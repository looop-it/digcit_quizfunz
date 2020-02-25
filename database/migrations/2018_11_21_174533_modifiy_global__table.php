<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifiyGlobalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('global', function (Blueprint $table) {
            $table->string('total_number')->default('')->comment('總參加人數');
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
            $table->dropColumn(['total_number']);
        });
    }
}
