<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    protected $fillable = [
        'name', 'description', 'quantity', 'status', 'image', 'seller_id'
    ];

    //----------------------------------- Internal Helper Methods ------------------------------------------------//
    public function isAvailable()
    {
        return $this->status = Product::AVAILABLE_PRODUCT;
    }
    //------------------------------------------------------------------------------------------------------------//
}
