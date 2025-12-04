<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Page Heading -->
                <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $page->heading }}</h3>

                <!-- Page Content -->
                <div class="prose prose-lg max-w-none">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
