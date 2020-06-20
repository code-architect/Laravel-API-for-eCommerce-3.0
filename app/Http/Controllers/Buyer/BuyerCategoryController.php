<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerCategoryController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Getting unique categories/category for individual Buyer
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()->with('product.categories')
            ->get()->pluck('product.categories')->unique('id')->values();
        return $this->showAll($categories);
    }

}
