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
        Schema::create('survivor_registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->references('id')->on('users')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('restrict');
            $table->foreignUuid('pool_id')->references('id')->on('survivor_pools')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->boolean('alive')->default(true);
            $table->integer('lives_count')->default(1);
            $table->timestamps();
            $table->unique(['pool_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survivor_registrations');
    }
};
