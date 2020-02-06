<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Enkripsi{
	private $privKey = "KlepoN_HangaT";
	private $cSalt 	 = "JaJaNaNPaSaR";
	
	/** MD5 hash modified with salt and bas64 **/
	public function myCrypt($pwd,$username){
		$toHash	  = $this->encrypt($pwd);
		$password = str_split($toHash,(strlen($toHash)/2)+1);
		$hash 	  = md5($this->encrypt($username) . $password[0] . $this->cSalt . $password[1]);
		return $hash; 
	}
	
	/* Base64 encrypt with Key */
	public function encrypt($string) {
		$result = '';
		for($i=0; $i<strlen($string); $i++){
			$char = substr($string, $i, 1);
			$keychar = substr($this->privKey, ($i % strlen($this->privKey))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}

		return base64_encode($result);
	}

	/* Base64 decrypt with Key */ 
	public function decrypt($string) {
		$result = '';
		$string = base64_decode($string);

		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($this->privKey, ($i % strlen($this->privKey))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}

		return $result;
	}

	

}