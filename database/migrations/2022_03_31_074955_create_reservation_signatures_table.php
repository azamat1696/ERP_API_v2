<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->longText('CustomerSignature')->comment(' Müşteri imzası base64 formatta olacak ');
            $table->longText('PersonalSignature')->comment(' Personel imzası base64 formatta olacak ');
            $table->timestamps();
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('reservation_signatures');
    }
}
