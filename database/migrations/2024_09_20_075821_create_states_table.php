<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->mediumIncrements('id'); // UNSIGNED and AUTO_INCREMENT
            $table->string('name', 255); // Name of the state
            $table->unsignedMediumInteger('country_id'); // Foreign key to the countries table
            $table->string('country_code', 2); // Country code (ISO2)
            $table->string('state_code', 255); // State code
            $table->decimal('latitude', 10, 8)->nullable(); // Latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Longitude
            $table->timestamp('created_at')->nullable(); // Creation timestamp
            $table->timestamp('updated_on')->useCurrent()->useCurrentOnUpdate(); // Update timestamp
            $table->tinyInteger('flag')->default(1); // Flag
            $table->string('wikiDataId', 255)->nullable()->comment('Rapid API GeoDB Cities');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade'); // Foreign key constraint
        });
    }

    public function down()
    {
        Schema::dropIfExists('states');
    }
}
