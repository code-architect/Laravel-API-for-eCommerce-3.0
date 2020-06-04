<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductBuyerController extends ApiController
{
    /**
     * Getting all the unique buyers for a product
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Product $product)
    {
        $buyers = $product->transactions()->with('buyer')->get()
            ->pluck('buyer')->unique('id')->values();
        return $this->showAll($buyers);
    }
}
