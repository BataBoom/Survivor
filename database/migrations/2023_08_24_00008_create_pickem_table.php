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
            $table->foreignUuid('ticket_id')->references('id')->on('survivor_registrations')->cascadeOnDelete();
            $table->integer('week');
            $table->string('selection')->nullable();
            $table->boolean('result')->nullable();
            $table->timestamps();
            $table->unique(['selection_id', 'user_id', 'week', 'ticket_id', 'game_id']);
            
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
