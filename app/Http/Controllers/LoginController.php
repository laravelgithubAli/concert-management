<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function store(LoginRequest $request)
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('email',$request->get('email'))->first();

        $permissions = $user->role->permissions()->pluck('title')->toArray();


        if (! Hash::check($request->get('password'),$user->password)){
            return response()->json([
               'data' => [
                   'message' => 'wrong password'
               ]
            ])->setStatusCode(400);
        }

        $user->tokens()->delete();


        return response()->json([
            'data' => [
                'token' => $user->createToken('access_token',$permissions)->plainTextToken
            ]
        ])->setStatusCode(200);

    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
           'data' => [
               'message' => 'you are logged out'
           ]
        ])->setStatusCode(200);
    }
}
