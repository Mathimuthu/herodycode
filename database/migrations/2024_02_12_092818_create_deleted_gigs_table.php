<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletedGigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deleted_gigs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('per_cost', 8, 2);
            $table->string('campaign_title');
            $table->longText('description');
            $table->unsignedBigInteger('user_id');
            $table->string('brand');
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
        Schema::dropIfExists('deleted_gigs');
    }
}
