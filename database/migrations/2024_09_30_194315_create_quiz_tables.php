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

        Schema::create('quizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete(); 
            $table->timestamps();
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->references('id')->on('quizes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('question');
            $table->unique(['quiz_id', 'question']);
        });

        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->references('id')->on('quiz_questions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('option');
            $table->boolean('answer')->default(false);
            $table->unique(['question_id', 'option']);
        });

        Schema::create('quiz_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('quiz_id')->references('id')->on('quizes')->cascadeOnDelete();
            $table->float('percentage', 8, 2)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_options');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizes');
        Schema::dropIfExists('quiz_scores_tables');
    }
};
