<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $userRole = Role::query()->where('title','user')->first();

       $user = User::query()->create([
           'role_id' => $userRole->id,
           'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        return response()->json([
           'data' => new UserResource($user)
        ])->setStatusCode(200);
    }
}
