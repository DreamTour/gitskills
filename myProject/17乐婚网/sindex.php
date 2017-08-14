<?php 
include "library/function.php";
include "FoFunction.php";           
$ThisUrl = $root."sindex.php?TypeOne=".$_GET['TypeOne'];
echo head("pc");
$TypeOne = query("TypeOne"," id = '$_GET[TypeOne]' ");        
//当商家列表页分类改变时，清空模糊查询        
if($_SESSION['SearchStore']['SellerType'] != $_GET['TypeOne']){        
    unset($_SESSION['SearchStore']);       
}   
if($_GET['TypeOne'] == "all" ){ 
    $sql=$_SESSION['SearchStore']['Sql']; 
}else{ 
    $sql="select * from seller where TypeOneId = '$_GET[TypeOne]' and prove = '已通过' "; 
} 
$num = mysql_num_rows(mysql_query($sql));        
paging($sql," order by authentication='已认证' desc,PageView desc,time",3);        
echo insertBackUrl();        
?>
<!DOCTYPE html>
<html lang='zh'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
<meta name='renderer' content='webkit'>
<title>重庆婚博会官方指定平台-重庆新人联盟，重庆结婚新人首选一站式新婚消费商城，集婚纱摄影、婚庆珠宝、婚礼用品、婚纱礼服、宴会酒店于一体的大型综合性结婚平台。</title>
<link rel='stylesheet' type='text/css' href='http://www.17lehun.com/library/pc.css'>
<link rel='stylesheet' type='text/css' href='library/p.css'>
<script type='text/javascript' src='http://www.yumukeji.com/library/jquery-1.11.2.min.js'></script>
<script type='text/javascript' charset='UTF-8' src='http://www.17lehun.com/library/pc.js'></script>
<!--百度统计开始-->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?f65f5ed5464eb4722f8a6e8bb680818e";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<!--百度统计结束-->
</head>
<body>
<!--顶部引导信息开始-->
<div class="MenuTop">
  <div class="column center"> <span class="FloatLeft">关注我们</span> 新人联盟结婚商城--重庆婚博会官方指定平台 <span class="FloatRight"> <a href='<?php echo "{$root}user/usRegister.php";?>'>注册</a>&nbsp;&nbsp;<span class='MenuVerticalLine'>|</span>&nbsp;&nbsp; <a href='<?php echo "{$root}user/uslogin.php";?>'>登录</a>&nbsp;&nbsp;<span class='MenuVerticalLine'>|</span>&nbsp;&nbsp; <a href="<?php echo "{$root}seller/selogin.php";?>">商家入驻</a></span> </div>
</div>
<!--顶部引导信息结束--> 
<!--logo和搜索行开始-->
<div class="column padding" style="width:1180px;"> <a href="<?php echo "{$root}";?>"><img class="logo" src="<?php echo img("e654s3");?>"></a> <a target="_blank" href="<?php echo "{$root}suopiao.php"?>"><img class="AdvertisementTop" src="<?php echo img("d87s57124a");?>"></a>
  <div class="HeaderSearchDiv">
    <div class="HeaderSearchKuang clear">
      <form name="SearchForm" id="SearchForm" action="<?php echo "{$root}library/PcPost.php";?>" method="post">
        <input name="SearchStoreBrandList" type="text" id="KeyWords" class="HeaderSearchText" placeholder="0元体验，送婚房">
        <input name="SellerType" type="hidden" value="all">
        <img class="HeaderSearchImg" id="SearchImg" src="<?php echo "{$root}img/images/search.jpg";?>" />
      </form>
    </div>
    <p class="smallword" style="padding-bottom:10px;"> <a href='<?php echo "{$root}m/mindex.php";?>
'>掌上筹婚</a>&nbsp;&nbsp;<a href='<?php echo "{$root}forum/coupons.php";?>
'>下单拿钱</a>&nbsp;&nbsp;<a href='<?php echo "{$root}forum/forum.php?TypeOne=sbo25033883dr&amp;TypeTwo=jNm25556438yj";?>
'>0元体验</a>&nbsp;&nbsp;<a href='<?php echo "{$root}forum/forum.php?bbs.php?id=XZo32319590PZ&amp;TypeTwoId=kGj25033900QG";?>'>霸王餐 </a>&nbsp;&nbsp; </p>
  </div>
  <div class="clear"></div>
</div>
<!--logo和搜索结束--> 
<!--主导航-->
<div class="main_nav_box">
  <div class="main_nav of wid">
    <div class="nav_all bg_col2 fl col">全部分类</div>
    <ul class="main_nav_top of fl">
      <li class="fl"><a href="<?php echo "{$GLOBALS['root']}index.php"?>">首页</a></li>
      <li class="fl"><a href="<?php echo "{$GLOBALS['root']}forum/coupons.php";?>">现金券</a></li>
      <li class="fl"><a href="<?php echo "{$GLOBALS['root']}forum/forum.php";?>">社区论坛</a></li>
      <li class="fl"><a href="<?php echo "{$GLOBALS['root']}forum/showReview.php";?>">用户点评</a></li>
      <li class="fl"><a href="<?php echo "{$GLOBALS['root']}Mall.php"?>">积分商城</a></li>
    </ul>
  </div>
