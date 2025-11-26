<?php

namespace App\Livewire\Frontend;

use App\Models\Faq;
use Livewire\Component;

class FaqAccordion extends Component
{
    public function render()
    {
        $faqs = Faq::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('livewire.frontend.faq-accordion', [
            'faqs' => $faqs
        ]);
    }
}
