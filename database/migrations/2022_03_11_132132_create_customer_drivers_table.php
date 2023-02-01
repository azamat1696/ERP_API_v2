<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_drivers', function (Blueprint $table) {
            
            $table->id();
            
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('DriverName');
            $table->string('DriverSurname');
            $table->string('DriverPhone')->nullable();
            $table->string('DriverEmail')->nullable();
            $table->boolean('Status')->default(1)->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_drivers');
    }
}
