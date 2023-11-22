<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function createToken(Request $request)
    {
        $rules = [
            'email' => 'email|required',
            'password' => 'required',
        ];

        $data = Validator::make($request->all(), $rules);

        if($data->fails()) {
            return response(['message' => __('frontend-portal/login.Login failed'), 'error' => $data->errors()], 500);
        }

        $data = $data->validated();

        $user = User::where('email', $data['email'])->first();

        if(!Hash::check($data['password'], $user->password)) {
            return response()->json(['content' => 'Invalid email & password'], 500);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // Return token along with other response data
        $result = [
            'token' => $token,
            'user' => $user, // You can customize the response data here
        ];

        return response()->json(['content' => $result], 200);
    }
}
