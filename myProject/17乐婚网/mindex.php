<?php include "Mlibrary/mfunction.php";              
echo head("m");          
?>       
<header> <a href="javascript:;"><em class="index-city">重庆</em></a><a href="<?php echo "{$mroot}mUser/muLogin.php";?>"><i class="u_login"></i></a>            
  <p class="search-line" contenteditable="false" id="focusSear">商品,店铺<i class="search-icon"></i></p>            
</header>            
<section>            
  <div id="content">            
  <div id="slideBox" class="slideBox">            
    <div class="Move">            
      <ul class="pic-wrap">            
        <?php      
           //首页轮播图            
           $Img_query =mysql_query("select * from img where type ='移动端-首页轮播图' order by UpdateTime desc limit 3");             
           while($Img_result =mysql_fetch_array($Img_query)){             
               echo " <li><a class=\"pic\" href=\"{$Img_result['url']}\"><img src=\"{$root}{$Img_result['imgsrc']}\"/></a></li>";               
           }             
        ?>            
      </ul>            
    </div>            
    <div class="contID">            
      <div class="slide-auto">            
        <ul class="contid-wrap">            
        </ul>            
      </div>            
    </div>            
  </div>            
</section>            
<section>            
  <div class="menu_nav block">            
    <div class="inner_wrap">            
      <ul class="nav_wrap">            
        <li> <a href="<?php echo "{$mroot}mList.php?TypeOne=d2s5d";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(<?php echo img('UCp24278644Zz')?>) no-repeat scroll 50%/49px"></i></span>            
          <p>拍婚照</p>            
          </a> </li>            
        <li> <a href="<?php echo "{$mroot}mList.php?TypeOne=j014e";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(<?php echo img('YpO24278633Sn')?>) no-repeat scroll 50%/49px"></i></span>            
          <p>订婚戒</p>            
          </a> </li>            
        <li> <a href="<?php echo "{$mroot}mList.php?TypeOne=b01q";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(<?php echo img('Uce24278636cU')?>) no-repeat scroll 50%/45px"></i></span>            
          <p>订婚宴</p>            
          </a> </li>            
        <li> <a href="<?php echo "{$mroot}mList.php?TypeOne=k01w";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(<?php echo img('Rmy24278638Io')?>) no-repeat scroll 50%/45px"></i></span>            
          <p>选婚纱</p>            
          </a> </li>            
        <li> <a href="<?php echo "{$mroot}mIndividualBus.php";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(http://www.17lehun.com/img/WebsiteImg/cBM30479655vr.jpg) no-repeat scroll 50%/49px"></i></span>            
          <p>婚礼人</p>            
          </a> </li>              
        <li class="nath-bottom"> <a href="<?php echo "{$mroot}mList.php?TypeOne=nh014t";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(<?php echo img('ihF24278630vg')?>) no-repeat scroll 50%/45px"></i></span>            
          <p>找婚庆</p>            
          </a> </li>            
        <li class="nath-bottom"> <a href="<?php echo "{$mroot}mList.php?TypeOne=g01qp";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(<?php echo img('tRw24278641ve')?>) no-repeat scroll 50%/49px"></i></span>            
          <p>淘婚品</p>            
          </a> </li>            
        <li class="nath-bottom"> <a href="<?php echo "{$mroot}mComment.php";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(<?php echo img('Fqc24278646fX')?>) no-repeat scroll 0px -2px/45px;"></i></span>            
          <p>点评</p>            
          </a> </li>            
        <li class="nath-bottom"> <a href="<?php echo "{$mroot}mCouponsList.php";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(<?php echo img('YoF24278650YF')?>) no-repeat scroll 50%/49px"></i></span>            
          <p>现金券</p>            
          </a> </li>            
        <li class="nath-bottom"> <a href="<?php echo "{$mroot}mMall.php";?>"><span style="background:#FFF"><i class="menuicon" style="background:url(http://www.17lehun.com/img/WebsiteImg/uhs30479650IV.jpg) no-repeat scroll 50%/49px"></i></span>            
          <p>积分</p>            
          </a> </li>  
      </ul>          
        
    </div>            
  </div>            