</div>
<!--banner部分-->
<div class="banner_all">
  <div class="banner_side"> 
    <!--侧导航-->
    <ul class="side_nav bg_col1">
      <li class="side_nav_items"><a href="<?php echo "{$root}goods.php?TypeOne=d2s5d";?>" class="col">拍婚照</a><a href="javascript:;" class="fz14 col">本地拍摄</a><a href="javascript:;" class="fz14 col">旅游拍摄</a></li>
      <li class="side_nav_items"><a href="<?php echo "{$root}goods.php?TypeOne=j014e";?>" class="col">订婚戒</a><a href="javascript:;" class="fz14 col">结婚对戒</a><a href="javascript:;" class="fz14 col">结婚首饰</a></li>
      <li class="side_nav_items"><a href="<?php echo "{$root}goods.php?TypeOne=b01q";?>" class="col">定婚宴</a><a href="javascript:;" class="fz14 col">星级酒店</a><a href="javascript:;" class="fz14 col">特色餐厅</a></li>
      <li class="side_nav_items"><a href="<?php echo "{$root}goods.php?TypeOne=k01w";?>" class="col">选婚纱</a><a href="javascript:;" class="fz14 col">女式婚纱</a><a href="javascript:;" class="fz14 col">男士礼服</a></li>
      <li class="side_nav_items"><a href="<?php echo "{$root}goods.php?TypeOne=nh014t";?>" class="col">找婚庆</a><a href="javascript:;" class="fz14 col">本地婚礼</a><a href="javascript:;" class="fz14 col">海外婚礼</a></li>
      <li class="side_nav_items"><a href="<?php echo "{$root}goods.php?TypeOne=g01qp";?>" class="col">选婚品</a><a href="javascript:;" class="fz14 col">喜糖蛋糕</a><a href="javascript:;" class="fz14 col">床上用品</a></li>
    </ul>
    <!--广告-->
    <div class="banner_ad"> <a href="javascript:;"><img src="<?php echo img("IPC51486271Rx");?>"></a> </div>
  </div>
  <!--banner--> 
  <div class="image-slider" id="image-slider">
  	<ul id="image-slider-cell">
    	<li><img src="<?php echo img("Fqo51486122BU");?>"></li>
        <li><img src="<?php echo img("eOH51486200la");?>"></li>
        <li><img src="<?php echo img("iqS51486175Nc");?>"></li>
    </ul>
    <ul id="image-slider-sort">
    
    </ul>
  </div>  
</div>
<!--搜索条件-->
<div class="search_cri_box wid">
  <div class="search_cri of"> <i class="index_icon index_icon1 fl"></i>
    <div class="search_cri_items fl hy1">
      <div class="cri_items_head of">
        <h3 class="fl">按类型</h3>
        <a href="javascript:;" class="fz12 fr search_more">更多>></a> </div>
      <div class="cri_items_body"> <a href="javascript:;" class="fz12">星级酒店</a> <a href="javascript:;" class="fz12">特色餐厅</a> </div>
    </div>
    <div class="search_cri_items fl hy1">
      <div class="cri_items_head of">
        <h3 class="fl">按价格</h3>
        <a href="javascript:;" class="fz12 fr search_more">更多>></a> </div>
      <div class="cri_items_body"> <a href="javascript:;" class="fz12">2000元以下</a> <a href="javascript:;" class="fz12">2000-3000</a> </div>
      <div class="cri_items_body"> <a href="javascript:;" class="fz12">3000-4000</a> <a href="javascript:;" class="fz12">4000元以上</a> </div>
    </div>
    <div class="search_cri_items fl hy1">
      <div class="cri_items_head of">
        <h3 class="fl">按桌数</h3>
        <a href="javascript:;" class="fz12 fr search_more">更多>></a> </div>
      <div class="cri_items_body"> <a href="javascript:;" class="fz12">10桌以下</a> <a href="javascript:;" class="fz12">10-20桌</a> </div>
      <div class="cri_items_body"> <a href="javascript:;" class="fz12">20-30桌</a> <a href="javascript:;" class="fz12">30桌以上</a> </div>
    </div>
    <div class="search_cri_items fl hy2">
      <div class="cri_items_head of">
        <h3 class="fl">按区域</h3>
        <a href="javascript:;" class="fz12 fr search_more">更多>></a> </div>
      <div class="cri_items_body"> <a href="javascript:;" class="fz12">渝北区</a> <a href="javascript:;" class="fz12">渝中区</a> <a href="javascript:;" class="fz12">沙坪坝区</a> </div>
      <div class="cri_items_body"> <a href="javascript:;" class="fz12">江北区</a> <a href="javascript:;" class="fz12">南岸区</a> <a href="javascript:;" class="fz12">九龙坡区</a> </div>
    </div>
    <div class="search_other fl">
      <div class="search_other_top"> <i class="index_icon index_icon2"></i><a href="<?php echo "{$root}goods.php?TypeOne=d2s5d";?>">婚纱摄影</a> <i class="index_icon index_icon3"></i><a href="<?php echo "{$root}goods.php?TypeOne=nh014t";?>">婚礼策划</a> </div>
      <i class="index_icon index_icon4"></i><a href="<?php echo "{$root}goods.php?TypeOne=d2s5d";?>">蜜月旅行</a> </div>
  </div>
