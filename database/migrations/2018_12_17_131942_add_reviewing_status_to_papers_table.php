<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviewingStatusToPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE papers CHANGE COLUMN status status ENUM('creating', 'created', 'assigned', 'processing', 'reviewing', 'finished', 'cancelled', 'voided') NOT NULL DEFAULT 'creating'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE papers CHANGE COLUMN status status ENUM('creating', 'created', 'assigned', 'processing', 'finished', 'cancelled', 'voided') NOT NULL DEFAULT 'creating'");
    }
}
