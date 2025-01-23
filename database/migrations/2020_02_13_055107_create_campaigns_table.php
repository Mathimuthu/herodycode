<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand');
            $table->string('logo');
            $table->string('title');
            $table->string('campaignstatus')->default(1);// 1:- active and 0 :- inactive 
            $table->mediumText('des');
            $table->dateTime('start');
            $table->dateTime('before');
            $table->dateTime('end');
            $table->integer('ucount');
            $table->string('city');
            $table->string('reward');
            $table->mediumText('benefits');
            $table->mediumText('requirements');
            $table->mediumText('imp_terms');
            $table->mediumText('terms');
            $table->string('task');
            $table->mediumText('dondont');
            $table->mediumText('instructions');
            $table->mediumText('methods');
            $table->bigInteger('form')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
}
