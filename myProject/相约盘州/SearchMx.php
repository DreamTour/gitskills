<?php
require_once "library/PcFunction.php";
$Client = query("kehu"," khid = '$_GET[search_khid]' ");
if(empty($Client['khid']) or $Client['khid'] != $_GET['search_khid']){
    $_SESSION['warn'] = "未找到该会员";
	header("Location:{$root}index.php");
	exit(0);
}
$age = date("Y") - substr($kehu['Birthday'],0,4);
$Region = query("region"," id = '$Client[LoveRegionId]' ");
/*********************************会员详情图片循环*********************************************************/
$img = "";
$x = 1;
$Sql = mysql_query(" select * from kehuImg where khid = '$Client[khid]' order by time desc ");
while($array = mysql_fetch_array($Sql)){
	if($x == 1){
		$first_img = "<img style='width:250px;' src='{$root}{$array['src']}' />";
	}
	$img .= "
	<li>
       <img src='{$root}{$array['src']}' />
    </li>
	";
	$x++;
}
echo head("pc").pc_header();
?>
<style>
.vip_icon{background-image:url(<?php echo img("yMY50519999zH");?>)}
#layout-top{margin:20px auto;padding:20px;width:750pt;border:1px solid #ddd;background-color:#fdfdfd;font-size:15px}
#layout-top:after{clear:both;display:block;content:''}
#user-image{float:left;width:250px}
#user-data{float:left;margin-left:20px;width:415px}
#user-advem{float:right;margin-left:40px;width:230px;height:230px}
#user-advem,.user-image-big{background:#f5f5f5}
.user-image-big,.user-image-big img{height:250px}
.user-image-list ul:after{clear:both;display:block;content:''}
.user-image-list ul{position:relative;left:14px;transition:margin .123s linear}
.user-image-list li{float:left;margin-right:6px}
.user-image-list img,.user-image-list li{width:50px;height:50px}
.user-image-list{position:relative;overflow:hidden;margin-top:10px;width:250px;height:50px}
.image-switch-btn{position:absolute;top:0;z-index:100;margin-top:20px;width:9pt;height:100%;height:9pt;background-position:0 0}
#prev{left:0}
#next{right:0}
#user-data .proto-text{color:#000;text-align:left;font-size:1pc;line-height:30px}
#proto-text{margin-top:20px}
.proto-text2{font-size:14px!important}
.proto-list{margin-top:15px}
.proto-list:after{clear:both;display:block;content:''}
.proto-list li{float:left;width:207px}
.proto-list .proto-label,.proto-list p{display:inline-block;font-size:14px}
.proto-list .proto-label{color:#999}
.proto-btn{display:inline-block;margin-right:5px;width:95px;border:1px solid #ccc;color:#666;text-align:center;font-size:14px}
.first-btn{border-color:#fe8723;background:#fe8723}
.second-btn{border-color:#0098c2;background:#0098c2}
.first-btn,.second-btn{color:#fff}
.vip_content{overflow:hidden;margin:0 auto 40px;width:750pt}
.news_place{margin:30px auto;width:750pt}
.news_place a,.news_place span{font-size:14px}
.news_place a{color:#ff536a}
.news_place_icon{margin-bottom:-3px;width:20px;height:20px;background-image:url(<?php echo img("GRE50462428Fy");?>);background-position:-22px -94px}
.vip_content_left{float:left;overflow:hidden;width:700px}
.left_column1,.left_column2{float:left;margin-bottom:20px;padding:15px;border:1px solid #ddd;width:700px;}
.left_column2{margin-top:2px}
.vip_icon1{width:9pt;height:9pt;background-position:-3px -2px}
.meet_love,.panzhou_news{border:1px solid #d9d9d9}
.meet_love{float:right;width:280px;height:550px}
.meet_love_title,.panzhou_news_title{height:42px;background-color:#f6f6f6;text-align:center;line-height:42px}
.meet_love_icon,.panzhou_news_icon{float:left;display:inline-block;margin:9px 5px 0 18px;width:25px;height:25px}
.meet_love_icon{background-position:-20px -199px}
.panzhou_news_icon{background-position:-20px -238px}
.meet_love_title h2,.panzhou_news_title h2{float:left;color:#000;font-weight:700;font-size:1pc}
.shop,.shop_box{height:126px}
.shop{margin:0 15px;padding-top:30px;width:250px;border-bottom:1px dotted #d9d9d9}
.shop_icon{float:left;display:inline-block;width:65px;height:65px}
.shop_icon01{background-position:-90px -31px}
.shop_icon02{background-position:-90px -105px}
.shop_icon03{background-position:-90px -180px}
.shop_icon04{background-position:-90px -262px}
.shop_text{float:left;margin-left:15px}
.shop_text_title{margin-bottom:9pt;color:#f55173;text-decoration:underline;font-size:14px}
.shop_text_content1{margin:10px 0 4px}
.shop_text_icon{margin-right:2px;width:0;height:0;border-top:5px solid transparent;border-bottom:5px solid transparent;border-left:5px solid #f55173}
#shop-special{border-bottom:none}
</style>
<!--基本资料-->
<div class="news_place"><i class="news_place_icon" id="news_btn"></i><span>您所在的位置：</span><a href='http://www.yumukeji.com/project/xiangyuepanzhou/Search.php'>缘分搜索</a><span>>></span><a href='http://www.yumukeji.com/project/xiangyuepanzhou/SearchMx.php'>会员详情</a></div>
<div id="layout-top">
	<div id="user-image" class="user-image-view">
    	<div id="image-big" class="user-image-big"><?php echo $first_img;?></div>
        <div class="user-image-list">
        	<div id="prev" class="image-switch-btn vip_icon" style="background-position: -22px -18px;"></div>
            <div id="next" class="image-switch-btn vip_icon" style="background-position: -3px 16px;"></div>
        	<ul id="image-list">
            	<?php echo $img;?>
            </ul>
        </div>
    </div>
    <div id="user-data" class="user-data">
    	<div class="proto-text" style="font-weight:600;"><?php echo kong($Client['NickName']);?></div>
        <div class="proto-text">
        	<div>会员身份：<span><?php echo $Client['Grade'];?></span></div>
        	<div class="proto-text proto-text2"><?php echo $age;?>岁，<?php echo kong($Client['marry']);?>，来自<?php echo $Region['city'];?></div>
            <ul class="proto-list">
            	<li><span class="proto-label">性别：</span><p><?php echo kong($Client['sex']);?></p></li>
                <li><span class="proto-label">身高：</span><p><?php echo kong($Client['height']);?>cm</p></li>
                <li><span class="proto-label">购车：</span><p><?php echo kong($Client['BuyCar']);?></p></li>
                <li><span class="proto-label">月薪：</span><p><?php echo kong($Client['salary']);?></p></li>
                <li><span class="proto-label">住房：</span><p><?php echo kong($Client['BuyHouse']);?></p></li>
                <li><span class="proto-label">属相：</span><p><?php echo kong($Client['Zodiac']);?></p></li>
                <li><span class="proto-label">星座：</span><p><?php echo kong($Client['constellation']);?></p></li>
                <li><span class="proto-label">学历：</span><p><?php echo kong($Client['degree']);?></p></li>
                <li><span class="proto-label">职业：</span><p><?php echo kong($Client['Occupation']);?></p></li>
                <li><span class="proto-label">子女情况：</span><p><?php echo kong($Client['children']);?></p></li>
            </ul>
        </div>
        <div class="proto-text" id="proto-text">
        	<a href="javascript:;" class="proto-btn first-btn" id="let-btn">发信</a>
            <a href="javascript:;" class="proto-btn second-btn" sayHi="<?php echo $Client['khid'];?>">打招呼</a>
            <a href="javascript:;" class="proto-btn" id="gifts-btn">送礼物</a>
        </div>
    </div>
    <a target="_blank" href="<?php echo imgurl('CuP50520032pV');?>"><img id="user-advem" class="user-advem" src="<?php echo img("CuP50520032pV");?>"></a>
</div>
<!--会员资料-->
<div class="vip_content">
    <!--左边-->
    <div class="vip_content_left">
        <!--自我介绍-->
        <div class="left_column1">
            <i class="vip_icon vip_icon1" ></i>
            <span style="font-size:18px;">内心独白</span>
            <p style="margin-top:10px;text-indent:2em;line-height:30px;font-size:14px;"><?php echo kong($Client['summary']);?></p>
        </div>
        <!--择偶要求-->
        <div class="left_column2">
            <i class="vip_icon vip_icon1" ></i>
            <span style="font-size:18px;">择偶要求</span>
             <ul class="proto-list" style="line-height:30px;">
                <li><span class="proto-label">年龄：</span><p><?php echo kong($Client['LoveAge']);?></p></li>
                <li><span class="proto-label">身高：</span><p><?php echo kong($Client['LoveHeight']);?>cm</p></li>
                <li><span class="proto-label">民族：</span><p><?php echo kong($Client['LoveNation']);?></p></li>
                <li><span class="proto-label">学历：</span><p><?php echo kong($Client['LoveDegree']);?></p></li>
                <li><span class="proto-label">婚姻状况：</span><p><?php echo kong($Client['LoveMarry']);?></p></li>
                <li><span class="proto-label">居住地：</span><p><?php echo kong($Region['province'].$Region['city'].$Region['area']);?></p></li>
                <li><span class="proto-label">购房：</span><p><?php echo kong($Client['LoveHouse']);?></p></li>
                <li><span class="proto-label">购车：</span><p><?php echo kong($Client['LoveCar']);?></p></li>

                <li><span class="proto-label">职业：</span><p><?php echo kong($Client['LoveOccupation']);?></p></li>
            </ul>
        </div>
    </div>
    <!--右侧帮你遇见爱-->
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
                         <a class="shop_text_title" href="javascript:;">银牌会员>></a>
                         <div class="shop_text_content1">
                            <i class="shop_text_icon"></i>
                            <span>看信、发信全部免费</span>
                         </div>
                         <div class="shop_text_content">
                            <i class="shop_text_icon"></i>
                            <span>个人资料页面优先展示</span>
                         </div>
                    </div>
                </div>
            </div>
            <div class="shop_box">
                <div class="shop">
                    <i class="shop_icon02 shop_icon icon"></i>
                    <div class="shop_text">
                         <a class="shop_text_title" href="javascript:;">银牌会员>></a>
                         <div class="shop_text_content1">
                            <i class="shop_text_icon"></i>
                            <span>看信、发信全部免费</span>
                         </div>
                         <div class="shop_text_content">
                            <i class="shop_text_icon"></i>
                            <span>个人资料页面优先展示</span>
                         </div>
                    </div>
                </div>
            </div>
            <div class="shop_box">
                <div class="shop">
                    <i class="shop_icon03 shop_icon icon"></i>
                    <div class="shop_text">
                         <a class="shop_text_title" href="javascript:;">银牌会员>></a>
                         <div class="shop_text_content1">
                            <i class="shop_text_icon"></i>
                            <span>看信、发信全部免费</span>
                         </div>
                         <div class="shop_text_content">
                            <i class="shop_text_icon"></i>
                            <span>个人资料页面优先展示</span>
                         </div>
                    </div>
                </div>
            </div>
            <div class="shop_box">
                <div class="shop" id="shop-special">
                    <i class="shop_icon04 shop_icon icon"></i>
                    <div class="shop_text">
                         <a class="shop_text_title" href="javascript:;">银牌会员>></a>
                         <div class="shop_text_content1">
                            <i class="shop_text_icon"></i>
                            <span>看信、发信全部免费</span>
                         </div>
                         <div class="shop_text_content">
                            <i class="shop_text_icon"></i>
                            <span>个人资料页面优先展示</span>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo send_gift().letter("",$_GET['search_khid']);?>
<script>
$(function(){
	//点击打招呼发送默认消息
	$("[sayHi]").click(function() {
		$.post("<?php echo root."user/usData.php";?>",{sayHiMessageId:$(this).attr("sayHi")},function(data) {
			warn(data.warn);
		},"json");
	});
})
var swiper = function() {
		var b = 0,
			c = function(a) {
				//获取id号
				if (a) return document.getElementById(a)
			},
			d = function(a, b) {
				//获取对象css
				return a.currentStyle ? a.currentStyle[b] : getComputedStyle(a, !1)[b]
			},
			m = c("image-big"),
			g = c("image-list"),
			e = g.getElementsByTagName("li"),
			f = e.length,
			h = c("prev"),
			k = c("next"),
			c = d(e[0], "width"),
			n = d(e[0], "height"),
			d = d(e[0], "margin-right"),
			l = parseInt(c.replace(/px/, ""));
		handleHeight = parseInt(n.replace(/px/, ""));
		handleMargin = parseInt(d.replace(/px/, ""));
		init = function() {
			//初始化对象
			g.style.width = (l + handleMargin) * f + "px";
			k && (k.onclick = function() {
				b++;
				b >= f && (b = f);
				move(b)
			}, h && (h.onclick = function() {
				b--;
				0 >= b && (b = 0);
				move(b)
			}))
		};
		move = function(a) {
			//执行列表图运行
			a >= f || (g.style.marginLeft = -(l + handleMargin) * a + "px")
		};
		selectImage = function() {
			//赋值src
			for (var a = 0; a < f; a++) e[a].onclick = function() {
				var a = this.getElementsByTagName("img")[0].src;
				m.getElementsByTagName("img")[0].src = a
			}
		};
		selectImage();
		init()
};
window.onload = function(){
	swiper();
}
//送礼物
$("#gifts-btn").click(function(){
	G.show();
});
$("#let-btn").click(function(){
	LG.show();
});
</script>
<?php echo warn().footer();?>