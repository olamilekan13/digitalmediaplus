<?php

namespace App\Livewire\Admin;

use App\Models\AboutSection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class AboutSectionForm extends Component
{
    use WithFileUploads;

    public $aboutSection;
    public $heading;
    public $description;
    public $story_text;
    public $is_active = true;
    public $newImage;
    public $currentImage;

    protected $rules = [
        'heading' => 'required|string|max:255',
        'description' => 'nullable|string',
        'story_text' => 'nullable|string',
        'newImage' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'heading.required' => 'The section heading is required.',
        'heading.max' => 'The heading must not be greater than 255 characters.',
        'newImage.image' => 'The company image must be an image file.',
        'newImage.max' => 'The company image must not be greater than 2MB.',
        'newImage.mimes' => 'The company image must be a file of type: jpg, jpeg, png, webp.',
    ];

    public function mount()
    {
        $this->aboutSection = AboutSection::first();

        if (!$this->aboutSection) {
            $this->aboutSection = AboutSection::create([
                'heading' => 'About ' . config('app.name'),
                'description' => '',
                'story_text' => '',
                'is_active' => true,
            ]);
        }

        $this->heading = $this->aboutSection->heading;
        $this->description = $this->aboutSection->description;
        $this->story_text = $this->aboutSection->story_text;
        $this->is_active = $this->aboutSection->is_active;
        $this->currentImage = $this->aboutSection->image;
    }

    public function updatedNewImage()
    {
        $this->validate([
            'newImage' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
        ]);
    }

    public function removeImage()
    {
        if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
            Storage::disk('public')->delete($this->currentImage);
        }

        $this->aboutSection->update(['image' => null]);
        $this->currentImage = null;
        $this->newImage = null;

        $this->dispatch('notify', message: 'Company image removed successfully.', type: 'success');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'heading' => $this->heading,
            'description' => $this->description,
            'story_text' => $this->story_text,
            'is_active' => $this->is_active,
        ];

        if ($this->newImage) {
            // Delete old image if exists
            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                Storage::disk('public')->delete($this->currentImage);
            }

            // Store new image
            $data['image'] = $this->newImage->store('about-sections', 'public');
            $this->currentImage = $data['image'];
            $this->newImage = null;
        }

        $this->aboutSection->update($data);

        $this->dispatch('notify', message: 'About section updated successfully.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.about-section-form');
    }
}
