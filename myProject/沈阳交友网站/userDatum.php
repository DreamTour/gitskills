<?php
include "mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
$search_khid = mysql_fetch_assoc(mysql_query("select * from kehu where khid = '$_GET[search_khid]' "));
$Region = mysql_fetch_assoc(mysql_query("select * from region where id = '$search_khid[RegionId]' "));
$age = date("Y") - substr($search_khid['Birthday'],0,4);
if(empty($search_khid['khid'])){
	header("Location:{$root}m/mindex.php");
	exit(0);
}
//记录谁看过我
$TargetId = $_GET['search_khid'];//被看过的客户的ID号
$num = mysql_num_rows(mysql_query(" select * from follow where type = '2' and khid = '$kehu[khid]' and TargetId = '$TargetId' "));
//判断
if($num == 0){
	$id = suiji();
	mysql_query(" insert into follow (id,type,khid,TargetId,time) values ('$id','2','$kehu[khid]','$TargetId','$time') ");
}
//我的相册
$sql = mysql_query("select * from kehuImg where khid = '$search_khid[khid]' order by time desc ");
$sqlNum = mysql_num_rows(mysql_query("select * from kehuImg where khid = '$search_khid[khid]' "));
$img = "";
if($sqlNum == 0){
	$img = "一张图片都没有";	
}else{
	$ImgArray = array();
	while($array = mysql_fetch_assoc($sql)){
		$img .= "<img class='see_img' src='{$root}{$array['src']}'>";
		array_push($ImgArray,"{$root}{$array['src']}");	
	}	
}
//检查是否已经关注过  如果已经关注打印已关注
$followNum = mysql_num_rows(mysql_query("select * from follow where type = '1' and khid = '$kehu[khid]' and TargetId = '$_GET[search_khid]' "));
if($followNum > 0){
	$value = "取消关注";	
	
}else{
	$value = "关注";
}
//包年包月发信
$minMonth = date("Y-m-d H:i:s",strtotime("$time - 1 month"));//当前时间减去一个月
$payMonth = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包月' and khid = '$search_khid[khid]' and WorkFlow = '已支付' and UpdateTime > '$minMonth' "));
$minYear = date("Y-m-d H:i:s",strtotime("$time - 1 year"));//当前时间减去一年
$payYear = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包年' and khid = '$search_khid[khid]' and WorkFlow = '已支付' and UpdateTime > '$minYear' "));
if($payYear>0){
	$Grade = "年会员";	
}else if($payMonth>0){
	$Grade = "月会员";	
}else{
	$Grade = "普通会员";	
}
//送礼物
$giftSql = mysql_query("select * from Gift");
$giftNum = mysql_num_rows(mysql_query("select * from Gift"));
$gift = array();
$count = 1;
if($giftNum == 0){
	array_push($gift,"一个礼物都没有");	
}
while($array = mysql_fetch_assoc($giftSql)){
	if($count == 1){
		$html = "<i class='ico'></i>";
		$GiftId = $array['id'];
	}else{
		$html = "";
	}
	array_push($gift,"<li GiftId='{$array['id']}' data-price=\"{$array['price']}\"><img src='{$root}{$array['ico']}' />{$html}</li>");
	$count++;
}
//查看微信号
$startTime = date("Y-m-d")." 00:00:00";//今天开始时间
$EndTime = date("Y-m-d")." 23:59:59";//今天结束时间
//今天是否给这个客户因为查看微信支付过款项
$weChatPay = mysql_num_rows(mysql_query(" select * from pay where classify = '查看微信号' and khid = '$kehu[khid]' and clientId = '$search_khid[khid]' and WorkFlow = '已支付' and UpdateTime > '$startTime' and UpdateTime < '$EndTime' "));
if($weChatPay > 0){
	$weChatNum = "{$search_khid['wxNum']}";
}else{
	$weChatNum = "点击查看";	
	$payCondition = "true";
}
//是否显示V
if($search_khid['authentication'] == "是"){
	$vIcon = " style='background:url(".root."img/WebsiteImg/Ffc54255421gK.jpg);background-size:15px 15px;' ";
}
?>
<style>
	.my-content .vip-photo{padding: 10px 0 10px 10px;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin: 15px 0 10px;}
	.vip-photo-scroll{ position:relative;}
	.vip-photo-inset{    display: flex;
    overflow: scroll;}
