<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerTransactionController extends ApiController
{
    /**
     * Get all transactions for a specific seller
     * @param Seller $seller
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()->whereHas('transactions')
                        ->with('transactions')->get()
                        ->pluck('transactions')->collapse();
        return $this->showAll($transactions);
    }
}
