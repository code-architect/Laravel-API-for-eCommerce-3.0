<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Transformers\TransactionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-product'.TransactionTransformer::class)->only(['store']);
    }


    /**
     * Buying a product form a verified seller
     * @param Request $request
     * @param Product $product
     * @param User $buyer
     * @return \Illuminate\Http\JsonResponse
     */
     public function store(Request $request, Product $product, User $buyer)
    {
        $rules= [
            'quantity'  =>  'required|integer|min:1'
        ];
        $this->validate($request, $rules);
        // Be sure that the seller is different then the buyer
        if($buyer->id == $product->seller_id)
        {
            return $this->errorResponse('The buyer must be different then the seller', 409);
        }

        // check if the buyer/user is verified or not?
        if(!$buyer->isVerified())
        {
            return $this->errorResponse('The buyer must be a verified user', 409);
        }

        // check if the seller is verified or not? We don't have a seller relationship directly
        // so we need to obtain it from product
         if(!$product->seller->isVerified())
         {
             return $this->errorResponse('The seller must be a verified user', 409);
         }

         // check if the product is available
        if(!$product->isAvailable())
        {
            return $this->errorResponse('This product is not available', 409);
        }

        // check if the transaction quantity is not grater than the existing product quantity
        if($product->quantity < $request->quantity)
        {
            return $this->errorResponse('This product does not have enough units for this transaction', 409);
        }

        // We need to be sure that different users are ordering the same product at the same time. In this case use Database transaction
        return DB::transaction(function () use ($request, $product, $buyer){
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity'      => $request->quantity,
                'buyer_id'      => $buyer->id,
                'product_id'    => $product->id
            ]);
            return $this->showOne($transaction);
        });
    }
}
