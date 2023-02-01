<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_details', function (Blueprint $table) {

            $table->integer('CompanyID');
            $table->string('AuthorizedName');
            $table->string('AuthorizedSurname');
            $table->string('AuthorizedEmail');
            $table->string('AuthorizedPhone');

            $table->string('CompanyName');
            $table->string('CompanyEmail');
            $table->string('CompanyPhone');
            $table->string('CompanyAddress');
            $table->string('CompanyLogo')->nullable();
            $table->string('CompanyVatNumber')->nullable()->comment('Vergi Numarası');
            $table->string('CompanyWebSite')->nullable();

            $table->string('CompanyBusinessArea')->comment('Çalışma alanı');
            $table->string('CompanyAccessToken')->comment('Auth Tokanı');

            $table->boolean('CompanyStatus')->nullable()->comment('Şirket işletme durumu');

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
        Schema::dropIfExists('company_details');
    }
}
