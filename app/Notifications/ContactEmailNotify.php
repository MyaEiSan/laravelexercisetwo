<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactEmailNotify extends Notification implements ShouldQueue
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
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
                    ->greeting('New Contact Created')
                    ->line("Full Name : ".$this->data['firstname']." ".$this->data['lastname'])
                    ->line("Birth Date : ".$this->data['birthday'])
                    ->line("Relative : {$this->data['relative']}")
                    ->action('Visit Site', $this->data['url']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }
}

// =>Generate Integrate (1.post forward / 2.app password)
// Gmail > Setting Icon > See all settings > Forwarding and POP/IMAP > IMAP on 
// Gmail > Manage your Google Account >  Security > 2-Step Verification > Get started > App passwords > App Name 
// App Name = DLT Student Management Project  


// mail ပို့တဲ့အခါ ပို့မြန်စေဖို့ queue ကို သုံးရတယ်။
// php artisan queue:table 
// php artisan migrate 

// QUEUE_CONNECTION က database ဖြစ်မှ queue က အလုပ်လုပ်မှာ 
// .env > QUEUE_CONNECTION=database
// implements ShouldQueue (use Illuminate\Contracts\Queue\ShouldQueue;)

// job ထဲမှာရှိနေပြီး email မရောက်သွားတာမျိုးတွေရှိရင် အဆင်ပြေအောင် အောက်ပါ command ထဲက တစ်ခုခုကို run ပေးရမယ်

// php artisan queue:work //must run after queue
// (or)
// php artisan queue:listen //must run after queue