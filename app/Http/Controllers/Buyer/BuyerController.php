<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        return response()->json(['data' => $buyers], 200);
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
        return response()->json(['data' => $buyers], 200);
    }
}
