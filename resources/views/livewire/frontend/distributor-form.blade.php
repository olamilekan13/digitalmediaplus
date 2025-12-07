<div class="max-w-4xl mx-auto">
    <form class="space-y-8" wire:submit.prevent="submit">
        <!-- Form Header -->
        <div class="text-center bg-gradient-to-r from-orange-600 to-yellow-600 text-white py-8 px-6 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold mb-2">DMPLUS SOLAR DISTRIBUTOR APPLICATION FORM</h2>
            <p class="text-lg">Please complete this form accurately. Our team will contact you after review.</p>
        </div>


        <!-- SECTION A: PERSONAL INFORMATION -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-600">
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-orange-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">A</span>
                PERSONAL INFORMATION
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="full_name"
                           wire:model.live.debounce.300ms="full_name"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('full_name') border-red-500 @else border-gray-300 @enderror"
                           placeholder="Enter your full name">
                    @error('full_name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Business Name -->
                <div>
                    <label for="business_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Business Name <span class="text-gray-400 text-xs">(if any)</span>
                    </label>
                    <input type="text"
                           id="business_name"
                           wire:model.live.debounce.300ms="business_name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                           placeholder="Optional">
                    @error('business_name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel"
                           id="phone_number"
                           wire:model.live.debounce.300ms="phone_number"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('phone_number') border-red-500 @else border-gray-300 @enderror"
                           placeholder="+234 XXX XXX XXXX">
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- WhatsApp Number -->
                <div>
                    <label for="whatsapp_number" class="block text-sm font-semibold text-gray-700 mb-2">
                        WhatsApp Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel"
                           id="whatsapp_number"
                           wire:model.live.debounce.300ms="whatsapp_number"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('whatsapp_number') border-red-500 @else border-gray-300 @enderror"
                           placeholder="+234 XXX XXX XXXX">
                    @error('whatsapp_number')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email"
                           id="email"
                           wire:model.live.debounce.300ms="email"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('email') border-red-500 @else border-gray-300 @enderror"
                           placeholder="your.email@example.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Residential Address -->
                <div class="md:col-span-2">
                    <label for="residential_address" class="block text-sm font-semibold text-gray-700 mb-2">
                        Residential Address <span class="text-red-500">*</span>
                    </label>
                    <textarea id="residential_address"
                              wire:model.live.debounce.300ms="residential_address"
                              rows="2"
                              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none @error('residential_address') border-red-500 @else border-gray-300 @enderror"
                              placeholder="Enter your complete residential address"></textarea>
                    @error('residential_address')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- City / Town -->
                <div>
                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                        City / Town <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="city"
                           wire:model.live.debounce.300ms="city"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('city') border-red-500 @else border-gray-300 @enderror"
                           placeholder="Enter city or town">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- State -->
                <div>
                    <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">
                        State <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="state"
                           wire:model.live.debounce.300ms="state"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('state') border-red-500 @else border-gray-300 @enderror"
                           placeholder="Enter state">
                    @error('state')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION B: BUSINESS DETAILS -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-600">
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-orange-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">B</span>
                BUSINESS DETAILS
            </h3>

            <!-- Do you currently own a business? -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Do you currently own a business? <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio"
                               wire:model.live="has_business"
                               value="1"
                               class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                        <span class="ml-2 text-gray-700">Yes</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio"
                               wire:model.live="has_business"
                               value="0"
                               class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                        <span class="ml-2 text-gray-700">No</span>
                    </label>
                </div>
                @error('has_business')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            @if($has_business == '1' || $has_business === true)
                <!-- Business Type -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Business Type <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach(['Electronics', 'Solar', 'ICT', 'POS', 'General Trading', 'Other'] as $type)
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio"
                                       wire:model.live="business_type"
                                       value="{{ $type }}"
                                       class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                <span class="ml-2 text-gray-700">{{ $type }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('business_type')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Other Business Type -->
                @if($business_type === 'Other')
                    <div class="mb-4">
                        <label for="business_type_other" class="block text-sm font-semibold text-gray-700 mb-2">
                            Please Specify <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="business_type_other"
                               wire:model.live.debounce.300ms="business_type_other"
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('business_type_other') border-red-500 @else border-gray-300 @enderror"
                               placeholder="Specify your business type">
                        @error('business_type_other')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                @endif

                <!-- Years in Business -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        How long have you been in business? <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach(['Less than 1 year', '1 - 3 years', '3 - 5 years', 'Over 5 years'] as $years)
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio"
                                       wire:model.live="years_in_business"
                                       value="{{ $years }}"
                                       class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                <span class="ml-2 text-gray-700">{{ $years }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('years_in_business')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            @endif

            <!-- Do you have a physical shop? -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Do you have a physical shop? <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio"
                               wire:model.live="has_physical_shop"
                               value="1"
                               class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                        <span class="ml-2 text-gray-700">Yes</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio"
                               wire:model.live="has_physical_shop"
                               value="0"
                               class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                        <span class="ml-2 text-gray-700">No</span>
                    </label>
                </div>
                @error('has_physical_shop')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            @if($has_physical_shop == '1' || $has_physical_shop === true)
                <!-- Shop Address -->
                <div>
                    <label for="shop_address" class="block text-sm font-semibold text-gray-700 mb-2">
                        Shop Address <span class="text-red-500">*</span>
                    </label>
                    <textarea id="shop_address"
                              wire:model.live.debounce.300ms="shop_address"
                              rows="2"
                              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none @error('shop_address') border-red-500 @else border-gray-300 @enderror"
                              placeholder="Enter your shop address"></textarea>
                    @error('shop_address')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            @endif
        </div>

        <!-- SECTION C: DISTRIBUTION CAPACITY -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-600">
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-orange-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">C</span>
                DISTRIBUTION CAPACITY
            </h3>

            <!-- Monthly Purchase Capacity -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Estimated Monthly Purchase Capacity <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(['5 - 10 Units', '10 - 30 Units', '30 - 50 Units', '50+ Units'] as $capacity)
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio"
                                   wire:model.live="monthly_purchase_capacity"
                                   value="{{ $capacity }}"
                                   class="w-4 h-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                            <span class="ml-2 text-gray-700">{{ $capacity }}</span>
                        </label>
                    @endforeach
                </div>
                @error('monthly_purchase_capacity')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Distribution Area -->
            <div class="mb-4">
                <label for="distribution_area" class="block text-sm font-semibold text-gray-700 mb-2">
                    Proposed Distribution Area (State & City) <span class="text-red-500">*</span>
                </label>
                <textarea id="distribution_area"
                          wire:model.live.debounce.300ms="distribution_area"
                          rows="2"
                          class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none @error('distribution_area') border-red-500 @else border-gray-300 @enderror"
                          placeholder="e.g., Lagos State - Ikeja, Victoria Island, Lekki"></textarea>
                @error('distribution_area')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Sales Staff Count -->
            <div>
                <label for="sales_staff_count" class="block text-sm font-semibold text-gray-700 mb-2">
                    Number of Sales Staff <span class="text-gray-400 text-xs">(if any)</span>
                </label>
                <input type="text"
                       id="sales_staff_count"
                       wire:model.live.debounce.300ms="sales_staff_count"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                       placeholder="e.g., 3 staff members">
                @error('sales_staff_count')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- SECTION D: ADDITIONAL INFORMATION -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-600">
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-orange-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">D</span>
                ADDITIONAL INFORMATION
            </h3>

            <div>
                <label for="additional_info" class="block text-sm font-semibold text-gray-700 mb-2">
                    Any additional information you would like us to know <span class="text-gray-400 text-xs">(Optional)</span>
                </label>
                <textarea id="additional_info"
                          wire:model.live.debounce.300ms="additional_info"
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none"
                          placeholder="Tell us anything else that might be relevant to your application..."></textarea>
                <div class="mt-2 text-sm text-gray-500 text-right">
                    {{ strlen($this->additional_info) }} / 1000
                </div>
                @error('additional_info')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- SECTION E: DECLARATION -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-600">
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-orange-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">E</span>
                DECLARATION
            </h3>

            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <p class="text-gray-700 text-sm leading-relaxed">
                    I hereby confirm that all information provided in this application is true and correct.
                    I agree to operate as an authorized DMPlus Distributor under the company's terms and conditions.
                </p>
            </div>

            <!-- Applicant Name -->
            <div class="mb-4">
                <label for="applicant_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Applicant Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="applicant_name"
                       wire:model.live.debounce.300ms="applicant_name"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('applicant_name') border-red-500 @else border-gray-300 @enderror"
                       placeholder="Type your full name as signature">
                @error('applicant_name')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Agreement Checkbox -->
            <div>
                <label class="inline-flex items-start cursor-pointer">
                    <input type="checkbox"
                           wire:model.live="agree_declaration"
                           class="w-5 h-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded mt-1">
                    <span class="ml-3 text-gray-700">
                        I agree to the declaration above and confirm that all information provided is accurate. <span class="text-red-500">*</span>
                    </span>
                </label>
                @error('agree_declaration')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mt-4 text-sm text-gray-500">
                <p><strong>Date:</strong> {{ now()->format('F d, Y') }}</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full px-8 py-4 bg-gradient-to-r from-orange-600 to-yellow-600 text-white text-lg font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center">

                <span wire:loading.remove wire:target="submit">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Submit Application
                </span>

                <span wire:loading wire:target="submit">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Submitting Application...
                </span>
            </button>
        </div>

        <!-- Privacy Notice -->
        <p class="text-xs text-gray-500 text-center">
            We respect your privacy. Your information will be kept confidential and used only for distributor application processing.
        </p>
    </form>

    @script
    <script>
        // Listen for form submission success
        $wire.on('distributor-form-submitted', () => {
            // Show success toast
            if (typeof showToast === 'function') {
                showToast('Thank you for your application! We will review your submission and contact you soon.', 'success');
            }

            // Scroll to top of page smoothly
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
    @endscript
</div>
