<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Dashboard extends Component
{
    public $stats = [];
    public $recentMessages;
    public $recentActivities;

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentMessages();
        $this->loadRecentActivities();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'total_testimonials' => Testimonial::count(),
            'total_faqs' => Faq::count(),
            'active_faqs' => Faq::where('is_active', true)->count(),
            'unread_messages' => ContactMessage::unread()->count(),
            'total_messages' => ContactMessage::count(),
        ];
    }

    public function loadRecentMessages()
    {
        $this->recentMessages = ContactMessage::latest()->take(5)->get();
    }

    public function loadRecentActivities()
    {
        $this->recentActivities = Activity::latest()->take(10)->get();
    }

    public function refreshStats()
    {
        $this->loadStats();
        $this->loadRecentMessages();
        $this->loadRecentActivities();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