</div>
<style>.center_problem_bottom li{width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}</style>
<!--1F婚宴酒店-->
<div class="index_content_hotel wid">
  <div class="index_hotel_header of"> <i class="index_icon index_icon_floor index_icon_floor1 fl"></i>
    <h1 class="fl col2">婚宴酒店</h1>
    <a href="<?php echo "{$root}StoreList.php?TypeOne=b01q";?>" class="fr">更多>></a> </div>
  <div class="index_hotel_body of" id="hotelTabWrap">
    <div class="index_hotel_ad fl"> <a href="javascript:;"><img src="<?php echo img("LFL51486780eo");?>"></a> </div>
    <div class="hotel_content fl">
      <div class="hotel_header of">
        <ul>
          <li class="fl hotel_header_list hotel_current">
            <p class="bd-top1"></p>
            <span>星级酒店</span></li>
          <li class="fl hotel_header_list">
            <p class="bd-top1"></p>
            <span>特色餐厅</span></li>
          <li class="fl">
            <p class="bd-top2"></p>
          </li>
        </ul>
      </div>
      <div class="hotel_body of hotelTab">
              <?php   
		$sql = mysql_query("select * from seller where TypeOneId = 'b01q' and prove = '已通过' limit 6"); 
		$num = mysql_num_rows($sql);        
        if($num > 0){        
            while($seller = mysql_fetch_array($sql)){
			$avgscore = mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid = '$seller[seid]' and status = '已通过' "));
            $score =(double)substr($avgscore[0],0,3);              
                echo "        
				<dl class='hotel_body_content fl'>
				  <dt><a href='{$root}store.php?seller={$seller['seid']}'><img style='width:186px;height:156px;' src='".ListImg($seller['logo'])."'></a></dt>
				  <dd><a href='javascript:;' class='fz14'>{$seller['Brand']}</a><span class='col3 fz14'>{$score}</span></dd>
				</dl>
                ";        
            }        
        }else{        
            echo "一个商家都没有";        
        }        
        ?>        

      </div>
         <div class="hotel_body of hotelTab">
         	<?php
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'b01q' and prove = '已通过' and authentication = '已认证' ) order by time desc limit 6 ");
			while($Goods = mysql_fetch_array($GoodsSql)){
				echo "
				<dl class='hotel_body_content fl'>
				  <dt><a href='{$root}goodsmx.php?TypeOne=b01q&goods={$Goods['id']}'><img style='width:186px;height:156px;' src='".ListImg($Goods['ico'])."'></a></dt>
				  <dd><a href='javascript:;' class='fz14'>".zishu($Goods['name'],20)."</a><span class='col3 fz14'>4.2</span></dd>
				</dl>
				";
			}
			?>
         </div>
    </div>
    <div class="hot_hotel fl">
      <div class="hot_hotel_title bg_col1 col"> <i class="index_icon index_icon_floor2"></i> <span>热门婚宴酒店</span> </div>
      <ul class="hot_hotel_content">
        <?php   
		$sql = mysql_query("select * from seller where TypeOneId = 'b01q' and prove = '已通过' limit 10"); 
		$num = mysql_num_rows($sql);        
        if($num > 0){  
			$n = '1';
            while($seller = mysql_fetch_array($sql)){
			$avgscore = mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid = '$seller[seid]' and status = '已通过' "));
            $score =(double)substr($avgscore[0],0,3);              
                echo "        
				<li class='hot_hotel_items'>
					<span class='bg_col1 col fz12'>".sprintf("%02d",$n)."</span> 
					<a href='{$root}store.php?seller={$seller['seid']}'>{$seller['Brand']}</a>
				</li>
                ";  
				$n++;
            }        
        }else{        
            echo "一个商家都没有";        
        }        
        ?>        
      </ul>
    </div>
  </div>
