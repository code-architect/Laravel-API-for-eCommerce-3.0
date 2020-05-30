<?php
namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerProductController extends ApiController
{
    /**
     * Get products details of each buyers, each transaction
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Buyer $buyer)
    {
        // The result of the transaction relationship is a collection, because a buyer have many transactions
        // so for this we are using Eager loading, to obtain the product directly within every transaction
        //For this we need to obtain the query builder from the relationship and not the relationship itself.
        // By doing this we are obtaining the list of transactions and with every transaction is going to come
        // with their respective products.
        $products = $buyer->transactions()->with('product')->get()->pluck('product');
        return $this->showAll($products);
    }
}
