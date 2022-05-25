<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->double('opening_quantity')->default(0)->after('sale_price');
            $table->double('alert_quantity')->default(0)->after('opening_quantity');
            $table->double('quantity')->default(0)->after('alert_quantity');
            $table->bigInteger('unit_id')->unsigned()->nullable()->after('quantity');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('opening_quantity');
            $table->dropColumn('alert_quantity');
            $table->dropColumn('quantity');
            $table->dropForeign('products_unit_id_foreign');
            $table->dropColumn('unit_id');
        });
    }
}
