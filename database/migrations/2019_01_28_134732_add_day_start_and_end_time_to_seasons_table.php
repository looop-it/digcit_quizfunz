<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDayStartAndEndTimeToSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->time('day_start_time')->nullable()->after('enable_days');
            $table->time('day_end_time')->nullable()->after('day_start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropColumn(['day_start_time', 'day_end_time']);
        });
    }
}
