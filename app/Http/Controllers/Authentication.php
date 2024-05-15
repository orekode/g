<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Authentication extends Controller
{
    public function signup(SignupRequest $request)
    {
        $user = User::create([
            // 'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'password' => Hash::make($request->password),
        ]);

        $user->token = $user->createToken('auth', ['*'], now()->addWeek())->plainTextToken;

        return new UserResource($user);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            throw new AuthenticationException(' Invalid Credentials ');
        }

        $user = Auth::user();

        $user->token = $user->createToken('auth', ['*'], now()->addWeek())->plainTextToken;

        return new UserResource($user);
    }
}
