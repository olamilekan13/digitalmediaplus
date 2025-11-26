<?php

namespace App\Livewire\Frontend;

use App\Models\Service;
use Livewire\Component;

class ServicesList extends Component
{
    public function render()
    {
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('livewire.frontend.services-list', [
            'services' => $services
        ]);
    }
}