</section>            
<section>            
  <div class="block_table block">            
  <div class="inner-head">            
    <h4>本周推荐</h4>            
  </div>            
  <div class="reco-container">            
    <ul class="reco-wrap">            
      <li data-width='50%'> <a href="<?php echo imgurl('dqm24279085GJ');?>">            
        <div class="content-box">            
          <div class="img-box"> <img src="<?php echo img('dqm24279085GJ')?>"> </div>            
        </div>            
        </a> </li>            
      <li data-width='50%'> <a href="<?php echo imgurl('fIK24279094YR');?>">            
        <div class="content-box">            
          <div class="img-box"> <img src="<?php echo img('fIK24279094YR')?>"> </div>            
        </div>            
        </a> </li>            
      <li data-width='33.3'> <a href="<?php echo imgurl('Lkh24279104OC');?>">            
        <div class="content-box">            
          <div class="img-box"> <img src="<?php echo img('Lkh24279104OC')?>"> </div>            
        </div>            
        </a> </li>            
      <li data-width='33.3'> <a href="<?php echo imgurl('hTt24279106aC');?>">            
        <div class="content-box">            
          <div class="img-box"> <img src="<?php echo img('hTt24279106aC')?>"> </div>            
        </div>            
        </a> </li>            
      <li data-width='33.3'> <a href="<?php echo imgurl('ISl24279110BI');?>">            
        <div class="content-box">            
          <div class="img-box"> <img src="<?php echo img('ISl24279110BI')?>"> </div>            
        </div>            
        </a> </li>            
    </ul>            
  </div>            
</section>            
<section>            
  <div class="integral-table block">            
    <div class="inner-head">            
      <h4>特惠产品</h4>            
      <span><a href="<?php echo "{$root}m/mGoodsList.php";?>">更多<i class="more"></i></a></span> </div>            
    <ul class="integral-wrap">            
      <?php              
        $Goods_query =mysql_query("select * from goods where Auditing ='已通过' order by UpdateTime desc ");             
        $i=1;             
        while($Goods_result =mysql_fetch_array($Goods_query)){             
            $SellerResult = query("seller"," seid = '$Goods_result[sellerid]' and prove = '已通过' and authentication = '已认证' ");          
            if($SellerResult['seid'] != ""){          
                if($i==1 or $i==2){             
                    echo "<li><a href=\"{$mroot}mGoodsMx.php?seller=$SellerResult[seid]&goods=$Goods_result[id]\" class=\"integral-pic\"><img src=\"".ListImg($Goods_result['ico'])."\"><span class=\"opacity-val\">$Goods_result[name]</span></a></li>";             
                }else if($i==3 or $i==4){             
                    echo "<li class=\"last\"><a href=\"{$mroot}mGoodsMx.php?seller=$SellerResult[seid]&goods=$Goods_result[id]\" class=\"integral-pic\"><img src=\"".ListImg($Goods_result['ico'])."\"><span class=\"opacity-val\">$Goods_result[name]</span></a></li>";             
                }else if($i >= 5){          
                    break;          
                }          
                $i++;          
            }             
        }             
      ?>            
    </ul>            
  </div>            
