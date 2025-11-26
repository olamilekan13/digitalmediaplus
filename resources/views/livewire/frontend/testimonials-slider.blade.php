<div>
    <!-- Section Header -->
    <div class="text-center mb-16"
         x-data="{ shown: false }"
         x-intersect="shown = true">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 transition-all duration-700 transform"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            What Our Clients Say
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto transition-all duration-700 transform delay-200"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
           style="transition-delay: 200ms;">
            Real stories from satisfied customers who trust our services
        </p>
    </div>

    @if($testimonials->count() > 0)
        <!-- Testimonials Slider -->
        <div x-data="{
                currentSlide: 0,
                totalSlides: {{ $testimonials->count() }},
                autoplayInterval: null,
                isAutoplayPaused: false,
                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                },
                prevSlide() {
                    this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                },
                goToSlide(index) {
                    this.currentSlide = index;
                },
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        if (!this.isAutoplayPaused) {
                            this.nextSlide();
                        }
                    }, 5000);
                },
                stopAutoplay() {
                    clearInterval(this.autoplayInterval);
                },
                pauseAutoplay() {
                    this.isAutoplayPaused = true;
                },
                resumeAutoplay() {
                    this.isAutoplayPaused = false;
                }
             }"
             x-init="startAutoplay()"
             @mouseenter="pauseAutoplay()"
             @mouseleave="resumeAutoplay()"
             class="relative max-w-5xl mx-auto">

            <!-- Testimonials Container -->
            <div class="relative overflow-hidden rounded-2xl">
                <div class="flex transition-transform duration-500 ease-in-out"
                     :style="`transform: translateX(-${currentSlide * 100}%)`">

                    @foreach($testimonials as $index => $testimonial)
                        <div class="w-full flex-shrink-0 px-4">
                            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                                <!-- Quote Icon -->
                                <div class="flex justify-center mb-6">
                                    <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-yellow-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-quote-left text-2xl text-orange-600"></i>
                                    </div>
                                </div>

                                <!-- Testimonial Content -->
                                <div class="text-center mb-8">
                                    <p class="text-lg md:text-xl text-gray-700 leading-relaxed italic">
                                        "{{ $testimonial->content }}"
                                    </p>
                                </div>

                                <!-- Customer Info -->
                                <div class="flex flex-col items-center">
                                    <!-- Photo -->
                                    <div class="mb-4">
                                        @if($testimonial->image)
                                            <img src="{{ Str::startsWith($testimonial->image, 'http') ? $testimonial->image : Storage::url($testimonial->image) }}"
                                                 alt="{{ $testimonial->name }}"
                                                 class="w-20 h-20 rounded-full object-cover border-4 border-orange-200 shadow-lg">
                                        @else
                                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-orange-400 to-yellow-400 flex items-center justify-center border-4 border-orange-200 shadow-lg">
                                                <span class="text-2xl font-bold text-white">
                                                    {{ substr($testimonial->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Name and Role -->
                                    <h4 class="text-xl font-bold text-gray-900">
                                        {{ $testimonial->name }}
                                    </h4>
                                    @if($testimonial->role)
                                        <p class="text-gray-600 mt-1">
                                            {{ $testimonial->role }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Star Rating (Optional decorative element) -->
                                <div class="flex justify-center mt-6 space-x-1">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Arrows -->
            <div class="absolute top-1/2 -translate-y-1/2 left-0 right-0 flex justify-between px-2 md:-mx-12 pointer-events-none">
                <!-- Previous Button -->
                <button @click="prevSlide()"
                        class="pointer-events-auto w-12 h-12 rounded-full bg-white shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:bg-orange-600 hover:text-white group">
                    <i class="fas fa-chevron-left text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                </button>

                <!-- Next Button -->
                <button @click="nextSlide()"
                        class="pointer-events-auto w-12 h-12 rounded-full bg-white shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:bg-orange-600 hover:text-white group">
                    <i class="fas fa-chevron-right text-gray-600 group-hover:text-white transition-colors duration-300"></i>
                </button>
            </div>

            <!-- Pagination Dots -->
            <div class="flex justify-center mt-8 space-x-2">
                @foreach($testimonials as $index => $testimonial)
                    <button @click="goToSlide({{ $index }})"
                            class="transition-all duration-300"
                            :class="currentSlide === {{ $index }} ? 'w-8 h-3 bg-orange-600 rounded-full' : 'w-3 h-3 bg-gray-300 rounded-full hover:bg-orange-400'">
                    </button>
                @endforeach
            </div>

            <!-- Slide Counter -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    <span x-text="currentSlide + 1"></span> / <span x-text="totalSlides"></span>
                </p>
            </div>
        </div>

        @if($testimonials->count() === 1)
            <!-- Hide navigation if only one testimonial -->
            <style>
                [x-cloak] { display: none; }
            </style>
        @endif

    @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-white rounded-xl shadow-lg">
            <i class="fas fa-comments text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-2xl font-medium text-gray-900 mb-2">No Testimonials Yet</h3>
            <p class="text-gray-600 text-lg">
                Customer testimonials will appear here soon.
            </p>
        </div>
    @endif
</div>
