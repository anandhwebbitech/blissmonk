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
        Schema::table('about_sections', function (Blueprint $table) {
            //
            $table->string('expertise_title')->default('Our Expertise')->after('image');
            $table->string('expertise_subtitle')->default('Prop Trading Excellence')->after('expertise_title');
            $table->json('expertise_items')->nullable()->after('expertise_subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            //
            $table->dropColumn(['expertise_title', 'expertise_subtitle', 'expertise_items']);
        });
    }
};
