<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('districts_id')->nullable();
            $table->unsignedBigInteger('cities_id')->nullable();
            $table->unsignedBigInteger('customer_groups_id')->nullable();
            $table->enum('CustomerType',['Individual','Corporate'])->default('Individual')->comment('Müşteri Tipi');
            $table->string(   'CompanyName')->nullable();
            $table->string(   'Name');
            $table->string(   'Surname');
            $table->enum(     'Gender',['Male','Female'])->nullable();
            $table->string(   'Email')->unique()->nullable();
            $table->string(   'Password')->nullable();
            $table->string(   'Phone')->unique()->nullable();
            $table->dateTime( 'DateOfBirthDate')->nullable();
            $table->string(   'Address')->nullable();
            $table->boolean(  'Status')->default(true);
            $table->timestamps();

            $table->foreign('districts_id')->references('id')->on('districts')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cities_id')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('customer_groups_id')->references('id')->on('customer_groups')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
