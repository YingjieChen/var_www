<?php
namespace Home\Controller;
use Think\Controller;

class MenuController extends Controller {
	public function getmenu()
	{
        $arr_lr = M("menu")->where("title = '根节点'")->select();
        if($arr_lr){
            $right = array();
            //查找这里面所有的节点包含根节点
            $arr_tree = M("menu")->order("ltv asc")->where("ltv >=".$arr_lr[0]['ltv']." and ltv<= ".$arr_lr[0]['rgv'])->select();
            foreach($arr_tree as $v){
                $title = $v['title'];
                if(count($right)){
                    while ($right[count($right) -1] < $v['rgv']){
                        array_pop($right);
                    }
                    $title="|-".$title;
                }
                switch(count($right))
                {
                    case(1):
                        $arr_list[] = array('id' => $v['id'], 'title' => str_repeat('  ', count($right)).$title, 'name' =>$v['title'],"level"=>count($right),"object"=>$v["object"]);
                    break;
                    case(2):
                        $arr_list[count($arr_list)-1]["sub"][] = array('id' => $v['id'], 'title' => str_repeat('  ', count($right)).$title, 'name' =>$v['title'],"level"=>count($right),"object"=>$v["object"]);
                    break;
                }
                $right[] = $v['rgv'];
            }
        }
        return $arr_list;
	}
}