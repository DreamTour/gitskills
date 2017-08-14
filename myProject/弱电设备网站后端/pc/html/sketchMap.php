<?php
include "library/PcFunction.php";
UserRoot("pc");
echo head("pc").headerPC().navTwo();
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
                    <div><a href=\"{$root}deviceDetails.php?id={$array['deviceId']}\" class=\"details\">详情</a></div>
                </div>
            </div>
        ";
            }
        }
        $systemImg .= "
                    <img class=\"gd-img\" alt='清单图片' src='{$root}{$systemImgArray['src']}'>
        ";
    }
}

;?>
<div class="sketchMap-bg">
    <!-- 内容 -->
    <div class="systemImg clearfix container">
        <?php echo $systemImg;?>
    </div>
</div>
<!-- 弹出层 -->
<div class="Drawing hide">
    <div id="map">
        <img class="shade-img" src="" name="test" alt="摆位图" usemap="#systemImg" ref='imageMaps' />
        <?php echo $systemImgSeat;?>
    </div>
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script>
    window.onload = function() {
        //点击出现弹出层显示对应的排位图
        Drawing2('.gd-img', '.shade-img', '.Drawing');
        function Drawing2(smallImgID, bigImgID, shadeID) {
            var smallImg = document.querySelectorAll(smallImgID);
            var bigImg = document.querySelector(bigImgID);
            var shade = document.querySelector(shadeID);
            if (smallImg && bigImg && shade) {
                for (var i=0;i<smallImg.length;i++) {
                    smallImg[i].onclick = function(ev) {
                        var e = ev||event;
                        if(document.all){  //只有ie识别
                            e.cancelBubble=true;
                        }else{
                            e.stopPropagation();
                        }
                        shade.style.display = 'block';
                        var src = this.getAttribute('src');
                        bigImg.setAttribute('src', src);
                    }
                }
                document.onclick = function() {
                    shade.style.display = 'none';
                }
            }
            //鼠标移入移除热点区域
            var map = document.getElementById('map');
            var areaSet = map.querySelectorAll('.area');
            for (var i=0;i<areaSet.length;i++) {
                areaSet[i].onmouseover = function() {
                    this.querySelector('.shade').style.display = 'block';
                }
                areaSet[i].onmouseout = function() {
                    this.querySelector('.shade').style.display = 'none';
                }
            }
        }
    }
</script>
</html>