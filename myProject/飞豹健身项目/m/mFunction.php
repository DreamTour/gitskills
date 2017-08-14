<?php
/*
*移动端函数库
*/
include dirname(dirname(dirname(__FILE__)))."/library/OpenFunction.php";
/*********移动端使用微信自动登录函数***********************/
if($KehuFinger == 2){
    wxLogin($ThisUrl);
}

//货币单位函数
$unit = para("currencyUnit");

//收费标准
$chargeStr= charges();
function charges(){
    $str = para("timeInterval");
    $arr = explode("，",$str);
    foreach ($arr as $key => $value) {
        $arr = explode("：",$value); //分割记录的时间和金钱
        $money = $arr[1];
        $time = explode("-",$arr[0]); //分割开始和结束时间
        $startTime = $time[0]  ;//开始时间
        $endTime = $time[1];//结束时间
        $tollStr .= "<em>{$startTime}-{$endTime} <span>{$money}</span>元/分钟</em><br>";
    }
    return $tollStr;
}

/**
 * 查询勋章函数
 * @param $khid 客户ID
 * @return $imgStr 勋章地址
 **/
function queryMedal($khid){
    $arr = query("kehu","khid = '$khid'");
    if (empty($arr['medalGroup'])) {
        return "<p class='medalStr'>暂时没有获得荣誉勋章</p>";
    }else{
        $medalGroup = json_decode($arr['medalGroup']); //勋章集合
        foreach ($medalGroup as $id) {
            $imgStr .= "<img src=\"".img($id)."\" width='40' alt=\"".imgtext($id)."\" />";
        }
        return $imgStr;
    }
}

/**
 * 更新勋章函数
 * @param  $khid  客户ID
 * @param  $mid  勋章ID
 * @param  $min  分钟数
 */
function upMedal($khid,$mid,$min){
    if (empty($khid) || empty($mid)) {
        $medalContent = "";
    }else{
        $kehu = query("kehu","khid = '$khid'");
        $medal = json_decode($kehu['medalGroup']); //勋章集合
        $bool = in_array($mid,$medal);
        if (!$bool) {//判断是否已经存在此勋章
            if (empty($medal)) { //判断是否是第一个
                $medal = explode(",",$mid);
            }else{
                array_push($medal,$mid); //在数组后插入新勋章
            }
            $groupStr = json_encode($medal);
            $bool  = mysql_query("UPDATE kehu SET medalGroup='{$groupStr}' WHERE khid = '$khid' ");
            if ($bool && !empty($min)) { //排出特定日
                $medalContent = showMedal($min,$mid); //显示勋章 showMedal()勋章显示函数
            }
        }
    }
    return $medalContent;
}

/**
 * 勋章显示函数
 * @param  $minute 分钟数或者特定日
 * @param  $mid    勋章图片ID
 */
function showMedal($minute,$mid){
    $img = img($mid); //勋章图片地址
    if (is_string($minute)) { //判断类型
        $spanStr = "<span>获得特定日 {$minute} 锻炼勋章</span>";
    }else{
        $spanStr = "<span>获得累积锻炼{$minute}分钟勋章</span>";
    }
    return "
    <div class='medal-shade' id='medal-shade'>
        <div class='shade-box'>
            <div class='medal-pic'>
                <img src='{$img}' alt='{$minute}分钟勋章图片' />
            </div>
            <div class='medal-explain'>
                <div class='first'>1st</div>
                <h3>恭喜您!</h3>
                {$spanStr}
            </div>
        </div>
    </div>";
}

/**
 * 统计累积时间函数
 * @param $khid 客户ID
 * @param $type 类型
 * @param $did 门锁设备ID
 * @param $unit 单位 为空为分
 * @return 分钟
 */
function StaTime($khid,$type,$did=NULL,$unit=NULL){
    if (empty($khid)) {
        return false;
    }else{
        $sql = "SELECT khid,SUM(IntervalTime) AS total  FROM CardRecord WHERE khid ='{$khid}' ";
        switch ($type) {
            case '周':
                $sql .= " AND IntervalTime is not null AND DATE_SUB(CURDATE(), INTERVAL 7 DAY) <=date(time)";
                break;
            case '月':
                $sql .= " AND IntervalTime is not null AND DATE_FORMAT( time, '%Y%m') = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
                break;
            case '年':
                $sql .= " AND IntervalTime is not null AND YEAR(time) = YEAR( NOW())";
                break;
            case '总':
                $sql .= " AND IntervalTime is not null";
                break;
            case '本次':
                $sql = "SELECT khid,(TIME_TO_SEC(now()) - TIME_TO_SEC(StartTime)) total FROM CardRecord WHERE khid ='{$khid}' AND DeviceId = '$did' AND StartTime IS NOT NULL AND EndTime = '0000-00-00 00:00:00' ORDER BY StartTime ASC";
                break;
            default:
            case '周':
                break;

        }
        $result = mysql_query($sql);
        while ($arr = mysql_fetch_assoc($result)) {
            if (!empty($unit)) {
                $total = $arr['total']; //秒
            }else{
                $total = round($arr['total'] / 60,0); //累积时长(分钟)
            }
        }
        if (empty($total)) {
            $total = 0;
        }
        return $total;
    }
}

