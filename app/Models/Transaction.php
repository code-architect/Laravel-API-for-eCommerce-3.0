<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'quantity', 'buyer_id', 'product_id'
    ];

    //----------------------------------- Internal Helper Methods ------------------------------------------------//

    /**
     * Relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    /**
     * Relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //------------------------------------------------------------------------------------------------------------//
}
