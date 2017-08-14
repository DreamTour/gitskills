<?php

require_once "library/PcFunction.php";

if(isset($_GET['detele']) and $_GET['detele'] == 'yes'){
	unset($_SESSION['khid']);
	header("Location:{$root}index.php");
	exit(0);
}

$ThisUrl = root."index.php";
$sql = " select * from kehu ".$_SESSION['userSearch']['Sql'];
paging($sql," order by UpdateTime desc ",12);
/*************同城搜索列表**********************************************/
$Search = "";
if($num == 0){
	$Search .= "一条搜索都没有";
}else{
	while($array = mysql_fetch_array($query)){
		$age = date("Y") - substr($array['Birthday'],0,4);
		$Region = query("region"," id = '$array[RegionId]' ");
		$Search .= "
		<div class='content01_box'>
            <div class='content01'>
				<a class='photo' href='{$root}SearchMx.php?search_khid={$array['khid']}'>
					<img style='width:120px;height:150px;' src='".HeadImg($array['sex'],$array['ico'])."'>
				</a>
				<h2>{$array['NickName']}</h2>
				<div class='content_text'>
					<span>{$age}岁</span><span>{$Region['province']}</span><span>{$Region['city']}</span>
				</div>
				<a class='say_hi' href='javascript:;' sayHi='{$array['khid']}'>打招呼</a>
				<a class='give_gift' href='javascript:;' data-id='{$array['khid']}'>送礼物</a>
             </div>
         </div>
		";
	}
}
/*************盘州信息列表**********************************************/
$sqlMessage = mysql_query(" select * from talk where type = '盘州信息' and Auditing = '已通过' order by time desc limit 10 ");
$message = "";
while($arrayMessage = mysql_fetch_array($sqlMessage)){
	$client = mysql_fetch_array(mysql_query("select * from kehu where khid = '$arrayMessage[khid]'"));
	$message .= "
	<li class='news_info'>
		<i class='news_circle'></i>
		<a href='{$root}MessageMx.php?talkId={$arrayMessage['id']}'>{$arrayMessage['title']}</a>
	</li>
	";
}
//生成年龄下拉菜单
for($n = 18;$n <= 60;$n++){
		$option[$n] = $n."岁";
	}
$Age1 = select('searchMinAge','s_style2',"年龄",$option,"");
$Age2 = select('searchMaxAge','s_style2',"年龄",$option,"");
/*************是否显示登录注册**********************************************/
$register = "";
if($KehuFinger == 2) {
	$register = "<div class='register_box'>
            	<div class='zzc'></div>
                <div class='register'>
                    <div class='reg'>1分钟注册，享一辈子幸福！</div>
                    <div class='line'></div>
                    <form name='indexUsRegisterForm' method='get' action='".root.'user/usRegister.php'."'>
                        <div class='select_box'>
                            <div class='sex_box'>
                                <h1>性别</h1>
                                <label><input type='radio' name='sex' value='男'><span>男</span></label>
                                <label><input type='radio' name='sex' value='女'><span>女</span></label>
                            </div>
                            <div class='birthday_box'>
                                <h1>生日</h1>
                                ".year('year','s_style','','').moon('moon','s_style','').day('day','s_style','')."
                            </div>
                            <div class='area_box'>
                                <h1>所在地区</h1>
                                <select name='province' class='s_style'>".RepeatSele('region','province','--省份--')."</select>
                                <select name='city' class='s_style'><option value=''>-城市-</option></select>
                                <select name='area' class='s_style'><option value=''>-区县-</option></select>
                            </div>
                            <div class='marry_box'>
                                <h1>婚姻状况</h>
                                <label><input type='radio' name='marry' value='未婚'><span>未婚</span></label>
                                <label><input type='radio' name='marry' value='离婚'><span>离婚</span></label>
                                <label><input type='radio' name='marry' value='丧偶'><span>丧偶</span></label>
                            </div>
                       </div>
                       <a class='free_reg' href='javascript:;' onClick='document.indexUsRegisterForm.submit()'>免费注册</a>
                    </form>
                    <a class='login_quick' href='".root.'user/usLogin.php'."'>我是会员，立即登录</a>
                </div>
            </div>";	
} else {
	$register = "";	
}
echo head("pc").pc_header();
?>
<style>
/****首页****/
/*banner*/
.banner{
	height:450px;
	margin:auto;
	overflow:hidden;
	position:relative;	
}
#banner-scontainer {
    position: absolute;
    overflow: hidden;
    height: 450px;
    top: 0;
    width: 100%;
}
#banner-scontainer .list-item li{ float:left; height:450px;}
#banner-scontainer .list-item:after{ content:''; display:block; clear:both;}
#banner-scontainer .sort-item{ position:absolute; width:100%; bottom:20px; left:0; z-index:100; text-align:center}
#banner-scontainer .sort-item li{ width:10px; height:10px; background:#fff; display:inline-block; margin:0 5px;}
#banner-scontainer .sort-item .cur{ background:#C00 !important;}
/*注册透明块儿*/
.register_box{
	height:450px;
	width:1000px;
	position:relative;
	margin:auto;
}
.zzc,.register{
	width:400px;
	height:380px;
	position:absolute;
	left:25px;
	top:30px;
	text-align:center;	
}
.zzc{ 
	background:#fff;
	opacity:.9; 
	filter:alpha(opacity=90);
	z-index:100;
	}
