<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraContactFieldsToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('contact2')->nullable()->comment('第二聯絡人姓名')->after('contact');
            $table->string('email2')->nullable()->comment('第二聯絡人電郵')->after('email');
            $table->string('phone2')->nullable()->comment('第二聯絡人電話')->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn([
                'contact2',
                'email2',
                'phone2'
            ]);
        });
    }
}