</div>
<!--2F婚纱摄影-->
<div class="index_content_hotel wid">
  <div class="index_hotel_header of"> <i class="index_icon index_icon_floor index_icon_floor2 fl"></i>
    <h1 class="fl col2">婚纱摄影</h1>
    <a href="<?php echo "{$root}StoreList.php?TypeOne=d2s5d";?>" class="fr">更多>></a> </div>
  <div class="index_hotel_body of">
    <div class="index_hotel_ad fl"> <a href="javascript:;"><img src="<?php echo img("Wlz51487481OV");?>"></a> </div>
    <div class="hotel_content fl">
      <div class="hotel_header hotel_header1"> </div>
      <div class="hotel_body of">
      			<?php
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'd2s5d' and prove = '已通过' and authentication = '已认证' ) order by time desc limit 6 ");
			while($Goods = mysql_fetch_array($GoodsSql)){
				echo "
				<dl class='hotel_body_content fl'>
				  <dt><a href='{$root}goodsmx.php?TypeOne=d2s5d&goods={$Goods['id']}'><img style='width:186px;height:156px;' src='".ListImg($Goods['ico'])."'></a></dt>
				  <dd><a href='javascript:;' class='fz14'>".zishu($Goods['name'],20)."</a><span class='col3 fz14'>4.2</span></dd>
				</dl>
				";
			}
			?>

      </div>
    </div>
    <div class="hot_hotel fl">
      <div class="hot_hotel_title bg_col1 col"> <i class="index_icon index_icon_floor2"></i> <span>热门婚纱摄影</span> </div>
      <ul class="hot_hotel_content">
                           <?php
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'd2s5d' and 											prove = '已通过' and authentication = '已认证' ) order by time desc limit 10 ");
			$n = '1';
			if(strlen($n) < 2) {
				$n = "0".$n;	
			}
			while($Goods = mysql_fetch_array($GoodsSql)){
				echo "
       		    <li class='hot_hotel_items'> <span class='bg_col1 col fz12'>{$n}</span> 
					<a href='{$root}goodsmx.php?TypeOne=d2s5d&goods={$Goods['id']}'>".zishu($Goods['name'],20)."</a>
				</li>
				";
				$n++;
				if(strlen($n) < 2) {
					$n = "0".$n;	
				}
			}
			?> 

     </ul>
    </div>
  </div>
</div>
<!--3F婚庆服务-->
<div class="index_content_hotel wid">
  <div class="index_hotel_header of"> <i class="index_icon index_icon_floor index_icon_floor3 fl"></i>
    <h1 class="fl col2">婚庆服务</h1>
    <a href="<?php echo "{$root}StoreList.php?TypeOne=nh014t";?>" class="fr">更多>></a> </div>
  <div class="index_hotel_body of">
    <div class="index_hotel_ad fl"> <a href="javascript:;"><img src="<?php echo img("nId51487567bH");?>"></a> </div>
    <div class="hotel_content fl">
      <div class="hotel_header hotel_header1"> </div>
      <div class="hotel_body of">
            <?php
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'nh014t' and 											prove = '已通过' and authentication = '已认证' ) order by time desc limit 6 ");
			while($Goods = mysql_fetch_array($GoodsSql)){
				echo "
				<dl class='hotel_body_content fl'>
				  <dt><a href='{$root}goodsmx.php?TypeOne=nh014t&goods={$Goods['id']}'><img style='width:186px;height:156px;' src='".ListImg($Goods['ico'])."'></a></dt>
				  <dd><a href='javascript:;' class='fz14'>".zishu($Goods['name'],20)."</a><span class='col3 fz14'>4.2</span></dd>
				</dl>
				";
			}
			?>

     </div>
    </div>
    <div class="hot_hotel fl">
      <div class="hot_hotel_title bg_col1 col"> <i class="index_icon index_icon_floor2"></i> <span>热门婚庆服务</span> </div>
      <ul class="hot_hotel_content">
                     <?php
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'nh014t' and 											prove = '已通过' and authentication = '已认证' ) order by time desc limit 10 ");
			$n = 1;
			while($Goods = mysql_fetch_array($GoodsSql)){
				echo "
       		    <li class='hot_hotel_items'>
					<span class='bg_col1 col fz12'>".sprintf("%02d",$n)."</span>
					<a href='{$root}goodsmx.php?TypeOne=nh014t&goods={$Goods['id']}'>".zishu($Goods['name'],20)."</a>
				</li>
				";
				$n++;
			}
			?> 
     </ul>
    </div>
  </div>
