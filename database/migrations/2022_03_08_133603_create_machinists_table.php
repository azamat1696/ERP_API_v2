<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machinists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('machinist_type_id')->nullable();
            $table->string('CompanyName');
            $table->string('CompanyPhone');
            $table->string('CompanyEmail');
            $table->string('AuthorizedPerson');
            $table->string('CompanyTaxAddress');
            $table->string('CompanyTaxNumber');
            $table->string('CompanyAddress');
            $table->boolean('Status')->default(true);
            $table->timestamps();
            
            $table->foreign('machinist_type_id')->references('id')->on('machinist_types')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machinists');
    }
}
