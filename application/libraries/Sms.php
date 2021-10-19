<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '../vendor/autoload.php');
use Twilio\Rest\Client;
	
Class Sms{

	public function send_message($mobileno,$message)
	{
		//$sid = 'AC93c4b58383728efd4f4253b4c6023a5a';
		//$token = 'dcd15d331617d445b92186390be6c2ad';

		$sid = 'AC03c176aec769d6b3ca8433f772859c76';
		$token = '0586cb8c0dbcae6caad644121a78c0f9';

		$client = new Client($sid, $token);
		$result=$client->messages->create('+'.$mobileno,array('from' => '++19492698359','body' => $message));
		return $result;
	}

     
		

}