<?php

namespace App\Livewire\Frontend;

use App\Models\ContactChannel;
use Livewire\Component;

class WhatsAppButton extends Component
{
    public $whatsappNumber;
    public $whatsappMessage;

    public function mount()
    {
        // Get WhatsApp number from contact_channels table
        $whatsappChannel = ContactChannel::where('channel_type', 'whatsapp')
            ->where('is_active', true)
            ->first();

        $this->whatsappNumber = $whatsappChannel?->value ?? null;
        $this->whatsappMessage = 'Hello DigitalMediaPlus';
    }

    public function render()
    {
        return view('livewire.frontend.whats-app-button');
    }
}
