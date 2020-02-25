<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGlobal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('global', function (Blueprint $table) {
                     $table->unsignedTinyInteger('rank_status')->nullable()->default(0)->comment('rank status');    
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
                'rank_status'      
            ]);
        });  
    }
}
      