<?php 
include "library/PcFunction.php";
echo head("pc");
UserRoot("pc");
limit($kehu);
$ThisUrl = root."search.php";
$sql = " select * from kehu where Auditing = '已通过' and khid != '$kehu[khid]' ".$_SESSION['userSearch']['Sql'];
paging($sql," order by rankingTop='是' desc,UpdateTime desc ",18);
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
//生成年龄下拉菜单
for($n = 18;$n <= 60;$n++){
		$option[$n] = $n."岁";
	}
$Age1 = select('searchMinAge','s_style2',"年龄",$option);
$Age2 = select('searchMaxAge','s_style2',"年龄",$option);
?>
<style>
.icon{ background: url(<?php echo img("WxN53377734Xb");?>)}
/*广告*/
.ad{
	width:1000px;
	height:90px;
	clear:both;
	margin:20px auto 30px;
}
/*搜索内容*/
.content{
	width:1020px;
	margin:auto;
	margin-top:20px;	
}
.content select{
	font-size:14px;
}
.search_box{
	width:1000px;
	height:880px;
}
.search_top{
	height:35px;
	line-height:35px;
	margin:20px;
	overflow:hidden;
	padding-left:160px;
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
	float:left;
	display:inline-block;
	width:86px;
	height:34px;
	background-color:#ff7f00;
	text-align:center;
	border-radius:3px;
	color:#fff;
	font-size:16px;
	margin-left:10px;
}
.s_style2,.s_style3,.s_style4{
	height:30px;
	border:1px sold #ddd;
	margin-right:8px;
}
.s_style2{
	width:70px;
}
.s_style3{
	width:80px;
}
.s_style4{
	width:70px;
}

.search_content{
	clear:both;
	width:1020px;
	padding-top:10px;
	padding-left:10px;
	overflow:hidden;
}
.content01_box{
	clear:both;
	width:152px;
	height:275px;
	background:#fff;
	border:1px solid #ccc;
	text-align:center;
	margin-right:12px;
	margin-bottom:14px;
	display:inline-block;
}
.content01{
	padding:10px;
	margin-top:10px;
}
.content01 h2{
	margin-top:10px;
	font-size:14px;
	color:#ff7c7c;
}
.content_text{
	margin:3px 0 8px 0;
}
.content_text span{
	margin-right:3px;
}
.say_hi,.give_gift{
	width:56px;
	height:24px;
	display:inline-block;
	background:#fff8f9;
	border:1px solid #ff7c7c;
	color:#ff7c7c;
	vertical-align:top;
	line-height:22px;	
}
.give_gift{
	background:#ff7c7c;
	color:#fff;
}
.page_btn_box{
	text-align:center;
    margin: 20px 0 50px;
    clear: both;
}
.page_btn{
	display:inline-block;
	width:58px;
	height:24px;
	border:1px solid #d4d4d4;
	text-align:center;
	line-height:24px;
	color:#000;
	font-size:14px;
	margin-right:5px;
}
.page_number{
	width:70px;
	position:relative;
	top:-1px;
}
</style>
 <!--头部-->
 <?php echo pcHeader();?>
    <!--广告-->
    <div class="ad">
        <a href="javascript:;"><img src="<?php echo img("uiJ53377569IG");?>"></a>
    </div>
    <!--搜索内容-->
    <div class="content">
    	<div class="search_top">
            <i class="search_bg icon"></i>
            <div class="search_condition">
                <form name="searchForm" action="<?php echo root."library/usPost.php";?>" method="post">
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
        	<a class="search_btn" href="javascript:;" onClick="document.searchForm.submit();">搜索</a>
        	</form>
         </div>
        <div class="search_box">
            <div class="search_content">
                 <?php echo $Search;?>
            </div>
        </div>
        <div class="page_btn_box">
        	<?php echo fenye($ThisUrl,7);?>	
        </div>
    </div>
<!--底部-->
    <?php echo letter("","").send_gift().warn().choosePay().pcFooter();?>
</body>
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
		},"json");
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
	<?php echo 
	KongSele("searchForm.searchSex",$_SESSION['userSearch']['sex']).
	KongSele("searchForm.searchMinAge",$_SESSION['userSearch']['minAge']).	
	KongSele("searchForm.searchMaxAge",$_SESSION['userSearch']['maxAge']);?>	
})
</script>
</html>
