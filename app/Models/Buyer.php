<?php

namespace App\Models;
use App\Models\Transaction;
use App\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends User
{
    public $transformer = BuyerTransformer::class;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }

    //----------------------------------- Internal Helper Methods ------------------------------------------------//
    /**
     * Relation
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    //------------------------------------------------------------------------------------------------------------//
}
