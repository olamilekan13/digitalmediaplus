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
        Schema::create('custom_page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_page_id')->constrained()->onDelete('cascade');
            $table->string('type'); // heading, text, image, video, gallery, cta, spacer
            $table->json('content'); // Flexible content based on type
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_page_sections');
    }
};
