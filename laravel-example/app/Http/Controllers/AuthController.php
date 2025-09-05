<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;
    
    function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Credenciales inválidas', 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('api-token', ['posts.read', 'posts.write']);

        $token = $tokenResult->accessToken;

        return $this->success([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => [
                'email' => $user->email,
                'roles' => $user->roles()->pluck('name')
            ]
        ]);
    }

    function signup(Request $request){
        $data = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => data['name'],
            'email' => data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $defaultRole = Role::where('name', 'viewer')->first();
        if ($defaultRole) {
            $user->roles()->syncWithoutDetaching([$defaultRole->id]);
        }

        return $this->success($user->load('roles'), 'usuario creado correctamente', 201);
    }

    function me(Request $request){
        return $this->success("hello camper!");
    }

    function logout(Request $request){
        return $this->success("hello camper!");
    }
}
