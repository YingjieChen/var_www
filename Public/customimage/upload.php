<?php
	// 指定允许其他域名访问
	header('Access-Control-Allow-Origin:*');
	// 响应类型
	header('Access-Control-Allow-Methods:POST');
	// 响应头设置
	header('Access-Control-Allow-Headers:x-requested-with,content-type');
	function get_extension($file)
	{
		return substr($file, strrpos($file, '.')+1);
	}
	if ((($_FILES["file"]["type"] == "image/png")||($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/pjpeg"))
		&& ($_FILES["file"]["size"] < 2*1024*1024))
		{
			if ($_FILES["file"]["error"] > 0)
			{
				echo json_encode(array("errmsg"=>"Error: " . $_FILES["file"]["error"],"errcode"=>1));
			}
			else
			{
				$time	=	time();
				$dir	=	dirname(__FILE__);	
				move_uploaded_file($_FILES["file"]["tmp_name"],$dir."/".$time.".".get_extension($_FILES["file"]["name"]));
				echo json_encode(array("fileurl"=>$dir."/".$time.".".get_extension($_FILES["file"]["name"]),"newhref"=>"//api.u7jewelry.com/customimage/".$time.".".get_extension($_FILES["file"]["name"]),"errcode"=>0));
			}
	}
?>
