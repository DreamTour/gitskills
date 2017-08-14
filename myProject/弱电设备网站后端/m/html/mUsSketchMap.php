<?php
include "../../library/mFunction.php";
UserRoot("m");
//判断显示不同系统的排位图
if ($_GET['id']) {
    $where = "WHERE systemId = '$_GET[id]' ";
} else {
    $where = "";
}
//循环排位图列表
$systemImgSql = mysql_query("SELECT * FROM systemImg $where");
$systemImg = "";
if (mysql_num_rows($systemImgSql) == 0) {
    $systemImg = "一张摆位图都没有";
} else {
    while ($systemImgArray = mysql_fetch_assoc($systemImgSql)) {
        //循环热点
        $systemImgSeatSql = mysql_query("select * from systemImgSeat WHERE systemImgId = '$systemImgArray[id]' AND systemId = '$_GET[id]' ");
        $systemImgSeat = "";
        if (mysql_num_rows($systemImgSeatSql) > 0) {
            while ($array = mysql_fetch_assoc($systemImgSeatSql)) {
                $device = query("device", "id = '$array[deviceId]' ");
                $systemImgSeat .= "
            <div class=\"area\" style='width: {$array['width']}px;height:{$array['height']}px;left:{$array['seatLeft']}px;top:{$array['seatTop']}px'>
                <div class=\"shade hide\">
                    <div class=\"param\">{$device['parameter']}</div>
                    <div><a href=\"{$root}m/mUser/mUsDeviceDetails.php?id={$array['deviceId']}\" class=\"details\">详情</a></div>
                </div>
            </div>
        ";
            }
        }
        $systemImg .= "
            <li>
                <img class=\"sketchMap-img\" src=\"{$root}{$systemImgArray['src']}\" alt=\"清单图片\" />
                <!--<h3>图纸图纸图纸图纸图纸图纸1</h3>-->
            </li>
        ";
    }
}
echo head("m").mHeader();
;?>
<!-- 图纸列表 -->
<div class="sketchMap">
    <ul>
        <?php echo $systemImg;?>
    </ul>
</div>
<!-- 页脚 -->
<?php echo mFooter().mNav().warn();?>
<!-- 二维码弹出层 -->
<div class="Drawing hide">
    <div id="map">
        <img class="shade-img" src="" name="test" alt="摆位图" usemap="#systemImg" ref='imageMaps' />
        <?php echo $systemImgSeat;?>
    </div>
</div>
</body>
<script>
    window.onload = function() {
        //点击二维码弹出对应的图纸
        Drawing('.sketchMap-img', '.shade-img', '.Drawing');
        //点击热点区域
        var map = document.getElementById('map');
        var areaSet = map.querySelectorAll('.area');
        for (var i=0;i<areaSet.length;i++) {
            areaSet[i].onclick = function(ev) {
                for (var i=0;i<areaSet.length;i++) {
                    areaSet[i].querySelector('.shade').style.display = 'none';
                }
                var e = ev || event;
                e.stopPropagation();
                this.querySelector('.shade').style.display = 'block';
            }
        }
    }
</script>
</html>