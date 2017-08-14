<?php
include "../library/mFunction.php";
$id = $get['id'];
$status = $get['status'];//状态 舱内出门out 进仓enter
$device = query("device"," GymId = '$id' ");
if (empty($device['id'])) {
    $_SESSION['warn'] = "对不起，该舱未安装门禁设备";
    header("location:{$root}m/mindex.php");
    exit(0);
}else{
    $kehu = query("kehu","khid = '$kehu[khid]'");
    $Gym = query("Gym"," id = '$device[GymId]' "); //健身房信息
    //查询现在健身的人数
    $cResult = mysql_query("SELECT *,(TIME_TO_SEC(now()) - TIME_TO_SEC(StartTime)) sec FROM CardRecord WHERE DeviceId = '$device[DeviceId]' AND StartTime IS NOT NULL AND EndTime = '0000-00-00 00:00:00' ORDER BY StartTime ASC");
    $PeopleNum = mysql_num_rows($cResult);
    if ($PeopleNum > 0) {
        while($array = mysql_fetch_assoc($cResult)){
            $totalTime = abs($array['sec']); //统计时长
            if($totalTime >= 5400){
                $pro_time = 5400;
            }else{
                $pro_time = $totalTime;
            }
            $width = (($pro_time / 5400)*100)."%";
            if($pro_time >= 5400){
                $style="style='width:{$width};background: #FFEB3B;'";
                //调用推送消息函数
                if($array['OverMessage'] != '是'){
                    mysql_query("update CardRecord set OverMessage = '是' where id = '$array[id]' ");
                    $mes = "温馨提示：你在{$Gym['name']}健身已经超过90分钟，请勿过度健身";
                    $access_token = getAccessToken();
                    $mKehu = query("kehu"," khid = '$array[khid]' ");
                    sendMsgToAll($access_token,$mKehu['wxOpenid'],$mes); //发送消息
                }
            }elseif($pro_time > 3600){
                $style="style='width:{$width};background: #FC0;'";
            }else{
                $style="style='width:{$width};background: #FFEB3B;'";
            }
            $RecordKehu = query("kehu"," khid = '$array[khid]' "); //舱内邻居信息
            if (empty($RecordKehu['wxIco'])) {
                $RecordKehu['wxIco'] = HeadImg($RecordKehu['wxSex'],$RecordKehu['wxIco']);
            }
            $cTime = round($totalTime / 3600,1);
            $li .= "
                    <li data-neighbor='{$RecordKehu['khid']}'>
                        <div class='port'>
                            <img src='{$RecordKehu['wxIco']}' alt='{$RecordKehu['NickName']}' style='box-shadow: 0 0 1px #ccc;display: block;'/>
                        </div>
                        <span class='nic'>".kong($RecordKehu['wxNickName'])."</span>
                        <div class='pro-back' >
                           <div class='pro' data-max-length='7200' {$style}></div>
                        </div>
                        <p>{$cTime} H</p>
                    </li>";
        }
    }else{
        $li = "<li class='no-data'>暂时无人锻炼</li>";
    }
    if($PeopleNum >= 0){
        //舒适指数
        $ComfortIndexLow = para("gymCosy");// 健身指数“舒适”的最高人数
        $ComfortIndexHigh = para("gymCommonly");// 健身指数“一般”的最高人数
        if($PeopleNum <= $ComfortIndexLow){
            $Comfort = "<span class='xqd1span' style='background: #FFEB3B;'>舒适</span><span class='xqd1span'>一般</span><span class='xqd1span'>拥挤</span>";
        }elseif($PeopleNum <= $ComfortIndexHigh){
            $Comfort = "<span class='xqd1span'>舒适</span><span class='xqd1span' style='background: #FFEB3B;'>一般</span><span class='xqd1span'>拥挤</span>";
        }else{
            $Comfort = "<span class='xqd1span'>舒适</span><span class='xqd1span'>一般</span><span class='xqd1span' style='background: #FFEB3B;'>拥挤</span>";
        }
    }
    $neighbor = "
            <div class='xqdiv11 wrap-box'>
            <div class='title'><h3><i class='neighbor-icon icon'>&#xe609;</i> 舱内邻居</h3></div>
                <ul class='xq11ul' id='neighborList' style='display: flex;flex-wrap: wrap;margin-top:20px'>
                {$li}
                </ul>
            </div>";
    //查询锻炼时长 判断是否在舱内
    $totalSec = StaTime($kehu['khid'],"本次",$device['DeviceId'],"秒"); //锻炼时长 分钟
    $StaTime = ceil($totalSec / 60); //锻炼时长 分钟
    if (empty($StaTime)) {
        $StaTime = 0;
    }
    $money = $kehu['money']; //账户余额
    $price = priceRange("timeInterval"); //计算当前时间区间所在单价
    $consume = $StaTime * $price; //本次消费金额
}
echo head("m");
?>
<style>
    .nic{overflow: hidden;text-overflow:ellipsis;width:61.16px;white-space: nowrap;}
    #qrcode canvas{ width:100%;}
    #DoorFixed{width:100%;height:100%;position:fixed;top:0px;left:0px;z-index:1000;background-color:#000000;opacity:.50; display:none;}
