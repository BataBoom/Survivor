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
        Schema::table('survivor_pools', function (Blueprint $table) {
            $table->boolean('public')->default(true);
            $table->boolean('hidden')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survivor_pools', function (Blueprint $table) {
            $table->dropColumn('public');
            $table->dropColumn('hidden');
        });
    }
};
