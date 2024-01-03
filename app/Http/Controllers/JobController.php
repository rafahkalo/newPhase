<?php

namespace App\Http\Controllers;

use App\Jobs\SendToEmailJob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function processQueue()
    {
        $details['to'] = 'rafah5743@gmail.com';
        $details['name'] = 'Receiver Name';
        $details['subject'] = 'Hello Laravelcode';
        $details['message'] = 'Here goes all message body.';

       // SendToEmailJob::dispatch($details);
        dispatch(new SendToEmailJob($details));
        return response('Email sent successfully');
    }
}
