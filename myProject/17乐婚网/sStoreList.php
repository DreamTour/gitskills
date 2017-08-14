<?php         
include "library/function.php"; 
if(isset($_GET['type'])){
	$ThisUrl = "{$root}sStoreList.php?TypeOne={$_GET['TypeOne']}";        
	if($_GET['type'] == "all"){
		$ThisUrl .= "?type=all"; 
		$type = "all";
	}else if($_GET['type'] == "star"){
		$ThisUrl .= "?type=star";
		$type = "star";	
	}else if($_GET['type'] == "feature"){
		$ThisUrl .= "?type=feature";
		$type = "feature";
	}	
}else{
	header("location:{$ThisUrl}?type=all");
	exit(0);
}       
$TypeOne = query("TypeOne"," id = '$_GET[TypeOne]' ");        
//当商家列表页分类改变时，清空模糊查询        
if($_SESSION['SearchStore']['SellerType'] != $_GET['TypeOne']){        
    unset($_SESSION['SearchStore']);       
}   
if($_GET['TypeOne'] == "all" ){ 
    $sql=$_SESSION['SearchStore']['Sql']; 
}else{ 
    $sql="select * from seller where TypeOneId = 'b01q' and prove = '已通过' "; 
} 

$num = mysql_num_rows(mysql_query($sql));        
paging($sql," order by authentication='已认证' desc,PageView desc,time",6);        
echo head("pc");       
echo insertBackUrl();        
?>        
<!DOCTYPE html>
<html lang='zh'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
<meta name='renderer' content='webkit'>
<title>重庆婚博会官方指定平台-重庆新人联盟，重庆结婚新人首选一站式新婚消费商城，集婚纱摄影、婚庆珠宝、婚礼用品、婚纱礼服、宴会酒店于一体的大型综合性结婚平台。</title>
<meta name='keywords' content='结婚、婚纱礼服、婚纱摄影、婚纱照、珠宝首饰、结婚对戒、婚庆策划、婚宴、酒席、婚宴预订、婚宴酒店、重庆婚博会、婚博会、婚宴网,婚礼场地价格,婚庆酒店,订婚宴,结婚网、婚礼摄影师、化妆师、婚礼主持、婚礼司仪、结婚购物'>
<meta name='description' content='重庆婚博会官方指定合作平台-一个重庆最聪明的一站式结婚消费平台，最真实的新人订单点评，汇集婚纱礼服,婚纱摄影,结婚对戒,婚宴酒楼,婚庆婚礼策划,结婚用品等流行款，上万新人探店经验互动分享及疑难问题咨询，数千商家当季特惠精选，让您结婚花钱更聪明!'>
<link rel='stylesheet' type='text/css' href='http://www.17lehun.com/library/pc.css'>
<link rel='stylesheet' type='text/css' href='shop_detail.css'>
<script type='text/javascript' src='http://www.yumukeji.com/library/jquery-1.11.2.min.js'></script>
<script type='text/javascript' charset='UTF-8' src='http://www.17lehun.com/library/pc.js'></script>
<link rel='Bookmark'  type='image/x-icon'  href='http://www.17lehun.com/favicon.ico'/>  
<link rel='icon'  type='image/x-icon' href='http://www.17lehun.com/favicon.ico' />  
<link rel='shortcut icon'  type='image/x-icon' href='http://www.17lehun.com/favicon.ico' />  
<link rel='apple-touch-icon' href='http://www.17lehun.com/favicon.ico'>
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
	<div class="column center">
		<span class="FloatLeft">关注我们</span>
		新人联盟结婚商城--重庆婚博会官方指定平台		<span class="FloatRight">
        <a href='http://www.17lehun.com/user/usRegister.php'>注册</a>&nbsp;&nbsp;<span class='MenuVerticalLine'>|</span>&nbsp;&nbsp;
        <a href='http://www.17lehun.com/user/uslogin.php'>登录</a>&nbsp;&nbsp;<span class='MenuVerticalLine'>|</span>&nbsp;&nbsp;
    <a href="http://www.17lehun.com/seller/selogin.php">商家入驻</a></span>
	</div>
