<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalExtraRanking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_extra_ranking', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('participant_id')->nullable()->comment('Participant ID');
            $table->unsignedInteger('added_year')->nullable()->comment('Year to added to ranking');
            $table->unsignedInteger('added_week')->nullable()->comment('Week to added to ranking');
            $table->unsignedInteger('season_id')->nullable()->comment('Season ID');
            $table->unsignedInteger('sum_scores')->nullable()->comment('SUM scores under season');
            $table->unsignedInteger('sum_seconds')->nullable()->comment('SUM seconds under season');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_extra_ranking');
    }
}
