<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarDamagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_damages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cars_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('DamageCode');
            $table->string('DamageLevel');
            $table->string('DamageTitle');
            $table->longText('DamageDescription')->nullable();
            $table->longText('DamageFiles')->nullable();
            $table->decimal('DamagePrice',9,2)->nullable();
            $table->longText('DamageMaterials')->nullable();
            $table->enum('DamageMaintenanceStatus',['Completed','Waiting','Processing'])->default('Waiting')->nullable();
            $table->timestamps();

            $table->foreign('cars_id')->references('id')->on('cars')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_damages');
    }
}
