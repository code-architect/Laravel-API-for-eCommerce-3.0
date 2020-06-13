<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier'    =>  (int)$product->id,
            'title'         =>  (string)$product->name,
            'details'       =>  (int)$product->description,
            'stock'         =>  (int)$product->quantity,
            'situation'     =>  (int)$product->status,
            'picture'       =>  url("img/{$product->image}"),
            'seller'        =>  (int)$product->seller_id,
            'creationDate'  =>  $product->created_at,
            'lastChange'    =>  $product->updated_at,
            'deleteDate'    =>  isset($product->deleted_at) ? (string)$product->deleted_at : null,
        ];
    }
}
