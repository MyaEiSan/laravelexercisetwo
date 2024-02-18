<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementNotify extends Notification
{
    use Queueable;

    protected $tbid;
    protected $title;
    protected $img;

    /**
     * Create a new notification instance.
     */
    public function __construct($id,$title,$img)
    {
        $this->tbid = $id;
        $this->title = $title;
        $this->img = $img;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->tbid,
            'title' => $this->title,
            'img' => $this->img
        ];
    }
}
