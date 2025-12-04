<?php

namespace App\Livewire\Admin;

use App\Models\CustomPage;
use App\Models\CustomPageSection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UnifiedPageBuilder extends Component
{
    use WithFileUploads;

    // Page Properties
    public $pageId;
    public $page;
    public $title = '';
    public $slug = '';
    public $layout = 'full-width';
    public $meta_title = '';
    public $meta_description = '';
    public $is_active = true;
    public $isEditMode = false;

    // Sections
    public $sections = [];
    public $showSectionModal = false;
    public $showDeleteModal = false;
    public $sectionToDelete = null;

    // Section Form
    public $sectionId = null;
    public $sectionType = 'text';
    public $heading_title;
    public $heading_subtitle;
    public $text_content;
    public $image_file;
    public $image_caption;
    public $image_link;
    public $current_image;
    public $video_file;
    public $video_caption;
    public $current_video;
    public $gallery_images = [];
    public $current_gallery = [];
    public $cta_text;
    public $cta_link;
    public $cta_style = 'primary';
    public $spacer_height = 50;
    public $section_is_active = true;

    protected function pageRules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => $this->isEditMode
                ? 'required|string|max:255|unique:custom_pages,slug,' . $this->pageId
                : 'required|string|max:255|unique:custom_pages,slug',
            'layout' => 'required|in:full-width,two-column,sidebar-left,sidebar-right',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ];
    }

    protected function sectionRules()
    {
        $rules = [
            'sectionType' => 'required|in:heading,text,image,video,gallery,cta,spacer',
            'section_is_active' => 'boolean',
        ];

        switch ($this->sectionType) {
            case 'heading':
                $rules['heading_title'] = 'required|string|max:255';
                $rules['heading_subtitle'] = 'nullable|string|max:500';
                break;
            case 'text':
                $rules['text_content'] = 'required|string';
                break;
            case 'image':
                $rules['image_file'] = $this->sectionId ? 'nullable|image|max:5120' : 'required|image|max:5120';
                $rules['image_caption'] = 'nullable|string|max:255';
                $rules['image_link'] = 'nullable|url';
                break;
            case 'video':
                $rules['video_file'] = $this->sectionId ? 'nullable|file|mimes:mp4,webm,ogg|max:51200' : 'required|file|mimes:mp4,webm,ogg|max:51200';
                $rules['video_caption'] = 'nullable|string|max:255';
                break;
            case 'gallery':
                $rules['gallery_images.*'] = 'image|max:5120';
                break;
            case 'cta':
                $rules['cta_text'] = 'required|string|max:255';
                $rules['cta_link'] = 'required|url';
                $rules['cta_style'] = 'required|in:primary,secondary,success,danger';
                break;
            case 'spacer':
                $rules['spacer_height'] = 'required|integer|min:10|max:500';
                break;
        }

        return $rules;
    }

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

            $this->loadSections();
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

        $this->validate($this->pageRules());

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
            $this->dispatch('notify', message: 'Page updated successfully.', type: 'success');
        } else {
            $this->page = CustomPage::create($data);
            $this->pageId = $this->page->id;
            $this->isEditMode = true;
            $this->dispatch('notify', message: 'Page created successfully. Now add sections below.', type: 'success');
        }
    }

    public function loadSections()
    {
        if ($this->page) {
            $this->sections = $this->page->sections()->orderBy('order')->get();
        }
    }

    public function openSectionModal($type = 'text')
    {
        $this->resetSectionForm();
        $this->sectionType = $type;
        $this->showSectionModal = true;
    }

    public function editSection($sectionId)
    {
        $section = CustomPageSection::findOrFail($sectionId);
        $this->sectionId = $section->id;
        $this->sectionType = $section->type;
        $this->section_is_active = $section->is_active;

        $content = $section->content;

        switch ($section->type) {
            case 'heading':
                $this->heading_title = $content['title'] ?? '';
                $this->heading_subtitle = $content['subtitle'] ?? '';
                break;
            case 'text':
                $this->text_content = $content['content'] ?? '';
                break;
            case 'image':
                $this->image_caption = $content['caption'] ?? '';
                $this->image_link = $content['link'] ?? '';
                $this->current_image = $content['path'] ?? '';
                break;
            case 'video':
                $this->video_caption = $content['caption'] ?? '';
                $this->current_video = $content['path'] ?? '';
                break;
            case 'gallery':
                $this->current_gallery = $content['images'] ?? [];
                break;
            case 'cta':
                $this->cta_text = $content['text'] ?? '';
                $this->cta_link = $content['link'] ?? '';
                $this->cta_style = $content['style'] ?? 'primary';
                break;
            case 'spacer':
                $this->spacer_height = $content['height'] ?? 50;
                break;
        }

        $this->showSectionModal = true;
    }

    public function saveSection()
    {
        if (!$this->page) {
            $this->dispatch('notify', message: 'Please save the page first before adding sections.', type: 'error');
            return;
        }

        if (!auth()->user()->hasPermission('manage_pages')) {
            $this->dispatch('notify', message: 'You do not have permission to manage pages.', type: 'error');
            return;
        }

        $this->validate($this->sectionRules());

        $content = $this->prepareSectionContent();

        $data = [
            'custom_page_id' => $this->page->id,
            'type' => $this->sectionType,
            'content' => $content,
            'is_active' => $this->section_is_active,
        ];

        if ($this->sectionId) {
            $section = CustomPageSection::findOrFail($this->sectionId);
            $section->update($data);
            $message = 'Section updated successfully.';
        } else {
            $data['order'] = CustomPageSection::where('custom_page_id', $this->page->id)->max('order') + 1 ?? 1;
            CustomPageSection::create($data);
            $message = 'Section added successfully.';
        }

        $this->dispatch('notify', message: $message, type: 'success');
        $this->loadSections();
        $this->closeSectionModal();
    }

    private function prepareSectionContent()
    {
        $content = [];

        switch ($this->sectionType) {
            case 'heading':
                $content = [
                    'title' => $this->heading_title,
                    'subtitle' => $this->heading_subtitle,
                ];
                break;
            case 'text':
                $content = [
                    'content' => $this->text_content,
                ];
                break;
            case 'image':
                if ($this->image_file) {
                    if ($this->current_image && Storage::disk('public')->exists($this->current_image)) {
                        Storage::disk('public')->delete($this->current_image);
                    }
                    $path = $this->image_file->store('custom-pages', 'public');
                    $content['path'] = $path;
                } else {
                    $content['path'] = $this->current_image;
                }
                $content['caption'] = $this->image_caption;
                $content['link'] = $this->image_link;
                break;
            case 'video':
                if ($this->video_file) {
                    if ($this->current_video && Storage::disk('public')->exists($this->current_video)) {
                        Storage::disk('public')->delete($this->current_video);
                    }
                    $path = $this->video_file->store('custom-pages', 'public');
                    $content['path'] = $path;
                } else {
                    $content['path'] = $this->current_video;
                }
                $content['caption'] = $this->video_caption;
                break;
            case 'gallery':
                $images = $this->current_gallery ?? [];
                if (!empty($this->gallery_images)) {
                    foreach ($this->gallery_images as $image) {
                        $path = $image->store('custom-pages', 'public');
                        $images[] = $path;
                    }
                }
                $content['images'] = $images;
                break;
            case 'cta':
                $content = [
                    'text' => $this->cta_text,
                    'link' => $this->cta_link,
                    'style' => $this->cta_style,
                ];
                break;
            case 'spacer':
                $content = [
                    'height' => $this->spacer_height,
                ];
                break;
        }

        return $content;
    }

    public function removeGalleryImage($index)
    {
        if (isset($this->current_gallery[$index])) {
            $imagePath = $this->current_gallery[$index];
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            unset($this->current_gallery[$index]);
            $this->current_gallery = array_values($this->current_gallery);
        }
    }

    public function moveUp($sectionId)
    {
        $section = CustomPageSection::findOrFail($sectionId);
        $previousSection = CustomPageSection::where('custom_page_id', $this->page->id)
            ->where('order', '<', $section->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previousSection) {
            $tempOrder = $section->order;
            $section->order = $previousSection->order;
            $previousSection->order = $tempOrder;
            $section->save();
            $previousSection->save();

            $this->loadSections();
            $this->dispatch('notify', message: 'Section moved up.', type: 'success');
        }
    }

    public function moveDown($sectionId)
    {
        $section = CustomPageSection::findOrFail($sectionId);
        $nextSection = CustomPageSection::where('custom_page_id', $this->page->id)
            ->where('order', '>', $section->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextSection) {
            $tempOrder = $section->order;
            $section->order = $nextSection->order;
            $nextSection->order = $tempOrder;
            $section->save();
            $nextSection->save();

            $this->loadSections();
            $this->dispatch('notify', message: 'Section moved down.', type: 'success');
        }
    }

    public function toggleSectionActive($sectionId)
    {
        $section = CustomPageSection::findOrFail($sectionId);
        $section->update(['is_active' => !$section->is_active]);
        $this->loadSections();
        $this->dispatch('notify', message: 'Section status updated.', type: 'success');
    }

    public function confirmDelete($sectionId)
    {
        $this->sectionToDelete = $sectionId;
        $this->showDeleteModal = true;
    }

    public function deleteSection()
    {
        if (!auth()->user()->hasPermission('manage_pages')) {
            $this->dispatch('notify', message: 'You do not have permission to delete sections.', type: 'error');
            return;
        }

        if ($this->sectionToDelete) {
            $section = CustomPageSection::findOrFail($this->sectionToDelete);

            if (in_array($section->type, ['image', 'video'])) {
                $path = $section->content['path'] ?? null;
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            } elseif ($section->type === 'gallery') {
                $images = $section->content['images'] ?? [];
                foreach ($images as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            $section->delete();

            $this->dispatch('notify', message: 'Section deleted successfully.', type: 'success');
            $this->loadSections();
            $this->sectionToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->sectionToDelete = null;
        $this->showDeleteModal = false;
    }

    public function closeSectionModal()
    {
        $this->showSectionModal = false;
        $this->resetSectionForm();
    }

    private function resetSectionForm()
    {
        $this->sectionId = null;
        $this->sectionType = 'text';
        $this->heading_title = '';
        $this->heading_subtitle = '';
        $this->text_content = '';
        $this->image_file = null;
        $this->image_caption = '';
        $this->image_link = '';
        $this->current_image = '';
        $this->video_file = null;
        $this->video_caption = '';
        $this->current_video = '';
        $this->gallery_images = [];
        $this->current_gallery = [];
        $this->cta_text = '';
        $this->cta_link = '';
        $this->cta_style = 'primary';
        $this->spacer_height = 50;
        $this->section_is_active = true;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.unified-page-builder');
    }
}
