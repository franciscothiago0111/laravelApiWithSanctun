<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('primeiroToken', ['read'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => "invalid credentials",
            ], 401);
        }

        $token = $user->createToken('firstTokenRead', ['read'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }   

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Successful logout and token deletion.'
        ];
    }

    public function createTokenReadAndWrite(Request $request)
    {           
        $user = $request->user();  
        
        $token = $user->createTokenWithExpirationTime('readAndWrite', ['read', 'write']);
         
        $response = [
            'token' =>  $token->plainTextToken,
            'expired_at' => $token->accessToken->expired_at
        ];

        return response($response, 201);
    }
}


