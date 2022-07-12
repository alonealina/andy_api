<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casts', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->string('name', 30);
            $table->smallInteger('height')->nullable();
            $table->tinyInteger('blood_type')->nullable();
            $table->string('hobbit',1000)->nullable();
            $table->string('type_person',1000)->nullable();
            $table->string('dream',1000)->nullable();
            $table->string('fetish',1000)->nullable();
            $table->string('slogan',1000)->nullable();
            $table->string('instagram_url',1000)->nullable();
            $table->string('special_skill',1000)->nullable();
            $table->boolean('is_service')->default(false);
            $table->boolean('is_overtime')->default(false);
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
        Schema::dropIfExists('casts');
    }
}
