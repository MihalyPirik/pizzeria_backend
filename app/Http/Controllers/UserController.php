<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // if (!Auth::check()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Hitelesítés sikertelen'
        //     ], 401);
        // }

        dd(Auth::user());
        return response()->json(Auth::user(), 200);

        // return response()->json([
        //     'success' => true,
        //     'user' => $user
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
