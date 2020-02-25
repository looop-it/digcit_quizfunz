<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSponsorRelatedFieldsToGlobalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('global', function (Blueprint $table) {
            $table->string('sponsor_image')->nullable()->after('app_info_url')->comment('desktop sponsor image');
            $table->string('sponsor_image_mobile')->nullable()->after('sponsor_image')->comment('mobile sponsor image');
            $table->string('sponsor_page_url')->nullable()->after('sponsor_image_mobile')->comment('sponsor page url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('global', function (Blueprint $table) {
            $table->dropColumn([
                'sponsor_image',
                'sponsor_image_mobile',
                'sponsor_page_url'
            ]);
        });
    }
}
