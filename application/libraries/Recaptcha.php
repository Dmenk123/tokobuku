<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("./vendor/google/recaptcha/src/autoload.php");
// require_once __DIR__ . '/application/third_party/apis.php';

class Recaptcha
{
	public function generate()
	{
		//get api key recaptcha
		$secret = '6LcKN-MUAAAAAOJHTIPSVwDh2CohYZ9Rf17YWnlt';
		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		return $recaptcha;
	}
	
}
