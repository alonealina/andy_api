<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBranchIdForFoodCategoryAndDrinkCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drink_categories', function (Blueprint $table) {
            $table->integer('branch_id')->after('id');
        });
        Schema::table('food_categories', function (Blueprint $table) {
            $table->integer('branch_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drink_categories', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
        Schema::table('food_categories', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
    }
}
