<?php

namespace App\Livewire\Frontend;

use App\Models\Testimonial;
use Livewire\Component;

class TestimonialsSlider extends Component
{
    public function render()
    {
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('livewire.frontend.testimonials-slider', [
            'testimonials' => $testimonials
        ]);
    }
}
