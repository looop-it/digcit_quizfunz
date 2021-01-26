<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_id');
            $table->unsignedInteger('season_id');
            $table->unsignedMediumInteger('students')->default(0);
            $table->unsignedMediumInteger('participants')->default(0);
            $table->unsignedMediumInteger('scores')->default(0);
            $table->unsignedMediumInteger('seconds')->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('school_statistics');
    }
}
