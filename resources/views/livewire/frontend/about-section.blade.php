<div class="about-section">
    @if($aboutSection)
        <!-- Section Header -->
        <div class="text-center mb-16"
             x-data="{ shown: false }"
             x-intersect="shown = true">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 transition-all duration-700 transform"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                {{ $aboutSection->heading }}
            </h2>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <!-- Left: Text Content -->
            <div x-data="{ shown: false }"
                 x-intersect="shown = true"
                 class="transition-all duration-700 transform"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">

                <!-- Description -->
                @if($aboutSection->description)
                    <div class="prose prose-lg max-w-none mb-6">
                        <p class="text-xl text-gray-700 leading-relaxed">
                            {{ $aboutSection->description }}
                        </p>
                    </div>
                @endif

                <!-- Story Text -->
                @if($aboutSection->story_text)
                    <div class="prose prose-lg max-w-none">
                        <p class="text-gray-600 leading-relaxed">
                            {{ $aboutSection->story_text }}
                        </p>
                    </div>
                @endif

                <!-- CTA Button -->
                <div class="mt-8">
                    <a href="#contact"
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-yellow-600 text-white text-lg font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        Get in Touch
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
            </div>

            <!-- Right: Image -->
            <div x-data="{ shown: false }"
                 x-intersect="shown = true"
                 class="transition-all duration-700 transform"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'">
                @if($aboutSection->image)
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl group">
                        <img src="{{ $aboutSection->image }}"
                             alt="{{ $aboutSection->heading }}"
                             class="w-full h-auto transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                @else
                    <div class="bg-gradient-to-br from-orange-100 to-yellow-100 rounded-2xl h-96 flex items-center justify-center">
                        <i class="fas fa-image text-orange-300 text-6xl"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Feature Highlights Cards -->
        @if($featureHighlights->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-16">
                @foreach($featureHighlights as $index => $feature)
                    <div x-data="{ shown: false }"
                         x-intersect="shown = true"
                         class="transition-all duration-700 transform"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                         style="transition-delay: {{ $index * 100 }}ms;">

                        <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl p-6 border-2 border-orange-100 hover:border-orange-300 hover:shadow-lg transition-all duration-300 h-full">
                            <!-- Icon -->
                            <div class="mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-lg flex items-center justify-center shadow-md">
                                    <i class="fas {{ $feature->icon ?? 'fa-star' }} text-white text-2xl"></i>
                                </div>
                            </div>

                            <!-- Title -->
                            <h4 class="text-lg font-bold text-gray-900 mb-2">
                                {{ $feature->title }}
                            </h4>

                            <!-- Description -->
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $feature->description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <!-- Default About Section -->
        <div class="text-center mb-16"
             x-data="{ shown: false }"
             x-intersect="shown = true">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 transition-all duration-700 transform"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                About Us
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div x-data="{ shown: false }"
                 x-intersect="shown = true"
                 class="transition-all duration-700 transform"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
                <div class="prose prose-lg max-w-none">
                    <p class="text-xl text-gray-700 leading-relaxed mb-6">
                        We are a leading digital media company dedicated to transforming your online presence.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Our team of experts combines creativity with technical expertise to deliver solutions that drive results and exceed expectations.
                    </p>
                </div>
                <div class="mt-8">
                    <a href="#contact"
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-yellow-600 text-white text-lg font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        Get in Touch
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
            </div>

            <div x-data="{ shown: false }"
                 x-intersect="shown = true"
                 class="transition-all duration-700 transform"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'">
                <div class="bg-gradient-to-br from-orange-100 to-yellow-100 rounded-2xl h-96 flex items-center justify-center">
                    <i class="fas fa-image text-orange-300 text-6xl"></i>
                </div>
            </div>
        </div>
    @endif
</div>
