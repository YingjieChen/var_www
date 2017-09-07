<?php
    namespace Bandmax\Controller;
    use Think\Controller;
    use Think\Image;
    class ShareproController extends Controller {
        public function config()
        {
            json_return(array(
                "isshow" => [0 => "不显示", 1 => "显示"],
            ));
        }

        public function getContent()
        {
            $filecontent    =   file_get_contents(C("ROOT")."/config/Promotion/config.json");
            $contentobj     =   json_decode($filecontent);
            json_return($contentobj);
        }

        //获取banner
        public function getBanner()
        {
            $filecontent    =   file_get_contents(C("ROOT")."/config/Promotion/config.json");
            $contentobj     =   json_decode($filecontent,true);
            $image=file_get_contents(C("ROOT")."/uploads/".$contentobj["banner"]["img"]);
//            $content=addslashes($image);
            header('Content-type: image/jpg');
            echo $image;
        }

        public function setContent()
        {
            //当下的配置文件
            $filecontent    =   file_get_contents(C("ROOT")."/config/Promotion/config.json");
            $contentobj     =   json_decode($filecontent,true);

            //banner 的配置
            $bannerurl = I("banner_url","","strip_tags");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =      C("ROOT")."/uploads/"; // 设置附件上传根目录
            $upload->subName = array('date','Y-m-d');
            // 上传单个文件
            $info   =   $upload->uploadOne($_FILES['bannerimg']);
            if(!$info) {// 上传错误提示错误信息
                $bannerimg = $contentobj["banner"]["img"];
            }else{// 上传成功 获取上传文件信息
                $bannerimg=$info['savepath'].$info['savename'];
            }

            $heads          =   I("head/a");
            $descriptions   =   I("description/a");
            $Products       =   [];
            foreach($heads as $key => $head)
            {
                $img        =   $upload->uploadOne($_FILES['img'.$key]);
                if(!$img) {// 上传错误提示错误信息
                    $resimg = $contentobj["Products"][$key]["img"];
                }else{// 上传成功 获取上传文件信息
                    $resimg = $img['savepath'].$img['savename'];
                }

                $Products[]=array(
                    "img"=>$resimg,
                    "head"=>$head,
                    "description"=>$descriptions[$key],
                );
            }

            //$img_arr    =   $_POST["img[]"];
            $restful    =   array(
                "banner"=>array(
                    "url"=>$bannerurl,
                    "img"=>$bannerimg,
                ),
                "Products"=>$Products,
            );
            if(file_put_contents(C("ROOT")."/config/Promotion/config.json",json_encode($restful))>0)
            {
                json_return(array("errcode"=>0,"msg"=>"更新完成"));
            }
            else
            {
                json_return(array("errcode"=>1,"msg"=>"更新失败"));
            }
        }

        public function getnamelist()
        {
            $namelistfile   =   file_get_contents(C("ROOT")."/config/Promotion/namelist.json");
            $namelist       =   json_decode($namelistfile,true);
            json_return($namelist);
        }

        public function addnamelist()
        {
            $namelistfile   =   file_get_contents(C("ROOT")."/config/Promotion/namelist.json");
            $namelist       =   json_decode($namelistfile,true);
            $faceurl        =   I("faceurl","","strip_tags");
            $img            =   I("img","","strip_tags");
            $facename       =   I("facename","","strip_tags");
            $urlforimg      =   I("urlforimg","","strip_tags");
            $newObj         =   array(
                "faceurl"=>$faceurl,
                "img"=>$img,
                "urlforimg"=>$urlforimg,
                "facename"=>$facename,
                "time"=>date("Y-m-d H:i:s")
            );
            array_unshift($namelist,$newObj);
            file_put_contents(C("ROOT")."/config/Promotion/namelist.json",json_encode($namelist));
            json_return($namelist);
        }

        public function deletenamelist()
        {
            $index  =   I("index",1,"intval");
            $namelistfile   =   file_get_contents(C("ROOT")."/config/Promotion/namelist.json");
            $namelist       =   json_decode($namelistfile,true);
            array_splice($namelist, $index, 1);
            file_put_contents(C("ROOT")."/config/Promotion/namelist.json",json_encode($namelist));
            json_return($namelist);
        }
    }
