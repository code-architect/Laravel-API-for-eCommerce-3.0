<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTransactionController extends ApiController
{
    /**
     * Getting all the transactions of the products of a category
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        // Some products may not have any transactions, i.e. they haven't been sold yet, so we need to get only
        // those which has a transaction, se we are using whereHas('transactions')
        // And a specific product has several transactions, we need to collapse them into one so we use collapse() keyword.
        $transactions = $category->products()->whereHas('transactions')
            ->with('transactions')->get()
            ->pluck('transactions')->collapse();

        return $this->showAll($transactions);
    }
}
