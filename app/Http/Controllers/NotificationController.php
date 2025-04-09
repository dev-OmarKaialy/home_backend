<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendFirebaseNotification;

class NotificationController extends Controller
{

    public static function sendNotification($deviceToken, $title, $body, $data = [])
    {
        SendFirebaseNotification::dispatch($deviceToken, $title, $body, $data);
    }
}
