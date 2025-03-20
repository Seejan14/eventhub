<?php

namespace App\Services;
use Mail;

class MailService
{
  public static function send($from,$to,$body,$subject)
    {
        Mail::raw($body, function($message) use($from,$to,$body,$subject){            
            $message->to($to, '')
            ->subject($subject);
            $message->from($from,\config('app.name'));
        });
    }
}