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
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('webinar_date');
            $table->integer('duration_minutes')->default(60);
            $table->string('speaker_name');
            $table->string('meeting_link'); // Zoom, Google Meet link
            $table->string('banner_image')->nullable(); // Optional Image
            $table->enum('status', ['upcoming', 'live', 'completed'])->default('upcoming');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinars');
    }
};
