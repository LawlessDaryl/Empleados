<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_employees', function (Blueprint $table) {
            $table->id();
            $table->dateTime('departure_date');
            $table->dateTime('return_date');
            $table->string('observation',255)->nullable();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('vacation_id')->constrained();
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
        Schema::dropIfExists('vacation_employees');
    }
}
