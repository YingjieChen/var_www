<?php
return array(
	//'配置项'=>'配置值'
	// 配置邮件发送服务器
    'MAIL_HOST' =>'smtp.exmail.qq.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>true, //启用smtp认证
    'MAIL_USERNAME' =>'support@u7jewelry.com',//你的邮箱名
    'MAIL_FROM' =>'support@u7jewelry.com',//发件人地址
    'MAIL_FROMNAME'=>'u7jewelry',//发件人姓名
    'MAIL_PASSWORD' =>'yang@147258KSLU7',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>true, // 是否HTML格式邮件
	
	//数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'bandmax', // 数据库名
	'DB_USER'   => 'bandmax', // 用户名
	'DB_PWD'    => 'kn3fTD2KYGFeCLIn1U5JD0', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => '', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8mb4', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
    //分页空间设置
    'PAGE_SIZE'=>5,
	//允许地址设置
	//允许接口访问地址
    "ROOT"      =>  $_SERVER["DOCUMENT_ROOT"]."/bandmax",
    "ALLOW_HOST"=>array(
        "HOST"  =>  array(
            "www.bandmax.com",
            "api.bandmax.com",
            "piwik.bandmax.com",
        ),
    ),
);
