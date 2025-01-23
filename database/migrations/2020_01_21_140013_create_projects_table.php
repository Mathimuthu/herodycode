<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('projectstatus')->default(1);
            $table->longText('des');
            $table->string('cat');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('duration');
            $table->string('stipend');
            $table->longText('benefits');
            $table->string('place');
            $table->string('count');
            $table->longText('skills');
            $table->string('proofs');
            $table->string('user');
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
        Schema::dropIfExists('projects');
    }
}
