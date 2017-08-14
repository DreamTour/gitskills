<?php
include "adfunction.php";
foreach($_POST as $key => $value){
    $post[$key] = FormSubArray($value);
}
/*************如下代码必须在登录的情况下才能执行，否则返回未登录提示***************************/
if($ControlFinger == 2){
    $json['warn'] = $ControlWarn;
}
/*******客户管理-新增或更新基本资料*************************************/
elseif($_GET['type'] == "clientEdit" ){
    //赋值
    $contactName = $post['contactName'];//联系人姓名
    $contactTel = $post['contactTel'];//联系人手机
    $wxQq = $post['wxQq'];//微信/QQ
    $intentionArea = $post['intentionArea'];//意向区域
    $fromArea = $post['fromProvince'];//来自区域
    $clientLevel = $post['clientLevel'];//客户等级
    $clientType = $post['clientType'];//客户类型
    $clientStatus = $post['clientStatus'];//客户状态
    $clientSourceOne = $post['clientSourceOne'];//客户来源一级分类
    $clientSourceTwo = $post['clientSourceTwo'];//客户来源二级分类
    $callTime = $post['callTime'];//来电时间
    $visitTime = $post['visitTime'];//回访时间
    $compareDate = substr($visitTime,0,10);//比较时间
    $returnVisit = $post['returnVisit'];//回访记录
    $look = $post['look'];//带看
    $id = $post['adClientId'];//客户ID
    $client = query("kehu", "khid = '$id' ");
    //判断
    /*if(!power("客户管理")){
        $json['warn'] = "权限不足";
    }else*/if(Repeat(" kehuMsg WHERE tel = '$contactTel' AND khid = '$id' ","id",$id)){
        $json['warn'] = "联系人手机号码重复";
    }elseif(empty($intentionArea)){
        $json['warn'] = "请选择意向区域";
    }elseif(empty($fromArea)){
        $json['warn'] = "请选择来自区域";
    }elseif(empty($clientLevel)){
        $json['warn'] = "请选择客户等级";
    }elseif(empty($clientType)){
        $json['warn'] = "请选择客户类型";
    }elseif(empty($clientSourceOne)){
        $json['warn'] = "请选择客户来源一级分类";
    }elseif(empty($clientSourceTwo)){
        $json['warn'] = "请选择客户来源二级分类";
    }elseif(empty($callTime)){
        $json['warn'] = "请选择来电时间";
    }elseif(empty($visitTime)){
        $json['warn'] = "请选择回访时间";
    /*}elseif(empty($returnVisit)){
        $json['warn'] = "请填写回访记录";*/
    }elseif(empty($id)){
        if(empty($contactName)){
            $json['warn'] = "请填写姓名";
        }elseif(empty($contactTel)){
            $json['warn'] = "请填写手机";
        }elseif(preg_match($CheckTel,$contactTel) == 0) {
            $json['warn'] = "手机号码格式有误";
        }elseif(empty($wxQq)) {
            $json['warn'] = "请填写微信/QQ";
        }else{
            $id = rand(1000000000,9999999999);
            while(mysql_num_rows(mysql_query(" SELECT khid FROM kehu WHERE khid = '$id' ")) > 0){
                $id = rand(1000000000,9999999999);
            }
            //判断状态
            if (empty($returnVisit)) {
                if ($date < $compareDate) {
                    $clientStatus = '待回访';
                    $sort = 3;
                } else if ($date == $compareDate) {
                    $clientStatus = '今日需回访';
                    $sort = 2;
                } else {
                    $clientStatus = '逾期未回访';
                    $sort = 1;
                }
            }
            else {
                $clientStatus = '今日已回访';
                $sort = 4;
            }
            //新增
            $bool = mysql_query(" INSERT INTO kehu
            (khid, adid, type, contactName, contactTel, wxQq, intentionArea, fromArea, clientLevel, clientType, clientStatus,sort,clientSourceOne,clientSourceTwo, callTime, visitTime, returnVisit,look, updateTime, time)
            VALUES
            ('$id', '$Control[adid]', '私客', '$contactName', '$contactTel', '$wxQq', '$intentionArea','$fromArea','$clientLevel','$clientType','$clientStatus','$sort','$clientSourceOne','$clientSourceTwo','$callTime','$visitTime','$returnVisit','$look', '$time', '$time')
            ");
            if($bool){
                //回访记录
                if (!empty($returnVisit)) {
                    $kehuFollowId = suiji();
                    mysql_query(" INSERT INTO kehuFollow
                (id, khid, adid, text,look, time)
                VALUES
                ('$kehuFollowId', '$id', '$Control[adid]','$returnVisit','$look', '$time')
                ");
                }
                //客户信息
                $kehuMsgId = suiji();
                mysql_query(" INSERT INTO kehuMsg
                (id, khid, name, tel,wxQq, time)
                VALUES
                ('$kehuMsgId', '$id', '$contactName','$contactTel','$wxQq', '$time')
                ");
                $json['warn'] = 2;
                $_SESSION['warn'] = "新增成功";
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}新增了客户基本信息（客户名称：{$contactName}，客户ID：{$id}）");
            }else{
                $json['warn'] = "新增失败";
            }
        }
    }else{
        if(!empty($contactTel)){
            if(preg_match($CheckTel,$contactTel) == 0) {
                $json['warn'] = "手机号码格式有误";
            }
        }
        $kehu = query("kehu"," khid = '$id' ");
        $clientIntention = $kehu['clientIntention'];
        if($kehu['khid'] != $id){
            $json['warn'] = "本客户未找到";
        }elseif($kehu['adid'] != $Control['adid'] ){
            $json['warn'] = "只有所属员工才能修改对应资料";
        }else{
            //回访记录
            if (!empty($returnVisit)) {
                $kehuFollowId = suiji();
                $insert = mysql_query(" INSERT INTO kehuFollow
                (id, khid, adid, text,look, time)
                VALUES
                ('$kehuFollowId', '$id', '$Control[adid]','$returnVisit','$look', '$time')
                ");
            }
            //客户信息
            if (!empty($contactName) or !empty($contactTel) or !empty($wxQq)) {
                $kehuMsgId = suiji();
                mysql_query(" INSERT INTO kehuMsg
                (id, khid, name, tel,wxQq, time)
                VALUES
                ('$kehuMsgId', '$id', '$contactName','$contactTel','$wxQq', '$time')
                ");
            }
            //判断状态
            if (empty($returnVisit)) {
                if ($clientIntention == '成交') {
                    if ($date < $compareDate) {
                        $clientStatus = '成交待回访';
                        $sort = 3;
                    } else if ($date == $compareDate) {
                        $clientStatus = '成交今日需回访';
                        $sort = 2;
                    } else {
                        $clientStatus = '成交逾期未回访';
                        $sort = 1;
                    }
                }
                else if ($clientIntention == '放弃') {
                    $clientStatus = '放弃';
                    $sort = 6;
                }
                else {
                    if ($date < $compareDate) {
                        $clientStatus = '待回访';
                        $sort = 3;
                    } else if ($date == $compareDate) {
                        $clientStatus = '今日需回访';
                        $sort = 2;
                    } else {
                        $clientStatus = '逾期未回访';
                        $sort = 1;
                    }
                }
            }
            else {
                $clientStatus = '今日已回访';
                $sort = 4;
            }
            //判断是否带看
            $client = query("kehu", "khid = '$id' ");
            if ($client['look'] == '带看') {
                $look = '带看';
            }
            //更新
            if (empty($contactName)) {
                $contactNameStr = "";
                $contactTelStr = "";
                $wxQqStr = "";
            }
            else {
                $contactNameStr = "contactName = '$contactName',";
                $contactTelStr = " contactTel = '$contactTel',";
                $wxQqStr = "  wxQq = '$wxQq',";
            }
            $bool = mysql_query(" UPDATE kehu SET
                {$contactNameStr}
                {$contactTelStr}
                {$wxQqStr}
                intentionArea = '$intentionArea',
                fromArea = '$fromArea',
                clientLevel = '$clientLevel',
                clientType = '$clientType',
                clientStatus = '$clientStatus',
                sort = '$sort',
                clientSourceOne = '$clientSourceOne',
                clientSourceTwo = '$clientSourceTwo',
                callTime = '$callTime',
                visitTime = '$visitTime',
                returnVisit = '$returnVisit',
                look = '$look',
                updateTime = '$time' WHERE khid = '$id' ");
            if($bool){
                $_SESSION['warn'] = "客户基本资料更新成功";
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了客户基本信息（客户名称：{$contactName}，客户ID：{$id}）");
                $json['warn'] = 2;
            }else{
                $json['warn'] = "客户基本资料更新失败";
            }
        }
    }
    $json['href'] = root."control/adClient.php?id=".$id;
}
/********客户管理-改变客户状态**************************************/
elseif($_GET['type'] == "changeStatus"){
    $clientSql = mysql_query("SELECT * FROM kehu order by time desc ");
    while($array = mysql_fetch_assoc($clientSql)) {
        if ($array['clientIntention'] == '成交') {
            if ($date < substr($array['visitTime'],0,10)) {
                $clientStatus = '成交待回访';
                $sort = 3;
            } else if ($date == substr($array['visitTime'],0,10)) {
                $clientStatus = '成交今日需回访';
                $sort = 2;
            } else {
                $clientStatus = '成交逾期未回访';
                $sort = 1;
            }
        }
        else if ($array['clientIntention'] == '放弃') {
            $clientStatus = '放弃';
            $sort = 6;
        }
        else {
            if ($date < substr($array['visitTime'],0,10)) {
                $clientStatus = '待回访';
                $sort = 3;
            } else if ($date == substr($array['visitTime'],0,10)) {
                $clientStatus = '今日需回访';
                $sort = 2;
            } else {
                $clientStatus = '逾期未回访';
                $sort = 1;
            }
        }
        mysql_query("UPDATE kehu SET clientStatus = '$clientStatus', sort = '$sort', updateTime = '$time' WHERE khid = '$array[khid]' ");
    }
}
/********客户管理-返回客户来源二级分类**************************************/
elseif($_GET['type'] == "clientSourceOne"){
    //赋值
    $clientSourceOne = $post['clientSourceOne'];
    switch($clientSourceOne) {
        case '来电':
            $json['warn'] = option("--二级选项--",explode("，",website('tgl73981646Da')),$kehu['clientSourceTwo']);
            break;
        case '商桥聊天':
            $json['warn'] = option("--二级选项--",explode("，",website('mkM74025300Co')),$kehu['clientSourceTwo']);
            break;
        case '商桥留言':
            $json['warn'] = option("--二级选项--",explode("，",website('OnI74025361gq')),$kehu['clientSourceTwo']);
            break;
        case '网站留言':
            $json['warn'] = option("--二级选项--",explode("，",website('TVG74025425OH')),$kehu['clientSourceTwo']);
            break;
        default:
            $json['warn'] = '<option>--二级选项--</option>';
    }
}
/*******数据统计-新增或更新基本资料*************************************/
elseif($_GET['type'] == "statistics" ){
    //赋值
    $id = $post['adStatisticsId'];//计划ID
    $planName = $post['planName'];//计划名称
    $planDateStart = $post['planDateStart'];//选择日期
    $planDateEnd = $post['planDateEnd'];//选择日期

    $backstage = $post['backstage'];//推广后台
    $backstage = implode(',', $backstage);

    $telegram = $post['telegram'];//来电
    $telegram = Stitching($telegram);

    $chat = $post['chat'];//商桥聊天
    $chat = Stitching($chat);

    $bridge = $post['bridge'];//商桥留言
    $bridge = Stitching($bridge);

    $website = $post['website'];//网站留言
    $website = Stitching($website);

    $area = $post['area'];//来电区域
    $area = Stitching($area);

    $telegramDan = $post['telegramDan'];//来电时间段

    $clientLevel = $post['clientLevel'];//客户级别
    $clientLevel = Stitching($clientLevel);

    $intention = $post['intention'];//意向区域
    $intention = Stitching($intention);

    $clientType = $post['clientType'];//客户类型
    $clientType = Stitching($clientType);

    $remark = $post['remark'];//备注
    //判断
    /*if(!power("客户管理")){
        $json['warn'] = "权限不足";
    }else*/if(empty($planName)) {
        $json['warn'] = "请填写计划名称";
    } else if (empty($planDateStart) || empty($planDateEnd)) {
        $json['warn'] = "请选择时间";
    }elseif(empty($id)){
        $id = rand(1000000000,9999999999);
        while(mysql_num_rows(mysql_query(" SELECT id FROM statistics WHERE id = '$id' ")) > 0){
            $id = rand(1000000000,9999999999);
        }
        $bool = mysql_query(" INSERT INTO statistics
            ( id, planName, planDateStart, planDateEnd, backstage, telegram, chat, bridge, website, area, telegramDan, clientLevel, intention, clientType, remark, updateTime, time )
            VALUES
            ( '$id', '$planName','$planDateStart', '$planDateEnd', '$backstage', '$telegram', '$chat', '$bridge', '$website', '$area', '$telegramDan', '$clientLevel', '$intention', '$clientType', '$remark', '$time', '$time' )
            ");
        if ($bool) {
            $json['warn'] = 2;
            $_SESSION['warn'] = "新增成功";
            LogText("客户管理", $Control['adid'], "管理员{$Control['adname']}新增了计划基本信息（计划名称：{$planName}，计划ID：{$id}）");
        } else {
            $json['warn'] = "新增失败";
        }
    }else{
        $statistics = query("statistics"," id = '$id' ");
        if($statistics['id'] != $id){
            $json['warn'] = "本计划未找到";
        /*}elseif($kehu['adid'] != $Control['adid'] ){
            $json['warn'] = "只有所属员工才能修改对应资料";*/
        }else{
            $bool = mysql_query(" UPDATE statistics SET
                planName = '$planName',
                planDateStart = '$planDateStart',
                planDateEnd = '$planDateEnd',
                backstage = '$backstage',
                telegram = '$telegram',
                chat = '$chat',
                bridge = '$bridge',
                website = '$website',
                area = '$area',
                telegramDan = '$telegramDan',
                clientLevel = '$clientLevel',
                intention = '$intention',
                clientType = '$clientType',
                remark = '$remark',
                updateTime = '$time' WHERE id = '$id' ");
            if($bool){
                $_SESSION['warn'] = "计划基本资料更新成功";
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了计划基本信息（计划名称：{$planName}，计划ID：{$id}）");
                $json['warn'] = 2;
            }else{
                $json['warn'] = "计划基本资料更新失败";
            }
        }
    }
    $json['href'] = root."control/adStatistics.php?id=".$id;
}
/*******数据统计-后台列表-新增或更新基本资料*************************************/
elseif($_GET['type'] == "adStatisticsBack" ){
    //赋值
    $id = $post['adStatisticsBackId'];//后台id
    $name = $post['name'];//后台名称
    $backDate = $post['backDate'];//选择日期
    $spend = $post['spend'];//花费
    //判断
    /*if(!power("客户管理")){
        $json['warn'] = "权限不足";
    }else*/if(empty($name)) {
        $json['warn'] = "请填写后台名称";
    } else if (empty($backDate)) {
        $json['warn'] = "请选择日期";
    }else if(empty($spend)) {
        $json['warn'] = "请填写后台花费";
    }elseif(empty($id)){
        $id = rand(1000000000,9999999999);
        while(mysql_num_rows(mysql_query(" SELECT id FROM backstage WHERE id = '$id' ")) > 0){
            $id = rand(1000000000,9999999999);
        }
        $bool = mysql_query(" INSERT INTO backstage
            ( id, name, backDate, spend, updateTime, time )
            VALUES
            ( '$id', '$name', '$backDate', '$spend', '$time', '$time' )
            ");
        if ($bool) {
            $backSpendId = suiji();
            mysql_query(" INSERT INTO backSpend
            (id, backId, date, spend, time)
            VALUES
            ('$backSpendId', '$id', '$backDate','$spend', '$time')
            ");
            $json['warn'] = 2;
            $_SESSION['warn'] = "新增成功";
            LogText("客户管理", $Control['adid'], "管理员{$Control['adname']}新增了后台基本信息（后台名称：{$name}，后台ID：{$id}）");
        } else {
            $json['warn'] = "新增失败";
        }
    }else{
        $backstage= query("backstage"," id = '$id' ");
        if($backstage['id'] != $id){
            $json['warn'] = "本后台未找到";
            /*}elseif($kehu['adid'] != $Control['adid'] ){
                $json['warn'] = "只有所属员工才能修改对应资料";*/
        }else{
            $bool = mysql_query(" UPDATE backstage SET
                name = '$name',
                backDate = '$backDate',
                spend = '$spend',
                updateTime = '$time' WHERE id = '$id' ");
            if($bool){
                $backSpendId = suiji();
                mysql_query(" INSERT INTO backSpend
                (id, backId, date, spend, time)
                VALUES
                ('$backSpendId', '$id', '$backDate','$spend', '$time')
                ");
                $_SESSION['warn'] = "后台基本资料更新成功";
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了后台基本信息（后台名称：{$name}，后台ID：{$id}）");
                $json['warn'] = 2;
            }else{
                $json['warn'] = "后台基本资料更新失败";
            }
        }
    }
    $json['href'] = root."control/adStatisticsBackMx.php?id=".$id;
}
/********客户管理-选择日期**************************************/
elseif($_GET['type'] == "chooseDate"){
    //赋值
    $clientId = $post['clientId'];//客户的id号
    $visitTime = $post['chooseDate'];//选择日期
    $compareDate = substr($visitTime,0,10);
    $client = query("kehu", "khid = '$clientId' ");
    //判断
    if(empty($clientId)){
        $json['warn'] = "没找到本客户";
    }elseif($client['khid'] != $clientId){
        $json['warn'] = "未知错误";
    }elseif(empty($visitTime)){
        $json['warn'] = "选择日期为空";
    }else{
        if ($client['clientIntention'] == '成交') {
            if ($date < $compareDate) {
                $clientStatus = '成交待回访';
            } else if ($date == $compareDate) {
                $clientStatus = '成交今日需回访';
            } else {
                $clientStatus = '成交逾期未回访';
            }
        } else {
            if ($date < $compareDate) {
                $clientStatus = '待回访';
            } else if ($date == $compareDate) {
                $clientStatus = '今日需回访';
            } else {
                $clientStatus = '逾期未回访';
            }
        }
        $bool = mysql_query(" UPDATE kehu SET
                clientStatus = '$clientStatus',
                visitTime = '$visitTime',
                updateTime = '$time' WHERE khid = '$clientId' ");
        if($bool){
            $_SESSION['warn'] = "更新成功";
            LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}选择了回访日期（日期：{$visitTime}，客户ID：{$clientId}）");
            $json['warn'] = 2;
        }else{
            $json['warn'] = "更新失败";
        }
    }
}
/********客户管理-批量分配客户**************************************/
elseif($_GET['type'] == "allotClient"){
    //赋值
    $ClientList = $post['ClientList'];//客户id号数组
    $adid = $post['adId'];//所属员工
    $admin = query("admin", " adid = '$adid' ");
    $Password = $post['Password'];//登录密码
    $staffClientNum = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE adid = '$adid' AND type = '私客' ")); //私客数量
    //判断
    /*if(!power("客户管理")){
        $json['warn'] = "权限不足";
    }else*/if($adDuty['name'] == '员工'){
        $json['warn'] = "您没有分配权限";
    }elseif(empty($ClientList)){
        $json['warn'] = "一个客户都没有选择";
    }elseif(empty($adid)){
        $json['warn'] = "没有选择所属员工";
    }elseif(empty($admin['adid'])){
        $json['warn'] = "未找到此员工";
    }elseif(count($ClientList) + $staffClientNum > $admin['clientNum'] ){
        $json['warn'] = "此员工的私客数量已达到上限";
    }elseif(empty($Password)){
        $json['warn'] = "登录密码为空";
    }elseif(MD5($Password) != $Control['adpas']){
        $json['warn'] = "登录密码错误";
    }else {
        $x = 0;
        foreach ($ClientList as $id) {
            $kehu = query("kehu", " khid = '$id' ");
            mysql_query(" UPDATE kehu SET
                type = '私客',
                adid = '$adid',
                UpdateTime = '$time' WHERE khid = '$id' ");
            LogText("客户管理", $Control['adid'], "管理员{$Control['adname']}把 {$kehu['contactName']}分配给了{$admin['adname']}");
            $x++;
        }
        $json['warn'] = 2;
        $_SESSION['warn'] = "管理员{$Control['adname']}为{$admin['adname']}新增了" . $x . "个客户";
    }
}
/************成交记录（需要管理员登录密码）********************************************/
elseif($get['type']=='addAssets'){
        //赋值
        $id = $post['clinchRecordId']; //成交记录id
        $clientId = $post['clientId'];//客户id
        $clinchTime = $post['clinchTime'];//时间
        $estateMsg = $post['estateMsg'];//楼盘信息
        $houseMoney = $post['houseMoney'];//房款
        $houseType = $post['houseType'];//佣金类型
        $points = $post['points'];//点数
        $concede = $post['concede'];//让利
        $concedeText = $post['concedeText'];//让利说明
        if ($houseType == '点数') {
            $houseCommission = $houseMoney * $points/100 - $concede;
        }
        else {
            $houseCommission = $post['houseCommission'];//佣金
        }
        $contact = $post['contact'];//联系方式
        $text = $post['text'];//备注
        $pas = $post['password'];//密码
        if(empty($clinchTime)){
            $json['warn'] = "请选择时间";
        }elseif(empty($estateMsg)){
            $json['warn'] = "请输入楼盘信息";
        }elseif(preg_match($CheckInteger,$meter) == 0){
            $json['warn'] = "平米是正整数";
        }elseif(empty($houseMoney)){
            $json['warn'] = "请输入房款";
        }elseif(preg_match($CheckInteger,$houseMoney) == 0){
            $json['warn'] = "房款是正整数";
        }elseif(empty($houseType)){
            $json['warn'] = "请选择佣金类型";
        }elseif(empty($concede)) {
            $json['warn'] = "请输入让利";
        }elseif(empty($concedeText)) {
            $json['warn'] = "请输入让利说明";
        }elseif(preg_match($CheckInteger,$concede) == 0){
            $json['warn'] = "让利是正整数";
        }elseif(empty($contact)){
            $json['warn'] = "请输入联系方式";
       /* }elseif(empty($text)){
            $json['warn'] = "请输入成交说明";*/
        }elseif(md5($pas) != $Control['adpas']){
            $json['warn'] = "管理员登录密码输入错误";
        }elseif(empty($id)) {
            $id = suiji();//id
            $bool = mysql_query("INSERT INTO kehuClinch
                (id, khid, adid, clinchTime, estateMsg, houseMoney, houseType,points, concede,concedeText, houseCommission, contact, text, look, time)
                VALUES
                ('$id', '$clientId', '$Control[adid]', '$clinchTime', '$estateMsg', '$houseMoney', '$houseType','$points', '$concede', '$concedeText', '$houseCommission','$contact', '$text', '$look', '$time')");
            if ($bool) {
                mysql_query("UPDATE kehu SET clientIntention = '成交',updateTime = '$time' WHERE khid = '$clientId' ");
                $json['warn'] = "2";
                $_SESSION['warn'] = '新增成功';
                $json['id'] = $id;
                LogText("客户管理", $Control['adid'], "管理员{$Control['adname']}新增了成交记录（成交楼盘：{$estate}，成交记录ID：{$id}）");
            } else {
                $json['warn'] = '新增失败';
            }
        }
}
/********客户管理-经理查看了某个员工的客户的联系的方式**************************************/
elseif($_GET['type'] == "contactTel"){
    //赋值
    $clientId = $post['clientId'];//客户的id号
    $client = query("kehu", "khid = '$clientId' ");
    //判断
    if(empty($clientId)){
        $json['warn'] = "没找到本客户";
    }elseif($client['khid'] != $clientId){
        $json['warn'] = "未知错误";
    }else{
        LogText("客户管理",$Control['adid'],"管理员{$Control['adname']} 查看了客户{$client['contactName']}的联系方式");
        $json['warn'] = 2;
    }
}
/******************设为小组公客**************************************************************/
elseif($get['type'] == "groupClient"){
    $khid = $post['khid'];
    $kehu = query("kehu","khid = '$khid' ");
    if(empty($kehu['khid'])){
        $json['warn'] = "请先提交客户信息再设置";
    }else{
        if ($kehu['type'] == "私客") {
            mysql_query("UPDATE kehu SET type = '小组公客',clientIntention = '放弃',clientStatus = '放弃', updateTime='$time' WHERE khid='$khid' ");
        }
        $_SESSION['warn']= "设为小组公客成功";
        $json['warn'] = 2;
    }
}
/******************设为公司公客**************************************************************/
elseif($get['type'] == "firmClient"){
    $khid = $post['khid'];
    $kehu = query("kehu","khid = '$khid' ");
    if(empty($kehu['khid'])){
        $json['warn'] = "请先提交客户信息再设置";
    }else{
        if ($kehu['type'] != "公司公客") {
            mysql_query("UPDATE kehu SET type = '公司公客',clientIntention = '放弃',clientStatus = '放弃', updateTime='$time' WHERE khid='$khid' ");
        }
        $_SESSION['warn']= "设为公司公客成功";
        $json['warn'] = 2;
    }
}
/******************数据统计-添加数据**************************************************************/
elseif($get['type'] == "planChoose") {
    //花费
    $statisticsIdSet = $post['statisticsId'];
    $statisticsId = explode('-',$statisticsIdSet);
    $str = array();
    foreach($statisticsId as $k=>$id){
        $statisticsSql = query("statistics", " id = '$id' ");
        $str[] = $statisticsSql['planName'];
        $backName = delquod(explode(',', $statisticsSql['backstage']));
        foreach ($backName as $name) {
            $backstageSql = query("backstage", "name = '$name' ");
            $backSpend = mysql_fetch_assoc(mysql_query("SELECT *,SUM(spend) AS total FROM backSpend WHERE backId = '$backstageSql[id]' AND date >= '$statisticsSql[planDateStart]' AND date <= '$statisticsSql[planDateEnd]' "));
            $json['spend'][$k] += $backSpend['total'];
        }
        //来电量
        $where = " 1 = 2";
        $clientSource = "";
        if (!empty($statisticsSql['telegram']) OR !empty($statisticsSql['chat']) OR !empty($statisticsSql['bridge']) OR !empty($statisticsSql['website'])) {
            if (!empty($statisticsSql['telegram'])) {
                $clientSource .= $statisticsSql['telegram'] . ',';
            }
            if (!empty($statisticsSql['chat'])) {
                $clientSource .= $statisticsSql['chat'] . ',';
            }
            if (!empty($statisticsSql['bridge'])) {
                $clientSource .= $statisticsSql['bridge'] . ',';
            }
            if (!empty($statisticsSql['website'])) {
                $clientSource .= $statisticsSql['website'] . ',';
            }
            $clientSource = substr($clientSource,0,strlen($clientSource)-1);
            $where .= " or clientSourceTwo in ($clientSource)";
        }
        $area = '';
        if (!empty($statisticsSql['area'])) {
            $area .= $statisticsSql['area'];
            $where .= " AND fromArea in ($area)";
        }
        $clientLevel = '';
        if (!empty($statisticsSql['clientLevel'])) {
            $clientLevel .= $statisticsSql['clientLevel'];
            $where .= " AND clientLevel in ($clientLevel)";
        }
        $intention = '';
        if (!empty($statisticsSql['intention'])) {
            $intention .= $statisticsSql['intention'];
            $where .= " AND intentionArea in ($intention)";
        }
        $clientType = '';
        if (!empty($statisticsSql['clientType'])) {
            $clientType .= $statisticsSql['clientType'];
            $where .= " AND clientType in ($clientType)";
        }
        $area = $statisticsSql['area'];
        $clientLevel = explode('，', $statisticsSql['clientLevel']);
        $intention = explode('，', $statisticsSql['intention']);
        $clientType = explode('，', $statisticsSql['clientType']);
        $json['clientNum'][$k] = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE callTime >= '$statisticsSql[planDateStart]' AND callTime <= '$statisticsSql[planDateEnd]' AND ($where) ")) ;
        //带看量
        $json['lookNum'][$k] = mysql_num_rows(mysql_query("SELECT * FROM kehu  WHERE look = '带看' AND callTime >= '$statisticsSql[planDateStart]' AND callTime <= '$statisticsSql[planDateEnd]' AND ($where) ")) ;
        //成交量
        $json['intentionNum'][$k] = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE clientIntention = '成交' AND callTime >= '$statisticsSql[planDateStart]' AND callTime <= '$statisticsSql[planDateEnd]' AND ($where) "));
        //带看成交比
        $json['lookIntention'][$k] = $json['lookNum'][$k] / $json['intentionNum'][$k];
        //成交成本
        if ($json['intentionNum'][$k] == 0) {
            $json['cost'][$k] = $json['spend'][$k];
        }
        else {
            $json['cost'][$k] = $json['spend'][$k] / $json['intentionNum'][$k];
        }
        //电话均价
        if ($json['clientNum'][$k] == 0) {
            $json['price'][$k] = $json['spend'][$k];
        }
        else {
            $json['price'][$k] = $json['spend'][$k] / $json['clientNum'][$k];
        }
        //判断计划类型
        if ($statisticsSql['type'] == '合并计划') {
            $json['spend'][$k] = $statisticsSql['spend'];
            $json['clientNum'][$k] = $statisticsSql['clientNum'];
            $json['lookNum'][$k] = $statisticsSql['lookNum'];
            $json['intentionNum'][$k] = $statisticsSql['intentionNum'];
            $json['lookIntention'][$k] = $statisticsSql['lookNum'] / $statisticsSql['intentionNum'];
            $json['cost'][$k] = $statisticsSql['spend'] / $statisticsSql['intentionNum'];
            $json['price'][$k] = $statisticsSql['spend'] / $statisticsSql['clientNum'];
        }
        else {
            mysql_query("UPDATE statistics SET
            type = '普通计划',
            spend = '$json[spend][$k]',
            clientNum = '$json[clientNum][$k]',
            lookNum = '$json[lookNum][$k]',
            intentionNum = '$json[intentionNum][$k]',
            lookIntention = '$json[lookIntention][$k]',
            cost = '$json[cost][$k]',
            price = '$json[price][$k]',
        WHERE id = '$id' ");
        }
    }
    $json['planName'] = $str;
    $json['planType'] = array("消费","来电量","带看量","成交量","带看成交比","成交成本","电话均价");
}
/******************数据统计-合并计划**************************************************************/
elseif($get['type'] == "mergeStatisticsForm"){
    //赋值
    $planName = $post['planName'];//计划名称
    $planDateStart = $post['planDateStart'];//选择日期
    $planDateEnd = $post['planDateEnd'];//选择日期
    $backstage = $post['backstage'];//推广后台
    $backstage = implode('，',$backstage);
    $telegram = $post['telegram'];//来电
    $telegram = implode('，',$telegram);
    $chat = $post['chat'];//商桥聊天
    $chat = implode('，',$chat);
    $bridge = $post['bridge'];//商桥留言
    $bridge = implode('，',$bridge);
    $website = $post['website'];//网站留言
    $website = implode('，',$website);
    $area = $post['area'];//来电区域
    $telegramDan = $post['telegramDan'];//来电时间段
    $clientLevel = $post['clientLevel'];//客户级别
    $intention = $post['intention'];//意向区域
    $clientType = $post['clientType'];//客户类型
    $remark = $post['remark'];//备注
    $pas = $post['Password'];//密码
    $Array = $post['statisticsList'];
    $i = 0;
    //判断
    if (empty($planName)) {
        $json['warn'] = "计划名称为空";
    }elseif(empty($pas)){
        $json['warn'] = "请输入管理员登录密码";
    }elseif(MD5($pas) != $Control['adpas']) {
        $json['warn'] = "管理员登录密码输入错误";
    }else if ($adDuty['name'] != "超级管理员") {
        $json['warn'] = "只有超级管理员才能合并计划";
    }elseif(empty($Array)){
        $json['warn'] = "您一个计划都没有选择呢";
    }else{
        $did = Stitching($Array);
        $planDateStart = mysql_fetch_assoc(mysql_query("SELECT MIN(planDateStart) AS minDate FROM statistics WHERE id in ($did) "));
        $planDateEnd = mysql_fetch_assoc(mysql_query("SELECT MAX(planDateEnd) AS maxDate  FROM statistics WHERE id in ($did) "));
        foreach($Array as $id){
            //查询计划基本信息
            $statistics = query("statistics"," id = '$id' ");
            //数据相加
            if ($i == 0) {
                $backstage .= $statistics['backstage'];
                $telegram .= $statistics['telegram'];
                $chat .= $statistics['chat'];
                $bridge .= $statistics['bridge'];
                $website .= $statistics['website'];
                $area .= $statistics['area'];
                $clientLevel .= $statistics['clientLevel'];
                $intention .= $statistics['intention'];
                $clientType .= $statistics['clientType'];
            }
            else {
                $backstage .= ','.$statistics['backstage'];
                $telegram .= ','.$statistics['telegram'];
                $chat .= ','.$statistics['chat'];
                $bridge .= ','.$statistics['bridge'];
                $website .= ','.$statistics['website'];
                $area .= ','.$statistics['area'];
                $clientLevel .= ','.$statistics['clientLevel'];
                $intention .= ','.$statistics['intention'];
                $clientType .= ','.$statistics['clientType'];
            }
            $backstage = explode(',',$backstage);
            $backstage = array_unique($backstage);
            $backstage = implode(',',$backstage);

            $telegram = explode(',',$telegram);
            $telegram = array_unique($telegram);
            $telegram = implode(',',$telegram);

            $chat = explode(',',$chat);
            $chat = array_unique($chat);
            $chat = implode(',',$chat);

            $bridge = explode(',',$bridge);
            $bridge = array_unique($bridge);
            $bridge = implode(',',$bridge);

            $website = explode(',',$website);
            $website = array_unique($website);
            $website = implode(',',$website);

            $area = explode(',',$area);
            $area = array_unique($area);
            $area = implode(',',$area);

            $clientLevel = explode(',',$clientLevel);
            $clientLevel = array_unique($clientLevel);
            $clientLevel = implode(',',$clientLevel);

            $intention = explode(',',$intention);
            $intention = array_unique($intention);
            $intention = implode(',',$intention);

            $clientType = explode(',',$clientType);
            $clientType = array_unique($clientType);
            $clientType = implode(',',$clientType);

            $spend += $statistics['spend'];
            $clientNum += $statistics['clientNum'];
            $lookNum += $statistics['lookNum'];
            $intentionNum += $statistics['intentionNum'];
            $lookIntention += $statistics['lookIntention'];
            $cost += $statistics['cost'];
            $price += $statistics['price'];
            $i++;
        }
        $sid = rand(1000000000,9999999999);
        while(mysql_num_rows(mysql_query(" SELECT id FROM statistics WHERE id = '$sid' ")) > 0){
            $sid = rand(1000000000,9999999999);
        }
        $bool = mysql_query(" INSERT INTO statistics
            ( id, planName, planDateStart, planDateEnd, backstage, telegram, chat, bridge, website, area, telegramDan, clientLevel, intention, clientType, remark,type,spend,clientNum,lookNum,intentionNum,lookIntention,cost,price, updateTime, time )
            VALUES
            ( '$sid', '$planName','$planDateStart[minDate]', '$planDateEnd[maxDate]', '$backstage', '$telegram', '$chat', '$bridge', '$website', '$area', '$telegramDan', '$clientLevel', '$intention', '$clientType', '$remark','合并计划','$spend','$clientNum','$lookNum','$intentionNum','$lookIntention','$cost','$price', '$time', '$time' )
            ");
        if ($bool) {
            $json['warn'] = 2;
            $_SESSION['warn'] = "合并了{$i}个计划";
            LogText("客户管理", $Control['adid'], "管理员{$Control['adname']}合并了计划基本信息（计划名称：{$planName}，计划ID：{$sid}）");
        } else {
            $json['warn'] = "合并失败";
        }
    }
}
/********批量处理**************************************/
elseif(isset($post['PadWarnType'])){
    //赋值
    $type = $post['PadWarnType'];//执行指令
    $pas = $post['Password'];//密码
    $x = 0;
    //判断
    if(empty($type)){
        $json['warn'] = "执行指令为空";
    }elseif(empty($pas)){
        $json['warn'] = "请输入管理员登录密码";
    }elseif(MD5($pas) != $Control['adpas']){
        $json['warn'] = "管理员登录密码输入错误";

    }
    //删除客户
    elseif($type == "deleteClient"){
        $Array = $post['ClientList'];
        if($adDuty['name'] != "超级管理员"){
            $json['warn'] = "只有超级管理员才能删除客户";
        }elseif(empty($Array)){
            $json['warn'] = "您一个客户都没有选择呢";
        }else{
            foreach($Array as $id){
                //查询客户基本信息
                $kehu = query("kehu"," khid = '$id' ");
                //删除客户信息
                mysql_query("DELETE FROM kehuMsg WHERE khid = '$id'");
                //删除客户成交记录
                mysql_query("DELETE FROM clinchRecord WHERE khid = '$id'");
                //删除客户回访记录
                mysql_query("DELETE FROM kehuFollow WHERE khid = '$id'");
                //最后删除客户基本资料
                mysql_query("DELETE FROM kehu WHERE khid = '$id'");
                //添加日志
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}删除了客户（联系人姓名：{$kehu['contactName']}，客户ID：{$kehu['khid']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个客户";
            $json['warn'] = 2;
        }
    }
    //删除计划
    elseif($type == "deleteSt atistics"){
        $Array = $post['statisticsList'];
        if($adDuty['name'] != "超级管理员"){
            $json['warn'] = "只有超级管理员才能删除计划";
        }elseif(empty($Array)){
            $json['warn'] = "您一个计划都没有选择呢";
        }else{
            foreach($Array as $id){
                //查询计划基本信息
                $statistics = query("statistics"," id = '$id' ");
                //最后删除计划基本资料
                mysql_query("DELETE FROM statistics WHERE id = '$id'");
                //添加日志
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}删除了计划（计划名称：{$statistics['planName']}，计划ID：{$statistics['id']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个计划";
            $json['warn'] = 2;
        }
    }
    //删除后台列表
    elseif($type == "deleteStatistics"){
        $Array = $post['statisticsList'];
        if($adDuty['name'] != "超级管理员"){
            $json['warn'] = "只有超级管理员才能删除后台列表";
        }elseif(empty($Array)){
            $json['warn'] = "您一个后台列表都没有选择呢";
        }else{
            foreach($Array as $id){
                //查询后台列表基本信息
                $backstage = query("backstage"," id = '$id' ");
                //删除后台花费
                mysql_query("DELETE FROM backSpend WHERE backId = '$id'");
                //最后删除后台列表基本资料
                mysql_query("DELETE FROM backstage WHERE id = '$id'");
                //添加日志
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}删除了后台列表（后台列表名称：{$backstage['planName']}，后台列表ID：{$backstage['id']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个后台列表";
            $json['warn'] = 2;
        }
    }
    else{
        $json['warn'] = "未知执行指令";
    }
}
/********返回**************************************/

echo json_encode($json);
?>