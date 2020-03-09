<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyBasicScoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('weekly_basic_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('participant_id')->comment('參賽選手編號');
            $table->unsignedSmallInteger('week_of_year')->comment('星期數');
            $table->unsignedSmallInteger('season_id')->comment('賽季編號');
            $table->unsignedInteger('paper_id')->comment('本周最佳答题卷编号');
            $table->unsignedSmallInteger('score')->comment('本周最佳成績');
            $table->unsignedSmallInteger('seconds_used')->comment('最佳成績的用時');
            $table->timestamp('started_at')->nullable()->comment('该份答題開始時間');
            $table->timestamps();
            $table->index('participant_id');
            $table->index('season_id');
            $table->index('week_of_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('weekly_basic_scores');
    }
}
