<?php
	function scaletheimage($imgpath="https://cdn.shopify.com/s/files/1/0964/9808/products/H489_15_1024x1024.jpg",$scale=1){
		//图片的等比缩放
		//因为PHP只能对资源进行操作，所以要对需要进行缩放的图片进行拷贝，创建为新的资源 
		$src		=	imagecreatefromstring(file_get_contents($imgpath));
		//取得源图片的宽度和高度 
		$size_src	=	getimagesize($imgpath);
		$w		=	$size_src['0']; 
		$h		=	$size_src['1']; 
		//指定缩放出来的最大的宽度（也有可能是高度） 
		$max		=	$w*$scale; 
		//根据最大值为300，算出另一个边的长度，得到缩放后的图片宽度和高度 
		if($w>$h){
			$w	=	$max; 
			$h	=	$h*($max/$size_src['0']); 
		}else{ 
			$h	=	$max;
			$w	=	$w*($max/$size_src['1']); 
		}
		//声明一个$w宽，$h高的真彩图片资源 
		$image		=	imagecreatetruecolor($w,$h);
		//关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
		imagecopyresampled($image, $src, 0, 0, 0, 0, $w, $h, $size_src['0'], $size_src['1']);
		return $image;
	}
?>
