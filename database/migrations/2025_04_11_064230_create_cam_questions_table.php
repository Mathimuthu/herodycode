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
        Schema::create('cam_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->integer('employee_id');
            // Enhanced type field with more options
            $table->enum('type', [
                'text',      // Short text answer
                'paragraph', // Long text answer
                'choice',    // Multiple choice (radio buttons)
                'checkbox',  // Multiple options (checkboxes)
                'dropdown',  // Dropdown selection
                'file',      // File upload
                'date',      // Date picker
                'time'       // Time picker
            ]);
            $table->boolean('required')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cam_questions');
    }
};
