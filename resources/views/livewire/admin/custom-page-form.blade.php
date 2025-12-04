<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-{{ $isEditMode ? 'edit' : 'plus-circle' }} mr-3"></i>
                {{ $isEditMode ? 'Edit Custom Page' : 'Create New Page' }}
            </h2>
        </div>

        <form wire:submit.prevent="save" class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Page Title *</label>
                <input type="text" wire:model.live="title" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug *</label>
                <input type="text" wire:model="slug" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Page Layout *</label>
                <select wire:model="layout" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    <option value="full-width">Full Width</option>
                    <option value="two-column">Two Column</option>
                    <option value="sidebar-left">Sidebar Left</option>
                    <option value="sidebar-right">Sidebar Right</option>
                </select>
                @error('layout') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title (SEO)</label>
                <input type="text" wire:model="meta_title" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                @error('meta_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description (SEO)</label>
                <textarea wire:model="meta_description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                @error('meta_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                <label for="is_active" class="ml-2 text-sm text-gray-700">Active (Publish this page)</label>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.custom-pages.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    {{ $isEditMode ? 'Update Page' : 'Create Page' }}
                </button>
            </div>
        </form>
    </div>
</div>
