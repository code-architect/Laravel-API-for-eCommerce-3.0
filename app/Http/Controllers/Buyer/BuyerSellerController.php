<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerSellerController extends ApiController
{
    /**
     * Obtain all the unique sellers/seller for a specific buyer
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Buyer $buyer)
    {
        // using a nested relationship in the Eager loading, have to go to product then to sellers
        // and also we are getting unique seller details
        // also we are recreating the index so we don't get null for duplicate sellers which have been erased
        $sellers = $buyer->transactions()->with('product.seller')
            ->get()->pluck('product.seller')
            ->unique('id')->values();
        return $this->showAll($sellers);
    }
}
