<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerCategoryController extends ApiController
{
    /**
     * Getting all the categories of the seller
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Seller $seller)
    {
        $category = $seller->products()->with('categories')
                           ->whereHas('categories')->get()  // there can be product without category, so we check here
                           ->pluck('categories')->collapse()
                           ->unique('id')->values();

        return  $this->showAll($category);
    }
}
