<?php
    namespace Home\Controller;
    use Think\Controller;
    use Think\Image;
    class ReviewattController extends Controller {
        public function config()
        {
            json_return(array(
                "isshow"=>[0=>"不显示",1=>"显示"],
            ));
        }
        //评论提交
        public function submitreview()
        {
            //获取所上传的文件
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =      C("ROOT")."/uploads/"; // 设置附件上传根目录
            $upload->subName = array('date','Y-m-d');
            // 上传文件
            $info   =   $upload->upload();
            $files = [];
            if($info) {// 上传成功 获取上传文件信息
                foreach($info as $file){
                    $files[] = $file['savepath'].$file['savename'];
                    $image = new \Think\Image(\Think\Image::IMAGE_GD,$upload->rootPath.$file['savepath'].$file['savename']); // GD库
		    if(!file_exists($upload->rootPath."thumb/".$file['savepath'])) mkdir($upload->rootPath."thumb/".$file['savepath']);
                    $image->thumb(100, 100,\Think\Image::IMAGE_THUMB_CENTER)->save($upload->rootPath."thumb/".$file['savepath'].$file['savename']);
                }
            }
//            else
//            {
//                json_return(array("errcode"=>1,"msg"=>$upload->getError()));
//                exit;
//            }
            //相应的数据实体
            $product_id     =       I("product_id","","strip_tags");
            $review         =       I("post.review/a");
            $rating         =       $review["rating"]?intval($review["rating"]):5;
            $author         =       $review["author"]?strip_tags($review["author"]):"anymous";
            $country        =       $review["country"]?strip_tags($review["country"]):"America";
            $body           =       $review["body"]?strip_tags($review["body"]):"";
            $data           =       array(
                "product_id"    =>      $product_id,
                "rating"         =>      $rating,
                "author"         =>      $author,
                "country"          =>    $country,
                "body"           =>      $body,
                "imageurl"      =>      json_encode($files),
                "create_at"     =>      date("Y-m-d H:i:s",time()),
            );
            $Reviewatt          =       M("reviewatt");
            if($Reviewatt->add($data))
            {
                json_return(array("errcode"=>0,"msg"=>"Thank you for submitting a review!"));
            }
            else
            {
                json_return(array("errcode"=>1,"msg"=>"Fail to commit"));
            }
        }

        //后端管理数据展示用的接口
        public function reviewattlist()
        {
            $reviewattObj   =   M("reviewatt");
            $page       =   I("get.page",1,"intval");
            $pagesize   =   I("pagesize",C("PAGE_SIZE"),"intval");
            $keyword    =   trim(I("keyword","","strip_tags"));
            $map        =   array(
                "product_id|author|country|body"=>array("like","%$keyword%"),
            );

            $total      =   $reviewattObj->where($map)->count();
            $rows       =   $reviewattObj->where($map)->limit(($page-1)*$pagesize.','.$pagesize)->order("product_id,create_at desc")->select();
            json_return(array(
                "total"=>$total,
                "selected"=>$page,
                "rows"=>$rows,
                "pagesize"=>$pagesize,
                "totalpage"=>ceil($total/$pagesize),
                "sql"=>$reviewattObj->getLastSql(),
            ));
        }
        public function hidden()
        {
            $id = I("id",0,"intval");
            M()->execute("update reviewatt set isshow=(isshow+1)%2 where id =$id");
            json_return(array(
                "errcode" => 0,
                "msg" => "数据更新成功",
                "sql"=>M()->getLastSql(),
            ));
        }

        //前端展示用的
        public function relistsortbyproid()
        {
            $reviewattObj   =   M("reviewatt");
            $product_id     =   I("product_id","","strip_tags");
            $page           =   I("get.page",1,"intval");
            $pagesize       =   I("pagesize",C("PAGE_SIZE"),"intval");
            $avg            =   ceil($reviewattObj->where(array("product_id"=>$product_id,"isshow"=>1))->avg("rating"));
            $total=$reviewattObj->where(array("product_id"=>$product_id,"isshow"=>1))->count();
            $rows=$reviewattObj->where(array("product_id"=>$product_id,"isshow"=>1))->limit(($page-1)*$pagesize.','.$pagesize)->order("create_at desc,product_id")->select();
            foreach($rows as $key=>$row)
            {
                $row["createstring"]=date("M d,Y",strtotime($row["create_at"]));
                $rows[$key]=$row;
            }
            json_return(array(
                "total"=>$total,
                "selected"=>$page,
                "rows"=>$rows,
                "pagesize"=>$pagesize,
                "totalpage"=>ceil($total/$pagesize),
                "avg"       =>$avg,
                "sql"=>$reviewattObj->getLastSql(),
            ));
        }

        //获取相应的产品列表
        public function getproductlist()
        {
            $allproductdetailjson   =   file_get_contents(C("ROOT")."/config/Product/list.json");
            $allproductdetailobj    =   json_decode($allproductdetailjson);
            $allproductdetail       =   $allproductdetailobj->products;
            $ids                    =   [];
            for($i=0;$i<count($allproductdetail);$i++)
            {
                $ids[]=$allproductdetail[$i]->id;
            }
            file_put_contents(C("ROOT")."/config/Product/list2.json",json_encode($ids));
        }

        //json数据还原(将其他网站的数据导入到u7jewerly里面去)
        public function importfromjson()
        {
            $productfiledata    =   file_get_contents(C("ROOT")."/config/Product/2214260293.json");
            $productdata        =   json_decode($productfiledata,true);
            if(M("reviewatt")->addAll($productdata))
            {
                json_return(
                    array(
                        "errcode"   =>  0,
                        "msg"       =>  "Success!",
                    )
                );
            }
        }
        //json数据全部导出
        public function export2json()
        {
            $responsedata   =   [];
            $allreviewdata  =   M("reviewatt")->where(array("isshow"=>1))->select();
            foreach($allreviewdata as $key => $reviewdata)
            {
                $responsedata[$reviewdata["product_id"]][]       =       $reviewdata;
            }
            file_put_contents(C("ROOT")."/config/Reviews/reviews.js","window.reviews=".json_encode($responsedata));
        }
	public function onepagelist(){
		$reviewattObj   =   M("reviewatt");
		$page           =   I("get.page",1,"intval");
		$pagesize       =   I("pagesize",C("PAGE_SIZE"),"intval");
		$avg            =   ceil($reviewattObj->where(array("ratting"=>array("gt",3),"isshow"=>1))->where("body<>''")->avg("rating"));
		$total=$reviewattObj->where(array("isshow"=>1,"ratting"=>array("gt",3)))->where("body<>''")->count();
		$rows=$reviewattObj->where(array("isshow"=>1,"ratting"=>array("gt",3)))->where("body<>''")->limit(($page-1)*$pagesize.','.$pagesize)->order("create_at desc,product_id")->select();
		foreach($rows as $key=>$row)
		{
			$row["createstring"]=date("M d,Y",strtotime($row["create_at"]));
			$rows[$key]=$row;
		}
		json_return(array(
			"total"=>$total,
			"selected"=>$page,
			"rows"=>$rows,
			"pagesize"=>$pagesize,
			"totalpage"=>ceil($total/$pagesize),
			"avg"       =>$avg,
			"sql"=>$reviewattObj->getLastSql(),
		));
	}
    }
