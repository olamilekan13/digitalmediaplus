<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Custom web solutions tailored to your business needs using the latest technologies and best practices.',
                'icon' => 'fa-code',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'description' => 'Native and cross-platform mobile applications for iOS and Android that deliver exceptional user experiences.',
                'icon' => 'fa-mobile-alt',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'title' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'description' => 'Comprehensive digital marketing strategies including SEO, social media, and content marketing.',
                'icon' => 'fa-bullhorn',
                'is_featured' => true,
                'order' => 3,
            ],
            [
                'title' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'Beautiful and intuitive user interfaces that provide seamless experiences across all devices.',
                'icon' => 'fa-paint-brush',
                'is_featured' => false,
                'order' => 4,
            ],
            [
                'title' => 'E-commerce Solutions',
                'slug' => 'e-commerce-solutions',
                'description' => 'Complete e-commerce platforms with secure payment processing and inventory management.',
                'icon' => 'fa-shopping-cart',
                'is_featured' => false,
                'order' => 5,
            ],
            [
                'title' => 'Cloud Services',
                'slug' => 'cloud-services',
                'description' => 'Reliable cloud infrastructure and migration services for scalable and secure applications.',
                'icon' => 'fa-cloud',
                'is_featured' => false,
                'order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
