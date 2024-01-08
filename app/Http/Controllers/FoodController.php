<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$foods = Food::all();
        $foods = Food::with('category')->get();
        return response()->json($foods);
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
    public function show($id) {
        $food = Food::with('category')->find($id);
        //$food = Food::find($id);
        if ($food == null) {
            return response()->json(['message' => 'No food found'], 404);
        }
        return response()->json($food);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Food $food)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $food = Food::find($id);
        $food->delete();
        return response()->json(['message' => 'Succes'], 204);
    }
}