body{position:relative;}
.hide{ display:none;}
.send-letter-bg,.send-letter,.send-gift-bg,.send-gift{position:fixed;top:0;bottom:0;right:0;left:0;margin:auto;color:#fff;}
.send-letter-bg,.send-gift-bg{background-color:rgba(0,0,0,.4);z-index:2;}
.send-letter,.send-gift{width:90%;height:50%;z-index:3;box-shadow:0 0 5px rgba(0, 0, 0, 0.5);}
.pop-top{background-color:#fd8eb9;}
.pop-top h5{padding:8px 0 8px 5px;}
.pop-icon{display:inline-block;width:12px;height:12px;background:url(<?php echo img("YgH55362469IL");?>)no-repeat scroll center/20px 20px;margin:9px 5px 0 0;}
.send-letter form{width:100%;height:100%;}
.send-letter textarea{margin:20px;height:60%;margin:5%;min-height:30%;width:90%;padding:10px;}
.send-gift .list{ display:flex;padding:2%;color:#666; flex-wrap:wrap;}
.send-gift .list img{border-radius:4px;}
.send-gift .list li{-webkit-box-flex:1;margin: 1%; width:18%; position:relative;}
.send-gift .list i{    display: block;
    height: 13px;
    width: 13px;
    position: absolute;
    bottom: 0px;
    right: 0px;
	background: url(<?php echo img("PPM50625481WQ");?>) no-repeat -9px -1px;}
.pop-re-btn{display:block;width:25%;height:30px;line-height:30px;background-color:#f9a61c;text-align:center;border-radius:3px;margin-right:15px;}
.shade img{ width:100%;}
.shade{ position:fixed; top:0; left:0; bottom:0; right:0; background: rgba(33,33,33,.9); display:-webkit-box; -webkit-box-align:center; -webkit-box-pack:center; color:#fff; z-index:999;}
.shade_content{ margin:0 5%; width:90%;}
.content_count{ position:absolute; left:0; bottom:1%; width:100%; text-align:center;}
.content_count li{ display:inline-block; color:transparent; width:10px; height:10px; background:rgba(204,204,204,.6); margin:0 3px; border-radius:50%;}
.content_count .on{ background:#F60 !important}
</style>
<!--头部-->
<div class="header fz16">
    <div class="head-center">	<div class="head-left"><a href="<?php echo "{$root}m/mindex.php";?>" class="col1"><返回</a></div>
</div>
</div>
<!--我的-->
<div class="my-content">
	<div class="my-top">
        <div class="my-in of">
        	<img src="<?php echo HeadImg($search_khid['sex'],$search_khid['ico'])?>" class="fl">
            <div class="my-title fl">
            	<p class="col1 fz16 fw2"><?php echo $search_khid['NickName']?></p>
                <p class="col1 fz14"><?php echo $Grade;?><i class="v-icon" <?php echo $vIcon;?>></i></p>
            </div>
        </div>
    </div>
 <!--个人资料-->
 	 <ul>
     	 <li class="vip-photo bg2">
            <div class="vip-photo-scroll">
               <div class="vip-photo-inset">
               		<?php echo $img;?>	
               </div>
            </div>
         </li>
     	 <li class="my-personal">
            <h2 class="col"><p class="my-line bg1"></p><span>内心独白</span></h2>
            <div class="my-pe-list bg2">
            	<ul class="pe-item-box">
                    <li class="pe-item"><p class="fz14"><?php echo kong($search_khid['summary']);?></p></li>
            </div>
         </li>
         <li class="my-personal">
            <h2 class="col"><p class="my-line bg1"></p><span>基本信息</span></h2>
            <div class="my-pe-list bg2">
                <ul class="pe-item-box">
                    <li class="pe-item"><span>微信名</span><s><?php echo kong($search_khid['NickName']);?></s></li>
                    <li class="pe-item"><span>性别</span><s><?php echo kong($search_khid['sex']);?></s></li>
                    <li class="pe-item"><span>年龄</span><s><?php echo kong($age);?>岁</s></li>
                    <li class="pe-item"><span>生肖</span><s><?php echo kong($search_khid['Zodiac']);?></s></li>
                    <li class="pe-item"><span>星座</span><s><?php echo kong($search_khid['constellation']);?></s></li>
                    <li class="pe-item"><span>民族</span><s><?php echo kong($search_khid['Nation']);?></s></li>
                    <li class="pe-item"><span>身高</span><s><?php echo kong($search_khid['height']);?>cm</s></li>
                    <li class="pe-item"><span>体重</span><s><?php echo kong($search_khid['weight']);?>斤</s></li>
                    <li class="pe-item"><span>学历</span><s><?php echo kong($search_khid['degree']);?></s></li>
                    <li class="pe-item"><span>婚育情况</span><s><?php echo kong($search_khid['marry']);?></s></li>
                    <li class="pe-item"><span>家乡</span><s><?php echo kong($search_khid['Hometown']);?></s></li>
                    <li class="pe-item"><span>所在地区</span><s><?php echo kong($Region['area']);?></s></li>
                    <li class="pe-item"><span>工作</span><s><?php echo kong($search_khid['Occupation']);?></s></li>
                    <li class="pe-item"><span>月收入</span><s style="border:none;"><?php echo kong($search_khid['salary']);?></s></li>
                </ul>
            </div>
         </li>
         <li class="my-personal">
            <h2 class="col"><p class="my-line bg1"></p><span>详细信息</span></h2>
            <div class="my-pe-list bg2">
                <ul class="pe-item-box">
                    <li class="pe-item"><span>吸烟</span><s><?php echo kong($search_khid['smoke']);?></s></li>
                    <li class="pe-item"><span>饮酒</span><s><?php echo kong($search_khid['drink']);?></s></li>
                    <li class="pe-item"><span>购房情况</span><s><?php echo kong($search_khid['BuyHouse']);?></s></li>
                    <li class="pe-item"><span>购车情况</span><s><?php echo kong($search_khid['BuyCar']);?></s></li>
                    <li class="pe-item"><span>贷款</span><s><?php echo kong($search_khid['loan']);?></s></li>
                    <li class="pe-item"><span>兴趣爱好</span><s><?php echo kong($search_khid['Hobby']);?></s></li>
                    <li class="pe-item"><span>优点</span><s><?php echo kong($search_khid['Advantage']);?></s></li>
                    <li class="pe-item"><span>缺点</span><s><?php echo kong($search_khid['defect']);?></s></li>
                    <li class="pe-item"><span>家中排行</span><s><?php echo kong($search_khid['HomeRanking']);?></s></li>
                    <li class="pe-item"><span>家庭成员</span><s><?php echo kong($search_khid['family']);?></s></li>
                    <li class="pe-item"><span>微信号</span><s style="border:none;"><a href="javascript:;" class="vip_btn bg1 col1" weChatpay=<?php echo $payCondition;?>><?php echo $weChatNum;?></a></s></li>
                </ul>
            </div>
         </li>
         <li class="my-personal">
            <h2 class="col"><p class="my-line bg1"></p><span>择偶意向</span></h2>
            <div class="my-pe-list bg2">
                <ul class="pe-item-box">
                    <li class="pe-item"><span>年龄</span><s><?php echo kong($search_khid['LoveAgeMin']);?>-<?php echo kong($search_khid['LoveAgeMax']);?>岁</s></li>
                    <li class="pe-item"><span>生肖</span><s><?php echo kong($search_khid['LoveZodiac']);?></s></li>
                    <li class="pe-item"><span>星座</span><s><?php echo kong($search_khid['LoveConstellation']);?></s></li>
                    <li class="pe-item"><span>民族</span><s><?php echo kong($search_khid['LoveNation']);?></s></li>
                    <li class="pe-item"><span>身高</span><s><?php echo kong($search_khid['LoveHeightMin']);?>-<?php echo kong($search_khid['LoveHeightMax']);?>cm</s></li>
                    <li class="pe-item"><span>体重</span><s><?php echo kong($search_khid['LoveWeightMin']);?>-<?php echo kong($search_khid['LoveWeightMax']);?>斤</s></li>
                    <li class="pe-item"><span>学历</span><s><?php echo kong($search_khid['LoveDegree']);?></s></li>
                    <li class="pe-item"><span>婚育情况</span><s><?php echo kong($search_khid['LoveMarry']);?></s></li>
                    <li class="pe-item"><span>家乡</span><s><?php echo kong($search_khid['LoveHometown']);?></s></li>
                    <li class="pe-item"><span>所在地区</span><s><?php echo empty($loveRegion['area'])?'不限':$loveRegion['area'];?></s></li>
                    <li class="pe-item"><span>工作</span><s><?php echo kong($search_khid['LoveOccupation']);?></s></li>
                    <li class="pe-item"><span>月收入</span><s><?php echo kong($search_khid['LoveSalary']);?></s></li>
                    <li class="pe-item"><span>吸烟</span><s><?php echo kong($search_khid['LoveSmoke']);?></s></li>
                    <li class="pe-item"><span>饮酒</span><s><?php echo kong($search_khid['LoveDrink']);?></s></li>
                    <li class="pe-item"><span>购房情况</span><s><?php echo kong($search_khid['LoveHouse']);?></s></li>
                    <li class="pe-item"><span>购车情况</span><s><?php echo kong($search_khid['LoveCar']);?></s></li>
                    <li class="pe-item"><span>贷款</span><s><?php echo kong($search_khid['LoveLoan']);?></s></li>
                    <li class="pe-item"><span>兴趣爱好</span><s><?php echo kong($search_khid['LoveHobby']);?></s></li>
                    <li class="pe-item"><span>优点</span><s><?php echo kong($search_khid['LoveAdvantage']);?></s></li>
                    <li class="pe-item"><span>缺点</span><s><?php echo kong($search_khid['LoveDefect']);?></s></li>
                    <li class="pe-item"><span>家中排行</span><s><?php echo kong($search_khid['LoveHomeRanking']);?></s></li>
                    <li class="pe-item"><span>家庭成员</span><s style="border:none;"><?php echo kong($search_khid['LoveFamily']);?></s></li>
                </ul>
            </div>
         </li>
     </ul>
</div>
<div class="vip-footer">
	<a href="javascript:;" class="vip-footer-nav" data-letter='<?php echo $_GET['search_khid'];?>'><i class="vip-icon vip-icon1"></i><span class="col1 fz16 fw2">发信</span></a>
    <a href="javascript:;"class="vip-footer-nav" follow='<?php echo $_GET['search_khid'];?>'><i class="vip-icon vip-icon2"></i><span class="col1 fz16 fw2"><?php echo $value;?></span></a>
    <a href="javascript:;"class="vip-footer-nav" data-id='<?php echo $_GET['search_khid'];?>'><i class="vip-icon vip-icon3"></i><span class="col1 fz16 fw2">送礼物</span></a>
</div>
<div class="send-letter-bg hide"></div>
<div class="send-letter bg2 of hide">
	<div class="pop-top of"><h5 class="fl">发信</h5><i class="pop-icon fr"></i></div>
    <form name="sendLetterForm">
    	<textarea name="sendLetter"></textarea>
	    <input type="hidden" name="TargetId" value="" />
        <a href="javascript:;" class="pop-re-btn fr col1 fz14" id="send_letter">点击发信</a> 
    </form>
</div>
<div class="send-gift-bg hide"></div>
<div class="send-gift bg2 of hide">
	<div class="pop-top of"><h5 class="fl">送礼物</h5><i class="pop-icon fr close"></i></div>
    	<ul class="list">
        	<?php echo implode('',$gift);?>
        </ul>
    <a href="javascript:;" class="pop-re-btn fr col1 fz14" id="send-mes">点击发送</a> 
</div>
<div class="shade hide" data-img="<?php echo join('||',$ImgArray);?>">
    <div class="shade_content" id="shade_content">
        <ul class="content_img"></ul>
        <ul class="content_count"></ul>
    </div>
</div>
</body>
</html>
<?php echo warn().choosePay();?>
<script>
$(function(){
	//送礼物支付弹出层
	function openGiftpay(){
		this.eject();
	}
	openGiftpay.prototype = {
		eject:function(){
			var _this = this;
			$('#send-mes').click(function(){
				_this.Show();
				var price = _this.giftPrice();
				$('[data-title]').html('赠送礼物');
				$('[data-money]').html('￥'+price);
				$('#bg-gift').hide();
				$('#gift').hide();
				$('[name=PayForm] [name=PayType]').val('赠送礼物'); 	
			})	
		},
		Show:function(){
			$('.popup-background').show();
			$('.popup-box').show();	
		},
		Hide:function(){
			$('.popup-background').hide();
			$('.popup-box').hide();
		},
		giftPrice:function(){
			var price = 0;
			$('[data-price]').each(function(index, element) {
				if($(this).find('i').hasClass('ico')){
					price=$(this).attr('data-price');
				}
			});		
			return price;
		}	
	}
	new openGiftpay();
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
	//送礼物
	function gift(){
		this.eject();
		this.Close();
		this.choose();
		this.getValue();
	}
	gift.prototype = {
		Show:function(){
			$('.send-gift-bg').show();
			$('.send-gift').show();	
		},
		Hide:function(){
			$('.send-gift-bg').hide();
			$('.send-gift').hide();
		},
		eject:function(){
			_this = this;
			$('[data-id]').click(function(){
				_this.Show();
				$('[name=PayForm] [name=TypeId]').val($(this).attr('data-id'));
			})	
		},
		Close:function(){
			_this = this;
			$('.close').click(function(){
				_this.Hide();	
			})	
		},
		choose:function(){
			$('.send-gift li').click(function(){
				var GiftId = $(this).attr('GiftId');
				$(this).parent().find('i').appendTo($(this));
				$(this).siblings().find('i').remove();
				$('[name=PayForm] [name=GiftId]').val(GiftId);
			});	
		},
		getValue:function(){
			$('[name=PayForm] [name=GiftId]').val('<?php echo $GiftId;?>'); 	
		}
	}
	new gift();
	//发信
	$("[data-letter]").click(function(){
		var TargetId = $(this).attr('data-letter');
		$("[name=TargetId]").val(TargetId);
	})
	$("#send_letter").click(function(e) {
        $.ajax({
			url: "<?php echo "{$root}library/usData.php";?>",
			async:false,
			data: $("[name=sendLetterForm]").serialize(),
			type:"POST",
			dataType:"json",
			success: function(data){
				if(data.warn == 2){
					window.location.reload();
				}else{
					warn(data.warn);
				}
			},
			error: function(){
				alert('服务器错误');	
			}
		});
    });		
	function letter(){
		this.eject();
		this.Close();	
	}
	letter.prototype = {
		show:function(){
			$('.send-letter-bg').show();
			$('.send-letter').show();
		},
		hide:function(){
			$('.send-letter-bg').hide();
			$('.send-letter').hide();	
		},
		eject:function(){
			self = this;
			$('[data-letter]').click(function(){
				self.show();
			})	
		},
		Close:function(){
			self = this;
			$('.pop-icon').click(function(){
				self.hide();	
			})	
		}	
	}
	new letter();
	//记录谁关注我
	$("[follow]").click(function(){
		var follow = $(this).attr('follow');
		var _this = $(this);
		$.ajax({
			url: "<?php echo "{$root}library/usData.php";?>",
			async:false,
			data: {follow:follow},
			type:"POST",
			dataType:"json",
			success: function(data){
				warn(data.warn);
				if(data.flag == 2){
					_this.find('span').text('取消关注');
				}
				if(data.warn == "取消成功"){
					_this.find('span').text('关注');
				}
			},
			error: function(){
				alert('服务器错误');	
			}
		});
	})
	//查看图片
	var shade = $('.shade');
	var Body = $('body');
	var imglist = shade.attr('data-img').split('||');
	var shade_content = $('.shade_content ul');
	for( var i=0;i<imglist.length;i++ ){
		shade_content.append("<li><img alt=undefined src="+imglist[i]+"></li>")
	}
	TouchSlide({              
	  slideCell:"#shade_content",             
	  titCell:"#shade_content .content_count",             
	  mainCell:"#shade_content .content_img",              
	  effect:"leftLoop",              
	  autoPage:true,             
	  autoPlay:false              
	}); 
	shade.hide();
	$('.see_img').click(function(){
		shade.show();
		Body.css({'overflow':'hidden','height':'auto'});	
	})
	shade.click(function(){
		$(this).hide();
		Body.css({'overflow':'auto','height':'auto'});	
	})
	
})
var TouchSlide = function(a) {
		a = a || {};
		var b = {
			slideCell: a.slideCell || "#touchSlide",
			titCell: a.titCell || ".hd li",
			mainCell: a.mainCell || ".bd",
			effect: a.effect || "left",
			autoPlay: a.autoPlay || !1,
			delayTime: a.delayTime || 200,
			interTime: a.interTime || 2500,
			defaultIndex: a.defaultIndex || 0,
			titOnClassName: a.titOnClassName || "on",
			autoPage: a.autoPage || !1,
			prevCell: a.prevCell || ".prev",
			nextCell: a.nextCell || ".next",
			pageStateCell: a.pageStateCell || ".pageState",
			pnLoop: "undefined " == a.pnLoop ? !0 : a.pnLoop,
			startFun: a.startFun || null,
			endFun: a.endFun || null,
			switchLoad: a.switchLoad || null
		},
			c = document.getElementById(b.slideCell.replace("#", ""));
		if (!c) return !1;
		var d = function(a, b) {
				a = a.split(" ");
				var c = [];
				b = b || document;
				var d = [b];
				for (var e in a) 0 != a[e].length && c.push(a[e]);
				for (var e in c) {
					if (0 == d.length) return !1;
					var f = [];
					for (var g in d) if ("#" == c[e][0]) f.push(document.getElementById(c[e].replace("#", "")));
					else if ("." == c[e][0]) for (var h = d[g].getElementsByTagName("*"), i = 0; i < h.length; i++) {
						var j = h[i].className;
						j && -1 != j.search(new RegExp("\\b" + c[e].replace(".", "") + "\\b")) && f.push(h[i])
					} else for (var h = d[g].getElementsByTagName(c[e]), i = 0; i < h.length; i++) f.push(h[i]);
					d = f
				}
				return 0 == d.length || d[0] == b ? !1 : d
			},
			e = function(a, b) {
				var c = document.createElement("div");
				c.innerHTML = b, c = c.children[0];
				var d = a.cloneNode(!0);
				return c.appendChild(d), a.parentNode.replaceChild(c, a), m = d, c
			},
			g = function(a, b) {
				!a || !b || a.className && -1 != a.className.search(new RegExp("\\b" + b + "\\b")) || (a.className += (a.className ? " " : "") + b)
			},
			h = function(a, b) {
				!a || !b || a.className && -1 == a.className.search(new RegExp("\\b" + b + "\\b")) || (a.className = a.className.replace(new RegExp("\\s*\\b" + b + "\\b", "g"), ""))
			},
			i = b.effect,
			j = d(b.prevCell, c)[0],
			k = d(b.nextCell, c)[0],
			l = d(b.pageStateCell)[0],
			m = d(b.mainCell, c)[0];
		if (!m) return !1;
		var N, O, n = m.children.length,
			o = d(b.titCell, c),
			p = o ? o.length : n,
			q = b.switchLoad,
			r = parseInt(b.defaultIndex),
			s = parseInt(b.delayTime),
			t = parseInt(b.interTime),
			u = "false" == b.autoPlay || 0 == b.autoPlay ? !1 : !0,
			v = "false" == b.autoPage || 0 == b.autoPage ? !1 : !0,
			w = "false" == b.pnLoop || 0 == b.pnLoop ? !1 : !0,
			x = r,
			y = null,
			z = null,
			A = null,
			B = 0,
			C = 0,
			D = 0,
			E = 0,
			G = /hp-tablet/gi.test(navigator.appVersion),
			H = "ontouchstart" in window && !G,
			I = H ? "touchstart" : "mousedown",
			J = H ? "touchmove" : "",
			K = H ? "touchend" : "mouseup",
			M = m.parentNode.clientWidth,
			P = n;
		if (0 == p && (p = n), v) {
			p = n, o = o[0], o.innerHTML = "";
			var Q = "";
			if (1 == b.autoPage || "true" == b.autoPage) for (var R = 0; p > R; R++) Q += "<li>" + (R + 1) + "</li>";
			else for (var R = 0; p > R; R++) Q += b.autoPage.replace("$", R + 1);
			o.innerHTML = Q, o = o.children
		}
		"leftLoop" == i && (P += 2, m.appendChild(m.children[0].cloneNode(!0)), m.insertBefore(m.children[n - 1].cloneNode(!0), m.children[0])), N = e(m, '<div class="tempWrap" style="overflow:hidden; position:relative;"></div>'), m.style.cssText = "width:" + P * M + "px;" + "position:relative;overflow:hidden;padding:0;margin:0;";
		for (var R = 0; P > R; R++) m.children[R].style.cssText = "display:table-cell;vertical-align:top;width:" + M + "px";
		var S = function() {
				"function" == typeof b.startFun && b.startFun(r, p)
			},
			T = function() {
				"function" == typeof b.endFun && b.endFun(r, p)
			},
			U = function(a) {
				var b = ("leftLoop" == i ? r + 1 : r) + a,
					c = function(a) {
						for (var b = m.children[a].getElementsByTagName("img"), c = 0; c < b.length; c++) b[c].getAttribute(q) && (b[c].setAttribute("src", b[c].getAttribute(q)), b[c].removeAttribute(q))
					};
				if (c(b), "leftLoop" == i) switch (b) {
				case 0:
					c(n);
					break;
				case 1:
					c(n + 1);
					break;
				case n:
					c(0);
					break;
				case n + 1:
					c(1)
				}
			},
			V = function() {
				M = N.clientWidth, m.style.width = P * M + "px";
				for (var a = 0; P > a; a++) m.children[a].style.width = M + "px";
				var b = "leftLoop" == i ? r + 1 : r;
				W(-b * M, 0)
			};
		window.addEventListener("resize", V, !1);
		var W = function(a, b, c) {
				c = c ? c.style : m.style, c.webkitTransitionDuration = c.MozTransitionDuration = c.msTransitionDuration = c.OTransitionDuration = c.transitionDuration = b + "ms", c.webkitTransform = "translate(" + a + "px,0)" + "translateZ(0)", c.msTransform = c.MozTransform = c.OTransform = "translateX(" + a + "px)"
			},
			X = function(a) {
				switch (i) {
				case "left":
					r >= p ? r = a ? r - 1 : 0 : 0 > r && (r = a ? 0 : p - 1), null != q && U(0), W(-r * M, s), x = r;
					break;
				case "leftLoop":
					null != q && U(0), W(-(r + 1) * M, s), -1 == r ? (z = setTimeout(function() {
						W(-p * M, 0)
					}, s), r = p - 1) : r == p && (z = setTimeout(function() {
						W(-M, 0)
					}, s), r = 0), x = r
				}
				S(), A = setTimeout(function() {
					T()
				}, s);
				for (var c = 0; p > c; c++) h(o[c], b.titOnClassName), c == r && g(o[c], b.titOnClassName);
				0 == w && (h(k, "nextStop"), h(j, "prevStop"), 0 == r ? g(j, "prevStop") : r == p - 1 && g(k, "nextStop")), l && (l.innerHTML = "<span>" + (r + 1) + "</span>/" + p)
			};
		if (X(), u && (y = setInterval(function() {
			r++, X()
		}, t)), o) for (var R = 0; p > R; R++)!
		function() {
			var a = R;
			o[a].addEventListener("click", function() {
				clearTimeout(z), clearTimeout(A), r = a, X()
			})
		}();
		k && k.addEventListener("click", function() {
			(1 == w || r != p - 1) && (clearTimeout(z), clearTimeout(A), r++, X())
		}), j && j.addEventListener("click", function() {
			(1 == w || 0 != r) && (clearTimeout(z), clearTimeout(A), r--, X())
		});
		var Y = function(a) {
				clearTimeout(z), clearTimeout(A), O = void 0, D = 0;
				var b = H ? a.touches[0] : a;
				B = b.pageX, C = b.pageY, m.addEventListener(J, Z, !1), m.addEventListener(K, $, !1)
			},
			Z = function(a) {
				if (!H || !(a.touches.length > 1 || a.scale && 1 !== a.scale)) {
					var b = H ? a.touches[0] : a;
					if (D = b.pageX - B, E = b.pageY - C, "undefined" == typeof O && (O = !! (O || Math.abs(D) < Math.abs(E))), !O) {
						switch (a.preventDefault(), u && clearInterval(y), i) {
						case "left":
							(0 == r && D > 0 || r >= p - 1 && 0 > D) && (D = .4 * D), W(-r * M + D, 0);
							break;
						case "leftLoop":
							W(-(r + 1) * M + D, 0)
						}
						null != q && Math.abs(D) > M / 3 && U(D > -0 ? -1 : 1)
					}
				}
			},
			$ = function(a) {
				0 != D && (a.preventDefault(), O || (Math.abs(D) > M / 10 && (D > 0 ? r-- : r++), X(!0), u && (y = setInterval(function() {
					r++, X()
				}, t))), m.removeEventListener(J, Z, !1), m.removeEventListener(K, $, !1))
			};
		m.addEventListener(I, Y, !1)
	};	
</script>
