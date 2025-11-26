<?php

namespace App\Livewire\Frontend;

use App\Models\SiteSetting;
use Livewire\Component;

class Navigation extends Component
{
    public $siteSetting;
    public $showMobileMenu = false;
    public $isScrolled = false;

    public function mount()
    {
        $this->siteSetting = SiteSetting::first();
    }

    public function toggleMobileMenu()
    {
        $this->showMobileMenu = !$this->showMobileMenu;
    }

    public function render()
    {
        return view('livewire.frontend.navigation');
    }
}
