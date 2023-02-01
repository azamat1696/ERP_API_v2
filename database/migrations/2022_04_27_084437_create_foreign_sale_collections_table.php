<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignSaleCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_sale_collections', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('foreign_sale_id')->nullable();
            $table->string('ReceiptCollectionNo')->comment('Tahsilat Makbuz Numarası');
            $table->longText('MessageContent')->nullable();
            $table->timestamps();

            $table->foreign('foreign_sale_id')->references('id')->on('foreign_sales')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foreign_sale_collections');
    }
}
