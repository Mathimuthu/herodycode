<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecallingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecallings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('logo');
            $table->double('amount', 15, 8);
            $table->longText('script_des');
            $table->longText('script_img')->nullable();
            $table->longText('audio_des');
            $table->longText('audio_file')->nullable();
            $table->longText('obj_des');
            $table->longText('obj_img')->nullable();
            $table->longText('outcomes');
            $table->longText('file');
            $table->boolean('distributed')->default(0);
            $table->dateTime('last_date');
            $table->string('category');
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
        Schema::dropIfExists('telecallings');
    }
}
