<?php
    namespace Bandmax\Controller;
    use Think\Controller;
    use Think\Verify;
    class CacheController extends Controller {


        public function test()
        {
		$imgurl		=	I("imgurl","","strip_tags");
		$wenhaopos	=	strpos($imgurl,"?")-4;
		$filename	=	substr($imgurl,0,$wenhaopos);
		$filename	=	str_replace(".","_",$filename);	
		$filename	=	str_replace("/","_",$filename);
		$filecontent	=	file_get_contents("$imgurl");
		if(!file_exists(C("ROOT")."/uploads/u7cache/$filename.jpg"))
		{
			file_put_contents(C("ROOT")."/uploads/u7cache/$filename.jpg",$filecontent);
		}
		json_return(array("url"=>"//api.u7jewelry.com/uploads/u7cache/$filename.jpg"));
        }

	
        public function test2()
        {
		$imgurl		=	I("imgurl","","strip_tags");
		$wenhaopos      =       strpos($imgurl,"?")-4;
		$filename       =       substr($imgurl,0,$wenhaopos);
		$filename       =       str_replace(".","_",$filename);
		$filename       =       str_replace("/","_",$filename);
		$filecontent	=	file_get_contents("$imgurl");
		file_put_contents(C("ROOT")."/uploads/u7cache/$filename.jpg",$filecontent);
		echo "<img src=\"//api.u7jewelry.com/uploads/u7cache/$filename.jpg\">";
        }
    }
?>
