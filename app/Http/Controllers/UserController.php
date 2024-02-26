<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();
        return response()->json($users);
    }


    /**
     * Display the specified resource.
     */
    public function showUser()
    {
        $user = User::where('id', Auth::user()->id)->get();

        if (!$user) {
            return response()->json(['message' => 'Felhasználó nem található'], 404);
        }
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        if (!$user) {
            return response()->json(['message' => 'Felhasználó nem található'], 404);
        }

        $request->validated();

        $user->update($request->only(
            'name',
            'email',
            'password',
            'phoneNumber',
            'address'
        ));
        return response()->json($user, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if (!$user) {
            return response()->json(['message' => 'Felhasználó nem található'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'Sikeresen törölve!'], 200);
    }
}
