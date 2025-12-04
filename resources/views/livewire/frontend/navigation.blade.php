<nav id="main-nav" class="fixed top-0 left-0 right-0 z-50 bg-white shadow-lg transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    @if($siteSetting && $siteSetting->logo)
                        <img src="{{ Storage::url($siteSetting->logo) }}"
                             alt="{{ $siteSetting->company_name ?? 'Logo' }}"
                             class="h-12 w-auto">
                    @endif
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                <a href="{{ url('/#home') }}"
                   class="nav-link font-medium text-gray-700 transition-colors duration-300 hover:text-orange-600">
                    Home
                </a>
                <a href="{{ url('/#about') }}"
                   class="nav-link font-medium text-gray-700 transition-colors duration-300 hover:text-orange-600">
                    About
                </a>
                <a href="{{ url('/#services') }}"
                   class="nav-link font-medium text-gray-700 transition-colors duration-300 hover:text-orange-600">
                    Services
                </a>
                <a href="{{ url('/#testimonials') }}"
                   class="nav-link font-medium text-gray-700 transition-colors duration-300 hover:text-orange-600">
                    Testimonials
                </a>
                <a href="{{ url('/#faq') }}"
                   class="nav-link font-medium text-gray-700 transition-colors duration-300 hover:text-orange-600">
                    FAQ
                </a>
                <a href="{{ url('/#contact') }}"
                   class="px-6 py-2.5 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition shadow-lg">
                    Contact Us
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button id="mobile-menu-toggle"
                        type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-900 hover:bg-gray-100 transition-colors duration-300">
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger Icon -->
                    <svg id="hamburger-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Close Icon -->
                    <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-white shadow-lg">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="{{ url('/#home') }}"
               class="mobile-menu-link block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                Home
            </a>
            <a href="{{ url('/#about') }}"
               class="mobile-menu-link block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                About
            </a>
            <a href="{{ url('/#services') }}"
               class="mobile-menu-link block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                Services
            </a>
            <a href="{{ url('/#testimonials') }}"
               class="mobile-menu-link block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                Testimonials
            </a>
            <a href="{{ url('/#faq') }}"
               class="mobile-menu-link block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                FAQ
            </a>
            <a href="{{ url('/#contact') }}"
               class="mobile-menu-link block px-4 py-3 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition text-center shadow-lg">
                Contact Us
            </a>
        </div>
    </div>
</nav>

<!-- Mobile Menu & Scroll Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');
    const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');

    // Toggle mobile menu
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            hamburgerIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    }

    // Close menu when clicking a link
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.add('hidden');
            hamburgerIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>
