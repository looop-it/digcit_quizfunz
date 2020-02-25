<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGlobalTableFiled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('global', function (Blueprint $table) {
            $table->unsignedTinyInteger('pop_up_status')->nullable()->default(0)->comment('pop up status');
            $table->text('pop_up_content')->nullable()->after('total_number');
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
            $table->dropColumn(['pop_up_status', 'pop_up_content']);
        });
    }
}
