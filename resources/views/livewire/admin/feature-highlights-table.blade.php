<div>
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-orange-600 to-yellow-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-star mr-3"></i>
                        Feature Highlights Management
                    </h2>
                    <p class="text-orange-100 mt-1">Manage your feature highlight cards</p>
                </div>
                @if(auth()->user()->hasPermission('manage_feature_highlights'))
                <a href="{{ route('admin.feature-highlights.create') }}"
                   class="bg-white text-orange-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-orange-50 transition flex items-center shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Create Feature
                </a>
                @endif
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i> Search Features
                    </label>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search by title or description..."
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>

                <!-- Filter by Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-filter mr-1"></i> Filter by Status
                    </label>
                    <select wire:model.live="filterStatus"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <option value="all">All Features</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($features->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Icon
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
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
                        @foreach($features as $feature)
                            <tr class="hover:bg-gray-50 transition">
                                <!-- Order -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-700 rounded-full font-semibold text-sm">
                                        {{ $feature->order ?? '-' }}
                                    </span>
                                </td>

                                <!-- Icon -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($feature->icon)
                                        @if(Str::startsWith($feature->icon, 'fa-'))
                                            <div class="w-12 h-12 bg-gradient-to-br from-orange-50 to-yellow-50 rounded-lg flex items-center justify-center border border-orange-200">
                                                <i class="fas {{ $feature->icon }} text-orange-600 text-2xl"></i>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($feature->icon) }}"
                                                 alt="{{ $feature->title }}"
                                                 class="w-12 h-12 object-contain rounded border border-gray-200">
                                        @endif
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>

                                <!-- Title -->
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900">{{ $feature->title }}</span>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600 line-clamp-2 max-w-md">
                                        {{ Str::limit($feature->description, 100) }}
                                    </p>
                                </td>

                                <!-- Status Toggle -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if(auth()->user()->hasPermission('manage_feature_highlights') || auth()->user()->hasPermission('edit_feature_highlights'))
                                    <button wire:click="toggleActive({{ $feature->id }})"
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition {{ $feature->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        {{ $feature->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $feature->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        {{ $feature->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        @if(auth()->user()->hasPermission('manage_feature_highlights') || auth()->user()->hasPermission('edit_feature_highlights'))
                                        <a href="{{ route('admin.feature-highlights.edit', $feature->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition"
                                           title="Edit">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('manage_feature_highlights'))
                                        <button wire:click="confirmDelete({{ $feature->id }})"
                                                class="text-red-600 hover:text-red-900 transition"
                                                title="Delete">
                                            <i class="fas fa-trash text-lg"></i>
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
                {{ $features->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No feature highlights found</h3>
                <p class="text-gray-500 mb-6">
                    @if($search || $filterStatus !== 'all')
                        Try adjusting your search or filter to find what you're looking for.
                    @else
                        Get started by creating your first feature highlight.
                    @endif
                </p>
                @if(!$search && $filterStatus === 'all' && auth()->user()->hasPermission('manage_feature_highlights'))
                    <a href="{{ route('admin.feature-highlights.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First Feature
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center"
             x-data
             @click.self="$wire.cancelDelete()">
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                        Confirm Deletion
                    </h3>
                    <button wire:click="cancelDelete"
                            class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <p class="text-gray-600">
                        Are you sure you want to delete this feature highlight? This action cannot be undone and will also delete the icon if present.
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 px-6 py-4 border-t border-gray-200">
                    <button wire:click="cancelDelete"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button wire:click="deleteFeature"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Feature
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