/**
 * 排行榜函数
 * @param  $type 类型
 * @param  $num 显示条数
 * @param  $did 门锁ID 用于区分哪个健身房
 */
function rankingText($type,$num,$did){
    if (empty($type)) {
        return false;
    }else{
        switch ($type) {
            case '周':
                $where = "IntervalTime is not null AND DeviceId = '$did' AND DATE_SUB(NOW(), INTERVAL 7 DAY) <=date(time) GROUP BY khid";
                break;
            case '周最长':  //查询所有周记录 ，并按周排序
                $where = "IntervalTime is not null AND DeviceId = '$did' GROUP BY weeks,khid ";
                break;
            case '总':
                $where = "IntervalTime is not null AND DeviceId = '$did' GROUP BY khid ";
                break;
            default:
            case '周':
                break;
        }
        $result = mysql_query("SELECT khid,DATE_FORMAT(time,'%Y%u') weeks,SUM(IntervalTime) AS total  FROM CardRecord WHERE {$where} ORDER BY total DESC limit 0,{$num}");
        $nums = mysql_num_rows($result);
        if ($nums <= 0) {
            $content = "<li class='clearfix no-data'>此排行榜暂无人员上榜</li>";
        }else{
            $i=0;
            while ($arr = mysql_fetch_assoc($result)) {
                $kehu = query("kehu","khid = '{$arr['khid']}' ");
                if (empty($kehu['wxIco'])) {
                    $kehu['wxIco'] = img("oisuw6d"); //默认头像
                }
                $i++;
                $total = round($arr['total'] / 60,0); //转换成分钟
                $content .= "<li class='clearfix' data-neighbor='{$kehu['khid']}'>
                                <div class='ranking-count fl'>{$i}</div>
                                <div class='ranking-message fl clearfix'>
                                    <div class='message-pic fl'>
                                        <img src='{$kehu['wxIco']}' alt='头像' data-kehu='{$kehu['khid']}' />
                                    </div>
                                    <div class='message-text fl'>
                                        <strong>".kong($kehu['wxNickName'])."</strong>
                                        <span>已锻炼{$total}分钟</span>
                                    </div>
                                    <i class='week-icon fr'></i>
                                </div>
                            </li>";
            }
        }
        return $content;
    }
}

/**************************头部函数**************************/
//要跳转的页面包含目录
function mHeader($url,$name){
    return "<div class='top'>
<div class='return' id='skip' data-url='{$GLOBALS['root']}{$url}'>{$name}</div>
    <div class='login'><a href='{$GLOBALS['root']}m/mUser/mUser.php'></a></div>
    <div class='clear'></div>
</div>
<div class='top2'>&nbsp;</div>
<script>
(function(){
    'use strict';
    window.skip={
        init:function(){
            document.addEventListener('click',function(evt){
                var target = evt.target;
                switch(target.id){
                    case 'skip':
                         skip.skipUrl(target);
                         break;
                    default:return;
                }
            },false);
        },
        skipUrl:function(target){
            var href = target.getAttribute('data-url');
            window.location = href;
        },
    }
})();
skip.init();
</script>
";
}
function footer(){
    return "
    <div id='bottom'>
    <ul>
        <li>
            <a href='".root."m/mindex.php' class='bota'>下楼就练</a>
        </li>
        <li>
            <a href='".root."m/mCourse.php' class='bota'>媒体库</a>
            <!--<div class='SecondMenu'>
                <a href=''><div>课程表</div></a>
            </div>-->
        </li>
        <li>
            <a href='".root."m/mUser/mUser.php' class='bota'>
                会员中心
                <!--<i class='exclamation-icon'>&#xe628;</i>-->
            </a>
        </li>
    </ul>
    </div>
    ";
}

/**************************检测到用户没有关注微信公众号的时候调用该函数显示公众号二维码**************************/
function attention(){
    if(isset($_SESSION['subscribe']) and $_SESSION['subscribe'] == 1){
        unset($_SESSION['subscribe']);
        return "
        <link rel='stylesheet' href='https://res.wx.qq.com/open/libs/weui/0.4.3/weui.min.css'/>
        <div style='position: fixed;text-align: center; background:#fff;left: 0;top: 0;width: 100%;z-index: 200005;height: 100%'  id='message'>
        <div class='weui_msg'>
            <div class='weui_icon_area'>
               <div style='width:50%;margin:5px auto'><img src='".img('pyP47951402VG')."' style='width:100%;'/></div>
            </div>
            <div class='weui_text_area'>
                <h2 class='weui_msg_title'>温馨提示</h2>
                <p class='weui_msg_desc'>你还没有关注该公众号，长按二维码并识别可以关注该公众号</p>
            </div>
            <div class='weui_opr_area'>
                <p class='weui_btn_area'></p>
            </div>
        </div>
        </div>
        ";
    }
}

