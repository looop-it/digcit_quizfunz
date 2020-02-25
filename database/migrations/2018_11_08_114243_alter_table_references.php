<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('references', function (Blueprint $table) {
            $table->string('author', 125)->nullable()->comment('author');
            $table->integer('hits')->nullable()->default(0);
            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('references', function (Blueprint $table) {
            $table->dropColumn([
                'author',
                'hits',
                'content'
            ]);
        });
    }
}
