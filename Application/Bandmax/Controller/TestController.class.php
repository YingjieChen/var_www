<?php
    namespace Bandmax\Controller;
    use Think\Controller;
    class TestController extends Controller {
        public function test()
        {
		print_r($_SESSION["subvcode1484118906000"]);
        }
	
    }
?>
