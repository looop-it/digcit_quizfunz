<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasicScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('participant_id')->comment('參賽選手編號');
            $table->unsignedSmallInteger('season_id')->comment('賽季編號');
            $table->unsignedInteger('paper_id')->comment('本賽季最佳答题卷编号');
            $table->unsignedSmallInteger('score')->comment('本賽季最佳成績');
            $table->unsignedSmallInteger('seconds_used')->comment('最佳成績的用時');
            $table->timestamps();
            $table->index('participant_id');
            $table->index('season_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basic_scores');
    }
}
