<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'John Smith',
                'role' => 'CEO, Tech Innovations',
                'content' => 'Digital Media Plus transformed our online presence. Their expertise and dedication exceeded our expectations.',
                'image' => 'https://i.pravatar.cc/150?img=12',
                'order' => 1,
            ],
            [
                'name' => 'Sarah Johnson',
                'role' => 'Marketing Director, GrowthCo',
                'content' => 'Working with this team was an absolute pleasure. They delivered a stunning website that perfectly captures our brand.',
                'image' => 'https://i.pravatar.cc/150?img=45',
                'order' => 2,
            ],
            [
                'name' => 'Michael Chen',
                'role' => 'Founder, StartupHub',
                'content' => 'Professional, responsive, and incredibly talented. I highly recommend their services to anyone looking for quality digital solutions.',
                'image' => 'https://i.pravatar.cc/150?img=33',
                'order' => 3,
            ],
            [
                'name' => 'Emily Rodriguez',
                'role' => 'Product Manager, InnovateTech',
                'content' => 'The level of professionalism and technical expertise is outstanding. Our project was completed on time and exceeded expectations.',
                'image' => 'https://i.pravatar.cc/150?img=47',
                'order' => 4,
            ],
            [
                'name' => 'David Kim',
                'role' => 'CTO, Digital Solutions Inc',
                'content' => 'Exceptional service from start to finish. The team is knowledgeable, creative, and truly cares about delivering quality work.',
                'image' => 'https://i.pravatar.cc/150?img=68',
                'order' => 5,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
