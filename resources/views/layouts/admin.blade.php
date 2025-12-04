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

        <!-- Toastify CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        <!-- CKEditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Mobile Sidebar Backdrop -->
            <div id="sidebar-backdrop"
                 class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300"
                 onclick="closeSidebar()"></div>

            <!-- Sidebar -->
            <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0" id="sidebar">
                <div class="flex items-center justify-between h-16 bg-gray-800 px-4">
                    <span class="text-white text-xl font-bold">Admin Panel</span>
                    <!-- Close button for mobile -->
                    <button id="sidebar-close" class="text-white lg:hidden hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <nav class="mt-5 px-2">
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
                        <a href="{{ route('admin.custom-pages.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.custom-pages.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-file-alt mr-3"></i>
                            Custom Pages
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

                    <!-- Admin Management (Super Admin Only) -->
                    @if(auth()->check() && auth()->user()->isSuperAdmin())
                    <div class="mt-4">
                        <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">System</h3>
                        <a href="{{ route('admin.admin-users.index') }}" class="group flex items-center px-2 py-2 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('admin.admin-users.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i class="fas fa-users-cog mr-3"></i>
                            Admin Management
                        </a>
                    </div>
                    @endif
                </nav>
            </div>

            <!-- Main Content -->
            <div class="lg:pl-64">
                <!-- Top Navigation -->
                <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                    <!-- Hamburger Menu Button -->
                    <button type="button"
                            class="flex items-center justify-center w-10 h-10 p-2 text-gray-900 bg-white hover:bg-gray-100 rounded-md border border-gray-300 transition-colors lg:hidden"
                            id="sidebar-toggle">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
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
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Alpine.js for dropdown -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Toastify JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        <!-- Mobile Sidebar Toggle -->
        <script>
            function openSidebar() {
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }

            function closeSidebar() {
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }

            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebar-toggle');
                const sidebarClose = document.getElementById('sidebar-close');

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', openSidebar);
                }

                if (sidebarClose) {
                    sidebarClose.addEventListener('click', closeSidebar);
                }
            });

            // Global Toaster Function
            function showToast(message, type = 'success') {
                const colors = {
                    success: 'linear-gradient(to right, #10b981, #059669)',
                    error: 'linear-gradient(to right, #ef4444, #dc2626)',
                    info: 'linear-gradient(to right, #3b82f6, #2563eb)',
                    warning: 'linear-gradient(to right, #f59e0b, #d97706)'
                };

                Toastify({
                    text: message,
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    style: {
                        background: colors[type] || colors.success,
                    }
                }).showToast();
            }

            // Listen for Livewire events
            document.addEventListener('livewire:init', () => {
                Livewire.on('notify', (event) => {
                    showToast(event.message, event.type || 'success');
                });
            });
        </script>

        @if(session('success'))
            <script>
                showToast('{{ session('success') }}', 'success');
            </script>
        @endif

        @if(session('error'))
            <script>
                showToast('{{ session('error') }}', 'error');
            </script>
        @endif

        @stack('scripts')
    </body>
</html>
