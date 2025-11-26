<?php

namespace App\View\Components;

use App\Models\SiteSetting;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $siteSetting;

    public function __construct()
    {
        $this->siteSetting = SiteSetting::first();
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
