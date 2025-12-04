<?php

namespace App\Livewire\Admin;

use App\Models\CustomPage;
use Livewire\Component;
use Illuminate\Support\Str;

class CustomPageForm extends Component
{
    public $pageId;
    public $page;
    public $title;
    public $slug;
    public $layout = 'full-width';
    public $meta_title;
    public $meta_description;
    public $is_active = true;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:custom_pages,slug',
        'layout' => 'required|in:full-width,two-column,sidebar-left,sidebar-right',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'title.required' => 'The page title is required.',
        'slug.required' => 'The slug is required.',
        'slug.unique' => 'This slug is already in use.',
        'layout.required' => 'Please select a layout.',
        'layout.in' => 'Invalid layout selected.',
    ];

    public function mount($pageId = null)
    {
        if ($pageId) {
            $this->isEditMode = true;
            $this->pageId = $pageId;
            $this->page = CustomPage::findOrFail($pageId);

            $this->title = $this->page->title;
            $this->slug = $this->page->slug;
            $this->layout = $this->page->layout;
            $this->meta_title = $this->page->meta_title;
            $this->meta_description = $this->page->meta_description;
            $this->is_active = $this->page->is_active;
        }
    }

    public function updatedTitle()
    {
        if (!$this->isEditMode || empty($this->page->slug)) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save()
    {
        if (!auth()->user()->hasPermission('manage_pages')) {
            session()->flash('error', 'You do not have permission to manage custom pages.');
            return redirect()->route('admin.custom-pages.index');
        }

        if ($this->isEditMode) {
            $this->rules['slug'] = 'required|string|max:255|unique:custom_pages,slug,' . $this->pageId;
        }

        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'layout' => $this->layout,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditMode) {
            $this->page->update($data);
            session()->flash('success', 'Page updated successfully.');
            return redirect()->route('admin.custom-pages.index');
        } else {
            $page = CustomPage::create($data);
            session()->flash('success', 'Page created successfully. You can now add sections to it.');
            return redirect()->route('admin.custom-pages.sections', $page->id);
        }
    }

    public function render()
    {
        return view('livewire.admin.custom-page-form');
    }
}
