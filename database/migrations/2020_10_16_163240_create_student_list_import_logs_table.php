<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentListImportLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_list_import_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_registration_id');
            $table->string('file_name')->nullable();
            $table->enum('status', ['new', 'processing', 'finished'])->default('new');
            $table->json('statistics')->nullable();
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
        Schema::dropIfExists('student_list_import_logs');
    }
}
