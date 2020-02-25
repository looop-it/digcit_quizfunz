<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeachingSubjectToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('teaching_subject')->after('contact');
            $table->string('teaching_subject2')->nullable()->after('contact2');
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
            $table->dropColumn(['teaching_subject', 'teaching_subject2']);
        });
    }
}
