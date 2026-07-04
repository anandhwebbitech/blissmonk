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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->default("🎉 You're Registered! Welcome to the Prop Trading Mastery Webinar");
            $table->string('heading')->nullable()->default('Prop Trading Mastery Webinar');
            $table->string('sub_heading')->nullable()->default("We're excited to have you join us for this exclusive live session.");
            
            // Rich text HTML block text fields (CKEditor contents)
            $table->text('what_you_will_learn')->nullable(); // Live session content points
            $table->text('before_webinar')->nullable();    // Prior joining checklist
            $table->text('body_content')->nullable();       // Additional custom notes layout
            
            // Corporate structural fields
            $table->string('company_name')->default('Bliss Monk Tech Solutionsz');
            $table->string('company_email')->default('bharath@blissmonktech.com');
            $table->string('company_phone')->default('+91 9894180719');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
