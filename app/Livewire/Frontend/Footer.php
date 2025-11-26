<?php

namespace App\Livewire\Frontend;

use App\Models\SiteSetting;
use App\Models\ContactChannel;
use Livewire\Component;

class Footer extends Component
{
    public $siteSetting;
    public $contactChannels;

    public function mount()
    {
        $this->siteSetting = SiteSetting::first();
        $this->contactChannels = ContactChannel::where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.footer');
    }
}
