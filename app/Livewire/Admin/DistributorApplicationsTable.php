<?php

namespace App\Livewire\Admin;

use App\Models\DistributorApplication;
use Livewire\Component;
use Livewire\WithPagination;

class DistributorApplicationsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all';
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $selectedApplication = null;
    public $applicationToDelete = null;
    public $selectedApplications = [];
    public $selectAll = false;
    public $adminNotes = '';

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

    public function viewApplication($applicationId)
    {
        $this->selectedApplication = DistributorApplication::findOrFail($applicationId);
        $this->adminNotes = $this->selectedApplication->admin_notes ?? '';
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedApplication = null;
        $this->adminNotes = '';
    }

    public function saveNotes()
    {
        if ($this->selectedApplication) {
            $this->selectedApplication->update(['admin_notes' => $this->adminNotes]);
            $this->dispatch('notify', message: 'Notes saved successfully.', type: 'success');
        }
    }

    public function saveAdminNotes()
    {
        if ($this->selectedApplication) {
            $this->selectedApplication->update(['admin_notes' => $this->adminNotes]);
            $this->dispatch('notify', message: 'Admin notes saved successfully.', type: 'success');
        }
    }

    public function toggleReviewed($applicationId)
    {
        $application = DistributorApplication::findOrFail($applicationId);
        $application->update(['is_reviewed' => !$application->is_reviewed]);
        $this->dispatch('notify', message: 'Application status updated successfully.', type: 'success');
    }

    public function confirmDelete($applicationId)
    {
        $this->applicationToDelete = $applicationId;
        $this->showDeleteModal = true;
    }

    public function deleteApplication()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_contact_messages')) {
            $this->dispatch('notify', message: 'You do not have permission to delete applications.', type: 'error');
            $this->applicationToDelete = null;
            $this->showDeleteModal = false;
            return;
        }

        if ($this->applicationToDelete) {
            DistributorApplication::findOrFail($this->applicationToDelete)->delete();
            $this->dispatch('notify', message: 'Application deleted successfully.', type: 'success');
        }

        $this->showDeleteModal = false;
        $this->applicationToDelete = null;
    }

    public function markAllAsReviewed()
    {
        DistributorApplication::where('is_reviewed', false)->update(['is_reviewed' => true]);
        $this->dispatch('notify', message: 'All applications marked as reviewed.', type: 'success');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedApplications = $this->getFilteredApplications()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedApplications = [];
        }
    }

    public function bulkDelete()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_contact_messages')) {
            $this->dispatch('notify', message: 'You do not have permission to delete applications.', type: 'error');
            return;
        }

        if (empty($this->selectedApplications)) {
            $this->dispatch('notify', message: 'Please select applications to delete.', type: 'error');
            return;
        }

        DistributorApplication::whereIn('id', $this->selectedApplications)->delete();

        $count = count($this->selectedApplications);
        $this->selectedApplications = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} application(s) deleted successfully.", type: 'success');
    }

    public function bulkMarkAsReviewed()
    {
        if (empty($this->selectedApplications)) {
            $this->dispatch('notify', message: 'Please select applications to mark as reviewed.', type: 'error');
            return;
        }

        DistributorApplication::whereIn('id', $this->selectedApplications)->update(['is_reviewed' => true]);

        $count = count($this->selectedApplications);
        $this->selectedApplications = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} application(s) marked as reviewed.", type: 'success');
    }

    public function bulkMarkAsUnreviewed()
    {
        if (empty($this->selectedApplications)) {
            $this->dispatch('notify', message: 'Please select applications to mark as unreviewed.', type: 'error');
            return;
        }

        DistributorApplication::whereIn('id', $this->selectedApplications)->update(['is_reviewed' => false]);

        $count = count($this->selectedApplications);
        $this->selectedApplications = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} application(s) marked as unreviewed.", type: 'success');
    }

    private function getFilteredApplications()
    {
        $query = DistributorApplication::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('full_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('business_name', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%')
                  ->orWhere('state', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'reviewed') {
            $query->where('is_reviewed', true);
        } elseif ($this->filterStatus === 'unreviewed') {
            $query->where('is_reviewed', false);
        }

        return $query->latest()->get();
    }

    public function render()
    {
        $query = DistributorApplication::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('full_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('business_name', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%')
                  ->orWhere('state', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'reviewed') {
            $query->where('is_reviewed', true);
        } elseif ($this->filterStatus === 'unreviewed') {
            $query->where('is_reviewed', false);
        }

        $applications = $query->latest()->paginate(10);
        $unreviewedCount = DistributorApplication::where('is_reviewed', false)->count();

        return view('livewire.admin.distributor-applications-table', compact('applications', 'unreviewedCount'));
    }
}
