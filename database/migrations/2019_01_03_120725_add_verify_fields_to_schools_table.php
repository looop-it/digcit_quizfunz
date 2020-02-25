<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerifyFieldsToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->boolean('verified')->comment('是否已驗證')->default(false)->after('code');
            $table->string('verification_token')->nullable()->comment('驗證碼')->after('verified');
            $table->string('verified_at')->nullable()->comment('驗證時間')->after('verification_token');
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
            $table->dropColumn(['verified', 'verification_token', 'verified_at']);
        });
    }
}
