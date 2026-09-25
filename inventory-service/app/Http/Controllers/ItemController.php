<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => ['required', 'string', 'max:64'],
            'name' => ['required', 'string'],
            'unit' => ['required', 'string'],
            'warehouseCode' => ['required', 'string', 'max:32'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $item = DB::transaction(function () use ($data) {
            $item = Item::create([
                'sku' => $data['sku'],
                'name' => $data['name'],
                'unit' => $data['unit'],
            ]);

            $item->stockBalances()->create([
                'warehouse_code' => $data['warehouseCode'],
                'quantity' => $data['quantity'],
            ]);

            return $item;
        });

        return response()->json($item, 201);
    }

    public function show(string $sku)
    {
        $item = Item::with('stockBalances')
            ->where('sku', $sku)
            ->first();

        if (!$item) {
            return response()->json([
                'message' => 'Item not found',
            ], 404);
        }

        return response()->json($item);
    }
}
