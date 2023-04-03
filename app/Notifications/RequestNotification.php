<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestNotification extends Notification
{
    use Queueable;
    private $kelompok;
    /**
     * Create a new notification instance.
     */
    public function __construct($kelompok)
    {
        $this->kelompok = $kelompok;
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
            ->subject('Permintaan Bimbingan')
            ->line('Permintaan bimbingan dari kelompok ' . $this->kelompok->nama_kelompok . ' telah diterima.')
            ->action('Lihat Permintaan', url('/kelompok/' . $this->kelompok->id));
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
