<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->mediumIncrements('id'); // UNSIGNED and AUTO_INCREMENT
            $table->string('name', 100); // Name of the country
            $table->char('iso3', 3)->nullable(); // ISO3 code
            $table->char('iso2', 2)->nullable(); // ISO2 code
            $table->string('phonecode', 255)->nullable(); // Phone code
            $table->string('capital', 255)->nullable(); // Capital city
            $table->string('currency', 255)->nullable(); // Currency code
            $table->timestamp('created_at')->nullable(); // Creation timestamp
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Update timestamp
            $table->tinyInteger('flag')->default(1); // Flag, default value set to 1
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities');
        });
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
