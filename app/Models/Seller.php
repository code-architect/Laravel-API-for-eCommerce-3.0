<?php

namespace App\Models;


class Seller extends User
{
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
