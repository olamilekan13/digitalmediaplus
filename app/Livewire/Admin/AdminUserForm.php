<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserForm extends Component
{
    public $userId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role_id = '';
    public $is_admin = true;

    protected $rules = [
        'name' => 'required|string|max:255|min:2',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role_id' => 'nullable|exists:roles,id',
        'is_admin' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'The name field is required.',
        'name.min' => 'Name must be at least 2 characters.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'password.required' => 'The password field is required.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
        'role_id.exists' => 'Please select a valid role.',
    ];

    public function mount($userId = null)
    {
        if ($userId) {
            $this->userId = $userId;
            $user = User::findOrFail($userId);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role_id = $user->role_id;
            $this->is_admin = $user->is_admin;

            // Update validation rules for edit
            $this->rules['email'] = ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId)];
            $this->rules['password'] = 'nullable|string|min:8|confirmed';
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'role_id' => $this->role_id ?: null,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $user->update($data);
            $message = 'Admin user updated successfully.';
        } else {
            User::create($data);
            $message = 'Admin user created successfully.';
        }

        $this->dispatch('notify', message: $message, type: 'success');
        return redirect()->route('admin.admin-users.index');
    }

    public function render()
    {
        $roles = Role::where('is_active', true)->orderBy('name')->get();
        return view('livewire.admin.admin-user-form', [
            'roles' => $roles,
        ]);
    }
}
