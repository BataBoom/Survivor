<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {

        Schema::table('wager_teams', function (Blueprint $table) {
            $table->unsignedBigInteger('league_id')->default(1);
        });
   
    }

    public function down()
    {

        Schema::table('wager_teams', function (Blueprint $table) {
            $table->dropColumn('league_id');
        });

    }

};
