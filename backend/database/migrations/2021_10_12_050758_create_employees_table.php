<?php

use App\Enums\EmployeeStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->index('employee_first_name_index');
            $table->string('last_name')->index('employee_last_name_index');
            $table->string('email')->unique()->nullable()->index('employee_email_index');
            $table->string('phone')->unique()->index('employee_phone_index');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('designation')->nullable()->index('employee_designation_index');
            $table->date('joining_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->double('salary')->default(0);
            $table->string('status')->default(EmployeeStatus::ACTIVE());
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
        Schema::dropIfExists('employees');
    }
}
