<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_information', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('pm_last');
            $table->string('companion_fee');
            $table->string('nomination_fee');
            $table->string('extension_fee');
            $table->string('vip_fee');
            $table->string('shochu_fee');
            $table->string('brandy_fee');
            $table->string('whisky_fee');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_information');
    }
}
