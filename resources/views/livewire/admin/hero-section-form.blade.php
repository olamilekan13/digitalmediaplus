<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-flag mr-3"></i>
                Hero Section
            </h2>
            <p class="text-indigo-100 mt-1">Manage your homepage hero banner content</p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="save" class="p-6 space-y-8">

            <!-- Background Image Upload Section -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-image mr-2 text-indigo-600"></i>
                    Background Image
                </h3>

                <div class="space-y-4">
                    <!-- Current/New Image Preview -->
                    <div class="flex justify-center">
                        @if ($currentBackgroundImage && !$newBackgroundImage)
                            <div class="relative w-full max-w-3xl">
                                <img src="{{ Storage::url($currentBackgroundImage) }}"
                                     alt="Current Background"
                                     class="w-full h-64 object-cover border-2 border-gray-300 rounded-lg shadow-md">
                                <button type="button"
                                        wire:click="removeBackgroundImage"
                                        wire:confirm="Are you sure you want to remove the background image?"
                                        class="absolute top-4 right-4 bg-red-500 text-white rounded-full px-4 py-2 flex items-center hover:bg-red-600 transition shadow-lg">
                                    <i class="fas fa-trash mr-2"></i>
                                    Remove
                                </button>
                            </div>
                        @elseif ($newBackgroundImage)
                            <div class="relative w-full max-w-3xl">
                                <img src="{{ $newBackgroundImage->temporaryUrl() }}"
                                     alt="New Background Preview"
                                     class="w-full h-64 object-cover border-2 border-green-500 rounded-lg shadow-md">
                                <span class="absolute top-4 left-4 bg-green-500 text-white text-sm px-3 py-1.5 rounded-full shadow-lg font-medium">
                                    <i class="fas fa-check mr-1"></i>
                                    New Image
                                </span>
                            </div>
                        @else
                            <div class="w-full max-w-3xl h-64 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 flex flex-col items-center justify-center">
                                <i class="fas fa-mountain text-gray-400 text-5xl mb-3"></i>
                                <p class="text-gray-500 font-medium">No background image uploaded</p>
                                <p class="text-gray-400 text-sm mt-1">Upload a hero banner below</p>
                            </div>
                        @endif
                    </div>

                    <!-- Upload Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload New Background Image
                        </label>
                        <input type="file"
                               wire:model="newBackgroundImage"
                               accept="image/jpeg,image/jpg,image/png,image/webp"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100
                                      cursor-pointer">

                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Accepted formats: JPG, JPEG, PNG, WEBP. Maximum size: 5MB. Recommended dimensions: 1920x1080px
                        </p>

                        @error('newBackgroundImage')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror

                        <div wire:loading wire:target="newBackgroundImage" class="mt-2 text-sm text-indigo-600 flex items-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Uploading background image...
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Content -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-align-left mr-2 text-indigo-600"></i>
                    Hero Content
                </h3>

                <div class="space-y-6">
                    <!-- Main Heading -->
                    <div>
                        <label for="heading" class="block text-sm font-medium text-gray-700 mb-2">
                            Main Heading <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="heading"
                               wire:model="heading"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg"
                               placeholder="Enter your main hero heading">
                        <p class="mt-1 text-xs text-gray-500">This will be the primary headline on your homepage</p>
                        @error('heading')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tagline -->
                    <div>
                        <label for="tagline" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-quote-left mr-1"></i> Tagline / Subtitle
                        </label>
                        <div wire:ignore>
                            <textarea id="tagline"
                                      wire:model.defer="tagline"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                      rows="3"></textarea>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Supporting text to elaborate on your main heading</p>
                        @error('tagline')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Call-to-Action Button -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-mouse-pointer mr-2 text-indigo-600"></i>
                    Call-to-Action Button
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- CTA Button Text -->
                    <div>
                        <label for="cta_button_text" class="block text-sm font-medium text-gray-700 mb-2">
                            Button Text
                        </label>
                        <input type="text"
                               id="cta_button_text"
                               wire:model="cta_button_text"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Get Started">
                        <p class="mt-1 text-xs text-gray-500">Text displayed on the CTA button</p>
                        @error('cta_button_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CTA Button Link -->
                    <div>
                        <label for="cta_button_link" class="block text-sm font-medium text-gray-700 mb-2">
                            Button Link (Page Section)
                        </label>
                        <select id="cta_button_link"
                                wire:model="cta_button_link"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Select a section --</option>
                            @foreach($this->getPageSections() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Select which section the button should scroll to</p>
                        @error('cta_button_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- CTA Preview -->
                @if($cta_button_text || $cta_button_link)
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            <i class="fas fa-eye mr-1"></i> Button Preview
                        </p>
                        <button type="button"
                                class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition inline-flex items-center">
                            {{ $cta_button_text ?: 'Button Text' }}
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Status Toggle -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-toggle-on mr-2 text-indigo-600"></i>
                    Visibility Status
                </h3>

                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div>
                        <label for="is_active" class="text-sm font-medium text-gray-900">
                            Hero Section Active
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Toggle to show or hide the hero section on your homepage</p>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox"
                               id="is_active"
                               wire:model="is_active"
                               class="h-6 w-6 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer">
                        <span class="ml-3 text-sm font-medium" :class="$wire.is_active ? 'text-green-600' : 'text-gray-500'">
                            <span wire:if="is_active">
                                <i class="fas fa-check-circle mr-1"></i>
                                Active
                            </span>
                            <span wire:if="!is_active">
                                <i class="fas fa-times-circle mr-1"></i>
                                Inactive
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <button type="button"
                        onclick="window.location.href='{{ route('admin.dashboard') }}'"
                        class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </button>

                <button type="submit"
                        wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save mr-2"></i>
                        Save Hero Section
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', function () {
        initializeHeroTinyMCE();
    });

    document.addEventListener('DOMContentLoaded', function() {
        initializeHeroTinyMCE();
    });

    function initializeHeroTinyMCE() {
        if (typeof tinymce !== 'undefined') {
            tinymce.remove('#tagline');
            tinymce.init({
                selector: '#tagline',
                height: 200,
                menubar: false,
                plugins: 'lists link code wordcount',
                toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link | removeformat | code',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
                setup: function (editor) {
                    editor.on('init', function () {
                        editor.setContent(@this.tagline || '');
                    });
                    editor.on('blur', function () {
                        @this.set('tagline', editor.getContent());
                    });
                }
            });
        }
    }

    document.addEventListener('livewire:navigating', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.remove('#tagline');
        }
    });
</script>
@endpush
