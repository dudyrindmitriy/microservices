<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier' => ['required', 'string'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.sku' => ['required', 'string', 'max:64'],
            'lines.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $purchase = DB::transaction(function () use ($data) {
            $purchase = Purchase::create([
                'supplier' => $data['supplier'],
                'status' => 'NEW',
                'created_at' => now(),
            ]);

            foreach ($data['lines'] as $line) {
                $purchase->lines()->create([
                    'item_sku' => $line['sku'],
                    'quantity' => $line['quantity'],
                ]);
            }

            return $purchase;
        });

        return response()->json([
            'id' => 'purchase-' . $purchase->id,
            'status' => $purchase->status,
        ], 201);
    }

    public function show(int $id)
    {
        $purchase = Purchase::with('lines')->find($id);

        if (!$purchase) {
            return response()->json([
                'message' => 'Purchase not found',
            ], 404);
        }

        return response()->json($purchase);
    }
}
