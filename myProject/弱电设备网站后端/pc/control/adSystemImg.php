<?php
include "ku/adfunction.php";
ControlRoot("摆位图");
$systemImg = query("systemImg"," id = '$_GET[imgId]' ");
if(empty($system['id']) and $system['id'] != $_GET['id']){
    $_SESSION['warn'] = "未找到这个系统的信息";
    header("location:{$adroot}adClient.php");
    exit(0);
}
//循环热点
$systemImgSeatSql = mysql_query("select * from systemImgSeat WHERE systemImgId = '$_GET[imgId]' AND systemId = '$_GET[systemId]' ORDER BY time DESC");
$systemImgSeat = "";
if (mysql_num_rows($systemImgSeatSql) > 0) {
    while ($array = mysql_fetch_assoc($systemImgSeatSql)) {
        $device = query("device", "id = '$array[deviceId]' ");
        $systemImgSeat .= "
            <div class=\"area\" style='width: {$array['width']}px;height:{$array['height']}px;left:{$array['seatLeft']}px;top:{$array['seatTop']}px'>
                <ul class=\"shade hide\">
                    <div class=\"param\">{$device['parameter']}</div>
                    <div><a href=\"{$root}control/adDeviceMx.php?id={$array['deviceId']}\" class=\"details\">详情</a></div>
                </ul>
            </div>
        ";
    }
}
$system = query("system"," id = '$_GET[systemId]' ");
$onion = array(
    "摆位图" => "{$root}control/adSystem.php",
    $system['name'] => "{$root}control/adSystemMx.php?id={$_GET['systemId']}",
    "热点设置" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column MinHeight">
        <!--热点设置开始-->
        <div id="map">
            <img src="<?php echo $root.$systemImg['src'];?>" name="test" alt="摆位图" usemap="#systemImg" ref='imageMaps'>
            <?php echo $systemImgSeat;?>
            <div class="nowArea" id="nowArea">
                <ul class="shade hide">
                    <li class="param">参数参数参数参数参数</li>
                    <li><a href="#" class="details">详情</a></li>
                </ul>
            </div>
        </div>
        <div class="box" id="box">
            <form name="areaForm">
                <span>宽度：</span>
                <input class="width text TextPrice" type="text" name="width" value="" />
                <span>高度：</span>
                <input class="height text TextPrice" type="text" name="height" value="" />
                <span>横坐标：</span> <input class="x-axis text TextPrice" type="text" name="x-axis" value="" />
                <span>纵坐标：</span> <input class="y-axis text TextPrice" type="text" name="y-axis" value="" />
                <?php echo IDSelect("device", "deviceId", "select", "id", "name", "--设备--", "device");?>
                <input name="imgId" type="hidden" value="<?php echo $_GET['imgId'];?>" />
                <input name="systemId" type="hidden" value="<?php echo $_GET['systemId'];?>" />
                <span class="SpanButton" id="addHot">添加热点</span>
            </form>
        </div>
        <!--热点设置结束-->
        <!--列表开始-->
        <form name="SystemForm">
            <table class="TableMany">
                <tr>
                    <td>宽度</td>
                    <td>高度</td>
                    <td>横坐标</td>
                    <td>纵坐标</td>
                    <td>设备</td>
                    <td></td>
                </tr>
                <?php
                $systemImgSeatSql = mysql_query("select * from systemImgSeat WHERE systemImgId = '$_GET[imgId]' AND systemId = '$_GET[systemId]' ");
                if(mysql_num_rows($systemImgSeatSql) > 0){
                    while($array = mysql_fetch_array($systemImgSeatSql)){
                        $device = query("device", "id = '$array[deviceId]' ");
                        echo "
				<tr>
					<td>".kong($array['width'])."</td>
					<td>".kong($array['height'])."</td>
					<td>".kong($array['seatLeft'])."</td>
					<td>".kong($array['seatTop'])."</td>
					<td>".kong($device['name'])."</td>
					<td><a href='{$root}control/ku/adpost.php?type=systemImgSeatDelete&systemImgSeatDelete={$array['id']}'><span class='SpanButton delete'>删除</span></a></td>
				</tr>
				";
                    }
                }else{
                    echo "<tr><td colspan='6'>一个系统都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <!--列表结束-->
    </div>
    <script>
        window.onload = function() {
            //找到元素
            var box = document.getElementById("box");
            var map = document.getElementById('map');
            var area = map.querySelector('.nowArea');
            var img = map.querySelector('img');
            var input = box.querySelectorAll('input');
            var widthValue = null;
            var heightValue = null;
            //初始化
            box.querySelector('.width').value = '50';
            box.querySelector('.height').value = '50';
            area.style.width = '50px';
            area.style.height = '50px';
            //自增宽度
            box.querySelector('.width').onfocus = function() {
                //input获取焦点
                for (var i=0;i<input.length;i++) {
                    input[i].style.borderColor = '#bbb';
                }
                this.style.borderColor = '#f00';
                var self = this;
                //上下点击
                document.onkeydown=keyDownSearch;
                function keyDownSearch(e) {
                    // 兼容FF和IE和Opera
                    var theEvent = e || window.event;
                    var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
                    if (code == 38) {
                        self.value++;
                        if (self.value > img.clientWidth) {
                            self.value = img.clientWidth;
                        }
                        area.style.width = self.value + 'px';
                        widthValue = self.value;//具体处理函数
                        return false;
                    }
                    else if (code == 40) {
                        self.value--;
                        if (self.value > img.clientWidth) {
                            self.value = img.clientWidth;
                        }
                        area.style.width = self.value + 'px';
                        widthValue = self.value;//具体处理函数
                        return false;
                    }
                    return true;
                }
            }
            //自增高度
            box.querySelector('.height').onfocus = function() {
                //input获取焦点
                for (var i=0;i<input.length;i++) {
                    input[i].style.borderColor = '#bbb';
                }
                this.style.borderColor = '#f00';
                //上下点击
                var self = this;
                document.onkeydown=keyDownSearch;
                function keyDownSearch(e) {
                    // 兼容FF和IE和Opera
                    var theEvent = e || window.event;
                    var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
                    if (code == 38) {
                        self.value++;
                        if (self.value > img.clientHeight) {
                            self.value = img.clientHeight;
                        }
                        area.style.height = self.value + 'px';
                        widthValue = self.value;//具体处理函数
                        return false;
                    }
                    else if (code == 40) {
                        self.value--;
                        if (self.value > img.clientHeight) {
                            self.value = img.clientHeight;
                        }
                        area.style.height = self.value + 'px';
                        widthValue = self.value;//具体处理函数
                        return false;
                    }
                    return true;
                }
            }
            //自增横坐标
            box.querySelector('.x-axis').onfocus = function() {
                //input获取焦点
                for (var i=0;i<input.length;i++) {
                    input[i].style.borderColor = '#bbb';
                }
                this.style.borderColor = '#f00';
                //上下点击
                var self = this;
                document.onkeydown=keyDownSearch;
                function keyDownSearch(e) {
                    // 兼容FF和IE和Opera
                    var theEvent = e || window.event;
                    var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
                    if (code == 38) {
                        self.value++;
                        if (parseInt(self.value) + parseInt(widthValue) > img.clientWidth) {
                            area.style.left = img.clientWidth - widthValue + 'px';
                        } else {
                            area.style.left = self.value + 'px';
                        }
                        return false;
                    }
                    else if (code == 40) {
                        self.value--;
                        if (parseInt(self.value) + parseInt(widthValue) > img.clientWidth) {
                            area.style.left = img.clientWidth - widthValue + 'px';
                        } else {
                            area.style.left = self.value + 'px';
                        }
                        return false;
                    }
                    return true;
                }
            }
            //自增纵坐标
            box.querySelector('.y-axis').onfocus = function() {
                //input获取焦点
                for (var i=0;i<input.length;i++) {
                    input[i].style.borderColor = '#bbb';
                }
                this.style.borderColor = '#f00';
                //上下点击
                var self = this;
                document.onkeydown=keyDownSearch;
                function keyDownSearch(e) {
                    // 兼容FF和IE和Opera
                    var theEvent = e || window.event;
                    var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
                    if (code == 38) {
                        self.value++;
                        if (parseInt(self.value) + parseInt(heightValue) > img.clientHeight) {
                            area.style.top = img.clientHeight - heightValue + 'px';
                        } else {
                            area.style.top = self.value + 'px';
                        }
                        return false;
                    }
                    else if (code == 40) {
                        self.value--;
                        if (parseInt(self.value) + parseInt(heightValue) > img.clientHeight) {
                            area.style.top = img.clientHeight - heightValue + 'px';
                        } else {
                            area.style.top = self.value + 'px';
                        }
                        return false;
                    }
                    return true;
                }
            }
            //编辑宽度
            box.querySelector('.width').onkeyup = function() {
                if (this.value > img.clientWidth) {
                    this.value = img.clientWidth;
                }
                area.style.width = this.value + 'px';
                widthValue = this.value;
            }
            //编辑高度
            box.querySelector('.height').onkeyup = function() {
                if (this.value > img.clientHeight) {
                    this.value = img.clientHeight;
                }
                area.style.height = this.value + 'px';
                heightValue = this.value;
            }
            //编辑横坐标
            box.querySelector('.x-axis').onkeyup = function() {
                if (parseInt(this.value) + parseInt(widthValue) > img.clientWidth) {
                    area.style.left = img.clientWidth - widthValue + 'px';
                } else {
                    area.style.left = this.value + 'px';
                }
            }
            //编辑纵坐标
            box.querySelector('.y-axis').onkeyup = function() {
                if (parseInt(this.value) + parseInt(heightValue) > img.clientHeight) {
                    area.style.top = img.clientHeight - heightValue + 'px';
                } else {
                    area.style.top = this.value + 'px';
                }
            }

             //鼠标移入移除热点区域
            var areaSet = map.querySelectorAll('.area');
            for (var i=0;i<areaSet.length;i++) {
                areaSet[i].onmouseover = function() {
                    this.querySelector('.shade').style.display = 'block';
                }
                areaSet[i].onmouseout = function() {
                    this.querySelector('.shade').style.display = 'none';
                }
            }
            //在数据库systemImgSeat表中创建一条记录
            document.getElementById("addHot").onclick = function() {
                $.post("<?php echo $root;?>control/ku/addata.php?type=adSystemImg", $('[name=areaForm]').serialize(), function(data) {
                    if(data.warn == 2){
                        if(data.href){
                            window.location.href = data.href;
                        }else{
                            window.location.reload();
                        }
                    }else{
                        warn(data.warn);
                    }
                },"json");

            }
        }
    </script>
<?php echo warn().adfooter();?>