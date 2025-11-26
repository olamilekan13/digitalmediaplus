<?php

namespace Database\Seeders;

use App\Models\HeroSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSection::create([
            'heading' => 'Welcome to Digital Media Plus',
            'tagline' => 'Your Partner in Digital Excellence',
            'cta_button_text' => 'Get Started',
            'cta_button_link' => '/contact',
            'background_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1920&h=1080&fit=crop',
            'is_active' => true,
        ]);
    }
}
