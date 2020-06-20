<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerBuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Getting all the buyers of a single seller
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Seller $seller)
    {
        // this relation is same as category buyer
        $buyers = $seller->products()->whereHas('transactions')
                    ->with('transactions.buyer')->get()
                    ->pluck('transactions')->collapse()      // we are going to obtain several collections into one, so we need to make a single collection
                    ->pluck('buyer')->unique('id')
                    ->values();
        return $this->showAll($buyers);
    }
}
