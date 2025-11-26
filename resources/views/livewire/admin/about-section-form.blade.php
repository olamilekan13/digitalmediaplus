<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-building mr-3"></i>
                About Section
            </h2>
            <p class="text-purple-100 mt-1">Manage your company's about section content</p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="save" class="p-6 space-y-8">

            <!-- Company Image Upload Section -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-image mr-2 text-purple-600"></i>
                    Company Image
                </h3>

                <div class="space-y-4">
                    <!-- Current/New Image Preview -->
                    <div class="flex justify-center">
                        @if ($currentImage && !$newImage)
                            <div class="relative w-full max-w-2xl">
                                <img src="{{ Str::startsWith($currentImage, 'http') ? $currentImage : Storage::url($currentImage) }}"
                                     alt="Current Company Image"
                                     class="w-full h-64 object-cover border-2 border-gray-300 rounded-lg shadow-md">
                                <button type="button"
                                        wire:click="removeImage"
                                        wire:confirm="Are you sure you want to remove the company image?"
                                        class="absolute top-4 right-4 bg-red-500 text-white rounded-full px-4 py-2 flex items-center hover:bg-red-600 transition shadow-lg">
                                    <i class="fas fa-trash mr-2"></i>
                                    Remove
                                </button>
                            </div>
                        @elseif ($newImage)
                            <div class="relative w-full max-w-2xl">
                                <img src="{{ $newImage->temporaryUrl() }}"
                                     alt="New Company Image Preview"
                                     class="w-full h-64 object-cover border-2 border-green-500 rounded-lg shadow-md">
                                <span class="absolute top-4 left-4 bg-green-500 text-white text-sm px-3 py-1.5 rounded-full shadow-lg font-medium">
                                    <i class="fas fa-check mr-1"></i>
                                    New Image
                                </span>
                            </div>
                        @else
                            <div class="w-full max-w-2xl h-64 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 flex flex-col items-center justify-center">
                                <i class="fas fa-building text-gray-400 text-5xl mb-3"></i>
                                <p class="text-gray-500 font-medium">No company image uploaded</p>
                                <p class="text-gray-400 text-sm mt-1">Upload an image below</p>
                            </div>
                        @endif
                    </div>

                    <!-- Upload Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload New Company Image
                        </label>
                        <input type="file"
                               wire:model="newImage"
                               accept="image/jpeg,image/jpg,image/png,image/webp"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-purple-50 file:text-purple-700
                                      hover:file:bg-purple-100
                                      cursor-pointer">

                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Accepted formats: JPG, JPEG, PNG, WEBP. Maximum size: 2MB
                        </p>

                        @error('newImage')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror

                        <div wire:loading wire:target="newImage" class="mt-2 text-sm text-purple-600 flex items-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Uploading image...
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Content -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-align-left mr-2 text-purple-600"></i>
                    About Content
                </h3>

                <div class="space-y-6">
                    <!-- Section Heading -->
                    <div>
                        <label for="heading" class="block text-sm font-medium text-gray-700 mb-2">
                            Section Heading <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="heading"
                               wire:model="heading"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-lg"
                               placeholder="Enter section heading">
                        <p class="mt-1 text-xs text-gray-500">Main heading for the about section</p>
                        @error('heading')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Description (WYSIWYG) -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-file-alt mr-1"></i> Company Description
                        </label>
                        <div wire:ignore>
                            <textarea id="description"
                                      wire:model.defer="description"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                      rows="8"></textarea>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Brief description of your company</p>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Our Story (WYSIWYG) -->
                    <div>
                        <label for="story_text" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-book-open mr-1"></i> Our Story
                        </label>
                        <div wire:ignore>
                            <textarea id="story_text"
                                      wire:model.defer="story_text"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                      rows="10"></textarea>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Tell your company's story and journey</p>
                        @error('story_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status Toggle -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-toggle-on mr-2 text-purple-600"></i>
                    Visibility Status
                </h3>

                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div>
                        <label for="is_active" class="text-sm font-medium text-gray-900">
                            About Section Active
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Toggle to show or hide the about section</p>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox"
                               id="is_active"
                               wire:model="is_active"
                               class="h-6 w-6 text-purple-600 focus:ring-purple-500 border-gray-300 rounded cursor-pointer">
                        <span class="ml-3 text-sm font-medium" :class="$wire.is_active ? 'text-green-600' : 'text-gray-500'">
                            @if($is_active)
                                <i class="fas fa-check-circle mr-1"></i>
                                Active
                            @else
                                <i class="fas fa-times-circle mr-1"></i>
                                Inactive
                            @endif
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
                        style="background-color: #9333ea !important; color: white !important; padding: 10px 24px; border-radius: 8px; display: inline-flex; align-items: center; font-weight: 600; visibility: visible !important; opacity: 1 !important;">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>
                        Save About Section
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
    let descriptionEditor, storyTextEditor;

    document.addEventListener('livewire:initialized', function () {
        initializeAboutCKEditors();
    });

    document.addEventListener('livewire:navigated', function () {
        initializeAboutCKEditors();
    });

    function initializeAboutCKEditors() {
        setTimeout(() => {
            if (typeof ClassicEditor !== 'undefined') {
                // Initialize Description Editor
                const descriptionElement = document.querySelector('#description');
                if (descriptionElement) {
                    if (descriptionEditor) {
                        descriptionEditor.destroy().catch(error => console.log(error));
                    }

                    ClassicEditor
                        .create(descriptionElement, {
                            toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link'],
                        })
                        .then(editor => {
                            descriptionEditor = editor;
                            const initialDescription = @this.get('description') || '';
                            editor.setData(initialDescription);
                            editor.model.document.on('change:data', () => {
                                @this.set('description', editor.getData());
                            });
                        })
                        .catch(error => console.error('CKEditor description error:', error));
                }

                // Initialize Story Text Editor
                const storyTextElement = document.querySelector('#story_text');
                if (storyTextElement) {
                    if (storyTextEditor) {
                        storyTextEditor.destroy().catch(error => console.log(error));
                    }

                    ClassicEditor
                        .create(storyTextElement, {
                            toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link'],
                        })
                        .then(editor => {
                            storyTextEditor = editor;
                            const initialStoryText = @this.get('story_text') || '';
                            editor.setData(initialStoryText);
                            editor.model.document.on('change:data', () => {
                                @this.set('story_text', editor.getData());
                            });
                        })
                        .catch(error => console.error('CKEditor story_text error:', error));
                }
            }
        }, 100);
    }

    document.addEventListener('livewire:navigating', function () {
        if (descriptionEditor) descriptionEditor.destroy().catch(error => console.log(error));
        if (storyTextEditor) storyTextEditor.destroy().catch(error => console.log(error));
    });
</script>
@endpush
