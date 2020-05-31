<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ['pivot'];  // removing pivot data part from the received json response

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

    /**
     * Relation
     * @return BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Relation
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relation
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    //------------------------------------------------------------------------------------------------------------//
}
