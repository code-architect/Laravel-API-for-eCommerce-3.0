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
}
