<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartedAtColumnToBasicScoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('basic_scores', function (Blueprint $table) {
            $table->timestamp('started_at')->nullable()->comment('该份答題開始時間')->after('seconds_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('basic_scores', function (Blueprint $table) {
            $table->dropColumn('started_at');
        });
    }
}
