<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class AdminsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $showDeleteModal = false;
    public $userToDelete = null;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($userId)
    {
        $this->userToDelete = User::findOrFail($userId);
        $this->showDeleteModal = true;
    }

    public function deleteUser()
    {
        if ($this->userToDelete) {
            // Prevent deleting yourself
            if ($this->userToDelete->id === auth()->id()) {
                $this->dispatch('notify', message: 'You cannot delete your own account.', type: 'error');
                $this->closeDeleteModal();
                return;
            }

            $this->userToDelete->delete();
            $this->dispatch('notify', message: 'Admin user deleted successfully.', type: 'success');
            $this->closeDeleteModal();
        }
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->userToDelete = null;
    }

    public function render()
    {
        $query = User::where('is_admin', true)
            ->orWhereHas('role')
            ->with('role');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->whereHas('role', function ($q) {
                $q->where('slug', $this->roleFilter);
            });
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(10);
        $roles = Role::where('is_active', true)->orderBy('name')->get();

        return view('livewire.admin.admins-table', [
            'admins' => $admins,
            'roles' => $roles,
        ]);
    }
}
