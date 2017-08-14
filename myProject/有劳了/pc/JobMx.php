<?php 
include "library/PcFunction.php";
//打印详情
$supply = mysql_fetch_array(mysql_query("select * from supply where id = '$_GET[supplyMx_id]' "));
$jobMx = query("kehu","khid = '$supply[khid]'");
$personal = query("personal","khid = '$jobMx[khid]'");
$age = date("Y") - substr($personal['Birthday'],0,4);
$region = query("region","id = '$jobMx[RegionId]'"); 
//根据ClassifyId查询分类
$classify = query("classify","id = '$supply[ClassifyId]' ");	
//判断是否改变按钮值和颜色
$collectNum = mysql_fetch_array(mysql_query("select * from collect where khid = '$kehu[khid]' and TargetId = '$_GET[supplyMx_id]' "));
if($collectNum > 0){
	$buttonValue = "取消收藏";
	$buttonBackground = "style='background:#999;'";		
}else{
	$buttonValue = "收藏";
	$buttonBackground = "";	
} 
//打印工作时间表
$WorkingHours = "";
if($supply['WorkingHours'] == '时间表'){
	$WorkingHours = "
		<div class='time-box' id='timeBox'>
			<ul class='time-head clearfix'>
				<li class='time-title'>星期</li><li>周一</li><li>周二</li><li>周三</li><li>周四</li><li>周五</li><li>周六</li><li>周日</li>
			</ul>
			<ul class='time-body clearfix'>
				<li class='time-title'>上午</li>
				<li class='time-current' TimeTable='1'></li>
				<li class='time-current' TimeTable='2'></li>
				<li class='time-current' TimeTable='3'></li>
				<li class='time-current' TimeTable='4'></li>
				<li class='time-current' TimeTable='5'></li>
				<li class='time-current' TimeTable='6'></li>
				<li class='time-current' TimeTable='7'></li>
			</ul>
			<ul class='time-body clearfix'>
				<li class='time-title'>下午</li>
				<li class='time-current' TimeTable='8'></li>
				<li class='time-current' TimeTable='9'></li>
				<li class='time-current' TimeTable='10'></li>
				<li class='time-current' TimeTable='11'></li>
				<li class='time-current' TimeTable='12'></li>
				<li class='time-current' TimeTable='13'></li>
				<li class='time-current' TimeTable='14'></li>
			</ul>
			<ul class='time-body clearfix'>
				<li class='time-title'>业余时间</li>
				<li class='time-current' TimeTable='15'></li>
				<li class='time-current' TimeTable='16'></li>
				<li class='time-current' TimeTable='17'></li>
				<li class='time-current' TimeTable='18'></li>
				<li class='time-current' TimeTable='19'></li>
				<li class='time-current' TimeTable='20'></li>
				<li class='time-current' TimeTable='21'></li>
			</ul>
		</div>
	";	
}
//是否显示教育程度
if(empty($personal['EducationLevelOpen'])){
	$personal['EducationLevel'] = "保密";	
}
//循环供给图片
$imgSql = mysql_query("select * from SupplyImg where SupplyId = '$_GET[supplyMx_id]' order by time desc");
$imgNum = mysql_num_rows(mysql_query("select * from SupplyImg where SupplyId = '$_GET[supplyMx_id]'"));
$img = "";
if($imgNum == 0){
	$img = "<div class='photoShow'><img src='".img("PGI58296514zx")."' /></div>";
}else{
	while($array = mysql_fetch_array($imgSql)){
		$img .= "<div class='photoShow'><img src='{$root}{$array['src']}' width='800' /></div>";
	}
}
//判断是否显示联系方式
if($GLOBALS['KehuFinger'] == 1){
	$contactNumber = $jobMx['ContactTel'];
	$contactEmail = $jobMx['email'];
}
//判断头像
if ($jobMx['ico'] == "") {
	$jobMx['ico'] = img("PGI58296514zx");
}
//判断我是个人还是商家，显示对应的名称
if ($supply['IdentityType'] == "商家") {
	$ContactName = $supply['CompanyName'];
}
else {
	$ContactName = $jobMx['ContactName'];
}
//判断收费类型，根据收费类型显示内容
if ($supply['payType'] == "薪酬") {
	$pay = "{$supply['pay']}/{$supply['PayCycle']}";
}
else {
	$pay = $supply['payType'];
}
echo head("pc").pcHeader();
?>
<!--内容-->
<div class="info-container"> 
   <?php echo pcNavigation();?>
  <!--row-->
    <div class="row">
    	<!--面包屑导航-->
        <div class="breadcrumb-nav">
        	<a href="<?php echo $root;?>index.php">首页</a><span>>></span>
            <a href="<?php echo $root;?>talent.php">优才</a><span>>></span>
            <a href="<?php echo "{$root}talent.php?classifyType={$classify['type']}";?>"><?php echo $classify['type'];?></a><span>>></span>
            <a href="<?php echo "{$root}talent.php?classifyId={$classify['id']}";?>"><?php echo $classify['name'];?></a>
        </div>
    	<!--职位详情-->
      	<div class="job-content">
        	<div class="job-header clearfix">
            	<div class="job-title fl"><h2><?php echo $supply['title'];?></h2></div>
                <div class="function-box fl">
                    <a href="javascript:;" <?php echo $buttonBackground;?> class="job-collect-btn" supplyId="<?php echo $_GET['supplyMx_id'];?>"><i class="job-icon job-icon01"></i><?php echo $buttonValue;?></a>
                    <a href="javascript:;" class="share-btn"><i class="job-icon job-icon02"></i>分享</a>
                    <!-- JiaThis Button BEGIN -->
                    <div class="jiathis_style_32x32 hide">
                        <a class="jiathis_button_qzone"></a>
                        <a class="jiathis_button_tsina"></a>
                        <a class="jiathis_button_tqq"></a>
                        <a class="jiathis_button_weixin"></a>
                        <a class="jiathis_button_renren"></a>
                        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                    </div>
                    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                    <!-- JiaThis Button END -->
                    <a href="javascript:;" class="inform-btn" id="informBtn"><i class="job-icon job-icon03"></i>举报</a>
                </div>
                <a href="javascript:;" class="jobApply-btn fr">查看联系方式</a>
            </div>
            <!--举报弹出层-->
            <div class="inform-popUp hide" id="informPopUp">
            	<div id="informClose"><img src="http://www.youlaole.com/img/WebsiteImg/vZd61501073iN.jpg"></div>
            	<form name="ReportForm">
            		<label><input name="Report[]" type="checkbox" value="虚假信息/冒用他人信息" /><span>虚假信息/冒用他人信息</span></label>
                    <label><input name="Report[]" type="checkbox" value="不良信息/违法违规信息" /><span>不良信息/违法违规信息</span></label>
                    <label><input name="Report[]" type="checkbox" value="有瞒偏和欺诈行为" /><span>有瞒偏和欺诈行为</span></label>
                    <label><input name="Report[]" type="checkbox" value="恶意营销、广告" /><span>恶意营销、广告</span></label>
                    <input name="targetId" type="hidden" value="<?php echo $supply['khid'];?>" />
                    <input name="ReportType" type="hidden" value="优才" />
                </form>
                <a href="javascript:;" class="inform-btn inform-btn2" id="informBtn2">确认举报</a>
            </div>
            <div class="job-body-box clearfix">
            	<div class="job-body-left fl">
                	<div class="clearfix">
                    	<img src="<?php echo $jobMx['ico'];?>" width='120' height='120' class="fl">
                        <ul class="job-details clearfix fl">
                            <li><span class="textTitle">供给方：</span><?php echo $ContactName;?></li>
                            <li><span class="textTitle">性别：</span><?php echo $personal['sex'];?></li>
                            <li><span class="textTitle">年龄：</span><?php echo $age;?>岁</li>
                            <li><span class="textTitle">教育程度：</span><?php echo $personal['EducationLevel'];?></li>
                            <li><span class="textTitle">常驻地点：</span><?php echo $region['province']."-".$region['city']."-".$region['area'];?></li>
                            <li><span class="textTitle">方式：</span><?php echo $supply['mode'];?></li>
                            <li><span class="textTitle">面向:</span><?php echo $supply['face'];?></li>
                            <li><span class="textTitle">薪酬：</span><?php echo $pay;?></li>
                            <li><span class="textTitle">类型：</span><?php echo $supply['type'];?></li>
                            <li><span class="textTitle">工作时间：</span><?php echo $supply['WorkingHours'];?></li>
							<li class="contact_way hide" style="color: #FFC107;"><span class="textTitle">电话：</span><?php echo $contactNumber;?></li>
							<li class="contact_way hide" style="color: #FFC107;"><span class="textTitle">邮箱：</span><?php echo $contactEmail;?></li>
                        </ul>
                    </div>
                    <?php echo $WorkingHours;?>
                    <div class="job-info">
                    	<h2>说明</h2>
                        <p class="clearfix">
                       <?php echo $supply['text'];?>
                       </p>
                    </div>
					<?php echo $img;?>
                </div>
                <div class="job-body-right fr">
                	<a href="javascript:;"><img src="<?php echo img("KXQ57016334gu");?>"></a>
                    <a href="javascript:;"><img src="<?php echo img("eZn57016371kp");?>"></a>
                    <a href="javascript:;"><img src="<?php echo img("FlH57016428QU");?>"></a>
                </div>
            </div>
        </div>
    </div>
    <!--row-->
