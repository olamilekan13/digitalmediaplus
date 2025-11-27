<?php

namespace App\Livewire\Frontend;

use App\Models\SiteSetting;
use Livewire\Component;

class WhatsAppButton extends Component
{
    public $siteSetting;
    public $isEnabled = false;
    public $whatsappNumber;
    public $whatsappMessage;

    public function mount()
    {
        $this->siteSetting = SiteSetting::first();

        if ($this->siteSetting) {
            $this->isEnabled = $this->siteSetting->whatsapp_chat_enabled;
            $this->whatsappNumber = $this->siteSetting->whatsapp_business_number;
            $this->whatsappMessage = $this->siteSetting->whatsapp_welcome_message ?? 'Hello! How can we help you today?';
        }
    }

    public function render()
    {
        return view('livewire.frontend.whats-app-button');
    }
}
