<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index('zone_name_index');
            $table->string('city')->index('zone_city_index')->nullable();
            $table->string('state')->index('zone_state_index')->nullable();
            $table->string('zipcode')->index('zone_zipcode_index')->nullable();
            $table->string('country')->index('zone_country_index');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zones');
    }
}