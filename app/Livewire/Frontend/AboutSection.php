<?php

namespace App\Livewire\Frontend;

use App\Models\AboutSection as AboutSectionModel;
use App\Models\FeatureHighlight;
use Livewire\Component;

class AboutSection extends Component
{
    public $aboutSection;
    public $featureHighlights;

    public function mount()
    {
        $this->aboutSection = AboutSectionModel::where('is_active', true)->first();
        $this->featureHighlights = FeatureHighlight::where('is_active', true)
            ->orderBy('order')
            ->limit(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.about-section');
    }
}
