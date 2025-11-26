<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'company_name' => 'Digital Media Plus',
            'phone' => '+1 (555) 123-4567',
            'email' => 'info@digitalmediaplus.com',
            'address' => '123 Media Street, Creative City, CA 90210',
            'facebook_url' => 'https://facebook.com/digitalmediaplus',
            'twitter_url' => 'https://twitter.com/digitalmediaplus',
            'instagram_url' => 'https://instagram.com/digitalmediaplus',
            'linkedin_url' => 'https://linkedin.com/company/digitalmediaplus',
            'youtube_url' => 'https://youtube.com/@digitalmediaplus',
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'copyright_text' => '© 2025 Digital Media Plus. All rights reserved.',
        ]);
    }
}
