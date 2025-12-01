<?php

namespace App\Livewire\Admin;

use App\Models\Faq;
use Livewire\Component;
use Livewire\WithPagination;

class FaqsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all';
    public $showDeleteModal = false;
    public $faqToDelete = null;
    public $selectedFaqs = [];
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

    public function toggleActive($faqId)
    {
        $faq = Faq::findOrFail($faqId);
        $faq->update(['is_active' => !$faq->is_active]);

        $this->dispatch('notify', message: 'FAQ status updated successfully.', type: 'success');
    }

    public function confirmDelete($faqId)
    {
        $this->faqToDelete = $faqId;
        $this->showDeleteModal = true;
    }

    public function deleteFaq()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_faqs')) {
            $this->dispatch('notify', message: 'You do not have permission to delete FAQs.', type: 'error');
            $this->faqToDelete = null;
            $this->showDeleteModal = false;
            return;
        }

        if ($this->faqToDelete) {
            $faq = Faq::findOrFail($this->faqToDelete);
            $faq->delete();

            $this->dispatch('notify', message: 'FAQ deleted successfully.', type: 'success');

            $this->faqToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->faqToDelete = null;
        $this->showDeleteModal = false;
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            Faq::where('id', $item['value'])->update(['order' => $item['order']]);
        }

        $this->dispatch('notify', message: 'FAQs reordered successfully.', type: 'success');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedFaqs = $this->getFilteredFaqs()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedFaqs = [];
        }
    }

    public function bulkDelete()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_faqs')) {
            $this->dispatch('notify', message: 'You do not have permission to delete FAQs.', type: 'error');
            return;
        }

        if (empty($this->selectedFaqs)) {
            $this->dispatch('notify', message: 'Please select FAQs to delete.', type: 'error');
            return;
        }

        Faq::whereIn('id', $this->selectedFaqs)->delete();

        $count = count($this->selectedFaqs);
        $this->selectedFaqs = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} FAQ(s) deleted successfully.", type: 'success');
    }

    public function bulkActivate()
    {
        if (empty($this->selectedFaqs)) {
            $this->dispatch('notify', message: 'Please select FAQs to activate.', type: 'error');
            return;
        }

        Faq::whereIn('id', $this->selectedFaqs)->update(['is_active' => true]);

        $count = count($this->selectedFaqs);
        $this->selectedFaqs = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} FAQ(s) activated successfully.", type: 'success');
    }

    public function bulkDeactivate()
    {
        if (empty($this->selectedFaqs)) {
            $this->dispatch('notify', message: 'Please select FAQs to deactivate.', type: 'error');
            return;
        }

        Faq::whereIn('id', $this->selectedFaqs)->update(['is_active' => false]);

        $count = count($this->selectedFaqs);
        $this->selectedFaqs = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} FAQ(s) deactivated successfully.", type: 'success');
    }

    private function getFilteredFaqs()
    {
        $query = Faq::query();

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('question', 'like', '%' . $this->search . '%')
                  ->orWhere('answer', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by status
        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        return $query->orderBy('order')->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        $query = Faq::query();

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('question', 'like', '%' . $this->search . '%')
                  ->orWhere('answer', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by status
        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $faqs = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.faqs-table', compact('faqs'));
    }
}
