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
        Schema::create('bet_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->foreignId('bet_type')
            ->nullable()
            ->constrained('bet_types')
            ->onUpdate('cascade')
            ->onDelete('cascade');


            $table->foreignId('league_id')
            ->nullable()
            ->constrained('leagues')
            ->onUpdate('cascade')
            ->onDelete('cascade');


            $table->string('sport')->nullable();


            $table->foreignId('game_id')->nullable()->constrained('wager_questions')->references('game_id')->onDelete('cascade');

            $table->foreignId('selection_id')->nullable()->constrained('wager_teams')->onDelete('cascade');
            
            $table->string('unscheduled_event')->nullable();
            $table->string('unscheduled_option')->nullable();
            
            $table->mediumInteger('odds');
            $table->float('bet_amount', 8, 2);
            $table->dateTime('starts_at');

            $table->longText('notes')->nullable();
            $table->boolean('result')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bet_slips');
    }
};
