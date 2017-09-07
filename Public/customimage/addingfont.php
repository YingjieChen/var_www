<?php
	//获取远程文件的地址，通过file_get_contents()下载相应的源文件
	//取得文件的拓展名
	//基于拓展名创建画布
	//加载相应的字体
	//创建文字
	require_once("function.php");
	if(isset($_GET['bigimgpath'])){
		$bigImgPath	=	$_GET['bigimgpath'];
	}
	else{
		exit;
	}
	//$bigImgPath = isset($_GET['bigimgpath'])?$_GET['bigimgpath']:'https://cdn.shopify.com/s/files/1/0964/9808/products/GP1897_2_large.jpg';
	$img 		= 	imagecreatefromstring(file_get_contents($bigImgPath));
	if(isset($_GET['fontname'])&&file_exists("./font/".$_GET['fontname'])){
		$fontname	=	$_GET['fontname'];
	}
	else{
		exit;
	}
	$font		=	"./font/$fontname";
	//$font 		= 	"./font/fofbb_ital.otf";//字体
	$black          =       imagecolorallocate($img, 217, 199, 182);//字体颜色 RGB
	$fontSize 	= 	isset($_GET['fontsize'])?intval($_GET['fontsize']):20;   //字体大小
	$circleSize 	= 	isset($_GET['circlesize'])?intval($_GET['circlesize']):79;   //字体大小
	$left 		= 	isset($_GET['left'])?intval($_GET['left']):150;      //左边距
	$top 		= 	isset($_GET['top'])?intval($_GET['top']):150;       //顶边距
	$textcontent	=	$_GET['textcontent'];
	imagefttext($img, $fontSize, $circleSize, $left, $top, $black, $font,$textcontent);
	list($bgWidth, $bgHight, $bgType) = getimagesize($bigImgPath);
	switch ($bgType) {
		case 1: //gif
			header('Content-Type:image/gif');
			imagegif($img);
		break;
		case 2: //jpg
			header('Content-Type:image/jpg');
			imagejpeg($img);
		break;
	 	case 3: //jpg
		     	header('Content-Type:image/png');
			imagepng($img);
		break;
		default:
		break;
	}
	imagedestroy($img);
?>
