<?php

namespace App\Livewire\Frontend;

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\NewContactMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $message = '';
    public $successMessage = '';

    protected $rules = [
        'name' => 'required|string|max:255|min:2',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'message' => 'required|string|min:10|max:2000',
    ];

    protected $messages = [
        'name.required' => 'Please enter your name.',
        'name.min' => 'Name must be at least 2 characters.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'message.required' => 'Please enter your message.',
        'message.min' => 'Message must be at least 10 characters.',
        'message.max' => 'Message cannot exceed 2000 characters.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $validatedData = $this->validate();

        // Save to database
        $contactMessage = ContactMessage::create($validatedData);

        // Send email notification to all admin users
        $admins = User::where('is_admin', true)->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new NewContactMessage($contactMessage));
        }

        // Set success message
        $this->successMessage = 'Thank you for contacting us! We will get back to you soon.';

        // Reset form
        $this->reset(['name', 'email', 'phone', 'message']);

        // Optional: Dispatch browser event for notification
        $this->dispatch('contact-form-submitted');

        // Auto-hide success message after 5 seconds
        $this->dispatch('auto-hide-success');
    }

    public function render()
    {
        return view('livewire.frontend.contact-form');
    }
}
