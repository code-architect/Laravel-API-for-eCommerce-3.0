<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier'    =>  (int)$category->id,
            'title'         =>  (string)$category->name,
            'details'       =>  (string)$category->description,
            'creationDate'  =>  (string)$category->created_at,
            'lastChange'    =>  (string)$category->updated_at,
            'deleteDate'    =>  isset($category->deleted_at) ? (string)$category->deleted_at : null,
        ];
    }


    public static function originalAttribute($index)
    {
        $attributes =  [
            'identifier'    =>  'id',
            'title'         =>  'name',
            'details'       =>  'description',
            'creationDate'  =>  'created_at',
            'lastChange'    =>  'updated_at',
            'deleteDate'    =>  'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