.register{ z-index:100;}

.register span{
	font-size:14px;
}
.reg{
	font-size:16px;
	font-weight:600;
	padding:20px 0;
}
.register h1{
	display:inline;
	font-size:14px;
	margin-right:20px;
	margin-left:25px;
}
.line{
	width:380px;
	height:1px;
	background-color:#ddd;
	margin-left:10px;
}
.free_reg{
	display:inline-block;
	width:230px;
	padding:15px 18px;
	background:#ff536a;
	font-size:20px;
	color:#fff;
	margin:20px 0;
}
.login_quick{
	display:block;
	font-size:14px;
	text-decoration:underline;	
}
.register .select_box{
	text-align:left;
	padding-left:20px;
}
.sex_box{
	padding:20px 0;
	margin-left:28px;
}
.birthday_box{
	marrgin-bottom:15px;
	margin-left:28px;
}
.s_style{
	width:70px;
	height:30px;
	border:1px solid #ddd;
	margin-right:5px;
}
.area_box{
	padding:15px 0;
}
.marry_box{
	padding:5px 0;
}
.marry_box span,.sex_box span{
	margin:0 5px 0 3px;
}
.space{
	margin-right:10px;
}
.sex_replace{
	display:inline-block;
	width:12px;
	height:12px;
	border-radius:50%;
	border:1px solid #ddd;
	position:relative;
	margin-right:5px;	
}
input:checked~.sex_replace:after{
	content:"";
	transition:background .1s linear;
	width:6px;
	height:6px;
	border-radius:50%;
	background:#ddd;
	left:0;
	right:0;
	top:0;
	bottom:0;
	position:absolute;
	margin:auto;
}
/*内容*/
.content{
	width:1000px;
	margin:auto;
	height:960px;
	margin-top:20px;	
}
.content select{
	font-size:14px;
}
/*右侧栏目1 帮你遇见爱*/
.column_box{
	width:280px;
	height:960px;
	float:right;
}
#myScroll li{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.panzhou_news,.meet_love{
	width:280px;
	border:1px solid #d9d9d9;
}
.meet_love{	
	height:550px;
}
.panzhou_news_title,.meet_love_title{
	height:42px;
	line-height:42px;
	text-align:center;
	background-color:#f6f6f6;	
}
.panzhou_news_icon,.meet_love_icon{
	margin:9px 5px 0 18px;
	width:25px;
	height:25px;
	display:inline-block;
	float:left;
}
.meet_love_icon{
	background-position:-20px -199px;
}
.panzhou_news_icon{
	background-position:-20px -238px;
}
.panzhou_news_title h2,.meet_love_title h2{
	float:left;
	font-size:16px;
	font-weight:bold;
	color:#000;
}
.shop_box{
	height:126px;
}
.shop{
	width:250px;
	height:126px;
	border-bottom:1px dotted #d9d9d9;
	margin:0 15px;
	padding-top:30px;
}
.shop_icon{
	float:left;
	display:inline-block;
	width:65px;
	height:65px;
}
.shop_icon01{
	background-position:-90px -31px;
}
.shop_icon02{
	background-position:-90px -105px;
}
.shop_icon03{
	background-position:-90px -180px;
}
.shop_icon04{
	background-position:-90px -262px;
}
.shop_text{
	float:left;
	margin-left:15px;
}
.shop_text_title{
	font-size:14px;
	color:#f55173;
	text-decoration:underline;
	margin-bottom:12px;
}
.shop_text_content1{
	margin:10px 0 4px 0;
}
.shop_text_icon{
	width:0;
	height:0;
	border-top:5px solid transparent;
	border-bottom:5px solid transparent;
	border-left:5px solid #f55173;
	margin-right:2px;
}
#shop-special{
	border-bottom:none;
}
/*右侧栏目2 盘州信息*/
.panzhou_news{
	margin-top:20px;
}
.news_info{
	padding: 10px 0 6px 0;
}
.news_info a{
	color:#000;
}
.news_info a:hover{
	text-decoration:underline;
}
.news_circle{
	width:5px;
	height:5px;
	background-color:#f9a61c;
	border-radius:50%;
	margin-left:15px;
	margin-right:2px;
	vertical-align:middle;
}
/*广告*/
.ad{
	width:1000px;
	height:90px;
	clear:both;
	margin:50px auto;
}
/*左侧搜索*/
.search_box{
	width:700px;
	height:960px;
	background:#f6f6f6;
	float:left;
}
.search_content{
	float:right;
	width:280px;
}
.search_top{
	height:35px;
	line-height:35px;
	margin:20px;
	overflow:hidden;
}
.search_top *{
	float:left;
}
.search_bg{
	display:inline-block;
	width:32px;
	height:32px;
	background-position:-18px -146px;
	margin-top:3px;
}
.search_title{
	font-size:18px;
	font-weight:bold;
	color:#000;
	margin:0 10px 0 5px;
}
.search_btn{
	float:right;
	display:inline-block;
	width:86px;
	height:34px;
	background-color:#f9a61c;
	text-align:center;
	border-radius:3px;
	color:#fff;
	font-size:16px;
	margin-right:10px;
}
.s_style2,.s_style3,.s_style4{
	height:30px;
	border:1px sold #ddd;
	margin-right:8px;
}
.s_style2{
	width:70px;
}
.s_style2{border:1px solid rgb(169, 169, 169);}
.s_style3{
	width:80px;
}
.s_style4{
	width:70px;
}

