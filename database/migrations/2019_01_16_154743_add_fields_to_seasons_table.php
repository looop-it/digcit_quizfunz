<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->tinyInteger('difficulty')->default(60)->comment('試卷難度')->after('time_interval');
            $table->tinyInteger('difficulty_offset')->default(10)->comment('試卷難度偏差')->after('difficulty');
            $table->tinyInteger('general_questions')->default(17)->comment('通用類題數')->after('difficulty_offset');
            $table->tinyInteger('other_questions')->default(3)->comment('其他類題數')->after('general_questions');
            $table->smallInteger('question_score')->default(5)->comment('每題分數')->after('other_questions');
            $table->smallInteger('paper_time_limit')->default(1500)->comment('試卷限時(秒)')->after('question_score');
            $table->smallInteger('question_time_limit')->default(30)->comment('每題限時(秒)')->after('paper_time_limit');
            $table->json('enable_days')->nullable()->comment('開放時間')->after('question_time_limit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropColumn([
                'difficulty',
                'difficulty_offset',
                'general_questions',
                'other_questions',
                'question_score',
                'paper_time_limit',
                'question_time_limit',
                'enable_days'
            ]);
        });
    }
}
