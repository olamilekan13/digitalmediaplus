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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('whatsapp_business_number')->nullable()->after('youtube_url');
            $table->boolean('whatsapp_chat_enabled')->default(false)->after('whatsapp_business_number');
            $table->text('whatsapp_welcome_message')->nullable()->after('whatsapp_chat_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_business_number', 'whatsapp_chat_enabled', 'whatsapp_welcome_message']);
        });
    }
};
