<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRankingSeasonToGlobalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('global', function (Blueprint $table) {
            $table->unsignedInteger('ranking_season')->nullable()->after('rank_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('global', function (Blueprint $table) {
            $table->dropColumn('ranking_season');
        });
    }
}
