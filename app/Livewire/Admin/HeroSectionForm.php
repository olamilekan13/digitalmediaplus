<?php

namespace App\Livewire\Admin;

use App\Models\HeroSection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class HeroSectionForm extends Component
{
    use WithFileUploads;

    public $heroSection;
    public $heading;
    public $tagline;
    public $cta_button_text;
    public $cta_button_link;
    public $is_active = true;
    public $newBackgroundImage;
    public $currentBackgroundImage;

    protected $rules = [
        'heading' => 'required|string|max:255',
        'tagline' => 'nullable|string|max:500',
        'cta_button_text' => 'nullable|string|max:100',
        'cta_button_link' => 'nullable|string|max:255',
        'newBackgroundImage' => 'nullable|image|max:5120|mimes:jpg,jpeg,png,webp',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'heading.required' => 'The main heading field is required.',
        'heading.max' => 'The heading must not be greater than 255 characters.',
        'tagline.max' => 'The tagline must not be greater than 500 characters.',
        'cta_button_text.max' => 'The CTA button text must not be greater than 100 characters.',
        'cta_button_link.required' => 'Please select a page section for the CTA button.',
        'newBackgroundImage.image' => 'The background image must be an image.',
        'newBackgroundImage.max' => 'The background image must not be greater than 5MB.',
        'newBackgroundImage.mimes' => 'The background image must be a file of type: jpg, jpeg, png, webp.',
    ];

    public function getPageSections()
    {
        return [
            '#hero' => 'Hero Section',
            '#about' => 'About Section',
            '#services' => 'Services Section',
            '#features' => 'Features Section',
            '#statistics' => 'Statistics Section',
            '#testimonials' => 'Testimonials Section',
            '#faq' => 'FAQ Section',
            '#contact' => 'Contact Section',
        ];
    }

    public function mount()
    {
        $this->heroSection = HeroSection::first();

        if (!$this->heroSection) {
            $this->heroSection = HeroSection::create([
                'heading' => 'Welcome to ' . config('app.name'),
                'tagline' => 'Your success is our mission',
                'is_active' => true,
            ]);
        }

        $this->heading = $this->heroSection->heading;
        $this->tagline = $this->heroSection->tagline;
        $this->cta_button_text = $this->heroSection->cta_button_text;
        $this->cta_button_link = $this->heroSection->cta_button_link;
        $this->is_active = $this->heroSection->is_active;
        $this->currentBackgroundImage = $this->heroSection->background_image;
    }

    public function updatedNewBackgroundImage()
    {
        $this->validate([
            'newBackgroundImage' => 'nullable|image|max:5120|mimes:jpg,jpeg,png,webp',
        ]);
    }

    public function removeBackgroundImage()
    {
        if ($this->currentBackgroundImage && Storage::disk('public')->exists($this->currentBackgroundImage)) {
            Storage::disk('public')->delete($this->currentBackgroundImage);
        }

        $this->heroSection->update(['background_image' => null]);
        $this->currentBackgroundImage = null;
        $this->newBackgroundImage = null;

        $this->dispatch('notify', message: 'Background image removed successfully.', type: 'success');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'heading' => $this->heading,
            'tagline' => $this->tagline,
            'cta_button_text' => $this->cta_button_text,
            'cta_button_link' => $this->cta_button_link,
            'is_active' => $this->is_active,
        ];

        if ($this->newBackgroundImage) {
            // Delete old background image if exists
            if ($this->currentBackgroundImage && Storage::disk('public')->exists($this->currentBackgroundImage)) {
                Storage::disk('public')->delete($this->currentBackgroundImage);
            }

            // Store new background image
            $data['background_image'] = $this->newBackgroundImage->store('hero', 'public');
            $this->currentBackgroundImage = $data['background_image'];
            $this->newBackgroundImage = null;
        }

        $this->heroSection->update($data);

        $this->dispatch('notify', message: 'Hero section updated successfully.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.hero-section-form');
    }
}
