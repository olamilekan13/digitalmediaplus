<form class="space-y-6" wire:submit.prevent="submit">
    <h3 class="text-2xl font-bold text-gray-900">Send Us a Message</h3>
    <p class="text-gray-600 leading-relaxed">
        Fill out the form below and we'll get back to you as soon as possible.
    </p>

    <!-- Success Message -->
    @if($successMessage)
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             class="p-4 bg-green-50 border border-green-200 rounded-lg flex items-start">
            <i class="fas fa-check-circle text-green-600 text-xl mt-0.5 mr-3"></i>
            <div class="flex-grow">
                <p class="text-green-800 font-medium">{{ $successMessage }}</p>
            </div>
            <button @click="show = false"
                    class="ml-3 text-green-600 hover:text-green-800 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Contact Form Fields -->
    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
            Name <span class="text-red-500">*</span>
        </label>
        <input type="text"
               id="name"
               wire:model.live.debounce.300ms="name"
               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('name') border-red-500 @else border-gray-300 @enderror"
               placeholder="Your full name">
        @error('name')
            <p class="mt-2 text-sm text-red-600 flex items-center">
                <i class="fas fa-exclamation-circle mr-1"></i>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
            Email <span class="text-red-500">*</span>
        </label>
        <input type="email"
               id="email"
               wire:model.live.debounce.300ms="email"
               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('email') border-red-500 @else border-gray-300 @enderror"
               placeholder="your.email@example.com">
        @error('email')
            <p class="mt-2 text-sm text-red-600 flex items-center">
                <i class="fas fa-exclamation-circle mr-1"></i>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Phone Field (Optional) -->
    <div>
        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
            Phone <span class="text-gray-400 text-xs">(Optional)</span>
        </label>
        <input type="tel"
               id="phone"
               wire:model.live.debounce.300ms="phone"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
               placeholder="+1 (555) 000-0000">
        @error('phone')
            <p class="mt-2 text-sm text-red-600 flex items-center">
                <i class="fas fa-exclamation-circle mr-1"></i>
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Message Field -->
    <div>
        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
            Message <span class="text-red-500">*</span>
        </label>
        <textarea id="message"
                  wire:model.live.debounce.300ms="message"
                  rows="5"
                  class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 resize-none @error('message') border-red-500 @else border-gray-300 @enderror"
                  placeholder="Tell us what's on your mind..."></textarea>

        <!-- Character Counter -->
        <div class="mt-2 flex items-center justify-between">
            @error('message')
                <p class="text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @else
                <p class="text-sm text-gray-500">
                    Minimum 10 characters
                </p>
            @enderror

            <p class="text-sm text-gray-500">
                {{ strlen($this->message) }} / 2000
            </p>
        </div>
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit"
                wire:loading.attr="disabled"
                class="w-full px-8 py-4 bg-gradient-to-r from-orange-600 to-yellow-600 text-white text-lg font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center">

            <span wire:loading.remove wire:target="submit">
                <i class="fas fa-paper-plane mr-2"></i>
                Send Message
            </span>

            <span wire:loading wire:target="submit">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Sending...
            </span>
        </button>
    </div>

    <!-- Privacy Notice -->
    <p class="text-xs text-gray-500 text-center">
        We respect your privacy. Your information will never be shared with third parties.
    </p>
</form>
