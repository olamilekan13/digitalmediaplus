<div>
    <!-- Section Header -->
    <div class="text-center mb-16"
         x-data="{ shown: false }"
         x-intersect="shown = true">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 transition-all duration-700 transform"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            Contact Us
        </h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto transition-all duration-700 transform delay-200"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
           style="transition-delay: 200ms;">
            Ready to start your next project? Let's connect and discuss how we can help you succeed.
        </p>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

        <!-- Left Column: Contact Info -->
        <div x-data="{ shown: false }"
             x-intersect="shown = true"
             class="transition-all duration-700 transform"
             :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
            <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-2xl p-8 h-full border border-orange-100">
                @livewire('frontend.contact-info')
            </div>
        </div>

        <!-- Right Column: Contact Form -->
        <div x-data="{ shown: false }"
             x-intersect="shown = true"
             class="transition-all duration-700 transform"
             :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'"
             style="transition-delay: 200ms;">
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                @livewire('frontend.contact-form')
            </div>
        </div>

    </div>
</div>
