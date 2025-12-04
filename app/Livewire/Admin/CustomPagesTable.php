<?php

namespace App\Livewire\Admin;

use App\Models\CustomPage;
use Livewire\Component;
use Livewire\WithPagination;

class CustomPagesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all';
    public $showDeleteModal = false;
    public $pageToDelete = null;
    public $selectedPages = [];
    public $selectAll = false;

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

    public function toggleActive($pageId)
    {
        $page = CustomPage::findOrFail($pageId);
        $page->update(['is_active' => !$page->is_active]);

        $this->dispatch('notify', message: 'Page status updated successfully.', type: 'success');
    }

    public function confirmDelete($pageId)
    {
        $this->pageToDelete = $pageId;
        $this->showDeleteModal = true;
    }

    public function deletePage()
    {
        if (!auth()->user()->hasPermission('manage_pages')) {
            $this->dispatch('notify', message: 'You do not have permission to delete pages.', type: 'error');
            $this->pageToDelete = null;
            $this->showDeleteModal = false;
            return;
        }

        if ($this->pageToDelete) {
            $page = CustomPage::findOrFail($this->pageToDelete);
            $page->delete();

            $this->dispatch('notify', message: 'Page deleted successfully.', type: 'success');

            $this->pageToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->pageToDelete = null;
        $this->showDeleteModal = false;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPages = $this->getFilteredPages()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedPages = [];
        }
    }

    public function bulkDelete()
    {
        if (!auth()->user()->hasPermission('manage_pages')) {
            $this->dispatch('notify', message: 'You do not have permission to delete pages.', type: 'error');
            return;
        }

        if (empty($this->selectedPages)) {
            $this->dispatch('notify', message: 'Please select pages to delete.', type: 'error');
            return;
        }

        CustomPage::whereIn('id', $this->selectedPages)->delete();

        $count = count($this->selectedPages);
        $this->selectedPages = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} page(s) deleted successfully.", type: 'success');
    }

    public function bulkActivate()
    {
        if (empty($this->selectedPages)) {
            $this->dispatch('notify', message: 'Please select pages to activate.', type: 'error');
            return;
        }

        CustomPage::whereIn('id', $this->selectedPages)->update(['is_active' => true]);

        $count = count($this->selectedPages);
        $this->selectedPages = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} page(s) activated successfully.", type: 'success');
    }

    public function bulkDeactivate()
    {
        if (empty($this->selectedPages)) {
            $this->dispatch('notify', message: 'Please select pages to deactivate.', type: 'error');
            return;
        }

        CustomPage::whereIn('id', $this->selectedPages)->update(['is_active' => false]);

        $count = count($this->selectedPages);
        $this->selectedPages = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} page(s) deactivated successfully.", type: 'success');
    }

    private function getFilteredPages()
    {
        $query = CustomPage::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        $query = CustomPage::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $pages = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.custom-pages-table', compact('pages'));
    }
}
