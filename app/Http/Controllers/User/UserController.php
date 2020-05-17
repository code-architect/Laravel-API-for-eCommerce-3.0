<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = User::all();
        return $this->showAll($user);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'      =>  'required',
            'email'     =>  'required|email|unique:users',
            'password'  =>  'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);
        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //$user = User::findOrFail($id);
        return $this->showOne($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'email'     =>  'email|unique:users,email'.$user->id,
            'password'  =>  'min:6|confirmed',
            'admin'     =>  'in:'.User::ADMIN_USER.','.User::REGULAR_USER
        ];
        $this->validate($request, $rules);

        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('email') && $user->email != $request->email){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if($request->has('password')){
            $user->password = bcrypt($request->name);
        }

        if($request->has('admin')){
            if(!$user->isVerified()){
                return $this->errorResponse('Only verified users can modify the admin field', 409);
            }
            $user->admin = $request->admin;
        }

        if(!$user->isDirty())
        {
            return $this->errorResponse('Need to specify a different value', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }
}
