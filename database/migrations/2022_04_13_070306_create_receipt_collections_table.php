<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->string('ReceiptCollectionNo')->comment('Tahsilat Makbuz Numarası');
            $table->longText('MessageContent')->nullable();
            $table->timestamps();
            
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_collections');
    }
}
