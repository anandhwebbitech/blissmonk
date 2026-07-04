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
        Schema::create('problem_sections', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->string('subheading_lead')->nullable();
            $table->text('good_points')->nullable(); // Stored as JSON Array
            $table->string('mid_title')->nullable(); // "Then suddenly..."
            $table->text('bad_points')->nullable();  // Stored as JSON Array
            $table->string('footer_text')->nullable();
            $table->string('image')->nullable();
            
            // Bottom two columns
            $table->string('worst_part_title')->nullable();
            $table->text('worst_part_desc_1')->nullable();
            $table->text('worst_part_desc_2')->nullable();
            
            $table->string('wondering_title')->nullable();
            $table->text('wondering_questions')->nullable(); // Stored as JSON Array
            $table->string('wondering_footer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problem_sections');
    }
};
