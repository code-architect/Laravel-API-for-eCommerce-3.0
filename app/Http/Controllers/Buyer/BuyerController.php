<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        return $this->showAll($buyers);
        // TODO: vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php changed
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $buyers = Buyer::has('transactions')->findOrFail($id);
        return $this->showOne($buyers);
    }
}
