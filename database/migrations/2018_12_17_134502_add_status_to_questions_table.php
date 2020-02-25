<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->tinyInteger('status')->after('reference')->comment('狀態：是否啟用')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
