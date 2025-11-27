<div>
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-phone mr-3"></i>
                        Contact Channels Management
                    </h2>
                    <p class="text-blue-100 mt-1">Manage customer contact channels</p>
                </div>
                <a href="{{ route('admin.contact-channels.create') }}"
                   class="bg-white text-blue-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-50 transition flex items-center shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Add Channel
                </a>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text"
                               wire:model.live="search"
                               placeholder="Search channels..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Channel Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Type</label>
                    <select wire:model.live="filterChannelType"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="all">All Types</option>
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="teams">Teams</option>
                        <option value="kingschat">Kingschat</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                    <select wire:model.live="filterStatus"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="all">All Channels</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Channels List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($channels->count() > 0)
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
                                Channel Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact Value
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
                        @foreach($channels as $channel)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-semibold">
                                        {{ $channel->order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($channel->icon)
                                        @if(Str::startsWith($channel->icon, 'fa-'))
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-lg flex items-center justify-center border border-blue-200">
                                                <i class="fas {{ $channel->icon }} text-blue-600 text-xl"></i>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($channel->icon) }}"
                                                 alt="{{ ucfirst($channel->channel_type) }} Icon"
                                                 class="w-10 h-10 object-contain rounded-lg border border-gray-200 bg-gray-50 p-1">
                                        @endif
                                    @else
                                        <div class="w-10 h-10 rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-sm"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($channel->channel_type === 'email')
                                            <i class="fas fa-envelope text-red-600 mr-2"></i>
                                        @elseif($channel->channel_type === 'phone')
                                            <i class="fas fa-phone text-green-600 mr-2"></i>
                                        @elseif($channel->channel_type === 'whatsapp')
                                            <i class="fab fa-whatsapp text-green-600 mr-2"></i>
                                        @elseif($channel->channel_type === 'teams')
                                            <i class="fab fa-microsoft text-blue-600 mr-2"></i>
                                        @elseif($channel->channel_type === 'kingschat')
                                            <i class="fas fa-comments text-purple-600 mr-2"></i>
                                        @endif
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ ucfirst($channel->channel_type) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-mono">
                                        {{ $channel->value }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="toggleActive({{ $channel->id }})"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition {{ $channel->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                        <i class="fas fa-{{ $channel->is_active ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                        {{ $channel->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.contact-channels.edit', $channel->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition p-2 rounded-lg hover:bg-blue-50"
                                           title="Edit Channel">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="confirmDelete({{ $channel->id }})"
                                                class="text-red-600 hover:text-red-900 transition p-2 rounded-lg hover:bg-red-50"
                                                title="Delete Channel">
                                            <i class="fas fa-trash"></i>
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
                {{ $channels->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-phone text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Contact Channels Found</h3>
                <p class="text-gray-600 mb-4">
                    @if($search)
                        No channels match your search criteria.
                    @else
                        Get started by adding your first contact channel.
                    @endif
                </p>
                @if(!$search)
                    <a href="{{ route('admin.contact-channels.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Add Channel
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="showDeleteModal = false">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 text-center mt-4">Delete Contact Channel</h3>
                    <p class="text-sm text-gray-600 text-center mt-2">
                        Are you sure you want to delete this contact channel? This action cannot be undone.
                    </p>
                    <div class="flex gap-3 mt-6">
                        <button wire:click="showDeleteModal = false"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                            Cancel
                        </button>
                        <button wire:click="deleteChannel"
                                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
