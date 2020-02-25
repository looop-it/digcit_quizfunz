<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodeToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('code', 50)->nullable()->after('fax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['code']);
        });
    }
}
