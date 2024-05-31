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
        Schema::create('payments', function (Blueprint $table) {
            $table->Uuid('id');
            $table->foreignId('user_id')->references('id')->on('users')->constrained();
            $table->enum('payment_type', ['crypto', 'other'])->default('crypto');
            $table->foreignUuid('pool_id')->references('id')->on('survivor_pools')->constrained();
            $table->nullableUuidMorphs('ticket');
            $table->boolean('paid')->default(true);
            $table->string('payment_id')->nullable()->comment('3rd party ref');
            $table->timestamps();
            $table->double('amount_usd', 16, 2)->default(0);
            $table->double('amount_crypto', 16, 8)->default(0);
            $table->string('crypto_method')->nullable();

            $table->unique(['id', 'user_id', 'payment_id', 'ticket_id']);

  	    $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['user_id',]);
            $table->dropForeign(['pool_id',]);
            $table->dropForeign(['ticket_id']);
        });
        Schema::dropIfExists('payments');
    }
};
