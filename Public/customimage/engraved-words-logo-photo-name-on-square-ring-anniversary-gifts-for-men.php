<?php
	/*
		选择图片具体操作
		1，html 	当中增加图片选择框
		2，jQuery 	控制选择了图片之后要上传到服务器上面去
			a,js判断所上传的文件的尺寸1M以内
		3，PHP 		接受ajax post 传送过来的数据
			a，判断上传的文件的尺寸
			b，判断上传的文件的比例，一定要是正方形
	*/
	// 指定允许其他域名访问
	header('Access-Control-Allow-Origin:*');
	// 响应类型
	header('Access-Control-Allow-Methods:POST');
	// 响应头设置
	header('Access-Control-Allow-Headers:x-requested-with,content-type');
	require_once("function.php");
	$is_fileuploaded	=	isset($_POST['type']);
	if($is_fileuploaded){
		//对相应的图片进行判定
		//提交图片的时候的操作
		$time		=	time();
		$imagefile	=	$_FILES['imagefile'];
		$tmpname	=	$imagefile['tmp_name'];
		$file_parts 	= 	pathinfo('dir/'.$imagefile['name']);
		$despath	=	"upload/".$time.".".$file_parts['extension'];
		if(move_uploaded_file($tmpname,$despath)){
			$imagedata = getimagesize($despath);
			$olgWidth = $imagedata[0];
			$oldHeight = $imagedata[1];
			if($olgWidth/$oldHeight<1.1&&$olgWidth/$oldHeight>0.909&&filesize($despath)<1024*1024*2){
				echo json_encode(array(
                                        'errcode'=>0,
                                        'imgurl'=>"https://".$_SERVER['SERVER_NAME']."/customimage/upload/$time.".$file_parts['extension'],
                                ));
			}else{
				unlink($despath);
				echo json_encode(array(
					'errcode'	=>	1,
					'msg'		=>	'The scale of the image must be 0.91:1 to 1:1.1;And filesize no more than 1MB.',
				));
			}
		}else{
			echo json_encode(array(
				'errcode'=>1,
				'msg'           =>      'Fail to upload the file',
			));
		}
	}
?>
