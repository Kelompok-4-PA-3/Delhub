<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateRequestNotification extends Notification
{
    use Queueable;
    private $bimbingan;
    private $status;
    /**
     * Create a new notification instance.
     */
    public function __construct(object $bimbingan, string $status)
    {
        $this->bimbingan = $bimbingan;
        $this->status = $status;
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
            ->subject('Permintaan Bimbingan Anda Telah Diperbarui')
            ->view('emails.update_request', [
                'bimbingan' => $this->bimbingan,
                'status' => $this->status
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
