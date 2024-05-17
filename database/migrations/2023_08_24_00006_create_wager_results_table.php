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
       Schema::create('wager_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game')->references('game_id')->on('wager_options')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('winner')->references('team_id')->on('wager_options')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('winner_name')->nullable();
            $table->integer('week')->nullable();
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->timestamps();
            $table->unique(['game', 'winner', 'winner_name', 'week']);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wager_results');
    }
};