</section>            
<section>            
  <div class="caash-item block">            
    <div class="inner-head">            
      <h4>现金券&nbsp;<ins>共<?php echo mysql_num_rows(mysql_query("select * from khcoupon "));?>人领取</ins></h4>           
      <span><a href="<?php echo "{$root}m/mCouponsList.php";?>">更多<i class="more"></i></a></span></div>            
    <ul class="cash-list-wrap">            
      <?php                
         $Conpon_query =mysql_query("select * from coupon where 
		 coupontargetid in ( select seid from seller where prove = '已通过' and authentication = '已认证' and CashCoupon = '开通' ) group by coupontargetid order by coupondate desc limit 0,10");               
         if(mysql_num_rows($Conpon_query) ==0){               
             echo "<li><p class='null-msg'>还没有现金券</p></li>";                
         }else{               
             while($Conpon_result =mysql_fetch_array($Conpon_query)){               
                 $Seller_result =query("seller"," seid ='$Conpon_result[coupontargetid]' ");               
                 echo "<li>                
                        <a href=\"{$mroot}mStore.php?seller=$Seller_result[seid]\" class=\"caash-link\">                
                            <img src=\"".ListImg($Seller_result['logo'])."\">                
                              <dl>                
                                <dt>$Seller_result[name]现金券</dt>                
                                <dd class=\"price\">￥$Conpon_result[couponprice]&nbsp;</dd>                
                                <dd class=\"cont\">剩余<em>".($Conpon_result['coupontotal']-$Conpon_result['couponcount'])."</em>份&nbsp;&nbsp;已领<em>$Conpon_result[couponcount]</em>份</dd>             
                              </dl>                
                        </a>                
                      </li>";               
             }               
         }              
      ?>            
    </ul>            
  </div>            
  </div>            
</section>      
<section>      
  <div class="pop-block" style="display:none">      
    <div class="pop-search">      
      <aside class="pop-head">       
          <div class="search-line sear-def">      
            <input type="button" value="" id="popBtn">      
            <input type="search" value="" placeholder="店铺" id="popSear">      
          </div>      
          <a href="javascript:;" id="return">取消</a>      
      </aside>      
      <div class="pop-container">      
        <p class="pop-sline">热门搜索      
        </p>      
        <ul class="pop-wrap">      
          <?php      
          $TypeOneQuery = mysql_query("select * from TypeOne order by list ");     
          while($TypeOneResult = mysql_fetch_array($TypeOneQuery)){     
              echo "<li><a href=\"{$root}m/mList.php?TypeOne={$TypeOneResult['id']}\">{$TypeOneResult['name']}</a></li>";     
          }     
          ?>     
        </ul>      
      </div>      
    </div>      
  </div>      
</section>    
<!--分享弹出层开始-->
<div id="shareDibian" style="width:100%; height:100%; position:fixed; top:0px; left:0px; z-index:8000; background-color:#000000;-moz-opacity: 0.9;opacity:.90;filter: alpha(opacity=90); display:none;">
    <img style="width:80%; position:absolute; right:10%; bottom:10%;" src="<?php ro();?>img/images/share.png">
</div>
<!--分享弹出层结束-->            
<?php             
if($_SESSION['khid'] !="" and isset($_GET['DeleteUser']) and $_GET['DeleteUser'] =="user"){             
    unset($_SESSION["khid"]);             
    echo "<script>alert('你已成功退出');</script>";             
}  
if(isset($_SESSION['warn']) and $_SESSION['warn'] != ""){  
    echo "<script>alert('{$_SESSION['warn']}');</script>";  
    unset($_SESSION["warn"]);  
}
echo mPageFooter();             
?>            
<script type="text/javascript">
$(document).ready(function(){
  <?php if($_GET['suopiao'] == "yes"){echo "$('#shareDibian').show();";}?>
  $("#shareDibian").click(function(){$(this).hide();});
});
TouchSlide({              
  slideCell:"#slideBox",             
  titCell:".slide-auto ul",             
  mainCell:".Move ul",              
  effect:"leftLoop",              
  autoPage:true,             
  autoPlay:true              
});      
$(function(){      
    var popSlides=$('.pop-block');      
    $('#popSear').focus(      
        function(){      
            $(this).parent().addClass('searHover');      
        }      
    ).blur(      
        function(){      
            $(this).parent().removeClass('searHover');      
        }      
    );      
    popSlides.css(      
        {      
            "transition-duration":"350",      
            "transition-property":"all",      
            "transition-timing-function":"linear"      
        }      
    );      
    $('#focusSear').click(      
        function(){      
            popSlides.slideDown(450);          
        }      
    )      
    $('#return').click(      
        function(){      
            popSlides.slideUp(450);          
        }      
    );       
    $('#popBtn').click(function(){     
        var store = $('#popSear').val();     
        if(store ==""){     
            alert("请输入店铺名称");     
            $('#popSear').focus();     
        }else{     
            window.location.href = "mStore.php?store="+store;     
        }     
    });      
})              
</script>            
</body>            
</html>