<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplicationCountsToGigsTable extends Migration
{
    public function up()
    {
        Schema::table('gigs', function (Blueprint $table) {
            $table->integer('total_applicants')->default(0); // Column to store total applicants
            $table->integer('status_4_applicants')->default(0); // Column to store status=4 applicants
        });
    }

    public function down()
    {
        Schema::table('gigs', function (Blueprint $table) {
            $table->dropColumn('total_applicants');
            $table->dropColumn('status_4_applicants');
        });
    }
}
