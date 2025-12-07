<?php

namespace App\Livewire\Admin;

use App\Models\CustomPage;
use Livewire\Component;
use Illuminate\Support\Str;

class SimplePageBuilder extends Component
{
    public $pageId;
    public $page;
    public $title = '';
    public $slug = '';
    public $heading = '';
    public $content = '';
    public $is_active = true;
    public $isEditMode = false;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => $this->isEditMode
                ? 'required|string|max:255|unique:custom_pages,slug,' . $this->pageId
                : 'required|string|max:255|unique:custom_pages,slug',
            'heading' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ];
    }

    public function mount($pageId = null)
    {
        if ($pageId) {
            $this->isEditMode = true;
            $this->pageId = $pageId;
            $this->page = CustomPage::findOrFail($pageId);

            $this->title = $this->page->title;
            $this->slug = $this->page->slug;
            $this->heading = $this->page->heading;
            $this->content = $this->page->content;
            $this->is_active = $this->page->is_active;
        }
    }

    public function updatedTitle()
    {
        if (!$this->isEditMode || empty($this->slug)) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function savePage()
    {
        if (!auth()->user()->hasPermission('manage_pages')) {
            $this->dispatch('notify', message: 'You do not have permission to manage pages.', type: 'error');
            return;
        }

        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'heading' => $this->heading,
            'content' => $this->content,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditMode) {
            $this->page->update($data);
            session()->flash('success', 'Page updated successfully.');
            return redirect()->route('admin.custom-pages.index');
        } else {
            $this->page = CustomPage::create($data);
            session()->flash('success', 'Page created successfully.');
            return redirect()->route('admin.custom-pages.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.simple-page-builder');
    }
}
