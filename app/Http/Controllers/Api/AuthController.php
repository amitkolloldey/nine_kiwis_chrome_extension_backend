<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Generate token for the authenticated user
            $token = $user->createToken('YourAppName')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }


        return response()->json(['message' => 'Unauthorized'], 401);
    }


    public function logout(Request $request)
    {  

        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
