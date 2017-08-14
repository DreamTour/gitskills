<?php include "library/function.php";echo head("pc");ThisHeader();echo banner();?>
<div class="column">
    <ul class="superiority">
        <li><a href="<?php echo imgurl("asdf78a2sd7s");?>"><img src="<?php echo img("asdf78a2sd7s");?>"></a></li>
        <li><a href="<?php echo imgurl("s78s74sw");?>"><img src="<?php echo img("s78s74sw");?>"></a></li>
        <li><a href="<?php echo imgurl("sdf78a014dw");?>"><img src="<?php echo img("sdf78a014dw");?>"></a></li>
        <li><a href="<?php echo imgurl("s787w14a");?>"><img src="<?php echo img("s787w14a");?>"></a></li>
    </ul>
    <ul class="aurguPuzzle clear">
        <li><a class="imghoverOpa" href="<?php echo imgurl("DEf25731372aO");?>"><img style="width: 270px;height: 350px;" src="<?php echo img("DEf25731372aO");?>"></a></li>
        <li><a class="imghoverOpa" href="<?php echo imgurl("Sgn25731392jx");?>"><img src="<?php echo img("Sgn25731392jx");?>"></a></li>
        <li><a class="imghoverOpa" href="<?php echo imgurl("bUk25731409US");?>"><img src="<?php echo img("bUk25731409US");?>"></a></li>
        <li class="norimar"><a class="imghoverOpa" href="<?php echo imgurl("RtO25731418db");?>"><img src="<?php echo img("RtO25731418db");?>"></a></li>
        <li style="margin-right: 5px;"><a class="imghoverOpa" href="<?php echo imgurl("ffS25731434sD");?>"><img style="width: 269px;height:230px;" src="<?php echo img("ffS25731434sD");?>"></a></li>
        <li style="margin-right: 5px;"><a class="imghoverOpa" href="<?php echo imgurl("JoZ25731447Ve");?>"><img style="width:236px;height:230px;" src="<?php echo img("JoZ25731447Ve");?>"></a></li>
        <li><a class="imghoverOpa" href="<?php echo imgurl("zyN25731460lz");?>"><img src="<?php echo img("zyN25731460lz");?>"></a></li>
        <li><a class="imghoverOpa" href="<?php echo imgurl("dXn25731473zH");?>"><img src="<?php echo img("dXn25731473zH");?>"></a></li>
        <li class="norimar"><a class="imghoverOpa" href="<?php echo imgurl("fmB25731481RS");?>"><img src="<?php echo img("fmB25731481RS");?>"></a></li>
    </ul>
    <div class="weidingPhoto">
        <h3 class="indexHThree">拍婚照</h3>
        <a href="<?php echo "{$root}goods.php?TypeOne=d2s5d"?>" class="moreLink" style="color:#e13f4a;">更多&gt;&gt;</a>
        <ul class="clear" style="width:1300px;">
			<?php
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'd2s5d' and prove = '已通过' and authentication = '已认证' ) order by time desc limit 4 ");
			while($Goods = mysql_fetch_array($GoodsSql)){
				echo "
				<li>
					<a href='{$root}goodsmx.php?TypeOne=d2s5d&goods={$Goods['id']}'><img class='GoodsListIco' src='".ListImg($Goods['ico'])."'></a>
					<p class='GoodsListName'>".zishu($Goods['name'],20)."</p>
					<p class='GoodsListPrice'>￥{$Goods['price']}</p>
					<p class='IndexSellerBrand'>{$Goods['Brand']}</p>
				</li>
				";
			}
			?>
        </ul>
    </div>
    <div>
        <h3 class="indexHThree">订婚戒</h3>
        <a href="<?php echo "{$root}goods.php?TypeOne=j014e";?>" class="moreLink" style="color:#e13f4a;">更多&gt;&gt;</a>
        <ul class="weidings clear">
			<?php
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'j014e' and prove = '已通过' and authentication = '已认证' ) order by time desc limit 4 ");
			while($Goods = mysql_fetch_array($GoodsSql)){    
				echo "
				<li>
					<a href='{$root}goodsmx.php?TypeOne=j014e&goods={$Goods['id']}'><img class='GoodsListIco' src='".ListImg($Goods['ico'])."'></a>
					<p class='GoodsListName'>".zishu($Goods['name'],20)."</p>
					<p class='GoodsListPrice'>￥{$Goods['price']}</p>
					<p class='IndexSellerBrand'>{$Goods['Brand']}</p>
				</li> 
				";    
			}  
			?>    
        </ul>     
    </div>     
    <h3 class="indexHThree">社区论坛</h3>     
    <a href="<?php echo $root;?>forum/forum.php" class="moreLink" style="color:#e13f4a;">更多&gt;&gt;</a>     
    <ul class="bbsPlace clear">     
           
        <li class="clear">     
            <a href="" class='imghoverOpa'><img src="<?php echo img(ZQI25724159Oj);?>"></a>     
            <div class="showPost">     
                <h4>will结婚</h4>     
                <?php    
                $i=1;   
                $ForumTypeTwoSql = mysql_query("select * from ForumTypeTwo where ForumTypeOneId = 'cbJ24960387jB' ");   
                while($ForumTypeTwo = mysql_fetch_array($ForumTypeTwoSql)){   
                    $ForumTypeThreeSql = mysql_query("select * from ForumTypeThree where ForumTypeTwoId ='$ForumTypeTwo[id]' ");   
                    while($ForumTypeThree = mysql_fetch_array($ForumTypeThreeSql)){   
                        $ForumpostSql = mysql_query("select * from forumposts where forumtype = '$ForumTypeThree[id]' and status = '已发布' order by forumdate desc");   
                        while($Forumpost =mysql_fetch_array($ForumpostSql)){   
                            if($i <= 7){   
                                echo "   
                                     <a href=\"{$root}bbs.php?id={$Forumpost['forumid']}&TypeTwoId={$ForumTypeTwo['id']}\" class=\"postName\"><i class='disc'>·</i>$Forumpost[forumtitle]</a>   
                                     ";   
                            }   
                            $i++;   
                        }   
                    }   
                }   
                   
                ?>    
            </div>     
        </li>     
        <li class="clear">     
            <a class='imghoverOpa' href=""><img src="<?php echo img(JWs25724162Eu);?>"></a>     
            <div class="showPost">     
                <h4>结婚ing</h4>     
                <?php    
                $i=1;   
                $ForumTypeTwoSql = mysql_query("select * from ForumTypeTwo where ForumTypeOneId = 'oCm24960404hD' ");   
                while($ForumTypeTwo = mysql_fetch_array($ForumTypeTwoSql)){   
                    $ForumTypeThreeSql = mysql_query("select * from ForumTypeThree where ForumTypeTwoId ='$ForumTypeTwo[id]' ");   
                    while($ForumTypeThree = mysql_fetch_array($ForumTypeThreeSql)){   
                        $ForumpostSql = mysql_query("select * from forumposts where forumtype = '$ForumTypeThree[id]' and status = '已发布' order by forumdate desc");   
                        while($Forumpost =mysql_fetch_array($ForumpostSql)){   
                            if($i <= 7){   
                                echo "   
                                     <a href=\"{$root}bbs.php?id={$Forumpost['forumid']}&TypeTwoId={$ForumTypeTwo['id']}\" class=\"postName\"><i class='disc'>·</i>$Forumpost[forumtitle]</a>   
                                     ";   
                            }   
                            $i++;   
                        }   
                    }   
                }   
                ?>     
            </div>     
        </li>     
        <li class="clear">     
            <a class='imghoverOpa' href=""><img src="<?php echo img(hFl25724165Js);?>"></a>     
            <div class="showPost">     
                <h4>结婚ED</h4>     
                <?php    
                $i=1;   
                $ForumTypeTwoSql = mysql_query("select * from ForumTypeTwo where ForumTypeOneId = 'zdO24960413Ib' ");   
                while($ForumTypeTwo = mysql_fetch_array($ForumTypeTwoSql)){   
                    $ForumTypeThreeSql = mysql_query("select * from ForumTypeThree where ForumTypeTwoId ='$ForumTypeTwo[id]' ");   
                    while($ForumTypeThree = mysql_fetch_array($ForumTypeThreeSql)){   
                        $ForumpostSql = mysql_query("select * from forumposts where forumtype = '$ForumTypeThree[id]' and status = '已发布' order by forumdate desc");   
                        while($Forumpost =mysql_fetch_array($ForumpostSql)){   
                            if($i <= 7){   
                                echo "   
                                     <a href=\"{$root}bbs.php?id={$Forumpost['forumid']}&TypeTwoId={$ForumTypeTwo['id']}\" class=\"postName\"><i class='disc'>·</i>$Forumpost[forumtitle]</a>   
                                     ";   
                            }   
                            $i++;   
                        }   
                    }   

                }   
                ?>       
            </div>     
        </li>     
        <li class="clear">     
            <a class='imghoverOpa' href=""><img src="<?php echo img(DBo25724168Ra);?>"></a>     
            <div class="showPost">     
                <h4>站内活动</h4>     
                <?php    
                $i=1;   
                $ForumTypeTwoSql = mysql_query("select * from ForumTypeTwo where ForumTypeOneId = 'sbo25033883dr' ");   
                while($ForumTypeTwo = mysql_fetch_array($ForumTypeTwoSql)){   
                    $ForumTypeThreeSql = mysql_query("select * from ForumTypeThree where ForumTypeTwoId ='$ForumTypeTwo[id]' ");   
                    while($ForumTypeThree = mysql_fetch_array($ForumTypeThreeSql)){   
                        $ForumpostSql = mysql_query("select * from forumposts where forumtype = '$ForumTypeThree[id]' and status = '已发布' order by forumdate desc");   
                        while($Forumpost =mysql_fetch_array($ForumpostSql)){   
                            if($i <= 7){   
                                echo "   
                                     <a href=\"{$root}bbs.php?id={$Forumpost['forumid']}&TypeTwoId={$ForumTypeTwo['id']}\" class=\"postName\"><i class='disc'>·</i>$Forumpost[forumtitle]</a>   
                                     ";   
                            }   
                            $i++;   
                        }   
                    }   
                }   
                ?>     
            </div>     
        </li>     
    </ul>     
    <div class="indexArguImg">    
        <a target="_blank" href="<?php echo imgurl("djd57e");?>"><img src="<?php echo img("djd57e");?>" /></a>     
    </div>     
    <h3 class="indexHThree">现金券</h3>     
    <a href="<?php echo $root;?>forum/coupons.php" class="moreLink" style="color:#e13f4a;">更多&gt;&gt;</a>     
    <ul class="indexCupons clear">    
        <?php     
         $CouponsetypeSql = mysql_query("select * from couponsetype where couponseid in ( select seid from seller where prove = '已通过' and authentication = '已认证' and CashCoupon = '开通' ) order by UpdateTime desc limit 0,10");    
         while($Couponsetype = mysql_fetch_array($CouponsetypeSql)){ 
            $SellerResult = query("seller"," seid = '$Couponsetype[couponseid]' "); 
            $Conpon = query("coupon"," coupontargetid = '$Couponsetype[couponseid]' order by coupondate desc "); 
            $totalCoupon = mysql_fetch_array(mysql_query("select sum(couponcount) as totalCoupon from coupon where coupontargetid = '$SellerResult[seid]' "));    
            echo "    
            <li class=\"singleCoup\">     
                <span class=\"price\"><em>￥</em>{$Conpon['couponprice']}</span>     
                <span class=\"cupName\" title=\"{$SellerResult['Brand']}\">{$SellerResult['Brand']}</span>     
                <a href=\"{$root}forum/singleCoupon.php?seid={$Conpon[coupontargetid]}\" class=\"getNow\">立即领取</a>     
                <span class=\"msg\"><i class=\"getNum\">{$totalCoupon['totalCoupon']}</i>人领取</span>     
            </li>    
             ";     
         } 
        ?>    
    </ul>     
</div>     
<script type="text/javascript">    
//被动备份数据库    
$.post("<?php echo "{$root}library/backups.php";?>",{ThisBackups:"ThisBackups"},function(data){});      
$(".bbsPlace li").eq(1).addClass("specLi"); 
$(".bbsPlace li").eq(3).addClass("specLi"); 
</script>     
<?php      
echo warn();ThisFooter();     
?>          
