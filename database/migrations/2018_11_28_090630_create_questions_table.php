<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->nullable()->comment('題目分類ID');
            $table->unsignedInteger('scope_id')->nullable()->comment('範籌分類ID');
            $table->unsignedInteger('user_id')->nullable()->comment('出題者ID');
            $table->string('name')->comment('題目');
            $table->text('description')->nullable()->comment('簡介');
            $table->unsignedTinyInteger('level')->default(1)->comment('難度');
            $table->unsignedInteger('hit')->default(0)->comment('出題命中數');
            $table->unsignedTinyInteger('correct_rate')->default(0)->comment('答題正確率');
            $table->text('reference')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('category_id')->references('id')->on('question_categories')->onDelete('set null');
            $table->foreign('scope_id')->references('id')->on('question_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('questions');
    }
}
