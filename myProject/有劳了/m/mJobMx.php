<?php
include "../library/mFunction.php";
//打印信息
$supply = mysql_fetch_array(mysql_query("select * from supply where id = '$_GET[supplyMx_id]' "));
$jobMx = query("kehu","khid = '$supply[khid]'");
$personal = query("personal","khid = '$jobMx[khid]'");
$age = date("Y") - substr($personal['Birthday'],0,4);
$region = query("region","id = '$jobMx[RegionId]'");
//判断是否改变按钮值和颜色
$collectNum = mysql_fetch_array(mysql_query("select * from collect where khid = '$kehu[khid]' and TargetId = '$_GET[supplyMx_id]' "));
if($collectNum > 0){
    $buttonValue = "取消收藏";
}else{
    $buttonValue = "收藏";
}
//打印工作时间表
$WorkingHours = "";
if($supply['WorkingHours'] == '时间表'){
    $WorkingHours = "
		<div class='time-box' id='timeBox'>
		    <div class='timeBox_flex'>
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
        </div>
	";
}
//循环供给图片
$imgSql = mysql_query("select * from SupplyImg where SupplyId = '$_GET[supplyMx_id]' order by time desc");
$imgNum = mysql_num_rows(mysql_query("select * from SupplyImg where SupplyId = '$_GET[supplyMx_id]'"));
$img = "";
if($imgNum == 0){
    $img = "<div class='photoShow'><img src='".img("PGI58296514zx")."' /></div>";
}else{
    while($array = mysql_fetch_array($imgSql)){
        $img .= "<div class='photoShow'><img src='{$root}{$array['src']}' /></div>";
    }
}
//判断是否显示联系方式
if($GLOBALS['KehuFinger'] == 1){
    $contactNumber = $jobMx['ContactTel'];
    $contactEmail = $jobMx['email'];
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
echo head("m").mHeader();
?>
<style>#m-job-body{padding-bottom:50px;}</style>
<div class="way">
    <a href="<?php echo $root;?>m/mindex.php">首页</a>
    <span>&gt;&gt;</span><a href="<?php echo $root;?>m/mTalent.php">优才</a>
    <span>&gt;&gt;</span><a href="javascript:;">详情</a>
</div>
<!--内容-->
<section id="job-details">
    <div class="job-de-content">
        <div class="job-de-title">
            <h2><?php echo $supply['title'];?></h2>
        </div>
        <img src="<?php echo HeadImg($jobMx['sex'],$jobMx['ico']);?>" class="je-de-photo">
        <ul class="job-de-list clearfix">
            <li><span class="textTitle">供给方：</span><?php echo $ContactName;?></li>
            <li><span class="textTitle">性别：</span><?php echo $personal['sex'];?></li>
            <li><span class="textTitle">年龄：</span><?php echo $age;?>岁</li>
            <li><span class="textTitle">教育程度：</span><?php echo $personal['EducationLevel'];?></li>
            <li><span class="textTitle">类型：</span><?php echo $supply['type'];?></li>
            <li><span class="textTitle">常驻地点：</span><?php echo $region['city'];?></li>
            <li><span class="textTitle">方式：</span><?php echo $supply['mode'];?></li>
            <li><span class="textTitle">面向:</span><?php echo $supply['face'];?></li>
            <li><span class="textTitle">收费：</span><?php echo $pay;?></li>
            <li><span class="textTitle">工作时间：</span><?php echo $supply['WorkingHours'];?></li>
            <li class="contact_way hide" style="color: #FFC107;"><span class="textTitle">电话：</span><?php echo $contactNumber;?></li>
            <li class="contact_way hide" style="color: #FFC107;"><span class="textTitle">邮箱：</span><?php echo $contactEmail;?></li>
        </ul>
        <?php echo $WorkingHours;?>
    </div>
</section>
<section id="m-job-body">
    <div class="job-body-title clearfix"><h2 class="fl">说明</h2><div class="fr inform-box"><a href="javascript:;"><i class="inform-icon"></i><span id="informBtn">举报</span></a></div></div>
    <div class="job-body-article clearfix">
        <span style="display: block;"><?php echo $supply['text'];?></span>
        <?php echo $img;?>
    </div>
</section>
<div class="po-bottom clearfix">
    <!-- JiaThis Button BEGIN -->
    <div class="jiathis_style_m"></div>
    <script type="text/javascript" src="http://v3.jiathis.com/code/jiathis_m.js" charset="utf-8"></script>
    <!-- JiaThis Button END -->
    <div class="collect fl share-btn"><a href="jabvascript:;"><i class="po-share-icon"></i><span>分享</span></a></div>
    <a href="javascript:;" class="po-apply-btn fl" id="lookBtn">查看联系方式</a>
    <div class="collect fl"><a href="jabvascript:;" supplyId="<?php echo $_GET['supplyMx_id'];?>"><i class="po-co-icon"></i><span><?php echo $buttonValue;?></span></a></div>
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
    };
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
        //打印时间表
        var timeString = "<?php echo $supply['Timetable']?>";
        var currentTime = timeString.split(",");
        var timeTable = $("[timetable]");
        if (timeString) {
            for (var i=0;i<currentTime.length;i++) {
                timeTable[parseInt(currentTime[i]) - 1].className +=" current1";
            }
        }
        //分享
        var jiathis = $('.jiathis_style_m');
        $('.share-btn').click(function(event){
            event.stopPropagation();
            jiathis.show();
        });
        $(document).click(function(event){
            event.stopPropagation();
            jiathis.hide();
        });
        //收藏
        $("[supplyId]").click(function(){
            var supplyId = $(this).attr("supplyId");
            var element = "<i class='po-co-icon'></i>";
            $.post("<?php echo root."library/usdata.php";?>",{collectionsupplyId:supplyId,demandType:"优才"},function(data){
                warn(data.warn);
                if(data.warn == "收藏成功"){
                    $("[supplyId="+supplyId+"]").html(element+"取消收藏");
                }else if(data.warn == '取消成功'){
                    $("[supplyId="+supplyId+"]").html(element+"收藏");
                }
            },"json");
        })
    })
</script>
</body>
</html>