</style>
<div class="ploading">
    <div class="load-container load">
        <div class="loader">Loading...</div>
    </div>
</div>
<div class="wrap">
    <div class="xqdiv12 wrap-box">
        <div class="title"><h3><i class="description-icon icon">&#xe6a8;</i> 公告栏</h3></div>
        <div class="content placard-content">
            <?php echo neirong(website("stI70321425EW")) ;?>
        </div>
    </div>
    <div class="wrap-box" id="navigationTemplate">
        <div class="focus">
            <div class="pag pag-1"></div>
            <div class="swiper swiper-1">
                <ul class="swiper-wrapper">
                </ul>
            </div>
        </div>
        <div class="focusdiv">
            <span><i class="position-icon icon">&#xe620;</i> <?php echo $Gym['AddressMx'];?></span><a href="<?php echo "{$root}m/mGymMap.php?id={$id}";?>">地图导航</a>
            <div class="clear"></div>
        </div>
    </div>
    <div class="xqdiv1 wrap-box">
        <div class="title"><h3><i class="fitnessNum-icon icon">&#xe607;</i>健身人数</h3></div>
        <div class="content">
            <p>现在健身人数：<b><?php echo $PeopleNum; ?>人</b></p>
            <p class="xqd1p1" >
                <span class="xqd1span1">舒适指数：</span>
                <?php echo $Comfort;?>
            <div class="clear"></div>
        </div>
    </div>
    <div class="xqdiv12 wrap-box">
        <div class="title"><h3><i class="live-icon icon">&#xe610;</i>查看舱内现在健身情况</h3></div>
        <div class="content">
            <a href="<?php echo "{$root}m/mVideo.php?url={$Gym['oxygen']}";?>" class="xq12a1">无氧舱</a>
            <a href="<?php echo "{$root}m/mVideo.php?url={$Gym['anaerobic']}";?>" class="xq12a2">有氧舱</a>
            <div style="clear:both;"></div>
        </div>
    </div>
    <!-- 舱内邻居 -->
    <?php echo $neighbor;?>
    <!-- 锻炼排行 -->
    <div class="wrap-box box ranking" id="ranking">
        <div class="title">
            <h3><i class="ranking-icon">&#xe601;</i> 本周训练时长前五名</h3>
        </div>
        <ul>
            <?php echo rankingText("周",5,$device['DeviceId'])?>
        </ul>
        <!-- 累积最长 -->
        <div class="title title-add">
            <h3><i class="ranking-icon">&#xe601;</i> 累计最长锻炼记录</h3>
        </div>
        <ul>
            <?php echo rankingText("总",1,$device['DeviceId'])?>
        </ul>
        <!-- 累积最长 end -->

        <!-- 周最长最长 -->
        <div class="title title-add">
            <h3><i class="ranking-icon">&#xe601;</i> 周最长锻炼记录</h3>
        </div>
        <ul>
            <?php echo rankingText("周最长",1,$device['DeviceId'])?>
        </ul>
    </div>
    <!-- 周最长最长 end -->
    <!-- 进场须知 -->
    <div class="xqdiv3 wrap-box">
        <div class="title"><h3><i class="description-icon icon">&#xe6a8;</i> 进场须知</h3></div>
        <div class="content">
            <?php echo neirong(website("YJP46922963OB"));?>
        </div>
    </div>
    <!-- 进场须知 end -->
