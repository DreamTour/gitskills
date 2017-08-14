<?php 
include "library/PcFunction.php";
$Client = mysql_fetch_assoc(mysql_query("select * from kehu where khid = '$_GET[search_khid]' "));
if(empty($Client['khid']) or $Client['khid'] != $_GET['search_khid']){
	$_SESSION['warn'] = "未找到该会员";
	header("Location:{$root}index.php");
	exit(0);	
}
$age = date("Y") - substr($Client['Birthday'],0,4);
$Region = mysql_fetch_assoc(mysql_query("select * from region where id = '$Client[RegionId]' "));
$loveRegion = mysql_fetch_assoc(mysql_query("select * from region where id = '$Client[LoveRegionId]' "));
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
//检查是否已经关注过  如果已经关注打印已关注 把背景色，border调灰色
$followNum = mysql_num_rows(mysql_query("select * from follow where type = '1' and khid = '$kehu[khid]' and TargetId = '$_GET[search_khid]' "));
if($followNum > 0){
	$style = "style='background:#ccc;border-color:#ccc'";
	$value = "取消关注";	
	
}else{
	$style = "style='background:#0098c2;border-color:#0098c2'";
	$value = "加关注";
}
//记录谁看过我
$TargetId = $_GET['search_khid'];//被看过的客户的ID号
$num = mysql_num_rows(mysql_query(" select * from follow where type = '2' and khid = '$kehu[khid]' and TargetId = '$TargetId' "));
if($num == 0){
	$id = suiji();
	mysql_query(" insert into follow (id,type,khid,TargetId,time) values ('$id','2','$kehu[khid]','$TargetId','$time') ");
}
//查看微信号
$startTime = date("Y-m-d")." 00:00:00";//今天开始时间
$EndTime = date("Y-m-d")." 23:59:59";//今天结束时间
//今天是否给这个客户因为查看微信支付过款项
$weChatPay = mysql_num_rows(mysql_query(" select * from pay where classify = '查看微信号' and khid = '$kehu[khid]' and clientId = '$Client[khid]' and WorkFlow = '已支付' and UpdateTime > '$startTime' and UpdateTime < '$EndTime' "));
if($weChatPay > 0){
	$weChatNum = "{$Client['wxNum']}";
}else{
	$weChatNum = "点击查看";	
	$payCondition = "true";
}
//包年包月发信
$minMonth = date("Y-m-d H:i:s",strtotime("$time - 1 month"));//当前时间减去一个月
$payMonth = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包月' and khid = '$Client[khid]' and WorkFlow = '已支付' and UpdateTime > '$minMonth' "));
$minYear = date("Y-m-d H:i:s",strtotime("$time - 1 year"));//当前时间减去一年
$payYear = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包年' and khid = '$Client[khid]' and WorkFlow = '已支付' and UpdateTime > '$minYear' "));
if($payYear>0){
	$Grade = "年会员";	
}else if($payMonth>0){
	$Grade = "月会员";	
}else{
	$Grade = "普通会员";	
}
if($Client['authentication'] == "是"){
	$vIcon = "vip_icon";
}
echo head("pc");
UserRoot("pc");	
?>
<style>
.left_column1{min-width:700px;}
.icon{ background:url(<?php echo img("WxN53377734Xb");?>);}
.vip_icon{background-image:url(<?php echo img("yMY50519999zH");?>)}
#layout-top{width:1000px;margin:20px auto;padding:20px;font-size:15px;background-color:#fdfdfd;border:1px solid #ddd}
#layout-top:after{content:'';display:block;clear:both}
#user-image{width:250px;float:left}
#user-data{width:415px;float:left;margin-left:20px}
#user-advem{width:230px;height:230px;float:right;margin-left:40px;background:#f5f5f5}
.user-image-big{background:#f5f5f5}
.user-image-big,.user-image-big img{height:250px;height:250px}
.user-image-list ul:after{content:'';display:block;clear:both}
.user-image-list ul{position:relative;left:14px;transition:margin .123s linear}
.user-image-list li{float:left;margin-right:6px}
.user-image-list img,.user-image-list li{width:50px;height:50px}
.user-image-list{width:250px;overflow:hidden;height:50px;margin-top:10px;position:relative}
.image-switch-btn{position:absolute;height:100%;width:12px;height:12px;background-position:0 0;top:0;z-index:100;margin-top:20px}
#prev{left:0}
#next{right:0}
#user-data .proto-text{text-align:left;color:#000;font-size:16px;line-height:30px}
#proto-text{margin-top:20px}
.proto-text2{font-size:14px!important}
.proto-list{margin-top:15px}
.proto-list:after{content:'';display:block;clear:both}
.proto-list li{width:207px;float:left}
.proto-list .proto-label,.proto-list p{display:inline-block;font-size:14px}
.proto-list .proto-label{color:#999}
.proto-btn{width:95px;text-align:center;font-size:14px;display:inline-block;border:1px solid #ccc;color:#666;margin-right:5px}
.first-btn{background:#fe8723;border-color:#fe8723}
.second-btn{background:#ff7c7c;border-color:#ff7c7c}
.third-btn{background:#0098c2;border-color:#0098c2}
.first-btn,.second-btn,.third-btn{color:#fff}
.vip_content{width:1000px;margin:0 auto 40px;overflow:hidden}
.news_place{width:1000px;margin:30px auto}
.news_place a,.news_place span{font-size:14px}
.news_place a{color:#ff7c7c}
.news_place_icon{width:20px;height:20px;background-position:-22px -94px;margin-bottom:-3px;background-image:url(<?php echo img("GRE50462428Fy")?>)}
.vip_content_left{float:left;overflow:hidden;width:700px}
.left_column1,.left_column2{padding:15px;float:left;border:1px solid #ddd;margin-bottom:20px}
.left_column2{margin-top:2px}
.vip_icon1{width:12px;height:12px;background-position:-3px -2px}
.vip_icon2{width:12px;height:12px;background-position:-3px 16px;margin:0 0 -1px 2px}
.look-btn{background-color:#ff7c7c;padding:3px 5px;color:#fff;margin-right:3px;border-radius:3px}
.meet_love,.panzhou_news{border:1px solid #d9d9d9}
.meet_love{width:280px;height:450px;float:right}
.meet_love_title,.panzhou_news_title{height:42px;line-height:42px;text-align:center;background-color:#f6f6f6}
.meet_love_icon,.panzhou_news_icon{margin:9px 5px 0 18px;width:25px;height:25px;display:inline-block;float:left}
.meet_love_icon{background-position:-20px -199px}
.panzhou_news_icon{background-position:-20px -238px}
.meet_love_title h2,.panzhou_news_title h2{float:left;font-size:16px;font-weight:700;color:#000}
.shop_box{height:126px}
.shop{width:250px;height:126px;border-bottom:1px dotted #d9d9d9;margin:0 15px;padding-top:30px}
.shop_icon{float:left;display:inline-block;width:65px;height:65px}
.shop_icon01{background-position:-90px -31px}
.shop_icon02{background-position:-90px -105px}
.shop_icon03{background-position:-90px -180px}
.shop_icon04{background-position:-90px -262px}
.shop_text{float:left;margin-left:15px}
.shop_text_title{font-size:14px;color:#f55173;text-decoration:underline;margin-bottom:12px}
.shop_text_content1{margin:10px 0 4px 0}
.shop_text_icon{width:0;height:0;border-top:5px solid transparent;border-bottom:5px solid transparent;border-left:5px solid #f55173;margin-right:2px}
#shop-special{border-bottom:none}
.side_ad{margin-top:12px}
</style>
<!--头部-->
<?php echo pcHeader();?>
<!--基本资料-->
<div class="news_place"><i class="news_place_icon" id="news_btn"></i><span>您所在的位置：</span><a href="<?php echo "{$root}search.php";?>">搜索意中人</a><span>>></span><a href="javascript:;">会员详情</a></div>
<div id="layout-top">
	<div id="user-image" class="user-image-view">
    	<div id="image-big" class="user-image-big">
        	<?php echo $first_img;?>
        </div>
        <div class="user-image-list">
        	<div id="prev" class="image-switch-btn vip_icon" style="background-position: -22px -18px;"></div>
            <div id="next" class="image-switch-btn vip_icon" style="background-position: -3px -34px;"></div>
        	<ul id="image-list">
            	<?php echo $img;?>
            </ul>
        </div>
    </div>
    <div id="user-data" class="user-data">
    	<div class="proto-text" style="font-weight:600;"><?php echo kong($Client['NickName']);?></div>
        <div class="proto-text">
        	<div>会员身份：<span><?php echo $Grade;?></span><i class="vip_icon2 <?php echo $vIcon;?>"></i></div>
        	<div class="proto-text proto-text2"><?php echo kong($Client['sex']);?>，<?php echo $age;?>岁，来自<?php echo $Region['area'];?></div>
            <ul class="proto-list">
                <li><span class="proto-label">生肖：</span><p><?php echo kong($Client['Zodiac']);?></p></li>
                <li><span class="proto-label">星座：</span><p><?php echo kong($Client['constellation']);?></p></li>
                <li><span class="proto-label">民族：</span><p><?php echo kong($Client['Nation']);?></p></li>
                <li><span class="proto-label">身高：</span><p><?php echo kong($Client['height']);?>cm</p></li>
                <li><span class="proto-label">体重：</span><p><?php echo kong($Client['weight']);?>斤</p></li>
                <li><span class="proto-label">学历：</span><p><?php echo kong($Client['degree']);?></p></li>
                <li><span class="proto-label">婚育情况：</span><p><?php echo kong($Client['marry']);?></p></li>
                <li><span class="proto-label">家乡：</span><p><?php echo kong($Client['Hometown']);?></p></li>
                <li><span class="proto-label">所在地：</span><p><?php echo kong($Region['area']);?></p></li>
                <li><span class="proto-label">工作：</span><p><?php echo kong($Client['Occupation']);?></p></li>
                <li><span class="proto-label">月薪：</span><p><?php echo kong($Client['salary']);?></p></li>
                <li><span class="proto-label">微信号：</span><a href="javascript:;" class="fz14 look-btn" weChatpay=<?php echo $payCondition;?>><?php echo $weChatNum;?></a><span class="col fz14"></span></li>
            </ul>
        </div>
        <div class="proto-text" id="proto-text">
        	<a href="javascript:;" class="proto-btn first-btn" id="let-btn">发信</a>
            <a href="javascript:;" class="proto-btn second-btn" data-id='<?php echo $_GET['search_khid'];?>'>送礼物</a>
            <a href="javascript:;" <?php echo $style;?> class="proto-btn third-btn" follow='<?php echo $_GET['search_khid'];?>'><?php echo $value;?></a>
        </div>
    </div>
    <img id="user-advem" class="user-advem" src="<?php echo img("CuP50520032pV");?>">
</div>
<!--会员资料-->
    <div class="vip_content of">
    	<!--左边-->
    	<div class="vip_content_left">
        	<!--详细资料-->
            <div class="left_column2">
            	<i class="vip_icon vip_icon1" ></i>
                <span style="font-size:18px;">详细资料</span>
                 <ul class="proto-list" style="line-height:30px;">
                    <li><span class="proto-label">吸烟：</span><p><?php echo kong($Client['smoke']);?></p></li>
                    <li><span class="proto-label">饮酒：</span><p><?php echo kong($Client['drink']);?></p></li>
                    <li><span class="proto-label">购房：</span><p><?php echo kong($Client['BuyHouse']);?></p></li>
                    <li><span class="proto-label">购车：</span><p><?php echo kong($Client['BuyCar']);?></p></li>
                    <li><span class="proto-label">贷款：</span><p><?php echo kong($Client['loan']);?></p></li>
                    <li><span class="proto-label">兴趣爱好：</span><p><?php echo kong($Client['Hobby']);?></p></li>
                    <li><span class="proto-label">优点：</span><p><?php echo kong($Client['Advantage']);?></p></li>
                    <li><span class="proto-label">缺点：</span><p><?php echo kong($Client['defect']);?></p></li>
                    <li><span class="proto-label">家中排行：</span><p><?php echo kong($Client['HomeRanking']);?></p></li>
                    <li><span class="proto-label">家庭成员：</span><p><?php echo kong($Client['family']);?></p></li>


                </ul>
            </div>
        	<!--内心独白-->
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
                    <li><span class="proto-label">年龄：</span><p><?php echo kong($Client['LoveAgeMin']);?>-<?php echo kong($Client['LoveAgeMax']);?>岁</p></li>
                    <li><span class="proto-label">生肖：</span><p><?php echo kong($Client['LoveZodiac']);?></p></li>
                    <li><span class="proto-label">星座：</span><p><?php echo kong($Client['LoveConstellation']);?></p></li>
                    <li><span class="proto-label">民族：</span><p><?php echo kong($Client['LoveNation']);?></p></li>
                    <li><span class="proto-label">身高：</span><p><?php echo kong($Client['LoveHeightMin']);?>-<?php echo kong($Client['LoveHeightMax']);?>cm</p></li>
                    <li><span class="proto-label">体重：</span><p><?php echo kong($Client['LoveWeightMin']);?>-<?php echo kong($Client['LoveWeightMax']);?>斤</p></li>
                    <li><span class="proto-label">学历：</span><p><?php echo kong($Client['LoveDegree']);?></p></li>
                    <li><span class="proto-label">家乡：</span><p><?php echo kong($Client['LoveHometown']);?></p></li>
                    <li><span class="proto-label">目前所在地：</span><p><?php echo empty($loveRegion['area'])?'不限':$loveRegion['area'];?></p></li>
                    <li><span class="proto-label">工作：</span><p><?php echo kong($Client['LoveOccupation']);?></p></li>
                    <li><span class="proto-label">月薪：</span><p><?php echo kong($Client['LoveSalary']);?></p></li>
                    <li><span class="proto-label">吸烟：</span><p><?php echo kong($Client['LoveSmoke']);?></p></li>
                    <li><span class="proto-label">喝酒：</span><p><?php echo kong($Client['LoveDrink']);?></p></li>
                    <li><span class="proto-label">购房：</span><p><?php echo kong($Client['LoveHouse']);?></p></li>
                    <li><span class="proto-label">购车：</span><p><?php echo kong($Client['LoveCar']);?></p></li>
                    <li><span class="proto-label">贷款：</span><p><?php echo kong($Client['LoveLoan']);?></p></li>
                    <li><span class="proto-label">兴趣爱好：</span><p><?php echo kong($Client['LoveHobby']);?></p></li>
                    <li><span class="proto-label">优点：</span><p><?php echo kong($Client['LoveAdvantage']);?></p></li>
                    <li><span class="proto-label">缺点：</span><p><?php echo kong($Client['LoveDefect']);?></p></li>
                    <li><span class="proto-label">婚育情况：</span><p><?php echo kong($Client['LoveMarry']);?></p></li>
                    <li><span class="proto-label">家中排行：</span><p><?php echo kong($Client['LoveHomeRanking']);?></p></li>
                    <li><span class="proto-label">家庭成员：</span><p><?php echo kong($Client['LoveFamily']);?></p></li>
                </ul>
            </div>
        </div>
        <!--右侧帮你遇见爱 支付弹出层-->
        <?php echo meet_love();?>
        <!--右侧广告-->
        <div class="side_ad fr">
        	<a href="javascript:;"><img src="<?php echo img("SnF53377644ta");?>"></a>
        </div>
    </div>
<!--底部-->
<?php echo letter("",$_GET['search_khid']).send_gift().warn().choosePay().pcFooter();?>
<script>
$(function(){
	//点击查看微信
	function openWxNumPay(){
		this.eject();
	}
	openWxNumPay.prototype = {
		Show:function(){
			$('.popup-background').show();
			$('.popup-box').show();	
		},
		eject:function(){
			var _this = this;
			$('[wechatpay=true]').click(function(){
				var price = <?php echo website("Sqc52623372XS");?>;
				$('[data-title]').html('查看微信号');
				$('[data-money]').html('￥'+price);
				_this.Show();
				$('[name=PayForm] [name=PayType]').val('查看微信号');
				$('[name=PayForm] [name=TypeId]').val('<?php echo $_GET['search_khid'];?>');
			})	
		}
	}
	new openWxNumPay();
	//点击显示送礼物
	$("[data-id]").click(function(){
		G.show();
		document.PayForm.TypeId.value = $(this).attr("data-id");
	});
	//点击显示发信
	$("#let-btn").click(function(){
		LG.show();
	});
	//记录谁关注我
	$("[follow]").click(function() {
		var _this = $(this);
		$.post("<?php echo root."library/usData.php";?>",{follow:_this.attr('follow')},function(data) {
			warn(data.warn);
			if(data.flag == 2){
				_this.text('取消关注');
				_this.css({'background':'#ccc','border-color':'#ccc'});
			}
			if(data.warn == "取消成功"){
				_this.text('加关注');
				_this.css({'background':'#0098c2','border-color':'#0098c2'});	
			}
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
(function() {
	photoAlbum = function(imageList, setting) {
		//imageList 目标图片容器
		//setting 自定义设置参数
		this.init(imageList, setting)
	};
	photoAlbum.fn = photoAlbum.prototype = {
		init: function(imageList, setting) {//初始化配置基本参数
			this.targetElement = $(imageList.target)[0],this.photoImageList = this.targetElement.getAttribute("data-imagelist").split("||"),this.photoImageName = this.targetElement.getAttribute("data-imagename"),this.photoAlbum = $(setting.container)[0],this.photoContainer = $(setting.photoContainer)[0],this.photoCtrlL = $(setting.prevButton)[0],this.photoCtrlR = $(setting.nextButton)[0],this.photoInfoBar = $(setting.photoToolbar)[0],this.photoShadow = $(setting.photoImage)[0],this.navContainer = $(setting.photoImageList)[0],this.currentCount = $(setting.curImgNum)[0],this.countAll = $(setting.allImgNum)[0],this.photoName = $(setting.photoName)[0],this.currentClass = setting.activeClass || "active-show";
			this.photoAuto();
			this.photoAlbumResize();
			this.photoAlbumCreat();
			this.photoAlbumControl()
		},
		setCSS: function(applyObj, style) {
			if (typeof style == 'object') {//css函数
				var cssName = [],cssData = [];
				for (name in style) {cssName.push(name);cssData.push(style[name])};
				for (var i = 0; i < cssName.length; i++) {applyObj.style[cssName[i]] = cssData[i]}
			}
		},
		photoAlbumResize: function() {
			var adjustWidth = adjustHeight = domElmWidth = domElmHeight = calcWidth = calcHeight = 0;
			if (this.photoInfoBar && this.photoCtrlL) {//处理窗口缩放问题
				adjustWidth = this.photoInfoBar.clientHeight;
				adjustHeight = this.photoCtrlL.clientWidth;
				domElmWidth = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth;
				domElmHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight;
				calcWidth = (domElmWidth - ((adjustHeight * 2.5)));
				calcHeight = (domElmHeight - ((adjustWidth * 2.5)));
				this.setCSS(this.photoContainer, {height: calcHeight + 'px',width: calcWidth + 'px',position:'fixed',top: (adjustWidth * 1.25) + 'px',left: (adjustHeight * 1.25) + 'px'});
				this.setCSS(this.photoAlbum, {width: domElmWidth + 'px',height: domElmHeight + 'px',top: 0,left: 0,zIndex: 100005})
			}
		},
		photoAlbumCreat: function() {
			var thumbnailLength, thumbnailWraper = this.navContainer,thumbnailImageLIst = this.photoImageList,photoShadow = this.photoContainer,countAll = this.countAll,currentCount = this.currentCount;
			if (thumbnailImageLIst && thumbnailWraper) {
				thumbnailLength = thumbnailImageLIst.length;
				thumbnailWraper.innerHTML = "";
				for (var i = 0; i < thumbnailLength; i++) {//根据imageList添加相册缩略图
					thumbnailWraper.innerHTML += "<li data-index=" + i + "><div class=box-shadow></div><img src=" + thumbnailImageLIst[i] + "></li>"
				};
				countAll.innerHTML = thumbnailLength;
				currentCount.innerHTML = 1
			};
			thumbnailWraper.getElementsByTagName('li')[0].className = this.currentClass;
			this.photoName.innerHTML = this.photoImageName;//添加相册名称
			this.photoShadow.innerHTML = "<img alt='undefined' class='shadow-image' src=" + thumbnailImageLIst[0] + ">";//添加第一张图片到photoShadow
		},
		photoAlbumControl: function() {
			var ctrlButtonLeft, ctrlButtonRight, thumbnailImageLIst, thumbnailChild, thumbnailLength, calcCount = 0,index, picture, pictureURL, applyObj = this;
			if (this.photoCtrlL && this.photoCtrlR && this.navContainer && this.photoContainer) {
				picture = this.photoContainer.getElementsByTagName('img')[0], ctrlButtonLeft = this.photoCtrlL, ctrlButtonRight = this.photoCtrlR, thumbnailImageLIst = this.navContainer, thumbnailChild = thumbnailImageLIst.getElementsByTagName('li'), thumbnailLength = thumbnailChild.length;
				ctrlButtonLeft.onclick = function() {//点击按钮，实现上一张操作
					calcCount--;
					if (calcCount >= thumbnailLength || calcCount <= -1) {
						calcCount = thumbnailLength - 1
					};
					for (var i = 0; i < thumbnailLength; i += 1) {
						thumbnailChild[i].className = ""
					};
					applyObj.photoShadow.innerHTML = "";
					thumbnailChild[calcCount].className = applyObj.currentClass;
					applyObj.currentCount.innerHTML = (parseInt(calcCount) + 1);
					applyObj.photoShadow.innerHTML = "<img alt='undefined' class='shadow-image' style='opacity:0' src=" + thumbnailChild[calcCount].getElementsByTagName('img')[0].src + ">";
					$('.shadow-image').animate({opacity: 1}, 320)
				};
				ctrlButtonRight.onclick = function() {//点击按钮，实现下一张操作
					calcCount++;
					if (calcCount >= thumbnailLength || calcCount <= 0) {
						calcCount = 0
					}
					for (var i = 0; i < thumbnailLength; i += 1) {
						thumbnailChild[i].className = ""
					};
					applyObj.photoShadow.innerHTML = "";
					thumbnailChild[calcCount].className = applyObj.currentClass;
					applyObj.currentCount.innerHTML = (parseInt(calcCount) + 1);
					applyObj.photoShadow.innerHTML = "<img alt='undefined' class='shadow-image' style='opacity:0' src=" + thumbnailChild[calcCount].getElementsByTagName('img')[0].src + ">";
					$('.shadow-image').animate({opacity: 1}, 320)
				};
				for (var i = 0; i < thumbnailLength; i++) {//点击缩略图，实现全局操作
					thumbnailChild[i].onclick = function() {
						calcCount = this.getAttribute('data-index');
						for (var i = 0; i < thumbnailLength; i++) {
							thumbnailChild[i].className = ""
						};
						applyObj.photoShadow.innerHTML = "";
						thumbnailChild[calcCount].className = applyObj.currentClass;
						applyObj.currentCount.innerHTML = (parseInt(calcCount) + 1);
						applyObj.photoShadow.innerHTML = "<img alt='undefined' class='shadow-image' style='opacity:0' src=" + thumbnailChild[calcCount].getElementsByTagName('img')[0].src + ">";
						$('.shadow-image').animate({opacity: 1}, 320)
					}
				}
			}
		},
		photoAuto: function() {
			var applyObj = this;//缩放事件
			window.onresize = function() {applyObj.photoAlbumResize()}
		},
	}
})($);
</script>
</body>
</html>
