<?php

namespace App\Models;


use App\Scopes\SellerScope;

class Seller extends User
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope);
    }
    //----------------------------------- Internal Helper Methods ------------------------------------------------//

    /**
     * Relation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    //------------------------------------------------------------------------------------------------------------//
}
