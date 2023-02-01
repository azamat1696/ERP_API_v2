<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinistRegistrationCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machinist_registration_cars', function (Blueprint $table) {
            $table->unsignedBigInteger('car_damage_id')->nullable();
            $table->unsignedBigInteger('registration_id')->nullable();
            $table->boolean('Status')->default(false)->comment('Kayıt açılırken status false olacakdır');
            $table->foreign('registration_id')->references('id')->on('machinist_damage_registrations')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('car_damage_id')->references('id')->on('car_damages')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machinist_registration_cars');
    }
}
