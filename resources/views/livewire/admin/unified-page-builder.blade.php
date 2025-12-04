<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header with Save Button -->
    <div class="bg-white rounded-lg shadow-md mb-6 sticky top-0 z-40">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-white">
                    {{ $isEditMode ? 'Edit Page: ' . $title : 'Create New Page' }}
                </h1>
                <div class="flex items-center space-x-3">
                    @if($page)
                        <a href="{{ route('page.show', $page->slug) }}" target="_blank"
                           class="px-4 py-2 bg-white text-purple-700 rounded-lg hover:bg-purple-50 transition">
                            <i class="fas fa-eye mr-2"></i>Preview
                        </a>
                    @endif
                    <button wire:click="savePage"
                            class="px-6 py-2 bg-white text-purple-700 rounded-lg hover:bg-purple-50 transition font-semibold">
                        <i class="fas fa-save mr-2"></i>{{ $isEditMode ? 'Update' : 'Save' }} Page
                    </button>
                    <a href="{{ route('admin.custom-pages.index') }}"
                       class="px-4 py-2 bg-purple-800 text-white rounded-lg hover:bg-purple-900 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content Area (Left Side - 2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Page Settings Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cog mr-2 text-purple-600"></i>
                    Page Settings
                </h2>

                <div class="space-y-4">
                    <!-- Page Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Page Title *</label>
                        <input type="text" wire:model.live="title"
                               class="w-full text-2xl font-bold rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Enter page title...">
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- URL Slug -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug *</label>
                        <div class="flex items-center">
                            <span class="text-gray-500 text-sm mr-2">{{ url('/') }}/</span>
                            <input type="text" wire:model="slug"
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                   placeholder="page-url">
                        </div>
                        @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Page Content/Sections -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-th-list mr-2 text-purple-600"></i>
                        Page Content
                    </h2>
                </div>

                <!-- Add Section Buttons -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-700 mb-3 font-medium">Add Section:</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <button wire:click="openSectionModal('heading')" type="button"
                                class="px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
                            <i class="fas fa-heading mr-1"></i>Heading
                        </button>
                        <button wire:click="openSectionModal('text')" type="button"
                                class="px-3 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition text-sm font-medium">
                            <i class="fas fa-align-left mr-1"></i>Rich Text
                        </button>
                        <button wire:click="openSectionModal('image')" type="button"
                                class="px-3 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-sm font-medium">
                            <i class="fas fa-image mr-1"></i>Image
                        </button>
                        <button wire:click="openSectionModal('video')" type="button"
                                class="px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                            <i class="fas fa-video mr-1"></i>Video
                        </button>
                        <button wire:click="openSectionModal('gallery')" type="button"
                                class="px-3 py-2 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition text-sm font-medium">
                            <i class="fas fa-images mr-1"></i>Gallery
                        </button>
                        <button wire:click="openSectionModal('cta')" type="button"
                                class="px-3 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition text-sm font-medium">
                            <i class="fas fa-mouse-pointer mr-1"></i>Button
                        </button>
                        <button wire:click="openSectionModal('spacer')" type="button"
                                class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                            <i class="fas fa-arrows-alt-v mr-1"></i>Spacer
                        </button>
                    </div>
                </div>

                <!-- Sections List -->
                <div class="space-y-3">
                    @if(!$page)
                        <div class="text-center py-8 bg-blue-50 rounded-lg border-2 border-dashed border-blue-200">
                            <i class="fas fa-info-circle text-blue-500 text-3xl mb-2"></i>
                            <p class="text-blue-700 font-medium">Save the page first to start adding content sections</p>
                            <button wire:click="savePage" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-save mr-2"></i>Save Page Now
                            </button>
                        </div>
                    @elseif(empty($sections) || count($sections) === 0)
                        <div class="text-center py-12 bg-purple-50 rounded-lg border-2 border-dashed border-purple-200">
                            <i class="fas fa-th-list text-purple-400 text-5xl mb-3"></i>
                            <p class="text-purple-900 font-medium text-lg">No content sections yet</p>
                            <p class="text-purple-700 text-sm mt-1">Click a section type button above to add your first section</p>
                        </div>
                    @else
                        @foreach($sections as $section)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 hover:shadow-md transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded uppercase flex-shrink-0">
                                            {{ $section->type }}
                                        </span>
                                        <div class="text-sm text-gray-900 flex-1 truncate">
                                            @if($section->type === 'heading')
                                                <strong>{{ $section->content['title'] ?? 'Untitled Heading' }}</strong>
                                                @if(!empty($section->content['subtitle']))
                                                    <span class="text-gray-500"> - {{ Str::limit(strip_tags($section->content['subtitle']), 50) }}</span>
                                                @endif
                                            @elseif($section->type === 'text')
                                                {{ Str::limit(strip_tags($section->content['content'] ?? ''), 80) }}
                                            @elseif($section->type === 'image')
                                                Image{{ !empty($section->content['caption']) ? ': ' . $section->content['caption'] : '' }}
                                            @elseif($section->type === 'video')
                                                Video{{ !empty($section->content['caption']) ? ': ' . $section->content['caption'] : '' }}
                                            @elseif($section->type === 'gallery')
                                                Gallery ({{ count($section->content['images'] ?? []) }} images)
                                            @elseif($section->type === 'cta')
                                                Button: {{ $section->content['text'] ?? '' }}
                                            @elseif($section->type === 'spacer')
                                                Spacer ({{ $section->content['height'] ?? 50 }}px)
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-1 flex-shrink-0 ml-4">
                                        <button wire:click="moveUp({{ $section->id }})" type="button"
                                                class="p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded transition"
                                                title="Move Up">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                        <button wire:click="moveDown({{ $section->id }})" type="button"
                                                class="p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded transition"
                                                title="Move Down">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                        <button wire:click="toggleSectionActive({{ $section->id }})" type="button"
                                                class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors {{ $section->is_active ? 'bg-green-600' : 'bg-gray-200' }}"
                                                title="Toggle Active">
                                            <span class="inline-block w-4 h-4 bg-white rounded-full transform transition {{ $section->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                        <button wire:click="editSection({{ $section->id }})" type="button"
                                                class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded transition"
                                                title="Edit Section">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="confirmDelete({{ $section->id }})" type="button"
                                                class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition"
                                                title="Delete Section">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar (Right Side - 1/3) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Publish Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-paper-plane mr-2 text-purple-600"></i>
                    Publish
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 font-medium">Status:</span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $is_active ? 'Published' : 'Draft' }}
                        </span>
                    </div>

                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <input type="checkbox" wire:model.live="is_active" id="is_active"
                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <label for="is_active" class="ml-2 text-sm text-gray-700 font-medium">Publish this page</label>
                    </div>

                    <button wire:click="savePage"
                            class="w-full px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                        <i class="fas fa-save mr-2"></i>{{ $isEditMode ? 'Update' : 'Publish' }} Page
                    </button>
                </div>
            </div>

            <!-- Page Layout -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-th-large mr-2 text-purple-600"></i>
                    Page Layout
                </h3>

                <div class="space-y-2">
                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition {{ $layout === 'full-width' ? 'border-purple-500 bg-purple-50' : 'border-gray-200' }}">
                        <input type="radio" wire:model.live="layout" value="full-width" class="text-purple-600 focus:ring-purple-500">
                        <span class="ml-3 text-sm font-medium">Full Width</span>
                    </label>
                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition {{ $layout === 'two-column' ? 'border-purple-500 bg-purple-50' : 'border-gray-200' }}">
                        <input type="radio" wire:model.live="layout" value="two-column" class="text-purple-600 focus:ring-purple-500">
                        <span class="ml-3 text-sm font-medium">Two Column</span>
                    </label>
                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition {{ $layout === 'sidebar-left' ? 'border-purple-500 bg-purple-50' : 'border-gray-200' }}">
                        <input type="radio" wire:model.live="layout" value="sidebar-left" class="text-purple-600 focus:ring-purple-500">
                        <span class="ml-3 text-sm font-medium">Sidebar Left</span>
                    </label>
                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition {{ $layout === 'sidebar-right' ? 'border-purple-500 bg-purple-50' : 'border-gray-200' }}">
                        <input type="radio" wire:model.live="layout" value="sidebar-right" class="text-purple-600 focus:ring-purple-500">
                        <span class="ml-3 text-sm font-medium">Sidebar Right</span>
                    </label>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-search mr-2 text-purple-600"></i>
                    SEO Settings
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" wire:model="meta_title"
                               class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="SEO title (optional)">
                        <p class="mt-1 text-xs text-gray-500">Leave empty to use page title</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea wire:model="meta_description" rows="3"
                                  class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                  placeholder="SEO description (optional)"></textarea>
                        <p class="mt-1 text-xs text-gray-500">{{ strlen($meta_description ?? '') }}/500 characters</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Modal -->
    @if($showSectionModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4" x-data x-init="document.body.style.overflow = 'hidden'" x-destroy="document.body.style.overflow = 'auto'">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between z-10">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ $sectionId ? 'Edit' : 'Add' }} {{ ucfirst($sectionType) }} Section
                </h3>
                <button wire:click="closeSectionModal" type="button" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form wire:submit.prevent="saveSection" class="p-6 space-y-5">
                @if($sectionType === 'heading')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Heading Title *</label>
                        <input type="text" wire:model="heading_title"
                               class="w-full text-xl font-bold rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Enter heading...">
                        @error('heading_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle (Optional) - Rich Text Editor</label>
                        <div wire:ignore>
                            <textarea id="heading_subtitle_editor_{{ $sectionId ?? 'new' }}" class="w-full border-gray-300 rounded-lg">{{ $heading_subtitle }}</textarea>
                        </div>
                        <script>
                            document.addEventListener('livewire:initialized', () => {
                                const editorId = 'heading_subtitle_editor_{{ $sectionId ?? "new" }}';
                                if (typeof ClassicEditor !== 'undefined' && document.getElementById(editorId)) {
                                    ClassicEditor.create(document.getElementById(editorId))
                                        .then(editor => {
                                            editor.model.document.on('change:data', () => {
                                                @this.set('heading_subtitle', editor.getData());
                                            });
                                        })
                                        .catch(error => console.error(error));
                                }
                            });
                        </script>
                    </div>

                @elseif($sectionType === 'text')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Content * - Rich Text Editor</label>
                        <div wire:ignore>
                            <textarea id="text_content_editor_{{ $sectionId ?? 'new' }}" rows="15" class="w-full border-gray-300 rounded-lg">{{ $text_content }}</textarea>
                        </div>
                        @error('text_content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <script>
                            document.addEventListener('livewire:initialized', () => {
                                const editorId = 'text_content_editor_{{ $sectionId ?? "new" }}';
                                if (typeof ClassicEditor !== 'undefined' && document.getElementById(editorId)) {
                                    ClassicEditor.create(document.getElementById(editorId))
                                        .then(editor => {
                                            editor.model.document.on('change:data', () => {
                                                @this.set('text_content', editor.getData());
                                            });
                                        })
                                        .catch(error => console.error(error));
                                }
                            });
                        </script>
                    </div>

                @elseif($sectionType === 'image')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image {{ $sectionId ? '' : '*' }}</label>
                        <input type="file" wire:model="image_file" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                        @if($current_image)
                            <div class="mt-3">
                                <img src="{{ Storage::url($current_image) }}" class="h-40 rounded-lg border shadow-sm">
                            </div>
                        @endif
                        @error('image_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="image_file" class="mt-2 text-sm text-purple-600">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Uploading...
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Caption (Optional)</label>
                        <input type="text" wire:model="image_caption"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Image caption...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link URL (Optional)</label>
                        <input type="url" wire:model="image_link"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="https://...">
                        @error('image_link') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                @elseif($sectionType === 'video')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video File {{ $sectionId ? '' : '*' }}</label>
                        <input type="file" wire:model="video_file" accept="video/mp4,video/webm,video/ogg"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer">
                        @if($current_video)
                            <p class="mt-2 text-sm text-gray-600"><i class="fas fa-video mr-1"></i> Current: {{ basename($current_video) }}</p>
                        @endif
                        @error('video_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="video_file" class="mt-2 text-sm text-red-600">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Uploading video... (this may take a while)
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Accepted: MP4, WebM, OGG. Max 50MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Caption (Optional)</label>
                        <input type="text" wire:model="video_caption"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Video caption...">
                    </div>

                @elseif($sectionType === 'gallery')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Images (Multiple)</label>
                        <input type="file" wire:model="gallery_images" multiple accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 cursor-pointer">
                        <div wire:loading wire:target="gallery_images" class="mt-2 text-sm text-yellow-600">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Uploading images...
                        </div>
                        @if(!empty($current_gallery))
                            <div class="mt-4 grid grid-cols-4 gap-2">
                                @foreach($current_gallery as $index => $image)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($image) }}" class="h-24 w-full object-cover rounded border shadow-sm">
                                        <button type="button" wire:click="removeGalleryImage({{ $index }})"
                                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 text-xs hover:bg-red-600 opacity-0 group-hover:opacity-100 transition">
                                            ×
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                @elseif($sectionType === 'cta')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Text *</label>
                        <input type="text" wire:model="cta_text"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Get Started, Learn More, etc.">
                        @error('cta_text') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Link *</label>
                        <input type="url" wire:model="cta_link"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="https://...">
                        @error('cta_link') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Style</label>
                        <select wire:model="cta_style" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="primary">Primary (Blue)</option>
                            <option value="secondary">Secondary (Gray)</option>
                            <option value="success">Success (Green)</option>
                            <option value="danger">Danger (Red)</option>
                        </select>
                    </div>

                @elseif($sectionType === 'spacer')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Height (pixels) *</label>
                        <input type="number" wire:model="spacer_height" min="10" max="500"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        @error('spacer_height') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500">Between 10px and 500px</p>
                    </div>
                @endif

                <div class="flex items-center pt-2 p-3 bg-gray-50 rounded-lg">
                    <input type="checkbox" wire:model="section_is_active" id="section_is_active"
                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    <label for="section_is_active" class="ml-2 text-sm text-gray-700 font-medium">Show this section on the page</label>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="closeSectionModal"
                            class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-5 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                        <i class="fas fa-check mr-2"></i>{{ $sectionId ? 'Update' : 'Add' }} Section
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Delete Section</h3>
            <p class="text-gray-600 text-center mb-6">Are you sure you want to delete this section? This action cannot be undone.</p>
            <div class="flex space-x-3">
                <button wire:click="cancelDelete"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button wire:click="deleteSection"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Delete
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
