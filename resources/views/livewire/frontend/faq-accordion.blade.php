<div>
    <!-- Section Header -->
    <div class="text-center mb-16"
         x-data="{ shown: false }"
         x-intersect="shown = true">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 transition-all duration-700 transform"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            Frequently Asked Questions
        </h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto transition-all duration-700 transform delay-200"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
           style="transition-delay: 200ms;">
            Find answers to common questions about our services and solutions
        </p>
    </div>

    @if($faqs->count() > 0)
        <!-- FAQ Accordion -->
        <div x-data="{ activeAccordion: null }"
             class="max-w-4xl mx-auto space-y-4">
            @foreach($faqs as $index => $faq)
                <div x-data="{ shown: false }"
                     x-intersect="shown = true"
                     class="transition-all duration-700"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     style="transition-delay: {{ $index * 100 }}ms;">

                    <!-- Accordion Item -->
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-200"
                         :class="activeAccordion === {{ $index }} ? 'ring-2 ring-orange-500' : ''">

                        <!-- Question Header (Clickable) -->
                        <button @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}"
                                class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors duration-200 group">

                            <!-- Question Text -->
                            <h3 class="text-lg md:text-xl font-semibold text-gray-900 pr-8 group-hover:text-orange-600 transition-colors duration-200">
                                {{ $faq->question }}
                            </h3>

                            <!-- Icon (Plus/Minus) -->
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-orange-100 to-yellow-100 flex items-center justify-center transition-all duration-300 group-hover:scale-110"
                                 :class="activeAccordion === {{ $index }} ? 'bg-gradient-to-br from-orange-500 to-yellow-500' : ''">
                                <!-- Plus Icon (when closed) -->
                                <svg x-show="activeAccordion !== {{ $index }}"
                                     class="w-5 h-5 text-orange-600 transition-transform duration-300"
                                     :class="activeAccordion === {{ $index }} ? 'text-white' : ''"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>

                                <!-- Minus Icon (when open) -->
                                <svg x-show="activeAccordion === {{ $index }}"
                                     class="w-5 h-5 text-white transition-transform duration-300"
                                     x-cloak
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/>
                                </svg>
                            </div>
                        </button>

                        <!-- Answer Content (Expandable) -->
                        <div x-show="activeAccordion === {{ $index }}"
                             x-collapse
                             x-cloak>
                            <div class="px-6 pb-6 pt-2">
                                <div class="pl-4 border-l-4 border-orange-400">
                                    <div class="text-gray-700 leading-relaxed text-base md:text-lg prose max-w-none">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- FAQ Count Info -->
        <div class="text-center mt-12"
             x-data="{ shown: false }"
             x-intersect="shown = true">
            <p class="text-gray-500 transition-all duration-700"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                Have more questions?
                <a href="#contact" class="text-orange-600 font-semibold hover:text-orange-700 underline">
                    Contact us
                </a>
            </p>
        </div>

    @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-white rounded-xl shadow-lg max-w-2xl mx-auto">
            <i class="fas fa-question-circle text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-2xl font-medium text-gray-900 mb-2">No FAQs Available</h3>
            <p class="text-gray-600 text-lg">
                Frequently asked questions will be displayed here soon.
            </p>
        </div>
    @endif

</div>
