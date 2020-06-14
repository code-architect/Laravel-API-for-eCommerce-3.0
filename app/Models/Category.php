<?php

namespace App\Models;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ['pivot'];  // removing pivot data part from the received json response

    public $transformer = CategoryTransformer::class;

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
