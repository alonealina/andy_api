<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('events');
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('title');
            $table->text('content');
            $table->dateTime('news_time');
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
        Schema::dropIfExists('news');
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->string('title', 255);
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
