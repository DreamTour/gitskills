<?php
include "adfunction.php";
foreach($_POST as $key => $value){
    $post[$key] = FormSubArray($value);
}
if($ControlFinger == 2){
    $json['warn'] = $ControlWarn;
    /*-----------------客户管理-新建或更新客户基本资料-------------------------------------------------------------*/
}else if($_GET['type'] == "adClientMx" ) {
    $id = $post['adClientId'];   //客户ID
    $accountNumber = $post['accountNumber'];   //登录帐号
    $companyName = $post['companyName']; //公司名称
    $regionId = $post['area']; //所属区域
    $addressMx = $post['addressMx']; //详细地址
    $contactName = $post['contactName']; //联系人姓名
    $contactTel = $post['contactTel']; //联系人手机号码
    $khpas = $post['khpas']; //登录密码
    if (strstr($adDuty['Power'], "客户管理") == false) {
        $json['warn'] = "权限不足";
    } elseif (empty($accountNumber)) {
        $json['warn'] = "请填写登录帐号";
    }else if(mysql_num_rows(mysql_query("select * from kehu where accountNumber = '$accountNumber' ")) > 0){
        $json['warn'] = "本登录帐号已经有了";
    } elseif (empty($companyName)) {
        $json['warn'] = "请填写公司名称";
    }else if(mysql_num_rows(mysql_query("select * from kehu where companyName = '$companyName' ")) > 0){
        $json['warn'] = "本公司已经有了";
    } elseif (empty($regionId)) {
        $json['warn'] = "请选择所属区域";
    } elseif (empty($addressMx)) {
        $json['warn'] = "请填写详细地址";
    } elseif (empty($contactName)) {
        $json['warn'] = "请填写联系人姓名";
    } elseif (empty($contactTel)) {
        $json['warn'] = "请填写联系人手机号码";
    }else if(preg_match($CheckTel,$contactTel) == 0){
        $json['warn'] = "联系人手机号码格式有误";
    } elseif (empty($khpas)) {
        $json['warn'] = "请填写登录密码";
    } elseif (empty($id)) {
        $id = suiji();
        $bool = mysql_query("insert into kehu
                (khid,accountNumber,companyName,regionId,addressMx,contactName,contactTel,khpas,updateTime,time)
                values
                ('$id','$accountNumber','$companyName',$regionId,'$addressMx','$contactName','$contactTel','$khpas','$time','$time') ");
        if ($bool) {
            $_SESSION['warn'] = "客户基本资料新增成功";
            LogText("客户管理", $Control['adid'], "管理员{$Control['adname']}新增了客户（登陆帐号：{$accountNumber}，联系人姓名：{$contactName}）");
            $json['warn'] = 2;
        } else {
            $json['warn'] = "客户基本资料新增失败";
        }
    } else {
        $client = query("kehu", " khid = '$id' ");
        if ($client['khid'] != $id) {
            $json['warn'] = "本客户未找到";
        } else {
            $bool = mysql_query(" update kehu set
                        accountNumber = '$accountNumber',
                        companyName = '$companyName',
                        regionId = '$regionId',
                        addressMx = '$addressMx',
                        contactName = '$contactName',
                        contactTel = '$contactTel',
                        khpas = '$khpas',
                        updateTime = '$time' where khid = '$id' ");
            if ($bool) {
                $_SESSION['warn'] = "客户基本资料更新成功";
                LogText("客户管理", $Control['adid'], "管理员{$Control['adname']}更新了客户基本信息（登陆帐号：{$accountNumber}，联系人姓名：{$contactName}）");
                $json['warn'] = 2;
            } else {
                $json['warn'] = "客户基本资料更新失败";
            }
        }
    }
	 $json['href'] = root."control/adClientMx.php?id=".$id;
    /*-----------------摆位图-新建或更新系统基本资料-------------------------------------------------------------*/
}else if($_GET['type'] == "adSystemMx" ) {
    $id = $post['adSystemId'];   //系统ID
    $name = $post['name'];   //系统名称
    $abbreviation = $post['abbreviation'];   //系统名称
    if (strstr($adDuty['Power'], "摆位图") == false) {
        $json['warn'] = "权限不足";
    } elseif (empty($name)) {
        $json['warn'] = "请填写系统名称";
    } elseif (empty($id)) {
        $id = suiji();
        $bool = mysql_query("insert into system
                (id,name,abbreviation,updateTime,time)
                values
                ('$id','$name','$abbreviation','$time','$time') ");
        if ($bool) {
            $_SESSION['warn'] = "系统基本资料新增成功";
            LogText("摆位图", $Control['adid'], "管理员{$Control['adname']}新增了系统（系统名称：{$name}，系统ID：{$id}）");
            $json['warn'] = 2;
        } else {
            $json['warn'] = "系统基本资料新增失败";
        }
    } else {
        $system = query("system", " id = '$id' ");
        if ($system['id'] != $id) {
            $json['warn'] = "本系统未找到";
        } else {
            $bool = mysql_query(" update system set
                        name = '$name',
                        abbreviation = '$abbreviation',
                        updateTime = '$time' where id = '$id' ");
            if ($bool) {
                $_SESSION['warn'] = "系统基本资料更新成功";
                LogText("摆位图", $Control['adid'], "管理员{$Control['adname']}更新了系统基本信息（系统名称：{$name}，系统ID：{$id}）");
                $json['warn'] = 2;
            } else {
                $json['warn'] = "系统基本资料更新失败";
            }
        }
    }
	 $json['href'] = root."control/adSystemMx.php?id=".$id;
    /*-----------------设备管理-新建或更新设备基本资料-------------------------------------------------------------*/
}else if($_GET['type'] == "adDeviceMx" ) {
    $id = $post['adDeviceId'];   //设备id
    $khid = $post['clientId']; //客户id
    $name = $post['name'];   //名称
    $model = $post['model'];   //型号
    $brand = $post['brand'];   //品牌
    $type = $post['type'];   //系统类别
    $num = $post['num'];   //数量
    $unit = $post['unit'];   //单位
    $installSeat = $post['installSeat'];   //安装位置
    $installTime = $post['installYear']."-".$post['installMoon']."-".$post['installDay']; //安装时间
    $LastServiceTime = $post['LastServiceYear']."-".$post['LastServiceMoon']."-".$post['LastServiceDay']; //上次维修时间
    $installYear = $post['installYear'];  //安装时间
    $installMoon = $post['installMoon'];  //安装时间
    $installDay = $post['installDay'];    //安装时间
    $LastServiceYear = $post['LastServiceYear'];    //上次维修时间
    $LastServiceMoon = $post['LastServiceMoon'];    //上次维修时间
    $LastServiceDay = $post['LastServiceDay'];  //上次维修时间
    $serviceNum = $post['serviceNum'];   //维修次数
    $inSecurity = $post['inSecurity'];   //在保
    $parameter = $post['parameter']; //设备参数
    $contactNumber = $post['contactNumber'];   //客户帐号
    if (strstr($adDuty['Power'], "设备管理") == false) {
        $json['warn'] = "权限不足";
    } elseif (empty($name)) {
        $json['warn'] = "请填写名称";
    } elseif (empty($model)) {
        $json['warn'] = "请填写型号";
    } elseif (empty($brand)) {
        $json['warn'] = "请填写品牌";
    } elseif (empty($type)) {
        $json['warn'] = "请选择系统类别";
    } elseif (empty($num)) {
        $json['warn'] = "请填写数量";
    } elseif (empty($unit)) {
        $json['warn'] = "请填写单位";
    } elseif (empty($installSeat)) {
        $json['warn'] = "请填写安装位置";
    } elseif (empty($installYear) or empty($installMoon) or empty($installDay)) {
        $json['warn'] = "请选择安装时间";
    } elseif ((!empty($LastServiceYear) or !empty($LastServiceMoon) or !empty($LastServiceDay)) and ($LastServiceTime < $installTime)) {
        $json['warn'] = "上次维修时间不能小于安装时间";
    } elseif ($serviceNum == '') {
        $json['warn'] = "请填写维修次数";
    } elseif (empty($inSecurity)) {
        $json['warn'] = "请选择是否在保";
    } elseif (empty($parameter)) {
        $json['warn'] = "请填写设备参数";
        /*} elseif (empty($contactNumber)) {
            $json['warn'] = "请选择或填写客户帐号";
       /*} elseif (empty($startYear) or empty($startMoon) or empty($startDay)) {
            $json['warn'] = "请选择合同生效服务期限开始";
        } elseif (empty($endYear) or empty($endMoon) or empty($endDay)) {
            $json['warn'] = "请选择合同生效服务期限结束";
        } elseif ($endTime <= $startTime) {
            $json['warn'] = "合同生效服务期限结束时间应该比开始时间大";*/
    } elseif (empty($id)) {
        $identifyIdSql  = mysql_fetch_assoc(mysql_query("SELECT identifyId FROM device WHERE type = '$type' ORDER BY identifyId DESC"));//查询最大的设备查询ID
        $system = query("system", "id = '$type' ");//查询系统 
        if (empty($identifyIdSql['identifyId'])) {
			$identifyIdNum = 1;
		}
		else {
			$identifyIdNum = substr($identifyIdSql['identifyId'], 2, 5);
			$identifyIdNum++;
		}
        $identifyId = $system['abbreviation'].sprintf("%05d",$identifyIdNum);//拼接设备查询ID
        $id = suiji();
        $bool = mysql_query("insert into device
                (id, khid, identifyId, name, model, brand, type, num, unit, installSeat, installTime, LastServiceTime, serviceNum, inSecurity, parameter, contactNumber, updateTime, time)
                values
                ('$id','$khid','$identifyId','$name','$model','$brand','$type','$num','$unit','$installSeat','$installTime','$LastServiceTime','$serviceNum','$inSecurity','$parameter','$contactNumber','$time','$time') ");
        if ($bool) {
            $_SESSION['warn'] = "设备基本资料新增成功";
            LogText("设备管理", $Control['adid'], "管理员{$Control['adname']}新增了设备（设备名称：{$name}，设备ID：{$id}）");
            $json['warn'] = 2;
        } else {
            $json['warn'] = "设备基本资料新增失败";
        }
    } else {
        $device = query("device", " id = '$id' ");
        if ($device['id'] != $id) {
            $json['warn'] = "本设备未找到";
        } else {
            $bool = mysql_query(" update device set
                        name = '$name',
                        model = '$model',
                        brand = '$brand',
                        type = '$type',
                        num = '$num',
                        unit = '$unit',
                        installSeat = '$installSeat',
                        installTime = '$installTime',
                        LastServiceTime = '$LastServiceTime',
                        serviceNum = '$serviceNum',
                        inSecurity = '$inSecurity',
                        parameter = '$parameter',
                        contactNumber = '$contactNumber',
                        updateTime = '$time' where id = '$id' ");
            if ($bool) {
                $_SESSION['warn'] = "设备基本资料更新成功";
                LogText("设备管理", $Control['adid'], "管理员{$Control['adname']}更新了设备基本信息（设备名称：{$name}，设备ID：{$id}）");
                $json['warn'] = 2;
            } else {
                $json['warn'] = "设备基本资料更新失败";
            }
        }
    }
	 $json['href'] = root."control/adDeviceMx.php?id=".$id."&clientId=".$khid;
    /*-----------------设备报修-新建或更新报修基本资料-------------------------------------------------------------*/
}else if($_GET['type'] == "adRepairMx" ) {
    $id = $post['adDeviceId'];   //设备报修id
    $khid = $post['clientId'];   //客户id
    $repairTime = $post['repairYear']."-".$post['repairMoon']."-".$post['repairDay']; //报修时间
    $repairYear = $post['repairYear'];  //报修时间
    $repairMoon = $post['repairMoon'];  //报修时间
    $repairDay = $post['repairDay'];    //报修时间
    $type = $post['type'];   //系统类别
    $status = $post['status'];   //状态
    $repairText = $post['repairText']; //故障描述
    $contactName = $post['contactName'];   //报案人
    $contactTel = $post['contactTel'];   //联系方式
    $contactNumber = $post['contactNumber'];   //客户帐号
    if (strstr($adDuty['Power'], "设备管理") == false) {
        $json['warn'] = "权限不足";
   /* } elseif (empty($repairYear) or empty($repairMoon) or empty($repairDay)) {
        $json['warn'] = "请选择报修时间";*/
    } elseif (empty($type)) {
        $json['warn'] = "请选择系统类别";
    } elseif (empty($contactName)) {
        $json['warn'] = "请填写报案人";
    } elseif (empty($contactTel)) {
        $json['warn'] = "请填写联系方式";
    }else if(preg_match($CheckTel,$contactTel) == 0){
        $json['warn'] = "联系方式电话格式有误";
    } elseif (empty($repairText)) {
        $json['warn'] = "请填写故障描述";
    /*} elseif (empty($contactNumber)) {
        $json['warn'] = "请选择或填写客户帐号";*/
    } elseif (empty($id)) {
        $id = suiji();
        $listSql = query("repair", "1=1 ORDER BY list DESC");
        $list = $listSql['list'] + 1;
        $bool = mysql_query("INSERT INTO repair
                (id, khid, list, repairTime, type, status, repairText,  contactName, contactTel, contactNumber, updateTime, time)
                VALUES
                ('$id', '$khid', '$list', '$repairTime', '$type', '$status' ,'$repairText', '$contactName', '$contactTel', '$contactNumber', '$time', '$time') ");
        if ($bool) {
            $_SESSION['warn'] = "设备报修基本资料新增成功";
            LogText("设备管理", $Control['adid'], "管理员{$Control['adname']}新增了设备报修（设备报修名称：{$name}，设备报修ID：{$id}）");
            $json['warn'] = 2;
        } else {
            $json['warn'] = "设备报修基本资料新增失败";
        }
    } else {
        $repair = query("repair", " id = '$id' ");
        if ($repair['id'] != $id) {
            $json['warn'] = "本设备报修未找到";
        } else {
            $bool = mysql_query(" update repair set
                        repairTime = '$repairTime',
                        type = '$type',
                        status= '$status',
                        repairText = '$repairText',
                        contactName = '$contactName',
                        contactTel = '$contactTel',
                        contactNumber = '$contactNumber',
                        updateTime = '$time' where id = '$id' ");
            if ($bool) {
                $_SESSION['warn'] = "设备报修基本资料更新成功";
                LogText("设备管理", $Control['adid'], "管理员{$Control['adname']}更新了设备报修基本信息（设备报修名称：{$name}，设备报修ID：{$id}）");
                $json['warn'] = 2;
            } else {
                $json['warn'] = "设备报修基本资料更新失败";
            }
        }
    }
	 $json['href'] = root."control/adClientRepairMx.php?id=".$id."&clientId=".$khid;
    /*-----------------维修反馈-新建或更新维修设备基本资料-------------------------------------------------------------*/
}else if($_GET['type'] == "adAfterSaleMx" ) {
    $id = $post['adServiceId'];   //维修设备id
    $khid = $post['clientId'];   //客户id
    $serviceText = $post['serviceText']; //维修说明
    $identifyId = $post['identifyId'];  //设备识别ID
    $manner = $post['manner'];   //选择方式
    $serviceName = $post['serviceName'];   //维修人
    $status = $post['status']; //状态
    $contactNumber = $post['contactNumber']; //联系人账号
    if (strstr($adDuty['Power'], "设备管理") == false) {
        $json['warn'] = "权限不足";
    } elseif (empty($serviceText)) {
        $json['warn'] = "请填写维修说明";
    } elseif (empty($identifyId)) {
        $json['warn'] = "请填写设备识别ID";
    } elseif (empty($manner)) {
        $json['warn'] = "请选择方式";
    } elseif (empty($serviceName)) {
        $json['warn'] = "请填写维修人";
    } elseif (empty($status)) {
        $json['warn'] = "请选择状态";
    /*} elseif (empty($contactNumber)) {
        $json['warn'] = "请填写联系人账号";*/
    } elseif (empty($id)) {
        $id = suiji();
        $bool = mysql_query("insert into service
                (id, khid, serviceText, identifyId, manner, serviceName, status, contactNumber, updateTime, time)
                values
                ('$id','$khid','$serviceText','$identifyId','$manner','$serviceName','$status','$contactNumber','$time','$time') ");
        if ($bool) {
            $_SESSION['warn'] = "维修设备基本资料新增成功";
            LogText("售后管理", $Control['adid'], "管理员{$Control['adname']}新增了维修设备（设备报修名称：{$name}，维修设备ID：{$id}）");
            $json['warn'] = 2;
        } else {
            $json['warn'] = "维修设备基本资料新增失败";
        }
    } else {
        $service = query("service", " id = '$id' ");
        if ($service['id'] != $id) {
            $json['warn'] = "本维修设备未找到";
        } else {
            $bool = mysql_query(" update service set
                        serviceText = '$serviceText',
                        identifyId = '$identifyId',
                        manner = '$manner',
                        serviceName = '$serviceName',
                        status = '$status',
                        contactNumber = '$contactNumber',
                        updateTime = '$time' where id = '$id' ");
            if ($bool) {
                $_SESSION['warn'] = "维修设备基本资料更新成功";
                LogText("售后管理", $Control['adid'], "管理员{$Control['adname']}更新了设备报修基本信息（设备报修名称：{$name}，设备报修ID：{$id}）");
                $json['warn'] = 2;
            } else {
                $json['warn'] = "维修设备基本资料更新失败";
            }
        }
    }
	 $json['href'] = root."control/adClientAfterSaleMx.php?id=".$id."&clientId=".$khid;
    /*-----------------客户预约-反馈------------------------------------------------------------*/
}else if($_GET['type'] == "adBespeakMx" ) {
    $id = $post['adBespeakId']; //客户预约ID号
    $feedbackText = $post['feedbackText']; //反馈说明
    if (strstr($adDuty['Power'], "客户预约") == false) {
        $json['warn'] = "权限不足";
    } elseif (empty($feedbackText)) {
        $json['warn'] = "请填写反馈说明";
    } else {
        $bespeak = query("bespeak", " id = '$id' ");
        if ($bespeak['id'] != $id) {
            $json['warn'] = "本客户预约未找到";
        } else {
            $bool = mysql_query(" update bespeak set
                        feedbackText = '$feedbackText',
                        isFeedback = '是',
                        updateTime = '$time' where id = '$id' ");
            if ($bool) {
                $_SESSION['warn'] = "客户预约反馈成功";
                LogText("设备管理", $Control['adid'], "管理员{$Control['adname']}反馈了客户预约（联系人：{$bespeak['contactName']}，ID：{$id}）");
                $json['warn'] = 2;
            } else {
                $json['warn'] = "客户预约反馈失败";
            }
        }
    }
	 $json['href'] = root."control/adBespeakMx.php?id=".$id;
    /*-----------------客户投诉-反馈------------------------------------------------------------*/
}else if($_GET['type'] == "adComplainMx" ) {
    $id = $post['adComplainId']; //客户投诉ID号
    $feedbackText = $post['feedbackText']; //反馈说明
    if (strstr($adDuty['Power'], "客户投诉") == false) {
        $json['warn'] = "权限不足";
    } elseif (empty($feedbackText)) {
        $json['warn'] = "请填写反馈说明";
    } else {
        $complain = query("complain", " id = '$id' ");
        if ($complain['id'] != $id) {
            $json['warn'] = "本客户投诉未找到";
        } else {
            $bool = mysql_query(" update complain set
                        feedbackText = '$feedbackText'
                         where id = '$id' ");
            if ($bool) {
                $_SESSION['warn'] = "客户投诉反馈成功";
                LogText("设备管理", $Control['adid'], "管理员{$Control['adname']}反馈了客户投诉（ID：{$id}）");
                $json['warn'] = 2;
            } else {
                $json['warn'] = "客户投诉反馈失败";
            }
        }
    }
    $json['href'] = root."control/adComplainMx.php?id=".$id;
    /*-----------------摆位图-新建或更新摆位图热点-------------------------------------------------------------*/
}else if($_GET['type'] == 'adSystemImg') {
    $systemId = $post['systemId']; //系统ID
    $systemImgId = $post['imgId'];   //摆位图ID
    $deviceId = $post['deviceId'];   //设备ID
    $width = $post['width']; //宽度
    $height = $post['height']; //高度
    $xAxis = $post['x-axis']; //横坐标
    $yAxis = $post['y-axis']; //纵坐标
    $systemImg = query("systemImg", "id = '$id' "); //摆位图
    /*$json['warn'] = $systemId."----".$systemImgId."-----".$deviceId."----".$width."----".$height."----".$xAxis."----".$yAxis;*/
    if (strstr($adDuty['Power'], "摆位图") == false) {
        $json['warn'] = "权限不足";
    } elseif (empty($width)) {
        $json['warn'] = "请填写宽度";
    } elseif (empty($height)) {
        $json['warn'] = "请填写高度";
    } elseif (empty($xAxis)) {
        $json['warn'] = "请填写横坐标";
    } elseif (empty($yAxis)) {
        $json['warn'] = "请填写纵坐标";
    } elseif (empty($deviceId)) {
        $json['warn'] = "请选择设备";
    } elseif (empty($id)) {
        $id = suiji();
        $bool = mysql_query("insert into systemImgSeat
                (id,systemId,systemImgId,deviceId,width,height,seatLeft,seatTop,time)
                values
                ('$id','$systemId','$systemImgId','$deviceId','$width','$height','$xAxis','$yAxis','$time') ");
        if ($bool) {
            $_SESSION['warn'] = "摆位图热点新增成功";
            LogText("摆位图", $Control['adid'], "管理员{$Control['adname']}新增了热点（热点宽度：{$width}，热点高度：{$height}）");
            $json['warn'] = 2;
        } else {
            $json['warn'] = "摆位图热点新增失败";
        }
    }
    $json['href'] = root."control/adSystemImg.php?imgId=".$systemImgId."&systemId=".$systemId;
/*-----------------批量处理列表记录（需要管理员登录密码）--------------------------------*/
}elseif(isset($post['PadWarnType'])) {
    //赋值
    $type = $_POST['PadWarnType'];//执行指令
    $pas = $_POST['Password'];//密码
    $x = 0;
    //判断
    if (empty($type)) {
        $json['warn'] = "执行指令为空";
    } elseif (empty($pas)) {
        $json['warn'] = "请输入管理员登录密码";
    } elseif ($pas != $Control['adpas']) {
        $json['warn'] = "管理员登录密码输入错误";
    }
    //删除客户
    elseif ($type == "ClientDelete") {
        $Array = $_POST['ClientList'];
        if ($adDuty['name'] != "超级管理员") {
            $json['warn'] = "只有超级管理员才能删除客户";
        } elseif (empty($Array)) {
            $json['warn'] = "您一个客户都没有选择呢";
        } else {
            foreach ($Array as $id) {
                //查询本客户基本信息
                $kehu = query("kehu", " khid = '$id' ");
                //最后删除本客户基本资料
                mysql_query("delete from kehu where khid = '$id'");
                //添加日志
                LogText("客户管理", $Control['adid'], "管理员{$Control['adname']}删除了客户（客户姓名：{$kehu['ContactName']}，客户ID：{$kehu['khid']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个客户";
            $json['warn'] = 2;
        }
    }
    //删除系统
    elseif ($type == "SystemDelete") {
        $Array = $_POST['SystemList'];
        if ($adDuty['name'] != "超级管理员") {
            $json['warn'] = "只有超级管理员才能删除系统";
        } elseif (empty($Array)) {
            $json['warn'] = "您一个系统都没有选择呢";
        } else {
            foreach ($Array as $id) {
                //查询本条系统基本信息
                $system = query("system", " id = '$id' ");
                //删除本系统
                mysql_query("delete from system where id = '$id'");
                //添加日志
                LogText("系统管理", $Control['adid'], "管理员{$Control['adname']}删除了系统（系统名称：{$system['name']}，系统ID：{$system['id']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个系统";
            $json['warn'] = 2;
        }
    }
    //删除设备
    elseif ($type == "DeviceDelete") {
        $Array = $_POST['DeviceList'];
        if ($adDuty['name'] != "超级管理员") {
            $json['warn'] = "只有超级管理员才能删除设备";
        } elseif (empty($Array)) {
            $json['warn'] = "您一个设备都没有选择呢";
        } else {
            foreach ($Array as $id) {
                //查询本设备基本信息
                $device = query("device", " id = '$id' ");
                //删除本设备
                mysql_query("delete from device where id = '$id'");
                //添加日志
                LogText("设备管理", $Control['adid'], "管理员{$Control['adname']}删除了设备（设备名称：{$device['name']}，设备ID：{$device['id']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个设备";
            $json['warn'] = 2;
        }
    }
    //删除设备报修
    elseif ($type == "RepairDelete") {
        $Array = $_POST['RepairList'];
        if ($adDuty['name'] != "超级管理员") {
            $json['warn'] = "只有超级管理员才能删除设备报修";
        } elseif (empty($Array)) {
            $json['warn'] = "您一个设备报修都没有选择呢";
        } else {
            foreach ($Array as $id) {
                //查询本设备报修基本信息
                $repair = query("repair", " id = '$id' ");
                //删除本设备报修
                mysql_query("delete from repair where id = '$id'");
                //添加日志
                LogText("设备管理", $Control['adid'], "管理员{$Control['adname']}删除了设备报修（设备名称：{$device['name']}，设备报修ID：{$device['id']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个设备报修";
            $json['warn'] = 2;
        }
    }
    //删除售后设备
    elseif ($type == "serviceDelete") {
        $Array = $_POST['serviceList'];
        if ($adDuty['name'] != "超级管理员") {
            $json['warn'] = "只有超级管理员才能删除售后设备";
        } elseif (empty($Array)) {
            $json['warn'] = "您一个售后设备都没有选择呢";
        } else {
            foreach ($Array as $id) {
                //查询本售后设备基本信息
                $service = query("service", " id = '$id' ");
                //删除本设备报修
                mysql_query("delete from service where id = '$id'");
                //添加日志
                LogText("售后管理", $Control['adid'], "管理员{$Control['adname']}删除了售后设备（设备名称：{$device['name']}，售后设备ID：{$device['id']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个售后设备";
            $json['warn'] = 2;
        }
    }
    else {
        $json['warn'] = "未知执行指令";
    }
    /********客户管理-分配内勤**************************************/
}elseif($_GET['type'] == "clientInterShadeForm"){
        $clientIdArray = $post['ClientList']; //客户的ID号数组
        $adid = $post['taskAllotInter'];//分配给谁的ID号
        $admin = query("admin", "adid = '$adid' ");//被分配者的基本信息
        $pas = $post['taskPassword'];//管理员登录密码
        $direction = $post['direction'];//执行方向
        if ($adDuty['name'] != "超级管理员") {
            $json['warn'] = "你没有权限分配客户";
        }
        else if (empty($clientIdArray)) {
            $json['warn'] = "一条客户都没有选择";
        }
        else if (empty($adid)) {
            $json['warn'] = "请选择分配给谁";
        }
        else if ($adid != $admin['adid']) {
            $json['warn'] = "未找到被分配者";
        }
        else if (empty($pas)) {
            $json['warn'] = "请输入登录密码";
        }
        else if ($pas != $Control['adpas']) {
            $json['warn'] = "登录密码错误";
        }
        else if ($direction == "分配") {
            $x = 0;
            foreach ($clientIdArray as $id) {
                mysql_query("update kehu set
				adidInter = '$adid',
				updateTime = '$time' where khid = '$id' ");
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}分配了客户（客户ID：{$id}），被分配者：{$admin['adname']}");
                $x++;
            }
            $_SESSION['warn'] = "分配了".$x."个客户";
            $json['warn'] = 2;
        }
        else if ($direction == "撤销分配") {
            $x = 0;
            foreach ($taskIdArray as $id) {
                mysql_query("update kehu set
				adid = '',
				updateTime = '$time' where khid = '$id' ");
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}撤销了客户的负责人（客户ID：{$id}），被撤销者：{$admin['adname']}");
            }
            $_SESSION['warn'] = "撤销了".$x."个客户";
            $json['warn'] = 2;
        }
        else {
            $json['warn'] = "请选择执行方向";
        }
    /********客户管理-分配外勤**************************************/
}elseif($_GET['type'] == "clientOutShadeForm"){
    $clientIdArray = $post['ClientList']; //客户的ID号数组
    $adid = $post['taskAllotOut'];//分配给谁的ID号
    $admin = query("admin", "adid = '$adid' ");//被分配者的基本信息
    $pas = $post['taskPassword'];//管理员登录密码
    $direction = $post['direction'];//执行方向
    if ($adDuty['name'] != "超级管理员") {
        $json['warn'] = "你没有权限分配客户";
    }
    else if (empty($clientIdArray)) {
        $json['warn'] = "一条客户都没有选择";
    }
    else if (empty($adid)) {
        $json['warn'] = "请选择分配给谁";
    }
    else if ($adid != $admin['adid']) {
        $json['warn'] = "未找到被分配者";
    }
    else if (empty($pas)) {
        $json['warn'] = "请输入登录密码";
    }
    else if ($pas != $Control['adpas']) {
        $json['warn'] = "登录密码错误";
    }
    else if ($direction == "分配") {
        $x = 0;
        foreach ($clientIdArray as $id) {
            mysql_query("update kehu set
				adidOut = '$adid',
				updateTime = '$time' where khid = '$id' ");
            LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}分配了客户（客户ID：{$id}），被分配者：{$admin['adname']}");
            $x++;
        }
        $_SESSION['warn'] = "分配了".$x."个客户";
        $json['warn'] = 2;
    }
    else if ($direction == "撤销分配") {
        $x = 0;
        foreach ($taskIdArray as $id) {
            mysql_query("update kehu set
				adid = '',
				updateTime = '$time' where khid = '$id' ");
            LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}撤销了客户的负责人（客户ID：{$id}），被撤销者：{$admin['adname']}");
        }
        $_SESSION['warn'] = "撤销了".$x."个客户";
        $json['warn'] = 2;
    }
    else {
        $json['warn'] = "请选择执行方向";
    }
}
/*-----------------返回-------------------------------------------------------------*/
echo json_encode($json);
?>