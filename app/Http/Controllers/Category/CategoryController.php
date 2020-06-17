<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.CategoryTransformer::class)->only(['store', 'update']);
    }


    /**
     * Return All categories
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories= Category::all();
        return $this->showAll($categories);
    }


    /**
     * Create a new single product
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = ['name' => 'required', 'description' => 'required'];
        $this->validate($request, $rules);

        $newCategory = Category::create($request->all());
        return $this->showOne($newCategory, 201);
    }


    /**
     * Get a specified category
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }


    /**
     * Update category name, description
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->intersect([
            'name', 'description'
        ]));

        // if nothing has changed return an exception
        if(!$category->isDirty()) {
            return $this->errorResponse('You need to specify different values to update', 422);
        }
        $category->save();  // if something changed save it, and then return the result
        return $this->showOne($category);
    }



    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
