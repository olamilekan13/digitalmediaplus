<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;

class ContactMessagesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all';
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $selectedMessage = null;
    public $messageToDelete = null;
    public $selectedMessages = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function viewMessage($messageId)
    {
        $this->selectedMessage = ContactMessage::findOrFail($messageId);

        // Mark as read when opened
        if (!$this->selectedMessage->is_read) {
            $this->selectedMessage->update(['is_read' => true]);
        }

        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedMessage = null;
    }

    public function toggleRead($messageId)
    {
        $message = ContactMessage::findOrFail($messageId);
        $message->update(['is_read' => !$message->is_read]);
        $this->dispatch('notify', message: 'Message status updated successfully.', type: 'success');
    }

    public function confirmDelete($messageId)
    {
        $this->messageToDelete = $messageId;
        $this->showDeleteModal = true;
    }

    public function deleteMessage()
    {
        if ($this->messageToDelete) {
            ContactMessage::findOrFail($this->messageToDelete)->delete();
            $this->dispatch('notify', message: 'Message deleted successfully.', type: 'success');
        }

        $this->showDeleteModal = false;
        $this->messageToDelete = null;
    }

    public function markAllAsRead()
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);
        $this->dispatch('notify', message: 'All messages marked as read.', type: 'success');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedMessages = $this->getFilteredMessages()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedMessages = [];
        }
    }

    public function bulkDelete()
    {
        if (empty($this->selectedMessages)) {
            $this->dispatch('notify', message: 'Please select messages to delete.', type: 'error');
            return;
        }

        ContactMessage::whereIn('id', $this->selectedMessages)->delete();

        $count = count($this->selectedMessages);
        $this->selectedMessages = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} message(s) deleted successfully.", type: 'success');
    }

    public function bulkMarkAsRead()
    {
        if (empty($this->selectedMessages)) {
            $this->dispatch('notify', message: 'Please select messages to mark as read.', type: 'error');
            return;
        }

        ContactMessage::whereIn('id', $this->selectedMessages)->update(['is_read' => true]);

        $count = count($this->selectedMessages);
        $this->selectedMessages = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} message(s) marked as read.", type: 'success');
    }

    public function bulkMarkAsUnread()
    {
        if (empty($this->selectedMessages)) {
            $this->dispatch('notify', message: 'Please select messages to mark as unread.', type: 'error');
            return;
        }

        ContactMessage::whereIn('id', $this->selectedMessages)->update(['is_read' => false]);

        $count = count($this->selectedMessages);
        $this->selectedMessages = [];
        $this->selectAll = false;

        $this->dispatch('notify', message: "{$count} message(s) marked as unread.", type: 'success');
    }

    private function getFilteredMessages()
    {
        $query = ContactMessage::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'read') {
            $query->where('is_read', true);
        } elseif ($this->filterStatus === 'unread') {
            $query->where('is_read', false);
        }

        return $query->latest()->get();
    }

    public function render()
    {
        $query = ContactMessage::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus === 'read') {
            $query->where('is_read', true);
        } elseif ($this->filterStatus === 'unread') {
            $query->where('is_read', false);
        }

        $messages = $query->latest()->paginate(10);
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('livewire.admin.contact-messages-table', compact('messages', 'unreadCount'));
    }
}
