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
        Schema::create('course_topics', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Topic name
            $table->text('description')->nullable(); // Topic description (optional)
            $table->date('publication_date'); // Date of publication
            $table->boolean('is_mandatory')->default(false); // Whether the topic is mandatory
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_topics');
    }
};
