<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataLoginExceptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_login_exception', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('user_id')->default('')->comment('用戶');
            $table->string('ip')->default('')->comment('用戶ip');
            $table->string('addtime')->default('')->comment('添加地址');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_login_exception');
    }
}
