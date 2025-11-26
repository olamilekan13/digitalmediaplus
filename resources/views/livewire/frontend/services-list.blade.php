<div>
    <!-- Section Header -->
    <div class="text-center mb-16"
         x-data="{ shown: false }"
         x-intersect="shown = true">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 transition-all duration-700 transform"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            Check our Services
        </h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto transition-all duration-700 transform delay-200"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
           style="transition-delay: 200ms;">
            Comprehensive solutions designed to elevate your business and drive success
        </p>
    </div>

    @if($services->count() > 0)
        <!-- Services List - 2 Column Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($services as $index => $service)
                <div class="service-item"
                     x-data="{ shown: false }"
                     x-intersect="shown = true">
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 p-8 h-full flex flex-col md:flex-row gap-6 transition-all duration-700 transform hover:-translate-y-1"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                         style="transition-delay: {{ $index * 100 }}ms;">

                        <!-- Icon/Image Section -->
                        <div class="flex-shrink-0">
                            <div class="w-24 h-24 bg-gradient-to-br from-orange-100 to-yellow-100 rounded-xl flex items-center justify-center hover:scale-110 transition-transform duration-300">
                                <i class="fas {{ $service->icon ?? 'fa-cog' }} text-orange-600 text-4xl"></i>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="flex-grow flex flex-col">
                            <!-- Title -->
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 hover:text-orange-600 transition-colors duration-300">
                                {{ $service->title }}
                            </h3>

                            <!-- Full Description -->
                            <p class="text-gray-600 leading-relaxed flex-grow">
                                {{ $service->description }}
                            </p>

                            <!-- Optional Link/Button -->
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="#contact"
                                   class="inline-flex items-center text-orange-600 font-semibold hover:text-orange-700 group">
                                    Get Started
                                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Services Count Info -->
        <div class="text-center mt-12"
             x-data="{ shown: false }"
             x-intersect="shown = true">
            <p class="text-gray-500 transition-all duration-700"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                Showing all <span class="font-bold text-orange-600">{{ $services->count() }}</span> services
            </p>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-gray-50 rounded-xl">
            <i class="fas fa-briefcase text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-2xl font-medium text-gray-900 mb-2">No Services Available</h3>
            <p class="text-gray-600 text-lg">
                Our comprehensive services list will be displayed here soon.
            </p>
        </div>
    @endif
</div>
