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
        Schema::create('purchase_lines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_id')
                ->references('id')
                ->on('purchases')
                ->onDelete('cascade');
            $table->string('item_sku', 64);
            $table->integer('quantity');
        });

         DB::statement(
            'ALTER TABLE purchase_lines ADD CONSTRAINT purchase_lines_quantity_check CHECK (quantity >= 0)'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_lines');
    }
};
