<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('paper_id')->comment('答題卷ID');
            $table->unsignedInteger('question_id')->comment('賽題ID');
            $table->text('options')->nullable()->comment('可選擇答案');
            $table->text('answer')->nullable()->comment('參加者答案');
            $table->boolean('correct')->default(false)->comment('是否正確');
            $table->unsignedTinyInteger('score')->default(0)->comment('分數');
            $table->timestamp('started_at')->nullable()->comment('答題開始時間');
            $table->timestamp('finished_at')->nullable()->comment('答題結束時間');
            $table->unsignedTinyInteger('seconds_used')->default(0)->comment('答題耗時（秒)');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('paper_id')->references('id')->on('papers');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paper_questions', function (Blueprint $table) {
            $table->dropForeign(['paper_id']);
            $table->dropForeign(['question_id']);
        });

        Schema::dropIfExists('paper_questions');
    }
}
