<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquire', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->string('school_name')->comment('學校名稱');
            $table->string('capacity')->comment('身份');
            $table->string('tel')->comment('聯絡電話');
            $table->string('email')->comment('聯絡電郵');
            $table->string('enquiry')->comment('查詢內容');
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
        Schema::dropIfExists('inquire');
    }
}
