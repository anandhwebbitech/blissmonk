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
        Schema::create('webinar_heros', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable(); // CKEditor structural rich data
            
            // Buttons Texts
            $table->string('btn_register_text')->default('Register For Free Webinar');
            $table->string('btn_whatsapp_text')->default('JOIN WHATSAPP GROUP');
            
            // Additional Link Columns
            $table->string('btn_register_url')->nullable();
            $table->string('btn_whatsapp_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinar_heros');
    }
};
