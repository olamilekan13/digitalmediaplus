<?php

namespace App\Notifications;

use App\Models\DistributorApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDistributorApplication extends Notification implements ShouldQueue
{
    use Queueable;

    public $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(DistributorApplication $application)
    {
        $this->application = $application;
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
            ->subject('New Solar Distributor Application from ' . $this->application->full_name)
            ->greeting('Hello Admin,')
            ->line('You have received a new solar distributor application on your website.')
            ->line('**Applicant Name:** ' . $this->application->full_name)
            ->line('**Business Name:** ' . ($this->application->business_name ?? 'Not provided'))
            ->line('**Email:** ' . $this->application->email)
            ->line('**Phone:** ' . $this->application->phone_number)
            ->line('**WhatsApp:** ' . $this->application->whatsapp_number)
            ->line('**Location:** ' . $this->application->city . ', ' . $this->application->state)
            ->line('**Monthly Capacity:** ' . $this->application->monthly_purchase_capacity)
            ->line('**Distribution Area:** ' . $this->application->distribution_area)
            ->action('View Application in Dashboard', url('/admin/distributor-applications'))
            ->line('Please review this application as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'full_name' => $this->application->full_name,
            'email' => $this->application->email,
            'city' => $this->application->city,
            'state' => $this->application->state,
        ];
    }
}
