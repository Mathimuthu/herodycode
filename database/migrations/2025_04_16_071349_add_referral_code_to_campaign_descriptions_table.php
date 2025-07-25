<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('campaign_descriptions', function (Blueprint $table) {
            $table->string('referral_code')->unique()->nullable()->after('gig_id');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaign_descriptions', function (Blueprint $table) {
            $table->dropColumn('referral_code');
        });
    }
};
