<?php

namespace App\Http\Controllers;

use App\Dtos\UserDto;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRegisterRequest;
use App\Services\UserService;

class AuthController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(AuthRegisterRequest $request)
    {
        $userDto = new UserDto($request->name, $request->email, $request->password);
        return response()->json(['token' => $this->userService->create($userDto)], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');
        return response()->json(['token' => $this->userService->authenticate($credentials)], 200);
    }
}
