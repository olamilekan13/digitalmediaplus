<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-{{ $userId ? 'edit' : 'user-plus' }} mr-3"></i>
                {{ $userId ? 'Edit Admin User' : 'Create New Admin User' }}
            </h2>
            <p class="text-purple-100 mt-1">
                {{ $userId ? 'Update admin user details and access level' : 'Add a new admin user with specific access permissions' }}
            </p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="save" class="p-6 space-y-8">
            <!-- User Information -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user mr-2 text-purple-600"></i>
                    User Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               wire:model="name"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('name') border-red-500 @enderror"
                               placeholder="John Doe">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               id="email"
                               wire:model="email"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('email') border-red-500 @enderror"
                               placeholder="john.doe@example.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Password Section -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-lock mr-2 text-purple-600"></i>
                    Password
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password {{ $userId ? '(Leave blank to keep current)' : '' }} <span class="text-red-500">{{ $userId ? '' : '*' }}</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password"
                                   wire:model="password"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 pr-10 @error('password') border-red-500 @enderror"
                                   placeholder="••••••••">
                            <button type="button"
                                    onclick="togglePasswordVisibility('password', 'password-eye')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i id="password-eye" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Minimum 8 characters
                        </p>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password {{ $userId ? '(Leave blank to keep current)' : '' }} <span class="text-red-500">{{ $userId ? '' : '*' }}</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password_confirmation"
                                   wire:model="password_confirmation"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 pr-10"
                                   placeholder="••••••••">
                            <button type="button"
                                    onclick="togglePasswordVisibility('password_confirmation', 'password-confirmation-eye')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i id="password-confirmation-eye" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Access Level -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-shield-alt mr-2 text-purple-600"></i>
                    Access Level
                </h3>

                <div class="space-y-6">
                    <!-- Admin Status -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <label for="is_admin" class="block text-sm font-medium text-gray-700">
                                Admin Status
                            </label>
                            <p class="text-sm text-gray-500 mt-1">
                                Grant admin access to this user
                            </p>
                        </div>
                        <div class="ml-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       id="is_admin"
                                       wire:model="is_admin"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-tag mr-1"></i> Role
                        </label>
                        <select id="role_id"
                                wire:model="role_id"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 @error('role_id') border-red-500 @enderror">
                            <option value="">Select a role (Optional)</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }} - {{ $role->description }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Select a role to assign specific permissions. If no role is selected, the user will have basic admin access.
                        </p>

                        @if($role_id)
                            @php
                                $selectedRole = $roles->firstWhere('id', $role_id);
                            @endphp
                            @if($selectedRole && $selectedRole->permissions)
                                <div class="mt-4 p-4 bg-purple-50 rounded-lg border border-purple-200">
                                    <p class="text-sm font-medium text-purple-900 mb-2">
                                        <i class="fas fa-key mr-1"></i> Permissions for {{ $selectedRole->name }}:
                                    </p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($selectedRole->permissions as $permission)
                                            <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded">
                                                {{ str_replace('_', ' ', $permission) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.admin-users.index') }}"
                   class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>

                <button type="submit"
                        wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save mr-2"></i>
                        {{ $userId ? 'Update Admin' : 'Create Admin' }}
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        {{ $userId ? 'Updating...' : 'Creating...' }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
