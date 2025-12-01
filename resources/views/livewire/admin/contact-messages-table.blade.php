<div>
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-envelope mr-3"></i>
                        Contact Messages Inbox
                        @if($unreadCount > 0)
                            <span class="ml-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-400 text-yellow-900">
                                {{ $unreadCount }} Unread
                            </span>
                        @endif
                    </h2>
                    <p class="text-purple-100 mt-1">Manage customer inquiries and messages</p>
                </div>
                @if($unreadCount > 0 && auth()->user()->hasPermission('manage_contact_messages'))
                    <button wire:click="markAllAsRead"
                            wire:confirm="Are you sure you want to mark all messages as read?"
                            class="bg-white text-purple-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-purple-50 transition flex items-center shadow-lg">
                        <i class="fas fa-check-double mr-2"></i>
                        Mark All Read
                    </button>
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
                               placeholder="Search by name, email, or message..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                    <select wire:model.live="filterStatus"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="all">All Messages</option>
                        <option value="unread">Unread Only</option>
                        <option value="read">Read Only</option>
                    </select>
                </div>
            </div>

            <!-- Bulk Actions -->
            @if(count($selectedMessages) > 0)
                <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <span class="text-sm font-medium text-blue-900">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ count($selectedMessages) }} message(s) selected
                    </span>
                    <div class="flex items-center space-x-2">
                        @if(auth()->user()->hasPermission('manage_contact_messages'))
                        <button wire:click="bulkMarkAsRead"
                                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-envelope-open mr-1"></i> Mark Read
                        </button>
                        <button wire:click="bulkMarkAsUnread"
                                class="px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition">
                            <i class="fas fa-envelope mr-1"></i> Mark Unread
                        </button>
                        <button wire:click="bulkDelete"
                                class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition"
                                onclick="return confirm('Are you sure you want to delete the selected messages?')">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Messages List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($messages->count() > 0)
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
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Message Preview
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($messages as $message)
                            <tr class="hover:bg-gray-50 transition {{ !$message->is_read ? 'bg-purple-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                           wire:model.live="selectedMessages"
                                           value="{{ $message->id }}"
                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(auth()->user()->hasPermission('manage_contact_messages'))
                                    <button wire:click="toggleRead({{ $message->id }})"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition {{ $message->is_read ? 'bg-gray-100 text-gray-800 hover:bg-gray-200' : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' }}"
                                            title="Click to toggle status">
                                        <i class="fas fa-{{ $message->is_read ? 'envelope-open' : 'envelope' }} mr-1"></i>
                                        {{ $message->is_read ? 'Read' : 'Unread' }}
                                    </button>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $message->is_read ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        <i class="fas fa-{{ $message->is_read ? 'envelope-open' : 'envelope' }} mr-1"></i>
                                        {{ $message->is_read ? 'Read' : 'Unread' }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-purple-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 {{ !$message->is_read ? 'font-bold' : '' }}">
                                                {{ $message->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $message->email }}</div>
                                    @if($message->phone)
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-phone mr-1"></i>{{ $message->phone }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 max-w-md">
                                    <div class="text-sm text-gray-900 truncate {{ !$message->is_read ? 'font-semibold' : '' }}">
                                        {{ Str::limit($message->message, 100) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex flex-col">
                                        <span>{{ $message->created_at->format('M d, Y') }}</span>
                                        <span class="text-xs">{{ $message->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button wire:click="viewMessage({{ $message->id }})"
                                                class="text-purple-600 hover:text-purple-900 transition p-2 rounded-lg hover:bg-purple-50"
                                                title="View Full Message">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if(auth()->user()->hasPermission('manage_contact_messages'))
                                        <button wire:click="confirmDelete({{ $message->id }})"
                                                class="text-red-600 hover:text-red-900 transition p-2 rounded-lg hover:bg-red-50"
                                                title="Delete Message">
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
                {{ $messages->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Messages Found</h3>
                <p class="text-gray-600 mb-4">
                    @if($search)
                        No messages match your search criteria.
                    @elseif($filterStatus === 'unread')
                        You have no unread messages.
                    @elseif($filterStatus === 'read')
                        You have no read messages.
                    @else
                        Your inbox is empty. Messages from the contact form will appear here.
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- View Message Modal -->
    @if($showViewModal && $selectedMessage)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeViewModal">
            <div class="relative top-20 mx-auto p-0 border w-full max-w-2xl shadow-2xl rounded-lg bg-white" wire:click.stop>
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4 rounded-t-lg">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-envelope-open mr-3"></i>
                            Message Details
                        </h3>
                        <button wire:click="closeViewModal"
                                class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-6">
                    <!-- Sender Information -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-user-circle text-purple-600 mr-2"></i>
                            Sender Information
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Name</label>
                                <p class="text-sm font-medium text-gray-900">{{ $selectedMessage->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                                <a href="mailto:{{ $selectedMessage->email }}"
                                   class="text-sm text-purple-600 hover:text-purple-800 flex items-center">
                                    <i class="fas fa-envelope mr-2"></i>
                                    {{ $selectedMessage->email }}
                                </a>
                            </div>
                            @if($selectedMessage->phone)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Phone</label>
                                    <a href="tel:{{ $selectedMessage->phone }}"
                                       class="text-sm text-purple-600 hover:text-purple-800 flex items-center">
                                        <i class="fas fa-phone mr-2"></i>
                                        {{ $selectedMessage->phone }}
                                    </a>
                                </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Date Received</label>
                                <p class="text-sm text-gray-900">
                                    {{ $selectedMessage->created_at->format('F d, Y \a\t h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-comment-alt text-purple-600 mr-2"></i>
                            Message
                        </h4>
                        <div class="bg-white border border-gray-300 rounded-lg p-4">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $selectedMessage->message }}</p>
                        </div>
                    </div>

                    <!-- Message Status -->
                    <div class="flex items-center justify-between bg-purple-50 p-4 rounded-lg border border-purple-200">
                        <div class="flex items-center">
                            <i class="fas fa-{{ $selectedMessage->is_read ? 'check-circle' : 'circle' }} text-purple-600 mr-3 text-xl"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    Status: {{ $selectedMessage->is_read ? 'Read' : 'Unread' }}
                                </p>
                                <p class="text-xs text-gray-600">
                                    {{ $selectedMessage->is_read ? 'Message has been read' : 'Message marked as read' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-lg border-t border-gray-200 flex justify-between">
                    @if(auth()->user()->hasPermission('manage_contact_messages'))
                    <button wire:click="confirmDelete({{ $selectedMessage->id }})"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Message
                    </button>
                    @else
                    <div></div>
                    @endif
                    <button wire:click="closeViewModal"
                            class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="showDeleteModal = false">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 text-center mt-4">Delete Message</h3>
                    <p class="text-sm text-gray-600 text-center mt-2">
                        Are you sure you want to delete this message? This action cannot be undone.
                    </p>
                    <div class="flex gap-3 mt-6">
                        <button wire:click="showDeleteModal = false"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                            Cancel
                        </button>
                        <button wire:click="deleteMessage"
                                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
