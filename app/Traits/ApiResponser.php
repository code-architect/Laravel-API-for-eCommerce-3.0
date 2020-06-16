<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait  ApiResponser
{
    /**
     * Return a success response in JSOn format
     * @param $data
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }


    /**
     * Return error response in JSON format
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }


    /**
     * Return multiple records
     * @param Collection $collection
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;
        // reducing the quantity of data, making the sort a little faster
        $collection  =$this->filterData($collection, $transformer);
        $collection  =$this->sortData($collection, $transformer);
        $collection  =$this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        // catching the data
        $collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $code);
    }


    /**
     * Return a single record
     * @param Model $model
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showOne(Model $model, $code = 200)
    {
        $transformer = $model->transformer;
        $model = $this->transformData($model, $transformer);
        return $this->successResponse($model, $code);
    }


    /**
     * Show a message
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }


    protected function filterData(Collection $collection, $transformer)
    {
        foreach (request()->query() as $query => $value)
        {
            $attribute = $transformer::originalAttribute($query);
            if(isset($attribute, $value))
            {
                $collection = $collection->where($attribute, $value);
            }
        }
        return $collection;
    }


    /**
     * Sort data by the given parameter
     * @param Collection $collection
     * @param $transformer
     * @return Collection
     */
    protected function sortData(Collection $collection, $transformer)
    {
        if(request()->has('sort_by'))
        {
            $attribute = $transformer::originalAttribute(request()->sort_by);
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }


    /**
     * Pagination with page limit and with additionally passed arguments
     * @param Collection $collection
     * @return LengthAwarePaginator
     */
    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page'  => 'integer|min:2|max:50',
        ];
        // NOTE: Remember, we are not in a controller, and our trait might not be used by every controller,
        //       based on these conditions validate.
        Validator::validate(request()->all(),$rules);

        // get the current page
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        if(request()->has('per_page')){
            $perPage = (int)request()->per_page;
        }

        $results = $collection->slice(($page -1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        // NOTE: When we resolve the 'path' it will only take it to account.i.e. it will ignore other parameters
        //       if we send sort by parameter it will ignore it. To resolve this we need to tell to the paginator
        //       results to append/include other parameter results.
        $paginated->appends(request()->all());
        return $paginated;
    }


    /**
     * Transform the data using the respected Transformers and change the return type of the queried data
     * @param $data
     * @param $transformer
     * @return array
     */
    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }


    /**
     * The cache is going to change/recreate a new cache version of the request based on different query parameters
     * @param $data
     * @return mixed
     */
    protected function cacheResponse($data)
    {
        // make sure that we are caching unique stuff, so differentiate different request based on url
        $url = request()->url();
        $queryParams = request()->query();

        // sort the query parameters based on the key of the array
        // ksort acts by reference and not by value so we can move to next step
        ksort($queryParams);

        // build a new string based on these query parameters
        $queryString = http_build_query($queryParams);

        // now we build the full url
        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30/60, function () use($data){
            return $data;
        });
    }
}