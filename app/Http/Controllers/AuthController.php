<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthRegisterRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $user = User::create([
            'name'=> $request->name,
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        Auth::attempt($request->only('email', 'password'));

        if (!Auth::check()) {
            throw ValidationException::withMessages([
                'email' => ['Falha ao fazer login.'],
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        $credendials = $request->only('email','password');

        if (!Auth::attempt($credendials)) {
            return response()->json('Unauthorized', 401);
        }

        $token = Auth::user()->createToken('token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
}