</div>
<!--拥挤警示弹出层开始-->
<!--<a href="#" id="ewmys" title="浮动按钮"></a>-->
<div id="DoorFixed"></div>
<div id="ccts">
    <div class="ccts">
        <p>目前在健身箱人数超过<?php echo $PeopleNum;?>人，客户健身箱较拥挤</p>
        <div class="line"></div>
        <div class="ccdiv"><a href="#" class="close_btn" id="SureOut">确定</a><a href="#" class="close_btn">取消</a></div>
    </div>
</div>
<!--拥挤警示弹出层结束-->
<!-- 邻居详情弹出层 -->
<div class="neighbor-shade hide" id="neighbor-shade">
    <div class="shade-box">
        <!--头部-->
        <div class="header clearfix">
            <div class="header-pic fl">
                <img id="wxIco" src="http://wx.qlogo.cn/mmopen/pXosMMaRmNeO2ibGOEbcAZQhIZfm1c7p6DeQeJ6U22MXda367H7LXpL9uQrh9SoOpxrbVZEPicwOX08hbQDoJeeVkoz414HyJ5/0" alt="图片" />
            </div>
            <div class="header-text fr">
                <span class="text-name" id="nickname">双份的阳光</span>
            </div>
        </div>
        <!--我的荣耀-->
        <div class="xqdiv4 wrap-box-two">
            <div class="title">
                <h3><i class="icon">&#xe606;</i> 获得荣耀</h3>
            </div>
            <div class="content">
                <ul>
                    <li>
                        <!-- <span class="medal">荣誉勋章：</span>-->
                        <p id="medalStr"></p>
                    </li>
                    <li>
                        <span>当前训练时间：</span>
                        （<b id="mcurrent"> 0 </b> 分钟）
                    </li>
                    <li>
                        <span>本周训练时间：</span>
                        （<b id="mweek">0</b> 分钟）
                    </li>
                    <li>
                        <span>当月训练时间：</span>
                        （<b id="month">0</b> 分钟）
                    </li>
                    <li>
                        <span>年度训练时间：</span>
                        （<b id="myear">0</b> 分钟）
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- 邻居详情弹出层 end -->

<!-- 确认开门弹出层 -->
<div class="enter-door-shade hide" id="enterDoorShade">
    <div class="shade-module">
        <div class="module-head">
            温馨提示！
        </div>
        <div class="module-content">
            你目前的账户余额：<span> <?php echo $money;?> </span>元<br />
            <?php echo $chargeStr; ?>
            确定要开门健身吗？
        </div>
        <div class="module-btn">
            <a href="<?php echo root.'library/mPost.php?t=scanQRCode&did='.$device['DeviceId'].'&status=enter'; ?>" class="btn-confirm" id="btnConfirm">确认</a>
            <a href="javascript:;" class="btn-cancel" id="btnCancel">取消</a>
        </div>
    </div>
</div>
<!-- 确认开门弹出层 end -->
<!-- 结束健身出门弹出层 -->
<div class="out-door-shade hide" id="outDoorShade">
    <div class="shade-module">
        <div class="module-head">
            温馨提示！
        </div>
        <div class="module-content">
            您本次健身时长：<span id="totalTimeText"> <?php echo $StaTime; ?> </span>分钟<br />
            应付<span id="totalMoneyText"><?php echo $consume;?> </span>元
        </div>
        <div class="module-btn">
            <a href="<?php echo $root.'library/mPost.php?t=scanQRCode&did='.$device['DeviceId'].'&status=out'; ?>" class="btn-confirm" id="outConfirm">支付</a>
            <a href="javascript:;" class="btn-cancel" id="outCancel">取消</a>
        </div>
    </div>
