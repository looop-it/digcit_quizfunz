<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('賽季名稱');
            $table->enum('status', ['ready', 'open', 'closed', 'cancelled'])->default('ready')->comment('賽季狀態');
            $table->timestamp('start_at')->nullable()->comment('比賽開始時間');
            $table->timestamp('end_at')->nullable()->comment('比賽結束時間');
            $table->boolean('is_intercollegiate')->default(false)->comment('是否校際賽');
            $table->unsignedTinyInteger('times_limit')->default(1)->comment('每個用戶可參加次數');
            $table->unsignedTinyInteger('time_interval')->default(1)->comment('次數之間的間隔（分鐘）');
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
        Schema::dropIfExists('seasons');
    }
}
