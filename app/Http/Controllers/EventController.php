<?php

namespace App\Http\Controllers;

use App\Events\SendtoMail;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function useEvent()
    {
        $details['to'] = 'rama@gmail.com';
        $details['name'] = 'Receiver Name';
        $details['message'] = 'Here goes all message body.';
        SendtoMail::dispatch($details);

        return response('Email sent successfully');

    }
}
