<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_sales', function (Blueprint $table) {
            $table->id();
            $table->string('InvoiceNo')->comment('Fatura Numarası');
            $table->string('InvoiceTitle')->nullable()->comment('İşlem Başlıgı');
            $table->decimal('UnitPrice',9,2)->nullable()->comment('Birim Fiyatı');
            $table->integer('Piece')->nullable()->default(1)->comment('Miktar by default 1');
            $table->decimal('VatRate',9,2)->nullable()->default(5)->comment('Kdv Oranı default 5');
            $table->decimal('UnitTotal',9,2)->nullable()->comment('Birim Toplam');
            $table->decimal('SubTotal',9,2)->nullable();
            $table->decimal('VatTotal',9,2)->nullable();
            $table->decimal('Total',9,2)->nullable();
            $table->longText('TotalSting')->nullable();
            $table->longText('Description')->comment('Açıklama')->nullable();
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
        Schema::dropIfExists('foreign_sales');
    }
}
