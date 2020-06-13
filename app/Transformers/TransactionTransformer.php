<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Transaction $transaction
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier'    =>  (int)$transaction->id,
            'quantity'      =>  (int)$transaction->quantity,
            'buyer'         =>  (int)$transaction->buyer_id,
            'product'       =>  (int)$transaction->product_id,
            'creationDate'  =>  $transaction->created_at,
            'lastChange'    =>  $transaction->updated_at,
            'deleteDate'    =>  isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null,
        ];
    }
}
