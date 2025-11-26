<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-{{ $isEditMode ? 'edit' : 'plus-circle' }} mr-3"></i>
                {{ $isEditMode ? 'Edit FAQ' : 'Create New FAQ' }}
            </h2>
            <p class="text-indigo-100 mt-1">
                {{ $isEditMode ? 'Update FAQ details' : 'Add a new frequently asked question' }}
            </p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="save" class="p-6 space-y-8">

            <!-- Question Section -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-question-circle mr-2 text-indigo-600"></i>
                    Question
                </h3>

                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700 mb-2">
                        Question <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="question"
                           wire:model="question"
                           placeholder="Enter the question"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('question')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Answer Section -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-comment-alt mr-2 text-indigo-600"></i>
                    Answer
                </h3>

                <div>
                    <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">
                        Answer <span class="text-red-500">*</span>
                    </label>
                    <div wire:ignore>
                        <textarea id="answer"
                                  wire:model.defer="answer"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                  rows="8"></textarea>
                    </div>
                    @error('answer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Provide a clear and detailed answer
                    </p>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cog mr-2 text-indigo-600"></i>
                    Settings
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                            Display Order
                        </label>
                        <input type="number"
                               id="order"
                               wire:model="order"
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            <i class="fas fa-sort mr-1"></i>
                            Lower numbers appear first
                        </p>
                    </div>

                    <!-- Active Status -->
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       id="is_active"
                                       wire:model="is_active"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900">
                                    {{ $is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            <i class="fas fa-{{ $is_active ? 'eye' : 'eye-slash' }} mr-1"></i>
                            {{ $is_active ? 'Visible on website' : 'Hidden from website' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="border-t border-gray-200 pt-6 flex justify-between items-center">
                <a href="{{ route('admin.faqs.index') }}"
                   class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to FAQs
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isEditMode ? 'Update FAQ' : 'Create FAQ' }}
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', function () {
        initializeFaqTinyMCE();
    });

    document.addEventListener('DOMContentLoaded', function() {
        initializeFaqTinyMCE();
    });

    function initializeFaqTinyMCE() {
        if (typeof tinymce !== 'undefined') {
            tinymce.remove('#answer');
            tinymce.init({
                selector: '#answer',
                height: 300,
                menubar: false,
                plugins: 'lists link code wordcount',
                toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link | removeformat | code',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
                setup: function (editor) {
                    editor.on('init', function () {
                        editor.setContent(@this.answer || '');
                    });
                    editor.on('blur', function () {
                        @this.set('answer', editor.getContent());
                    });
                }
            });
        }
    }

    document.addEventListener('livewire:navigating', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.remove('#answer');
        }
    });
</script>
@endpush
