<?php 
include "library/PcFunction.php";
echo head("pc");
UserRoot("pc");
limit($kehu);
//生成年龄下拉菜单
for($n = 18;$n <= 60;$n++){
		$option[$n] = $n."岁";
	}
$Age1 = select('searchMinAge','s_style2',"年龄",$option);
$Age2 = select('searchMaxAge','s_style2',"年龄",$option);
$ThisUrl = root."index.php";
$sql = " select * from kehu where Auditing = '已通过' and khid != '$kehu[khid]' ".$_SESSION['userSearch']['Sql'];
paging($sql," order by rankingTop='是' desc,UpdateTime desc ",12);
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
				<a class='photo' href='{$root}searchMx.php?search_khid={$array['khid']}'>
					<img style='width:120px;height:150px;' src='".HeadImg($array['sex'],$array['ico'])."'>
				</a>
				<h2>".kong($array['NickName'])."</h2>
				<div class='content_text'>
					<span>{$age}岁</span><span>{$Region['city']}</span><span>{$Region['area']}</span>
				</div>
				<a class='say_hi' href='javascript:;' let_btn='{$array['khid']}'>发信</a>
				<a class='give_gift' href='javascript:;' data-id='{$array['khid']}'>送礼物</a>
             </div>
         </div>
		";
	}
}
?>
<style>
.icon{background-image:url(<?php echo img("WxN53377734Xb");?>);}
.banner{height:450px;margin:auto;overflow:hidden;position:relative}
#banner-scontainer{position:absolute;overflow:hidden;height:450px;top:0;width:100%}
#banner-scontainer .list-item li{float:left;height:450px}
#banner-scontainer .list-item:after{content:'';display:block;clear:both}
#banner-scontainer .sort-item{position:absolute;width:100%;bottom:20px;left:0;z-index:100;text-align:center}
#banner-scontainer .sort-item li{width:10px;height:10px;background:#fff;display:inline-block;margin:0 5px}
#banner-scontainer .sort-item .cur{background:#C00!important}
.content{width:1000px;margin:auto;height:960px;margin-top:20px}
.content select{font-size:14px}
.search_box{width:700px;height:960px;background:#f6f6f6;float:left}
.search_content{float:right;width:280px}
.search_top{height:35px;line-height:35px;margin:20px;overflow:hidden}
.search_top *{float:left}
.search_bg{display:inline-block;width:32px;height:32px;background-position:-18px -146px;margin-top:3px}
.search_title{font-size:18px;font-weight:700;color:#000;margin:0 10px 0 5px}
.search_btn{float:right;display:inline-block;width:86px;height:34px;background-color:#ff7f00;text-align:center;border-radius:3px;color:#fff;font-size:16px;margin-right:10px}
.s_style2,.s_style3,.s_style4{height:30px;border:1px sold #ddd;margin-right:8px}
.s_style2{width:70px}
.s_style3{width:80px}
.s_style4{width:70px}
.search_content{clear:both;width:700px;padding-left:18px}
.content01_box{clear:both;width:152px;height:275px;background:#fff;border:1px solid #ccc;text-align:center;margin-right:15px;margin-bottom:20px;display:inline-block}
.content01{padding:10px;margin-top:10px}
.content01 h2{margin-top:10px;font-size:14px;color:#ff7c7c}
.content_text{margin:3px 0 8px 0}
.content_text span{margin-right:3px}
.give_gift,.say_hi{width:56px;height:24px;display:inline-block;background:#fff8f9;border:1px solid #ff7c7c;color:#ff7c7c;vertical-align:top;line-height:22px}
.give_gift{background:#ff7c7c;color:#fff}
.column_box{width:280px;height:960px;float:right}
.generalize,.meet_love{width:280px;border:1px solid #d9d9d9}
.meet_love{height:450px}
.meet_love_title{height:42px;line-height:42px;text-align:center;background-color:#f6f6f6}
.meet_love_icon{margin:9px 5px 0 18px;width:25px;height:25px;display:inline-block;float:left}
.meet_love_icon{background-position:-20px -199px}
.meet_love_title h2{float:left;font-size:16px;font-weight:700;color:#000}
.shop_box{height:126px}
.shop{width:250px;height:126px;border-bottom:1px dotted #d9d9d9;margin:0 15px;padding-top:30px}
.shop_icon{float:left;display:inline-block;width:65px;height:65px}
.shop_icon01{background-position:-90px -31px}
.shop_icon02{background-position:-90px -105px}
.shop_icon03{background-position:-90px -180px}
.shop_icon04{background-position:-90px -262px}
.shop_text{float:left;margin-left:15px}
.shop_text_title{font-size:14px;color:#ff7c7c;text-decoration:underline;margin-bottom:12px}
.shop_text_content1{margin:10px 0 4px 0}
.shop_text_icon{width:0;height:0;border-top:5px solid transparent;border-bottom:5px solid transparent;border-left:5px solid #ff7c7c;margin-right:2px}
#shop-special{border-bottom:none}
.index_ad{margin:15px 0;width:280px;overflow:hidden}
.generalize{border:1px solid #ddd;background:url(<?php echo img("JvE53377837cQ");?>) no-repeat scroll 0 0;text-align:center;padding:40px 18px 30px}
.generalize_content{margin:20px 0}
.generalize_content i{width:76px;height:76px;background-image:url(<?php echo img("aNs53377798ic");?>);background-position:0 0}
.generalize_content p{width:160px;word-break:break-all;text-overflow:ellipsis;text-align:justify}
.generalize_btn{display:inline-block;width:240px;line-height:48px;background-color:#ff7f00;text-align:center;color:#fff;border-radius:5px}
.ad{width:1000px;height:90px;clear:both;margin:50px auto}
/*::-webkit-scrollbar{ width:0;}*/
/*轮播图*/
#slider{position:relative;padding-top:140px;overflow:hidden;}
#sort-items{position:absolute; z-index:10; width:100%; bottom:10px; text-align:center;}
#sort-items li{color:transparent;display:inline-block;width:25px;height:6px;margin:0 3px;cursor:pointer;background:rgba(255,255,255,.6);}
.current{background-color:#006db2 !important}
.slider-btn{ position:absolute;margin:auto;top:0;bottom:0;width:100px;height:100px; z-index:10;}
</style>
    	<!--头部和导航-->
        <?php echo pcHeader();?>
        <!--banner-->
        <div class="banner">
            <div id="banner-scontainer" class="banner-scontainer">
                <div class="banner-listitem">
                    <ul class="list-item">
                        <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover"></li>
                        <li style="background:url(<?php echo img("paX53378607Rf");?>) no-repeat scroll center/cover"></li>
                        <li style="background:url(<?php echo img("OzS53378634dZ");?>) no-repeat scroll center/cover"></li>
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
<!--            	<div class="search_top">
                	<i class="search_bg icon"></i>
                     <form name="searchForm" action="<?php echo "{$root}library/usPost.php";?>" method="post">
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
                        <select name="area" class="s_style3">
                        <?php echo IdOption("region where province = '辽宁省' and city = '沈阳市'","id","area","--区县--",$_SESSION['userSearch']['area']);?>
                        </select>
                    </div>
                     <input class="search_btn" type="submit" value="搜索">
					</form>
                </div>
-->                <div class="search_content">
                    <?php echo $Search;?>
                </div>
            </div>
            <!--右侧栏目1 服务中心-->
            <div class="column_box">
            	<?php echo meet_love();?>
                <!--右侧栏目 广告-->
               <div class="index_ad"><a href="javascript:;"><img src="<?php echo img("SnF53377644ta");?>"></a></div> 
                <!--右侧栏目 推广-->
                <div class="generalize">
                	<h2 class="fz24 col fw2">邀请朋友就送免费发信</h2>
                    <div class="generalize_content of"><i class="fl"></i><p class="fr">推荐一位身边的单身朋友加入本站并成功成为会员 您就可以获得免费发信的权利  成功一人奖励一天 没有上限 多劳多得 让更多的单身朋友加入进来吧</p></div>
                    <a href="<?php echo "{$root}promotion.php";?>" class="generalize_btn fz18">立即邀请领取</a>
                </div>
            </div>
        </div>
    </div>
    <!--广告-->
<!--    <div class="ad">
        <a href="javascript:;"><img src="<?php echo img("uiJ53377569IG");?>"></a>
    </div>
-->   <!--底部-->
    <?php echo letter("","").send_gift().warn().choosePay().pcFooter();?>
<script>
$(function(){
	//支付弹出层
	function openGiftpay(){
		this.eject();
	}
	openGiftpay.prototype = {
		eject:function(){
			var _this = this;
			$('#send-mes').click(function(){
				_this.Show();
				var $price = _this.giftPrice();
				$('[data-title]').html('赠送礼物');
				$('[data-money]').html('￥'+$price);
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
			var $price = 0;
			$('[data-price]').each(function(index, element) {
				if($(this).hasClass('gift_current')){
					$price=$(this).attr('data-price');
				}
			});		
			return $price;
		}	
	}
	new openGiftpay();
	 //根据省份获取下属城市下拉菜单
	$(document).on('change','[name="searchForm"] [name=province]',function(){
		$.post('<?php echo root."library/OpenData.php";?>',{ProvincePostCity:$(this).val()},function(data){
			$('[name="searchForm"] [name=city]').html(data.city);
		},'json');
	});	
	//点击打招呼发送默认消息
	$("[sayHi]").click(function(){
		$.post("<?php echo root."library/usData.php";?>",{sayHi:$(this).attr("sayHi")},function(data){
			warn(data.warn);	
		},"json");	
	})
	//点击显示发信
	$("[let_btn]").click(function(){
		LG.show();
		document.sendLetterForm.TargetId.value = $(this).attr("let_btn");
	});
	//点击显示送礼物
	$("[data-id]").click(function(){
		G.show();
		document.PayForm.TypeId.value = $(this).attr("data-id");
	});
	/*同城搜索*/
	<?php 
	echo 
	KongSele("searchForm.searchSex",$_SESSION['userSearch']['sex']).
	KongSele("searchForm.searchMinAge",$_SESSION['userSearch']['minAge']).
	KongSele("searchForm.searchMaxAge",$_SESSION['userSearch']['maxAge']);
	?>
})
</script>  
</body>
</html>
