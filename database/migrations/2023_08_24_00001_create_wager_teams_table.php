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
        Schema::create('wager_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->comment('espn lookup, leagues overlap ids');
            $table->string('name');
            $table->string('abbreviation')->nullable();
            $table->string('division')->nullable();
            $table->string('conference')->nullable();
            $table->enum('league', ['nfl', 'mlb', 'nba', 'ncaaf', 'wrestling', 'mma', 'nhl'])->default('nfl');
            $table->unique(['team_id', 'name', 'league']);
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
        Schema::dropIfExists('wager_teams');
    }
};
