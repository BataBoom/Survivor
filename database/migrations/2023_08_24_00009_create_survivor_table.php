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
        Schema::create('survivor', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('game_id')->references('game_id')->on('wager_questions')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->string('selection')->nullable();
            $table->foreignId('selection_id')->references('team_id')->on('wager_options')->cascadeOnDelete();
            $table->foreignUuid('ticket_id')->references('id')->on('survivor_registrations')->cascadeOnDelete();
            $table->integer('week')->nullable();
            $table->boolean('result')->nullable();
            $table->timestamps();
            $table->unique(['selection_id', 'selection', 'user_id', 'ticket_id', 'week']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survivor');
    }
};
