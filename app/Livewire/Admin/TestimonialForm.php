<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class TestimonialForm extends Component
{
    use WithFileUploads;

    public $testimonialId;
    public $testimonial;
    public $name;
    public $role;
    public $content;
    public $newImage;
    public $currentImage;
    public $order = 0;
    public $is_active = true;
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'content' => 'required|string|max:500',
        'newImage' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
        'order' => 'nullable|integer|min:0',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'The customer name is required.',
        'name.max' => 'The name must not exceed 255 characters.',
        'role.required' => 'The role/title is required.',
        'role.max' => 'The role must not exceed 255 characters.',
        'content.required' => 'The testimonial text is required.',
        'content.max' => 'The testimonial must not exceed 500 characters.',
        'newImage.image' => 'The photo must be an image.',
        'newImage.max' => 'The photo must not be greater than 2MB.',
        'newImage.mimes' => 'The photo must be a file of type: jpg, jpeg, png, webp.',
        'order.integer' => 'The order must be a number.',
        'order.min' => 'The order must be at least 0.',
    ];

    public function mount($testimonialId = null)
    {
        if ($testimonialId) {
            $this->isEditMode = true;
            $this->testimonialId = $testimonialId;
            $this->testimonial = Testimonial::findOrFail($testimonialId);

            $this->name = $this->testimonial->name;
            $this->role = $this->testimonial->role;
            $this->content = $this->testimonial->content;
            $this->order = $this->testimonial->order ?? 0;
            $this->is_active = $this->testimonial->is_active;
            $this->currentImage = $this->testimonial->image;
        } else {
            // Get next order number
            $this->order = Testimonial::max('order') + 1 ?? 1;
        }
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

        if ($this->testimonial) {
            $this->testimonial->update(['image' => null]);
        }

        $this->currentImage = null;
        $this->newImage = null;

        $this->dispatch('notify', message: 'Customer photo removed successfully.', type: 'success');
    }

    public function save()
    {
        // Check permissions
        if ($this->isEditMode) {
            // For editing, check if user has manage or edit permission
            if (!auth()->user()->hasPermission('manage_testimonials') && !auth()->user()->hasPermission('edit_testimonials')) {
                session()->flash('error', 'You do not have permission to edit testimonials.');
                return redirect()->route('admin.testimonials.index');
            }
        } else {
            // For creating, check if user has manage permission
            if (!auth()->user()->hasPermission('manage_testimonials')) {
                session()->flash('error', 'You do not have permission to create testimonials.');
                return redirect()->route('admin.testimonials.index');
            }
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'role' => $this->role,
            'content' => $this->content,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];

        // Handle image upload
        if ($this->newImage) {
            // Delete old image if exists
            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                Storage::disk('public')->delete($this->currentImage);
            }

            // Store new image
            $data['image'] = $this->newImage->store('testimonials', 'public');
            $this->currentImage = $data['image'];
            $this->newImage = null;
        }

        if ($this->isEditMode) {
            $this->testimonial->update($data);
            session()->flash('success', 'Testimonial updated successfully.');
            return redirect()->route('admin.testimonials.index');
        } else {
            Testimonial::create($data);
            session()->flash('success', 'Testimonial created successfully.');
            return redirect()->route('admin.testimonials.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.testimonial-form');
    }
}
