/*现金劵*/
            <?php     
         $CouponsetypeSql = mysql_query("select * from couponsetype where couponseid in ( select seid from seller where prove = '已通过' and authentication = '已认证' and CashCoupon = '开通' ) order by UpdateTime desc limit 0,10");    
         while($Couponsetype = mysql_fetch_array($CouponsetypeSql)){ 
            $SellerResult = query("seller"," seid = '$Couponsetype[couponseid]' "); 
            $Conpon = query("coupon"," coupontargetid = '$Couponsetype[couponseid]' order by coupondate desc "); 
            $totalCoupon = mysql_fetch_array(mysql_query("select sum(couponcount) as totalCoupon from coupon where coupontargetid = '$SellerResult[seid]' "));    
            echo "    
	<li style='margin: 0px 22px 20px 0px;'>
        <div class='top'> <a class='couponName' href='store.php?seller=ClpKQ19700262' title='{$SellerResult['Brand']}'>{$SellerResult['Brand']}</a>
          <div class='coupImg'> <img alt='南岸拾花摄影工作室现金券' src='http://www.17lehun.com/img/logo/nly31528062Ku.jpg' width='110' height='110'> </div>
          <div class='coupDtails' style='margin-top:-20px;'>
            <ul class='st_score'>
              <li class='score'>
                <div class='dimStar'> <i class='greyFive'></i> <i class='yellowFive' style='width:75px;'></i> </div>
                <b>5.0分</b> </li>
              <li><a href='' target='_blank'>共<span class='red'>1</span>条点评</a></li>
            </ul>
          </div>
        </div>
        <div class='bottom'>
          <p class='price'><em>￥</em><b>{$Conpon['couponprice']}</b></p>
          <div class='get'> <a href='{$root}forum/singleCoupon.php?seid={$Conpon[coupontargetid]}'>我要领取</a> </div>
          <p><span class='getCNumber'>{$totalCoupon['totalCoupon']}</span>人领取</p>
          <p>本期剩余3份 </p>
        </div>
      </li>   
             ";     
         } 
        ?>    
/*首页4L旅拍*/
        <?php
if($num > 0){        
	while($seller = mysql_fetch_array($query)){        
		//获取商家是否有现金卷    
		$avgscore = mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid = '$seller[seid]' and status = '已通过' "));   
		$score =(double)substr($avgscore[0],0,3);      
		$coupon = query("coupon"," coupontargetid = '$seller[seid]' ");       
		if($coupon['couponid'] !=""){       
			$IsCoupon ="<i class='couponsOwner' title='现金券'></i> ";       
		}else{       
			$IsCoupon ="";       
		}       
		//获取商家是否有评论       
		$secomment =query("secomment"," commenttargetid = '$seller[seid]' and status ='已通过' ");       
		if($secomment['secommentid'] !=""){       
			$IsSecommentid ="<i class='remarkedSeller' title='有评商户'></i> ";       
		}else{       
			$IsSecommentid ="";       
		}       
			   
		//修正商家认证状态图标        
		if($seller['authentication'] == "已认证"){        
			$authentication = "<i class='authOwner' title='已认证'></i>";        
		}else{        
			$authentication = "";        
		}      
				
		//商家保障状态图标        
		if($seller['Guarantee'] == "关闭" or $seller['Guarantee'] == ""){        
			$status = "";        
		}else{        
			$status = "<i class='couponsSafe' title='消费保障'></i> ";        
		}       
		if($seller['League'] == "开"){
			$league = "<i style='background-position: -2px -82px' class='couponsSafe' title='积分盟约'></i>";     
		}else{
			$league = "";
		}
		//模糊查询关键字高亮显示        
		if(isset($_SESSION['SearchStore']['name'])){        
			$seller['name'] = str_replace($_SESSION['SearchStore']['name'],"<span class='purpose'>{$_SESSION['SearchStore']['name']}</span>",$seller['name']);        
		}        
		if($seller['Brand'] == ""){        
			$SellerName = $seller['name'];        
		}else{        
			$SellerName = $seller['Brand'];        
		}
		 echo "        
			  <dl class='special_item of'>
				<dt><a href='{$root}store.php?seller={$seller['seid']}' class='special_items_img fl'><img style='width:80px;height:60px;' src='".ListImg($seller['logo'])."'></a></dt>
				<dd class='special_items_text fl'>
				  <div>
				  	<a href='{$root}store.php?seller={$seller['seid']}' class='fz16'>
                     {$SellerName}&nbsp;{$authentication}{$IsCoupon}{$IsSecommentid}{$status}{$league}				  	
					</a>
				  </div>
				  <div><a href='javascript:;' class='fz14'>免费领100元现金</a></div>
				</dd>
			  </dl>		
		";        
	}        
}else{        
	echo "一个婚礼人都没有";        
}        
?>   
/*筹婚攻略*/
<div class="common_problems_content"> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=EWK25033859uW";?>">登记结婚</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=DxM25033853Lm";?>">新人报道</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=gRQ25033837BZ";?>">社区公告</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=kGj25033900QG";?>">活动公告</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=hZM25556487nn";?>">组团询价</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=jNm25556438yj";?>">探店专区</a>
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=WpV24961689Sn";?>">婚照美图</a>
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=Xah24961698Zy";?>">钻石夫人</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=hfE24961709Kn";?>">婚宴酒店</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=KEd24961719YU";?>">婚纱礼服</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=LZs24961729Gv";?>">婚礼策划</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=fhh24961740QF";?>">婚礼用品</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=ndu24961767RK";?>">婚礼纪实</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=iob24961774rS";?>">蜜月纪实</a>
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=hCi24961791ta";?>">婚房装修</a>
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=urw24961811Fo";?>">婆媳杂谈</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=Xfz24961823PI";?>">备孕亲子</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=aBq24961831sZ";?>">夫妻关系</a> 
 <a href="<?php echo "{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=LoN25034273bl";?>">商家活动</a>
</div>

StoreID();

