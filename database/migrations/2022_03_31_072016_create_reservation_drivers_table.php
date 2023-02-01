<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_drivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->boolean('Status')->default(true)->comment(' Sürücü Aracı Kullanıyormu bakılacak ');
            $table->timestamps();
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('driver_id')->references('id')->on('customer_drivers')->onDelete('set null')->onUpdate('cascade');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_drivers');
    }
}
