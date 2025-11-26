<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutSection::create([
            'heading' => 'About Digital Media Plus',
            'description' => 'We are a leading digital agency committed to transforming businesses through innovative technology solutions.',
            'story_text' => 'Founded in 2010, Digital Media Plus has grown from a small startup to a full-service digital agency. Our team of passionate professionals combines creativity with technical expertise to deliver exceptional results for our clients. We believe in building long-term partnerships and helping businesses thrive in the digital age.',
            'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop',
            'is_active' => true,
        ]);
    }
}
