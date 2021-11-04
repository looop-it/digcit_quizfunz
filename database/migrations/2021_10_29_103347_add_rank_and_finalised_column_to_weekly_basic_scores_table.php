<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRankAndFinalisedColumnToWeeklyBasicScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weekly_basic_scores', function (Blueprint $table) {
            $table->unsignedInteger('year')->default(2021)->after('participant_id');
            $table->unsignedTinyInteger('rank')->default(0)->after('started_at');
            $table->unsignedTinyInteger('rank_raw')->default(0)->after('rank');
            $table->boolean('finalised')->after('rank_raw')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weekly_basic_scores', function (Blueprint $table) {
            $table->dropColumn(['year', 'rank', 'rank_raw', 'finalised']);
        });
    }
}
