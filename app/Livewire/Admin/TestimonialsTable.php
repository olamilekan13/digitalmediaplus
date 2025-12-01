<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class TestimonialsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all';
    public $showDeleteModal = false;
    public $testimonialToDelete = null;
    public $selectedTestimonials = [];
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

    public function toggleActive($testimonialId)
    {
        $testimonial = Testimonial::findOrFail($testimonialId);
        $testimonial->update(['is_active' => !$testimonial->is_active]);

        $this->dispatch('notify', message: 'Testimonial status updated successfully.', type: 'success');
    }

    public function confirmDelete($testimonialId)
    {
        $this->testimonialToDelete = $testimonialId;
        $this->showDeleteModal = true;
    }

    public function deleteTestimonial()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_testimonials')) {
            $this->dispatch('notify', message: 'You do not have permission to delete testimonials.', type: 'error');
            $this->testimonialToDelete = null;
            $this->showDeleteModal = false;
            return;
        }

        if ($this->testimonialToDelete) {
            $testimonial = Testimonial::findOrFail($this->testimonialToDelete);

            // Delete image if exists
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }

            $testimonial->delete();

            $this->dispatch('notify', message: 'Testimonial deleted successfully.', type: 'success');

            $this->testimonialToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->testimonialToDelete = null;
        $this->showDeleteModal = false;
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            Testimonial::where('id', $item['value'])->update(['order' => $item['order']]);
        }

        $this->dispatch('notify', message: 'Testimonials reordered successfully.', type: 'success');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedTestimonials = $this->getFilteredTestimonials()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedTestimonials = [];
        }
    }

    public function bulkDelete()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_testimonials')) {
            $this->dispatch('notify', message: 'You do not have permission to delete testimonials.', type: 'error');
            return;
        }

        if (empty($this->selectedTestimonials)) {
            $this->dispatch('notify', message: 'Please select testimonials to delete.', type: 'error');
            return;
        }

        $testimonials = Testimonial::whereIn('id', $this->selectedTestimonials)->get();

        foreach ($testimonials as $testimonial) {
            // Delete image if exists
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $testimonial->delete();
        }

        $count = count($this->selectedTestimonials);
        $this->selectedTestimonials = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} testimonial(s) deleted successfully.", type: 'success');
    }

    public function bulkActivate()
    {
        if (empty($this->selectedTestimonials)) {
            $this->dispatch('notify', message: 'Please select testimonials to activate.', type: 'error');
            return;
        }

        Testimonial::whereIn('id', $this->selectedTestimonials)->update(['is_active' => true]);

        $count = count($this->selectedTestimonials);
        $this->selectedTestimonials = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} testimonial(s) activated successfully.", type: 'success');
    }

    public function bulkDeactivate()
    {
        if (empty($this->selectedTestimonials)) {
            $this->dispatch('notify', message: 'Please select testimonials to deactivate.', type: 'error');
            return;
        }

        Testimonial::whereIn('id', $this->selectedTestimonials)->update(['is_active' => false]);

        $count = count($this->selectedTestimonials);
        $this->selectedTestimonials = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} testimonial(s) deactivated successfully.", type: 'success');
    }

    private function getFilteredTestimonials()
    {
        $query = Testimonial::query();

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('role', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
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
        $query = Testimonial::query();

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('role', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by status
        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $testimonials = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.testimonials-table', compact('testimonials'));
    }
}
