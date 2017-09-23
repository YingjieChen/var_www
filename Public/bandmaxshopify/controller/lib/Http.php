<?php
	namespace PrivateSDK;
	class Http{
		private $apikey;
		private $apipassword;
		private $curl_handler;
		private $host;
		function __construct($apikey,$apipassword,$host){
			$this->apikey		=	$apikey;
			$this->apipassword	=	$apipassword;
			$this->host		=	$host;
		}

		function getdata($path,$method,$postdata){
			$apikey		=	$this->apikey;
			$password	=	$this->apipassword;
			$url            =       "https://$apikey:$password@bandmax.myshopify.com/$path";
			$ch             =       curl_init();
			//设置选项，包括URL
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_HEADER,0);
			
			switch($method){
				case("post"):
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Content-Length: ' . strlen($postdata))
					);
					curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
					// post数据
					curl_setopt($ch, CURLOPT_POST, 1);
				break;
				case("delete"):
					// delete 数据
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
				case("put"):
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                'Content-Type: application/json',
                                                'Content-Length: ' . strlen($postdata))
                                        );
					// put 数据
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
					curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); //设置请求体，提交数据包
				break;
				default:
				break;
			}
			//执行并获取HTML文档内容
			$output         =       curl_exec($ch);
			//释放curl句柄
			curl_close($ch);
			//打印获得的数据
			return $output;
		}
		
	}
?>
