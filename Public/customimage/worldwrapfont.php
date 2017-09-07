<?php
	//获取远程文件的地址，通过file_get_contents()下载相应的源文件
	//取得文件的拓展名
	//基于拓展名创建画布
	//加载相应的字体
	//创建文字
	require_once("function.php");
	$maxlength	=16;
	function fillbyzero($string){
		global $maxlength;
		$stringlenght	=	mb_strlen($string,'utf-8');
		$neededzero	=	$maxlength-$stringlenght;
		$resultstring	=	$string;
		for($i=1;$i<$neededzero/2;$i++){
			$resultstring		=	" $resultstring ";
		}
		return $resultstring;
	}
	if(isset($_GET['bigimgpath'])){
		$bigImgPath	=	$_GET['bigimgpath'];
	}else{
		exit;
	}
	//$bigImgPath = isset($_GET['bigimgpath'])?$_GET['bigimgpath']:'https://cdn.shopify.com/s/files/1/0964/9808/products/GP1897_2_large.jpg';
	$img 		= 	imagecreatefromstring(file_get_contents($bigImgPath));
	$fontname       =       $_GET['fontname'];
	if(isset($_GET['fontname'])&&file_exists("./font/$fontname.ttf")){
		$fontname	=	$_GET['fontname'];
	}else{
		exit;
	}
	$font		=	"./font/$fontname.ttf";
	//$font 	= 	"./font/fofbb_ital.otf";					//字体
	$black          =       imagecolorallocate($img, 204, 194, 182);//字体颜色 RGB
	$fontSize 	= 	isset($_GET['fontsize'])?intval($_GET['fontsize'])*0.85:20; 		//字体大小
	$circleSize 	= 	isset($_GET['circlesize'])?intval($_GET['circlesize']):0;   	//字体大小
	$left 		= 	isset($_GET['left'])?intval($_GET['left']):150;      		//左边距
	$top 		= 	isset($_GET['top'])?intval($_GET['top']):150;       		//顶边距
	$textcontent	=	$_GET['textcontent'];
	
	$newtext	=	utf8_wordwrap($textcontent,16,"\n", true);
	$newtext_arr	=	explode("\n",$newtext);
	$newtext_arr2	=	array();
	/*for($i=0;$i<count($newtext_arr);$i++){
		$newtext_arr2[$i]       =       fillbyzero($newtext_arr[$i]);
		for($j=0;$j<mb_strlen($newtext_arr2[$i],'utf-8');$j++){
			imagefttext($img, $fontSize, $circleSize, $left+$j*$fontSize*0.67, $top+$i*$fontSize*1.2, $black, $font,$newtext_arr[$i][$j]);
		}
	}
	$newtext	=	implode("\n",$newtext_arr2);*/	
	imagefttext($img, $fontSize, $circleSize, $left, $top, $black, $font,$newtext);
	list($bgWidth, $bgHight, $bgType) = getimagesize($bigImgPath);
	switch($bgType){
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
