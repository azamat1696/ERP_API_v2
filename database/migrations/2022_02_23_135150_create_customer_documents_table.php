<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_documents', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('DocumentTypeId')->comment('Dosya Turu Id si');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('customer_drivers_id')->nullable();
            $table->dateTime('DocumentDateOfExpire')->nullable();
            $table->dateTime('DocumentDateOfIssue')->nullable();
            $table->string('DocumentNotes')->nullable();
            $table->string('DocumentNumber')->nullable();
            $table->string('DocumentPath')->nullable()->comment('Dosya Erişim Yolu');
            $table->boolean(  'Status')->default(true);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('customer_drivers_id')->references('id')->on('customer_drivers')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_documents');
    }
}
