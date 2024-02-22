<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $request->validated();

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Hibás email vagy jelszó!'], 401);
        }

        $user = User::where('email', $request->email)->first();

        $data = [
            'user' => $user,
            'token' => $user->createToken('API token')->plainTextToken,
        ];

        if ($user) {
            return response()->json($data, 200);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        // Auth::user()->currentAccessToken()->delete();

        return response()->json(["message" => "Logged out"], 200);
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address
        ]);

        $data = [
            'user' => $user,
            'token' => $user->createToken('API token')->plainTextToken
        ];

        return response()->json($data, 201);
    }

    public function checkEmail($email)
    {
        $user = User::where('email', $email)->first();
        
        if ($user) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }
}
