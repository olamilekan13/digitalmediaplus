<div>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-file-alt mr-3"></i>
                    {{ $isEditMode ? 'Edit Page' : 'Create New Page' }}
                </h2>
            </div>

            <div class="p-6">
                <!-- Page Title -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Page Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           wire:model.live="title"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                           placeholder="Enter page title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Page Slug -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Page Slug <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center">
                        <span class="text-gray-500 text-sm mr-2">{{ url('/') }}/</span>
                        <input type="text"
                               wire:model="slug"
                               class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="page-slug">
                    </div>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Page Heading -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Page Heading (H3) <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           wire:model="heading"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                           placeholder="Enter page heading">
                    @error('heading')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Page Content -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Page Content <span class="text-red-500">*</span>
                    </label>
                    <div wire:ignore>
                        <textarea id="content-editor" class="w-full rounded-lg border-gray-300 shadow-sm">{{ $content }}</textarea>
                    </div>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox"
                               wire:model="is_active"
                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Publish this page (make it active)</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.custom-pages.index') }}"
                       class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Pages
                    </a>
                    <button wire:click="savePage"
                            class="px-8 py-2.5 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition shadow-lg flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        {{ $isEditMode ? 'Update Page' : 'Publish Page' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            let editor;

            // Custom upload adapter
            class MyUploadAdapter {
                constructor(loader) {
                    this.loader = loader;
                }

                upload() {
                    return this.loader.file
                        .then(file => new Promise((resolve, reject) => {
                            const data = new FormData();
                            data.append('upload', file);

                            fetch('{{ route("admin.upload-image") }}', {
                                method: 'POST',
                                body: data,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.uploaded) {
                                    resolve({
                                        default: result.url
                                    });
                                } else {
                                    reject(result.error.message);
                                }
                            })
                            .catch(error => {
                                reject('Upload failed');
                            });
                        }));
                }

                abort() {
                    // Handle abort
                }
            }

            function MyCustomUploadAdapterPlugin(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return new MyUploadAdapter(loader);
                };
            }

            ClassicEditor
                .create(document.getElementById('content-editor'), {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', '|',
                            'bulletedList', 'numberedList', '|',
                            'imageUpload', 'blockQuote', 'insertTable', '|',
                            'undo', 'redo'
                        ]
                    },
                    image: {
                        toolbar: [
                            'imageTextAlternative', '|',
                            'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'
                        ]
                    }
                })
                .then(newEditor => {
                    editor = newEditor;

                    // Update Livewire when editor content changes
                    editor.model.document.on('change:data', () => {
                        @this.set('content', editor.getData());
                    });
                })
                .catch(error => {
                    console.error('CKEditor initialization error:', error);
                });

            // Update editor when Livewire updates the content
            Livewire.hook('morph.updated', ({ el, component }) => {
                if (editor && component.fingerprint.name === 'admin.simple-page-builder') {
                    const currentContent = @this.get('content');
                    if (editor.getData() !== currentContent) {
                        editor.setData(currentContent || '');
                    }
                }
            });
        });
    </script>
    @endpush
</div>
