<?php
include "OpenFunction.php";
foreach($_POST as $key => $value){
    $post[$key] = FormSubArray($value);
}
if($KehuFinger == 2){
    $json['warn'] = "您未登录";
    /*----------------------------个人中心基本资料更新------------------------------------*/
}else if($_GET['type'] == 'modifyData'){
    //赋值
    $accountNumber = $post['accountNumber'];//登录帐号
    $companyName = $post['companyName'];//公司名称
    $regionId = $post['area'];//所在区县ID号
    $addressMx = $post['addressMx'];//详细地址
    $contactName = $post['contactName'];//联系人姓名
    $contactTel = $post['contactTel'];// 联系人手机号码
    $khpas = $post['khpas'];//登录密码
    $reg_chinese = "/^[\x{4e00}-\x{9fa5}]+$/u";
    //判断
    if(empty($accountNumber)){
        $json['warn'] = "登录帐号不能为空";
    }else if(empty($companyName)){
        $json['warn'] = "公司名称不能为空";
    }else if(empty($regionId)){
        $json['warn'] = "所属区域不能为空";
    }else if(empty($addressMx)){
        $json['warn'] = "详细地址不能为空";
    }else if(empty($contactName)){
        $json['warn'] = "联系人姓名不能为空";
    }else if(empty($contactTel)){
        $json['warn'] = "请输入联系人手机号码";
    }else if(preg_match($CheckTel,$contactTel) == 0){
        $json['warn'] = "联系人手机号码格式有误";
    }else{
        $bool = mysql_query("update kehu set
		accountNumber = '$accountNumber',
		companyName = '$companyName',
		RegionId = '$regionId',
		addressMx = '$addressMx',
		contactName = '$contactName',
		contactTel = '$contactTel',
		khpas = '$khpas',
		updateTime = '$time' where khid = '$kehu[khid]' ");
        if($bool){
            $_SESSION['warn'] = "基本资料更新成功";
            $json['warn'] = 2;
        }else{
            $json['warn'] = "基本资料更新失败";
        }
    }
    /*------------------服务预约-------------------------------------------------*/
}else if ($_GET['type'] == 'bespeak') {
    //赋值
    $type = $post['type'];   //系统类别
    $bespeakText = $post['bespeakText'];   //故障现象描述
    $bespeakTime = $post['bespeakYear']."-".$post['bespeakMoon']."-".$post['bespeakDay']; //预约维护时间
    $bespeakYear = $post['bespeakYear'];  //预约维护时间
    $bespeakMoon = $post['bespeakMoon'];  //预约维护时间
    $bespeakDay = $post['bespeakDay'];    //预约维护时间
    $contactName = $post['contactName'];   //联系人
    $contactTel = $post['contactTel'];   //联系电话
    $remark = $post['remark']; //备注
    //判断
    if (empty($type)) {
        $json['warn'] = "请选择系统类别";
    } elseif (empty($bespeakText)) {
        $json['warn'] = "请填写故障现象描述";
    } elseif (empty($bespeakYear) or empty($bespeakMoon) or empty($bespeakDay)) {
        $json['warn'] = "请选择预约维护时间";
    } elseif (empty($contactName)) {
        $json['warn'] = "请填写联系人姓名";
    } elseif (empty($contactTel)) {
        $json['warn'] = "请填写联系人电话";
    }else if(preg_match($CheckTel,$contactTel) == 0){
        $json['warn'] = "联系人电话格式不正确";
    } elseif (empty($remark)) {
        $json['warn'] = "请填写备注";
    } elseif (empty($id)) {
        $id = suiji();
        $bool = mysql_query("INSERT INTO bespeak
                (id, khid, isFeedback, type, bespeakText, bespeakTime, contactName, contactTel, remark, updateTime, time)
                VALUES
                ('$id', '$kehu[khid]', '否', '$type', '$bespeakText', '$bespeakTime' ,'$contactName', '$contactTel', '$remark', '$time', '$time') ");
        if ($bool) {
            $_SESSION['warn'] = "服务预约成功";
            $json['warn'] = 2;
        } else {
            $json['warn'] = "服务预约失败".$type;
        }
    }
    if (isMobile()) {
        $json['href'] = root."m/mUser/mUsBespeak.php?id=".$id;
    }
    else {
        $json['href'] = root."user/bespeak.php?id=".$id;
    }
    /*------------------投诉-------------------------------------------------*/
}else if ($_GET['type'] == 'complain') {
    //赋值
    $complainText = $post['complainText']; //投诉说明
    $device = query("device", "id = '$deviceId' ");  //设备表
    //判断
    if (empty($complainText)) {
        $json['warn'] = "请填写投诉说明";
    } elseif (empty($id)) {
        $id = suiji();
        $bool = mysql_query("INSERT INTO complain
                (id, khid, complainText, time)
                VALUES
                ('$id','$kehu[khid]','$complainText','$time') ");
        if ($bool) {
            $_SESSION['warn'] = "投诉成功";
            $json['warn'] = 2;
        } else {
            $json['warn'] = "投诉失败";
        }
    }
    if (isMobile()) {
        $json['href'] = root."m/mUser/mUsComplain.php?deviceId=".$deviceId;
    }
    else {
        $json['href'] = root."user/complain.php?deviceId=";
    }
    /*---------------------------我的投诉分页------------------------------------*/
}else if(isset($_GET['act']) and $_GET['act'] == 'share'){
    $page = $_GET['page'];
    $json = share($page);
/*---------------------------我的预约分页------------------------------------*/
}else if(isset($_GET['act2']) and $_GET['act2'] == 'share'){
    $page = $_GET['page'];
    $json = share2($page);
/*---------------------------我的维修记录分页------------------------------------*/
}else if(isset($_GET['act3']) and $_GET['act3'] == 'share'){
    $page = $_GET['page'];
    $json = share3($page);
    /*----------------------------删除我的预约列表------------------------------------*/
}else if(isset($_GET['DeleteBespeakId'])){
    $id  = $_GET['DeleteBespeakId']; //我的预约ID
    if(mysql_query("delete from bespeak where id = '$id' ")){
        $json['warn'] = 2;
    }else{
        $json['warn'] = "删除成功";
    }
    /*----------------------------删除我的投诉列表------------------------------------*/
}else if(isset($_GET['DeleteComplainId'])){
    $id  = $_GET['DeleteComplainId']; //我的投诉ID
    if(mysql_query("delete from complain where id = '$id' ")){
        $json['warn'] = 2;
    }else{
        $json['warn'] = "删除成功";
    }
    /*----------------------------删除我的维修记录列表------------------------------------*/
}else if(isset($_GET['DeleteServiceId'])){
    $id  = $_GET['DeleteServiceId']; //我的维修记录ID
    if(mysql_query("delete from service where id = '$id' ")){
        $json['warn'] = 2;
    }else{
        $json['warn'] = "删除成功";
    }
    /*-----------------我的设备搜索表单提交返回数据-------------------------------------------------------------*/
}elseif(isset($_POST['identifyId'])){
    //赋值
    $StartYear = $_POST['StartYear'];
    $StartMoon = $_POST['StartMoon'];
    $StartDay = $_POST['StartDay'];
    $EndYear = $_POST['EndYear'];
    $EndMoon = $_POST['EndMoon'];
    $EndDay = $_POST['EndDay'];
    $startTime = $_POST['StartYear']."-".$_POST['StartMoon']."-".$_POST['StartDay']." 00:00:00";  //采购开始时间
    $endTime = $_POST['EndYear']."-".$_POST['EndMoon']."-".$_POST['EndDay']." 00:00:00";  //采购结束时间
    $identifyId = $_POST['identifyId'];//设备识别ID
    $name = $_POST['name'];//设备名称
    $model = $_POST['model'];//设备型号
    $brand = $_POST['brand'];//设备品牌
    $where = " where 1=1 ";
    //判断
    if (!empty($StartYear) and !empty($StartMoon) and !empty($StartDay) and !empty($EndYear) and !empty($EndMoon) and !empty($EndDay)) {
        $where .= "and time >= '$startTime' and time <= '$endTime' ";
    }else if (!empty($StartYear) and !empty($StartMoon) and !empty($StartDay)) {
        $where .= "and time >= '$startTime'";
    }
    if(!empty($identifyId)){
        $where .= "and identifyId = '$identifyId'";
    }
    if(!empty($name)){
        $where .= "and name = '$name'";
    }
    if(!empty($model)){
        $where .= "and model = '$model'";
    }
    if(!empty($brand)){
        $where .= "and brand = '$brand'";
    }
    //查询返回结果
    $json['html'] = "
        <li class='deviceList-head clearfix'>
            <span>查询ID</span>
            <span>名称</span>
            <span>型号</span>
            <span>品牌</span>
            <span>系统类别</span>
            <span>数量</span>
            <span>单位</span>
        </li>
    ";
    $deviceSql = mysql_query(" select * from device {$where} order by updateTime desc " );
    if(mysql_num_rows($deviceSql) == 0){
        $json['html'] .= "一台设备信息都没有";
    }else{
        while($array = mysql_fetch_array($deviceSql)){
            if (empty($array['ico'])) {
                $ico = img('ZEg70828834DN');
            }
            else {
                $ico = $root.$array['ico'];
            }
            if (isMobile()) {
                $deviceDetailsUrl = "m/mUser/mUsDeviceDetails.php";
                $bespeakUrl = "m/mUser/mUsBespeak.php";
                $complainUrl = "m/mUser/mUsComplain.php";
            }
            else {
                $deviceDetailsUrl = "deviceDetails.php";
                $bespeakUrl = "user/bespeak.php";
                $complainUrl = "user/complain.php";
            }
            $system = query("system", "id = '$array[type]' ");
            $json['html'] .= "
				<li class='deviceList-item clearfix'>
					<a href='{$root}{$deviceDetailsUrl}?id={$array['id']}'>
						<span>{$array['identifyId']}</span>
                        <span>{$array['name']}</span>
                        <span>{$array['model']}</span>
                        <span>{$array['brand']}</span>
                        <span>{$system['name']}</span>
                        <span>{$array['num']}</span>
                        <span>{$array['unit']}</span>
					</a>
				</li>
			";
        }
    }
}
echo json_encode($json);
?>