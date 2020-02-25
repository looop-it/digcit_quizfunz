<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSchoolNameDataTypeInParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->string('school_name', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->unsignedInteger('school_name')->nullable()->change();
        });
    }
}
