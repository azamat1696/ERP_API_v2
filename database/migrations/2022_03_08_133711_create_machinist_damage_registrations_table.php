<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinistDamageRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machinist_damage_registrations', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('cars_id')->nullable();
            $table->unsignedBigInteger('machinist_id')->nullable();
            $table->date('ReservationStartDate')->nullable();
            $table->date('ReservationEndDate')->nullable();
            $table->longText('Description')->nullable();
            $table->decimal('EstimatedRepairCost',9,2)->nullable();
            $table->enum('ReservationStatus',['Opened','Canceled','Completed'])->default('Opened')->nullable();
            $table->timestamps();
            
            $table->foreign('machinist_id')->references('id')->on('machinists')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cars_id')->references('id')->on('cars')->onDelete('set null')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machinist_damage_registrations');
    }
}
