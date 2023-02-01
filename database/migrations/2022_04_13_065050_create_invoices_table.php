<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->string('InvoiceNo')->comment('Fatura Numarası');
            $table->string('InvoiceCar')->nullable();
            $table->decimal('UnitPrice',9,2)->nullable();
            $table->integer('Piece')->nullable()->default(1);
            $table->decimal('VatRate',9,2)->nullable()->default(5);
            $table->decimal('UnitTotal',9,2)->nullable();
            $table->decimal('SubTotal',9,2)->nullable();
            $table->decimal('VatTotal',9,2)->nullable();
            $table->decimal('Total',9,2)->nullable();
            $table->longText('TotalSting')->nullable();
            $table->timestamps();
            
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('set null')->onUpdate('cascade');
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
