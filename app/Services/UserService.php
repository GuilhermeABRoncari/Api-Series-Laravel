<?php

namespace App\Services;

use DateTimeZone;
use App\Models\User;
use App\Dtos\UserDto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Exceptions\DomainExceptions\AuthValidateException;

class UserService
{
    public function create(UserDto $userDto): string
    {
        $user = User::create([
            'name'=> $userDto->getName(),
            'email' => $userDto->getEmail(),
            'password' => Hash::make($userDto->getPassword()),
        ]);

        Auth::attempt(['email'=> $user->email,'password'=> $userDto->getPassword()]);

        if (!Auth::check()) {
            throw ValidationException::withMessages([
                'email' => ['Falha ao fazer login.'],
            ]);
        }

        return $this->generateToken($user);
    }

    public function authenticate(array $credentials): string
    {
        throw_if (!Auth::attempt($credentials), new AuthValidateException());

        $user = Auth::user();
        
        return $this->generateToken($user);
    }

    private function generateToken($user): string
    {
        $user->tokens()->delete();
        return $user->createToken('token')->plainTextToken;
    }
}