.search_content{
	clear:both;
	width:700px;
	padding-left:18px;
}
.content01_box{
	width:152px;
	background:#fff;
	border:1px solid #ccc;
	text-align:center;
	margin-right:15px;
	margin-bottom:20px;
	float: left;
}
.content01{
	padding:10px;
	margin-top: 5px;
    height: 265px;
}
.content01 h2{
	margin-top:8px;
	font-size:14px;
	color:#f55173;
	white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.content_text{
	margin:3px 0 8px 0;
	height: 31px;
	display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
}
.content_text span{
	margin-right:3px;
}
.say_hi,.give_gift{
		width:56px;
	height:24px;
	display:inline-block;
	background:#fff8f9;
	border:1px solid #f55173;
	color:#f55173;
	vertical-align:top;
	line-height:22px;	
}
.give_gift{
	background:#f55173;
	color:#fff;
}
#banner-scontainer .list-item li{max-width:1903px !important;}
</style>
<!--banner-->
        <div class="banner">
        	<?php echo $register;?>
            <div id="banner-scontainer" class="banner-scontainer">
                <div class="banner-listitem">
                    <ul class="list-item">
                        <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover;"></li>
                        <li style="background:url(<?php echo img("YOs52692750nh");?>) no-repeat scroll center/cover;"></li>
                        <li style="background:url(<?php echo img("LNq52692953Ny");?>) no-repeat scroll center/cover;"></li>
                    </ul>
                </div>
                <div class="banner-sortitem">
                    <ul class="sort-item"></ul>
                </div>
            </div>
        </div>
        <!--内容-->
        <div class="content">
        	<!--左侧搜索-->
        	<div class="search_box">
            	<div class="search_top">
                	<i class="search_bg icon"></i>
                    <form name="searchForm" action="<?php echo "{$root}library/PcPost.php";?>" method="post">
                        <div class="search_condition">
                            <h1 class="search_title">同城搜索:</h1>
                            <select name="searchSex" class="s_style4">
                                <option value="">请选择</option>
                                <option value="男">男</option>
                                <option value="女">女</option>
                            </select>


                            <?php echo $Age1;?>
                            <span style="margin-right:10px;">至</span>
                            <?php echo $Age2;?>
                            <select name="province" class="s_style3">
                                 <?php echo RepeatSele("region","province","--省份--");?>
                            </select>
                            <select name="city" class="s_style3">
                                 <?php echo RepeatSele("region where province = '{$_SESSION['userSearch']['province']}' ","city","--城市--");?>
                            </select>
                        </div>
                        <input class="search_btn" type="submit" value="搜索">
                    </form>
                </div>
                <div class="search_content">
                	<?php echo $Search;?>
                </div>
            </div>
            <!--右侧栏目1 帮你遇见爱-->
            <div class="column_box">
            	<div class="meet_love">
                	<div class="meet_love_title">
                    	<i class="meet_love_icon icon"></i>
                        <h2>帮你遇见爱</h2>
                    </div>
                    <div class="meet_love_content">
                    	<div class="shop_box">
                        	<div class="shop">
                            	<i class="shop_icon01 shop_icon icon"></i>
                                <div class="shop_text">
                                	 <a class="shop_text_title" href="javascript:;" openId='2'>银牌会员>></a>
                                     <div class="shop_text_content1">
                                     	<i class="shop_text_icon"></i>
                                        <span>相互关注动态,玫瑰赠送</span>
                                     </div>
                                     <div class="shop_text_content">
                                     	<i class="shop_text_icon"></i>
                                        <span>人气排行榜,情书互动</span>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="shop_box">
                        	<div class="shop">
                            	<i class="shop_icon02 shop_icon icon"></i>
                                <div class="shop_text">
                                	 <a class="shop_text_title" href="javascript:;" openId='3'>金牌会员>></a>
                                     <div class="shop_text_content1">
                                     	<i class="shop_text_icon"></i>
                                        <span>择偶意向</span>
                                     </div>
                                     <div class="shop_text_content">
                                     	<i class="shop_text_icon"></i>
                                        <span>客服详细推荐</span>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="shop_box">
                        	<div class="shop">
                            	<i class="shop_icon03 shop_icon icon"></i>
                                <div class="shop_text">
                                	 <a class="shop_text_title" href="javascript:;" openId='4'>钻石会员>></a>
                                     <div class="shop_text_content1">
                                     	<i class="shop_text_icon"></i>
                                        <span>可预约本站会员并可预约见面</span>
                                     </div>
                                     <div class="shop_text_content">
                                     	<i class="shop_text_icon"></i>
                                        <span>每月可以预约2次</span>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="shop_box">
                        	<div class="shop" id="shop-special">
                            	<i class="shop_icon04 shop_icon icon"></i>
                                <div class="shop_text">
                                	 <a class="shop_text_title" href="javascript:;" openId='5'>红娘会员>></a>
                                     <div class="shop_text_content1">
                                     	<i class="shop_text_icon"></i>
                                        <span>享有本站所有功能</span>
                                     </div>
                                     <div class="shop_text_content">
                                     	<i class="shop_text_icon"></i>
                                        <span>每月可以预约4次</span>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--会员开通隐藏表单-->
                <div class="hide">
                <form name="PayForm" action="<?php echo root."pay/alipayapi.php";?>" method="post">
                    <input name="GradeNum" type="hidden">
                    <input name="type" type="hidden" value="会员升级">
                </form>
                </div>
                <!--右侧栏目2 盘州信息-->
                <div class="panzhou_news">
					<div class="panzhou_news_title">
                    	<i class="panzhou_news_icon icon"></i>
                        <h2>盘州信息</h2>
                        <a href="<?php echo root."Message.php";?>" style="margin-left: 100px;">更多>></a>
                    </div>
                    <div id="myScroll" style="height: 325px; overflow:hidden;">
                    	<ul class="panzhou_news_content"><?php echo $message;?></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="activity_btn"><?php echo fenye($ThisUrl,7,"");?></div>
    <!--广告-->
    <div class="ad">
		<a target="_blank" href="<?php echo imgurl("oGv49861379ud");?>"><img src="<?php echo img("oGv49861379ud");?>"></a>
    </div>
<?php echo send_gift().warn().footer();?>
<script>
$(function() {
	//提升会员等级
	$('[openId]').click(function() {
		//自己当前的会员等级
		var GradeNum = <?php echo UserGradeNum($kehu['Grade']);?>;
		//要提升的会员等级
		var clickNum = $(this).attr('openId');
		if(GradeNum >= clickNum) {
			warn('新开通的会员等级不能低于当前会员等级');
		}else{
			document.PayForm.GradeNum.value = clickNum;
			document.PayForm.submit();
		}
	})	
	//点击显示送礼物
	$("[data-id]").click(function(){
		G.show();
		document.GiftPayForm.TypeId.value = $(this).attr("data-id");
	});
	 //根据省份获取下属城市下拉菜单
	$(document).on('change','[name="indexUsRegisterForm"] [name=province]',function(){
		$.post('<?php echo root."library/OpenData.php";?>',{ProvincePostCity:$(this).val()},function(data){
			$('[name="indexUsRegisterForm"] [name=city]').html(data.city);
		},'json');
	});
	//根据省份和城市获取下属区域下拉菜单
	$(document).on('change','[name="indexUsRegisterForm"] [name = city]',function(){
	    $.post('<?php echo root."library/OpenData.php";?>',{
				ProvincePostArea:$('[name="indexUsRegisterForm"] [name=province]').val(),
				CityPostArea:$(this).val()
			},function(data){
			$('[name="indexUsRegisterForm"] [name=area]').html(data.area);
		},"json");
	});
	 //根据省份获取下属城市下拉菜单
	$(document).on('change','[name="searchForm"] [name=province]',function(){
		$.post('<?php echo root."library/OpenData.php";?>',{ProvincePostCity:$(this).val()},function(data){
			$('[name="searchForm"] [name=city]').html(data.city);
		},'json');
	});
	/*同城搜索*/
	<?php 
	echo 
	KongSele("searchForm.searchSex",$_SESSION['userSearch']['sex']).
	KongSele("searchForm.searchMinAge",$_SESSION['userSearch']['minAge']).
	KongSele("searchForm.searchMaxAge",$_SESSION['userSearch']['maxAge']).
	KongSele("searchForm.province",$_SESSION['userSearch']['province']).
	KongSele("searchForm.city",$_SESSION['userSearch']['city']);
	?>
	//点击打招呼发送默认消息
	$("[sayHi]").click(function() {
		$.post("<?php echo root."user/usData.php";?>",{sayHiMessageId:$(this).attr("sayHi")},function(data) {
			warn(data.warn);
		},"json");
	});
	//盘州信息滚动效果
	var b = null,
		d = $("#myScroll"),
		a = $("#myScroll").find("ul"),
		e = a.find("li").height() + parseInt(a.find("li").css("margin-top")) + parseInt(a.find("li").css("margin-bottom")) + parseInt(a.find("li").css(		"padding-top")) + parseInt(a.find("li").css("padding-bottom")),
		f = function() {
			a.finish().animate({
				marginTop: e + "px"
			}, 500, function() {
				var b = a.find("li:last");
				a.css({
					marginTop: 0
				});
				b.css({
					opacity: 0
				});
				b.prependTo(a);
				b.animate({
					opacity: 1
				}, 500)
			})
		},
		c = function() {
			clearInterval(b);
			b = setInterval(function() {
				f()
			}, 3E3)
		};
	c();
	d.hover(function() {
		clearInterval(b)
	}, function() {
		c()
	})
});
</script>