</div>
<style>.special_items_text div{white-space:nowrap;text-overflow:ellipsis;width:158px;overflow:hidden;}</style>
<!--4F特色分类-->
<div class="index_content_special wid">
  <div class="index_hotel_header of"> <i class="index_icon index_icon_floor index_icon_floor4 fl"></i>
    <h1 class="fl col2">特色分类</h1>
  </div>
  <ul class="special_content of">
    <li class="fl special_box">
    <a href="<?php echo "{$root}goods.php?TypeOne=j014e";?>" class="fr">更多>></a>
      <dl class="special_content_items">
        <dt><a href="javascript:;"><img src="<?php echo img("WeM51487591dc");?>"></a></dt>
        <dd class="special_text_box">
        	<?php 
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'j014e' and 											prove = '已通过' and authentication = '已认证' ) order by time desc limit 3 ");
			while($Goods = mysql_fetch_array($GoodsSql)){
				echo "
			  <dl class='special_item of'>
				<dt><a href='{$root}goodsmx.php?TypeOne=j014e&goods={$Goods['id']}' class='special_items_img fl'><img style='width:80px;height:60px;' src='".ListImg($Goods['ico'])."'></a></dt>
				<dd class='special_items_text fl'>
				  <div><a href='{$root}goodsmx.php?TypeOne=j014e&goods={$Goods['id']}' class='fz16'>".zishu($Goods['name'],20)."</a></div>
				  <div class='fz14 col3'>￥".zishu($Goods['price'],20)."</div>
				</dd>
			  </dl>	
				";
			}
			?>
        </dd>
      </dl>
    </li>
    <li class="fl special_box">
    <a href="<?php echo "{$root}goods.php?TypeOne=g01qp";?>" class="fr">更多>></a>
      <dl class="special_content_items">
        <dt><a href="javascript:;"><img src="<?php echo img("EDu51489530EQ");?>"></a></dt>
        <dd class="special_text_box">
        	        	<?php
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'g01qp' and 											prove = '已通过' and authentication = '已认证' ) order by time desc limit 3 ");
			while($Goods = mysql_fetch_array($GoodsSql)){
				echo "
			  <dl class='special_item of'>
				<dt><a href='{$root}goodsmx.php?TypeOne=g01qp&goods={$Goods['id']}' class='special_items_img fl'><img style='width:80px;height:60px;' src='".ListImg($Goods['ico'])."'></a></dt>
				<dd class='special_items_text fl'>
				  <div><a href='{$root}goodsmx.php?TypeOne=g01qp&goods={$Goods['id']}' class='fz16'>".zishu($Goods['name'],20)."</a></div>
				  <div class='fz14 col3'>￥".zishu($Goods['price'],20)."</div>
				</dd>
			  </dl>	
				";
			}
			?>
        </dd>
      </dl>
    </li>
    <li class="fl special_box">
    <a href="<?php echo "{$root}goods.php?TypeOne=k01w";?>" class="fr">更多>></a>
      <dl class="special_content_items">
        <dt><a href="javascript:;"><img src="<?php echo img("nsr51489604eg");?>"></a></dt>
        <dd class="special_text_box">
			        	<?php
			$GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in ( select seid from seller where TypeOneId = 'k01w' and 											prove = '已通过' and authentication = '已认证' ) order by time desc limit 3 ");
			while($Goods = mysql_fetch_array($GoodsSql)){
				echo "
			  <dl class='special_item of'>
				<dt><a href='{$root}goodsmx.php?TypeOne=k01w&goods={$Goods['id']}' class='special_items_img fl'><img style='width:80px;height:60px;' src='".ListImg($Goods['ico'])."'></a></dt>
				<dd class='special_items_text fl'>
				  <div><a href='{$root}goodsmx.php?TypeOne=k01w&goods={$Goods['id']}' class='fz16'>".zishu($Goods['name'],20)."</a></div>
				  <div class='fz14 col3'>￥".zishu($Goods['price'],20)."</div>
				</dd>
			  </dl>	
				";
			}
			?>
        </dd>
      </dl>
    </li>
    <li class="fl special_box">
    <a href="<?php echo "{$root}IndividualBus.php";?>" class="fr">更多>></a>
      <dl class="special_content_items">
        <dt><a href="javascript:;"><img src="<?php echo img("ohn51489631DJ");?>"></a></dt>
        <dd class="special_text_box">
			  <?php 
	$query = mysql_query("select * from seller where type = '个人商户' and prove = '已通过' limit 3");		  
	 while($PersonSeller=mysql_fetch_array($query)){
		 if($PersonSeller['authentication'] == "已认证"){     
			 $authentication = "<img class='IDCard' src='{$root}img/images/IDCard.png'>";
		 }else{
		     $authentication = "";
		 }    
		 $url = root."store.php?seller=".$PersonSeller['seid'];
		 echo "
			   <dl class='special_item of'>
				<dt><a href='{$url}' class='special_items_img fl'><img style='width:80px;height:60px;' src='".ListImg($PersonSeller['logo'])."'></a></dt>
				<dd class='special_items_text fl'>
				  <div>
				  	<a href='{$url}' class='fz16'>
                     {$PersonSeller['Brand']}			  	
					</a>{$authentication}
				  </div>
				  <div class='fz14'>{$PersonSeller['Petype']}</div>
				</dd>
			  </dl>		
		"; 
	 }
  ?>
        </dd>
      </dl>
    </li>
  </ul>
