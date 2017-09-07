<?php
	//http://tsn.baidu.com/text2audio?tex=asd&lan=zh&cuid=***&ctp=1&tok=24.e7660103e17e9986b857103c4dd50734.2592000.1483842272.282335-5154342
	$filecontent	=	file_get_contents("http://tsn.baidu.com/text2audio?tex=asd&lan=zh&cuid=***&ctp=1&tok=24.e7660103e17e9986b857103c4dd50734.2592000.1483842272.282335-5154342");
	$response	=	json_decode($filecontent,true);
	if(isset($response["err_no"]))
	{
		echo $filecontent;	
	}
	else
	{
		$time   =       time();
		file_put_contents("./text2audio/".$time.".mp3",$filecontent);
	}
	//https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=fIiRom33PrGzc9bFAGCE5um0&client_secret=2FjafsAwjv5HEbMsaBtRLH1lZBXhrqDH
	$restfulcontent	=	file_get_contents("https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=fIiRom33PrGzc9bFAGCE5um0&client_secret=2FjafsAwjv5HEbMsaBtRLH1lZBXhrqDH");
	echo $restfulcontent;
?>
