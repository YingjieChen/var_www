<?php
    namespace Home\Controller;
    use Think\Controller;
    use Think\Verify;
    class SocialoginController extends Controller {	
	public function add()
	{
		$Socialogin 	=	M("socialogin");
		$address	=	I("email");
		$Socialogin->add(array("email"=>$address));
	}
	
	public function find()
	{
		$Socialogin     =       M("socialogin");
                $address        =       I("email");
		$count 		=	$Socialogin->where(array("email"=>$address))->count();
		json_return(array("count"=>$count));
	}
    }
?>