</div>
<!--5F筹婚攻略-->
<div class="wedding_raiders wid">
  <div class="index_hotel_header of"> <i class="index_icon index_icon_floor index_icon_floor5 fl"></i>
    <h1 class="fl col2">筹婚攻略</h1>
    <a href="<?php echo "{$root}forum/forum.php";?>" class="fr">更多>></a> </div>
  <ul class="wedding_content of">
    <li class="common_problems fl">
      <h5 class="common_problems_head"><a href="javascript:;" class="fz16 col2">常见问题</a></h5>
      <div class="common_problems_content">
      		<?php
			$titleSql = mysql_query("select * from ForumTypeTwo ");
			while($title = mysql_fetch_assoc($titleSql)){
         	echo " <a href='{$root}forum/forum.php?TypeOne=NUh25033822tE&TypeTwo=$title[id]'>{$title[name]}</a>"; 
				}
			;?>     
       </div>
    </li>
    <li class="content_problem fl of">
      <ul class="center_problem fl">
        	<?php    
            $i=1;   
            $ForumTypeTwoSql = mysql_query("select * from ForumTypeTwo where ForumTypeOneId = 'oCm24960404hD' ");   
            while($ForumTypeTwo = mysql_fetch_array($ForumTypeTwoSql)){   
                $ForumTypeThreeSql = mysql_query("select * from ForumTypeThree where ForumTypeTwoId ='$ForumTypeTwo[id]' ");   
                while($ForumTypeThree = mysql_fetch_array($ForumTypeThreeSql)){   
                    $ForumpostSql = mysql_query("select * from forumposts where forumtype = '$ForumTypeThree[id]' and status = '已发布' order by forumdate desc");   
                    while($Forumpost =mysql_fetch_array($ForumpostSql)){ 
						$word = mysql_fetch_assoc(mysql_query("select * from article where TargetId = '$Forumpost[forumid]' "));
                        if($i <= 1){   
                            echo "  
		<li class='center_problem_top'>
          <h5><a href='{$root}bbs.php?id={$Forumpost['forumid']}&TypeTwoId={$ForumTypeTwo['id']}' class='fz16 col2'>$Forumpost[forumtitle]</a></h5>
          <p class='fz14 of'><a href='{$root}bbs.php?id={$Forumpost['forumid']}&TypeTwoId={$ForumTypeTwo['id']}'>{$word['word']}</a></p>
        </li>
                                 ";   
                        }   
                        $i++;   
                    }   
                }   
            }   
            ?>    
        <li class="center_problem_bottom of">
          <ul class="problem_left fl">
			<?php    
            $i=1;   
            $ForumTypeTwoSql = mysql_query("select * from ForumTypeTwo where ForumTypeOneId = 'cbJ24960387jB' ");   
            while($ForumTypeTwo = mysql_fetch_array($ForumTypeTwoSql)){   
                $ForumTypeThreeSql = mysql_query("select * from ForumTypeThree where ForumTypeTwoId ='$ForumTypeTwo[id]' ");   
                while($ForumTypeThree = mysql_fetch_array($ForumTypeThreeSql)){   
                    $ForumpostSql = mysql_query("select * from forumposts where forumtype = '$ForumTypeThree[id]' and status = '已发布' order by forumdate desc");   
                    while($Forumpost =mysql_fetch_array($ForumpostSql)){   
                        if($i <= 5){   
                            echo "   
                                <li><a href='{$root}bbs.php?id={$Forumpost['forumid']}&TypeTwoId={$ForumTypeTwo['id']}'>$Forumpost[forumtitle]</a></li>
                                 ";   
                        }   
                        $i++;   
                    }   
                }   
            }   
            ?>    
          </ul>
          <ul class="problem_right fl">
			<?php    
            $i=1;   
            $ForumTypeTwoSql = mysql_query("select * from ForumTypeTwo where ForumTypeOneId = 'oCm24960404hD' ");   
            while($ForumTypeTwo = mysql_fetch_array($ForumTypeTwoSql)){   
                $ForumTypeThreeSql = mysql_query("select * from ForumTypeThree where ForumTypeTwoId ='$ForumTypeTwo[id]' ");   
                while($ForumTypeThree = mysql_fetch_array($ForumTypeThreeSql)){   
                    $ForumpostSql = mysql_query("select * from forumposts where forumtype = '$ForumTypeThree[id]' and status = '已发布' order by forumdate desc");   
                    while($Forumpost =mysql_fetch_array($ForumpostSql)){   
                        if($i <= 5){   
                            echo "   
                                <li><a href='{$root}bbs.php?id={$Forumpost['forumid']}&TypeTwoId={$ForumTypeTwo['id']}'>$Forumpost[forumtitle]</a></li>
                                 ";   
                        }   
                        $i++;   
                    }   
                }   
            }   
            ?>    
          </ul>
        </li>
      </ul>
      <div class="problem_ad fr"> <a href="javascript:;"><img src="<?php echo img("UUb51487898qf");?>"></a> <a href="javascript:;"><img src="<?php echo img("Epf51487962uJ");?>" style="margin-top:2px;"></a> </div>
    </li>
  </ul>
