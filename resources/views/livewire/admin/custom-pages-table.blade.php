<div>
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-file-alt mr-3"></i>
                        Custom Pages Management
                    </h2>
                    <p class="text-purple-100 mt-1">Create and manage dynamic custom pages</p>
                </div>
                @if(auth()->user()->hasPermission('manage_pages'))
                <a href="{{ route('admin.custom-pages.create') }}"
                   class="bg-white text-purple-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-purple-50 transition flex items-center shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Create Page
                </a>
                @endif
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i> Search Pages
                    </label>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search by title or slug..."
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>

                <!-- Filter by Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-filter mr-1"></i> Filter by Status
                    </label>
                    <select wire:model.live="filterStatus"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="all">All Pages</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </select>
                </div>
            </div>

            <!-- Bulk Actions -->
            @if(count($selectedPages) > 0)
                <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <span class="text-sm font-medium text-blue-900">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ count($selectedPages) }} page(s) selected
                    </span>
                    <div class="flex items-center space-x-2">
                        <button wire:click="bulkActivate"
                                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-check mr-1"></i> Activate
                        </button>
                        <button wire:click="bulkDeactivate"
                                class="px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition">
                            <i class="fas fa-ban mr-1"></i> Deactivate
                        </button>
                        @if(auth()->user()->hasPermission('manage_pages'))
                        <button wire:click="bulkDelete"
                                class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition"
                                onclick="return confirm('Are you sure you want to delete the selected pages?')">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Pages Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($pages->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox"
                                       wire:model.live="selectAll"
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Slug
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pages as $page)
                            <tr class="hover:bg-gray-50 transition">
                                <!-- Checkbox -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                           wire:model.live="selectedPages"
                                           value="{{ $page->id }}"
                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                                </td>

                                <!-- Title -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $page->title }}</div>
                                    <div class="text-sm text-gray-500">Created {{ $page->created_at->diffForHumans() }}</div>
                                </td>

                                <!-- Slug -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="px-2 py-1 bg-gray-100 text-purple-600 rounded text-sm">{{ $page->slug }}</code>
                                </td>

                                <!-- Status Toggle -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button wire:click="toggleActive({{ $page->id }})"
                                            class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 {{ $page->is_active ? 'bg-green-600' : 'bg-gray-200' }}">
                                        <span class="sr-only">Toggle active status</span>
                                        <span class="inline-block w-4 h-4 transform transition-transform bg-white rounded-full {{ $page->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('page.show', $page->slug) }}"
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-900 transition"
                                           title="View Page">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->hasPermission('manage_pages'))
                                        <a href="{{ route('admin.custom-pages.edit', $page->id) }}"
                                           class="text-indigo-600 hover:text-indigo-900 transition"
                                           title="Edit Page">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="confirmDelete({{ $page->id }})"
                                                class="text-red-600 hover:text-red-900 transition"
                                                title="Delete Page">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $pages->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-file-alt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No custom pages found</h3>
                <p class="text-gray-500 mb-6">
                    @if($search || $filterStatus !== 'all')
                        Try adjusting your search or filter criteria.
                    @else
                        Get started by creating your first custom page.
                    @endif
                </p>
                @if(auth()->user()->hasPermission('manage_pages') && !$search && $filterStatus === 'all')
                <a href="{{ route('admin.custom-pages.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Page
                </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Delete Custom Page</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Are you sure you want to delete this page? All sections and content will be permanently removed.
                    </p>
                    <div class="flex space-x-3">
                        <button wire:click="cancelDelete"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button wire:click="deletePage"
                                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Delete Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
