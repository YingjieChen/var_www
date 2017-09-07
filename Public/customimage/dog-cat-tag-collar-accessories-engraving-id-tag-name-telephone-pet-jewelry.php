<?php
	//获取远程文件的地址，通过file_get_contents()下载相应的源文件
	//取得文件的拓展名
	//基于拓展名创建画布
	//加载相应的字体
	//创建文字❤ 	♂♀
	//❤ 
	require_once("function.php");
	$genders	=	array("female"=>"♀","male"=>"♂","FEMALE"=>"♀","MALE"=>"♂");
	if(isset($_GET['bigimgpath'])){
		$bigImgPath	=	$_GET['bigimgpath'];
	}else{
		exit;
	}
	//$bigImgPath = isset($_GET['bigimgpath'])?$_GET['bigimgpath']:'https://cdn.shopify.com/s/files/1/0964/9808/products/GP1897_2_large.jpg';
	$img 		= 	imagecreatefromstring(file_get_contents($bigImgPath));
	if(isset($_GET['fontname'])&&file_exists("./font/".$_GET['fontname'].".ttf")){
		$fontname	=	$_GET['fontname'];
	}else{
		exit;
	}
	$font		=	"./font/$fontname.ttf";
	//$font 	= 	"./font/fofbb_ital.otf";//字体
	$black          =       imagecolorallocate($img, 204, 169, 144);//字体颜色 RGB
	
	$fontSize 	= 	isset($_GET['fontsize'])?intval($_GET['fontsize']):20;   //字体大小
	$circleSize 	= 	isset($_GET['circlesize'])?intval($_GET['circlesize']):0;   //字体大小
	$top 		= 	isset($_GET['top'])?intval($_GET['top']):150;       //顶边距
	$textcontent    =       $_GET['textcontent'];
	$left           =       isset($_GET['left'])?intval($_GET['left'])-mb_strlen($textcontent,'utf-8')/3*$fontSize:150;      //左边距

	$fontSize2       =       isset($_GET['fontsize2'])?intval($_GET['fontsize2']):20;   //字体大小
        $circleSize2     =       isset($_GET['circlesize2'])?intval($_GET['circlesize2']):0;   //字体大小
        $top2            =       isset($_GET['top2'])?intval($_GET['top2']):150;       //顶边距
	$textcontent2    =       $_GET['textcontent2'];
	$left2           =       isset($_GET['left2'])?intval($_GET['left2'])-mb_strlen($textcontent2,'utf-8')/3*$fontSize2:150;      //左边距

	$fontSize3       =       isset($_GET['fontsize3'])?intval($_GET['fontsize3']):20;   //字体大小
        $circleSize3     =       isset($_GET['circlesize3'])?intval($_GET['circlesize3']):0;   //字体大小
        $top3            =       isset($_GET['top3'])?intval($_GET['top3']):150;       //顶边距
        $textcontent3    =       $_GET['textcontent3'];
	$textcontent3	=	wordwrap($textcontent3,17,"\n",true);
        $left3           =       isset($_GET['left3'])?intval($_GET['left3']):150;      //左边距	
	
	$gender		=	isset($_GET['gender'])?strip_tags($_GET['gender']):"male";
	//如何获取性别
	imagefttext($img, $fontSize, $circleSize, $left, $top, $black, $font,$textcontent);
	imagefttext($img, $fontSize2, $circleSize2, $left2, $top2, $black, $font,$textcontent2);
	imagefttext($img, $fontSize3, $circleSize3, $left3, $top3, $black, $font,$textcontent3);
	imagefttext($img, 50, $circleSize3,210, $top2+70, $black, $font,$genders[$gender]);
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
