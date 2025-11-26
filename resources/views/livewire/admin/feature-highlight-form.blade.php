<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-600 to-yellow-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-{{ $isEditMode ? 'edit' : 'plus-circle' }} mr-3"></i>
                {{ $isEditMode ? 'Edit Feature Highlight' : 'Create New Feature Highlight' }}
            </h2>
            <p class="text-orange-100 mt-1">
                {{ $isEditMode ? 'Update feature highlight details' : 'Add a new feature highlight card' }}
            </p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="save" class="p-6 space-y-8">

            <!-- Icon Upload Section -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-icons mr-2 text-orange-600"></i>
                    Feature Icon
                </h3>

                <div class="flex items-start space-x-6">
                    <!-- Current Icon Preview -->
                    <div class="flex-shrink-0">
                        @if ($currentIcon && !$newIcon)
                            <div class="relative">
                                @if(Str::startsWith($currentIcon, 'fa-'))
                                    <div class="w-24 h-24 border-2 border-gray-300 rounded-lg bg-gradient-to-br from-orange-50 to-yellow-50 flex items-center justify-center p-2">
                                        <i class="fas {{ $currentIcon }} text-orange-600 text-4xl"></i>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($currentIcon) }}"
                                         alt="Current Icon"
                                         class="w-24 h-24 object-contain border-2 border-gray-300 rounded-lg bg-gray-50 p-2">
                                @endif
                                <button type="button"
                                        wire:click="removeIcon"
                                        wire:confirm="Are you sure you want to remove the icon?"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        @elseif ($newIcon)
                            <div class="relative">
                                <img src="{{ $newIcon->temporaryUrl() }}"
                                     alt="New Icon Preview"
                                     class="w-24 h-24 object-contain border-2 border-orange-500 rounded-lg bg-gray-50 p-2">
                                <span class="absolute -top-2 -left-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full">
                                    New
                                </span>
                            </div>
                        @else
                            <div class="w-24 h-24 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Upload Input -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Feature Icon
                        </label>
                        <input type="file"
                               wire:model="newIcon"
                               accept="image/jpeg,image/jpg,image/png,image/svg+xml,image/webp"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-orange-50 file:text-orange-700
                                      hover:file:bg-orange-100
                                      cursor-pointer">

                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Accepted formats: JPG, PNG, SVG, WEBP. Maximum size: 2MB. Recommended: 100x100px
                        </p>

                        @error('newIcon')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror

                        <div wire:loading wire:target="newIcon" class="mt-2 text-sm text-orange-600 flex items-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Uploading...
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature Details -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-orange-600"></i>
                    Feature Details
                </h3>

                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Feature Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               wire:model="title"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                               placeholder="e.g., Customer Focus">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <div wire:ignore>
                            <textarea id="description"
                                      wire:model.defer="description"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                      rows="5"></textarea>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            Maximum 1000 characters.
                        </p>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Feature Settings -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-sliders-h mr-2 text-orange-600"></i>
                    Feature Settings
                </h3>

                <div class="space-y-6">
                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                            Display Order
                        </label>
                        <input type="number"
                               id="order"
                               wire:model="order"
                               min="0"
                               class="w-full md:w-48 rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <p class="mt-1 text-xs text-gray-500">
                            Lower numbers appear first. Use for custom sorting.
                        </p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Toggle -->
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div>
                            <label for="is_active" class="text-sm font-medium text-gray-900 flex items-center">
                                <i class="fas fa-toggle-on text-orange-600 mr-2"></i>
                                Feature Active
                            </label>
                            <p class="text-xs text-gray-600 mt-1">
                                Only active features are displayed on the frontend
                            </p>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="is_active"
                                   wire:model="is_active"
                                   class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.feature-highlights.index') }}"
                   class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition inline-flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>

                <button type="submit"
                        wire:loading.attr="disabled"
                        style="background-color: #ea580c !important; color: white !important; padding: 10px 24px; border-radius: 8px; display: inline-flex; align-items: center; font-weight: 600; visibility: visible !important; opacity: 1 !important;">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>
                        Save Feature
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>
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
        initializeFeatureTinyMCE();
    });

    document.addEventListener('DOMContentLoaded', function() {
        initializeFeatureTinyMCE();
    });

    function initializeFeatureTinyMCE() {
        if (typeof tinymce !== 'undefined') {
            tinymce.remove('#description');
            tinymce.init({
                selector: '#description',
                height: 300,
                menubar: false,
                plugins: 'lists link code wordcount',
                toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link | removeformat | code',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
                setup: function (editor) {
                    editor.on('init', function () {
                        editor.setContent(@this.description || '');
                    });
                    editor.on('blur', function () {
                        @this.set('description', editor.getContent());
                    });
                }
            });
        }
    }

    document.addEventListener('livewire:navigating', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.remove('#description');
        }
    });
</script>
@endpush
