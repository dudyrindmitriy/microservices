<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'requester' => ['required', 'string'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.sku' => ['required', 'string', 'max:64'],
            'lines.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = DB::transaction(function () use ($data) {
            $order = Order::create([
                'requester' => $data['requester'],
                'status' => 'NEW',
                'created_at' => now(),
            ]);

            foreach ($data['lines'] as $line) {
                $order->lines()->create([
                    'item_sku' => $line['sku'],
                    'quantity' => $line['quantity'],
                ]);
            }

            return $order;
        });

        return response()->json([
            'id' => 'order-' . $order->id,
            'status' => $order->status,
        ], 201);
    }

    public function show(int $id)
    {
        $order = Order::with('lines')->find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json($order);
    }
}
