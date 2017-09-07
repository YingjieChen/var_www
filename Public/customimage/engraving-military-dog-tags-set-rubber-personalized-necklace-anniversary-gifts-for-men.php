<?php
	//获取远程文件的地址，通过file_get_contents()下载相应的源文件
	//取得文件的拓展名
	//基于拓展名创建画布
	//加载相应的字体
	//创建文字❤ 
	require_once("function.php");
	if(isset($_GET['bigimgpath'])){
		$bigImgPath	=	$_GET['bigimgpath'];
	}else{
		exit;
	}
	//http://api.u7jewelry.com/customimage/addingtwofont.php?bigimgpath=https://cdn.shopify.com/s/files/1/0964/9808/products/golden_fd8ff399-2831-4238-af0c-d89b0743cbe8_1024x1024.png&fontname=AaTaurus&fontsize=25&left=250&top=600&textcontent=jack%20and%20rose&fontsize2=25&left2=792&top2=600&textcontent2=jack%20and%20rose
	//$bigImgPath = isset($_GET['bigimgpath'])?$_GET['bigimgpath']:'https://cdn.shopify.com/s/files/1/0964/9808/products/GP1897_2_large.jpg';
	$img 		= 	imagecreatefromstring(file_get_contents($bigImgPath));
	if(isset($_GET['fontname'])&&file_exists("./font/".$_GET['fontname'].".ttf")){
		$fontname	=	$_GET['fontname'];
	}else{
		exit;
	}
	$font		=	"./font/$fontname.ttf";
	//$font 	= 	"./font/fofbb_ital.otf";//字体
	$black          =       imagecolorallocate($img, 204, 194, 182);//字体颜色 RGB

	$fontSize 	= 	isset($_GET['fontsize'])?intval($_GET['fontsize']):20;   //字体大小
	$circleSize 	= 	isset($_GET['circlesize'])?intval($_GET['circlesize']):0;   //字体大小
	$top 		= 	isset($_GET['top'])?intval($_GET['top']):150;       //顶边距
	$textcontent    =       $_GET['textcontent'];
	$left           =       isset($_GET['left'])?intval($_GET['left']):150;      //左边距

	$fontSize2       =       isset($_GET['fontsize2'])?intval($_GET['fontsize2']):20;   //字体大小
        $circleSize2     =       isset($_GET['circlesize2'])?intval($_GET['circlesize2']):0;   //字体大小
        $top2            =       isset($_GET['top2'])?intval($_GET['top2']):150;       //顶边距
	$textcontent2    =       $_GET['textcontent2'];
	//$textcontent2	 =	 iconv("utf-8","gb2312",$textcontent2);
	$left2           =       isset($_GET['left2'])?intval($_GET['left2']):150;      //左边距
	imagefttext($img, $fontSize, $circleSize, $left, $top, $black, $font,$textcontent);
	imagefttext($img, $fontSize2, $circleSize2, $left2, $top2, $black, $font,$textcontent2);

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
