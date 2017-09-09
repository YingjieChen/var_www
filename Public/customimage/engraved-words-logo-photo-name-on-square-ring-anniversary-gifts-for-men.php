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
	require_once("function.php");
	$is_fileuploaded	=	isset($_POST['type']);
	if($is_fileuploaded){
		//提交图片的时候的操作
		$imagefile	=	$_FILES['imagefile'];
		$tmpname	=	$imagefile['tmp_name'];
		$file_parts 	= 	pathinfo('dir/'.$imagefile['name']);
		$despath	=	"upload/".time().$file_parts['extension'];
		move_uploaded_file($tmpname,$despath);
		//这里进行相应的图片合成操作图片合成完毕之后的结果 left 365 top 350
	}else{
		//没有提交图片的时候的操作
		//获取远方提交的字符串
		$fonttext	=	$_GET['textcontent'];
		//字符串是否超出长度
		$linesize	=	6;
		$strlen		=	mb_strlen($fonttext,'utf-8');
		$fontSize	=	42;//这个建议为3的倍数
		
		/*$rows		=	ceil($strlen/$linesize);
		$rows		=	$rows>4?4:$rows;
		$fontSize	=	$fontSize/$rows;*/

		$fonttextnew    =       mb_substr($fonttext,0,24,'utf-8');
		$fonttextnew    =       strtoupper(mb_wordwrap($fonttextnew,$linesize,'utf-8',"\n",true));
		//画出新的图片		
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
		$black          =       imagecolorallocate($img, 204, 194, 182);//字体颜色 RGB	
		
		$top 		= 	isset($_GET['top'])?intval($_GET['top']):365;       //顶边距
		$left           =       isset($_GET['left'])?intval($_GET['left']):350;      //左边距
		
		$drawingtext	=	explode("\n",$fonttextnew);
		//linesize
		
		$beishus	=	array(
			1=>1.5,
			2=>1.5,
			3=>1.5,
			4=>(6/4),
			5=>(6/5),
			6=>1
		);

		

		$top1		=	0;
		for($i=0;$i<count($drawingtext)&&$i<4;$i++){
			$linesize	=	mb_strlen($drawingtext[$i],'utf-8');
			if($i==0){
				$top1	=0;
			}else{
				$linesize2	=       mb_strlen($drawingtext[$i-1],'utf-8');
				if($linesize2<=3){
					$top1	+=	1.5*$fontSize*4/3;
				}else{
					//$top1   +=      1.5*$fontSize*$beishu*4/3;
					$top1	+=	$fontSize*4/3*6/$linesize2;
				}
			}
			
			for($j=0;$j<$linesize;$j++){
				$ord	=	ord(mb_substr($drawingtext[$i],$j,1,'utf-8'));
				if($ord>19&&$ord<127){
					imagefttext($img, $fontSize*$beishus[$linesize]*4/3,$circleSize,$left+$fontSize*$beishus[$linesize]*4/3*$j,$top+$top1*$beishus[$linesize]+($top1+$fontSize*$beishus[$linesize]*4/3)/3, $black, $font,mb_substr($drawingtext[$i],$j,1,'utf-8'));
				}else{
					imagefttext($img, $fontSize*$beishus[$linesize], $circleSize, $left+$fontSize*$beishus[$linesize]*4/3*$j, $top+$top1*$beishus[$linesize]+($top1+$fontSize*$beishus[$linesize])/3, $black, $font,mb_substr($drawingtext[$i],$j,1,'utf-8'));
				}
			}
		}
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
	}
?>
