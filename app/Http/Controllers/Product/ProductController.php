<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\JsonResponse;


class ProductController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
    }
    /**
     *  Show all Products
     * @return JsonResponse
     */
    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }


    /**
     * Show a Specified Product
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }
}
