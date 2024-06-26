<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestNotification extends Notification
{
    use Queueable;
    private $bimbingan;
    private $kelompok;
    /**
     * Create a new notification instance.
     */
    public function __construct($bimbingan, $kelompok)
    {
        $this->bimbingan = $bimbingan;
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
            ->view('emails.request', [
                'bimbingan' => $this->bimbingan,
                'kelompok' => $this->kelompok
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
