<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier'    =>  (int)$user->id,
            'name'          =>  (string)$user->name,
            'email'         =>  (string)$user->email,
            'isVerified'    =>  (int)$user->verified,
            'isAdmin'       =>  ($user->admin === 'true'),
            'creationDate'  =>  (string)$user->created_at,
            'lastChange'    =>  (string)$user->updated_at,
            'deleteDate'    =>  isset($user->deleted_at) ? (string) $user->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'identifier'    =>  'id',
            'name'          =>  'name',
            'email'         =>  'email',
            'isVerified'    =>  'verified',
            'isAdmin'       =>  'admin',
            'creationDate'  =>  'created_at',
            'lastChange'    =>  'updated_at',
            'deleteDate'    =>  'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
