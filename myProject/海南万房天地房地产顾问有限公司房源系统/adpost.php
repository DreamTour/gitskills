<?php
include "adfunction.php";
ControlRoot();
foreach($_POST as $key => $value){
    $post[$key] = FormSubArray($value);
}
/****************客户管理-多条件模糊查询*****************************/
if($_GET['type'] == "selectClient") {
    //赋值
    $type = $post['type'];//客户性质
    $contactName = $post['contactName'];//联系人姓名
    $contactTel = $post['contactTel'];//联系人手机
    $clientStatus = $post['clientStatus'];//客户状态
    $intentionArea = $post['intentionArea'];//意向区域
    $fromArea = $post['fromArea'];//来自区域
    $clientLevel = $post['clientLevel'];//客户等级
    $clientType = $post['clientType'];//客户类型
    $clientSourceOne = $post['clientSourceOne'];//来电方式
    $adname = $post['adname'];//销售员
    $callTimeStart = $post['callTimeStart'];//来电开始时间
    $callTimeEnd = $post['callTimeEnd'];//来电结束时间
    //查询
    if (!empty($type)) {
        $x .= " AND type = '$type' ";
    }
    if (!empty($contactName)) {
        $x .= " AND contactName LIKE '%$contactName%' ";
    }
    if (!empty($contactTel)) {
        $x .= " AND contactTel LIKE '%$contactTel%' ";
    }
    if (!empty($clientStatus)) {
        $x .= " AND clientStatus LIKE '%$clientStatus%' ";
    }
    if (!empty($intentionArea)) {
        $x .= " AND intentionArea = '$intentionArea' ";
    }
    if (!empty($fromArea)) {
        $x .= " AND fromArea = '$fromArea' ";
    }
    if (!empty($clientLevel)) {
        $x .= " AND clientLevel = '$clientLevel' ";
    }
    if (!empty($clientType)) {
        $x .= " AND clientType = '$clientType' ";
    }
    if (!empty($clientSourceOne)) {
        $x .= " AND clientSourceOne = '$clientSourceOne' ";
    }
    if (!empty($adname)) {
        $x .= " AND adid in ((SELECT adid FROM admin WHERE adid = '$adname') ) ";
    }
    if (!empty($callTimeStart)) {
        $x .= " AND callTime >= '$callTimeStart%' ";
    }
    if (!empty($callTimeEnd)) {
        $x .= " AND callTime <= '$callTimeEnd%' ";
    }
    //返回
    $_SESSION['adClient'] = array(
        "type" => $type,
        "contactName" => $contactName,
        "contactTel" => $contactTel,
        "clientStatus" => $clientStatus,
        "intentionArea" => $intentionArea,
        "fromArea" => $fromArea,
        "clientLevel" => $clientLevel,
        "clientType" => $clientType,
        "clientSourceOne" => $clientSourceOne,
        "adname" => $adname,
        "callTimeStart" => $callTimeStart,
        "callTimeEnd" => $callTimeEnd,
        "Sql" => $x);
    /****************数据统计-多条件模糊查询*****************************/
}else if($_GET['type'] == "adStatistics"){
        //赋值
        $planName = $post['planName'];//客户性质
        $ContactName = $post['ContactName'];//联系人姓名
        $ContactTel = $post['ContactTel'];//联系人手机
        $text = $post['text'];//简要说明
        //查询
        if(!empty($planName)){
            $x .= " AND planName LIKE '%$planName%' ";
        }
        if(!empty($ContactName)){
            $x .= " AND ContactName LIKE '%$ContactName%' ";
        }
        if(!empty($ContactTel)){
            $x .= " AND ContactTel LIKE '%$ContactTel%' ";
        }
        if(!empty($text)){
            $x .= " AND text LIKE '%$text%' ";
        }

        //返回
        $_SESSION['adStatistics'] = array(
            "planName" => $planName,
            "ContactName" => $ContactName,
            "ContactTel" => $ContactTel,
            "text" => $text,
            "Sql" => $x);
    /****************数据统计-后台列表-多条件模糊查询*****************************/
}else if($_GET['type'] == "adStatisticsBack"){
    //赋值
    $name = $post['adName'];//后台名称
    $x = " WHERE 1=1 ";
    //查询
    if(!empty($name)){
        $x .= " AND name LIKE '%$name%' ";
    }
    //返回
    $_SESSION['adStatisticsBack'] = array(
        "name" => $name,
        "Sql" => $x);
    /*************客户管理-删除成交记录***************************/
}elseif(isset($_GET['deleteKehuClinch'])) {
    //赋值
    $id = $_GET['deleteKehuClinch'];
    $n = mysql_num_rows(mysql_query(" SELECT * FROM kehuClinch WHERE id = '$id' "));
    //判断
    if (empty($id)) {
        $_SESSION['warn'] = "成交记录id号为空";
    } elseif ($n == 0) {
        $_SESSION['warn'] = "未找到本条成交记录";
  /*  } elseif ($adDuty['name'] != "超级管理员") {
        $_SESSION['warn'] = "只有超级管理员才能删除成交记录";*/
    } else {
        $bool = mysql_query(" DELETE FROM kehuClinch WHERE id = '$id' ");
        if ($bool) {
            $_SESSION['warn'] = "删除成功";
        } else {
            $_SESSION['warn'] = "删除失败";
        }
    }
    /*************客户管理-删除回访记录***************************/
}elseif(isset($_GET['DeleteClientFollow'])) {
    //赋值
    $id = $_GET['DeleteClientFollow'];
    $n = mysql_num_rows(mysql_query(" SELECT * FROM kehuFollow WHERE id = '$id' "));
    //判断
    if (empty($id)) {
        $_SESSION['warn'] = "回访记录id号为空";
    } elseif ($n == 0) {
        $_SESSION['warn'] = "未找到本条回访记录";
    /*} elseif ($adDuty['name'] != "超级管理员") {
        $_SESSION['warn'] = "只有超级管理员才能删除回访记录";*/
    } else {
        $bool = mysql_query(" DELETE FROM kehuFollow WHERE id = '$id' ");
        if ($bool) {
            $_SESSION['warn'] = "删除成功";
        } else {
            $_SESSION['warn'] = "删除失败";
        }
    }
    /*************数据统计-后台列表-删除后台花费***************************/
}elseif(isset($_GET['DeleteBackSpend'])) {
    //赋值
    $id = $_GET['DeleteBackSpend'];
    $n = mysql_num_rows(mysql_query(" SELECT * FROM backSpend WHERE id = '$id' "));
    //判断
    if (empty($id)) {
        $_SESSION['warn'] = "后台花费id号为空";
    } elseif ($n == 0) {
        $_SESSION['warn'] = "未找到本条后台花费";
   /* } elseif ($adDuty['name'] != "超级管理员") {
        $_SESSION['warn'] = "只有超级管理员才能删除后台花费";*/
    } else {
        $bool = mysql_query(" DELETE FROM backSpend WHERE id = '$id' ");
        if ($bool) {
            $_SESSION['warn'] = "删除成功";
        } else {
            $_SESSION['warn'] = "删除失败";
        }
    }
}
/****************跳转回刚才的页面*****************************/
header("Location:".getenv("HTTP_REFERER"));
?>