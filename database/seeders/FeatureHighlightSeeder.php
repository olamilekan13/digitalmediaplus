<?php

namespace Database\Seeders;

use App\Models\FeatureHighlight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureHighlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'title' => 'Expert Team',
                'description' => 'Our talented professionals bring years of industry experience.',
                'icon' => 'fa-users',
                'order' => 1,
            ],
            [
                'title' => '24/7 Support',
                'description' => 'Round-the-clock assistance whenever you need it.',
                'icon' => 'fa-headset',
                'order' => 2,
            ],
            [
                'title' => 'Quality Guaranteed',
                'description' => 'We deliver excellence in every project we undertake.',
                'icon' => 'fa-check-circle',
                'order' => 3,
            ],
            [
                'title' => 'Fast Delivery',
                'description' => 'Quick turnaround times without compromising quality.',
                'icon' => 'fa-rocket',
                'order' => 4,
            ],
        ];

        foreach ($features as $feature) {
            FeatureHighlight::create($feature);
        }
    }
}
