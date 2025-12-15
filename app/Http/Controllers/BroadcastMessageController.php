<?php

namespace App\Http\Controllers;

use App\Events\MessageActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastMessageController extends Controller
{
    public function bradcastMessage(Request $request)
    {

        $message = $request->message;
        $userName = 'Tanveer';


        event(new MessageActivity($message, $userName));
    }
}
