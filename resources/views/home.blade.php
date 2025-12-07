<x-app-layout>
    <x-slot name="title">{{ $siteSetting->company_name ?? config('app.name') }} - Home</x-slot>

    <!-- Hero Section -->
    @livewire('frontend.hero-section')

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('frontend.services-list')
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('frontend.about-section')
        </div>
    </section>

    {{-- Feature Highlights Section --}}
    {{-- <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('frontend.feature-highlights-section')
        </div>
    </section> --}}

    <!-- Statistics Section -->
    <section id="statistics" class="py-20 bg-gradient-to-br from-orange-600 to-yellow-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('frontend.statistics-bar')
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('frontend.testimonials-slider')
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('frontend.faq-accordion')
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('frontend.contact-section')
        </div>
    </section>
</x-app-layout>
