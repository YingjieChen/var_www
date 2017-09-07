<?php
	require_once("function.php");
	$maxlength      =       16;
        function drawString($img,$middlepoint,$radius,$fontsize,$color,$font,$string,$startangle=622,$angleSize=40){
                //编码处理
                //相关计量
                $leng  = mb_strlen($string,'utf8'); //字符串长度
                $avgAngle  = $angleSize/($leng);  //平均字符倾斜度
                //拆分并写入字符串
                $words = array(); //字符数组
                for($i=0;$i<$leng;$i++){
                        $words[] = mb_substr($string,$i,1,'utf8');
                        $r = $startangle + $avgAngle*($i - $leng/2) + ($i-1);   //坐标角度
                        $R = $startangle+98 - $avgAngle*($leng-2*$i-1)/2 + (1-$i);  //字符角度
                        $x = $middlepoint['x'] + $radius * cos(deg2rad($r)); //字符的x坐标
                        $y = $middlepoint['y'] - $radius * sin(deg2rad($r)); //字符的y坐标
                        imagettftext($img, $fontsize, $R, $x, $y, $color, $font, $words[$i]);
                }
        }
        function fillbyzero($string){
                global $maxlength;
                $stringlenght   =       mb_strlen($string,'utf-8');
                $neededzero     =       $maxlength-$stringlenght;
                $resultstring   =       mb_substr($string,0,$maxlength,'utf-8');
                for($i=1;$i<$neededzero/2;$i++){
                        $resultstring           =       " $resultstring ";
                }
                return $resultstring;
        }
	//获取远程文件的地址，通过file_get_contents()下载相应的源文件
	//取得文件的拓展名
	//基于拓展名创建画布
	//加载相应的字体
	//创建文字❤ 
	if(isset($_GET['bigimgpath'])){
		$bigImgPath	=	$_GET['bigimgpath'];
	}else{
		exit;
	}
	$img 		= 	imagecreatefromstring(file_get_contents($bigImgPath));
	if(isset($_GET['fontname'])&&file_exists("./font/".$_GET['fontname'].".ttf")){
		$fontname	=	$_GET['fontname'];
	}else{
		exit;
	}
	$font		=	"./font/$fontname.ttf";
	//$font 	= 	"./font/fofbb_ital.otf";//字体
	$black          =       imagecolorallocate($img, 255, 255, 255);//字体颜色 RGB

	$fontSize 	= 	isset($_GET['fontsize'])?intval($_GET['fontsize']):20;   //字体大小
	$circleSize 	= 	isset($_GET['circlesize'])?intval($_GET['circlesize']):0;   //字体大小
	$top 		= 	isset($_GET['top'])?intval($_GET['top']):150;       //顶边距
	$textcontent    =       $_GET['textcontent'];
	$textcontent   	=      fillbyzero($textcontent);
	//$textcontent1	=	mb_substr();
	$left		=       isset($_GET['left'])?intval($_GET['left']):150;      //左边距

	$fontSize2      =       isset($_GET['fontsize2'])?intval($_GET['fontsize2']):20;   //字体大小
        $circleSize2    =       isset($_GET['circlesize2'])?intval($_GET['circlesize2']):0;   //字体大小
        $top2           =       isset($_GET['top2'])?intval($_GET['top2']):150;       //顶边距
	$textcontent2   =       $_GET['textcontent2'];
	$textcontent2   =      	fillbyzero($textcontent2);
	$left2          =       isset($_GET['left2'])?intval($_GET['left2']):150;      //左边距
	//imagefttext($img, $fontSize, $circleSize, $left, $top, $black, $font,$textcontent);
	//imagefttext($img, $fontSize2, $circleSize2, $left2, $top2, $black, $font,$textcontent2);
	/*
	http://api.u7jewelry.com/customimage/monogram-necklace-layered-necklace-personalized-heart-anniversary-gift-for-women.php?bigimgpath=https://cdn.shopify.com/s/files/1/0964/9808/products/golden_0ac594cb-58c2-43e1-a5d4-d56a0bdcd598_1024x1024.png&fontname=Times_New_Roman&fontsize=12&left=299.06&top=582.09&textcontent=jack%20and%20rose&circlesize=193&fontsize2=12&left2=713&top2=581&textcontent2=jack%20and%20rose&circlesize2=193
	*/
	drawString($img,array('x'=>$left,'y'=>$top),$circleSize,$fontSize,$black,$font,$textcontent,625,28);
	drawString($img,array('x'=>$left2,'y'=>$top2),$circleSize2,$fontSize2,$black,$font,$textcontent2,623,42);
	list($bgWidth, $bgHight, $bgType) 	= 	getimagesize($bigImgPath);
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
