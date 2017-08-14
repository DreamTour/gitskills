<?php
require_once "../../library/mFunction.php";
$kehu = query("kehu","khid ='$kehu[khid]' ");
if (empty($kehu['khid'])) {
    wxLogin($ThisUrl);
}else{
    $khid = $kehu['khid'];
    $money = $kehu['money'];
}
//荣誉勋章
$medalStr = queryMedal($khid);
//查询客户是否有打卡记录
$CardRecord = query("CardRecord"," khid = '$kehu[khid]' and StartTime <> '0000-00-00 00:00:00' and IntervalTime is not null order by time desc");
//如果为空 或者生成相应二维码并没有去开门
if(empty($CardRecord['id'])){
    $text = "无";
    $now_time = 0;
}else{
    $text = substr($CardRecord['StartTime'],0,10);
    $last = strtotime($text); //上次打卡的时间
    $now = strtotime(substr($time,0,10));//现在的时间
    $now_time = (($now - $last)/86400-1);
    if($now_time <= 0){
        $now_time = 0;
    }
}
//判断状态
$device = query("device","DeviceId = '$CardRecord[DeviceId]'"); //门禁信息
$Gym = query("Gym","id = '$device[GymId]' "); //健身房信息
if ($CardRecord['EndTime'] == '0000-00-00 00:00:00') {
    $txt = "您正在{$Gym['name']}舱进行锻炼，离场请使用微信扫描二维码";
    $html = "<h3>（舱内状态）</h3><p style='text-align:justify;padding: 5px;'><b>{$txt}</b></p>";
}else{
    $txt = "您最后一次锻炼的舱是{$Gym['name']}，如需进场请使用微信扫描二维码";
    $html = "<h3>（舱外状态）</h3><p style='text-align:justify;padding: 5px;'><b>{$txt}</b></p>";;
}

//看过的视频
$sql = mysql_query("Select * from CourseRecord where khid = '$kehu[khid]' order by time desc limit 0,2 ");
if(mysql_num_rows($sql) > 0){
    $index = 0;
    $arr = "";
    while($array = mysql_fetch_assoc($sql)){
        $Course = query("Course"," id = '$array[CourseId]' ");
        if(!empty($Course['id'])){
            $arr[] = "<a href='{$root}m/mCourseMx.php?id={$array['CourseId']}'><img src='{$root}{$Course[ico]}' alt='{$Course['name']}'/><span>{$Course['name']}</span></a>";
        }
    }
    $seeVideo = "
    <div class='hysydiv2 wrap-box'>
        <div class='title'><h3><i class='icon'>&#xe61c;</i> 看过视频</h3></div>
        <div class='content'>
            <div class='left'>{$arr[0]}</div>
            <div class='right'>{$arr[1]}</div>
            <div class='clear'></div>
            <div class='right'></div>
            <div class='morediv'><a href='{$root}m/mUser/mUsVideoHistory.php'>更多>></a></div>
        </div>
    </div>";
}
//统计锻炼时长
$totalTime = StaTime($khid,"总");

//判断时长 upMedal()更新勋章函数
if ($totalTime >=300 && $totalTime<500) {
    $medalMsg = upMedal($khid,'monthlyExercise3',300);
}
if ($totalTime >=500 && $totalTime<700) {
    $medalMsg = upMedal($khid,'monthlyExercise5',300);
}
if ($totalTime >=700 && $totalTime<10000) {
    $medalMsg = upMedal($khid,"monthlyExercise7",700);
}
if ($totalTime >=1000) {
    $medalMsg = upMedal($khid,"monthlyExercise10",1000);
}

//特定日勋章 判断特定日当天是否打卡
$anniversary = website("anniversary");
if ($text == $anniversary) {
    $medalMsg = upMedal($khid,"anniversary","{$anniversary}");
}
echo head("m");
?>
<div class="ploading">
    <div class="load-container load">
        <div class="loader">Loading...</div>
    </div>
