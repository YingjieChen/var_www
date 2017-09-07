<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image;

class IndexController extends Controller {
    public function config()
    {
        $menuC =new MenuController();
        json_return(array(
            "menulist"      =>      $menuC->getmenu(),
        ));
    }

    public function water()
    {
        $image = new \Think\Image(Image::IMAGE_GD,C("ROOT")."/config/Font/52d29f071b68b.jpg"); // GD库
        //$image->thumb(150, 150)->save('./thumb.jpg');
        $image->text('www.u7jewelry.com',C("ROOT")."/config/Font/SDB.ttf",$image->width()/30,'#000000',\Think\Image::IMAGE_WATER_SOUTHEAST)->save(C("ROOT")."/config/Font/52d29f071b68b.jpg");
        $image->thumb(100, 100,\Think\Image::IMAGE_THUMB_CENTER)->save(C("ROOT")."/config/Font/thumb/52d29f071b68b.jpg");
    }

    public function Index()
    {
        $total  =       37;
        for($i=1;$i<=2;$i++)
        {
            $html   =       file_get_contents("https://www.amazon.com/U7-Fashion-Jewelry-Necklace-22-Inch/product-reviews/B010LWYH3M/ref=cm_cr_arp_d_paging_btm_2?ie=UTF8&reviewerType=avp_only_reviews&showViewpoints=1&sortBy=recent&pageNumber=$i");
            $pos    =       0;
            for($j=0;$j<10;$j++)
            {
                $firstpos       =       strpos($html,"a-start",$pos);
                echo $firstpos;
            }
        }
    }	
}
