<?php
include "../library/mFunction.php";
$demand = mysql_fetch_array(mysql_query("select * from demand where id = '$_GET[demandMx_id]' "));
$recruit = query("kehu","khid = '$demand[khid]'");
$personal = query("personal","khid = '$recruit[khid]'");
$age = date("Y") - substr($personal['Birthday'],0,4);
$region = query("region","id = '$jobMx[RegionId]'");
//判断是否改变按钮值和颜色
$collectNum = mysql_fetch_array(mysql_query("select * from collect where khid = '$kehu[khid]' and TargetId = '$_GET[demandMx_id]' "));
if($collectNum > 0){
	$buttonValue = "取消收藏";
}else{
	$buttonValue = "收藏";
}
//是否显示联系人全名
if(empty($recruit['ContactNameOpen'])){
	$recruit['ContactName'] = "保密";
}
//判断是否显示联系号码
if($GLOBALS['KehuFinger'] == 1){
	$contactNumber = $recruit['ContactTel'];
	$contactEmail = $recruit['email'];
}
echo head("m").mHeader();
?>
<div class="way">
	<a href="<?php echo $root;?>m/mindex.php">首页</a>
	<span>&gt;&gt;</span><a href="<?php echo $root;?>m/mTalent.php">优职</a>
	<span>&gt;&gt;</span><a href="javascript:;">详情</a>
</div>
<!--内容-->
<section id="job-details">
	<div class="job-de-content">
		<div class="job-de-title">
			<h2><?php echo $demand['title'];?></h2>
			<span><?php echo $recruit['ContactName'];?></span>
		</div>
		<ul class="job-de-list clearfix">
			<li><span class="textTitle">方式：</span><?php echo $demand['mode'];?></li>
			<li><span class="textTitle">面向：</span><?php echo $demand['face'];?></li>
			<li><span class="textTitle">薪资：</span><?php echo $demand['pay'];?>元/<?php echo $demand['PayCycle'];?></li>
			<li><span class="textTitle">类型：</span><?php echo $demand['type'];?></li>
			<li style="width:100%;"><span class="textTitle">需求时间：</span><?php echo $demand['StartTime'];?> 至 <?php echo $demand['EndTime'];?></li>
			<li class="contact_way hide" style="color: #FFC107;"><span class="textTitle">电话：</span><?php echo $contactNumber;?></li>
			<li class="contact_way hide" style="color: #FFC107;"><span class="textTitle">邮箱：</span><?php echo $contactEmail;?></li>
		</ul>
	</div>
</section>
<section id="m-job-body">
	<div class="job-body-title clearfix"><h2 class="fl">说明</h2><div class="fr inform-box"><a href="javascript:;"><i class="inform-icon"></i><span id="informBtn">举报</span></a></div></div>
	<div class="job-body-article"><?php echo $demand['text'];?>
	</div>
</section>
<div class="po-bottom clearfix">
	<!-- JiaThis Button BEGIN -->
	<div class="jiathis_style_m"></div>
	<script type="text/javascript" src="http://v3.jiathis.com/code/jiathis_m.js" charset="utf-8"></script>
	<!-- JiaThis Button END -->
	<div class="collect fl share-btn"><a href="jabvascript:;"><i class="po-share-icon"></i><span>分享</span></a></div>
	<a href="javascript:;" class="po-apply-btn fl" id="lookBtn">查看联系方式</a>
	<div class="collect fl"><a href="jabvascript:;" demandId="<?php echo $_GET['demandMx_id'];?>"><i class="po-co-icon"></i><span><?php echo $buttonValue;?></span></a></div>
</div>
<!--举报弹出层-->
<div id="m-informPopUp">
	<div id="informClose"><img src="http://www.youlaole.com/img/WebsiteImg/ysD61515199UI.jpg"></div>
	<div class="popUpBox">
		<form name="ReportForm">
			<label><input name="Report[]" type="checkbox" value="虚假信息/冒用他人信息" /><span>虚假信息/冒用他人信息</span></label>
			<label><input name="Report[]" type="checkbox" value="不良信息/违法违规信息" /><span>不良信息/违法违规信息</span></label>
			<label><input name="Report[]" type="checkbox" value="有瞒偏和欺诈行为" /><span>有瞒偏和欺诈行为</span></label>
			<label><input name="Report[]" type="checkbox" value="恶意营销、广告" /><span>恶意营销、广告</span></label>
			<input name="targetId" type="hidden" value="<?php echo $demand['khid'];?>" />
			<input name="ReportType" type="hidden" value="优职" />
		</form>
		<a href="javascript:;" class="inform-btn inform-btn2" id="informBtn2">确认举报</a>
	</div>
</div>
<script>
	window.onload=function(){
		//举报弹出层
		var informBtn=document.getElementById("informBtn"),
			informPopUp=document.getElementById("m-informPopUp"),
			informClose=document.getElementById("informClose"),
			informBtn2=document.getElementById("informBtn2");
		informBtn.onclick=function(){
			informPopUp.style.display="block";
		};
		informBtn2.onclick=function(){
			//点击提交表单
			$.post("<?php echo "{$root}library/usdata.php?reportMessage";?>",$('[name=ReportForm]').serialize(),function(data) {
				warn(data.warn);
			}, "json")
		};
		informClose.onclick=function(){
			informPopUp.style.display="none";
		}
	}
	$(function(){
		//查看联系方式
		$('.po-apply-btn').click(function(){
			//判断是否显示联系号码
			var ClientFinger = "<?php echo $KehuFinger;?>";
			if(ClientFinger == 1){
				$('.contact_way').show();
			}else{
				warn("未登陆，请在网站右上角选择登录");
			}
		});
		//分享
		var jiathis = $('.jiathis_style_m');
		$('.share-btn').click(function(event){
			event.stopPropagation();
			jiathis.show();
		})
		$(document).click(function(event){
			event.stopPropagation();
			jiathis.hide();
		})
		//收藏
		$("[demandId]").click(function(){
			var demandId = $(this).attr("demandId");
			var element = "<i class='po-co-icon'></i>";
			$.post("<?php echo root."library/usdata.php";?>",{collectiondemandId:demandId,demandType:"优职"},function(data){
				warn(data.warn);
				if(data.warn == "收藏成功"){
					$("[demandId="+demandId+"]").html(element+"取消收藏");
				}else if(data.warn == '取消成功'){
					$("[demandId="+demandId+"]").html(element+"收藏");
				}
			},"json");
		})
	})
</script>
</body>
</html>
