<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('學校名稱');
            $table->string('address')->nullable()->comment('學校地址');
            $table->string('contact')->comment('聯絡人');
            $table->string('email', 100)->nullable()->comment('聯絡電郵');
            $table->string('phone', 50)->nullable()->comment('聯絡電話');
            $table->string('fax', 50)->nullable()->comment('傳真號碼');
            $table->boolean('approved')->default(false)->comment('是否已審核');
            $table->unsignedSmallInteger('student')->default(0)->comment('學生人數');
            $table->unsignedSmallInteger('expected_participant')->default(0)->comment('預期參加學生人數');
            $table->unsignedSmallInteger('actual_participant')->default(0)->comment('實際參加學生人數');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
