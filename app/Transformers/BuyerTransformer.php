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
            'creationDate'  =>  (string)$buyer->created_at,
            'lastChange'    =>  (string)$buyer->updated_at,
            'deleteDate'    =>  isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null,
            'links'         => [
                [
                    'rel'   => 'self',
                    'href'  => route('buyers.show', $buyer->id),
                ],
                [
                    'rel'   => 'buyer.categories',
                    'href'  => route('buyers.categories.index', $buyer->id),
                ],
                [
                    'rel'   => 'buyer.products',
                    'href'  => route('buyers.products.index', $buyer->id),
                ],
                [
                    'rel'   => 'buyer.sellers',
                    'href'  => route('buyers.sellers.index', $buyer->id),
                ],
                [
                    'rel'   => 'buyer.transactions',
                    'href'  => route('buyers.transactions.index', $buyer->id),
                ],
                [
                    'rel'   => 'user',
                    'href'  => route('users.show', $buyer->id),
                ],
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'identifier'    =>  'id',
            'name'          =>  'name',
            'email'         =>  'email',
            'isVerified'    =>  'verified',
            'creationDate'  =>  'created_at',
            'lastChange'    =>  'updated_at',
            'deleteDate'    =>  'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
