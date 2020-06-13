<?php

namespace App\Transformers;

use App\Models\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Buyer $buyer
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identifier'    =>  (int)$buyer->id,
            'name'          =>  (string)$buyer->name,
            'email'         =>  (string)$buyer->email,
            'isVerified'    =>  (int)$buyer->verified,
            'creationDate'  =>  $buyer->created_at,
            'lastChange'    =>  $buyer->updated_at,
            'deleteDate'    =>  isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null,
        ];
    }
}
