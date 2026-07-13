<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    # User Registration 
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        # Create the user
        $user = User::create([
            'name' => $fields['name'], 
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        # Create the token 
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        # Return the response 
        return response($response, 201);
    }

     # User login
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        # Check the email
        $user = User::where('email', $fields['email'])->first();
        
        # Check the password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Wrong login credentials'
            ], 401);
        }

        # Create the token 
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        # Return the response 
        return response($response, 201);
    }

    # Logout the user
    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        # Return the response
        return response()->json([
            'message' => 'Logged out!'
        ], 200);
    }
}
