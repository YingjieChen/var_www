<?php
	namespace Bandmax\Controller;
	use Think\Controller;
	use Think\Verify;
	class ConfigController extends Controller {
		public function config()
		{
			echo "window.config2=".json_encode(
					array(
						"admin"     =>      cookie("admin")?cookie("admin"):null,
					)
				);
		}

		public function loginVerify()
		{
			$Verify =     new Verify();
			$Verify->useImgBg = true;
			$Verify->length   = 6;
			$Verify->useNoise = false;
			$Verify->entry(1);
		}

		public function Logout()
		{
			cookie("admin",null);
			json_return(
				array(
					"errcode"       =>  0,
					"msg"           =>  "退出成功",
				)
			);
		}

		//http://localhost/index.php/Home/Config/checkLogin?code=xqjbfe&account=admin&password=21232f297a57a5a743894a0e4a801fc3
		public function checkLogin($code,$account,$password)
		{
			$verify                 =   new Verify();
			$verifycheckresult      =   $verify->check($code,1);
			if(false)
			{
				json_return(
					array(
						"errcode"   =>  $verifycheckresult,
						"msg"       =>   "你输入的验证码错误",
					)
				);
			}
			else if($this->checkloginfunction($account,$password))
			{
				json_return(
					array(
						"errcode"   =>  0,
						"msg"       =>  "登录成功",
					)
				);
			}
		}

		public function checkloginfunction($account,$password)
		{
			$adminObj   =   M("admin");
			$num        =   $adminObj->where(array("account"=>$account,"password"=>$password))->count();
			if($num>0)
			{
				$adminaccount   =       $adminObj->getByAccount($account);
				$adminaccount["password"]="";
				cookie('admin',$adminaccount,3600);
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public function subverify()
		{
			$timstam=	I("timestamp","","strip_tags");
			$num 	= 	4;
			$w	=	120;
			$h	=	40;
			$code = "";
			for ($i = 0; $i < $num; $i++) {
				$code .= rand(0, 9);
			}
			//4位验证码也可以用rand(1000,9999)直接生成
			//将生成的验证码写入session，备验证时用
			file_put_contents(C("ROOT")."/subvcode$timstam.json",$code);
			//创建图片，定义颜色值
			header("Content-type: image/PNG");
			$im = imagecreate($w, $h);
			$black = imagecolorallocate($im, 0, 0, 0);
			$gray = imagecolorallocate($im, 200, 200, 200);
			$bgcolor = imagecolorallocate($im, 255, 255, 255);
			//填充背景
		       	imagefill($im, 0, 0, $gray);
			//画边框
			imagerectangle($im, 0, 0, $w-1, $h-1, $black);
			//随机绘制两条虚线，起干扰作用
			$style = array ($black,$black,$black,$black,$black,
			$gray,$gray,$gray,$gray,$gray);
			imagesetstyle($im, $style);
			$y1 = rand(0, $h);
			$y2 = rand(0, $h);
			$y3 = rand(0, $h);
			$y4 = rand(0, $h);
			imageline($im, 0, $y1, $w, $y3, IMG_COLOR_STYLED);
			imageline($im, 0, $y2, $w, $y4, IMG_COLOR_STYLED);
			//在画布上随机生成大量黑点，起干扰作用;
			for ($i = 0; $i < 80; $i++) {
				imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
			}
			//将数字随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成
			$strx = rand(6, 16);
			for ($i = 0; $i < $num; $i++) {
				$strpos = rand(1, 6);
				imagestring($im, 20, $strx, $strpos, substr($code, $i, 1), $black);
				$strx += rand(16, 24);
			}
			imagepng($im);//输出图片
			imagedestroy($im);//释放图片所占内存
		}

		public function checkSubVerify()
		{
			$timstam        =       trim(I("timestamp","","strip_tags"));
			$key            =       "subvcode".$timstam;
			$suppostcode	=	file_get_contents(C("ROOT")."/subvcode$timstam.json");
			$code		=	trim(I("code","","strip_tags"));
//
			$verifycheckresult      =   strcasecmp($code,$suppostcode);
			json_return(
                                array(
                                        "errcode"       =>  $verifycheckresult,
                                        "msg"           =>  $verifycheckresult==0?"Sussessfully":"Failed code:$code,timestamp:$timstam,suppostcode:$suppostcode",
					"session"	=>  $_SESSION,
                                )
                        );
		}
		public function test()
		{
			echo C("ROOT")."/bandmax/subvcode$timstam.json";
		}
    }
?>
