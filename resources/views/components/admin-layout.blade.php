<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- CKEditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Mobile Sidebar Backdrop -->
            <div id="sidebar-backdrop"
                 class="fixed inset-0 bg-gray-900 bg-opacity-50 z-[45] lg:hidden hidden transition-opacity duration-300"
                 onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden');"></div>

            <!-- Sidebar -->
            <div class="fixed inset-y-0 left-0 z-[60] w-64 bg-gray-900 transform transition-all duration-300 ease-in-out -translate-x-full" id="sidebar">
                <div class="flex items-center justify-between h-16 bg-gray-800 px-4">
                    <span class="text-white text-xl font-bold">Admin Panel</span>
                    <!-- Close button for mobile/desktop -->
                    <button id="sidebar-close" class="text-white lg:hidden">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <nav class="mt-5 px-2 overflow-y-auto h-[calc(100vh-4rem)] pb-10">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>

                    <!-- Site Settings -->
                    <div class="mt-4">
                        <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Site Management</h3>
                        <a href="{{ route('admin.site-settings.index') }}" class="group flex items-center px-2 py-2 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('admin.site-settings.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-cog mr-3"></i>
                            Site Settings
                        </a>
                        <a href="{{ route('admin.hero-sections.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.hero-sections.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-star mr-3"></i>
                            Hero Section
                        </a>
                    </div>

                    <!-- Content Management -->
                    <div class="mt-4">
                        <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Content</h3>
                        <a href="{{ route('admin.services.index') }}" class="group flex items-center px-2 py-2 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('admin.services.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-briefcase mr-3"></i>
                            Services
                        </a>
                        <a href="{{ route('admin.about-sections.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.about-sections.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-info-circle mr-3"></i>
                            About Section
                        </a>
                        <a href="{{ route('admin.feature-highlights.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.feature-highlights.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-lightbulb mr-3"></i>
                            Features
                        </a>
                        <a href="{{ route('admin.statistics.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.statistics.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-chart-bar mr-3"></i>
                            Statistics
                        </a>
                        <a href="{{ route('admin.testimonials.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.testimonials.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-quote-left mr-3"></i>
                            Testimonials
                        </a>
                        <a href="{{ route('admin.faqs.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.faqs.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-question-circle mr-3"></i>
                            FAQs
                        </a>
                    </div>

                    <!-- Contact Management -->
                    <div class="mt-4">
                        <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Contact</h3>
                        <a href="{{ route('admin.contact-channels.index') }}" class="group flex items-center px-2 py-2 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('admin.contact-channels.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-phone mr-3"></i>
                            Contact Channels
                        </a>
                        <a href="{{ route('admin.contact-messages.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.contact-messages.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-envelope mr-3"></i>
                            Messages
                            @if($unreadCount = \App\Models\ContactMessage::unread()->count())
                                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div id="main-content" class="transition-all duration-300">
                <!-- Top Navigation -->
                <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                    <button type="button" class="-m-2.5 p-2.5 text-gray-900" id="sidebar-toggle">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                        <div class="flex flex-1"></div>
                        <div class="flex items-center gap-x-4 lg:gap-x-6">
                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" type="button" class="flex items-center gap-x-2 text-sm font-semibold leading-6 text-gray-900">
                                    <span class="sr-only">Open user menu</span>
                                    <i class="fas fa-user-circle text-2xl"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>

                                <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5">
                                    <a href="{{ route('profile.edit') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">
                                        <i class="fas fa-user mr-2"></i>Your Profile
                                    </a>
                                    <a href="{{ url('/') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" target="_blank">
                                        <i class="fas fa-globe mr-2"></i>View Site
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <main class="py-6">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <!-- Success/Error Messages -->
                        @if(session('success'))
                            <div class="mb-4 rounded-md bg-green-50 p-4">
                                <div class="flex">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 rounded-md bg-red-50 p-4">
                                <div class="flex">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Alpine.js for dropdown -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Sidebar Toggle Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebar-toggle');
                const sidebarClose = document.getElementById('sidebar-close');
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                const mainContent = document.getElementById('main-content');

                // Open sidebar on desktop by default
                function initializeSidebar() {
                    if (window.innerWidth >= 1024) {
                        // Desktop: open by default
                        sidebar.classList.remove('-translate-x-full');
                        mainContent.classList.add('lg:pl-64');
                    } else {
                        // Mobile: closed by default
                        sidebar.classList.add('-translate-x-full');
                        mainContent.classList.remove('lg:pl-64');
                    }
                }

                function openSidebar() {
                    sidebar.classList.remove('-translate-x-full');
                    if (window.innerWidth < 1024) {
                        // Mobile: show backdrop
                        backdrop.classList.remove('hidden');
                    } else {
                        // Desktop: adjust content padding
                        mainContent.classList.add('lg:pl-64');
                    }
                }

                function closeSidebar() {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                    if (window.innerWidth >= 1024) {
                        mainContent.classList.remove('lg:pl-64');
                    }
                }

                // Initialize on load
                initializeSidebar();

                // Toggle button click
                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', function() {
                        if (sidebar.classList.contains('-translate-x-full')) {
                            openSidebar();
                        } else {
                            closeSidebar();
                        }
                    });
                }

                // Close button click (mobile only)
                if (sidebarClose) {
                    sidebarClose.addEventListener('click', closeSidebar);
                }

                // Backdrop click (mobile only)
                if (backdrop) {
                    backdrop.addEventListener('click', closeSidebar);
                }

                // Handle window resize
                window.addEventListener('resize', function() {
                    initializeSidebar();
                });
            });
        </script>

        @livewireScripts
    </body>
</html>
