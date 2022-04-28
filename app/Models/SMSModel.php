<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;

class SMSModel
{
    protected static $url = 'https://www.textit.biz/sendmsg';

    public static function send($text,$to)
    {

        return Http::get(self::$url, [
            'id' => env('SMS_GATEWAY_USERNAME'),
            'pw' => env('SMS_GATEWAY_PASSWORD'),
            'text' => urlencode($text),
            'to' => $to,
        ]);
    }
}
