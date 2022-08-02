<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnCastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('casts', function (Blueprint $table) {
            $table->dropColumn('is_service');
            $table->dropColumn('is_overtime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('casts', function (Blueprint $table) {
            $table->boolean('is_service')->default(false);
            $table->boolean('is_overtime')->default(false);
        });
    }
}
