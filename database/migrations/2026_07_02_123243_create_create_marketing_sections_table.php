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
        Schema::create('create_marketing_sections', function (Blueprint $table) {
            $table->id();
            $table->string('why_heading')->nullable();
            $table->string('why_subheading')->nullable();
            $table->string('lead_text')->nullable();
            $table->string('problem_label')->nullable();
            $table->json('problems_list')->nullable(); // Stored as Array
            $table->string('result_title')->nullable();
            $table->text('result_desc')->nullable();
            $table->string('truth_title')->nullable();
            $table->text('truth_desc')->nullable();

            // Prop Thesis Wrapper Data Strings
            $table->string('program_headline')->nullable();
            $table->text('program_subheadline')->nullable();
            $table->string('program_image')->nullable();
            $table->string('discover_text')->nullable();
            $table->json('benefits_list')->nullable(); // Stored as Array
            $table->string('pain_point_text')->nullable();
            $table->string('solution_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_marketing_sections');
    }
};
