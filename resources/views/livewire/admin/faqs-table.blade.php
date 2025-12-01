<div>
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-question-circle mr-3"></i>
                        FAQs Management
                    </h2>
                    <p class="text-indigo-100 mt-1">Manage frequently asked questions</p>
                </div>
                @if(auth()->user()->hasPermission('manage_faqs'))
                <a href="{{ route('admin.faqs.create') }}"
                   class="bg-white text-indigo-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-indigo-50 transition flex items-center shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Create FAQ
                </a>
                @endif
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text"
                               wire:model.live="search"
                               placeholder="Search questions or answers..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                    <select wire:model.live="filterStatus"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="all">All FAQs</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </select>
                </div>
            </div>

            <!-- Bulk Actions -->
            @if(count($selectedFaqs) > 0)
                <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <span class="text-sm font-medium text-blue-900">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ count($selectedFaqs) }} FAQ(s) selected
                    </span>
                    <div class="flex items-center space-x-2">
                        @if(auth()->user()->hasPermission('manage_faqs') || auth()->user()->hasPermission('edit_faqs'))
                        <button wire:click="bulkActivate"
                                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-check mr-1"></i> Activate
                        </button>
                        <button wire:click="bulkDeactivate"
                                class="px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition">
                            <i class="fas fa-ban mr-1"></i> Deactivate
                        </button>
                        @endif
                        @if(auth()->user()->hasPermission('manage_faqs'))
                        <button wire:click="bulkDelete"
                                class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition"
                                onclick="return confirm('Are you sure you want to delete the selected FAQs?')">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- FAQs List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($faqs->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox"
                                       wire:model.live="selectAll"
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Question
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Answer Preview
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($faqs as $faq)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                           wire:model.live="selectedFaqs"
                                           value="{{ $faq->id }}"
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-800 font-semibold">
                                        {{ $faq->order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ Str::limit($faq->question, 80) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">
                                        {{ Str::limit(strip_tags($faq->answer), 100) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(auth()->user()->hasPermission('manage_faqs') || auth()->user()->hasPermission('edit_faqs'))
                                    <button wire:click="toggleActive({{ $faq->id }})"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition {{ $faq->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                        <i class="fas fa-{{ $faq->is_active ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $faq->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas fa-{{ $faq->is_active ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        @if(auth()->user()->hasPermission('manage_faqs') || auth()->user()->hasPermission('edit_faqs'))
                                        <a href="{{ route('admin.faqs.edit', $faq->id) }}"
                                           class="text-indigo-600 hover:text-indigo-900 transition p-2 rounded-lg hover:bg-indigo-50"
                                           title="Edit FAQ">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                        @if(auth()->user()->hasPermission('manage_faqs'))
                                        <button wire:click="confirmDelete({{ $faq->id }})"
                                                class="text-red-600 hover:text-red-900 transition p-2 rounded-lg hover:bg-red-50"
                                                title="Delete FAQ">
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
                {{ $faqs->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-question-circle text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No FAQs found</h3>
                <p class="text-gray-600 mb-4">
                    @if($search)
                        No FAQs match your search criteria.
                    @else
                        Get started by creating your first FAQ.
                    @endif
                </p>
                @if(!$search && auth()->user()->hasPermission('manage_faqs'))
                    <a href="{{ route('admin.faqs.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Create FAQ
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="cancelDelete">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 text-center mt-4">Delete FAQ</h3>
                    <p class="text-sm text-gray-600 text-center mt-2">
                        Are you sure you want to delete this FAQ? This action cannot be undone.
                    </p>
                    <div class="flex gap-3 mt-6">
                        <button wire:click="cancelDelete"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                            Cancel
                        </button>
                        <button wire:click="deleteFaq"
                                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
