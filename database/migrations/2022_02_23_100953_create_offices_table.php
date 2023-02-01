<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('districts_id')->nullable();
            $table->unsignedBigInteger('cities_id')->nullable();
            $table->string('OfficeName')->unique();
            $table->string('OfficePhone')->unique()->nullable();
            $table->string('OfficeEmail')->unique()->nullable();
            $table->string('OfficeAddress')->nullable();
            $table->longText('OfficeWorkingPeriods')->nullable()->comment('Office working hour periodic objects');
            $table->string('Positions')->nullable()->comment('Location lat lng objects');
            $table->string('OfficeContacts')->nullable()->comment('Office Contacts object');
            $table->boolean('Status')->default(true);
            $table->timestamps();

            $table->foreign('districts_id')->references('id')->on('districts')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cities_id')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offices');
    }
}
