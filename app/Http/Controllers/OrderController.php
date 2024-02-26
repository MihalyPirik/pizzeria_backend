<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'user_id' => Auth::user()->id, // Győződj meg róla, hogy a felhasználó be van jelentkezve
            'order' => $request->order,
        ]);
    
        // Az új rendelés adatainak visszaadása a válaszban
        return response()->json([
            'id' => $order->id,
            'order' => $order->order,
            'created_at' => $order->created_at,
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return response()->json([
            'id' => $order->id,
            'order' => $order->order,
            'created_at' => $order->created_at,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        if ($request->user()->cannot('update', $order)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $order->update($request->only('order'));
        
        return response()->json([
            'id' => $order->id,
            'order' => $order->order,
            'created_at' => $order->created_at,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();

        return response()->noContent();
    }
}
