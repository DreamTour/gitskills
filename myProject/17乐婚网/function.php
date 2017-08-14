<?php
include dirname(dirname(__FILE__))."/control/ku/configure.php";
/*-----------如果是移动设备，则跳转到手机网站首页--------------------------------------------------------------------------------------------------------*/
if(isMobile()){
    if(strstr($_SERVER['PHP_SELF'],"suopiao.php")!==false){
        header("Location:{$mroot}mActive.php");
    }else{
        header("Location:{$mroot}mindex.php");
    }
    exit(0);//必不可少，$warn在底部会被执行清理
}
/*----------------------------------------渐变通栏banner-----------------------------------------------------------------------------------------------*/
function banner(){
    $second = website("sjkldus4") * 1000;
	$html = "
	<div style='overflow:hidden;'>
		<div class='banner'>
			<ul class='BannerZ'>
	";
	//组合图片
	$ImgSql = mysql_query(" select * from img where type = '广告位' and imgname = 'banner' order by list limit 5 ");
	$x = 0;
	while($Img = mysql_fetch_array($ImgSql)){
		if(!empty($Img['imgsrc'])){
			$html .= "<a target='_blank' href='{$Img['url']}'><li><img src='{$GLOBALS['root']}{$Img['imgsrc']}'></li></a>";
			$x++;
		}
	}
	//组合控制器
	$i = 1;
	$BaCon = "";
	while($i <= $x){
	    if($i == 1){
		    $white = " class='white' ";
		}else{
		    $white = "";
		}
		$BaCon .= "<li {$white}>●</li>";
		$i++;
	}
	$html .= "
			</ul>
			<div class='BannerControl'><ul>{$BaCon}</ul></div>
		</div>
	</div>
	<script>
	$(document).ready(function(){
		setInterval(BannerChange,{$second}); 
		$('.BannerControl ul li').click(function(){
			var a = $(this).index();
			BannerFun(a);
		});
		
	});
	var x=0; 
	function BannerChange(){
		var length = $('.BannerZ li').length-1;
		if(x==length){
			x=0;
		}else{
			x+=1;
		} 
		BannerFun(x);
	}
	function BannerFun(a){
		var index = $('.BannerControl ul li.white').index();
		$('.BannerZ li').css({'z-index':'100'});
		$('.BannerZ li:eq('+index+')').css({'z-index':'140'});
		$('.BannerZ li:eq('+a+')').hide();
		$('.BannerZ li:eq('+a+')').css({'z-index':'150'});
		$('.BannerZ li:eq('+a+')').fadeIn(2000);
		$('.BannerControl ul li:eq('+index+')').removeClass('white');
		$('.BannerControl ul li:eq('+a+')').addClass('white');
	}
	</script>
	";
	return $html;
}
/*----------------------------------------通用banner---------------------------------------------------------------------------------------------------*/
function BannerCurrency($width,$height,$img,$imgurl,$warn){
$ControlLeft = $width/2-40;
$ControlTop = $height/2-24;
$ImgNum = count($img);
if($ImgNum > 0 and $img != ""){
    $ThisImg = "<ul class='BannerImg'>";
    for($x=0;$x<$ImgNum;$x++){
        $ThisImg .= "<li><a target='_blank' href='".$imgurl[$x]."'><img src='".$img[$x]."'></a></li>";
        $ControlCircle .= "<li BannerControlShow='no'>●</li>";
    }
    $ThisImg .= "
                </ul>
                <div class='BannerControl'>
                    <ul>{$ControlCircle}</ul>
                </div>
                <img class='BannerLeftControl'  src='{$globals[root]}img/images/BannerLeftControl.png'>
                <img class='BannerRightControl' src='{$globals[root]}img/images/BannerRightControl.png'>
                ";
}else{
    $ThisImg = "<p class='BannerWarn'>{$warn}</p>";
}
?>
<style>
.BannerDiv{ position:relative; width:<?php echo $width;?>px; height:<?php echo $height;?>px; background-color:#ccc; overflow:hidden;}
.BannerWarn{ line-height:<?php echo $height;?>px; color:#888; font-size:36px; text-align:center;}
.BannerImg{ width:<?php echo $ImgNum;?>00%;}
.BannerImg li{ float:left; cursor:pointer;}
.BannerImg li img{display:block; width:<?php echo $width;?>px; height:<?php echo $height;?>px;}
.BannerControl{ width:80px; height:20px; position:absolute; bottom:20px; left:<?php echo $ControlLeft;?>px;}
.BannerControl ul li{ width:20px; height:20px; float:left; margin:0 2px 0 2px; color:#857958; cursor:pointer; font-size:30px; text-align:center;}
.BannerLeftControl{ position:absolute; cursor:pointer; width:29px; height:48px; left:10px; top:<?php echo $ControlTop;?>px;}
.BannerRightControl{ position:absolute; cursor:pointer; width:29px; height:48px; right:10px; top:<?php echo $ControlTop;?>px;}
</style>
<div style="overflow:hidden;">
  <div class="BannerDiv">
    <?php  echo $ThisImg;?>
  </div>
</div>
<script>
$(document).ready(function(){
    ImgChange(0);//初始化banner
    //鼠标点击小按钮时
    $(".BannerControl li").click(function(){
        var a = $(this).index();
        ImgChange(a);
    });
    //鼠标点击左侧按钮时
    $(".BannerLeftControl").click(function(){
        var a = $("[BannerControlShow=yes]").index();
        if(a > 0){
            var x = a - 1;
            ImgChange(x);
        }
    });
    //鼠标点击右侧按钮时
    $(".BannerRightControl").click(function(){
        var a = $("[BannerControlShow=yes]").index();
        var length = $(".BannerImg li").length-1;
        if(a < length){
            var x = a + 1;
            ImgChange(x);
        }
    });
});
//定时切换
setInterval(BannerChange,10000);
//定时切换函数
var x=0;
function BannerChange(){
    var length = $(".BannerImg li").length-1;
    if(x==length){
        x=0;
    }else{
        x+=1;
    }
    ImgChange(x);
}
function ImgChange(a){
    //修正当前效果
    $(".BannerImg").animate({"marginLeft":-1200*a+"px"},1000);
    $(".BannerControl li").css({"color":"#857958"});
    $(".BannerControl li").attr({"BannerControlShow":"no"});
    $(".BannerControl li:eq("+a+")").css({"color":"#0f4700"});
    $(".BannerControl li:eq("+a+")").attr({"BannerControlShow":"yes"});
}
</script>
<?php
}
function bbsLBan(){
?>
<div class='leftBanner'>
	<h3> <a href='<?php echo $GLOBALS['root'];?>forum/forum.php'>全部</a></h3>
	<?php
	$TypeOneQuery =mysql_query("select * from ForumTypeOne where id in('NUh25033822tE','sbo25033883dr')");
	while($TypeOneResult =mysql_fetch_array($TypeOneQuery)){
		 echo "<dl class='postClass'>
				<dt><a href='javascript:;' class='pTypeOne' style='color:#fff;'>$TypeOneResult[name]</a>
				</dt>
			  ";
		 $TypeTwoQuery =mysql_query("select * from ForumTypeTwo where ForumTypeOneId ='$TypeOneResult[id]' ");
		 while($TypeTwoResult =mysql_fetch_array($TypeTwoQuery)){
			if($_GET['TypeTwo'] == $TypeTwoResult['id']){
				$cur = "cur";
			}else{
				$cur = "";
			}
			echo "
			<dd><a href='{$GLOBALS['root']}forum/forum.php?TypeOne=$TypeOneResult[id]&TypeTwo=$TypeTwoResult[id]' class='pTypeTwo {$cur}'>$TypeTwoResult[name]</a></dd>";
		 }
		 echo "</dl>";
	}
	$TypeOneQuery =mysql_query("select * from ForumTypeOne where id not in('NUh25033822tE','sbo25033883dr')");
	while($TypeOneResult =mysql_fetch_array($TypeOneQuery)){
		 echo "
			   <dl class='postClass'>
			   <dt><a href='javascript:;' class='pTypeOne' style='color:#fff;'>$TypeOneResult[name]</a></dt>
			  ";
		 $TypeTwoQuery =mysql_query("select * from ForumTypeTwo where ForumTypeOneId ='$TypeOneResult[id]' ");
		 while($TypeTwoResult =mysql_fetch_array($TypeTwoQuery)){
			if($_GET['TypeTwo'] == $TypeTwoResult['id']){
				$cur = "cur";
			}else{
				$cur = "";
			}
			echo "<dd><a href='{$GLOBALS['root']}forum/forum.php?TypeOne=$TypeOneResult[id]&TypeTwo=$TypeTwoResult[id]' class='pTypeTwo {$cur}'>$TypeTwoResult[name]</a></dd>";
		 }
		 echo "</dl>";
	}
    ?>
</div>
<?php
}
/*-----------------------------------网站前端头部---------------------------------------------------------------------------------------------------------------------------------*/
function ThisHeader(){
//修正顶部搜索词
if(isset($_SESSION['SearchStore']['Brand']) and $_SESSION['SearchStore']['Brand'] != ""){
    $HeaderSearch = $_SESSION['SearchStore']['Brand'];
}else{
    $HeaderSearch = website("a32468asdfasdf");
}
//根据客户登录情况显示登录注册或用户中心
if($GLOBALS['KehuFinger'] == 1){
    if($GLOBALS['kehu']['nickname'] == ""){
        $ShowName = $GLOBALS['kehu']['khname'];
    }else{                     
        $ShowName = $GLOBALS['kehu']['nickname'];
    }
    $MenuLogin = "
        <a href='{$GLOBALS['root']}user/user.php'>个人中心</a>&nbsp;&nbsp;<span class='MenuVerticalLine'>|</span>&nbsp;&nbsp;
        {$ShowName}&nbsp;&nbsp;<span class='MenuVerticalLine'>|</span>&nbsp;&nbsp;
        <a style='color:#f17a56;' href='{$GLOBALS['root']}index.php?Delete=user'>注销</a>&nbsp;&nbsp;<span class='MenuVerticalLine'>|</span>&nbsp;&nbsp;
    ";
}else{
    $MenuLogin = "
        <a href='{$GLOBALS['root']}user/usRegister.php'>注册</a>&nbsp;&nbsp;<span class='MenuVerticalLine'>|</span>&nbsp;&nbsp;
        <a href='{$GLOBALS['root']}user/uslogin.php'>登录</a>&nbsp;&nbsp;<span class='MenuVerticalLine'>|</span>&nbsp;&nbsp;
    ";
}
?>
<!--顶部引导信息开始-->
<div class="MenuTop">
	<div class="column center">
		<span class="FloatLeft">关注我们</span>
		<?php echo website("asdf3564a68dw");?>
		<span class="FloatRight"><?php echo $MenuLogin;?><a href="<?php ro();?>seller/selogin.php">商家入驻</a></span>
	</div>
</div>
<!--顶部引导信息结束--> 
<!--logo和搜索行开始-->
<div class="column padding" style="width:1180px;"> <a href="<?php ro();?>"><img class="logo" src="<?php echo img("e654s3");?>"></a> <a target="_blank" href="<?php echo "{$GLOBALS['root']}suopiao.php";?>"><img class="AdvertisementTop" src="<?php echo img("d87s57124a");?>"></a>
  <div class="HeaderSearchDiv">
    <div class="HeaderSearchKuang clear">
      <form name="SearchForm" id="SearchForm" action="<?php echo "{$GLOBALS['root']}library/PcPost.php";?>" method="post">
        <input name="SearchStoreBrandList" type="text" id="KeyWords" class="HeaderSearchText" placeholder="<?php echo $HeaderSearch;?>">
        <input name="SellerType" type="hidden" value="all">
        <img class="HeaderSearchImg" id="SearchImg" src="<?php echo "{$GLOBALS['root']}img/images/search.jpg";?>" />
      </form>
    </div>
    <p class="smallword" style="padding-bottom:10px;">
      <?php                     
        $SearchRecommendSql = explode("【文字】",website("asdf75ws"));                     
        $length=count($SearchRecommendSql);                     
        for($x=1;$x<$length;$x++){                     
            $SearchRecommend = explode("【超链接】",$SearchRecommendSql[$x]);                     
            echo "<a href='{$SearchRecommend[1]}'>{$SearchRecommend[0]}</a>&nbsp;&nbsp;";                     
        }                     
        ?>
    </p>
  </div>
  <div class="clear"></div>
</div>
<!--logo和搜索结束--> 
<!--导航栏开始-->
<div class="MenuColumn">
  <div class="column">
    <ul class="Menu">
      <a href="<?php ro();?>">
      <li>首页</li>
      </a>
      <?php                   
            $TypeOneSql = mysql_query("select * from TypeOne order by list");                   
            while($TypeOne = mysql_fetch_array($TypeOneSql)){                   
                echo "<a href='{$GLOBALS['root']}goods.php?TypeOne={$TypeOne['id']}'><li class='".MenuGet("TypeOne",$TypeOne['id'],"MenuHover")."'>{$TypeOne['name']}</li></a>";                   
            }                   
            ?>
      <a href="<?php echo "{$GLOBALS['root']}forum/showReview.php";?>">
      	<li class="<?php echo menu("showReview.php","MenuHover");?>">用户点评</li>
      </a> 
      <a href="<?php echo "{$GLOBALS['root']}forum/forum.php";?>">
      	<li class="<?php echo menu("forum.php","MenuHover");?>">社区论坛</li>
      </a> 
      <a href="<?php echo "{$GLOBALS['root']}forum/coupons.php";?>">
      	<li class="<?php echo menu("coupons.php","MenuHover");?>">现金券</li>
      </a> 
      <a href="<?php echo "{$GLOBALS['root']}IndividualBus.php"?>">
      	<li class="<?php echo menu("IndividualBus.php","MenuHover")?>">婚礼人</li>
      </a> 
      <a href="<?php echo "{$GLOBALS['root']}Mall.php"?>">
      	<li class="<?php echo menu("Mall","MenuHover")?>">积分商城</li>
      </a>
    </ul>
  </div>
  <div class="clear"></div>
</div>
<!--导航栏结束-->
<?php    
echo floatWinImg();                    
}                     
/*---------------------------------------网站前端底部------------------------------------------------------------------------------------------------------------------------------*/                     
function ThisFooter(){                     
?>
<div class="toTop" title="返回顶部">返回顶部</div>
<div style="clear:both; height:10px;"></div>
	<div class="clear bbsFooter">
	  <div class="helpMsg clear">
		<?php               
			  $helpTitleSql = mysql_query("select DISTINCT classify from content where type = '帮助中心' ");              
			  while($helpTitle = mysql_fetch_array($helpTitleSql)){              
				 $ImgQuery = query("img"," type = '底部footer小图标' and imgname = '$helpTitle[classify]' ");             
				 echo "<ul class=\"newUser\">               
						  <span ><img src=\"{$GLOBALS['root']}{$ImgQuery['imgsrc']}\" /></span>             
						  <li class=\"helpTitle\">{$helpTitle['classify']}</li>";              
				 $helpTileTypeTwoSql = mysql_query("select * from content where type = '帮助中心' and classify = '$helpTitle[classify]' ");              
				 while($helpTileTypeTwo = mysql_fetch_array($helpTileTypeTwoSql)){              
					 echo "<li><a href=\"{$GLOBALS['root']}help.php?id={$helpTileTypeTwo['id']}&title=".urlencode($helpTileTypeTwo['title'])."\">{$helpTileTypeTwo['title']}</a></li>";
					 if($helpTitle['classify'] == "商家服务"){
						 echo "
						 <li><a href='{$GLOBALS['root']}seller/seRegister.php'>商家注册</a></li>
						 <li><a href='{$GLOBALS['root']}seller/peRegster.php'>婚礼人注册</a></li>
						 ";
					 }
				 }              
				 echo "</ul>";              
			  }              
			?>
	  </div>
	  <div class="websiteMsg">
		<iframe frameborder="0" style="margin: 0px auto 0px 486px;" height="90" width="90" allowtransparency="true" scrolling="no" src='http://www.cqgseb.cn/ztgsgl/WebMonitor/GUILayer/eImgMana/gshdimg.aspx?sfdm=120160125153420414325'> </iframe>
		<a href="http://www.cqgseb.cn/ztgsgl/WebSiteMonitoring/WebUI/XFWQ/Index.aspx?xh=108"><img class="Img12315" src="<?php echo root."img/images/12315.jpg";?>"></a>
		<div class="ftMsg"> <?php echo "<p>".neirong(website("uisjue410q"))."</p>";?> </div>
	  </div>
	  <!--底部网站认证标志结束-->
	</div>
</div>
<!--底部信息结束-->
</body></html>
<?php                     
}                     
/*--------------------------------商家导航栏---------------------------------------------------------------------------------------------------------------------------------------*/                     
function SellerMenu(){                     
?>
<div class="SellerLeft">
  <div class="SellerLeftTitle">
    <p class="SellerLeftTitleP">商户管理后台</p>
  </div>
  <ul class="SellerLeftUl">
    <li class="must"><img src="<?php ro();?>img/images/PersonalData.png">商户信息</li>
    <li class="<?php echo menu("seller.php","SellerMenuNow");?>"><a href="<?php sero();?>seller.php">我的资料</a></li>
    <li class="<?php echo menu("record.php","SellerMenuNow");?>"><a href="<?php sero();?>record.php">账户记录</a></li>
    <li class="<?php echo menu("sepas.php","SellerMenuNow");?>"><a href="<?php sero();?>sepas.php">修改密码</a></li>
    <li><a href="<?php ro();?>index.php?Delete=seller">注销登录</a></li>
    <li class="must"><img src="<?php ro();?>img/images/store.png">店铺管理</li>
    <li class="<?php echo menu("segoods","SellerMenuNow");?>"><a href="<?php sero();?>segoods.php">发布商品</a></li>
    <li class="<?php echo menu("seDecorate","SellerMenuNow");?>"><a href="<?php sero();?>seDecorate.php">店铺装修</a></li>
    <li class="<?php echo menu("seAlbum","SellerMenuNow");?>"><a href="<?php sero();?>seAlbum.php">店铺相册</a></li>
    <li class="<?php echo menu("SeSalesPromotion","SellerMenuNow");?>"><a href="<?php sero();?>SeSalesPromotion.php">最新活动</a></li>
    <!--<li class="<?php echo menu("secompetition","SellerMenuNow");?>"><a href="<?php sero();?>secompetition.php">参加竞价</a></li>-->
    <li><a target='_blank' href="<?php echo "{$GLOBALS['root']}store.php?seller={$GLOBALS['Seller']['seid']}";?>">店铺预览</a></li>
    <li class="must"><img src="<?php ro();?>img/images/MoneyIco.png">现金券管理</li>
    <li class="<?php echo menu("seCoupons.php","SellerMenuNow");?>"><a href="<?php sero();?>seCoupons.php">添加现金券</a></li>
    <li class="<?php echo menu("adCouponsDetails.php","SellerMenuNow");?>"><a href="<?php sero();?>adCouponsDetails.php">现金券详情</a></li>
    <li class="<?php echo menu("CouponsCondition.php","SellerMenuNow");?>"><a href="<?php sero();?>CouponsCondition.php">领取情况</a></li>
  </ul>
</div>
<?php                     
}                     
/*--------------------------------客户导航栏---------------------------------------------------------------------------------------------------------------------------------------*/                     
function UserMenu(){                     
?>
<style>                     
.SellerLeft{ width:160px; float:left; margin:10px auto auto auto; background-color:#e9e9e9; padding:10px 0 20px 30px;}                     
.SellerLeftTitle{ padding:0 10px 0 0; margin:auto auto 10px auto;}                     
.SellerLeftTitleP{ border-bottom:1px solid #fff; line-height:40px;}                     
.SellerLeftUl li{ padding:4px 4px 4px 10px; font-size:14px}                     
.SellerLeftUl li img{ margin:auto 6px auto -24px;}                     
.SellerMenuNow{ background-color:#f8f8f8; color:#ff0000;}                     
</style>
<div class="SellerLeft">
  <div class="SellerLeftTitle">
    <p class="SellerLeftTitleP">用户中心</p>
  </div>
  <ul class="SellerLeftUl">
    <li class="must"><img src="<?php ro();?>img/images/PersonalData.png">用户信息</li>
    <li class="<?php echo menu("user.php","SellerMenuNow");?>"><a href="<?php usro();?>user.php">我的资料</a></li>
    <li class="<?php echo menu("uspas.php","SellerMenuNow");?>"><a href="<?php usro();?>uspas.php">修改密码</a></li>
    <li><a href="<?php ro();?>index.php?Delete=user">注销登录</a></li>
    <li class="must"><img src="<?php ro();?>img/images/text.png">账户管理</li>
    <li class="<?php echo MenuGet("type","integrate","SellerMenuNow");?>"><a href="<?php usro();?>KhRecord.php?type=integrate">积分记录</a></li>
    <li class="<?php echo MenuGet("type","money","SellerMenuNow");?>"><a href="<?php usro();?>KhRecord.php?type=money">账户乐币</a></li>
    <li class="<?php echo menu("order.php","SellerMenuNow");?>"><a href="<?php usro();?>order.php">乐币换购</a></li>
    <li class="must"><img src="<?php ro();?>img/images/MoneyIco.png">定单管理</li>
    <li class="<?php echo menu("appointment.php","SellerMenuNow");?>"><a href="<?php usro();?>appointment.php">我的预约</a></li>
    <li class="<?php echo menu("Exhibition.php","SellerMenuNow");?>"><a href="<?php usro();?>Exhibition.php">婚博会定单</a></li>
    <li class="<?php echo menu("collect.php","SellerMenuNow");?>"><a href="<?php usro();?>collect.php">店铺收藏</a></li>
    <li class="<?php echo menu("MyCoupons.php","SellerMenuNow");?>"><a href="<?php usro();?>MyCoupons.php">现金券管理</a></li>
    <li class="must"><img src="<?php ro();?>img/images/talk.png">我的论坛</li>
    <li class="<?php echo menu("MyForum.php","SellerMenuNow");?>"><a href="<?php usro();?>MyForum.php">我的帖子</a></li>
    <li class="<?php echo menu("MyReplyForum.php","SellerMenuNow");?>"><a href="<?php usro();?>MyReplyForum.php">我的回复</a></li>
    <li class="<?php echo menu("usComment.php","SellerMenuNow");?>"><a href="<?php usro();?>usComment.php">我的点评</a></li>
  </ul>
</div>
<?php                     
}                     
/*--------------------------------上传单张图片-------------------------------------------------------------------------------------------------------------------------------------*/                     
/*                     
$title为表格标题，$remark为备注，$UploadImgName为上传文件名，$action为php处理页地址，$img为需要显示的图片，$InputName为扩展参数，$ThisUrl为当前页面地址                     
*/                     
function TableSubmitImg($title,$remark,$UploadImgName,$action,$img,$InputName){                     
    return "                     
    <div class='SellerRight'>                     
        <p>                     
            <img src='{$GLOBALS['root']}img/images/img.png'>                     
            {$title}                     
            <span class='FloatRight smallword'>{$remark}</span>                     
        </p>                     
        <form name='{$UploadImgName}Form' action='{$action}' method='post' enctype='multipart/form-data'>                     
        <table class='TableRight'>                     
            <tr>                     
                <td>上传效果：</td>                     
                <td>{$img}</td>                     
            </tr>                     
            <tr>                     
                <td>本地上传：</td>                     
                <td><input name='{$UploadImgName}' type='file'></td>                     
            </tr>                     
            {$InputName}                     
            <tr>                     
                <td></td>                     
                <td><input type='submit' class='button' value='上传'></td>                     
            </tr>                     
        </table>                     
        </form>                     
    </div>                     
    ";                     
}                     
/*--------------------------------商户店铺基本资料查询------------------------------------------------------------------------------------------------------------------------------*/                     
function StoreID(){                     
    if($GLOBALS['seller'] = query("seller"," seid = '$_GET[seller]' ")){                     
    }else{                     
        header("Location:{$GLOBALS['root']}");                     
        $_SESSION['warn'] = "您要找的店铺不存在";                     
        exit(0);                     
    }                     
}                     
/*--------------------------------商户店铺抬头-------------------------------------------------------------------------------------------------------------------------------------*/                     
function StoreHead($seller){                   
$TypeOne = query("TypeOne"," id = '$seller[TypeOneId]' ");      
$avgscore = mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid = '$seller[seid]' and status = '已通过' "));     
$score =(double)substr($avgscore[0],0,3);                  
//修正商户品牌输出                     
if($seller['Brand'] == ""){                     
    $SellerBrand = $seller['name'];                     
}else{                     
    $SellerBrand = $seller['Brand'];                     
}
if($seller['type'] == "个人商户"){
	$StoreOrderButton = "档期查询";
	$CollectStore = "<div class='StoreOrderButton'>我要预订</div>";
	$PersonalPrice = "<div class='PersonalPrice'>价格：￥{$seller['price']}</div>";
	$PetypeSpan = "<span class='StorePe'>{$seller['Petype']}</span>&nbsp;";
	$OnionSkin = "
	<a href='".root."IndividualBus.php'>婚礼人</a>&nbsp;>&nbsp;
	<a href='".root."IndividualBus.php?type={$seller['Petype']}'>{$seller['Petype']}</a>&nbsp;>&nbsp;
	";
}else{
	$StoreOrderButton = "预约到店";
	$CollectStore = "<div id='CollectStore' class='StoreOrderButton'>收藏本店</div>";
	$OnionSkin = "
	<a href='".root."goods.php?TypeOne={$TypeOne['id']}'>{$TypeOne['name']}</a>&nbsp;>&nbsp;
	<a href='".root."StoreList.php?TypeOne={$TypeOne['id']}'>更多商铺</a>&nbsp;>&nbsp;
	";
}
?>
<div class="kuang"> 
  <!--洋葱皮开始-->
  <p class="smallword">
	  当前位置：<a href="<?php ro();?>">首页</a>&nbsp;>&nbsp;
	  <?php echo $OnionSkin;?>
	  <a href="<?php echo root."store.php?seller=".$seller['seid'];?>"><?php echo $SellerBrand;?></a>
  </p>
  <!--洋葱皮结束--> 
</div>
<div class="kuang"> 
  <!--顶部面板开始-->
  <div class="StoreTop"> 
    <!--左边橱窗开始-->
    <div class="Storewindow"> <img class="StorewindowBig" src="<?php echo ListImg($seller['logo']);?>"> </div>
    <!--左边橱窗结束--> 
    <!--右边店铺参数开始-->
    <div class="StoreParameter">
      <p class="StoreParameterTitle">
         <?php
		 echo $SellerBrand.$PetypeSpan;
		 if($seller['authentication'] == "已认证"){
			 if($seller['type'] == "个人商户"){
			     echo "<img class='IDCard' src='".root."img/images/IDCard.png'>";
			 }else{
				 echo "<i style='background-position: 0px -22px;' class='authOwner' title='已认证'></i>";
			 }
		 }
		 $SeComment = query("secomment"," commenttargetid = '$seller[seid]' and status = '已通过' ");
		 if($SeComment['secommentid'] !=""){
			 echo "<i style='background-position: 0px -63px;' class='remarkedSeller' title='有评商户'></i>";
		 }
		 $Coupon = query("coupon"," coupontargetid = '$seller[seid]' ");
		 if($Coupon['couponid'] !="" and $seller['CashCoupon'] == "开通"){
			 echo "<i style='background-position: 0px -43px;' class='couponsOwner' title='现金券'></i> ";
			 $CouponMenu = "<li class='".menu("singleCoupon.php","StoreMenuHover")."'><a href='{$GLOBALS['root']}forum/singleCoupon.php?seid={$seller[seid]}' target='_blank'>现金券</a></li>";
		 }
		 if($seller['Guarantee'] != "关闭" and $seller['Guarantee'] != ""){
			 echo "<i style='background-position: 0px -1px;' class='couponsSafe' title='消费保障'></i>";
		 }
		 if($seller['League'] == "开"){
			 echo "<i style='background-position: -2px -84px' class='couponsSafe' title='积分盟约'></i>";
		 }
		 ?>
        <span style=" font-size:12px; float:right; font-weight:100;">人气指数：<?php echo (100 + $seller['PageView']);?></span>
      <div class="stScoreShow">
        <div class="dimStar" style="left: 19px;"> <i class='greyFive'></i> <i class='yellowFive' style='width: <?php echo $score*15;?>px;'></i> </div>
        <b style="font-size: 13px; position: relative; top: -4px; left: 14px;"><?php echo $score;?>分</b> </div>
      </p>
      <div class="kuang smallword">
        <?php                     
		if($seller['summary'] == ""){                     
			echo "暂无店铺简介";                     
		}else{                     
			echo $seller['summary'];                     
		}                     
		?>
      </div>
      <div id="GoodsOrderButtonId" class="StoreOrderButton"><?php echo $StoreOrderButton;?></div>
      <?php echo $CollectStore.$PersonalPrice;?>
      <div class="clear"></div>
      <div style="margin:20px 0 0 0;"> 店铺标签：
        <?php    
		if($seller['label'] !=""){   
			$ThisLabel = explode("，",$seller['label']);                   
			$length = count($ThisLabel);                     
			for($x=0;$x<$length;$x++){                     
				echo "<span class='SpanButton'>{$ThisLabel[$x]}</span>";
			}
		}else{   
			echo "无";
		}
		?>
      </div>
    </div>
    <!--右边店铺参数结束-->
    <div class="clear"></div>
  </div>
  <!--顶部面板结束--> 
  <!--导航条开始-->
  <div class="StoreMenu">
    <ul>
      <li class="<?php echo menu("store.php","StoreMenuHover");?>"><a href="<?php echo "{$GLOBALS['root']}store.php?seller={$seller[seid]}";?>">店铺首页</a></li>
      <li class="<?php echo menu("StoreGoods.php","StoreMenuHover");?>"><a href="<?php echo "{$GLOBALS['root']}StoreGoods.php?seller={$seller[seid]}";?>">商品列表</a></li>
      <li class="<?php echo menu("album.php","StoreMenuHover");?>"><a href="<?php echo "{$GLOBALS['root']}album.php?seller={$seller[seid]}";?>">相册列表</a></li>
      <li class="<?php echo menu("Suona.php","StoreMenuHover");?>"><a href="<?php echo "{$GLOBALS['root']}Suona.php?seller={$seller[seid]}";?>">最新活动</a></li>
      <li><a href="<?php echo "{$GLOBALS['root']}forum/forum.php" ?>" target="_blank">社区</a></li>
      <li class="<?php echo menu("reviewsC.php","StoreMenuHover");?>"><a href="<?php echo "{$GLOBALS['root']}forum/reviewsC.php?seller={$seller[seid]}" ?>" target="_blank">用户点评</a></li>
      <?php echo $CouponMenu;?>
    </ul>
    <div class="clear"></div>
  </div>
  <!--导航条结束--> 
</div>
<script>                     
$(document).ready(function(){                     
    $("#CollectStore").click(function(){                     
        var KehuFinger = "<?php echo $GLOBALS['KehuFinger'];?>";                     
        if(KehuFinger == 1){                     
            $.post("<?php ro();?>library/PcData.php",{CollectStoreId:"<?php echo $seller['seid'];?>"},                     
            function(data){                     
                warn(data);                     
            });                     
        }else{                     
            warn("<a target='_blank' href='<?php ro();?>user/user.php'>您未登录，请登录</a>");                     
        }                     
    });                     
});                     
</script>
<?php                     
OrderPage($seller['name'],$seller['seid'],$GLOBALS['ThisUrl']);                     
}                     
/*--------------------------------预约到店弹出层--------------------------------------------------------------------------------------------------------------------------------*/                     
function OrderPage($StoreName,$StoreId,$ThisUrl){                     
?>
<div id="OrderPageDibian" class="dibian"></div>
<div id="OrderPageWin" class="win" style="width:600px; height:500px; margin:-300px 0 0 -250px;border-radius:5px;">
  <div onclick="cang('OrderPageDibian','OrderPageWin');" class="WinTitle"                     
        style="background-color:#f85451;border-radius:5px 5px 0 0; font-size:20px; color:#fff; height:60px; line-height:60px;padding: 0 10px 0 10px;"> 预约到店 <span class="WinClose">关闭</span> </div>
  <div style="padding:20px; border:1px solid #f85451; margin:20px; position:relative;">
    <div style="position:absolute; top:-14px; left:100px; font-size:18px; background-color:#fff; padding:0 10px 0 10px; color:#f85451;">预约信息</div>
    <p class="smallword">您正在预约：<?php echo $StoreName;?></p>
  </div>
  <form name="OrderPageForm" action="<?php ro();?>library/PcPost.php" method="post">
    <table class="OrderPageTable">
      <tr>
        <td><span class="must">*</span>&nbsp;预约人：</td>
        <td><input name="OrderPageName" type="text" class="text" value="<?php echo $GLOBALS['kehu']['khname'];?>"></td>
      </tr>
      <tr>
        <td><span class="must">*</span>&nbsp;手机号：</td>
        <td><input name="OrderPageTel" type="text" class="text" value="<?php echo $GLOBALS['kehu']['khtel'];?>"></td>
      </tr>
      <tr>
        <td></td>
        <td><input id="OrderPageAcquire" type="button" value="获取手机验证码"></td>
      </tr>
      <tr>
        <td><span class="must">*</span>&nbsp;验证码：</td>
        <td><input name="OrderPageProve" type="text" class="text"></td>
      </tr>
      <tr>
        <td><span class="must">*</span>&nbsp;到店日：</td>
        <td><?php echo year("year","OrderPageSelect").moon("moon","OrderPageSelect").day("day","OrderPageSelect");?></td>
      </tr>
      <tr>
        <td>QQ号：</td>
        <td><input name="OrderPageQQ" type="text" class="text" value="<?php echo $GLOBALS['kehu']['khqq'];?>"></td>
      </tr>
      <tr>
        <td>提示信息：</td>
        <td class="must" id="OrderPageWarn">暂无提示信息</td>
      </tr>
      <tr>
        <td><input name="OrderPageStoreId" type="hidden" class="text" value="<?php echo $StoreId;?>"></td>
        <td><div onclick="OrderPageSubmit()" class="OrderPageButton">预约</div></td>
      </tr>
    </table>
    <input name="GoodsId" type="hidden" value="<?php echo $_GET['goods'];?>">
    <input name="ThisUrl" type="hidden" value="<?php echo $ThisUrl;?>">
  </form>
</div>
<script>                     
<?php                     
KongSele(date("Y"),"OrderPageForm.year");                     
KongSele(date("m"),"OrderPageForm.moon");                     
KongSele(date("d"),"OrderPageForm.day");                     
?>                     
function OrderPageSubmit(){                     
    if(document.OrderPageForm.OrderPageName.value.length == 0){                     
        $("#OrderPageWarn").text("请输入预约人姓名");                     
        document.OrderPageForm.OrderPageName.focus();                     
    }else if(document.OrderPageForm.OrderPageTel.value.length == 0){                     
        $("#OrderPageWarn").text("请输入手机号码");                     
        document.OrderPageForm.OrderPageTel.focus();                     
    }else if(!(<?php echo $GLOBALS['CheckTel'];?>.test(document.OrderPageForm.OrderPageTel.value))){                     
        $("#OrderPageWarn").text("手机号码输入错误");                     
        document.OrderPageForm.OrderPageTel.focus();                     
    }else if(document.OrderPageForm.OrderPageProve.value.length == 0){                     
        $("#OrderPageWarn").text("请输入手机验证码");                     
        document.OrderPageForm.OrderPageProve.focus();                     
    }else{                     
        document.OrderPageForm.submit();                     
    }                     
}                     
$(document).ready(function(){                     
    /*--------------------客户点击预约按钮时检查是否登录，如果登录，则弹出预约窗口，如果未登录，则提示登录，客户点击提示按钮时新建登录页面-----------------------------------------------*/                     
    $("#GoodsOrderButtonId").click(function(){                     
        xian("OrderPageDibian","OrderPageWin");                     
    });                     
    /*--------------------手机验证码-----------------------------------------------*/                     
    $("#OrderPageAcquire").click(function(){                     
        var RegisterCheckTel = document.OrderPageForm.OrderPageTel.value;                     
        $.post("<?php ro();?>library/PcData.php",{RegisterCheckTel:RegisterCheckTel},                     
        function(data){                     
            warn(data);                     
        });                     
    });                     
});                     
</script>
<?php                     
}                   
/*-------------------------------引入背景图片----------------------------------------------------------------------*/                
function insertBackUrl(){                
    $img = img("atV26859109xJ");//认证、现金券、保障、已评图标                     
    $img3 = img("fBf25833856Qo");//现金券箭头                 
    $img4 = img("vdC25837108dQ");//进入店铺              
    return "                
        <style>                
            .authOwner{        
                background:url({$img}) no-repeat scroll 0px -20px / 70% auto;        
            }        
            .remarkedSeller{        
                background:url({$img}) no-repeat scroll 0px -61px / 70% auto;        
            }        
            .couponsSafe{        
                background:url({$img}) no-repeat scroll 0px -1px / 70% auto;        
            }
            .couponsLeague{        
                background:url({$img}) no-repeat scroll 0px -41px / 70% auto;        
            }
            .couponsOwner{        
                background:url({$img}) no-repeat scroll 0px -41px / 70% auto;        
            }        
            .redNrow{             
                background:url({$img3}) no-repeat scroll 0px 0px;               
            }             
            b.enterstore{             
                background:url({$img4}) no-repeat scroll 0px 0px;              
            }              
            .advan{             
                background:url('".img("eBz26070160kz")."') no-repeat scroll  -854px -441px;             
            }             
            .disadvan{             
                background:url('".img("eBz26070160kz")."') no-repeat scroll  -854px -407px;             
            }             
            .asse{             
                background:url('".img("eBz26070160kz")."') no-repeat scroll  -854px -372px;             
            }             
            .shv-btn{             
                background:#fff url('".img("DVP26076609eV")."') no-repeat scroll 0px 4px;             
            }             
            .forword{             
                background:url('".img("BOc26077081Ta")."') no-repeat scroll 9px 6px;             
            }             
            .jifen{            
                background:url('".img("zym26173158JF")."') no-repeat scroll 0px -4px;             
            }            
            .yue{            
                background:url('".img("hsJ26173162EL")."') no-repeat scroll 0px -9px;             
            }            
            .dengji{            
                background:url('".img("PFI26173165bL")."') no-repeat scroll;             
            }            
            .addBlockOne{            
                background:url('".img("uSU26181999bU")."') no-repeat scroll;            
            }            
            .addBlockTwo{            
                background:url('".img("OrW26175970rp")."') no-repeat scroll;            
            }            
            .jinghua{            
                background:url('".img("xFo26183792Vs")."') no-repeat scroll;            
            }            
            .zhiding{            
                background:url('".img("HeE26183789uQ")."') no-repeat scroll 0px 2px / 85% auto;        
            }              
            .greyFive{           
                background:url('".img("Evc26265598aB")."') no-repeat scroll;           
            }           
            .yellowFive{           
                background: #f6f6f6 url('".img("Iia26348328Vf")."') no-repeat scroll;           
            }        
            .shv-forword-arrow{     
                background: #f6f6f6 url('".img("eBz26070160kz")."') no-repeat scroll -600px -60px;     
            }     
            .shv-next-arrow{     
                background: #f6f6f6 url('".img("eBz26070160kz")."') no-repeat scroll -690px -60px;     
            }                  
        </style>                
    ";                
}     

/*-------------------------------引入飘窗----------------------------------------------------------------------*/    
function floatWinImg(){   
    return "   
    <style>                
    .WinB{background:url('".img("TRs27448962aT")."') no-repeat scroll; width:100%; height:100%;}        
    .floatWindowS{background:url('".img("NDQ27448976Bx")."') no-repeat scroll;}                   
    </style>  
    <div class='floatWindowB'>  
        <span class='closeWin'>×</span>  
        <a target='_blank' href='".imgurl("TRs27448962aT")."'><div class='WinB'></div></a>  
    </div>  
    <a target='_blank' href='".imgurl("NDQ27448976Bx")."'><div class='floatWindowS'></div></a>  
    ";   
}        
?>
