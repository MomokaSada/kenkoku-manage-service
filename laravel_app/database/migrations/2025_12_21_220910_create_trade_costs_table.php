<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trade_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_id')->constrained('trades')->cascadeOnDelete();
            $table->foreignId('item_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_costs');
    }
};
