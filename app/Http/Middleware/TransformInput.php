<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $transformer)
    {
        $transformedInput = [];
        // get only the data part from the request
        foreach ($request->request->all() as $input => $value)
        {
            $transformedInput[$transformer::originalAttribute($input)] = $value;
        }
        // replace the transformer value with original database field
        $request->replace($transformedInput);

        $response = $next($request);

        // we will only work on validation error responses, so check if there is a an exception has occurred and
        // if its a validation exception
        if(isset($response->exception) && $response->exception instanceof ValidationException)
        {
            $data = $response->getData();   // obtain directly the data of the response
            $transformedErrors = [];
            foreach ($data->error as $field => $error)
            {
                $transformedField = $transformer::transformedAttribute($field);
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }
            $data->error = $transformedErrors;
            $response->setData($data);
        }
        return $response; 
    }
}
