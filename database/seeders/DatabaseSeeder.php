<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SiteSettingSeeder::class,
            HeroSectionSeeder::class,
            ServiceSeeder::class,
            AboutSectionSeeder::class,
            FeatureHighlightSeeder::class,
            StatisticSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            ContactChannelSeeder::class,
        ]);
    }
}
