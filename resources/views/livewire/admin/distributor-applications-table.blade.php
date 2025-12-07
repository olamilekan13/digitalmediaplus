<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Distributor Applications</h2>
            <p class="mt-1 text-sm text-gray-600">Manage solar distributor applications submitted through your website</p>
        </div>
        @if($unreviewedCount > 0)
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-orange-100 text-orange-800">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $unreviewedCount }} Unreviewed
            </span>
        @endif
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by name, email, business, city, or state..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    />
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Filter -->
            <div>
                <select
                    wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                >
                    <option value="all">All Applications</option>
                    <option value="unreviewed">Unreviewed</option>
                    <option value="reviewed">Reviewed</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    @if(count($selectedApplications) > 0)
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-orange-800">
                    <i class="fas fa-check-square mr-2"></i>
                    {{ count($selectedApplications) }} application(s) selected
                </span>
                <div class="flex gap-2">
                    <button
                        wire:click="bulkMarkAsReviewed"
                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors"
                    >
                        <i class="fas fa-check mr-1"></i>
                        Mark Reviewed
                    </button>
                    <button
                        wire:click="bulkMarkAsUnreviewed"
                        class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors"
                    >
                        <i class="fas fa-undo mr-1"></i>
                        Mark Unreviewed
                    </button>
                    @if(auth()->user()->hasPermission('manage_contact_messages'))
                        <button
                            wire:click="bulkDelete"
                            onclick="return confirm('Are you sure you want to delete the selected applications?')"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors"
                        >
                            <i class="fas fa-trash mr-1"></i>
                            Delete
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Applications Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input
                                type="checkbox"
                                wire:model.live="selectAll"
                                class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                            />
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applicant
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Location
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Capacity
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
                    @forelse($applications as $application)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input
                                    type="checkbox"
                                    wire:model.live="selectedApplications"
                                    value="{{ $application->id }}"
                                    class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                                />
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                            <span class="text-orange-600 font-semibold text-sm">
                                                {{ strtoupper(substr($application->full_name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $application->full_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $application->business_name ?? 'No business name' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <a href="mailto:{{ $application->email }}" class="text-orange-600 hover:text-orange-800">
                                        <i class="fas fa-envelope mr-1"></i>
                                        {{ Str::limit($application->email, 20) }}
                                    </a>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <a href="tel:{{ $application->phone_number }}" class="hover:text-gray-700">
                                        <i class="fas fa-phone mr-1"></i>
                                        {{ $application->phone_number }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $application->city }}</div>
                                <div class="text-sm text-gray-500">{{ $application->state }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $application->monthly_purchase_capacity }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $application->created_at->format('M d, Y') }}
                                <div class="text-xs text-gray-400">
                                    {{ $application->created_at->format('g:i A') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button
                                    wire:click="viewApplication({{ $application->id }})"
                                    class="text-orange-600 hover:text-orange-900 mr-3"
                                    title="View Application"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if(auth()->user()->hasPermission('manage_contact_messages'))
                                    <button
                                        wire:click="confirmDelete({{ $application->id }})"
                                        class="text-red-600 hover:text-red-900"
                                        title="Delete Application"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg font-medium">No applications found</p>
                                    <p class="text-gray-400 text-sm mt-1">
                                        @if($search || $filterStatus !== 'all')
                                            Try adjusting your search or filter criteria
                                        @else
                                            Applications will appear here when submitted
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($applications->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $applications->links() }}
            </div>
        @endif
    </div>

    <!-- View Application Modal -->
    @if($showViewModal && $selectedApplication)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75" wire:click="closeViewModal"></div>
                <div class="relative bg-white rounded-lg max-w-5xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
                    <!-- Modal Header -->
                    <div class="sticky top-0 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-4 rounded-t-lg z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold">Distributor Application Details</h3>
                                <p class="text-orange-100 text-sm mt-1">Submitted on {{ $selectedApplication->created_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            <button wire:click="closeViewModal" class="text-white hover:text-orange-100 transition-colors">
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Section A: Personal Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <span class="bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">A</span>
                                Personal Information
                            </h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                                    <p class="text-gray-900">{{ $selectedApplication->full_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Business Name</label>
                                    <p class="text-gray-900">{{ $selectedApplication->business_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                                    <p class="text-gray-900">
                                        <a href="tel:{{ $selectedApplication->phone_number }}" class="text-orange-600 hover:text-orange-800">
                                            <i class="fas fa-phone mr-1"></i>{{ $selectedApplication->phone_number }}
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">WhatsApp Number</label>
                                    <p class="text-gray-900">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $selectedApplication->whatsapp_number) }}" target="_blank" class="text-green-600 hover:text-green-800">
                                            <i class="fab fa-whatsapp mr-1"></i>{{ $selectedApplication->whatsapp_number }}
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                                    <p class="text-gray-900">
                                        <a href="mailto:{{ $selectedApplication->email }}" class="text-orange-600 hover:text-orange-800">
                                            <i class="fas fa-envelope mr-1"></i>{{ $selectedApplication->email }}
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">City</label>
                                    <p class="text-gray-900">{{ $selectedApplication->city }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Residential Address</label>
                                    <p class="text-gray-900">{{ $selectedApplication->residential_address }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">State</label>
                                    <p class="text-gray-900">{{ $selectedApplication->state }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section B: Business Details -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <span class="bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">B</span>
                                Business Details
                            </h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Has Existing Business?</label>
                                    <p class="text-gray-900">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $selectedApplication->has_business ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $selectedApplication->has_business ? 'Yes' : 'No' }}
                                        </span>
                                    </p>
                                </div>
                                @if($selectedApplication->has_business)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Business Type</label>
                                        <p class="text-gray-900">{{ $selectedApplication->business_type === 'Other' ? $selectedApplication->business_type_other : $selectedApplication->business_type }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Years in Business</label>
                                        <p class="text-gray-900">{{ $selectedApplication->years_in_business ?? 'N/A' }}</p>
                                    </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Has Physical Shop?</label>
                                    <p class="text-gray-900">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $selectedApplication->has_physical_shop ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $selectedApplication->has_physical_shop ? 'Yes' : 'No' }}
                                        </span>
                                    </p>
                                </div>
                                @if($selectedApplication->has_physical_shop)
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Shop Address</label>
                                        <p class="text-gray-900">{{ $selectedApplication->shop_address ?? 'N/A' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Section C: Distribution Capacity -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <span class="bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">C</span>
                                Distribution Capacity
                            </h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Monthly Purchase Capacity</label>
                                    <p class="text-gray-900 font-semibold text-lg">{{ $selectedApplication->monthly_purchase_capacity }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Number of Sales Staff</label>
                                    <p class="text-gray-900">{{ $selectedApplication->sales_staff_count ?? 'N/A' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Distribution Area</label>
                                    <p class="text-gray-900">{{ $selectedApplication->distribution_area }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section D: Additional Information -->
                        @if($selectedApplication->additional_info)
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <span class="bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">D</span>
                                    Additional Information
                                </h4>
                                <p class="text-gray-900 whitespace-pre-line">{{ $selectedApplication->additional_info }}</p>
                            </div>
                        @endif

                        <!-- Section E: Declaration -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <span class="bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">E</span>
                                Declaration
                            </h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Applicant Name (Declaration)</label>
                                    <p class="text-gray-900">{{ $selectedApplication->applicant_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Application Date</label>
                                    <p class="text-gray-900">{{ $selectedApplication->application_date->format('F d, Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <p class="text-green-800 text-sm flex items-start">
                                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                                    <span>Applicant confirmed: "I hereby declare that the information provided is true and accurate to the best of my knowledge."</span>
                                </p>
                            </div>
                        </div>

                        <!-- Admin Notes Section -->
                        <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-sticky-note text-blue-600 mr-2"></i>
                                Admin Notes
                            </h4>
                            <div class="mb-4">
                                <textarea
                                    wire:model="adminNotes"
                                    rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                    placeholder="Add internal notes about this application..."
                                ></textarea>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input
                                            type="checkbox"
                                            wire:click="toggleReviewed({{ $selectedApplication->id }})"
                                            {{ $selectedApplication->is_reviewed ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                                        />
                                        <span class="text-sm font-medium text-gray-700">Mark as Reviewed</span>
                                    </label>
                                    @if($selectedApplication->is_reviewed)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Reviewed
                                        </span>
                                    @endif
                                </div>
                                <button
                                    wire:click="saveAdminNotes"
                                    class="px-6 py-2 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 transition-colors"
                                >
                                    <i class="fas fa-save mr-2"></i>Save Notes
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="sticky bottom-0 bg-gray-100 px-6 py-4 rounded-b-lg border-t border-gray-200 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Application ID: <span class="font-mono font-semibold">#{{ $selectedApplication->id }}</span>
                        </div>
                        <div class="flex gap-3">
                            @if(auth()->user()->hasPermission('manage_contact_messages'))
                                <button
                                    wire:click="confirmDelete({{ $selectedApplication->id }})"
                                    class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors"
                                >
                                    <i class="fas fa-trash mr-2"></i>Delete Application
                                </button>
                            @endif
                            <button
                                wire:click="closeViewModal"
                                class="px-6 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors"
                            >
                                <i class="fas fa-times mr-2"></i>Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
            <div class="relative bg-white rounded-lg max-w-md w-full p-6">
                <h3 class="text-lg font-semibold mb-4">Delete Application</h3>
                <p class="text-gray-600 mb-6">Are you sure? This action cannot be undone.</p>
                <div class="flex gap-3 justify-end">
                    <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
                    <button wire:click="deleteApplication" class="px-4 py-2 bg-red-600 text-white rounded-lg">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
