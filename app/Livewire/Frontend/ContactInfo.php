<?php

namespace App\Livewire\Frontend;

use App\Models\ContactChannel;
use Livewire\Component;

class ContactInfo extends Component
{
    public function render()
    {
        $channels = ContactChannel::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('livewire.frontend.contact-info', [
            'channels' => $channels
        ]);
    }

    public function getChannelUrl($channel)
    {
        switch ($channel->channel_type) {
            case 'skype':
                return 'skype:' . $channel->value . '?chat';
            case 'email':
                return 'mailto:' . $channel->value;
            case 'phone':
                return 'tel:' . $channel->value;
            case 'whatsapp':
                $phone = preg_replace('/[^0-9]/', '', $channel->value);
                $message = urlencode('Hello! I would like to inquire about your services.');
                return 'https://wa.me/' . $phone . '?text=' . $message;
            case 'kingschat':
                return $channel->value; // Assuming it's a full URL
            default:
                return '#';
        }
    }
}
