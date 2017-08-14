<?php
include "../../library/mFunction.php";
//打印车辆基本资料
$car = query("Car","auction = '是'");
$Brand = query("Brand","id = '$car[BrandId]' ");
$Region = query("region","id = '$car[RegionId]' ");
//打印车辆详情图片
$carImgSql = mysql_query("select * from CarImg where CarId = '$car[id]' ");
$carImg = "";
while($array = mysql_fetch_assoc($carImgSql)){
	$carImg .= "
		<li class='swiper-slide';><a href='#'><img  src='{$root}{$array['src']}'/></a></li>
	";	
}
//拍卖倒计时
if($time < $car['AuctionTimeStart']){//拍卖还没开始
	$CountDown = strtotime($car['AuctionTimeStart']) - time();
	$CountDownTitle = "拍卖开始还有";
}else if($time < $car['AuctionTimeEnd']){//拍卖中
	$CountDown = strtotime($car['AuctionTimeEnd']) - time();	
	$CountDownTitle = "拍卖结束还有";
}else{//拍卖已结束
	$CountDown = 0;	
	$CountDownTitle = "拍卖已结束";
}
echo head("m");
//多少钱起拍
$Discount = $car['price'] * website("sads7df78d"); 
?> 
	<body style="padding-bottom:6em;">
		<div class="wrap">
		<!-- 轮播图开始 -->
		<div class="focus">
        <div class="pag pag-2"></div>
        <div class="swiper swiper-2">
            <ul class="swiper-wrapper">
                <?php echo $carImg;?>
            </ul>
        </div>
		<a href="#" class="user1"></a>
		</div>
		<div class="xqdiv xqdiv1">
			<h2><?php echo $car['name'];?></h2>
			<div class="xq1div"><span class="red"><?php echo $car['price'];?>万</span>&nbsp;<span class="font1">新车含税<b class="zhx">11.02万</b><strong>参加人数：<span class="red">36</span>人</strong></span></div>
<p style="color:#f09601;text-align:center;">一折起拍，<?php echo $Discount;?>万元起拍</p>
		</div>
		<div class="hang"></div>
		<div class="xqdiv xqdiv5">
			<div class="count"><span id="CountDownTitle"><?php echo $CountDownTitle;?>
                </span> : <span class="countsp">
                    <b></b>时
                    <b></b>分
                    <b></b>秒
                </span>
            </div>
			<a href="#" class="xqd4a xqd4a1">拍卖须知</a>
		</div>
		<div class="hang"></div>
		<div class="xqdiv xqdiv2"><ul>
			<li><?php echo $Brand['EffluentStandard'];?><br/><span class="font1">排放标准</span></li>
			<li><?php echo $Brand['GearBox'];?><br/><span class="font1">变速箱</span></li>
			<li><?php echo $Brand['OutputVolume'];?>L<br/><span class="font1">排放量</span></li>
			<li><?php echo substr($car['RegisterTime'], 0, 7);?><br/><span class="font1">首次上牌时间</span></li>
			<li><?php echo $Brand['Nation'];?><br/><span class="font1">国别</span></li>
			<li><?php echo $Region['area'];?><br/><span class="font1">区域</span></li>
			<li><?php echo $car['mileage'];?>万公里<br/><span class="font1">里程数</span></li>
		</ul><div class="clear"></div></div>
		<div class="hang"></div>
		<div class="xqdiv xqdiv3">
			<ul>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
			</ul>
			<a href="#">查看更多参数配置</a>
		</div>
		<div class="pmbottom"><a href="#" class="pmba2">点击缴纳诚意金</a></div>
<div id="tan1" class="tan"><div class="tan1 tanc">
			<div class="ctitle">诚意金须知</div>
			<p><?php echo website("mWO60741509OL");?></p>
			<a class="haode">好的</a>
		</div></div>
		<div id="tan2" class="tan"><div class="tan2 tanc">
			<div class="ctitle">诚意金</div>
			<p><span>应收金额</span>&nbsp;&nbsp;<input type="text" name="" class="input1" value="请输入诚意金" /></p>
			<a class="xuzhi">诚意金须知</a>
			<div class="tanque">确&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;定</div>
		</div></div>
		<div id="tan5" class="tan"><div class="tan5 tanc">
			<div class="ctitle">拍卖须知</div>
			<p><?php echo website("NZW60886190og");?></p>
		</div></div>
		<div id="mackbg"></div>
		</div>
	</body>
<script>
//倒计时函数
function formatDate(config){
	this.second = config.second;
	this.state = config.state;
	this.timer = null;
}
formatDate.prototype.hexText = function(number){
	if (number !== undefined)
	{
			var hex = "";
			if (number < 10 || number == 0)
			{
					hex += 0
			}
			return hex += number
	}
}
formatDate.prototype.format = function(number){
	var useing = this;
	if (number !== undefined)
	{
		  return {
		  _getDay:useing.hexText(parseInt((number / (24 * 60 * 60)))),
		  _getHour:useing.hexText(parseInt(number / 3600)),
		  _getMin:useing.hexText(parseInt((number / 60) % 60)),
		  _getSecond:useing.hexText(parseInt((number % 60)))
																				};
	}
}
formatDate.prototype.timtout = function(callback){
	 if (callback !== undefined && typeof callback == "function"){
		var useing = this;
		if (this.state)
                {
                        this.timer = setInterval(function(){					
							useing.second --;
							if(useing.second === -1 || useing.second <= 0){
								useing.second = 0;
								clearInterval(useing.timer)
							}
							callback(useing.format(useing.second))	
						},1000)
                }
                else
                {
                        callback(useing.format(useing.second));
                } 
	 }
}
//页面加载完
$(document).ready(function(e) {   
	var countsp = document.querySelector(".countsp");
	var nodeList = countsp.children;
	//调用		
	var DateNow = new formatDate({
		second:<?php echo $CountDown;?>,
		state:true	
	});
	DateNow.timtout(function(data){
		nodeList[0].innerHTML = data._getHour;
		nodeList[1].innerHTML = data._getMin;
		nodeList[2].innerHTML = data._getSecond;
		var CountDownTitle = document.getElementById("CountDownTitle").innerHTML;
		if(data._getHour == '00' && data._getMin == '00' && data._getSecond == '00' && CountDownTitle == "拍卖开始还有"){
			$.post("<?php echo "{$root}library/mData.php";?>",{CountDown:"yes"},function(data){
				//再调用一次
				DateNow.second = data.time;
				DateNow.timtout(function(data){
					nodeList[0].innerHTML = data._getHour;
					nodeList[1].innerHTML = data._getMin;
					nodeList[2].innerHTML = data._getSecond;	
				});
				document.getElementById("CountDownTitle").innerHTML = data.title;	
				
			},"json");
		}else if(data._getHour == '00' && data._getMin == '00' && data._getSecond == '00' && CountDownTitle == "拍卖结束还有"){
			$.post("<?php echo "{$root}library/mData.php";?>",{CountDown:"yes"},function(data){
				document.getElementById("CountDownTitle").innerHTML = data.title;	
			},"json");	
		}					
					
	});
});
</script>    
</html>