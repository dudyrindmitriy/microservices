<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_balances', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse_code', 32);
            $table->integer('quantity');
            $table->foreignId('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('restrict');
            $table->unique(['item_id', 'warehouse_code']);
        });

        DB::statement(
            'ALTER TABLE stock_balances ADD CONSTRAINT stock_balances_quantity_check CHECK (quantity >= 0)'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_balances');
    }
};
