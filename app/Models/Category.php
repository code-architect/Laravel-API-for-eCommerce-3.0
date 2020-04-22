<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    //----------------------------------- Internal Helper Methods ------------------------------------------------//

    /**
     * Relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class); // only works on may to many
    }
    //------------------------------------------------------------------------------------------------------------//
}
