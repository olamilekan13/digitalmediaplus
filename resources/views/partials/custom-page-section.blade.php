@php
    $content = $section->content;
@endphp

<div id="section-{{ $section->id }}" class="custom-page-section">
    @if($section->type === 'heading')
        <!-- Heading Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $content['title'] ?? '' }}</h2>
            @if(!empty($content['subtitle']))
                <p class="text-lg text-gray-600">{{ $content['subtitle'] }}</p>
            @endif
        </div>

    @elseif($section->type === 'text')
        <!-- Text Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <div class="prose prose-lg max-w-none">
                {!! $content['content'] ?? '' !!}
            </div>
        </div>

    @elseif($section->type === 'image')
        <!-- Image Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            @if(!empty($content['path']))
                @if(!empty($content['link']))
                    <a href="{{ $content['link'] }}" target="_blank" class="block">
                        <img src="{{ Storage::url($content['path']) }}"
                             alt="{{ $content['caption'] ?? '' }}"
                             class="w-full h-auto hover:opacity-90 transition">
                    </a>
                @else
                    <img src="{{ Storage::url($content['path']) }}"
                         alt="{{ $content['caption'] ?? '' }}"
                         class="w-full h-auto">
                @endif
                @if(!empty($content['caption']))
                    <div class="p-4 bg-gray-50">
                        <p class="text-sm text-gray-600 text-center">{{ $content['caption'] }}</p>
                    </div>
                @endif
            @endif
        </div>

    @elseif($section->type === 'video')
        <!-- Video Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            @if(!empty($content['path']))
                <video controls class="w-full h-auto">
                    <source src="{{ Storage::url($content['path']) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @if(!empty($content['caption']))
                    <div class="p-4 bg-gray-50">
                        <p class="text-sm text-gray-600 text-center">{{ $content['caption'] }}</p>
                    </div>
                @endif
            @endif
        </div>

    @elseif($section->type === 'gallery')
        <!-- Gallery Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            @if(!empty($content['images']))
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($content['images'] as $image)
                        <div class="aspect-square overflow-hidden rounded-lg">
                            <img src="{{ Storage::url($image) }}"
                                 alt="Gallery Image"
                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    @elseif($section->type === 'cta')
        <!-- CTA Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8 text-center">
            @if(!empty($content['text']) && !empty($content['link']))
                @php
                    $styleClasses = [
                        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
                        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white',
                        'success' => 'bg-green-600 hover:bg-green-700 text-white',
                        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
                    ];
                    $style = $content['style'] ?? 'primary';
                    $classes = $styleClasses[$style] ?? $styleClasses['primary'];
                @endphp
                <a href="{{ $content['link'] }}"
                   class="inline-flex items-center px-8 py-4 {{ $classes }} rounded-lg font-semibold text-lg transition-colors shadow-lg hover:shadow-xl">
                    {{ $content['text'] }}
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            @endif
        </div>

    @elseif($section->type === 'spacer')
        <!-- Spacer Section -->
        <div style="height: {{ $content['height'] ?? 50 }}px;"></div>
    @endif
</div>
