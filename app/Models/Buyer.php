<?php

namespace App\Models;
use App\Models\Transaction;

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
