<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-{{ $isEditMode ? 'edit' : 'plus-circle' }} mr-3"></i>
                {{ $isEditMode ? 'Edit Testimonial' : 'Create New Testimonial' }}
            </h2>
            <p class="text-pink-100 mt-1">
                {{ $isEditMode ? 'Update testimonial details' : 'Add a new customer testimonial' }}
            </p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="save" class="p-6 space-y-8">

            <!-- Customer Photo Upload Section -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-camera mr-2 text-pink-600"></i>
                    Customer Photo
                </h3>

                <div class="flex items-start space-x-6">
                    <!-- Current Photo Preview -->
                    <div class="flex-shrink-0">
                        @if ($currentImage && !$newImage)
                            <div class="relative">
                                <img src="{{ Str::startsWith($currentImage, 'http') ? $currentImage : Storage::url($currentImage) }}"
                                     alt="Current Photo"
                                     class="w-32 h-32 rounded-full object-cover border-4 border-pink-200 shadow-lg">
                                <button type="button"
                                        wire:click="removeImage"
                                        wire:confirm="Are you sure you want to remove the customer photo?"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 transition shadow-lg">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @elseif ($newImage)
                            <div class="relative">
                                <img src="{{ $newImage->temporaryUrl() }}"
                                     alt="New Photo Preview"
                                     class="w-32 h-32 rounded-full object-cover border-4 border-green-500 shadow-lg">
                                <span class="absolute -top-2 -left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full shadow-lg">
                                    <i class="fas fa-check mr-1"></i>
                                    New
                                </span>
                            </div>
                        @else
                            <div class="w-32 h-32 border-4 border-dashed border-gray-300 rounded-full bg-gray-50 flex items-center justify-center">
                                <i class="fas fa-user text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Upload Input -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Customer Photo
                        </label>
                        <input type="file"
                               wire:model="newImage"
                               accept="image/jpeg,image/jpg,image/png,image/webp"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-pink-50 file:text-pink-700
                                      hover:file:bg-pink-100
                                      cursor-pointer">

                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Accepted formats: JPG, PNG, WEBP. Maximum size: 2MB. Recommended: Square photo (e.g., 400x400px)
                        </p>

                        @error('newImage')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror

                        <div wire:loading wire:target="newImage" class="mt-2 text-sm text-pink-600 flex items-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Uploading photo...
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-circle mr-2 text-pink-600"></i>
                    Customer Details
                </h3>

                <div class="space-y-6">
                    <!-- Customer Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Customer Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               wire:model="name"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                               placeholder="e.g., John Smith">
                        <p class="mt-1 text-xs text-gray-500">Full name of the customer</p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role/Title -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role / Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="role"
                               wire:model="role"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                               placeholder="e.g., Business Owner, CEO, Student">
                        <p class="mt-1 text-xs text-gray-500">Customer's role, title, or occupation</p>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Testimonial Content -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-comment-dots mr-2 text-pink-600"></i>
                    Testimonial Content
                </h3>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Testimonial Text <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content"
                              wire:model.live="content"
                              rows="6"
                              maxlength="500"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                              placeholder="Enter customer's testimonial or review here..."></textarea>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Maximum 500 characters
                        </p>
                        <p class="text-xs font-medium {{ strlen($content ?? '') > 450 ? 'text-red-600' : 'text-gray-600' }}">
                            {{ strlen($content ?? '') }}/500 characters
                        </p>
                    </div>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Preview -->
                    @if($content)
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                                <i class="fas fa-eye mr-1"></i> Preview
                            </p>
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-quote-left text-pink-400 text-2xl mt-1"></i>
                                    <p class="text-gray-700 italic flex-1">{{ $content }}</p>
                                    <i class="fas fa-quote-right text-pink-400 text-2xl mt-1"></i>
                                </div>
                                @if($name || $role)
                                    <div class="mt-3 flex items-center space-x-2 text-sm">
                                        <span class="font-semibold text-gray-900">{{ $name ?: 'Customer Name' }}</span>
                                        @if($role)
                                            <span class="text-gray-500">•</span>
                                            <span class="text-gray-600">{{ $role }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Testimonial Settings -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-sliders-h mr-2 text-pink-600"></i>
                    Testimonial Settings
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
                               class="w-full md:w-48 rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
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
                                <i class="fas fa-toggle-on text-pink-600 mr-2"></i>
                                Testimonial Active
                            </label>
                            <p class="text-xs text-gray-600 mt-1">
                                Only active testimonials are displayed on the frontend
                            </p>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="is_active"
                                   wire:model="is_active"
                                   class="h-5 w-5 text-pink-600 focus:ring-pink-500 border-gray-300 rounded cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.testimonials.index') }}"
                   class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition inline-flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>

                <button type="submit"
                        wire:loading.attr="disabled"
                        style="background-color: #db2777 !important; color: white !important; padding: 10px 24px; border-radius: 8px; display: inline-flex; align-items: center; font-weight: 600; visibility: visible !important; opacity: 1 !important;">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>
                        Save Testimonial
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
