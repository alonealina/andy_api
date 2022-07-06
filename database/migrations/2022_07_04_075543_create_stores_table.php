<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->integer('store_category_id');
            $table->string('name', 100);
            $table->string('post_code_1', 100)->nullable();
            $table->string('post_code_2', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('payment_method')->default('[1]');
            $table->tinyInteger('counter_count')->default(0);
            $table->tinyInteger('table_count')->default(0);
            $table->tinyInteger('room_count')->default(0);
            $table->tinyInteger('stand_count')->default(0);
            $table->string('hotline', 100)->nullable();
            $table->string('homepage_url', 255)->nullable();
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
        Schema::dropIfExists('stores');
    }
}
