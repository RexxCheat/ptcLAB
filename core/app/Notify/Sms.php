<?php

namespace App\Notify;

use App\Notify\NotifyProcess;
use App\Notify\SmsGateway;


class Sms extends NotifyProcess{

    /**
    * Mobile number of receiver
    *
    * @var string
    */
	public $mobile;

    /**
    * Assign value to properties
    *
    * @return void
    */
	public function __construct(){
		$this->statusField = 'sms_status';
		$this->body = 'sms_body';
		$this->globalTemplate = 'sms_body';
		$this->notifyConfig = 'sms_config';
	}


    /**
    * Send notification
    *
    * @return void|bool
    */
	public function send(){

		//get message from parent
		$message = $this->getMessage();
		if ($this->setting->sn && $message) {
			try {
				$gateway = $this->setting->sms_config->name;
                if($this->mobile){
                    $sendSms = SmsGateway::$gateway($this->mobile,$this->setting->sms_from,strip_tags($message),$this->setting->sms_config);
                    $this->createLog('sms');
                }
			} catch (\Exception $e) {
				$this->createErrorLog('SMS Error: '.$e->getMessage());
				session()->flash('sms_error','API Error: '.$e->getMessage());
			}
		}

	}

    /**
    * Configure some properties
    *
    * @return void
    */
	protected function prevConfiguration(){
		//Check If User
		if ($this->user) {
			$this->mobile = $this->user->mobile;
			$this->receiverName = $this->user->fullname;
		}
		$this->toAddress = $this->mobile;
	}
}
