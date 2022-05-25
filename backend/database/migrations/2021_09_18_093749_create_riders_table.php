<?php

use App\Enums\ActiveStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->index('rider_first_name_index');
            $table->string('last_name')->nullable()->index('rider_last_name_index');
            $table->string('email')->unique()->index('rider_email_index');
            $table->string('phone')->unique()->index('rider_phone_index');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->boolean('verified')->default(false);
            $table->string('status')->default(ActiveStatus::ACTIVE());
            $table->dateTime('last_login')->nullable();
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
        Schema::dropIfExists('riders');
    }
}
