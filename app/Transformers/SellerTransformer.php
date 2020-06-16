<?php

namespace App\Transformers;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Seller $seller
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'identifier'    =>  (int)$seller->id,
            'name'          =>  (string)$seller->name,
            'email'         =>  (string)$seller->email,
            'isVerified'    =>  (int)$seller->verified,
            'creationDate'  =>  (string)$seller->created_at,
            'lastChange'    =>  (string)$seller->updated_at,
            'deleteDate'    =>  isset($seller->deleted_at) ? (string)$seller->deleted_at : null,
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
