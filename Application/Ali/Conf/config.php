<?php
return array(
	//支付宝配置参数
	'alipay_config'=>array(
		'partner' =>'2088102169667604',   //这里是你在成功申请支付宝接口后获取到的PID；
		'key'=>'LXmB9UIAZwu3lYurcRhCKA==',//这里是你在成功申请支付宝接口后获取到的Key
		'sign_type'=>strtoupper('MD5'),
		'input_charset'=> strtolower('utf-8'),
		'cacert'=> getcwd().'\\cacert.pem',
		'transport'=> 'https',
	),
	//以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；
 	'alipay'   =>array(
 		//这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
 		'seller_email'=>'kijbcr1745@sandbox.com',
 		//这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
 		'notify_url'=>'https://api.u7jewelry.com/index.php/Ali/Pay/notifyurl', 
 		//这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
 		'return_url'=>'https://api.u7jewelry.com/index.php/Ali/Pay/returnurl',
 		//支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
 		'successpage'=>'User/myorder?ordtype=payed',   
 		//支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
 		'errorpage'=>'User/myorder?ordtype=unpay', 
 	),
);
