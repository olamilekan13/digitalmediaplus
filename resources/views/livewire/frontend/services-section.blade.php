<div class="services-section">
    <!-- Section Header -->
    <div class="text-center mb-16"
         x-data="{ shown: false }"
         x-intersect="shown = true">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 transition-all duration-700 transform"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            Our Services
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto transition-all duration-700 transform delay-200"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
           style="transition-delay: 200ms;">
            Discover how we can help transform your digital presence
        </p>
    </div>

    @if($services->count() > 0)
        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($services as $index => $service)
                <div class="service-card group"
                     x-data="{ shown: false }"
                     x-intersect="shown = true">
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 p-8 h-full flex flex-col transition-all duration-700"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                         style="transition-delay: {{ $index * 100 }}ms;">

                        <!-- Icon -->
                        <div class="mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-yellow-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas {{ $service->icon ?? 'fa-cog' }} text-orange-600 text-3xl"></i>
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors duration-300">
                            {{ $service->title }}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-600 flex-grow leading-relaxed">
                            {{ Str::limit($service->description, 120) }}
                        </p>

                        <!-- Learn More Link (appears on hover) -->
                        <div class="mt-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="#contact"
                               class="inline-flex items-center text-orange-600 font-semibold hover:text-orange-700">
                                Learn More
                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- View All Services Button -->
        @if($services->count() >= 4)
            <div class="text-center mt-12"
                 x-data="{ shown: false }"
                 x-intersect="shown = true">
                <a href="#contact"
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-yellow-600 text-white text-lg font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                   :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                    View All Services
                    <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <i class="fas fa-briefcase text-gray-400 text-5xl mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No Services Available</h3>
            <p class="text-gray-600">
                Our services will be displayed here soon.
            </p>
        </div>
    @endif

    <!-- Custom Styles for Service Cards -->
    <style>
        .service-card {
            position: relative;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, #ea580c, #eab308);
            border-radius: 12px 12px 0 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .service-card:hover::before {
            opacity: 1;
        }
    </style>
</div>
