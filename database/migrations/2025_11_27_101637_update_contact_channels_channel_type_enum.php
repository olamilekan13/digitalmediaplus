<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any existing 'skype' records to 'teams'
        DB::table('contact_channels')
            ->where('channel_type', 'skype')
            ->update(['channel_type' => 'teams']);

        // Modify the ENUM column to replace 'skype' with 'teams'
        DB::statement("ALTER TABLE contact_channels MODIFY COLUMN channel_type ENUM('email', 'phone', 'whatsapp', 'teams', 'kingschat') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update any existing 'teams' records back to 'skype'
        DB::table('contact_channels')
            ->where('channel_type', 'teams')
            ->update(['channel_type' => 'skype']);

        // Revert the ENUM column back to include 'skype' instead of 'teams'
        DB::statement("ALTER TABLE contact_channels MODIFY COLUMN channel_type ENUM('email', 'phone', 'whatsapp', 'skype', 'kingschat') NOT NULL");
    }
};
