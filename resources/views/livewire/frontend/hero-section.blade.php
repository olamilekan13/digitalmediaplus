<div>
<section id="home" class="relative min-h-screen flex items-center justify-center {{ $heroSection && $heroSection->background_image ? '' : 'bg-gradient-to-br from-sky-400 to-sky-600' }}">
    @if($heroSection)
        <!-- Background Image -->
        @if($heroSection->background_image)
            <div class="absolute inset-0 z-0">
                <img src="{{ Storage::url($heroSection->background_image) }}"
                     alt="Hero Background"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-br from-sky-400/40 to-sky-600/40"></div>
            </div>
        @endif

        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-4xl mx-auto"
                 x-data="{ shown: false }"
                 x-init="setTimeout(() => shown = true, 100)">

        <!-- Heading with fade-in animation -->
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight transition-all duration-1000 transform text-gray-900"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            {{ $heroSection->heading }}
        </h1>

        <!-- Tagline with delayed fade-in -->
        @if($heroSection->tagline)
            <div class="text-xl md:text-2xl lg:text-3xl mb-10 text-gray-800 transition-all duration-1000 transform delay-200 prose max-w-none"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                 style="transition-delay: 200ms;">
                {!! $heroSection->tagline !!}
            </div>
        @endif

        <!-- CTA Button with delayed slide-up -->
        @if($heroSection->cta_button_text)
            <div class="transition-all duration-1000 transform delay-400"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                 style="transition-delay: 400ms;">
                <a href="{{ $heroSection->cta_button_link ?? '#contact' }}"
                   class="inline-flex items-center px-8 py-4 bg-white text-orange-600 text-lg font-bold rounded-lg shadow-2xl hover:bg-gray-100 hover:shadow-3xl transform hover:scale-105 transition-all duration-300">
                    {{ $heroSection->cta_button_text }}
                    <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        @endif

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#about" class="flex flex-col items-center text-gray-900 hover:text-gray-700 transition">
                <span class="text-sm mb-2">Scroll Down</span>
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
            </div>
        </div>
    @else
        <!-- Default Hero when no active hero section -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <div class="max-w-4xl mx-auto"
                 x-data="{ shown: false }"
                 x-init="setTimeout(() => shown = true, 100)">

        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight transition-all duration-1000 transform"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            Welcome to {{ config('app.name') }}
        </h1>

        <p class="text-xl md:text-2xl lg:text-3xl mb-10 text-white/90 transition-all duration-1000 transform delay-200"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
           style="transition-delay: 200ms;">
            Your Digital Media Partner
        </p>

        <div class="transition-all duration-1000 transform delay-400"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
             style="transition-delay: 400ms;">
            <a href="#contact"
               class="inline-flex items-center px-8 py-4 bg-white text-orange-600 text-lg font-bold rounded-lg shadow-2xl hover:bg-gray-100 hover:shadow-3xl transform hover:scale-105 transition-all duration-300">
                Get Started
                <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#about" class="flex flex-col items-center text-gray-900 hover:text-gray-700 transition">
                <span class="text-sm mb-2">Scroll Down</span>
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
            </div>
        </div>
    @endif
</section>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .delay-200 {
        animation-delay: 200ms;
    }

    .delay-400 {
        animation-delay: 400ms;
    }
</style>
</div>
