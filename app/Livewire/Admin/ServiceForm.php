<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceForm extends Component
{
    use WithFileUploads;

    public $serviceId;
    public $service;
    public $title;
    public $slug;
    public $description;
    public $newIcon;
    public $currentIcon;
    public $is_featured = false;
    public $order = 0;
    public $is_active = true;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:services,slug',
        'description' => 'required|string|max:1000',
        'newIcon' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,svg,webp',
        'is_featured' => 'boolean',
        'order' => 'nullable|integer|min:0',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'title.required' => 'The service title is required.',
        'slug.required' => 'The slug is required.',
        'slug.unique' => 'This slug is already in use.',
        'description.required' => 'The service description is required.',
        'description.max' => 'The description must not exceed 1000 characters.',
        'newIcon.image' => 'The icon must be an image.',
        'newIcon.max' => 'The icon must not be greater than 2MB.',
        'newIcon.mimes' => 'The icon must be a file of type: jpg, jpeg, png, svg, webp.',
    ];

    public function mount($serviceId = null)
    {
        if ($serviceId) {
            $this->isEditMode = true;
            $this->serviceId = $serviceId;
            $this->service = Service::findOrFail($serviceId);

            $this->title = $this->service->title;
            $this->slug = $this->service->slug;
            $this->description = $this->service->description;
            $this->is_featured = $this->service->is_featured;
            $this->order = $this->service->order ?? 0;
            $this->is_active = $this->service->is_active;
            $this->currentIcon = $this->service->icon;
        } else {
            // Get next order number
            $this->order = Service::max('order') + 1 ?? 1;
        }
    }

    public function updatedTitle()
    {
        if (!$this->isEditMode || empty($this->service->slug)) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function updatedNewIcon()
    {
        $this->validate([
            'newIcon' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,svg,webp',
        ]);
    }

    public function removeIcon()
    {
        if ($this->currentIcon && Storage::disk('public')->exists($this->currentIcon)) {
            Storage::disk('public')->delete($this->currentIcon);
        }

        if ($this->service) {
            $this->service->update(['icon' => null]);
        }

        $this->currentIcon = null;
        $this->newIcon = null;

        $this->dispatch('notify', message: 'Icon removed successfully.', type: 'success');
    }

    public function save()
    {
        // Check permissions
        if ($this->isEditMode) {
            // For editing, check if user has manage or edit permission
            if (!auth()->user()->hasPermission('manage_services') && !auth()->user()->hasPermission('edit_services')) {
                session()->flash('error', 'You do not have permission to edit services.');
                return redirect()->route('admin.services.index');
            }
        } else {
            // For creating, check if user has manage permission
            if (!auth()->user()->hasPermission('manage_services')) {
                session()->flash('error', 'You do not have permission to create services.');
                return redirect()->route('admin.services.index');
            }
        }

        // Update validation rules for edit mode
        if ($this->isEditMode) {
            $this->rules['slug'] = 'required|string|max:255|unique:services,slug,' . $this->serviceId;
        }

        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_featured' => $this->is_featured,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];

        // Handle icon upload
        if ($this->newIcon) {
            // Delete old icon if exists
            if ($this->currentIcon && Storage::disk('public')->exists($this->currentIcon)) {
                Storage::disk('public')->delete($this->currentIcon);
            }

            // Store new icon
            $data['icon'] = $this->newIcon->store('services', 'public');
            $this->currentIcon = $data['icon'];
            $this->newIcon = null;
        }

        if ($this->isEditMode) {
            $this->service->update($data);
            session()->flash('success', 'Service updated successfully.');
            return redirect()->route('admin.services.index');
        } else {
            Service::create($data);
            session()->flash('success', 'Service created successfully.');
            return redirect()->route('admin.services.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.service-form');
    }
}
