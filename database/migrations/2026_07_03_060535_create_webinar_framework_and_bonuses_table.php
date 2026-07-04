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
        Schema::create('webinar_framework_and_bonuses', function (Blueprint $table) {
            $table->id();
            // Framework Block (zx-)
            $table->string('fw_title')->default("The Time-Aligned Prop Scaling Framework™");
            $table->string('fw_image')->nullable();
            $table->text('fw_paragraph_1')->nullable();
            $table->string('fw_emphasis_light')->nullable();
            $table->string('fw_emphasis_bold')->nullable();
            $table->text('fw_paragraph_2')->nullable();
            $table->longText('fw_list_items')->nullable(); // JSON Array
            $table->text('fw_conclusion')->nullable();

            // Perfect For / Not For Matrix
            $table->string('perfect_title')->default("Perfect For:");
            $table->longText('perfect_items')->nullable(); // JSON Array
            $table->string('not_perfect_title')->default("Not For:");
            $table->longText('not_perfect_items')->nullable(); // JSON Array

            // Bonuses Block (trd-)
            $table->string('bonus_heading')->default("Exclusive Webinar Bonuses");
            $table->longText('bonuses_cards')->nullable(); // JSON Array
            $table->string('urgent_text')->default("Bonus expires tonight.");
            
            // Risk-Free vs Restrictions Split Panel
            $table->string('risk_title')->default("Risk-Free Registration");
            $table->longText('risk_paragraphs')->nullable(); // JSON Array
            $table->string('expire_title')->default("Important: Bonuses Expire Tonight");
            $table->string('expire_subtitle')->default("Once registration closes:");
            $table->longText('expire_items')->nullable(); // JSON Array
            
            $table->text('footer_cta')->nullable();
            $table->string('footer_cta_highlight')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinar_framework_and_bonuses');
    }
};