</div>
<!--顶部引导信息结束--> 
<!--logo和搜索行开始-->
<div class="column padding" style="width:1180px;"> <a href="http://www.17lehun.com/"><img class="logo" src="http://www.17lehun.com/img/WebsiteImg/Pbu38281411wp.jpg"></a> <a target="_blank" href="http://www.17lehun.com/suopiao.php"><img class="AdvertisementTop" src="http://www.17lehun.com/img/WebsiteImg/WZK43017543kX.jpg"></a>
  <div class="HeaderSearchDiv">
    <div class="HeaderSearchKuang clear">
      <form name="SearchForm" id="SearchForm" action="http://www.17lehun.com/library/PcPost.php" method="post">
        <input name="SearchStoreBrandList" type="text" id="KeyWords" class="HeaderSearchText" placeholder="0元体验，送婚房">
        <input name="SellerType" type="hidden" value="all">
        <img class="HeaderSearchImg" id="SearchImg" src="http://www.17lehun.com/img/images/search.jpg" />
      </form>
    </div>
    <p class="smallword" style="padding-bottom:10px;">
      <a href='http://www.17lehun.com/m/mindex.php
'>掌上筹婚</a>&nbsp;&nbsp;<a href='http://www.17lehun.com/forum/coupons.php
'>下单拿钱</a>&nbsp;&nbsp;<a href='http://www.17lehun.com/forum/forum.php?TypeOne=sbo25033883dr&amp;TypeTwo=jNm25556438yj
'>0元体验</a>&nbsp;&nbsp;<a href='http://www.17lehun.com/bbs.php?id=XZo32319590PZ&amp;TypeTwoId=kGj25033900QG'>霸王餐 </a>&nbsp;&nbsp;    </p>
  </div>
  <div class="clear"></div>
</div>
<!--logo和搜索结束--> 
<!--主导航-->
  <div class="main_nav_box">
      <div class="main_nav of wid">
          <div class="nav_all bg_col2 fl col fz16">全部分类</div>
          <ul class="main_nav_top of fl fz16">
              <li class="fl"><a href="javascript:;">首页</a></li>
              <li class="fl"><a href="javascript:;">现金券</a></li>
              <li class="fl"><a href="javascript:;">社区论坛</a></li>
              <li class="fl"><a href="javascript:;">用户点评</a></li>
              <li class="fl"><a href="javascript:;">积分商城</a></li>
          </ul>
      </div>
  </div> 
<div class='floatWindowB'>  
	<span class='closeWin'>×</span>  
	<a target='_blank' href='http://www.17lehun.com/suopiao.php'><div class='WinB'></div></a>  
</div>  
<a target='_blank' href='http://www.17lehun.com/suopiao.php'><div class='floatWindowS'></div></a>  
				
