<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBondUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bond_users', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('amount',255);
            $table->string('description',255)->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('bond_id')->constrained();
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
        Schema::dropIfExists('bond_users');
    }
}
