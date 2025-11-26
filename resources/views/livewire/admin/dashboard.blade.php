<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your site.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Services -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-briefcase text-3xl text-blue-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Services</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_services'] }}</div>
                                <div class="ml-2 text-sm text-gray-600">({{ $stats['active_services'] }} active)</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.services.index') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        View all <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Testimonials -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-quote-left text-3xl text-green-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Testimonials</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_testimonials'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.testimonials.index') }}" class="font-medium text-green-600 hover:text-green-500">
                        View all <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total FAQs -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-question-circle text-3xl text-purple-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total FAQs</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_faqs'] }}</div>
                                <div class="ml-2 text-sm text-gray-600">({{ $stats['active_faqs'] }} active)</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.faqs.index') }}" class="font-medium text-purple-600 hover:text-purple-500">
                        View all <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Unread Messages -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-envelope text-3xl text-red-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Unread Messages</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stats['unread_messages'] }}</div>
                                <div class="ml-2 text-sm text-gray-600">/ {{ $stats['total_messages'] }} total</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.contact-messages.index') }}" class="font-medium text-red-600 hover:text-red-500">
                        View all <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            <a href="{{ route('admin.services.create') }}" class="flex flex-col items-center justify-center p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-plus-circle text-3xl text-blue-500 mb-2"></i>
                <span class="text-sm font-medium text-gray-900">Add Service</span>
            </a>
            <a href="{{ route('admin.testimonials.create') }}" class="flex flex-col items-center justify-center p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-plus-circle text-3xl text-green-500 mb-2"></i>
                <span class="text-sm font-medium text-gray-900">Add Testimonial</span>
            </a>
            <a href="{{ route('admin.faqs.create') }}" class="flex flex-col items-center justify-center p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-plus-circle text-3xl text-purple-500 mb-2"></i>
                <span class="text-sm font-medium text-gray-900">Add FAQ</span>
            </a>
            <a href="{{ route('admin.site-settings.index') }}" class="flex flex-col items-center justify-center p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-cog text-3xl text-gray-500 mb-2"></i>
                <span class="text-sm font-medium text-gray-900">Site Settings</span>
            </a>
        </div>
    </div>

    <!-- Grid for Recent Items -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Messages -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-medium text-gray-900">Recent Messages</h2>
                <button wire:click="refreshStats" class="text-sm text-gray-600 hover:text-gray-900">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
            <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                @forelse($recentMessages as $message)
                    <div class="px-4 py-4 sm:px-6 {{ $message->is_read ? 'bg-white' : 'bg-blue-50' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm font-medium text-gray-900">{{ $message->name }}</span>
                                    <span class="text-sm text-gray-500">{{ $message->email }}</span>
                                    @if(!$message->is_read)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            New
                                        </span>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $message->message }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('admin.contact-messages.index') }}" class="ml-4 text-blue-600 hover:text-blue-500">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-8 sm:px-6 text-center">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-500">No messages yet</p>
                    </div>
                @endforelse
            </div>
            @if($recentMessages->count() > 0)
                <div class="bg-gray-50 px-4 py-3 sm:px-6">
                    <a href="{{ route('admin.contact-messages.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        View all messages <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Recent Activity</h2>
            </div>
            <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                @forelse($recentActivities as $activity)
                    <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                @if($activity->event === 'created')
                                    <i class="fas fa-plus-circle text-green-500"></i>
                                @elseif($activity->event === 'updated')
                                    <i class="fas fa-edit text-blue-500"></i>
                                @elseif($activity->event === 'deleted')
                                    <i class="fas fa-trash text-red-500"></i>
                                @else
                                    <i class="fas fa-circle text-gray-400"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $activity->description }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($activity->subject)
                                        <span class="font-medium">{{ class_basename($activity->subject_type) }}:</span>
                                        @if(method_exists($activity->subject, 'title'))
                                            {{ Str::limit($activity->subject->title ?? 'N/A', 30) }}
                                        @elseif(method_exists($activity->subject, 'question'))
                                            {{ Str::limit($activity->subject->question ?? 'N/A', 30) }}
                                        @elseif(method_exists($activity->subject, 'name'))
                                            {{ Str::limit($activity->subject->name ?? 'N/A', 30) }}
                                        @else
                                            ID: {{ $activity->subject_id }}
                                        @endif
                                    @else
                                        {{ class_basename($activity->subject_type) }} (deleted)
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-8 sm:px-6 text-center">
                        <i class="fas fa-history text-4xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-500">No recent activity</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
