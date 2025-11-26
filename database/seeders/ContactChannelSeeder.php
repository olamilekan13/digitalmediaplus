<?php

namespace Database\Seeders;

use App\Models\ContactChannel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = [
            [
                'channel_type' => 'email',
                'value' => 'info@digitalmediaplus.com',
                'icon' => 'fa-envelope',
                'order' => 1,
            ],
            [
                'channel_type' => 'phone',
                'value' => '+1 (555) 123-4567',
                'icon' => 'fa-phone',
                'order' => 2,
            ],
            [
                'channel_type' => 'whatsapp',
                'value' => '+15551234567',
                'icon' => 'fa-whatsapp',
                'order' => 3,
            ],
            [
                'channel_type' => 'skype',
                'value' => 'digitalmediaplus',
                'icon' => 'fa-skype',
                'order' => 4,
            ],
        ];

        foreach ($channels as $channel) {
            ContactChannel::create($channel);
        }
    }
}
