<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function sendmessage(Request $request){

        $message = $request->sms; 
        event(new ChatEvent($message)); 

        return response()->json(['status'=>'Message Sent Successfully','message'=>$message]);
    }
}
