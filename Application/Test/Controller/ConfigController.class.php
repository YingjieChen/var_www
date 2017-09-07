<?php
    namespace Home\Controller;
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
    }
?>
