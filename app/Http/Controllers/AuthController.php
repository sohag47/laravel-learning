<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;
    public function login(Request $request)
    {
        $rules = [ 
            'email' => 'required|string|email',
            'password' => 'required',  
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->respondValidationError($validator->errors());
        }

        if (Auth::attempt($request->all())) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $expirationMinutes = config('sanctum.expiration', 60); // Default to 60 minutes
            $expirationTime = now()->addMinutes($expirationMinutes)->toDateTimeString();

            return $this->respondWithCreated([
                'token'=> $token,
                'token_type' => 'Bearer',
                'expires_at' => $expirationTime,
                'user'=> $user,
            ]);
        }else{
            return $this->respondUnauthorizedError('Invalid credentials');
        }
    }
    public function profile()
    {
        return $this->respondWithCreated([
            'user'=> Auth::user(),
        ]);
    }

    // Handle logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
