<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {

            $user = Auth::user();
            $success['token'] = $user->createToken('User Token')->accessToken;
            $success['data'] = $user;

            return $this->successResponse($success);
        } else {
            return $this->failureResponse(['error' => 'Unauthorization or user is not found.']);
        }

    }

    public function register(Request $request)
    {
        $user = new User;
        $user->name = $request->get('login');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->save();
        $token = $user->createToken('Access Token')->accessToken;
        $data = [
            'user' => $user,
            'access_token' => $token,
        ];

        return $this->successResponse($data);
    }


}
