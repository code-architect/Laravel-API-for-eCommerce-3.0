<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }


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
     * @param Buyer $buyer
     * @return Response
     */
    public function show(Buyer $buyer)
    {
        //$buyers = Buyer::has('transactions')->findOrFail($id);
        return $this->showOne($buyer);
    }
}
