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
        Schema::create('campaign_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
            $table->text('description');
            $table->string('sample_screenshot')->nullable(); // Stores file path
            $table->string('youtube_link')->nullable();
            $table->unsignedBigInteger('employer_id'); // No foreign key constraint
            $table->unsignedBigInteger('gig_id')->nullable(); // Optional, to associate with a gig
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_descriptions');
    }
};
