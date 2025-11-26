<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statistics = [
            [
                'label' => 'Client Satisfaction',
                'percentage' => 98,
                'icon' => 'fa-smile',
                'order' => 1,
            ],
            [
                'label' => 'Projects Completed',
                'percentage' => 95,
                'icon' => 'fa-tasks',
                'order' => 2,
            ],
            [
                'label' => 'On-Time Delivery',
                'percentage' => 99,
                'icon' => 'fa-clock',
                'order' => 3,
            ],
            [
                'label' => 'Quality Score',
                'percentage' => 97,
                'icon' => 'fa-star',
                'order' => 4,
            ],
        ];

        foreach ($statistics as $statistic) {
            Statistic::create($statistic);
        }
    }
}
