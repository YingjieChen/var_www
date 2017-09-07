<?php
    namespace Bandmax\Controller;
    use Think\Controller;
    use Think\Verify;
    class StatsController extends Controller {
        public function add()
        {
		
		$count = intval(file_get_contents(C("ROOT")."/bandmax.json"));
		file_put_contents(C("ROOT")."/bandmax.json",++$count);
		file_put_contents(C("ROOT")."/ip.json",getIp()." ".date("Y-m-d H:i:s",time())."\n",FILE_APPEND);
	//	if(preg_match("/^70.195.133.95$/",getIp()))
	//	{
	//		echo "<script language=\"javascript\"> window.location.href=\"https://www.google.com\"</script>";
	//	}
        }
    }
?>
