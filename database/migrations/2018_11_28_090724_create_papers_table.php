<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('participant_id')->nullable()->comment('參加者ID');
            $table->unsignedInteger('season_id')->comment('賽季ID');
            $table->string('number', 100)->unique()->comment('試題參考編號');
            $table->unsignedInteger('difficulty')->default(0)->comment('答題卷難度');
            $table->enum('status', ['creating', 'created', 'assigned', 'processing', 'finished', 'cancelled', 'voided'])->default('creating')->comment('答題卷狀態');
            $table->smallInteger('score')->default(0)->comment('得分');
            $table->timestamp('started_at')->nullable()->comment('開始時間');
            $table->timestamp('finished_at')->nullable()->comment('開始時間');
            $table->smallInteger('seconds_used')->default(0)->comment('完成所需秒數');
            $table->unsignedTinyInteger('questions_answered')->default(0)->comment('完成的題目數量');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('participant_id')->references('id')->on('participants');
            $table->foreign('season_id')->references('id')->on('seasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->dropForeign(['participant_id']);
            $table->dropForeign(['season_id']);
        });

        Schema::dropIfExists('papers');
    }
}
