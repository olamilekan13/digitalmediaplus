<nav x-data="{
    scrolled: false,
    mobileMenuOpen: @entangle('showMobileMenu')
}"
x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 50 })"
:class="{ 'bg-white shadow-lg': scrolled, 'bg-transparent': !scrolled }"
class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="#home" class="flex items-center">
                    @if($siteSetting && $siteSetting->logo)
                        <img src="{{ Storage::url($siteSetting->logo) }}"
                             alt="{{ $siteSetting->company_name ?? 'Logo' }}"
                             class="h-12 w-auto">
                    @endif
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                <a href="#home"
                   class="nav-link font-medium transition-colors duration-300 hover:text-orange-600"
                   :class="{ 'text-gray-700': scrolled, 'text-white': !scrolled }">
                    Home
                </a>
                <a href="#about"
                   class="nav-link font-medium transition-colors duration-300 hover:text-orange-600"
                   :class="{ 'text-gray-700': scrolled, 'text-white': !scrolled }">
                    About
                </a>
                <a href="#services"
                   class="nav-link font-medium transition-colors duration-300 hover:text-orange-600"
                   :class="{ 'text-gray-700': scrolled, 'text-white': !scrolled }">
                    Services
                </a>
                <a href="#testimonials"
                   class="nav-link font-medium transition-colors duration-300 hover:text-orange-600"
                   :class="{ 'text-gray-700': scrolled, 'text-white': !scrolled }">
                    Testimonials
                </a>
                <a href="#faq"
                   class="nav-link font-medium transition-colors duration-300 hover:text-orange-600"
                   :class="{ 'text-gray-700': scrolled, 'text-white': !scrolled }">
                    FAQ
                </a>
                <a href="#contact"
                   class="px-6 py-2.5 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition shadow-lg">
                    Contact Us
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-900 hover:bg-gray-100 transition-colors duration-300">
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger Icon -->
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Close Icon -->
                    <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="lg:hidden bg-white shadow-lg">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="#home"
               @click="mobileMenuOpen = false"
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                Home
            </a>
            <a href="#about"
               @click="mobileMenuOpen = false"
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                About
            </a>
            <a href="#services"
               @click="mobileMenuOpen = false"
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                Services
            </a>
            <a href="#testimonials"
               @click="mobileMenuOpen = false"
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                Testimonials
            </a>
            <a href="#faq"
               @click="mobileMenuOpen = false"
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-600 font-medium transition">
                FAQ
            </a>
            <a href="#contact"
               @click="mobileMenuOpen = false"
               class="block px-4 py-3 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition text-center shadow-lg">
                Contact Us
            </a>
        </div>
    </div>
</nav>

<!-- Add scroll behavior script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed header height
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>
