<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What services do you offer?',
                'answer' => 'We offer a comprehensive range of digital services including web development, mobile app development, digital marketing, UI/UX design, e-commerce solutions, and cloud services.',
                'order' => 1,
            ],
            [
                'question' => 'How long does a typical project take?',
                'answer' => 'Project timelines vary depending on complexity and scope. A basic website may take 4-6 weeks, while more complex applications can take 3-6 months. We provide detailed timelines during the consultation phase.',
                'order' => 2,
            ],
            [
                'question' => 'Do you provide ongoing support?',
                'answer' => 'Yes, we offer comprehensive maintenance and support packages to ensure your digital products continue to perform optimally. Our support includes updates, bug fixes, and technical assistance.',
                'order' => 3,
            ],
            [
                'question' => 'What is your development process?',
                'answer' => 'Our process includes discovery and planning, design, development, testing, and deployment. We maintain clear communication throughout and involve you at key milestones to ensure the final product meets your expectations.',
                'order' => 4,
            ],
            [
                'question' => 'How much does a project cost?',
                'answer' => 'Project costs vary based on requirements, complexity, and timeline. We provide transparent pricing after understanding your needs. Contact us for a detailed quote tailored to your specific project.',
                'order' => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
