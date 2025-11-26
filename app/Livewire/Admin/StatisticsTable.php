<?php

namespace App\Livewire\Admin;

use App\Models\Statistic;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class StatisticsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all';
    public $showDeleteModal = false;
    public $statisticToDelete = null;

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

    public function toggleActive($statisticId)
    {
        $statistic = Statistic::findOrFail($statisticId);
        $statistic->update(['is_active' => !$statistic->is_active]);

        $this->dispatch('notify', message: 'Statistic status updated successfully.', type: 'success');
    }

    public function confirmDelete($statisticId)
    {
        $this->statisticToDelete = $statisticId;
        $this->showDeleteModal = true;
    }

    public function deleteStatistic()
    {
        if ($this->statisticToDelete) {
            $statistic = Statistic::findOrFail($this->statisticToDelete);

            // Delete icon if exists
            if ($statistic->icon && Storage::disk('public')->exists($statistic->icon)) {
                Storage::disk('public')->delete($statistic->icon);
            }

            $statistic->delete();

            $this->dispatch('notify', message: 'Statistic deleted successfully.', type: 'success');

            $this->statisticToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->statisticToDelete = null;
        $this->showDeleteModal = false;
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            Statistic::where('id', $item['value'])->update(['order' => $item['order']]);
        }

        $this->dispatch('notify', message: 'Statistics reordered successfully.', type: 'success');
    }

    public function render()
    {
        $query = Statistic::query();

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('label', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by status
        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $statistics = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.statistics-table', compact('statistics'));
    }
}