<style>                
	.authOwner{        
		background:url(http://www.17lehun.com/img/WebsiteImg/mNx27033216DV.jpg) no-repeat scroll 0px -20px / 70% auto;        
	}        
	.remarkedSeller{        
		background:url(http://www.17lehun.com/img/WebsiteImg/mNx27033216DV.jpg) no-repeat scroll 0px -61px / 70% auto;        
	}        
	.couponsSafe{        
		background:url(http://www.17lehun.com/img/WebsiteImg/mNx27033216DV.jpg) no-repeat scroll 0px -1px / 70% auto;        
	}
	.couponsLeague{        
		background:url(http://www.17lehun.com/img/WebsiteImg/mNx27033216DV.jpg) no-repeat scroll 0px -41px / 70% auto;        
	}
	.couponsOwner{        
		background:url(http://www.17lehun.com/img/WebsiteImg/mNx27033216DV.jpg) no-repeat scroll 0px -41px / 70% auto;        
	}        
	.redNrow{             
		background:url(http://www.17lehun.com/img/WebsiteImg/ODc25833910xF.jpg) no-repeat scroll 0px 0px;               
	}             
	b.enterstore{             
		background:url(http://www.17lehun.com/img/WebsiteImg/uNM25837162Zx.jpg) no-repeat scroll 0px 0px;              
	}              
	.advan{             
		background:url('http://www.17lehun.com/img/WebsiteImg/GEq26070183CG.jpg') no-repeat scroll  -854px -441px;             
	}             
	.disadvan{             
		background:url('http://www.17lehun.com/img/WebsiteImg/GEq26070183CG.jpg') no-repeat scroll  -854px -407px;             
	}             
	.asse{             
		background:url('http://www.17lehun.com/img/WebsiteImg/GEq26070183CG.jpg') no-repeat scroll  -854px -372px;             
	}             
	.shv-btn{             
		background:#fff url('http://www.17lehun.com/img/WebsiteImg/tHH26440974Sm.jpg') no-repeat scroll 0px 4px;             
	}             
	.forword{             
		background:url('http://www.17lehun.com/img/WebsiteImg/dyM26077102al.jpg') no-repeat scroll 9px 6px;             
	}             
	.jifen{            
		background:url('http://www.17lehun.com/img/WebsiteImg/Hsu26247189uY.jpg') no-repeat scroll 0px -4px;             
	}            
	.yue{            
		background:url('http://www.17lehun.com/img/WebsiteImg/fkN26247309Is.jpg') no-repeat scroll 0px -9px;             
	}            
	.dengji{            
		background:url('http://www.17lehun.com/img/WebsiteImg/OSL26247402Uw.jpg') no-repeat scroll;             
	}            
	.addBlockOne{            
		background:url('http://www.17lehun.com/img/WebsiteImg/Xdh26246364Ug.jpg') no-repeat scroll;            
	}            
	.addBlockTwo{            
		background:url('http://www.17lehun.com/img/WebsiteImg/yGw26246659Ts.jpg') no-repeat scroll;            
	}            
	.jinghua{            
		background:url('http://www.17lehun.com/img/WebsiteImg/ufO26184347IQ.jpg') no-repeat scroll;            
	}            
	.zhiding{            
		background:url('http://www.17lehun.com/img/WebsiteImg/maG26184264lL.jpg') no-repeat scroll 0px 2px / 85% auto;        
	}              
	.greyFive{           
		background:url('http://www.17lehun.com/img/WebsiteImg/QwK26265620GS.jpg') no-repeat scroll;           
	}           
	.yellowFive{           
		background: #f6f6f6 url('http://www.17lehun.com/img/WebsiteImg/VpP26348459Io.jpg') no-repeat scroll;           
	}        
	.shv-forword-arrow{     
		background: #f6f6f6 url('http://www.17lehun.com/img/WebsiteImg/GEq26070183CG.jpg') no-repeat scroll -600px -60px;     
	}     
	.shv-next-arrow{     
		background: #f6f6f6 url('http://www.17lehun.com/img/WebsiteImg/GEq26070183CG.jpg') no-repeat scroll -690px -60px;     
	}
@charset "utf-8";.star_icon{display:inline-block;width:100px;height:20px;background-image:url(http://www.17lehun.com/img/WebsiteImg/BiG51486744VL.jpg)}
.details_icon{display:inline-block;width:19px;height:19px;background-image:url(http://www.17lehun.com/img/WebsiteImg/qYQ51486704ME.jpg)}
.yellowFive{background:#fff url(http://www.17lehun.com/img/WebsiteImg/VpP26348459Io.jpg) no-repeat scroll}
.WinB{background:url(http://www.17lehun.com/img/WebsiteImg/rom43268038XU.jpg) no-repeat scroll;width:100%;height:100%}
.floatWindowS{background:url(http://www.17lehun.com/img/WebsiteImg/eNH43268047MN.jpg) no-repeat scroll}
.of{overflow:hidden}
.fl{float:left}
.fr{float:right}
.cl{clear:both}
.bg_col1{background-color:#c81623}
.bg_col2{background-color:#b1191a}
.col{color:#fff}
.col2{color:#000}
.col3{color:#c81623}
.wid{width:1200px;margin:auto}
.fz20{font-size:20px}
.fz18{font-size:18px}
.fz16{font-size:16px}
.fz14{font-size:14px}
.fz12{font-size:12px}
.fw{font-weight:400}
.fw1{font-weight:700}
*{box-sizing:border-box;margin:0;padding:0}
b{font-weight:400}
.ta{text-align:center}
.main_nav_box{height:40px;border-bottom:2px solid #b1191a}
.main_nav{line-height:40px}
.nav_all{width:230px;text-align:center}
.main_nav_top li{width:120px;text-align:center}
.StoreListRight{width:250px;float:right;background-color:#fff;padding:10px;border:1px solid #e9e9e9}
.StoreListDiv{margin-bottom:15px;height:81px;padding:16px 0 16px 0;border-bottom:1px solid #e9e9e9}
.StoreLogoDiv{padding:4px;border:1px solid #e9e9e9;width:112px;height:80px;float:left;margin:auto 10px auto auto}
.StoreLogo{width:112px;height:80px}
.StoreListTitle{font-size:18px;font-weight:700}
.StoreListMx{font-size:14px;color:#888;line-height:20px;margin-top:10px}
.dimStar i{background-color:transparent}
.dimStar{top:5px}
.dimStar>b{position:relative;top:-4px}
.stScoreShow{margin-top:-53px}
.StoreListRight,.details_left{margin:20px 0}
.details_left{width:930px}
.details_search{padding:20px 20px 0 20px;border:1px solid #ddd}
.bt{border-bottom:1px solid #ddd}
.search_title{height:40px;line-height:40px;background:url(http://www.17lehun.com/img/WebsiteImg/cOQ51490240mP.jpg) no-repeat;position:relative;padding:0 10px}
.search_btn{width:150px;padding:2px 5px;position:absolute;right:20px;bottom:7px}
.ic1{background-position:-6px -9px;position:absolute;right:27px;bottom:8px}
.ic2,.ic3,.ic4{margin-bottom:-5px;margin-right:5px}
.ic2{background-position:-23px -8px}
.ic3{background-position:-49px -8px}
.ic4{background-position:-72px -8px}
.title_items a{display:inline-block;width:100px;text-align:center;margin-right:5px}
.current{border-top:3px solid #c81623;border-left:1px solid #ddd;border-right:1px solid #ddd;background-color:#fff;color:#c81623}
.mr{padding:20px 10px}
.search_items{width:650px;margin-right:30px}
.search_items li{float:left;width:80px;line-height:24px;margin-right:10px}
.all{display:inline-block;padding:3px;margin-left:45px}
.search_items .range{width:200px}
.range *{margin-right:3px}
.range input,.sure{width:50px;line-height:20px}
.sure{display:inline-block;background-color:#c81623;text-align:center;padding:2px}
.details_content{margin-top:20px;border:1px solid #ddd}
.hotel_detail thead tr{border-bottom:1px solid #ddd}
.pd{margin:20px;padding-bottom:10px}
.items_title a{line-height:40px}
.hotel_message dd,.hotel_message dt{border-bottom:1px solid #ddd;line-height:36px}
.hotel_message span{display:inline-block;width:125px;margin-right:10px}
.hotel_message dd span{color:#000}
.items_exto{margin:5px 0}
.items_exto span{padding:0 5px;border-right:1px solid #ddd}
.details_content b{color:#c81623;margin:0 3px}
.find_all{line-height:30px}
.star_icon1{background-position:-7px -34px;margin-bottom:-2px}
.page_btn_box{text-align:center;margin:30px 0 0 0;clear:both}
.page_btn{display:inline-block;width:58px;height:24px;border:1px solid #d4d4d4;text-align:center;line-height:24px;color:#000;font-size:14px;margin-right:5px}
.page_number{width:70px;position:relative;top:-1px}
.helpMsg ul{margin-left:99px;}
</style>                       

<div class="column">        
<!--洋葱皮开始--> 
<div class="kuang">        
	<p class="smallword">        
		当前位置：        
		<a href="<?php echo $root."sindex.php";?>">首页</a>&nbsp;>&nbsp;        
		<a href="<?php echo "{$root}goods.php?TypeOne=b01q";?>">定婚宴</a>&nbsp;>&nbsp;        
		<a href="<?php echo "{$root}sStoreList.php";?>">更多商铺</a>        
	</p>        
</div> 		
<!--洋葱皮结束-->
<!--左边--> 



<div class="details_left fl">
	<!--详细搜索-->
	<ul class="details_search">
    	<li class="search_title bt of">
        	<ul class="title_items of">
                <li><a href="<?php echo $ThisUrl;?>" class="fl fz16 <?php echo MenuGet("type","all","current");?>">全部类型</a></li>
                <li><a href="<?php echo $ThisUrl;?>" class="fl fz16 <?php echo MenuGet("type","star","current");?>">星级酒店</a></li>
                <li><a href="<?php echo $ThisUrl;?>" class="fl fz16 <?php echo MenuGet("type","feature","current");?>">特色餐厅</a></li>
            </ul>
            <input type="text" name="details_search" placeholder="酒店名 路名 地区" class="fr search_btn" />
            <a href="javascript:;"><i class="details_icon ic1"></i></a>
        </li>
        <li class="bt mr search_area of">
          	<div class="search_til fl"><i class="details_icon ic2"></i><span class="fz14 col2">区域</span></div>
          	<a href="javascript:; fl" class="all bg_col1 col">全部</a>
            <ul class="search_items fr of">
              <li><a  href="javascript:;" >渝北区</a></li>
              <li><a  href="javascript:;" >渝中区</a></li>
              <li><a  href="javascript:;" >南岸区</a></li>
              <li><a  href="javascript:;" >九龙坡区</a></li>
              <li><a  href="javascript:;" >江北区</a></li>
              <li><a  href="javascript:;" >沙坪坝区</a></li>
              <li><a  href="javascript:;" >巴南区</a></li>
              <li><a  href="javascript:;" >大渡口区</a></li>
              <li><a  href="javascript:;" >北部新区</a></li>
              <li><a  href="javascript:;" >北碚区</a></li>
              <li><a  href="javascript:;" >高新区</a></li>
              <li><a  href="javascript:;" >重庆近郊</a></li>
              <li><a  href="javascript:;" >黔江区</a></li>
              <li><a  href="javascript:;" >大足区</a></li>
              <li><a  href="javascript:;" >合川区</a></li>
              <li><a  href="javascript:;" >长寿区</a></li>
              <li><a  href="javascript:;" >万州区</a></li>
              <li><a  href="javascript:;" >涪陵区</a></li>
              <li><a  href="javascript:;" >綦江区</a></li>
              <li><a  href="javascript:;" >永川区</a></li>
              <li><a  href="javascript:;/" >南川区</a></li>
            </ul>
        </li>
        <li class="bt mr of">
        	<div class="search_til fl"><i class="details_icon ic3"></i><span class="fz14 col2">桌数</span></div>
          	<a href="javascript:; fl" class="all bg_col1 col">全部</a>
            <ul class="search_items fr of">
              <li><a  href="javascript:;" >10桌以下</a></li>
              <li><a  href="javascript:;" >10-20桌</a></li>
              <li><a  href="javascript:;" >20-30桌区</a></li>
              <li><a  href="javascript:;" >30桌以上</a></li>
            </ul>
        </li>
        <li class="bt mr of" style="border:none">
        	<div class="search_til fl"><i class="details_icon ic4"></i><span class="fz14 col2">价格</span></div>
          	<a href="javascript:; fl" class="all bg_col1 col">全部</a>
            <ul class="search_items fr of">
              <li><a  href="javascript:;" >2000元以下</a></li>
              <li><a  href="javascript:;" >2000-3000元</a></li>
              <li><a  href="javascript:;" >3000-4000元</a></li>
              <li><a  href="javascript:;" >4000元以上</a></li>
              <li class="range of">
                  <input type="text" name="range" class="fl" /><span class="fl">-</span>
                  <input type="text" name="range" class="fl" /><span class="fl">元</span>
                <a href="javascript:;" class="fl sure col">确定</a>
              </li>
            </ul>
        </li>
    </ul>
    <!--详细列表-->
   	<ul class="details_content">
<!--	 	<li class="of bt pd">
        	<a href="javascript:;" class="fl"><img src="http://www.17lehun.com/img/WebsiteImg/sLe51490478yr.jpg"></a>
            <div class="fr">
            	<div class="items_title of">
                	<a href="javascript:;" class="fl fz18">燕南酒店</a>
                    <span class="fr col3 fz20">￥998-1998</span>
                </div>
                <div class="items_exto">
                	<i class="star_icon star_icon1"></i>
                    <b class="fz14">4.8</b>
                    <span>星级酒店</span>
                    <span>北部新区翠渝路</span>
                    <span style="border:none;">可容纳<b>60</b>桌</span>
                </div>
				<dl class="hotel_message fz14">
                	<dt><span>宴会厅</span><span>桌数</span><span>层高</span><span>柱数</span></dt>
                    <dd><span>香榭丽舍厅</span><span><b>60</b>桌</span><span>4米</span><span>-</span></dd>
                    <dd><span>云中漫步厅</span><span><b>55</b>桌</span><span>6米</span><span>-</span></dd>
                </dl>
                <div class="ta find_all"><a href="javascript:;">查看全部<b>6</b>个宴会厅</a></div>
            </div>
        </li>
        <li class="of bt pd">
        	<a href="javascript:;" class="fl"><img src="http://www.17lehun.com/img/WebsiteImg/QwR51490487tw.jpg"></a>
            <div class="fr">
            	<div class="items_title of">
                	<a href="javascript:;" class="fl fz18">燕南酒店</a>
                    <span class="fr col3 fz20">￥998-1998</span>
                </div>
                <div class="items_exto">
                	<i class="star_icon star_icon1"></i>
                    <b class="fz14">4.8</b>
                    <span>星级酒店</span>
                    <span>北部新区翠渝路</span>
                    <span style="border:none;">可容纳<b>60</b>桌</span>
                </div>
				<dl class="hotel_message fz14">
                	<dt><span>宴会厅</span><span>桌数</span><span>层高</span><span>柱数</span></dt>
                    <dd><span>香榭丽舍厅</span><span><b>60</b>桌</span><span>4米</span><span>-</span></dd>
                    <dd><span>云中漫步厅</span><span><b>55</b>桌</span><span>6米</span><span>-</span></dd>
                </dl>
                <div class="ta find_all"><a href="javascript:;">查看全部<b>6</b>个宴会厅</a></div>
            </div>
        </li>
        <li class="of bt pd">
        	<a href="javascript:;" class="fl"><img src="http://www.17lehun.com/img/WebsiteImg/zad51490492WV.jpg"></a>
            <div class="fr">
            	<div class="items_title of">
                	<a href="javascript:;" class="fl fz18">燕南酒店</a>
                    <span class="fr col3 fz20">￥998-1998</span>
                </div>
                <div class="items_exto">
                	<i class="star_icon star_icon1"></i>
                    <b class="fz14">4.8</b>
                    <span>星级酒店</span>
                    <span>北部新区翠渝路</span>
                    <span style="border:none;">可容纳<b>60</b>桌</span>
                </div>
				<dl class="hotel_message fz14">
                	<dt><span>宴会厅</span><span>桌数</span><span>层高</span><span>柱数</span></dt>
                    <dd><span>香榭丽舍厅</span><span><b>60</b>桌</span><span>4米</span><span>-</span></dd>
                    <dd><span>云中漫步厅</span><span><b>55</b>桌</span><span>6米</span><span>-</span></dd>
                </dl>
                <div class="ta find_all"><a href="javascript:;">查看全部<b>6</b>个宴会厅</a></div>
            </div>
        </li>
        <li class="of bt pd">
        	<a href="javascript:;" class="fl"><img src="http://www.17lehun.com/img/WebsiteImg/lac51490496Vp.jpg"></a>
            <div class="fr">
            	<div class="items_title of">
                	<a href="javascript:;" class="fl fz18">燕南酒店</a>
                    <span class="fr col3 fz20">￥998-1998</span>
                </div>
                <div class="items_exto">
                	<i class="star_icon star_icon1"></i>
                    <b class="fz14">4.8</b>
                    <span>星级酒店</span>
                    <span>北部新区翠渝路</span>
                    <span style="border:none;">可容纳<b>60</b>桌</span>
                </div>
				<dl class="hotel_message fz14">
                	<dt><span>宴会厅</span><span>桌数</span><span>层高</span><span>柱数</span></dt>
                    <dd><span>香榭丽舍厅</span><span><b>60</b>桌</span><span>4米</span><span>-</span></dd>
                    <dd><span>云中漫步厅</span><span><b>55</b>桌</span><span>6米</span><span>-</span></dd>
                </dl>
                <div class="ta find_all"><a href="javascript:;">查看全部<b>6</b>个宴会厅</a></div>
            </div>
        </li>
        <li class="of bt pd" style="border:none;margin-bottom:0">
        	<a href="javascript:;" class="fl"><img src="http://www.17lehun.com/img/WebsiteImg/stm51490501nF.jpg"></a>
            <div class="fr">
            	<div class="items_title of">
                	<a href="javascript:;" class="fl fz18">燕南酒店</a>
                    <span class="fr col3 fz20">￥998-1998</span>
                </div>
                <div class="items_exto">
                	<i class="star_icon star_icon1"></i>
                    <b class="fz14">4.8</b>
                    <span>星级酒店</span>
                    <span>北部新区翠渝路</span>
                    <span style="border:none;">可容纳<b>60</b>桌</span>
                </div>
				<dl class="hotel_message fz14">
                	<dt><span>宴会厅</span><span>桌数</span><span>层高</span><span>柱数</span></dt>
                    <dd><span>香榭丽舍厅</span><span><b>60</b>桌</span><span>4米</span><span>-</span></dd>
                    <dd><span>云中漫步厅</span><span><b>55</b>桌</span><span>6米</span><span>-</span></dd>
                </dl>
                <div class="ta find_all"><a href="javascript:;">查看全部<b>6</b>个宴会厅</a></div>
            </div>
        </li>
-->   
<?php
$listContent = "";        
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
	/*		<a href='{$root}store.php?seller={$seller['seid']}' class='clear'>        
			<div change='divback' class='StoreListDiv'>        
				<div class='StoreLogoDiv'>        
					<img class='StoreLogo' src='".ListImg($seller['logo'])."'>        
				</div>        
				<p class='StoreListTitle'>        
					{$SellerName}&nbsp;{$authentication}{$IsCoupon}{$IsSecommentid}{$status}{$league}     
				</p>        
				<p class='StoreListMx'>商家地址：{$seller['address']}</p>        
				<p class='StoreListMx' style='margin-top:10px;'>注册时间：{$seller['time']}</p>      
				<span class='storePop'>人气指数：{$seller['PageView']}</span>      
				<div class='stScoreShow'>     
					<div class='dimStar'>     
					   <i class='greyFive'></i>    
					   <i class='yellowFive' style='width: ".($score*15)."px;'></i>      
					</div>       
					<b>{$score}分</b>      
				</div>     
				<div class='clear'></div>        
			</div>        
		</a> 
			
	*/	$listContent .= "        
			<li class='of bt pd' style='border:none;margin-bottom:0'>
				<a href='{$root}store.php?seller={$seller['seid']}' class='fl'><img src='".ListImg($seller['logo'])."'></a>
				<div class='fr'>
					<div class='items_title of'>
						<a href='{$root}store.php?seller={$seller['seid']}' class='fl fz18'>
							{$SellerName}&nbsp;{$authentication}{$IsCoupon}{$IsSecommentid}{$status}{$league} 
						</a>
						<span class='fr col3 fz20'>￥998-1998</span>
					</div>
					<div class='items_exto'>
						<i class='star_icon star_icon1'></i>
						<b class='fz14'>{$score}分</b>
						<span>星级酒店</span>
						<span>{$seller['address']}</span>
						<span style='border:none;'>可容纳<b>60</b>桌</span>
					</div>
					<dl class='hotel_message fz14'>
						<dt><span>宴会厅</span><span>桌数</span><span>层高</span><span>柱数</span></dt>
						<dd><span>香榭丽舍厅</span><span><b>60</b>桌</span><span>4米</span><span>-</span></dd>
						<dd><span>云中漫步厅</span><span><b>55</b>桌</span><span>6米</span><span>-</span></dd>
					</dl>
					<div class='ta find_all'><a href='javascript:;'>查看全部<b>6</b>个宴会厅</a></div>
				</div>
			</li>
		";        
	}        
}else{        
	echo "一个商家都没有";        
}        
?>   
	<?php echo $listContent;?>     
	</ul>
    <!--翻页按钮-->
<!--    <div class="page_btn_box">
        	<a class="page_btn" href="javascript:;">首页</a>
            <a class="page_btn" href="javascript:;">上一页</a>
            <select class="page_btn page_number" name="page_number">
            	<option><a href="javascript:;">第1页</a></option>
                <option><a href="javascript:;">第2页</a></option>
            </select>	
            <a class="page_btn" href="javascript:;">下一页</a>		
        </div>-->
       <div style="padding:10px;"><?php echo fenye($ThisUrl);?></div>        
    </div>     
<!--右边-->   
	<div class="StoreListRight">   
		<h3>最新产品</h3> 
         <?php   
        $NewGoodsSql = mysql_query("select * from goods where Auditing = '已通过' order by UpdateTime desc limit 4");  
        while($NewGoods = mysql_fetch_array($NewGoodsSql)){  
            $TypeTwoResult = query("TypeTwo"," id = '$NewGoods[TypeTwoId]'");  
            echo "  
                <a class='sinStroePush' href='{$root}goodsmx.php?TypeOne={$TypeTwoResult['TypeOneId']}&goods={$NewGoods['id']}'>   
                    <img src='{$root}{$NewGoods['ico']}' class='stPushImg'/>   
                    <p class='stName' style='color:#8C8C8C;'>{$NewGoods['name']}</p>  
                    <p class='stName'>￥{$NewGoods['price']}</p>   
                </a>  
                ";  
        }  
        ?>   
 <!--			<a class='sinStroePush' href='http://www.17lehun.com/goodsmx.php?TypeOne=d2s5d&goods=KyI43279580cw'>   
				<img src='http://www.17lehun.com/img/GoodsIco/eqy43282434pF.jpg' class='stPushImg'/>   
				<p class='stName' style='color:#8C8C8C;'>夏季热销套系</p>  
				<p class='stName'>￥5888.00</p>   
			</a>  
			  
			<a class='sinStroePush' href='http://www.17lehun.com/goodsmx.php?TypeOne=d2s5d&goods=cqb43279351Gi'>   
				<img src='http://www.17lehun.com/img/GoodsIco/ZQh43280003oJ.jpg' class='stPushImg'/>   
				<p class='stName' style='color:#8C8C8C;'>今尚古冰凉一夏专享套系</p>  
				<p class='stName'>￥3699.00</p>   
			</a>  
			  
			<a class='sinStroePush' href='http://www.17lehun.com/goodsmx.php?TypeOne=nh014t&goods=qOt36029318Cs'>   
				<img src='http://www.17lehun.com/img/GoodsIco/bJR36029465qg.jpg' class='stPushImg'/>   
				<p class='stName' style='color:#8C8C8C;'>【端庄中式】</p>  
				<p class='stName'>￥13888.00</p>   
			</a>  
			  
			<a class='sinStroePush' href='http://www.17lehun.com/goodsmx.php?TypeOne=nh014t&goods=IaI36029683pm'>   
				<img src='http://www.17lehun.com/img/GoodsIco/BlP36029807dj.jpg' class='stPushImg'/>   
				<p class='stName' style='color:#8C8C8C;'>【宝宝宴】</p>  
				<p class='stName'>￥13888.00</p>   
			</a>  
-->	</div> 			   
</div>              
	</div> 
	<div id='WarnDibian' class='dibian' style='z-index:9998;'></div>
	<div id='WarnWin' class='win' style='width:300px; height:120px; margin:-60px 0 0 -150px; z-index:9999; border:1px solid #c2a76e;'>
	  <p onclick="cang('WarnDibian','WarnWin');" class='WinTitle'><span class='WinClose'>关闭</span></p>
	  <div id='WarnWord' style='padding:20px; text-align:center;'></div>
	</div>
</div>
<script>
	$(document).ready(function(){
		var ThisWarn = '';
		if(ThisWarn != ''){
			warn(ThisWarn);
		}
	});
	</script>
<!--底部-->
	<div class="toTop" title="返回顶部">返回顶部</div>
<!--<div style="clear:both; height:10px;"></div>
	<div class="clear bbsFooter" style="height:470px;">
	  <div class="helpMsg clear">
		<ul class="newUser" style="    margin-right: 90px;">               
						  <span ><img src="http://www.17lehun.com/img/WebsiteImg/MKB25827288ra.jpg" /></span>             
						  <li class="helpTitle">新手帮助</li><li><a href="http://www.17lehun.com/help.php?id=ogg22993074kh&title=%E6%B6%88%E8%B4%B9%E8%80%85%E4%BF%9D%E9%9A%9C">消费者保障</a></li><li><a href="http://www.17lehun.com/help.php?id=Yrs31706350lm&title=%E5%A6%82%E4%BD%95%E8%8E%B7%E5%BE%97%E4%B9%90%E5%B8%81">如何获得乐币</a></li><li><a href="http://www.17lehun.com/help.php?id=VHk31707026dl&title=%E5%A6%82%E4%BD%95%E6%B3%A8%E5%86%8C">如何注册</a></li></ul><ul class="newUser">               
						  <span ><img src="http://www.17lehun.com/img/WebsiteImg/FqP25827312lV.jpg" /></span>             
						  <li class="helpTitle">商家服务</li><li><a href="http://www.17lehun.com/help.php?id=uVp25822704vf&title=%E5%95%86%E5%AE%B6%E5%B8%B8%E8%A7%81%E9%97%AE%E9%A2%98">商家常见问题</a></li>
						 <li><a href='http://www.17lehun.com/seller/seRegister.php'>商家注册</a></li>
						 <li><a href='http://www.17lehun.com/seller/peRegster.php'>婚礼人注册</a></li>
						 </ul><ul class="newUser">               
						  <span ><img src="http://www.17lehun.com/img/WebsiteImg/cpN25827322ad.jpg" /></span>             
						  <li class="helpTitle">合作通道</li><li><a href="http://www.17lehun.com/help.php?id=WUF25822618kV&title=%E5%B9%BF%E5%91%8A%E6%9C%8D%E5%8A%A1">广告服务</a></li></ul><ul class="newUser">               
						  <span ><img src="http://www.17lehun.com/img/WebsiteImg/unR25827328gC.jpg" /></span>             
						  <li class="helpTitle">会员服务</li><li><a href="http://www.17lehun.com/help.php?id=DLc25822744Qu&title=%E4%BB%80%E4%B9%88%E6%98%AF%E7%A7%AF%E5%88%86%E7%9B%9F%E7%BA%A6">什么是积分盟约</a></li><li><a href="http://www.17lehun.com/help.php?id=WQJ35158855rU&title=%E4%BC%9A%E5%91%98%E6%9C%8D%E5%8A%A1%E6%9D%A1%E6%AC%BE">会员服务条款</a></li></ul>	  </div>
	  <div class="websiteMsg">
		<iframe frameborder="0" style="margin: 0px auto 0px 486px;" height="90" width="90" allowtransparency="true" scrolling="no" src='http://www.cqgseb.cn/ztgsgl/WebMonitor/GUILayer/eImgMana/gshdimg.aspx?sfdm=120160125153420414325'> </iframe>
		<a href="http://www.cqgseb.cn/ztgsgl/WebSiteMonitoring/WebUI/XFWQ/Index.aspx?xh=108"><img class="Img12315" src="http://www.17lehun.com/img/images/12315.jpg"></a>
		<div class="ftMsg"> <p>重庆婚众网络科技有限公司 邮箱：17lehun@17lehun.com
</p><p>店铺入驻、广告合作请联系：QQ1005491643
</p><p>Copyright&amp;copy;2015 www.17lehun.com All Rights Reserved  渝ICP备15008796号-1   未经许可 不得抄袭本站图片和内容</p> </div>
	  </div>
	  <!--底部网站认证标志结束-->
	<!--</div>
</div>
<!--底部信息结束-->
<!--</body></html>-->      
<?php echo warn().ThisFooter();?>    