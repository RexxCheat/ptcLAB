<?php

namespace App\Notify;

use App\Lib\CurlRequest;
use MessageBird\Client as MessageBirdClient;
use MessageBird\Objects\Message;
use Textmagic\Services\TextmagicRestClient;
use Twilio\Rest\Client;
use Vonage\Client as NexmoClient;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class SmsGateway{

	public static function clickatell($to,$fromName,$message,$credentials)
	{
		$message = urlencode($message);
		$api_key = $credentials->clickatell->api_key;
		@file_get_contents("https://platform.clickatell.com/messages/http/send?apiKey=$api_key&to=$to&content=$message");
	}

	public static function infobip($to,$fromName,$message,$credentials){
		$message = urlencode($message);
		@file_get_contents("https://api.infobip.com/api/v3/sendsms/plain?user=".$credentials->infobip->username."&password=".$credentials->infobip->password."&sender=$fromName&SMSText=$message&GSM=$to&type=longSMS");
	}

	public static function messageBird($to,$fromName,$message,$credentials){
		$MessageBird = new MessageBirdClient($credentials->message_bird->api_key);
	  	$Message = new Message();
	  	$Message->originator = $fromName;
	  	$Message->recipients = array($to);
	  	$Message->body = $message;
	  	$MessageBird->messages->create($Message);
	}

	public static function nexmo($to,$fromName = 'admin',$message,$credentials){
		$basic  = new Basic($credentials->nexmo->api_key, $credentials->nexmo->api_secret);
		$client = new NexmoClient($basic);
		$response = $client->sms()->send(
		    new SMS($to, $fromName, $message)
		);
		$message = $response->current();
	}

	public static function smsBroadcast($to,$fromName,$message,$credentials){
		$message = urlencode($message);
		$response = @file_get_contents("https://api.smsbroadcast.com.au/api-adv.php?username=".$credentials->sms_broadcast->username."&password=".$credentials->sms_broadcast->password."&to=$to&from=$fromName&message=$message&ref=112233&maxsplit=5&delay=15");
	}

	public static function twilio($to,$fromName,$message,$credentials){
		$account_sid = $credentials->twilio->account_sid;
		$auth_token = $credentials->twilio->auth_token;
		$twilio_number = $credentials->twilio->from;

		$client = new Client($account_sid, $auth_token);
		$client->messages->create(
		    '+'.$to,
		    array(
		        'from' => $twilio_number,
		        'body' => $message
		    )
		);
	}

	public static function textMagic($to,$fromName,$message,$credentials){

			$client = new TextmagicRestClient($credentials->text_magic->username, $credentials->text_magic->apiv2_key);
		    $result = $client->messages->create(
		        array(
		            'text' => $message,
		            'phones' => $to
		        )
		    );

	}

	public static function custom($to,$fromName,$message,$credentials){
		$credential = $credentials->custom;
		$method = $credential->method;
		$shortCodes = [
			'{{message}}'=>$message,
			'{{number}}'=>$to,
		];
		$body = array_combine($credential->body->name,$credential->body->value);
		foreach ($body as $key => $value) {
			$bodyData = str_replace($value,@$shortCodes[$value] ?? $value ,$value);
			$body[$key] = $bodyData;
		}
		$header = array_combine($credential->headers->name,$credential->headers->value);
		if ($method == 'get') {
			$url = $credential->url.'?'.http_build_query($body);
			CurlRequest::curlContent($credential->url,$body,$header);
		}else{
			CurlRequest::curlPostContent($credential->url,$body,$header);
		}
	}
}
