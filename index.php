<?php
    $total  =       37;
    $reviews=       [];
    for($i=1;$i<=37;$i++)
    {
        $url    =       "https://www.amazon.com/U7-Fashion-Jewelry-Necklace-22-Inch/product-reviews/B010LWYH3M/ref=cm_cr_arp_d_paging_btm_2?ie=UTF8&reviewerType=avp_only_reviews&showViewpoints=1&sortBy=recent&pageNumber=$i";
        $html   =       file_get_contents($url);
        echo $url;
        $pos    =       strpos($html,"Show all reviews");
        for($j=0;$j<10;$j++)
        {
            $ratingpos       =       strpos($html,"a-icon a-icon-star a-star-",$pos);
            $rating = substr($html,$ratingpos+26,1);//获取rating
            $authorstartpos     =       strpos($html,"a-size-base a-link-normal author",$pos);//32+66
            $authorendpos       =       strpos($html,"</a></span><span class=\"a-declarative\" data-action=\"cr-popup\" data-cr-popup=\"{&quot;width&quot;:&quot;340&quot;,&quot;title&quot;:&quot;Help&quot;,&quot;url&quot;:&quot;/gp/help/customer/display.html/ref=cm_cr_dp_bdg_help?ie=UTF8&amp;nodeId=14279681&amp;pop-up=1#tr&quot;,&quot;height&quot;:&quot;340&quot;}\"></span>",$pos);
            $authornum          =       $authorendpos-$authorstartpos-100;
            $name = substr($html,$authorstartpos+100,$authornum)."\n";//获取name
            $bodystartpos     =       strpos($html,"<span data-hook=\"review-body\" class=\"a-size-base review-text\">",$pos);//62
            $bodyendpos       =       strpos($html,"</span></div><div class=\"a-row a-spacing-top-small review-comments comments-for-",$pos);
            $bodynum          =       $bodyendpos-$bodystartpos-62;
            $body = substr($html,$bodystartpos+62,$bodynum)."\n";//获取body
            $datestartpos     =       strpos($html,"<span data-hook=\"review-date\" class=\"a-size-base a-color-secondary review-date\">",$pos);//80
            $dateendpos       =       strpos($html,"</span></div><div class=\"a-row a-spacing-mini review-data review-format-strip\">",$pos);
            $datanum          =       $dateendpos-$datestartpos-83;
            $date = date("Y-m-d",strtotime(substr($html,$datestartpos+83,$datanum)))."\n";//获取date
            $pos            =       strpos($html,"Report abuse",$ratingpos);
            $reviews[]      =   array(
                "author"        =>      $name,
                "create_at"    =>       $date,
                "rating"        =>       $rating,
                "body"              =>  $body,
            );
        }
    }
