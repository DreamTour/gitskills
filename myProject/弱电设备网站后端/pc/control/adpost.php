<?php
include "adfunction.php";
ControlRoot();
/*-----------------摆位图-系统多条件模糊查询-------------------------------------------------------------------------------------------*/
if(isset($_POST['adSystemName'])){
    //赋值
    $name = $_POST['adSystemName'];   //公司名称
    $x = " where 1=1 ";
    //串联查询语句
    if(!empty($name)){
        $x .= " and name like '%$name%' ";
    }
    //返回
    $_SESSION['adSystem'] = array(
        "name" => $name,"Sql" => $x);
    /*-----------------设备管理-设备返回列表-------------------------------------------------------------------------------------------*/
}elseif($_GET['type'] == 'deleteSearch'){
    $name = $_GET['searchName'];
    unset($_SESSION[$name]);
    /*-----------------设备管理-设备多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adDeviceName'])){
    //赋值
    $accountNumber = $_POST['adDeviceAccountNumber']; //选择客户
    $identifyId = $_POST['adDeviceIdentifyId'];   //设备识别ID
    $name = $_POST['adDeviceName'];   //名称
    $model = $_POST['adDeviceModel'];   //型号
    $brand = $_POST['adDeviceBrand'];   //品牌
    //串联查询语句
    if(!empty($accountNumber)){
        $x .= " and contactNumber = '$accountNumber' ";
    }
    if(!empty($identifyId)){
        $x .= " and identifyId like '%$identifyId%' ";
    }
    if(!empty($name)){
        $x .= " and name like '%$name%' ";
    }
    if(!empty($model)){
        $x .= " and model like '%$model%' ";
    }
    if(!empty($brand)){
        $x .= " and brand like '%$brand%' ";
    }
    //返回
    $_SESSION['adDevice'] = array(
        "accountNumber" => $accountNumber,"identifyId" => $identifyId,"name" => $name,"model" => $model,"brand" => $brand,"Sql" => $x);
    /*-----------------内部管理-设备报修多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adRepairName'])){
    //赋值
    $name = $_POST['adRepairName'];   //系统名称
    $status = $_POST['searchStatus'];   //状态
    //串联查询语句
    if(!empty($name)){
        $x .= " AND type in (SELECT id FROM system WHERE name LIKE '%$name%' ) ";
    }
    if(!empty($status)){
        $x .= " AND status = '$status' ";
    }
    //返回
    $_SESSION['adRepair'] = array(
       "name" => $name,"status" => $status,"Sql" => $x);
    /*-----------------维修反馈-维修设备多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adServiceIdentifyId'])){
    //赋值
    $serviceText = $_POST['adServiceText'];   //维修说明
    $identifyId = $_POST['adServiceIdentifyId'];   //名称
    $manner = $_POST['searchManner'];   //选择方式
    $serviceName = $_POST['adServiceName'];   //维修人
    $status = $_POST['searchStatus'];   //状态
    //串联查询语句
    if(!empty($serviceText)){
        $x .= " AND serviceText LIKE '%$serviceText%' ";
    }
    if(!empty($identifyId)){
        $x .= " AND identifyId LIKE '%$identifyId%' ";
    }
    if(!empty($manner)){
        $x .= " AND manner = '$manner' ";
    }
    if(!empty($serviceName)){
        $x .= " AND serviceName LIKE '%$serviceName%' ";
    }
    if(!empty($status)){
        $x .= " AND status = '$status' ";
    }
    //返回
    $_SESSION['adService'] = array(
        "serviceText" => $serviceText,"identifyId" => $identifyId,"manner" => $manner,"serviceName" => $serviceName,"status" => $status,"Sql" => $x);
    /*-----------------客户管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adClientAccountNumber']) and isset($_POST['adClientCompanyName'])){
    //赋值
    $accountNumber = $_POST['adClientAccountNumber'];//登录帐号
    $companyName = $_POST['adClientCompanyName'];//公司名称
    $ContactName = $_POST['adClientContactName'];//联系人姓名
    $ContactTel = $_POST['adClientContactTel'];//联系人手机号码
    //串联查询语句
    if(!empty($accountNumber)){
        $x .= " and accountNumber like '%$accountNumber%' ";
    }
    if(!empty($companyName)){
        $x .= " and companyName like '%$companyName%' ";
    }
    if(!empty($ContactName)){
        $x .= " and ContactName like '%$ContactName%' ";
    }
    if(!empty($ContactTel)){
        $x .= " and ContactTel like '%$ContactTel%' ";
    }
    //返回
    $_SESSION['adClient'] = array(
        "accountNumber" => $accountNumber,"companyName" => $companyName,"ContactName" => $ContactName,"ContactTel" => $ContactTel,"Sql" => $x);
    /*-----------------客户预约-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adType']) and isset($_POST['adBespeakText'])){
    //赋值
    $type = $_POST['adType'];//系统类别
    $bespeakText = $_POST['adBespeakText'];//设备名称
    $contactName = $_POST['adContactName'];//设备型号
    $x = " where 1=1 ";
    //串联查询语句
    if(!empty($type)){
        $x .= " AND type in (SELECT id FROM system WHERE name LIKE '%$type%' ) ";
    }
    if(!empty($bespeakText)){
        $x .= " and bespeakText like '%$bespeakText%' ";
    }
    if(!empty($contactName)){
        $x .= " and contactName like '%$contactName%' ";
    }
    //返回
    $_SESSION['adBespeak'] = array(
        "type" => $type,"bespeakText" => $bespeakText,"contactName" => $contactName,"Sql" => $x);
    /*-----------------客户投诉-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adComplainContactName']) and isset($_POST['adComplainContactTel'])){
    //赋值
    $contactName = $_POST['adComplainContactName'];//联系人姓名
    $contactTel = $_POST['adComplainContactTel'];//联系人号码
    $complainText = $_POST['adComplainText'];//投诉说明
    $x = " where 1=1 ";
    //串联查询语句
    if(!empty($contactName)){
        $x .= " AND khid in ( SELECT khid FROM kehu WHERE contactName LIKE '%$contactName%') ";
    }
    if(!empty($contactTel)){
        $x .= " AND khid in ( SELECT khid FROM kehu WHERE contactTel LIKE '%$contactTel%') ";
    }
    if(!empty($complainText)){
         $x .= " AND complainText LIKE '%$complainText%' ";
    }
    //返回
    $_SESSION['adComplain'] = array(
        "contactName" => $contactName,"contactTel" => $contactTel,"complainText" => $complainText,"Sql" => $x);
/*------------------摆位图-上传摆位图---------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['adSketchMapMxIcoUpload']) and isset($_POST['adSystemId'])){
    //赋值
    $id = $_POST['adSystemId']; //系统id
    $system = query("system"," id = '$id' "); //系统
    //判断并执行
    if(empty($id)){
        $_SESSION['warn'] = "请先提交系统基本参数";
    }elseif($system['id'] != $id){
        $_SESSION['warn'] = "未找到本系统";
    }else{
        $FileName = "adSketchMapMxIcoUpload";//上传图片的表单文件域input名称
        $cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
        $cut['width'] = "";//裁剪宽度
        $cut['height'] = "";//裁剪高度
        $cut['NewWidth'] = 1000;//缩放的宽度
        $cut['MaxHeight'] = 1200;//缩放后图片的最大高度
        $type['name'] = "新增图像";//"更新图像"or"新增图像"
        $type['num'] = 20;//新增图像时限定的图像总数
        $sql = " select * from systemImg where systemId = '$id' ";//查询图片的数据库代码
        $column = "src";//保存图片的数据库列的名称
        $suiji = suiji();
        $Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
        $Url['NewImgUrl'] = "img/systemImg/{$suiji}.jpg";//新图片保存的网站根目录位置
        $NewImgSql = " insert into systemImg (id,systemId,src,time) values ('$suiji','$id','$Url[NewImgUrl]','$time') ";//保存图片的数据库代码
        $ImgWarn = "摆位图更新成功";//图片保存成功后返回的文字内容
        UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
    }
    /*------------------删除摆位图----------------------------------------------------------------------------------------------------------------------*/
}elseif(!empty($_GET['sketchMapDelete'])) {
    $id = $_GET['sketchMapDelete']; //摆位图id
    $systemImg = query("systemImg", " id = '$id' ");
    unlink(ServerRoot . $systemImg['src']);
    mysql_query("delete from systemImg where id = '$id'");
    $_SESSION['warn'] = "排位图详情图片删除成功";
    /*------------------摆位图-热点删除----------------------------------------------------------------------------------------------------------------------*/
}elseif($_GET['type'] == "systemImgSeatDelete"){
        /*if ($adDuty['name'] != "超级管理员") {
            $_SESSION['warn'] = "你没有权限删除热点";
        }
        else {

        }*/
    $id = $_GET['systemImgSeatDelete']; //热点id
    $systemImgSeat = query("systemImgSeat"," id = '$id' ");
    mysql_query("delete from systemImgSeat where id = '$id'");
    $_SESSION['warn'] = "热点删除成功";
    /*------------------设备管理-上传设备列表图片---------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['adListIcoUpload']) and isset($_POST['adListId'])){
    //赋值
    $id = $_POST['adListId'];
    $device = query("device"," id = '$id' ");
    //判断并执行
    if(empty($id)){
        $_SESSION['warn'] = "请先提交设备基本参数";
    }elseif($device['id'] != $id){
        $_SESSION['warn'] = "未找到本设备";
    }else{
        $FileName = "adListIcoUpload";//上传图片的表单文件域input名称
        $cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
        $cut['width'] = "";//裁剪宽度
        $cut['height'] = "";//裁剪高度
        $cut['NewWidth'] = 500;//缩放的宽度
        $cut['MaxHeight'] = 1000;//缩放后图片的最大高度
        $type['name'] = "更新图像";//"更新图像"or"新增图像"
        $type['num'] = "";//新增图像时限定的图像总数
        $sql = "select * from device where id = '$id' ";//查询图片的数据库代码
        $column = "ico";//保存图片的数据库列的名称
        $suiji = suiji();
        $Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
        $Url['NewImgUrl'] = "img/deviceIco/{$suiji}.jpg";//新图片保存的网站根目录位置
        $NewImgSql = "update device set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where id = '$id' ";//保存图片的数据库代码
        $ImgWarn = "设备列表图片更新成功";//图片保存成功后返回的文字内容
        UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
    }
    /*------------------设备管理-上传设备详情图片---------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['adDeviceMxIcoUpload']) and isset($_POST['adDeviceMxId'])){
    //赋值
    $id = $_POST['adDeviceMxId'];
    $device = query("device"," id = '$id' ");
    //判断并执行
    if(empty($id)){
        $_SESSION['warn'] = "请先提交设备基本参数";
    }elseif($device['id'] != $id){
        $_SESSION['warn'] = "未找到本设备";
    }else{
        $FileName = "adDeviceMxIcoUpload";//上传图片的表单文件域input名称
        $cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
        $cut['width'] = 1000;//裁剪宽度
        $cut['height'] = 800;//裁剪高度
        $cut['NewWidth'] = "";//缩放的宽度
        $cut['MaxHeight'] = "";//缩放后图片的最大高度
        $type['name'] = "新增图像";//"更新图像"or"新增图像"
        $type['num'] = 4;//新增图像时限定的图像总数
        $sql = " select * from deviceImg where deviceId = '$id' ";//查询图片的数据库代码
        $column = "src";//保存图片的数据库列的名称
        $suiji = suiji();
        $Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
        $Url['NewImgUrl'] = "img/deviceImg/{$suiji}.jpg";//新图片保存的网站根目录位置
        $NewImgSql = " insert into deviceImg (id,deviceId,src,time) values ('$suiji','$id','$Url[NewImgUrl]','$time') ";//保存图片的数据库代码
        $ImgWarn = "设备详情图片更新成功";//图片保存成功后返回的文字内容
        UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
    }
    /*------------------删除设备详情图片----------------------------------------------------------------------------------------------------------------------*/
}elseif(!empty($_GET['deviceImgDelete'])) {
    $id = $_GET['deviceImgDelete']; //摆位图id
    $deviceImg = query("deviceImg", " id = '$id' ");
    unlink(ServerRoot . $deviceImg['src']);
    mysql_query("delete from deviceImg where id = '$id'");
    $_SESSION['warn'] = "设备详情图片删除成功";
    /*-----------------举报管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif( isset($_POST['SearchReportType']) ){
    //赋值
    $type = $_POST['SearchReportType'];//劳务类型
    $x = " where 1=1 ";
    //串联查询语句
    if(!empty($type)){
        $x .= " and type like '%$type%' ";
    }
    //返回
    $_SESSION['adReport'] = array(
        "type" => $type,"Sql" => $x);
}
/*-----------------跳转回刚才的页面---------------------------------------------------------------------*/
header("Location:".getenv("HTTP_REFERER"));
?>