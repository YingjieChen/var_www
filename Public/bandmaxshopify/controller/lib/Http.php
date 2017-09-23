<?php
	namespace PrivateSDK;
	class Http{
		private $apikey;
		private $apipassword;
		private $curl_handler;
		function __construct($apikey,$apipassword){
			$this->apikey		=	$apikey;
			$this->apipassword	=	$apipassword;
		}
		
	}
?>
