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
        Schema::create('wager_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->index();
            $table->enum('league', ['nfl', 'mlb', 'nba', 'ncaaf', 'wrestling', 'mma', 'nhl']);
            $table->integer('week')->nullable();
            $table->string('question');
            $table->boolean('ended')->default(false);
            $table->boolean('status')->default(true);
            $table->dateTime('starts_at', $precision = 0);
            $table->unique(['question', 'game_id', 'week']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wagers_questions');
    }
};
