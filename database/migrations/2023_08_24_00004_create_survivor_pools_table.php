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
        Schema::create('survivor_pools', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('lives_per_person')->default(0);
            $table->enum('type', ['survivor', 'pickem', 'testing']);
            $table->double('entry_cost', 8, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->double('prize', 8, 2)->nullable();
            $table->enum('prize_type', ['crypto', 'credits', 'promotion'])->default('crypto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survivor_pools');
    }
};