</div>
<script>
	$(function(){
		//收藏
		$('.job-collect-btn').click(function(){
			var supplyId = $("[supplyId]").attr("supplyId");
			var element = "<i class='job-icon job-icon01'></i>";
			$.post("<?php echo root."library/usdata.php";?>",{collectionsupplyId:supplyId,demandType:"优才"},function(data){
				warn(data.warn);
				if(data.warn == "收藏成功"){
					$("[supplyId="+supplyId+"]").html(element+"取消收藏").css("background","#999");	
				}else if(data.warn == '取消成功'){
					$("[supplyId="+supplyId+"]").html(element+"收藏").css("background","#689fee");	
				}
			},"json");	
		});
		//查看联系方式
		$('.jobApply-btn').click(function(){
			//判断是否显示联系号码
			var ClientFinger = "<?php echo $KehuFinger;?>";
			if(ClientFinger == 1){
				$('.contact_way').show();
			}else{
			    warn("未登陆，请在网站右上角选择登录");
			}
		});
		//分享
		var jiathis = $('.jiathis_style_32x32');
		$('.share-btn').mouseenter(function(){
			jiathis.show();	
		});
		jiathis.mouseleave(function(){
			$(this).hide();	
		});
		//打印时间表
		var timeString = "<?php echo $supply['Timetable']?>";
		var currentTime = timeString.split(",");
		var timeTable = $("[timetable]");
		if (timeString) {
			for (var i=0;i<currentTime.length;i++) {		
				timeTable[parseInt(currentTime[i]) - 1].className +=" current1";
			}
		}
		/*举报弹出层*/
		var informBtn=document.getElementById("informBtn"),
		informPopUp=document.getElementById("informPopUp"),
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
	})
</script>
<!--页脚-->
<?php echo pcFooter().warn();?>
