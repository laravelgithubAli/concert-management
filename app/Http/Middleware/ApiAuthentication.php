<?php

namespace App\Http\Middleware;

use Closure;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthentication
{

    protected $except = [
        '/api/register'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (!in_array($request->getRequestUri(),$this->except)){
          $authorizationData = explode(' ',$request->header('authorization'));

//          dd(base64_decode($authorizationData[1]));

            $credentional = explode(':',base64_decode($authorizationData[1]));

            $user = User::query()->where('email',$credentional[0])->firstOrFail();

            if (!Hash::check($credentional[1],$user->password)){
//                auth()->login($user);
                abort(403);
            }

            auth()->login($user);
        }

        return $next($request);
    }
}
