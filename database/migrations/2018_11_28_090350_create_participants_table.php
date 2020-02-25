<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->comment('用戶ID');
            $table->unsignedInteger('school_id')->nullable()->comment('用戶所屬學校ID');
            $table->unsignedInteger('school_name')->nullable()->comment('學校名稱');
            $table->string('name')->comment('參加者姓名');
            $table->string('grade')->nullable()->comment('參加者年級');
            $table->string('class')->nullable()->comment('參加者班級');
            $table->string('organization_id')->nullable()->comment('參加者所屬機構ID');
            $table->string('organization_name')->nullable()->comment('機構名稱');
            $table->string('department')->nullable()->comment('機構部門');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });
        
        Schema::dropIfExists('participants');
    }
}
