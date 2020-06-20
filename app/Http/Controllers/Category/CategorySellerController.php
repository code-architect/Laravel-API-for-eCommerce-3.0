<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategorySellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Getting all the unique sellers of the products in the same category
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        $sellers = $category->products()->with('seller')
            ->get()->pluck('seller')->unique('id')->values();
        return $this->showAll($sellers);
    }
}
