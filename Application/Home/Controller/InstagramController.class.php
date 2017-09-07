<?php
    namespace Home\Controller;
    use Think\Controller;
    class InstagramController extends Controller {
        public function test()
        {
		$filepath	=	C("ROOT")."/config/Instagram/data.json";
		echo filectime($filepath);
        }

	public function get()
	{
		$filepath       =       C("ROOT")."/config/Instagram/data.json";
		if((!file_exists($filepath))||time()-filectime($filepath)>24*60*60)
		{
			$data_str	=	file_get_contents("https://api.snapppt.com/items/?profile=u7jewelryofficial&page[size]=12");
			file_put_contents($filepath,$data_str);
		}
		else{
			$data_str	=	file_get_contents($filepath);
		}
		$dataArray		=	json_decode($data_str,true);		
		json_return($dataArray);
	}
    }
?>
