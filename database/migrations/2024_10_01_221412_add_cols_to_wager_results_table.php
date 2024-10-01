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
            $table->mediumInteger('home_score_1Q')->nullable();
            $table->mediumInteger('home_score_2Q')->nullable();
            $table->mediumInteger('home_score_3Q')->nullable();
            $table->mediumInteger('home_score_4Q')->nullable();

            $table->mediumInteger('away_score_1Q')->nullable();
            $table->mediumInteger('away_score_2Q')->nullable();
            $table->mediumInteger('away_score_3Q')->nullable();
            $table->mediumInteger('away_score_4Q')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wager_results', function (Blueprint $table) {
            $table->dropColumn('away_score_1Q');
            $table->dropColumn('away_score_2Q');
            $table->dropColumn('away_score_3Q');
            $table->dropColumn('away_score_4Q');

            $table->dropColumn('home_score_1Q');
            $table->dropColumn('home_score_2Q');
            $table->dropColumn('home_score_3Q');
            $table->dropColumn('home_score_4Q');

        });
    }
};
