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
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('npc_id')->constrained()->cascadeOnDelete();
            $table->string('content');
            $table->boolean('is_money_required')->default(false);
            $table->unsignedBigInteger('required_money')->default(0)->nullable();
            $table->boolean('is_money_reward')->default(false);
            $table->unsignedBigInteger('reward_money')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
