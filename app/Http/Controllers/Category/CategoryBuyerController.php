<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryBuyerController extends ApiController
{
    /**
     * getting all the unique buyers/buyer of single category
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        $buyers = $category->products()->whereHas('transactions')
            ->with('transactions.buyer')->get()
            ->pluck('transactions')->collapse()      // we are going to obtain several collections into one, so we need to make a single collection
            ->pluck('buyer')->unique('id')
            ->values();

        return $this->showAll($buyers);
    }
}
