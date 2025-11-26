<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $contactMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Contact Message from ' . $this->contactMessage->name)
            ->greeting('Hello Admin,')
            ->line('You have received a new contact message on your website.')
            ->line('**From:** ' . $this->contactMessage->name)
            ->line('**Email:** ' . $this->contactMessage->email)
            ->line('**Phone:** ' . ($this->contactMessage->phone ?? 'Not provided'))
            ->line('**Message:**')
            ->line($this->contactMessage->message)
            ->action('View Message in Dashboard', route('admin.contact-messages.index'))
            ->line('Please respond to this inquiry as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contact_message_id' => $this->contactMessage->id,
            'name' => $this->contactMessage->name,
            'email' => $this->contactMessage->email,
            'message' => $this->contactMessage->message,
        ];
    }
}
