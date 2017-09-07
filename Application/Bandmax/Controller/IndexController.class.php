<?php
    namespace Bandmax\Controller;
    use Think\Controller;
    class IndexController extends Controller {
        public function test()
        {
		echo get_client_ip();
        }
	public function config()
    	{
         	$menuC =new MenuController();
         	json_return(array(
             		"menulist"      =>      $menuC->getmenu(),
         	));
     	}
    }
?>
