<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'quantity', 'buyer_id', 'product_id'
    ];

    //----------------------------------- Internal Helper Methods ------------------------------------------------//

    /**
     * Relation
     * @return BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    /**
     * Relation
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //------------------------------------------------------------------------------------------------------------//
}
