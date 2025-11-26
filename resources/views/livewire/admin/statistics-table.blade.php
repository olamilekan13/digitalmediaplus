<div>
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-chart-line mr-3"></i>
                        Statistics Management
                    </h2>
                    <p class="text-cyan-100 mt-1">Manage your performance metrics and statistics</p>
                </div>
                <a href="{{ route('admin.statistics.create') }}"
                   class="bg-white text-cyan-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-cyan-50 transition flex items-center shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Create Statistic
                </a>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i> Search Statistics
                    </label>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search by label..."
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                </div>

                <!-- Filter by Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-filter mr-1"></i> Filter by Status
                    </label>
                    <select wire:model.live="filterStatus"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        <option value="all">All Statistics</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($statistics->count() > 0)
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
                                Label
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Percentage
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
                        @foreach($statistics as $statistic)
                            <tr class="hover:bg-gray-50 transition">
                                <!-- Order -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-700 rounded-full font-semibold text-sm">
                                        {{ $statistic->order ?? '-' }}
                                    </span>
                                </td>

                                <!-- Icon -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($statistic->icon)
                                        @if(Str::startsWith($statistic->icon, 'fa-'))
                                            <div class="w-12 h-12 bg-gradient-to-br from-cyan-50 to-blue-50 rounded-lg flex items-center justify-center border border-cyan-200">
                                                <i class="fas {{ $statistic->icon }} text-cyan-600 text-2xl"></i>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($statistic->icon) }}"
                                                 alt="{{ $statistic->label }}"
                                                 class="w-12 h-12 object-contain rounded border border-gray-200">
                                        @endif
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>

                                <!-- Label -->
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900">{{ $statistic->label }}</span>
                                </td>

                                <!-- Percentage with Progress Bar -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-full max-w-xs bg-gray-200 rounded-full h-2.5 mb-2">
                                            <div class="bg-cyan-600 h-2.5 rounded-full transition-all duration-300"
                                                 style="width: {{ $statistic->percentage }}%"></div>
                                        </div>
                                        <span class="text-sm font-bold text-cyan-700">{{ $statistic->percentage }}%</span>
                                    </div>
                                </td>

                                <!-- Status Toggle -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button wire:click="toggleActive({{ $statistic->id }})"
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition {{ $statistic->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        {{ $statistic->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.statistics.edit', $statistic->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition"
                                           title="Edit">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <button wire:click="confirmDelete({{ $statistic->id }})"
                                                class="text-red-600 hover:text-red-900 transition"
                                                title="Delete">
                                            <i class="fas fa-trash text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $statistics->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No statistics found</h3>
                <p class="text-gray-500 mb-6">
                    @if($search || $filterStatus !== 'all')
                        Try adjusting your search or filter to find what you're looking for.
                    @else
                        Get started by creating your first statistic metric.
                    @endif
                </p>
                @if(!$search && $filterStatus === 'all')
                    <a href="{{ route('admin.statistics.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-cyan-600 text-white rounded-lg font-semibold hover:bg-cyan-700 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First Statistic
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
                        Are you sure you want to delete this statistic? This action cannot be undone and will also delete the icon if present.
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 px-6 py-4 border-t border-gray-200">
                    <button wire:click="cancelDelete"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button wire:click="deleteStatistic"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Statistic
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