/**************************获取的用户坐标转为百度地图坐标函数**************************/
/*
* 获取的用户坐标不精确
*/
function getLocation($Location_X,$Location_Y){
    $postData = "
    <xml>
        <ToUserName><![CDATA[toUser]]></ToUserName>
        <FromUserName><![CDATA[fromUser]]></FromUserName>
        <CreateTime>1351776360</CreateTime>
        <MsgType><![CDATA[location]]></MsgType>
        <Location_X>{$Location_X}</Location_X>
        <Location_Y>{$Location_Y}</Location_Y>
        <Scale>20</Scale>
        <Label><![CDATA[位置信息]]></Label>
        <MsgId>1234567890123456</MsgId>
    </xml> ";
    $object = simplexml_load_string($postData, 'SimpleXMLElement', LIBXML_NOCDATA);
    $lat = $object->Location_X;  //纬度
    $lng = $object->Location_Y;  //经度
    $q = "http://api.map.baidu.com/geoconv/v1/?coords={$lng},{$lat}&from=3&to=5&ak=yaMnqGiWDKzftga34qkznzCydHNs2H52";
    $result = json_decode(file_get_contents($q));
    $json['Location_X'] = $result->result[0]->x;
    $json['Location_Y'] = $result->result[0]->y;
    return $json;
}

/**************************图片处理函数**************************/
function CutImg($type,$name,$NewImg,$NewWidth,$NewHeight){
    if($type == "image/jpeg" || $type == "image/pjpeg"){
        $img = imagecreatefromjpeg($name);
    }else if($type == "image/png" || $type == "image/x-png"){
        $img = imagecreatefrompng($name);
    }else if($type == "image/gif"){
        $img = imagecreatefromgif($name);
    }else{
        $img="";
    }
    if($type == "image/png" || $type == "image/x-png"){
        imagesavealpha($img,true);//设置标记以在保存 PNG 图像时保存完整的 alpha 通道信息（与单一透明色相反）
        $thumb = imagecreatetruecolor($NewWidth,$NewHeight);//创建一个真彩画布
        imagealphablending($thumb,false);//不合并颜色,直接用$img图像颜色替换,包括透明色;
        imagesavealpha($thumb,true);//不要丢了$thumb图像的透明色;
        imagecopyresampled($thumb,$img,0,0,0,0,$NewWidth,$NewHeight,$NewWidth,$NewHeight);
    }else{
        $width = imagesx($img);
        $height = imagesy($img);
        $ratio  = $height/$width;
        $new_ratio  = $NewHeight / $NewWidth;
        if ($ratio > $new_ratio){//如果原图过高
            $x = 0;
            $y = ($height - $NewHeight) / 2;
        }else if ($ratio < $new_ratio){//如果原图过宽
            $x = ($width - $NewWidth) / 2;
            $y = 0;
        }else{//如果原图适中
            $x = 0;
            $y = 0;
        }
        $thumb = imagecreatetruecolor($NewWidth,$NewHeight);//创建一个真彩画布
        //$x,$y是裁剪起点坐标
        imagecopyresampled($thumb,$img,0,0,$x,$y,$NewWidth,$NewHeight,$NewWidth,$NewHeight);
    }
    //保存图像
    if($type == "image/jpeg" || $type == "image/pjpeg"){
        imagejpeg($thumb,$NewImg);
    }else if($type == "image/png" || $type == "image/x-png"){
        imagepng($thumb,$NewImg);
    }else if($type == "image/gif"){
        imagegif($thumb,$NewImg);
    }
    imagedestroy($thumb);
    imagedestroy($img);
}
/******移动端弹窗函数库*****************************/
function mWarn(){
    if (isset ($_SESSION['warn']) and !empty ($_SESSION['warn']) ){
        $GLOBALS['warn'] = $_SESSION['warn'];//使用全局变量的原因：$warn可能从函数外部传入
        unset($_SESSION['warn']);
    }
    if (!empty($GLOBALS['warn']) ){
        $show =  "mwarn('{$GLOBALS['warn']}');";
    }
    $html .= "
        <div class=\"enter-door-shade\" id=\"cover\">
            <div class=\"shade-module\">
                <div class=\"module-head\">
                    温馨提示！
                </div>
                <div class=\"module-content\" id='coverP'>
                    he hui
                </div>
                <div class=\"module-btn\">
                    <a href=\"javascript:;\" class=\"btn-confirm\" id=\"coverSure\">确认</a>
                    <a href=\"javascript:;\" class=\"btn-cancel\" id=\"coverCancel\">取消</a>
                </div>
            </div>
        </div>
    <script>
    $(document).ready(function(){
        {$show}
        $('#coverSure,#coverCancel').click(function(){
            $('#cover').hide();
        });
    });
    function mwarn(word){
        $('#cover').show();
        $('#coverP').html(word);
    }
    </script>
    ";
    return $html;
}
?>