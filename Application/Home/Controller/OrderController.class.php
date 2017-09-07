<?php
    namespace Home\Controller;
    use Think\Controller;
    class OrderController extends Controller {
        public function config()
        {
            json_return(
                array(
                    "admin"     =>      cookie("admin")?cookie("admin"):null,
                )
            );
        }

        //获取配置文件当中的所有未付款数据
        public function unpaidorder()
        {
            $filecontent    =   file_get_contents(C("ROOT")."/config/Order/config.json");
            $orders          =   json_decode($filecontent,true);
            $neworderlist   =   [];
            foreach($orders as $key=>$order)
            {
                $neworderlist[]=$order;
            }
            json_return(
                array(
                        "rows"=>$neworderlist,
                )
            );
        }
        //保存前端提交的邮件模板
        public function keeptemplate()
        {
            $title = I("title","邮件主题","strip_tags");
            $content = I("content","非常欢迎你订阅我们的邮件","htmlspecialchars");
            $Jsoncontent = json_encode([
                "title"=>$title,
                "content"=>$content,
            ]);
            if(file_put_contents(C("ROOT")."/config/Order/template.json",$Jsoncontent)>0)
            {
                json_return([
                    "errcode"=>0,
                    "msg"=>"邮件模板修改成功",
                ]);
            }
            else
            {
                json_return([
                    "errcode"=>1,
                    "msg"=>"邮件模板修改失败，请检查你是否具有目录".C("ROOT")."/config/Order/template.json的修改权限",
                ]);
            }
        }
        //邮件模板获取
        public function gettemplate()
        {
            $content = json_decode(file_get_contents(C("ROOT")."/config/Order/template.json"));
            $content->content = htmlspecialchars_decode($content->content);
            json_return($content);
        }

        //催款Go
        public function dopush()
        {
            $address    =   I("address","","strip_tags");
            $content = json_decode(file_get_contents(C("ROOT")."/config/Order/template.json"));
            $content->content = htmlspecialchars_decode($content->content);
            if(sendMail($address,$content->title,htmlspecialchars_decode($content->content)))
            {
                json_return(array(
                    "errcode"   =>  0,
                    "msg"       =>  "success to send",
                ));
            }
            else
            {
                json_return(array(
                    "errcode"   =>  1,
                    "msg"       =>  "fail to send",
                ));
            }

        }
    }
?>
