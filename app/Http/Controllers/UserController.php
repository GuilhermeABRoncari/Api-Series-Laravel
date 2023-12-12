<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;
use App\Services\UserService;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserRegisterRequest;

class UserController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRegisterRequest $request)
    {
        $userDto = $request->getUserDto();
        return response()->json(['token' => $this->userService->create($userDto)], HttpStatusCode::CREATED);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');
        return response()->json(['token' => $this->userService->authenticate($credentials)], HttpStatusCode::OK);
    }

    public function index()
    {
        return User::all();
    }

    public function destroy(UserDeleteRequest $request, int $userId)
    {
        $credentials = $request->validated();
        return response()->json($this->userService->deleteAccount($credentials, $userId), HttpStatusCode::NO_CONTENT);
    }
}
