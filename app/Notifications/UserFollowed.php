<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserFollowed extends Notification
{
    use Queueable;

    protected $follower;

    protected $followed;

    public function __construct(User $follower, User $user)
    {//الشخص يلي تابع
        $this->follower = $follower;
        // الشخص الذي تمت متابعته
        $this->followed = $user;
    }

    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'data' => [
                'follower_id' => $this->follower->id,
                'follower_name' => $this->follower->name,
                'user_id' => $this->followed->id,
                'user_name' => $this->followed->name,
            ],
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'user_id' => $this->followed->id,
            'user_name' => $this->followed->name,
        ];
    }


/*
    public function toDatabase($notifiable)
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'who_i_follow' => $this->followed->name,
        ];
    }
*/
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You have a new follower')
            ->line('You have been followed by someone.')
            ->action('View Profile', url('/profile'))
            ->line('Thank you for using our application!');
    }


    /* NOTE
     *  تابع toArray ممكن يشتغل بدلtoDatabase
     * التابعين رح يخزنو البيانات بالداتا بيز
     * لما بحدد قناة ارسال لازم اكتب التابع يلي بيرسل الها
     */
}
