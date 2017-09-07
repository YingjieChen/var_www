<?php
    namespace Bandmax\Controller;
    use Think\Controller;
    use Think\Verify;
    class OtherController extends Controller {
        public function generate()
        {
			$request	=	I("inputstr");
			$arr		=	explode(".jpg",$request);
			echo "<form action='' method='get'><p>width:<input name='width'/></p><textarea name='inputstr' style='width:100%;height:100px;'></textarea><button type='submit'>提交</button></form>";
			foreach($arr as $key=>$img)
			{
				echo "<img src=\"$img.jpg\" width=\"580\"/><br>";
				echo "&lt;img src=\"$img.jpg\" width=\"580\"/&gt;<br>";
				echo "---------------------------------------------------------------------------------------------------<br>";
			}
        }

		public function generate2()
		{
			$request	=	I("inputstr");
			$width	=	I("width");
			$arr		=	explode(".jpg",$request);
			$tags=[];
			$strs=[];
			foreach($arr as $key=>$img)
			{
				$tags[]	= 	"$img.jpg";
				$strs[]=	"<img src=\"$img.jpg\" width=\"$width\"/>";
			}
			json_return(array("tags"=>$tags,"strs"=>$strs,"width"=>$width));
		}
    }
?>