</div>

<!--6F热门现金券-->
<div class="cash_coupon wid">
  <div class="index_hotel_header of"> <i class="index_icon index_icon_floor index_icon_floor6 fl"></i>
    <h1 class="fl col2">热门现金券</h1>
    <a href="<?php echo "{$root}forum/coupons.php";?>" class="fr">更多>></a> </div>
  <div class='coupsCatoShows'>
    <ul class='clear' style="width:1210px;overflow:hidden;">
     <?php        
     $CouponsetypeSql = mysql_query("select * from couponsetype where couponseid in ( select seid from seller where prove = '已通过' and authentication = '已认证' and CashCoupon = '开通' ) order by UpdateTime desc limit 0,10");    
       while($Couponsetype = mysql_fetch_array($CouponsetypeSql)){ 
		$SellerResult = query("seller"," seid = '$Couponsetype[couponseid]' "); 
		$Conpon = query("coupon"," coupontargetid = '$Couponsetype[couponseid]' order by coupondate desc "); 
		$totalCoupon = mysql_fetch_array(mysql_query("select sum(couponcount) as totalCoupon from coupon where coupontargetid = '$SellerResult[seid]' "));    	$se_query = query("seller"," seid = '$result[couponseid]' ");       
      //查询商家共获得的评论数        
      $num = mysql_num_rows(mysql_query("select * from secomment where commenttargetid = '$Couponsetype[couponseid]' and status = '已通过' "));       
      //查询统计商家获得的评分的平均分        
      $avgscore = mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid = '$Couponsetype[couponseid]' and status = '已通过' "));
      //根据商家id查询商家的现金券信息        
      $coupon_result = mysql_fetch_array(mysql_query("select * from coupon where coupontargetid = '$Couponsetype[couponseid]' order by couponprice desc"));
      $fenshu=$coupon_result['coupontotal']-$coupon_result['couponcount'];
       echo "    
	<li style='margin: 0px 22px 20px 0px;'>
        <div class='top'> <a class='couponName' href='{$root}store.php?seller={$SellerResult['seid']}' title='{$SellerResult['Brand']}'>{$SellerResult['Brand']}</a>
          <div class='coupImg'> <img alt='{$SellerResult['Brand']}现金券' src='".ListImg($SellerResult['logo'],'seller/')."' width='110' height='110'> </div>
          <div class='coupDtails' style='margin-top:-20px;'>
            <ul class='st_score'>
              <li class='score'>
                <div class='dimStar'> <i class='greyFive'></i> <i class='yellowFive' style='width:".($avgscore[0]*15)."px;'></i> </div>
                <b>".(substr($avgscore[0],0,3) == 0?0:substr($avgscore[0],0,3))."分</b> </li>
              <li><a href='{$root}forum/reviewsC.php?seller={$SellerResult['seid']}'>共<span class='red'>{$num}</span>条点评</a></li>
            </ul>
          </div>
        </div>
        <div class='bottom'>
          <p class='price'><em>￥</em><b>{$Conpon['couponprice']}</b></p>
          <div class='get'> <a href='{$root}forum/singleCoupon.php?seid={$Conpon[coupontargetid]}'>我要领取</a> </div>
          <p><span class='getCNumber'>{$totalCoupon['totalCoupon']}</span>人领取</p>
          <p>本期剩余余".($fenshu<=0?"0":$fenshu)."份 </p>
        </div>
      </li>   
             ";     
         } 
        ?>    
   </ul>
  </div>
