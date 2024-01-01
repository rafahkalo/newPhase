<?php

namespace App\Listeners;

use App\Events\SendtoMail;
use App\Mail\SendToEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendtoMailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    //public $details;

    /**
     * Handle the event.
     */
    public function handle(SendtoMail $event): void
    {
        Mail::to($event->data['to'])
            ->send(new SendToEmail($event->data));
    }
}