</div>
<div class="wrap">
    <!-- 我的金额 -->
    <div class="hysydiv3 wrap-box">
        <div class="title">
            <h3><i class="icon">&#xe603;</i> 我的金额</h3>
            <!--<i class='exclamation-icon'>&#xe628;</i>-->
        </div>
        <div class="content">
            余额：<b><?php echo $money; ?></b> <?php echo $unit;?>
            <div class='morediv'>
                <a href='<?php echo $root;?>m/mUser/mUsCard.php'>充值>></a>
            </div>
        </div>
    </div>
    <!-- 我的金额 end -->
    <!--打卡详情-->
    <div class="hysydiv1 wrap-box">
        <div class="title">
            <h3><i class="icon">&#xe608;</i> 打卡详情</h3>
        </div>
        <div class="content">
            <p>上次打卡时间：<b><?php echo $text;?></b></p>
            <?php echo "<p>已经<b>{$now_time}天</b>没锻炼啦</p>";?>
            <div class="morediv"><a href="<?php echo $root;?>m/mUser/mUsSign.php">更多>></a></div>
        </div>
    </div>
    <!--打卡详情-->
    <!-- 我的荣耀 -->
    <div class="xqdiv4 wrap-box">
        <div class="title">
            <h3><i class="icon">&#xe606;</i> 我的荣耀</h3>
        </div>
        <div class="content li-content">
            <ul>
                <li>
                    <!-- <span class="medal">荣誉勋章：</span>-->
                    <?php echo $medalStr; ?>
                </li>
                <li>
                    <span>累积训练时间：</span>
                    （<b><?php echo StaTime($khid,"总"); ?></b> 分钟）
                </li>
                <li>
                    <span>本周训练时间：</span>
                    （<b><?php echo StaTime($khid,"周"); ?></b> 分钟）
                </li>
                <li>
                    <span>当月训练时间：</span>
                    （<b><?php echo StaTime($khid,"月"); ?></b> 分钟）
                </li>
                <li>
                    <span>年度训练时间：</span>
                    （<b><?php echo StaTime($khid,"年"); ?></b> 分钟）
                </li>
            </ul>
        </div>
    </div>
    <!-- 我的荣耀 end -->
    <!-- 专项通道 业主专享通道暂时不用开发了，万科不舍得开放接口，他们担心有潜在的风险。 -->
    <!--<div class="wrap-box box">
        <div class="title">
            <h3><i class="aisle-icon">&#xe640;</i> 专项通道</h3>
        </div>
        <div class="content">
            <p>专项通道专项通道专项通道专项通道</p>
            <div class="morediv">
                <a href="javascript:;">验证&gt;&gt;</a>
            </div>
        </div>
    </div>-->
    <!-- 专项通道 end -->

    <!--荣誉勋章弹出层开始-->
    <?php echo $medalMsg; ?>
    <!--荣誉勋章弹出层结束-->
    <!--状态板块-->
    <!--<div class="hysydiv3 wrap-box">
        <div class="title">
            <h3><i class="icon">&#xe608;</i> 练习状态</h3>
        </div>
        <div class="content">
            <?php /*echo $html; */?>
        </div>
    </div>-->
    <!-- 看过的视频 -->
    <?php echo $seeVideo; ?>
    <div class="hysydiv4 wrap-box" style="margin-bottom: 2.5%;">
        <div class="title">
            <h3><i class="icon">&#xe690;</i> 改善建议</h3>
        </div>
        <div class="content">
            <form name="messageForm" id="messageForm" method="post" enctype="multipart/form-data">
                <textarea name="MSG" id="MSG" rows="4"  placeholder="如果你有好的改善建议,欢迎留言......"></textarea>
                <input type="button" id="sendMessage" class="sendMessage" value="发送"/>
            </form>
        </div>
    </div>
    <div class="hysydiv5 wrap-box">
        <div class="title">
            <h3><i class="icon">&#xe608;</i> 近期回复</h3>
        </div>
        <div class="content">
            <?php echo neirong(website("aGD70311570za")); ?>
        </div>
    </div>
</div>
<script>

    window.onload = function() {
        //反馈
        $("#sendMessage").click(function() {
            $.post(root+'library/mData.php?type=msg',$("[name='messageForm']").serialize(), function(data) {
                if(data.warn == 2){
                    window.location.reload();
                }else{
                    mwarn(data.warn);
                }
            },'json');
        });

        //点击关闭勋章
        /*var medalShade = document.getElementById('medal-shade');
         medalShade.onclick = function() {
         this.style.display = 'none';
         }*/

        /*function doUpload() {
         var formData = new FormData($("#messageForm")[0]);
         $.ajax({
         url: root+'m/mLibrary/mData.php?type=msg',
         type: 'post',
         data: formData,
         dataType: 'json',
         async: false,
         cache: false,
         contentType: false,
         processData: false,
         success: function (data) {
         if(data.warn == 2){
         window.location.reload();
         }else{
         mwarn(data.warn);
         }
         },
         error: function (data) {
         alert('错误');
         }
         });
         }*/
    }
</script>
<?php echo mWarn().footer();?>
</body>
</html>