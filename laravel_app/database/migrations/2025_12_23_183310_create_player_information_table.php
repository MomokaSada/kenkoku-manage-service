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
        Schema::create('player_information', function (Blueprint $table) {
            $table->id();
            $table->uuid('player_uuid')->unique();
            $table->string('player_name')->nullable();
            $table->unsignedBigInteger('money')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_information');
    }
};
