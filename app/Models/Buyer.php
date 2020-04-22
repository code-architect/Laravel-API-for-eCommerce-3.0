<?php

namespace App\Models;

class Buyer extends User
{
    //----------------------------------- Internal Helper Methods ------------------------------------------------//
    /**
     * Relation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    //------------------------------------------------------------------------------------------------------------//
}
