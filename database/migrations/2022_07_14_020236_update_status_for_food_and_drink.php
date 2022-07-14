<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusForFoodAndDrink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drinks', function (Blueprint $table) {
            $table->tinyInteger('status')->default(\App\Enums\InventoryStatus::ON_SALE);
        });
        Schema::table('food', function (Blueprint $table) {
            $table->tinyInteger('status')->default(\App\Enums\InventoryStatus::ON_SALE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('drinks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
