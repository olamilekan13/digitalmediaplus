<?php

namespace App\Livewire\Admin;

use App\Models\ContactChannel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ContactChannelsForm extends Component
{
    use WithFileUploads;

    public $channelId;
    public $channel;
    public $channel_type = 'email';
    public $value;
    public $newIcon;
    public $currentIcon;
    public $order = 0;
    public $is_active = true;
    public $isEditMode = false;

    protected $rules = [
        'channel_type' => 'required|in:skype,email,phone,whatsapp,kingschat',
        'value' => 'required|string|max:255',
        'newIcon' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:2048',
        'order' => 'nullable|integer|min:0',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'channel_type.required' => 'Please select a channel type.',
        'channel_type.in' => 'Invalid channel type selected.',
        'value.required' => 'Please enter the contact value.',
        'value.max' => 'Contact value cannot exceed 255 characters.',
        'newIcon.image' => 'The icon must be an image file.',
        'newIcon.mimes' => 'Icon must be a JPEG, JPG, PNG, SVG, or WEBP file.',
        'newIcon.max' => 'Icon size cannot exceed 2MB.',
        'order.integer' => 'Order must be a number.',
        'order.min' => 'Order cannot be negative.',
    ];

    public function mount($channelId = null)
    {
        if ($channelId) {
            $this->isEditMode = true;
            $this->channelId = $channelId;
            $this->channel = ContactChannel::findOrFail($channelId);
            $this->channel_type = $this->channel->channel_type;
            $this->value = $this->channel->value;
            $this->currentIcon = $this->channel->icon;
            $this->order = $this->channel->order;
            $this->is_active = $this->channel->is_active;
        } else {
            $this->order = (ContactChannel::max('order') ?? 0) + 1;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'channel_type' => $this->channel_type,
            'value' => $this->value,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];

        if ($this->newIcon) {
            if ($this->currentIcon && Storage::disk('public')->exists($this->currentIcon)) {
                Storage::disk('public')->delete($this->currentIcon);
            }
            $data['icon'] = $this->newIcon->store('contact-channels', 'public');
            $this->currentIcon = $data['icon'];
            $this->newIcon = null;
        }

        if ($this->isEditMode) {
            $this->channel->update($data);
            session()->flash('success', 'Contact channel updated successfully.');
            return redirect()->route('admin.contact-channels.index');
        } else {
            ContactChannel::create($data);
            session()->flash('success', 'Contact channel created successfully.');
            return redirect()->route('admin.contact-channels.index');
        }
    }

    public function removeIcon()
    {
        if ($this->currentIcon && Storage::disk('public')->exists($this->currentIcon)) {
            Storage::disk('public')->delete($this->currentIcon);
        }

        if ($this->channel) {
            $this->channel->update(['icon' => null]);
        }

        $this->currentIcon = null;
        $this->newIcon = null;
        $this->dispatch('notify', message: 'Icon removed successfully.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.contact-channels-form');
    }
}
