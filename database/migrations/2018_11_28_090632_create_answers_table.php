<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id')->comment('賽題ID');
            $table->string('content')->comment('答案內容');
            $table->boolean('correct')->default(false)->comment('是否正確答案');
            $table->unsignedInteger('hit')->default(0)->comment('答題命中率');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
        });

        Schema::dropIfExists('answers');
    }
}
