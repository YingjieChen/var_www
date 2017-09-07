<?php
	namespace Home\Controller;
	use Think\Controller;
	class MailController extends Controller {
		public function config()
		{
			json_return(
				["issub"=>[0=>"已退订",1=>"已订阅"]]
			);
		}
		public function test()
		{
			$message	=	"<p>Name:".$_POST[contact][name]."</p>";
			$message	.=	"<p>phone number:".$_POST[contact]["phone-number"]."</p>";
			$message	.=	"<p>email:".$_POST[contact][email]."</p>";
			$message	.=	"<p>ProductLink:".$_POST[contact][ProductLink]."</p>";
			$message	.=	"<p>target-price:".$_POST[contact]["target-price"]."</p>";
			$message	.=	"<p>order-quantity:".$_POST[contact]["order-quantity"]."</p>";
			$message	.=	"<p>Country:".$_POST[contact][Country]."</p>";
			$message	.=	"<p>Company:".$_POST[contact][Company]."</p>";
			$message	.=	"<p>Inquiry:".$_POST[contact][Inquiry]."</p>";
			$message	.=	"<p><img src='https://api.u7jewelry.com/uploads/'/></p>";
			CussendMail("1038546502@qq.com","Custom Products Message",$message)?"Successfully sent!":"Fail to send";
		}
		//获取数据库当中所有订阅邮箱的数据
		public function subemailaddress()
		{
			$mailObj	=	M("emaillist");
			$page       =   I("get.page",1,"intval");
			$pagesize   =   I("pagesize",C("PAGE_SIZE"),"intval");
			$total=$mailObj->count();
			json_return(
				[
					"total"=>$total,
					"selected"=>$page,
					"rows"=>$mailObj->limit(($page-1)*$pagesize.','.$pagesize)->order("update_at desc,create_at desc")->select(),
					"pagesize"=>$pagesize,
					"totalpage"=>ceil($total/$pagesize),
				]
			);
		}
		//前端邮箱成功的时候将邮箱地址存进数据库
		public function subscribe(){
			$rules = array(
				array('emailaddress','require',L("_MAIL_RERUIRE_")), //默认情况下用正则进行验证
				array('emailaddress','email',L("_MAIL_NOT_LEGAL_")), //默认情况下用正则进行验证
				array('emailaddress','',L("_MAIL_HAS_EXITED_"),0,'unique',1),
			);
			$mailObj	=	M("emaillist");
			if (!$mailObj->validate($rules)->create(["emailaddress"=>I("emailaddress","","strip_tags"),"create_at"=>date("Y-m-d H:i:s",time())],1)){
				// 如果创建失败 表示验证没有通过 输出错误提示信息
				json_return(["errcode"=>1,"msg"=>$mailObj->getError()]);
			}else{
				// 验证通过 可以进行其他数据操作
				$mailObj->data(["emailaddress"=>I("emailaddress","","strip_tags")])->add();
				$this->sendmail(I("emailaddress"));
				json_return(["errcode"=>0,"msg"=>L("_SUBSCRIBE_SUCCESS_")]);
			}
		}
		//保存前端提交的邮件模板
		public function keeptemplate(){
			$title = I("title","邮件主题","strip_tags");
			$content = I("content","非常欢迎你订阅我们的邮件","htmlspecialchars");
			$Jsoncontent = json_encode([
				"title"=>$title,
				"content"=>$content,
			]);
			if(file_put_contents(C("ROOT")."/config/Mail/template.json",$Jsoncontent)>0){
				json_return([
					"errcode"=>0,
					"msg"=>"邮件模板修改成功",
				]);
			}else{
				json_return([
					"errcode"=>1,
					"msg"=>"邮件模板修改失败，请检查你是否具有目录".C("ROOT")."/config/Mail/template.json的修改权限",
				]);
			}
		}
		//邮件发送代码(订阅成功)
		public function sendmail($to){
			$content = json_decode(file_get_contents(C("ROOT")."/config/Mail/template.json"));
			sendMail($to,$content->title,htmlspecialchars_decode($content->content));
		}
		//邮件模板获取
		public function gettemplate(){
			$content = json_decode(file_get_contents(C("ROOT")."/config/Mail/template.json"));
			$content->content = htmlspecialchars_decode($content->content);
			json_return($content);
		}
		//删除相应的邮件记录
		public function deleteitem(){
			$id = I("id",0,"intval");
			if(M("emaillist")->where(["id"=>$id])->delete()){
				json_return(
					[
						"errcode"=>0,
						"msg"=>"该记录已经删除",
					]
				);
			}else{
				json_return(
					[
						"errcode"=>1,
						"msg"=>"该记录删除失败",
					]
				);
			}
		}
		//邮件群发代码
		public function sendtoall(){
			$title          =       I("title","","strip_tags");
			$content        =       I("content","","htmlspecialchars");
			$mail_list = M("emaillist")->field("emailaddress")->where("issub=1")->select();
			$addresslist = [];
			foreach($mail_list as $address){
				$addresslist[]=$address["emailaddress"];
			}
			if(sendMailAll($addresslist,$title,htmlspecialchars_decode($content))){
				json_return(["errcode"=>0,"msg"=>"发送成功"]);
			}else{
				json_return(["errcode"=>1,"msg"=>"发送错误"]);
			}
		}

		//定制邮件发送代码
		public function Cus(){
			//获取所上传的文件
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath  =      C("ROOT")."/uploads/"; // 设置附件上传根目录
			$upload->subName    = array('date','Y-m-d');
			// 上传文件
			$info   =   $upload->upload();
			$files = [];
			if($info) {// 上传成功 获取上传文件信息
				foreach($info as $file){
					$files[] = $file['savepath'].$file['savename'];
				}
			}else{
				$this->error($upload->getError());
			}
			$message	=	"<p>Name:".$_POST[contact][name]."</p>";
			$message	.=	"<p>phone number:".$_POST[contact]["phone-number"]."</p>";
			$message	.=	"<p>email:".$_POST[contact][email]."</p>";
			$message	.=	"<p>ProductLink:".$_POST[contact][ProductLink]."</p>";
			$message	.=	"<p>target-price:".$_POST[contact]["target-price"]."</p>";
			$message	.=	"<p>order-quantity:".$_POST[contact]["order-quantity"]."</p>";
			$message	.=	"<p>Country:".$_POST[contact][Country]."</p>";
			$message	.=	"<p>Company:".$_POST[contact][Company]."</p>";
			$message	.=	"<p>Inquiry:".$_POST[contact][Inquiry]."</p>";
			$message	.=	"<p><img src='https://api.u7jewelry.com/uploads/".$files[0]."'/></p>";
			if(CussendMail("support@u7jewelry.com","Custom Products Message",$message)){
				$this->success("Information sent successfully!");
			}
			else{
				$this->error("Fail to send");
			}
		}
		//分享页面的发送代码
		public function sharesend(){
			S(array('type'=>'memcache','host'=>'127.0.0.1','port'=>'12121', 'prefix'=>'u7','expire'=>300));
			$sharesendlist  =   S('sharesendlist');
			$ipadadress     =   get_client_ip();
			if(!isset($sharesendlist[$ipadadress]))
				$sharesendlist[$ipadadress]=0;
			else{
				$sharesendlist[$ipadadress]=$sharesendlist[$ipadadress]+1;
			}
			if($sharesendlist[$ipadadress]<3){
				$email      =   I("email","","strip_tags");
				$content    =   I("content","","strip_tags");
				if(CussendMail("support@u7jewelry.com","Suggesstion","$email => $content")){
					json_return(
						array(
							"errcode"=>0,
							"msg"=>"Information sent successfully!"
						)
					);
				}else{
					json_return(
						array(
							"errcode"=>1,
							"msg"=>"Fail to send!"
						)
					);
				}
				S('sharesendlist',$sharesendlist);
			}else{
				json_return(
					array(
						"errcode"=>1,
						"msg"=>"Fail to send!"
					)
				);
			}
		}
	}
