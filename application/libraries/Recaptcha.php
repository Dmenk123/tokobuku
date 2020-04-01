<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("./vendor/google/recaptcha/src/autoload.php");
require_once("./application/third_party/apis.php");

class Recaptcha
{
	public function generate()
	{
		//get api key recaptcha
		$apis = new \Apis;
		$key = $apis->api_key_recaptcha();
		
		$recaptcha = new \ReCaptcha\ReCaptcha($key);
		return $recaptcha;
	}
	
}




