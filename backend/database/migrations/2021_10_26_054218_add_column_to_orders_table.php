<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('rider_id')->unsigned()->nullable()->after('customer_id');
            $table->date('rider_assign_date')->nullable()->after('rider_id');
            $table->foreign('rider_id')->references('id')->on('riders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_rider_id_foreign');
            $table->dropColumn('rider_id');
            $table->dropColumn('rider_assign_date');
        });
    }
}
