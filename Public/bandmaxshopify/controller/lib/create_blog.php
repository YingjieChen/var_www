<?php
	$apikey		=	"173ee8115fed0e113f55d1d6ad02b37d";
	$password	=	"70b8d79341199077ebb1ac3dc4179ebc";
	$url            =       "https://$apikey:$password@bandmax.myshopify.com/admin/blogs.json";
        $ch             =       curl_init();
	$data_string	=	'{"blog":{"title": "News"}}';
        //设置选项，包括URL
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
	);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
	// post数据
	curl_setopt($ch, CURLOPT_POST, 1);
	// post的变量
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	
        //执行并获取HTML文档内容
        $output         =       curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        echo $output;
?>
