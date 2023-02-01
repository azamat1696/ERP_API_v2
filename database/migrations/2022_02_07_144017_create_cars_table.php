<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_brands_id')->nullable();
            $table->unsignedBigInteger('car_models_id')->nullable();
            $table->unsignedBigInteger('car_body_types_id')->nullable();
            $table->unsignedBigInteger('car_classes_id')->nullable();
            $table->unsignedBigInteger('car_fuel_types_id')->nullable();
            $table->unsignedBigInteger('car_transmission_types_id')->nullable();
            $table->unsignedBigInteger('offices_id')->nullable();
            $table->unsignedBigInteger('CarTypeId');
            $table->string('LicencePlate');
            $table->string('Year');
            $table->string('Image')->nullable();
            $table->string('EngineCapacity');
            $table->string('CarColor')->nullable();
            $table->string('NumberOfSeats')->nullable();
            $table->string('NumberOfDoors')->nullable();
            $table->string('NumberOfLargeBags')->nullable();
            $table->string('NumberOfSmallBags')->nullable();
            $table->boolean('Status')->comment('Araç Statusu');
            $table->boolean('CarAvailability')->comment('Araç Statusu Hizmet Durumu')->default(1);
            $table->text('ExtraFields')->nullable();
            $table->text('CarRemarks')->nullable();
            $table->boolean('IsReserved')->default(0)->comment('0 ----> Müsait, 1 ----> Dolu');
            
            
            $table->timestamps();
            /************* *************** FOREIGN_KEYS ************* ***********/
            $table->foreign('car_brands_id')->references('id')->on('car_brands')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('car_models_id')->references('id')->on('car_models')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('car_body_types_id')->references('id')->on('car_body_types')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('car_classes_id')->references('id')->on('car_classes')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('car_fuel_types_id')->references('id')->on('car_fuel_types')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('car_transmission_types_id')->references('id')->on('car_transmission_types')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('offices_id')->references('id')->on('offices')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
