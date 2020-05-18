<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $buyers = Seller::has('products')->get();
        return $this->showAll($buyers);
    }


    /**
     * Display the specified resource.
     *
     * @param Seller $seller
     * @return Response
     */
    public function show(Seller $seller)
    {
        //$seller = Seller::has('products')->findOrFail($id);
        return $this->showOne($seller);
    }
}
