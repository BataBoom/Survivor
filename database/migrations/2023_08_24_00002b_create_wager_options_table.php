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
        Schema::create('wager_options', function (Blueprint $table) {
        $table->id();
        $table->foreignId('game_id')->references('game_id')->on('wager_questions')->cascadeOnDelete();
        $table->foreignId('team_id')->references('team_id')->on('wager_teams')->cascadeOnDelete();
        $table->string('option');
        $table->boolean('status')->default(true);
        $table->boolean('home_team')->default(false);
        $table->string('week')->nullable();
        $table->unique(['team_id', 'game_id', 'option']);
        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wager_options');
    }
};
