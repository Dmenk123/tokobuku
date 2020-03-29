<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("./vendor/google/recaptcha/src/autoload.php");

class Recaptcha
{
	public function generate($secret='6LcKN-MUAAAAAOJHTIPSVwDh2CohYZ9Rf17YWnlt')
	{
		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		return $recaptcha;
	}
	
}