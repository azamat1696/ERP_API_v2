<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            
            $table->string('ReservationNo');
            $table->unsignedBigInteger('cars_id')->nullable();
            $table->unsignedBigInteger('pickup_office_id')->nullable()->comment('Office ID');
            $table->unsignedBigInteger('drop_office_id')->nullable()->comment('Office ID');
            $table->unsignedBigInteger('customers_id')->nullable()->comment('Customer ID');
            $table->dateTime('StartDateTime');
            $table->dateTime('EndDateTime');
            $table->integer( 'RentDays');
            $table->string(  'ReservationType');
            $table->string(  'CurrencyType');
            $table->string(  'CurrencySymbol');
            $table->string(  'CurrencyRate')->nullable()->comment('Dövüz ise o günkü kur olacak');
            $table->string('SelectedPriceTitle')->nullable();
            $table->decimal( 'DailyRentPrice');
            $table->decimal( 'RealDailyRentPrice')->comment('O gün O Aracın Orijinal Günlük ücreti ');
            $table->decimal( 'TotalRentPrice');
            $table->decimal( 'TotalExtraServicesPrice')->nullable();
            $table->decimal( 'TotalPrice');
            $table->decimal( 'TotalPriceByCurrency')->comment('Kur bazlı toplam tl karşılıgı')->nullable();
            $table->string(  'PaymentMethod')->comment('Ödeme Metodu');
            $table->string(  'PaymentState')->comment('Ödeme durumu');
            $table->string(  'TransactionNo')->nullable();
            $table->enum(    'ReservationStatus',['WaitingForApproval','Continues','Cancelled','Completed'])->comment('Reservation Statusu');
            $table->longText('ExtraServices')->nullable()->comment('Ekstra hizmetler json olarak kayıt edilecek');
            $table->longText('ReservationRemarks')->nullable();
            $table->timestamps();
            
            $table->foreign('cars_id')->references('id')->on('cars')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('pickup_office_id')->references('id')->on('offices')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('drop_office_id')->references('id')->on('offices')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('set null')->onUpdate('cascade');
            
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
