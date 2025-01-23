<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecallingAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecalling_apps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tid');
            $table->bigInteger('uid');
            $table->longText('data')->nullable();
            $table->integer('status')->default(0);
            $table->longText('feedback')->nullable();
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
        Schema::dropIfExists('telecalling_apps');
    }
}
