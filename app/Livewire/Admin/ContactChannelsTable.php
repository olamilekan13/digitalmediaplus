<?php

namespace App\Livewire\Admin;

use App\Models\ContactChannel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ContactChannelsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterChannelType = 'all';
    public $filterStatus = 'all';
    public $showDeleteModal = false;
    public $channelToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterChannelType' => ['except' => 'all'],
        'filterStatus' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterChannelType()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function toggleActive($channelId)
    {
        $channel = ContactChannel::findOrFail($channelId);
        $channel->update(['is_active' => !$channel->is_active]);
        $this->dispatch('notify', message: 'Contact channel status updated successfully.', type: 'success');
    }

    public function confirmDelete($channelId)
    {
        $this->channelToDelete = $channelId;
        $this->showDeleteModal = true;
    }

    public function deleteChannel()
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_contact_channels')) {
            $this->dispatch('notify', message: 'You do not have permission to delete contact channels.', type: 'error');
            $this->channelToDelete = null;
            $this->showDeleteModal = false;
            return;
        }

        if ($this->channelToDelete) {
            $channel = ContactChannel::findOrFail($this->channelToDelete);

            if ($channel->icon && Storage::disk('public')->exists($channel->icon)) {
                Storage::disk('public')->delete($channel->icon);
            }

            $channel->delete();
            $this->dispatch('notify', message: 'Contact channel deleted successfully.', type: 'success');
        }

        $this->showDeleteModal = false;
        $this->channelToDelete = null;
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            ContactChannel::where('id', $item['value'])->update(['order' => $item['order']]);
        }
        $this->dispatch('notify', message: 'Contact channels reordered successfully.', type: 'success');
    }

    public function render()
    {
        $query = ContactChannel::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('value', 'like', '%' . $this->search . '%')
                  ->orWhere('channel_type', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterChannelType !== 'all') {
            $query->where('channel_type', $this->filterChannelType);
        }

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $channels = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.contact-channels-table', compact('channels'));
    }
}