</div>
<!-- 结束健身出门弹出层 end -->
<!-- 欠费弹出层 -->
<div class="arrears-door-shade hide" id="arrearsDoorShade">
    <div class="shade-module">
        <div class="module-head">
            温馨提示！
        </div>
        <div class="module-content">
            您上次欠费<span id="arrearsMoneyText"> <?php echo $money; ?> </span>元
        </div>
        <div class="module-btn">
            <a href="<?php echo $root.'m/mUser/mUsCard.php'; ?>" class="btn-confirm" id="outConfirm">确认支付</a>
        </div>
    </div>
</div>
<!-- 欠费弹出层 end -->
<?php echo mWarn().msg().footer();?>
</body>
<script>
    window.onload = function() {
        //判断是否在舱内
        var status  = '<?php echo $status;?>', //操作状态 out enter
            seconds = <?php echo $totalSec; ?>, //在舱内的秒数
            money = <?php echo $money; ?>; //余额
        if (status.length > 0) {
            if (status == 'enter' && seconds == 0) { //进舱开门
                if (money < 0) { //提示欠费
                    $("#arrearsDoorShade").removeClass('hide');
                }else{ //开门
                    $("#enterDoorShade").removeClass('hide');
                }
            }else if(status == 'out' && seconds > 0){ //出门
                $("#outDoorShade").removeClass('hide'); //出舱开门
            }
        }
        //点击舱内头像请求数据
        var neighborList = getId('neighborList');
        var neighborShade = getId('neighbor-shade');
        var ranking = getId('ranking');
        getMessage(neighborList);
        getMessage(ranking);
        neighborShade.onclick = function() {
            this.style.display = 'none';
        }

        //添加荣誉勋章图标，颜色
        var icon = ranking.querySelectorAll('.week-icon');
        if (icon[0]) {
            icon[0].innerHTML = '&#xe641;';
            icon[0].style.color = '#F44336';
        }
        if (icon[1]) {
            icon[1].innerHTML = '&#xe66b;';
            icon[1].style.color = '#FFC107';
        }
        if (icon[2]) {
            icon[2].innerHTML = '&#xe66c;';
            icon[2].style.color = '#2196F3';
        }
        if (icon[icon.length-2]) {
            icon[icon.length-2].innerHTML = '&#xe604;';
            icon[icon.length-2].style.color = '#FF5722';
        }
        if (icon[icon.length-1]) {
            icon[icon.length-1].innerHTML = '&#xe62e;';
            icon[icon.length-1].style.color = '#FFEB3B';
        }

        //确认开门弹出层
        var enterDoorShade = getId('enterDoorShade');
        var btnCancel = getId('btnCancel');
        var outDoorShade = getId('outDoorShade');
        var outCancel = getId('outCancel');
        //取消按钮点击事件
        btnCancel.onclick = function() {
            enterDoorShade.style.display = 'none';
        }

        outCancel.onclick = function() {
            outDoorShade.style.display = 'none';
        }

        /**
         * 获取信息
         * @param parent 点击的父级
         * @author He Hui
         */
        function getMessage(parent) {
            parent.addEventListener('click', function(ev) {
                var ev = ev || window.event;
                var target = ev.target || ev.srcElement;
                while(target !== parent ) {
                    if (target && target.tagName.toLowerCase() == 'li') {
                        var dataNeighbor = target.getAttribute('data-neighbor');
                        //请求数据
                        $.post(root+'library/mData.php?type=mHealth', {kehu: dataNeighbor,did:'<?php echo $device['DeviceId'];?>'}, function(data) {
                            if(data.warn == 1){
                                $("#nickname").html(data.name);
                                $("#wxIco").attr('src',data.ico);
                                $("#medalStr").html(data.medalStr);
                                $("#mcurrent").html(data.current);
                                $("#mweek").html(data.week);
                                $("#month").html(data.month);
                                $("#myear").html(data.year);
                                neighborShade.style.display = 'block';
                            }else{
                                mwarn(data.warn);
                            }
                        },'json');
                    }
                    target = target.parentNode;
                }
            })
        }


    }

    /**
     * 获取id
     * @param id 元素id
     * @author He Hui
     * */
    function getId(id) {
        return document.getElementById(id);
    }

    /**
     * 写cookies
     * @param name 名字
     * @param value 值
     * @author He Hui
     * */
    function setCookie(name,value)
    {
        var Days = 30;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
    }
</script>
</html>