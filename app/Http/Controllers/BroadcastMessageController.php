<?php

namespace App\Http\Controllers;

use App\Events\MessageActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastMessageController extends Controller
{
    public function broadcastMessage(Request $request)
    {

        $message = $request->message;
        $userName = 'Tanveer';

        


        event(new MessageActivity($message, $userName));

        return response()->json([
            'status' => 'ok',
            'message' => 'MessageActivity event created'
        ]);
    }
}
