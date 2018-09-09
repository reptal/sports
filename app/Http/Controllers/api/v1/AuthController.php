<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;

class AuthController extends Controller
{

    /**
     * @param \App\Http\Requests\LoginUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(LoginUserRequest $request)
    {
        //check auth
        if (\Auth::attempt([
          'email'    => $request->validated()['email'],
          'password' => $request->validated()['password'],
        ])
        ) {
            //its correct data

            //generate token
            $token = sha1(str_random(16));
            $user = \Auth::user();
            //update user and return token
            $user->api_token = $token;
            $user->update();
            $data = [
              'error'   => false,
              'message' => __('translate.user logged in'),
              'data'    => [
                'token' => $token,
              ],
            ];
            return response()->json($data, 200);
        }
        //incorrect data
        $data = [
          'error'   => true,
          'message' => __('auth.failed'),
        ];
        return response()->json($data, 401);
    }
}
