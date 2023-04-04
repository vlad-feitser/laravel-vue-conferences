<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit(User $user, EditUserRequest $request)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'country' => $request->country,
            'birthdate' => $request->birthdate,
            'phone' => $request->phone
        ]);

        if ($request->has('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return new UserResource($user);
    }
}
