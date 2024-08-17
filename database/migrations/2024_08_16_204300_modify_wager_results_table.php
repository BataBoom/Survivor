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
        Schema::table('wager_results', function (Blueprint $table) {
            $table->dropForeign(['winner']);

             $table->foreign('winner')
              ->references('team_id')
              ->on('wager_teams')
              ->onUpdate('cascade')
              ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('wager_results', function (Blueprint $table) {
            $table->dropForeign(['winner']);
            
             $table->foreign('winner')
              ->references('team_id')
              ->on('wager_options')
              ->onUpdate('cascade')
              ->onDelete('cascade');

        });
    }
};
