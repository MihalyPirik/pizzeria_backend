<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::all();
        //$foods = Food::with('category')->get();
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
        $food = Food::findOrFail($id);
        $food->delete();
        return response()->json(['message' => 'Succes'], 204);
    }

    public function foodsByCategories(){
        try {
            $result = Food::select('categories.name as Category', DB::raw('COUNT(*) as foodCount'))
            ->join('categories', 'categories.id', '=', 'Food.category_id')
            ->groupBy('categories.name')
            ->get();

            return $result;
        } catch (\Exception $e) {
            return null;
        }
    }
}
