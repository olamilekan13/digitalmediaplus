<div>
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Get In Touch</h3>
    <p class="text-gray-600 mb-8 leading-relaxed">
        Have a question or want to work together? We'd love to hear from you. Reach us through any of these channels.
    </p>

    @if($channels->count() > 0)
        <!-- Contact Channels Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($channels as $index => $channel)
                @php
                    $channelIcons = [
                        'skype' => 'fa-skype',
                        'email' => 'fa-envelope',
                        'phone' => 'fa-phone',
                        'whatsapp' => 'fa-whatsapp',
                        'kingschat' => 'fa-comment-dots',
                    ];

                    $channelLabels = [
                        'skype' => 'Skype',
                        'email' => 'Email',
                        'phone' => 'Phone',
                        'whatsapp' => 'WhatsApp',
                        'kingschat' => 'KingsChat',
                    ];

                    $channelColors = [
                        'skype' => 'from-blue-400 to-blue-600',
                        'email' => 'from-red-400 to-red-600',
                        'phone' => 'from-green-400 to-green-600',
                        'whatsapp' => 'from-green-500 to-green-700',
                        'kingschat' => 'from-purple-400 to-purple-600',
                    ];

                    $icon = $channelIcons[$channel->channel_type] ?? 'fa-link';
                    $label = $channelLabels[$channel->channel_type] ?? ucfirst($channel->channel_type);
                    $gradient = $channelColors[$channel->channel_type] ?? 'from-gray-400 to-gray-600';

                    // Build URL based on channel type
                    switch ($channel->channel_type) {
                        case 'skype':
                            $url = 'skype:' . $channel->value . '?chat';
                            break;
                        case 'email':
                            $url = 'mailto:' . $channel->value;
                            break;
                        case 'phone':
                            $url = 'tel:' . $channel->value;
                            break;
                        case 'whatsapp':
                            $phone = preg_replace('/[^0-9]/', '', $channel->value);
                            $message = urlencode('Hello! I would like to inquire about your services.');
                            $url = 'https://wa.me/' . $phone . '?text=' . $message;
                            break;
                        case 'kingschat':
                            $url = $channel->value;
                            break;
                        default:
                            $url = '#';
                    }
                @endphp

                <a href="{{ $url }}"
                   target="{{ $channel->channel_type === 'email' || $channel->channel_type === 'phone' ? '_self' : '_blank' }}"
                   rel="{{ $channel->channel_type !== 'email' && $channel->channel_type !== 'phone' ? 'noopener noreferrer' : '' }}"
                   class="group"
                   x-data="{ shown: false }"
                   x-intersect="shown = true">
                    <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200 hover:border-orange-400 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                         style="transition-delay: {{ $index * 100 }}ms;">

                        <!-- Icon -->
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br {{ $gradient }} rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fab {{ $icon }} text-white text-xl"></i>
                        </div>

                        <!-- Channel Info -->
                        <div class="ml-4 flex-grow">
                            <p class="text-sm font-medium text-gray-500 group-hover:text-orange-600 transition-colors duration-300">
                                {{ $label }}
                            </p>
                            <p class="text-base font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-300">
                                {{ $channel->value }}
                            </p>
                        </div>

                        <!-- Arrow Icon -->
                        <div class="flex-shrink-0">
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 transform group-hover:translate-x-1 transition-all duration-300"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
            <i class="fas fa-address-book text-gray-400 text-4xl mb-3"></i>
            <p class="text-gray-600">Contact channels will appear here.</p>
        </div>
    @endif
</div>
