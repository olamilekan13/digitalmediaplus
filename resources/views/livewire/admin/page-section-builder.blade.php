<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-th-list mr-3"></i>
                        {{ $page->title }} - Section Builder
                    </h2>
                    <p class="text-purple-100 mt-1">Add and organize sections with up/down arrows</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('page.show', $page->slug) }}" target="_blank"
                       class="px-4 py-2 bg-white text-purple-700 rounded-lg hover:bg-purple-50 transition flex items-center">
                        <i class="fas fa-eye mr-2"></i>Preview
                    </a>
                    <a href="{{ route('admin.custom-pages.index') }}"
                       class="px-4 py-2 bg-white text-purple-700 rounded-lg hover:bg-purple-50 transition flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Add Section Buttons -->
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Add New Section:</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2">
                <button wire:click="openSectionModal('heading')"
                        class="px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
                    <i class="fas fa-heading mr-1"></i>Heading
                </button>
                <button wire:click="openSectionModal('text')"
                        class="px-3 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition text-sm font-medium">
                    <i class="fas fa-align-left mr-1"></i>Text
                </button>
                <button wire:click="openSectionModal('image')"
                        class="px-3 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-sm font-medium">
                    <i class="fas fa-image mr-1"></i>Image
                </button>
                <button wire:click="openSectionModal('video')"
                        class="px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                    <i class="fas fa-video mr-1"></i>Video
                </button>
                <button wire:click="openSectionModal('gallery')"
                        class="px-3 py-2 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition text-sm font-medium">
                    <i class="fas fa-images mr-1"></i>Gallery
                </button>
                <button wire:click="openSectionModal('cta')"
                        class="px-3 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition text-sm font-medium">
                    <i class="fas fa-mouse-pointer mr-1"></i>CTA
                </button>
                <button wire:click="openSectionModal('spacer')"
                        class="px-3 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition text-sm font-medium">
                    <i class="fas fa-arrows-alt-v mr-1"></i>Spacer
                </button>
            </div>
        </div>
    </div>

    <!-- Sections List -->
    <div class="space-y-4">
        @forelse($sections as $section)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 flex-1">
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full uppercase">
                                {{ $section->type }}
                            </span>
                            <div class="text-sm text-gray-900 flex-1">
                                @if($section->type === 'heading')
                                    <strong>{{ $section->content['title'] ?? 'Untitled' }}</strong>
                                    @if(!empty($section->content['subtitle']))
                                        <span class="text-gray-500"> - {{ $section->content['subtitle'] }}</span>
                                    @endif
                                @elseif($section->type === 'text')
                                    {{ Str::limit(strip_tags($section->content['content'] ?? ''), 100) }}
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

                        <div class="flex items-center space-x-2">
                            <!-- Move Up -->
                            <button wire:click="moveUp({{ $section->id }})"
                                    class="p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded transition"
                                    title="Move Up">
                                <i class="fas fa-arrow-up"></i>
                            </button>

                            <!-- Move Down -->
                            <button wire:click="moveDown({{ $section->id }})"
                                    class="p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded transition"
                                    title="Move Down">
                                <i class="fas fa-arrow-down"></i>
                            </button>

                            <!-- Active Toggle -->
                            <button wire:click="toggleSectionActive({{ $section->id }})"
                                    class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors focus:outline-none {{ $section->is_active ? 'bg-green-600' : 'bg-gray-200' }}"
                                    title="{{ $section->is_active ? 'Active' : 'Inactive' }}">
                                <span class="inline-block w-4 h-4 transform transition-transform bg-white rounded-full {{ $section->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>

                            <!-- Edit -->
                            <button wire:click="editSection({{ $section->id }})"
                                    class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded transition"
                                    title="Edit Section">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Delete -->
                            <button wire:click="confirmDelete({{ $section->id }})"
                                    class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition"
                                    title="Delete Section">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-th-list text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No sections yet</h3>
                <p class="text-gray-500">Click one of the section type buttons above to add your first section</p>
            </div>
        @endforelse
    </div>

    <!-- Section Modal -->
    @if($showSectionModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ $sectionId ? 'Edit' : 'Add' }} {{ ucfirst($sectionType) }} Section
                </h3>
            </div>

            <form wire:submit.prevent="saveSection" class="p-6 space-y-4">
                @if($sectionType === 'heading')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" wire:model="heading_title"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        @error('heading_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                        <input type="text" wire:model="heading_subtitle"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        @error('heading_subtitle') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                @elseif($sectionType === 'text')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                        <div wire:ignore>
                            <textarea id="textContent" rows="10"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">{{ $text_content }}</textarea>
                        </div>
                        @error('text_content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            if (typeof ClassicEditor !== 'undefined') {
                                ClassicEditor.create(document.querySelector('#textContent'))
                                    .then(editor => {
                                        editor.model.document.on('change:data', () => {
                                            @this.set('text_content', editor.getData());
                                        });
                                    })
                                    .catch(error => console.error(error));
                            }
                        });
                    </script>

                @elseif($sectionType === 'image')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image {{ $sectionId ? '' : '*' }}</label>
                        <input type="file" wire:model="image_file" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        @if($current_image)
                            <img src="{{ Storage::url($current_image) }}" class="mt-2 h-32 rounded border">
                        @endif
                        @error('image_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="image_file" class="mt-2 text-sm text-purple-600">Uploading...</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Caption</label>
                        <input type="text" wire:model="image_caption" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link URL (optional)</label>
                        <input type="url" wire:model="image_link" placeholder="https://" class="w-full rounded-lg border-gray-300">
                        @error('image_link') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                @elseif($sectionType === 'video')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video File {{ $sectionId ? '' : '*' }}</label>
                        <input type="file" wire:model="video_file" accept="video/mp4,video/webm,video/ogg"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                        @if($current_video)
                            <p class="mt-2 text-sm text-gray-600"><i class="fas fa-video mr-1"></i> Current: {{ basename($current_video) }}</p>
                        @endif
                        @error('video_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="video_file" class="mt-2 text-sm text-red-600">Uploading video...</div>
                        <p class="mt-1 text-xs text-gray-500">Accepted: MP4, WebM, OGG. Max 50MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Caption</label>
                        <input type="text" wire:model="video_caption" class="w-full rounded-lg border-gray-300">
                    </div>

                @elseif($sectionType === 'gallery')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Images</label>
                        <input type="file" wire:model="gallery_images" multiple accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                        <div wire:loading wire:target="gallery_images" class="mt-2 text-sm text-yellow-600">Uploading images...</div>
                        @if(!empty($current_gallery))
                            <div class="mt-4 grid grid-cols-4 gap-2">
                                @foreach($current_gallery as $index => $image)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($image) }}" class="h-24 w-full object-cover rounded border">
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
                        <input type="text" wire:model="cta_text" placeholder="Get Started" class="w-full rounded-lg border-gray-300">
                        @error('cta_text') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Link *</label>
                        <input type="url" wire:model="cta_link" placeholder="https://" class="w-full rounded-lg border-gray-300">
                        @error('cta_link') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Style</label>
                        <select wire:model="cta_style" class="w-full rounded-lg border-gray-300">
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
                               class="w-full rounded-lg border-gray-300">
                        @error('spacer_height') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500">Between 10px and 500px</p>
                    </div>
                @endif

                <div class="flex items-center pt-2">
                    <input type="checkbox" wire:model="section_is_active" id="section_is_active"
                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                    <label for="section_is_active" class="ml-2 text-sm text-gray-700">Active (Show this section)</label>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="closeSectionModal"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        {{ $sectionId ? 'Update' : 'Add' }} Section
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Delete Section</h3>
                <p class="text-gray-600 text-center mb-6">
                    Are you sure you want to delete this section? This action cannot be undone.
                </p>
                <div class="flex space-x-3">
                    <button wire:click="cancelDelete"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button wire:click="deleteSection"
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Delete Section
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
