<x-app-layout>
    <x-slot name="title">Become a Solar Distributor - Digital Media Plus</x-slot>
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Become a DMPlus Solar Distributor</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Join our growing network of solar energy distributors and be part of Nigeria's clean energy revolution.
                Fill out the application form below to get started.
            </p>
        </div>

        <!-- Benefits Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Why Partner With Us?</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white">
                            <i class="fas fa-trophy text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Quality Products</h3>
                        <p class="mt-2 text-gray-600">Access to high-quality solar products and equipment</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white">
                            <i class="fas fa-hands-helping text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Full Support</h3>
                        <p class="mt-2 text-gray-600">Comprehensive training and ongoing support</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Attractive Margins</h3>
                        <p class="mt-2 text-gray-600">Competitive pricing with good profit margins</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <livewire:frontend.distributor-form />

    </div>
</div>
</x-app-layout>
