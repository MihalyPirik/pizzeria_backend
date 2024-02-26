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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken('API token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response()->json(['message' => 'Hibás email vagy jelszó!'], 401);
    }


    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json(["message" => "Sikeres kijelentkezés"], 200);
    }

    public function register(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address
        ]);

        $token = $user->createToken('API token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
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
