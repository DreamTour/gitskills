<?php
include "../../library/mFunction.php";
UserRoot("m");
$systemSql = mysql_query("select * from system");
$deviceSystem = "";
$sketchMapSystem = "";
while ($array = mysql_fetch_assoc($systemSql)) {
    $deviceSystem .= " <li><a href=\"{$root}m/mUser/mUsDevice.php?id={$array['id']}\">{$array['name']}</a></li>";
    $sketchMapSystem .= " <li><a href=\"{$root}m/mUser/mUsSketchMap.php?id={$array['id']}\">{$array['name']}</a></li>";
}
echo head("m").mHeader();
;?>
<!--<div class="mUser-avatar">
    <div>
        <img src="../images/head.jpg" />
        <span>未设置</span>
    </div>
</div>-->
<div class="mUser-list">
    <div class="mUser-option">
        <h2 class="clearfix click"><i class="device-icon">&#xe616;</i>我的设备<i class="arrow_right fr"></i></h2>
        <ul class="hide">
            <?php echo $deviceSystem;?>
        </ul>
    </div>
    <div class="mUser-option">
        <h2 class="clearfix click"><i class="sketchMap-icon">&#xe619;</i>摆位图<i class="arrow_right fr"></i></h2>
        <ul class="hide">
            <?php echo $sketchMapSystem;?>
        </ul>
    </div>
    <div class="mUser-option mUser-option-meg">
        <a href="<?php echo $root;?>m/mUser/mUsRecordList.php?type=service"><h2 class="clearfix"><i class="service-icon">&#xe683;</i>我的维修记录<i class="arrow_right fr"></i></h2></a>
    </div>
    <div class="mUser-option">
        <a href="<?php echo $root;?>m/mUser/mUsMessage.php"><h2 class="clearfix"><i class="message-icon">&#xe62a;</i>我的信息<i class="arrow_right fr"></i></h2></a>
    </div>
    <div class="mUser-option">
        <a href="<?php echo $root;?>m/mUser/mUsRecordList.php?type=bespeak"><h2 class="clearfix"><i class="bespeak-icon">&#xe6e0;</i>我的预约<i class="arrow_right fr"></i></h2></a>
    </div>
    <div class="mUser-option">
        <a href="<?php echo $root;?>m/mUser/mUsRecordList.php?type=complain"><h2 class="clearfix"><i class="complain-icon">&#xe670;</i>我的投诉<i class="arrow_right fr"></i></h2></a>
    </div>
    <div class="mUser-option mUser-option-meg">
        <a href="<?php echo $root;?>m/mUser/mUsBespeak.php"><h2 class="clearfix"><i class="bespeak-icon">&#xe6e0;</i>服务预约<i class="arrow_right fr"></i></h2></a>
    </div>
    <div class="mUser-option">
        <a href="<?php echo $root;?>m/mUser/mUsComplain.php"><h2 class="clearfix"><i class="complain-icon">&#xe670;</i>投诉<i class="arrow_right fr"></i></h2></a>
    </div>
</div>
<?php echo mFooter().mNav().warn();?>
</body>
<script>
    $(function() {
        $(".mUser-option .click").click(function() {
            $(this).next().toggle();
            $(this).find('i:last').toggleClass('arrow');
        })
    })
</script>
</html>