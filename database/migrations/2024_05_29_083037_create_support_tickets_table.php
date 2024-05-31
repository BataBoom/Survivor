<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. nope dis sucks, implement direct from satoshi
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('subject');
            $table->boolean('answered')->default(false);
            $table->boolean('resolved')->default(false);
            $table->foreignUuid('payment_id')->nullable()->constrained('payments')->onDelete('cascade');
            $table->timestamps();

        });


        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->text('message');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('ticket_replies');
    }
};
