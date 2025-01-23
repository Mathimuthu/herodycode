<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->mediumIncrements('id'); // UNSIGNED and AUTO_INCREMENT
            $table->string('name', 255); // Name of the city
            $table->unsignedMediumInteger('state_id'); // Foreign key to the states table
            $table->unsignedMediumInteger('country_id'); // Foreign key to the countries table
            $table->char('country_code', 2); // Country code (ISO2)
            $table->string('fips_code', 255)->nullable(); // FIPS code (optional)
            $table->string('iso2', 255)->nullable(); // ISO2 code for the city (optional)
            $table->timestamp('created_at')->nullable(); // Creation timestamp
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Update timestamp
            $table->tinyInteger('flag')->default(1); // Flag
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade'); // Foreign key constraint
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade'); // Foreign key constraint
        });
    }

    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
