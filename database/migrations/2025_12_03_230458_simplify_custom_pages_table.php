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
        // Drop sections table - we don't need it
        Schema::dropIfExists('custom_page_sections');

        // Simplify custom_pages table
        Schema::table('custom_pages', function (Blueprint $table) {
            $table->dropColumn(['layout', 'meta_title', 'meta_description']);
            $table->string('heading')->after('slug');
            $table->longText('content')->after('heading');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_pages', function (Blueprint $table) {
            $table->dropColumn(['heading', 'content']);
            $table->string('layout')->default('full-width');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });

        // Recreate sections table
        Schema::create('custom_page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_page_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->json('content');
            $table->integer('order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
};
