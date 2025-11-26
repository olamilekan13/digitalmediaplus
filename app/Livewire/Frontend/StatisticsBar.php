<?php

namespace App\Livewire\Frontend;

use App\Models\Statistic;
use Livewire\Component;

class StatisticsBar extends Component
{
    public function render()
    {
        $statistics = Statistic::where('is_active', true)
            ->orderBy('order')
            ->limit(6)
            ->get();

        return view('livewire.frontend.statistics-bar', [
            'statistics' => $statistics
        ]);
    }
}
