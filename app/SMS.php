<?php

namespace App;

use Twilio\Rest\Client;

class SMS
{
    public static function sendSMS()
	{
		$account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");
        $client = new Client($account_sid, $auth_token);
        return ['cliente' => $client, 'numero' => $twilio_number];
	}
}
