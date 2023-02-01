<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id')->nullable()->unique();
            $table->decimal('DailyPrice',9,2);
            $table->decimal('WeeklyPrice',9,2);
            $table->decimal('MonthlyPrice',9,2);
            $table->decimal('YearlyPrice',9,2);
            $table->string('WeeklyPriceRange')->nullable()->comment('Haftalık Fiyat Aralıkları');
            $table->string('MonthlyPriceRange')->nullable()->comment('Aylık Fiyat Aralıkları');
            $table->string('YearlyPriceRange')->nullable()->comment('Yıllık Fiyat Aralıkları');
            $table->timestamps();

            $table->foreign('model_id')->references('id')->on('car_models')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_prices');
    }
}