</div>
<!--底部广告-->
<div class="index_bottom_ad wid"> <a href="javascript:;"><img src="<?php echo img("Xua51488018gr");?>"></a> </div>
<style>.helpMsg ul{margin-left:99px;}.hot_hotel_items{width: 199px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}</style>
<!--底部-->
<div class="toTop" title="返回顶部">返回顶部</div>
<div style="clear:both; height:10px;"></div>
<?php echo warn().ThisFooter();?>    
<script>
/*酒店切换*/
window.onload=function(){var a=document.getElementById("hotelTabWrap"),b=a.getElementsByClassName("hotel_header_list"),c=a.getElementsByClassName("hotelTab");c[1].style.display="none";for(a=0;a<b.length;a++)b[a].index=a,b[a].onclick=function(){for(var a=0;a<c.length;a++)b[a].className="fl hotel_header_list",c[a].style.display="none";this.className="fl hotel_header_list hotel_current";c[this.index].style.display="block"}};
/*banner切换*/
$(document).ready(function(e) {
	setSlider({
		container:'#image-slider',
		mainCell:'#image-slider-cell',
		mainSort:'#image-slider-sort',
		activeClass:'current',
		resize:true,
		speed:3500,
		autoplay:true
	});    
});

var setSlider=function(e){e=e||{};var bannerCont=e.container||"#banner-container",bannerCell=e.mainCell||"#banner-cell",bannerSort=e.mainSort||"#banner-sort",bannerNext=e.next||"#banner-button-next",bannerPrev=e.prev||"#banner-button-prev",speed=e.speed||2500,type=e.type||"li",className=e.activeClass||"activeOn",autoplay=e.autoplay,resize=e.resize,getElm=function(a){if(a)return document.getElementById(a.replace(/#/,""))},getStyle=function(a,b){return a.currentStyle?a.currentStyle[b]:getComputedStyle(a,!1)[b]},width=getStyle(getElm(bannerCont),"width"),height=getStyle(getElm(bannerCont),"height"),widths=parseInt(width.replace(/px/,"")),heights=parseInt(height.replace(/px/,"")),cont=0,time=null,ch=getElm(bannerCell).getElementsByTagName(type),sorts=getElm(bannerSort).getElementsByTagName(type),chLength=ch.length,timer=null,init=function(){0==autoplay?getElm(bannerCell).setAttribute("data-state","stop"):getElm(bannerCell).setAttribute("data-state","start");for(var a=0;a<chLength;a++){var b=document.createElement(type);getElm(bannerSort).appendChild(b)}getElm(bannerCell).style.width=widths*chLength+"px";getElm(bannerCell).style.height=heights+"px";sorts[0].className=className;for(a=0;a<chLength;a++)ch[a].style.width=widths+"px",ch[a].style.height=heights+"px"},regEvent=function(b,a,c){window.attachEvent?b.attachEvent(a,c):(a=a.replace(/^on/,""),b.addEventListener(a,c,!1))},mouse=function(){getElm(bannerCell).onmouseover=function(){getElm(bannerCell).setAttribute("data-state","stop");clearInterval(time)};getElm(bannerCell).onmouseout=function(){getElm(bannerCell).setAttribute("data-state","start");autoplay&&setTimes()}},mouseClick=function(){for(var a=0;a<chLength;a++)sorts[a].index=a,sorts[a].onclick=function(){for(var a=0;a<chLength;a++)sorts[a].className="";this.className=className;clearInterval(time);cont=this.index;setMove(this.index);autoplay&&setTimes()}},mouseNext=function(a){getElm(bannerNext)&&(getElm(bannerNext).onclick=function(){clearInterval(time);cont++;cont>=chLength&&(cont=chLength-1);autoplay&&setTimes();setMove(cont);a(cont)})},mousePrev=function(a){getElm(bannerPrev)&&(getElm(bannerPrev).onclick=function(){clearInterval(time);cont--;0>=cont&&(cont=0);autoplay&&setTimes();setMove(cont);a(cont)})},setTimes=function(){clearInterval(time);time=setInterval(function(){cont++;cont>=chLength&&(cont=0);for(var a=0;a<chLength;a++)sorts[a].className="";sorts[cont].className=className;setMove(cont)},speed)},setMove=function(a){animate(getElm(bannerCell),{marginLeft:-a*widths},28,2)},animate=function(a,e,h,k,f){clearInterval(a.timer);a.timer=setInterval(function(){var g=!0,b;for(b in e){var d=parseInt(getStyle(a,b)),d="opacity"==b?Math.round(100*parseFloat(getStyle(a,b))):parseInt(getStyle(a,b)),c=(e[b]-d)/h,c=0<c?Math.ceil(c):Math.floor(c);d!=e[b]&&(g=!1);"opacity"==b?(a.style.filter="alpha(opacity:"+(d+c)+")",a.style.opacity=(d+c)/100):a.style[b]=d+c+"px"}g&&(clearInterval(a.timer),f&&f)},k)},bind=function(){mouse();mouseNext(function(b){for(var a=0;a<chLength;a++)sorts[a].className="";sorts[b].className.match(className)||(sorts[b].className=className)});mousePrev(function(b){for(var a=0;a<chLength;a++)sorts[a].className="";sorts[b].className.match(className)||(sorts[b].className=className)});autoplay&&setTimes();init();mouseClick()};bind()}
</script>
</body>
</html>
