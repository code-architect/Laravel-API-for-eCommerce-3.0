<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Show all transaction
     * @return JsonResponse
     */
    public function index()
    {
        $transaction = Transaction::all();
        return $this->showAll($transaction);
    }


    /**
     * Show a specifies transaction
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }
}
