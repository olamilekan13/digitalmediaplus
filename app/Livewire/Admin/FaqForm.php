<?php

namespace App\Livewire\Admin;

use App\Models\Faq;
use Livewire\Component;

class FaqForm extends Component
{
    public $faqId;
    public $faq;
    public $question;
    public $answer;
    public $order = 0;
    public $is_active = true;
    public $isEditMode = false;

    protected $rules = [
        'question' => 'required|string|max:500',
        'answer' => 'required|string',
        'order' => 'nullable|integer|min:0',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'question.required' => 'The question is required.',
        'question.max' => 'The question must not exceed 500 characters.',
        'answer.required' => 'The answer is required.',
        'order.integer' => 'The order must be a number.',
        'order.min' => 'The order must be at least 0.',
    ];

    public function mount($faqId = null)
    {
        if ($faqId) {
            $this->isEditMode = true;
            $this->faqId = $faqId;
            $this->faq = Faq::findOrFail($faqId);

            $this->question = $this->faq->question;
            $this->answer = $this->faq->answer;
            $this->order = $this->faq->order ?? 0;
            $this->is_active = $this->faq->is_active;
        } else {
            // Get next order number
            $this->order = Faq::max('order') + 1 ?? 1;
        }
    }

    public function save()
    {
        // Check permissions
        if ($this->isEditMode) {
            // For editing, check if user has manage or edit permission
            if (!auth()->user()->hasPermission('manage_faqs') && !auth()->user()->hasPermission('edit_faqs')) {
                session()->flash('error', 'You do not have permission to edit FAQs.');
                return redirect()->route('admin.faqs.index');
            }
        } else {
            // For creating, check if user has manage permission
            if (!auth()->user()->hasPermission('manage_faqs')) {
                session()->flash('error', 'You do not have permission to create FAQs.');
                return redirect()->route('admin.faqs.index');
            }
        }

        $this->validate();

        $data = [
            'question' => $this->question,
            'answer' => $this->answer,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditMode) {
            $this->faq->update($data);
            session()->flash('success', 'FAQ updated successfully.');
            return redirect()->route('admin.faqs.index');
        } else {
            Faq::create($data);
            session()->flash('success', 'FAQ created successfully.');
            return redirect()->route('admin.faqs.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.faq-form');
    }
}
