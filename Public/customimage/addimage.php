<?php
	//需要输入的参数
	//bigimgpath=https://cdn.shopify.com/s/files/1/0964/9808/products/GP1897_2_large.jpg&fontname=fofbb_ital.otf&fontsize=32&left=100&top=200
	//bigimgpath	大图背景图的路径
	//smallimgpath	小图的路径
	include_once('scale.php');
	require_once("function.php");
	if(isset($_GET['scale'])){
		$scale		=	intval($_GET['scale']);
	}else{
		$scale		=	0.5;
	}
	if(isset($_GET['bigimgpath'])){
		$bigImgPath	=	$_GET['bigimgpath'];
	}else{
		$bigImgPath	=	'http://api.u7jewelry.com/customimage/image/big.png';
	}
	if(isset($_GET['qcodepath'])){
                $qCodePath     =       $_GET['qcodepath'];
        }else{
                $qCodePath     =       'http://api.u7jewelry.com/customimage/image/ontop.png';
        }
	$bigImg 	= 	imagecreatefromstring(file_get_contents($bigImgPath));
	$qCodeImg 	= 	scaletheimage($qCodePath,$scale);
	$resultImg	=	imagecreatefromstring(file_get_contents($bigImgPath));
	list($qCodeWidth,$qCodeHight,$qCodeType) 	= 	getimagesize($qCodePath);
	list($bigWidth,$bigHight,$bigType) 		= 	getimagesize($bigImgPath);
	// imagecopymerge使用注解
	imagecopymerge($resultImg,$qCodeImg,150,300,0,0,$qCodeWidth*$scale,$qCodeHight*$scale,100);//tag小图标
	imagecopymerge($resultImg,$bigImg,0,0,0,0,$bigWidth, $bigHight,100);
	switch($bigType){
		case 1: //gif
			header('Content-Type:image/gif');
			imagegif($resultImg);
		break;
		case 2: //jpg
			header('Content-Type:image/jpg');
			imagejpeg($resultImg);
		break;
		case 3: //jpg
			header('Content-Type:image/png');
			imagepng($resultImg);
		break;
		default:
			# code...
		break;
	}
	imagedestroy($resultImg);
	imagedestroy($bigImg);
	imagedestroy($qCodeImg);
?>
