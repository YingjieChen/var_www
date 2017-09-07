<?php
    namespace Home\Controller;
    use Think\Controller;
    use Think\Verify;
    class TestController extends Controller {
        public function test()
        {
		echo get_client_ip();
        }
    }
?>
