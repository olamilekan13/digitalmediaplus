<?php

namespace App\Livewire\Admin;

use App\Models\Statistic;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class StatisticForm extends Component
{
    use WithFileUploads;

    public $statisticId;
    public $statistic;
    public $label;
    public $percentage;
    public $newIcon;
    public $currentIcon;
    public $order = 0;
    public $is_active = true;
    public $isEditMode = false;

    protected $rules = [
        'label' => 'required|string|max:255',
        'percentage' => 'required|integer|min:0|max:100',
        'newIcon' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,svg,webp',
        'order' => 'nullable|integer|min:0',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'label.required' => 'The statistic label is required.',
        'label.max' => 'The label must not exceed 255 characters.',
        'percentage.required' => 'The percentage value is required.',
        'percentage.integer' => 'The percentage must be a number.',
        'percentage.min' => 'The percentage must be at least 0.',
        'percentage.max' => 'The percentage must not exceed 100.',
        'newIcon.image' => 'The icon must be an image.',
        'newIcon.max' => 'The icon must not be greater than 2MB.',
        'newIcon.mimes' => 'The icon must be a file of type: jpg, jpeg, png, svg, webp.',
        'order.integer' => 'The order must be a number.',
        'order.min' => 'The order must be at least 0.',
    ];

    public function mount($statisticId = null)
    {
        if ($statisticId) {
            $this->isEditMode = true;
            $this->statisticId = $statisticId;
            $this->statistic = Statistic::findOrFail($statisticId);

            $this->label = $this->statistic->label;
            $this->percentage = $this->statistic->percentage;
            $this->order = $this->statistic->order ?? 0;
            $this->is_active = $this->statistic->is_active;
            $this->currentIcon = $this->statistic->icon;
        } else {
            // Get next order number
            $this->order = Statistic::max('order') + 1 ?? 1;
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

        if ($this->statistic) {
            $this->statistic->update(['icon' => null]);
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
            if (!auth()->user()->hasPermission('manage_statistics') && !auth()->user()->hasPermission('edit_statistics')) {
                session()->flash('error', 'You do not have permission to edit statistics.');
                return redirect()->route('admin.statistics.index');
            }
        } else {
            // For creating, check if user has manage permission
            if (!auth()->user()->hasPermission('manage_statistics')) {
                session()->flash('error', 'You do not have permission to create statistics.');
                return redirect()->route('admin.statistics.index');
            }
        }

        $this->validate();

        $data = [
            'label' => $this->label,
            'percentage' => $this->percentage,
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
            $data['icon'] = $this->newIcon->store('statistics', 'public');
            $this->currentIcon = $data['icon'];
            $this->newIcon = null;
        }

        if ($this->isEditMode) {
            $this->statistic->update($data);
            session()->flash('success', 'Statistic updated successfully.');
            return redirect()->route('admin.statistics.index');
        } else {
            Statistic::create($data);
            session()->flash('success', 'Statistic created successfully.');
            return redirect()->route('admin.statistics.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.statistic-form');
    }
}
