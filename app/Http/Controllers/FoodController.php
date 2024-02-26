<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::all();
        return response()->json($foods);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        $food = Food::with('category')->find($id);
        if ($food == null) {
            return response()->json(['message' => 'Nem található ilyen étel!'], 404);
        }
        return response()->json($food);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        
        if (Gate::allows('delete', $food)) {
            $food->delete();
            return response()->json('', 204);
        }

        return response()->json(['message' => 'Nincs jogosultsága a törléshez'], 403);
    }

    public function foodsByCategories(){
        try {
            $result = Food::select('categories.id as CategoryId', 'categories.name as Category', DB::raw('COUNT(*) as foodCount'))
            ->join('categories', 'categories.id', '=', 'Food.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

            return $result;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }
}
