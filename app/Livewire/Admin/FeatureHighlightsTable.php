<?php

namespace App\Livewire\Admin;

use App\Models\FeatureHighlight;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class FeatureHighlightsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all';
    public $showDeleteModal = false;
    public $featureToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function toggleActive($featureId)
    {
        $feature = FeatureHighlight::findOrFail($featureId);
        $feature->update(['is_active' => !$feature->is_active]);

        $this->dispatch('notify', message: 'Feature status updated successfully.', type: 'success');
    }

    public function confirmDelete($featureId)
    {
        $this->featureToDelete = $featureId;
        $this->showDeleteModal = true;
    }

    public function deleteFeature()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_feature_highlights')) {
            $this->dispatch('notify', message: 'You do not have permission to delete feature highlights.', type: 'error');
            $this->featureToDelete = null;
            $this->showDeleteModal = false;
            return;
        }

        if ($this->featureToDelete) {
            $feature = FeatureHighlight::findOrFail($this->featureToDelete);

            // Delete icon if exists
            if ($feature->icon && Storage::disk('public')->exists($feature->icon)) {
                Storage::disk('public')->delete($feature->icon);
            }

            $feature->delete();

            $this->dispatch('notify', message: 'Feature highlight deleted successfully.', type: 'success');

            $this->featureToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->featureToDelete = null;
        $this->showDeleteModal = false;
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            FeatureHighlight::where('id', $item['value'])->update(['order' => $item['order']]);
        }

        $this->dispatch('notify', message: 'Feature highlights reordered successfully.', type: 'success');
    }

    public function render()
    {
        $query = FeatureHighlight::query();

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by status
        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $features = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.feature-highlights-table', compact('features'));
    }
}
