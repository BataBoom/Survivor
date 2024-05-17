<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->references('game_id')->on('wager_questions')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->cascadeOnDelete();
            $table->foreignId('selection_id')->references('team_id')->on('wager_options')->cascadeOnDelete();
            $table->integer('week');
            $table->string('selection');
            $table->boolean('result')->nullable();
            $table->timestamps();
            $table->unique(['selection_id', 'selection', 'user_id', 'week']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pickem');
    }
};
