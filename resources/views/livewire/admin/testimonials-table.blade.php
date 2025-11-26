<div>
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-quote-right mr-3"></i>
                        Testimonials Management
                    </h2>
                    <p class="text-pink-100 mt-1">Manage customer testimonials and reviews</p>
                </div>
                <a href="{{ route('admin.testimonials.create') }}"
                   class="bg-white text-pink-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-pink-50 transition flex items-center shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Create Testimonial
                </a>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i> Search Testimonials
                    </label>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search by name, role, or content..."
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                </div>

                <!-- Filter by Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-filter mr-1"></i> Filter by Status
                    </label>
                    <select wire:model.live="filterStatus"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <option value="all">All Testimonials</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </select>
                </div>
            </div>

            <!-- Bulk Actions -->
            @if(count($selectedTestimonials) > 0)
                <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <span class="text-sm font-medium text-blue-900">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ count($selectedTestimonials) }} testimonial(s) selected
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
                        <button wire:click="bulkDelete"
                                class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition"
                                onclick="return confirm('Are you sure you want to delete the selected testimonials?')">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Testimonials Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($testimonials->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox"
                                       wire:model.live="selectAll"
                                       class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Testimonial
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
                        @foreach($testimonials as $testimonial)
                            <tr class="hover:bg-gray-50 transition">
                                <!-- Checkbox -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                           wire:model.live="selectedTestimonials"
                                           value="{{ $testimonial->id }}"
                                           class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200">
                                </td>

                                <!-- Order -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-700 rounded-full font-semibold text-sm">
                                        {{ $testimonial->order ?? '-' }}
                                    </span>
                                </td>

                                <!-- Customer with Photo -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        @if($testimonial->image)
                                            <img src="{{ Str::startsWith($testimonial->image, 'http') ? $testimonial->image : Storage::url($testimonial->image) }}"
                                                 alt="{{ $testimonial->name }}"
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-pink-200">
                                        @else
                                            <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center border-2 border-pink-200">
                                                <i class="fas fa-user text-pink-500 text-lg"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-semibold text-gray-900 block">{{ $testimonial->name }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Role -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">{{ $testimonial->role ?? 'N/A' }}</span>
                                </td>

                                <!-- Testimonial Content -->
                                <td class="px-6 py-4">
                                    <div class="max-w-md">
                                        <p class="text-sm text-gray-600 line-clamp-2 italic">
                                            "{{ Str::limit($testimonial->content, 100) }}"
                                        </p>
                                    </div>
                                </td>

                                <!-- Status Toggle -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button wire:click="toggleActive({{ $testimonial->id }})"
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition {{ $testimonial->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition"
                                           title="Edit">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <button wire:click="confirmDelete({{ $testimonial->id }})"
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
                {{ $testimonials->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No testimonials found</h3>
                <p class="text-gray-500 mb-6">
                    @if($search || $filterStatus !== 'all')
                        Try adjusting your search or filter to find what you're looking for.
                    @else
                        Get started by adding your first customer testimonial.
                    @endif
                </p>
                @if(!$search && $filterStatus === 'all')
                    <a href="{{ route('admin.testimonials.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-pink-600 text-white rounded-lg font-semibold hover:bg-pink-700 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First Testimonial
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
                        Are you sure you want to delete this testimonial? This action cannot be undone and will also delete the customer photo if present.
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 px-6 py-4 border-t border-gray-200">
                    <button wire:click="cancelDelete"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button wire:click="deleteTestimonial"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Testimonial
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
