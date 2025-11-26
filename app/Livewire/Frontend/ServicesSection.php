<?php

namespace App\Livewire\Frontend;

use App\Models\Service;
use Livewire\Component;

class ServicesSection extends Component
{
    public $services;

    public function mount()
    {
        $this->services = Service::where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('order')
            ->limit(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.services-section');
    }
}
