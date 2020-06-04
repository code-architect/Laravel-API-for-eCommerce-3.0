<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends ApiController
{
    /**
     * Getting all the categories associated with the product
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }


    /**
     * Adding a category to the product
     * @param Request $request
     * @param Product $product
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, Category $category)
    {
        // attach method do not check if the category exists with the product or not, so it duplicate it
        //$product->categories()->attach([$category->id]);
        // sync method adds the given category, but detaches the other ones. This is not fit for the scenario
        //$product->categories()->sync([$category->id]);
        // syncWithoutDetaching is the method fit for this scenario
        $product->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->categories);
    }


    /**
     * Removing a specified category from the product
     * @param Product $product
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product, Category$category)
    {
        // we are deleting the relation between the product and category. We are removing records from the pivot
        // table but not deleting any resources such as categories or model. Check that the category that is going
        // to be removed already exists in list of categories for the product
        if(!$product->categories()->find($category->id))
        {
            return $this->errorResponse('The specified category is not a category of this product', 404);
        }
        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }
}
