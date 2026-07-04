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
        Schema::create('funded_account_sections', function (Blueprint $table) {
            $table->id();
            $table->string('main_heading')->default('Your Next Funded Account Could Be Closer Than You Think');
            
            // Left Content Box (Red Border Indicator)
            $table->string('left_title')->default('You can continue doing what most traders do:');
            $table->longText('left_points')->nullable(); // JSON Array for Red "X" bullet points
            
            // Middle Divider Text
            $table->string('divider_text')->default('Or...');

            // Right Content Box (Green Border Indicator)
            $table->string('right_title')->default('You can learn the framework designed to help traders become disciplined, funded, and scalable.');
            $table->longText('right_points')->nullable(); // JSON Array for Green Dot bullet points

            // CTA Button 1 (Left - Primary Accent)
            $table->string('btn1_text')->default('REGISTER FOR FREE WEBINAR NOW');
            $table->string('btn1_url')->default('#');
            $table->string('btn1_subtext')->default('Reserve your seat before bonuses expire tonight.');

            // CTA Button 2 (Right - Outline Ghost Accent)
            $table->string('btn2_text')->default('JOIN THE WHATSAPP GROUP');
            $table->string('btn2_url')->default('#');
            $table->string('btn2_subtext')->default('Get updates, reminders, and exclusive webinar announcements.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funded_account_sections');
    }
};
