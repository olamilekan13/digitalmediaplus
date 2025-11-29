<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    @if($siteSetting && $siteSetting->logo)
                        <img src="{{ Storage::url($siteSetting->logo) }}"
                             alt="{{ $siteSetting->company_name ?? 'Logo' }}"
                             class="h-10 w-auto">
                    @endif
                </div>
                @if($siteSetting && $siteSetting->address)
                    <p class="text-sm flex">
                        <i class="fas fa-map-marker-alt mr-2 text-orange-500 mt-1"></i>
                        <span class="prose prose-sm max-w-none text-gray-300">
                            {!! $siteSetting->address !!}
                        </span>
                    </p>
                @endif
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="#home" class="hover:text-orange-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="#about" class="hover:text-orange-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> About Us
                        </a>
                    </li>
                    <li>
                        <a href="#services" class="hover:text-orange-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> Services
                        </a>
                    </li>
                    <li>
                        <a href="#testimonials" class="hover:text-orange-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> Testimonials
                        </a>
                    </li>
                    <li>
                        <a href="#faq" class="hover:text-orange-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i> FAQ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-white font-semibold mb-4">Contact Us</h4>
                <ul class="space-y-3">
                    @foreach($contactChannels as $channel)
                        @php
                            $iconClass = $channel->icon ?? 'fa-info-circle';
                            $brandIconTypes = ['whatsapp', 'teams'];
                            $iconPrefix = in_array($channel->channel_type, $brandIconTypes) ? 'fab' : 'fas';
                        @endphp
                        <li class="flex items-start">
                            <i class="{{ $iconPrefix }} {{ $iconClass }} text-orange-500 mt-0.5 mr-3 flex-shrink-0"></i>
                            <span class="text-sm break-words break-all">{{ $channel->value }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Social Media -->
            <div>
                <h4 class="text-white font-semibold mb-4">Follow Us</h4>
                <div class="flex space-x-4">
                    @if($siteSetting && $siteSetting->facebook_url)
                        <a href="{{ $siteSetting->facebook_url }}"
                           target="_blank"
                           class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-orange-600 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if($siteSetting && $siteSetting->twitter_url)
                        <a href="{{ $siteSetting->twitter_url }}"
                           target="_blank"
                           class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-orange-600 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if($siteSetting && $siteSetting->instagram_url)
                        <a href="{{ $siteSetting->instagram_url }}"
                           target="_blank"
                           class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-orange-600 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if($siteSetting && $siteSetting->linkedin_url)
                        <a href="{{ $siteSetting->linkedin_url }}"
                           target="_blank"
                           class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-orange-600 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                    @if($siteSetting && $siteSetting->youtube_url)
                        <a href="{{ $siteSetting->youtube_url }}"
                           target="_blank"
                           class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-orange-600 transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                    @if($siteSetting && $siteSetting->teams_url)
                        <a href="{{ $siteSetting->teams_url }}"
                           target="_blank"
                           class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-orange-600 transition">
                            <i class="fab fa-microsoft"></i>
                        </a>
                    @endif
                    @if($siteSetting && $siteSetting->telegram_url)
                        <a href="{{ $siteSetting->telegram_url }}"
                           target="_blank"
                           class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-orange-600 transition">
                            <i class="fab fa-telegram"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
            <p class="prose prose-sm mx-auto max-w-3xl text-gray-400">
                @if($siteSetting && $siteSetting->copyright_text)
                    {!! $siteSetting->copyright_text !!}
                @else
                    {{ '© ' . date('Y') . ' ' . ($siteSetting->company_name ?? config('app.name')) . '. All rights reserved.' }}
                @endif
            </p>
        </div>
    </div>

    <!-- Back to Top Button -->
    <div x-data="{ showBackToTop: false }"
         x-init="window.addEventListener('scroll', () => { showBackToTop = window.pageYOffset > 300 })"
         x-show="showBackToTop"
         x-transition
         class="fixed bottom-8 right-8 z-40">
        <a href="#home"
           class="w-12 h-12 bg-orange-600 text-white rounded-full flex items-center justify-center hover:bg-orange-700 transition shadow-lg">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
</footer>
