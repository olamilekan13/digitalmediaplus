<?php

namespace App\Livewire\Frontend;

use App\Models\HeroSection as HeroSectionModel;
use Livewire\Component;

class HeroSection extends Component
{
    public $heroSection;

    public function mount()
    {
        $this->heroSection = HeroSectionModel::where('is_active', true)->first();
    }

    public function render()
    {
        return view('livewire.frontend.hero-section');
    }
}
