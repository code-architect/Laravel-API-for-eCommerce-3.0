<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerTransactionController extends ApiController
{
    /**
     * get all transaction of a single buyer
     * @param Buyer $buyer
     * @return JsonResponse
     */
    public function index(Buyer $buyer)
    {
        $transactions = $buyer->transactions;
        return $this->showAll($transactions);
    }
}
