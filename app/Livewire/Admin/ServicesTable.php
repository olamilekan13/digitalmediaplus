<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ServicesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all';
    public $showDeleteModal = false;
    public $serviceToDelete = null;
    public $selectedServices = [];
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

    public function toggleActive($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $service->update(['is_active' => !$service->is_active]);

        $this->dispatch('notify', message: 'Service status updated successfully.', type: 'success');
    }

    public function toggleFeatured($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $service->update(['is_featured' => !$service->is_featured]);

        $this->dispatch('notify', message: 'Service featured status updated successfully.', type: 'success');
    }

    public function confirmDelete($serviceId)
    {
        $this->serviceToDelete = $serviceId;
        $this->showDeleteModal = true;
    }

    public function deleteService()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_services')) {
            $this->dispatch('notify', message: 'You do not have permission to delete services.', type: 'error');
            $this->serviceToDelete = null;
            $this->showDeleteModal = false;
            return;
        }

        if ($this->serviceToDelete) {
            $service = Service::findOrFail($this->serviceToDelete);

            // Delete icon if exists
            if ($service->icon && Storage::disk('public')->exists($service->icon)) {
                Storage::disk('public')->delete($service->icon);
            }

            $service->delete();

            $this->dispatch('notify', message: 'Service deleted successfully.', type: 'success');

            $this->serviceToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->serviceToDelete = null;
        $this->showDeleteModal = false;
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            Service::where('id', $item['value'])->update(['order' => $item['order']]);
        }

        $this->dispatch('notify', message: 'Services reordered successfully.', type: 'success');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedServices = $this->getFilteredServices()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedServices = [];
        }
    }

    public function bulkDelete()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_services')) {
            $this->dispatch('notify', message: 'You do not have permission to delete services.', type: 'error');
            return;
        }

        if (empty($this->selectedServices)) {
            $this->dispatch('notify', message: 'Please select services to delete.', type: 'error');
            return;
        }

        $services = Service::whereIn('id', $this->selectedServices)->get();

        foreach ($services as $service) {
            // Delete icon if exists
            if ($service->icon && Storage::disk('public')->exists($service->icon)) {
                Storage::disk('public')->delete($service->icon);
            }
            $service->delete();
        }

        $count = count($this->selectedServices);
        $this->selectedServices = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} service(s) deleted successfully.", type: 'success');
    }

    public function bulkActivate()
    {
        if (empty($this->selectedServices)) {
            $this->dispatch('notify', message: 'Please select services to activate.', type: 'error');
            return;
        }

        Service::whereIn('id', $this->selectedServices)->update(['is_active' => true]);

        $count = count($this->selectedServices);
        $this->selectedServices = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} service(s) activated successfully.", type: 'success');
    }

    public function bulkDeactivate()
    {
        if (empty($this->selectedServices)) {
            $this->dispatch('notify', message: 'Please select services to deactivate.', type: 'error');
            return;
        }

        Service::whereIn('id', $this->selectedServices)->update(['is_active' => false]);

        $count = count($this->selectedServices);
        $this->selectedServices = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} service(s) deactivated successfully.", type: 'success');
    }

    private function getFilteredServices()
    {
        $query = Service::query();

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
        } elseif ($this->filterStatus === 'featured') {
            $query->where('is_featured', true);
        }

        return $query->orderBy('order')->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        $query = Service::query();

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
        } elseif ($this->filterStatus === 'featured') {
            $query->where('is_featured', true);
        }

        $services = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.services-table', compact('services'));
    }
}
