<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('des');
            $table->string('cat');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('duration');
            $table->string('stipend')->nullable();
            $table->longText('benefits')->nullable();
            $table->string('count')->nullable();
            $table->string('place')->nullable();    
            $table->longText('skills')->nullable(); 
            $table->string('proofs')->nullable();
            $table->string('user')->nullable();
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
        Schema::dropIfExists('pendings');
    }
}
