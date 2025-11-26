<?php

namespace App\Livewire\Admin;

use App\Models\FeatureHighlight;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class FeatureHighlightForm extends Component
{
    use WithFileUploads;

    public $featureId;
    public $feature;
    public $title;
    public $description;
    public $newIcon;
    public $currentIcon;
    public $order = 0;
    public $is_active = true;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'newIcon' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,svg,webp',
        'order' => 'nullable|integer|min:0',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'title.required' => 'The feature title is required.',
        'title.max' => 'The title must not exceed 255 characters.',
        'description.required' => 'The feature description is required.',
        'description.max' => 'The description must not exceed 1000 characters.',
        'newIcon.image' => 'The icon must be an image.',
        'newIcon.max' => 'The icon must not be greater than 2MB.',
        'newIcon.mimes' => 'The icon must be a file of type: jpg, jpeg, png, svg, webp.',
        'order.integer' => 'The order must be a number.',
        'order.min' => 'The order must be at least 0.',
    ];

    public function mount($featureId = null)
    {
        if ($featureId) {
            $this->isEditMode = true;
            $this->featureId = $featureId;
            $this->feature = FeatureHighlight::findOrFail($featureId);

            $this->title = $this->feature->title;
            $this->description = $this->feature->description;
            $this->order = $this->feature->order ?? 0;
            $this->is_active = $this->feature->is_active;
            $this->currentIcon = $this->feature->icon;
        } else {
            // Get next order number
            $this->order = FeatureHighlight::max('order') + 1 ?? 1;
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

        if ($this->feature) {
            $this->feature->update(['icon' => null]);
        }

        $this->currentIcon = null;
        $this->newIcon = null;

        $this->dispatch('notify', message: 'Icon removed successfully.', type: 'success');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
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
            $data['icon'] = $this->newIcon->store('features', 'public');
            $this->currentIcon = $data['icon'];
            $this->newIcon = null;
        }

        if ($this->isEditMode) {
            $this->feature->update($data);
            session()->flash('success', 'Feature highlight updated successfully.');
            return redirect()->route('admin.feature-highlights.index');
        } else {
            FeatureHighlight::create($data);
            session()->flash('success', 'Feature highlight created successfully.');
            return redirect()->route('admin.feature-highlights.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.feature-highlight-form');
    }
}
