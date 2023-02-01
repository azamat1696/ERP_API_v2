<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_offices', function (Blueprint $table) {
            $table->id();
            $table->string('LocationOfficeName');
            $table->decimal('LocationTransferCoast',9,2)->nullable();
            $table->string('LocationOfficePhone')->nullable();
            $table->string('TaxAdministration')->comment('Vergi Dairesi');
            $table->string('TaxNumber')->comment('Vergi Numarası');
            $table->string('LocationOfficeLogo')->nullable();
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
        Schema::dropIfExists('location_offices');
    }
}
