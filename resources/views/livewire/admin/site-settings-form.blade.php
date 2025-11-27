<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-cog mr-3"></i>
                Site Settings
            </h2>
            <p class="text-blue-100 mt-1">Manage your website's global settings and branding</p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="save" class="p-6 space-y-8">

            <!-- Logo Upload Section -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-image mr-2 text-blue-600"></i>
                    Company Logo
                </h3>

                <div class="flex items-start space-x-6">
                    <!-- Current Logo Preview -->
                    <div class="flex-shrink-0">
                        @if ($currentLogo && !$newLogo)
                            <div class="relative">
                                <img src="{{ Storage::url($currentLogo) }}"
                                     alt="Current Logo"
                                     class="w-32 h-32 object-contain border-2 border-gray-300 rounded-lg bg-gray-50 p-2">
                                <button type="button"
                                        wire:click="removeLogo"
                                        wire:confirm="Are you sure you want to remove the logo?"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        @elseif ($newLogo)
                            <div class="relative">
                                <img src="{{ $newLogo->temporaryUrl() }}"
                                     alt="New Logo Preview"
                                     class="w-32 h-32 object-contain border-2 border-green-500 rounded-lg bg-gray-50 p-2">
                                <span class="absolute -top-2 -left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                    New
                                </span>
                            </div>
                        @else
                            <div class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-3xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Upload Input -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload New Logo
                        </label>
                        <input type="file"
                               wire:model="newLogo"
                               accept="image/jpeg,image/jpg,image/png"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100
                                      cursor-pointer">

                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Accepted formats: JPG, JPEG, PNG. Maximum size: 2MB
                        </p>

                        @error('newLogo')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror

                        <div wire:loading wire:target="newLogo" class="mt-2 text-sm text-blue-600 flex items-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Uploading...
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Information -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-building mr-2 text-blue-600"></i>
                    Company Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Company Name -->
                    <div class="md:col-span-2">
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Company Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="company_name"
                               wire:model="company_name"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Enter company name">
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1"></i> Email
                        </label>
                        <input type="email"
                               id="email"
                               wire:model="email"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="company@example.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-1"></i> Phone
                        </label>
                        <input type="text"
                               id="phone"
                               wire:model="phone"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="+1 (555) 123-4567">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i> Address
                        </label>
                        <div wire:ignore>
                            <textarea id="address"
                                      wire:model.defer="address"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                      rows="3"></textarea>
                        </div>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-share-alt mr-2 text-blue-600"></i>
                    Social Media Links
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Facebook -->
                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-facebook text-blue-600 mr-1"></i> Facebook URL
                        </label>
                        <input type="url"
                               id="facebook_url"
                               wire:model="facebook_url"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="https://facebook.com/yourpage">
                        @error('facebook_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Twitter -->
                    <div>
                        <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-twitter text-blue-400 mr-1"></i> Twitter URL
                        </label>
                        <input type="url"
                               id="twitter_url"
                               wire:model="twitter_url"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="https://twitter.com/yourhandle">
                        @error('twitter_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-instagram text-pink-600 mr-1"></i> Instagram URL
                        </label>
                        <input type="url"
                               id="instagram_url"
                               wire:model="instagram_url"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="https://instagram.com/yourhandle">
                        @error('instagram_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- LinkedIn -->
                    <div>
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-linkedin text-blue-700 mr-1"></i> LinkedIn URL
                        </label>
                        <input type="url"
                               id="linkedin_url"
                               wire:model="linkedin_url"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="https://linkedin.com/company/yourcompany">
                        @error('linkedin_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- YouTube -->
                    <div class="md:col-span-2">
                        <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-youtube text-red-600 mr-1"></i> YouTube URL
                        </label>
                        <input type="url"
                               id="youtube_url"
                               wire:model="youtube_url"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="https://youtube.com/c/yourchannel">
                        @error('youtube_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- WhatsApp Business -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fab fa-whatsapp mr-2 text-green-600"></i>
                    WhatsApp Business
                </h3>

                <div class="space-y-6">
                    <!-- WhatsApp Chat Enabled Toggle -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <label for="whatsapp_chat_enabled" class="block text-sm font-medium text-gray-700">
                                Enable WhatsApp Chat Widget
                            </label>
                            <p class="text-sm text-gray-500 mt-1">
                                Display a WhatsApp chat button on your website for customer support
                            </p>
                        </div>
                        <div class="ml-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       id="whatsapp_chat_enabled"
                                       wire:model.boolean="whatsapp_chat_enabled"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- WhatsApp Business Number -->
                    <div>
                        <label for="whatsapp_business_number" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-whatsapp text-green-600 mr-1"></i> WhatsApp Business Number
                        </label>
                        <input type="text"
                               id="whatsapp_business_number"
                               wire:model="whatsapp_business_number"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="e.g., 1234567890 (include country code without + or spaces)">
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Enter the phone number with country code (e.g., 1234567890 for +1 234 567 890)
                        </p>
                        @error('whatsapp_business_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp Welcome Message -->
                    <div>
                        <label for="whatsapp_welcome_message" class="block text-sm font-medium text-gray-700 mb-2">
                            Welcome Message
                        </label>
                        <textarea id="whatsapp_welcome_message"
                                  wire:model="whatsapp_welcome_message"
                                  rows="3"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Hello! How can we help you today?"></textarea>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            This message will be pre-filled when customers click the WhatsApp button
                        </p>
                        @error('whatsapp_welcome_message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Theme Colors -->
            <div class="border-b border-gray-200 pb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-palette mr-2 text-blue-600"></i>
                    Theme Colors
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Primary Color -->
                    <div>
                        <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Primary Color
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color"
                                   id="primary_color"
                                   wire:model.live="primary_color"
                                   class="h-10 w-20 rounded border-gray-300 cursor-pointer">
                            <input type="text"
                                   wire:model="primary_color"
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="#007bff">
                        </div>
                        @error('primary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Secondary Color -->
                    <div>
                        <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Secondary Color
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color"
                                   id="secondary_color"
                                   wire:model.live="secondary_color"
                                   class="h-10 w-20 rounded border-gray-300 cursor-pointer">
                            <input type="text"
                                   wire:model="secondary_color"
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="#6c757d">
                        </div>
                        @error('secondary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Copyright Text -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-copyright mr-2 text-blue-600"></i>
                    Copyright Text
                </h3>

                <div>
                    <label for="copyright_text" class="block text-sm font-medium text-gray-700 mb-2">
                        Footer Copyright Text
                    </label>
                    <div wire:ignore>
                        <textarea id="copyright_text"
                                  wire:model.defer="copyright_text"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  rows="3"></textarea>
                    </div>
                    @error('copyright_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save mr-2"></i>
                        Save Settings
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
    let addressEditor, copyrightEditor;

    document.addEventListener('livewire:initialized', function () {
        initializeSiteSettingsCKEditor();
    });

    document.addEventListener('livewire:navigated', function () {
        initializeSiteSettingsCKEditor();
    });

    function initializeSiteSettingsCKEditor() {
        setTimeout(() => {
            if (typeof ClassicEditor !== 'undefined') {
                // Address Editor
                const addressElement = document.querySelector('#address');
                if (addressElement) {
                    if (addressEditor) {
                        addressEditor.destroy().catch(error => console.log(error));
                    }

                    ClassicEditor
                        .create(addressElement, {
                            toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link'],
                        })
                        .then(editor => {
                            addressEditor = editor;
                            const initialAddress = @this.get('address') || '';
                            editor.setData(initialAddress);
                            editor.model.document.on('change:data', () => {
                                @this.set('address', editor.getData());
                            });
                        })
                        .catch(error => console.error('CKEditor address error:', error));
                }

                // Copyright Text Editor
                const copyrightElement = document.querySelector('#copyright_text');
                if (copyrightElement) {
                    if (copyrightEditor) {
                        copyrightEditor.destroy().catch(error => console.log(error));
                    }

                    ClassicEditor
                        .create(copyrightElement, {
                            toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link'],
                        })
                        .then(editor => {
                            copyrightEditor = editor;
                            const initialCopyright = @this.get('copyright_text') || '';
                            editor.setData(initialCopyright);
                            editor.model.document.on('change:data', () => {
                                @this.set('copyright_text', editor.getData());
                            });
                        })
                        .catch(error => console.error('CKEditor copyright error:', error));
                }
            }
        }, 100);
    }

    document.addEventListener('livewire:navigating', function () {
        if (addressEditor) {
            addressEditor.destroy().catch(error => console.log(error));
        }
        if (copyrightEditor) {
            copyrightEditor.destroy().catch(error => console.log(error));
        }
    });
</script>
@endpush
