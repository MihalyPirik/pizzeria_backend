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

        $decodedOrders = $orders->map(function ($order) {
            $order->order = json_decode($order->order);
            return $order;
        });

        return response()->json($decodedOrders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'order' => json_encode($request->order),
        ]);

        return response()->json([
            'id' => $order->id,
            'order' => json_decode($order->order),
            'created_at' => $order->created_at,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->order = json_decode($order->order);

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

        $order->update([
            'order' => json_encode($request->order)
        ]);

        $updatedOrder = Order::findOrFail($order->id);

        return response()->json([
            'id' => $updatedOrder->id,
            'order' => json_decode($updatedOrder->order),
            'created_at' => $updatedOrder->created_at,
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
