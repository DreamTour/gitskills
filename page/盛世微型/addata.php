<?php
include "adfunction.php";
foreach($_POST as $key => $value){
    $post[$key] = FormSubArray($value);
}
/*************个人中心-微信推送***************************/
/*
*因为是用的登录页触发的此事件，所以处于未登录状态
*/
if($_GET['type'] == "wxMessage"){
    $dayStart = strtotime(date("Y-m-d")." 00:00:00");//今天开始的时间戳
    $lastTime = para("wxMessageDate");//最后一次执行的时间戳
    if($lastTime > $dayStart){
    }else{
        $t = time();//当前时间戳
        mysql_query(" update para set
		paValue = '$t',
		updateTime = '$time' where paid = 'wxMessageDate' ");
        //在下面执行微信通知
        //每周提醒业务员一次收款，直到开票总金额<=回款总金额为止
        $sql = mysql_query("select * from admin where duty in (select id from adDuty where department = '市场部' and name = '客户经理') and wxOpenid != '' ");
        //市场部主管
        $marketing = query("adDuty"," department = '市场部' and name = '市场部主管' ");
        $marketingWx = query("admin"," duty = '$marketing[id]' ");
        //技术副总
        $technology = query("adDuty"," department = '总裁办' and name = '技术副总' ");
        $technologyWx = query("admin"," duty = '$technology[id]' ");
        //运营副总
        $operate = query("adDuty"," department = '总裁办' and name = '运营副总' ");
        $operateWx = query("admin"," duty = '$operate[id]' ");
        //总经理
        $manager = query("adDuty"," department = '总裁办' and name = '总经理' ");
        $managerWx = query("admin"," duty = '$manager[id]' ");
        while($array = mysql_fetch_array($sql)){
            $buycarSql = mysql_query("select * from buycar where adid = '$array[adid]'  ");
            while($buycar = mysql_fetch_array($buycarSql)){
                //合同到期前一个月(续签提醒)
                $endday = Days($buycar['endTime']);
                $sign = '即将到期';
                $text = "到期时间：{$buycar['endTime']},请业务员尽快续签";
                $content1 = $buycar['companyName'];
                //第30天消息推送
                if($endday == 30){
                    ReturnUploadMessage($buycar['identifier'],$sign,$content1,$text,$array['wxOpenid']);
                }
                //判断30之间是否有新合同
                if($endday < 30 and $endday >= 0){
                    //计算出30天之后的时间
                    $orderStar = date('Y-m-d',strtotime('-30 day',strtotime($buycar['endTime'])));
                    $total = mysql_fetch_array(mysql_query("select count(*) as total from buycar where adid = '$array[adid]' and companyName = '$buycar[companyName]' and time between '{$orderStar} 00:00:00' and '{$buycar[endTime]} 23:59:59' "));
                    //如果没有则每隔三天进行消息推送
                    if($total['total'] == 0){
                        $dayNum = 30;
                        for($i = 1;$i < 10;$i++){
                            $dayNum -= 3;
                            if( date('Y-m-d') ==  date('Y-m-d',strtotime("+$dayNum day",strtotime($orderStar))) ){
                                ReturnUploadMessage($buycar['identifier'],$sign,$content1,$text,$array['wxOpenid']);
                            }
                        }

                    }
                }
                //收运提醒：如合同到期前两个月从未进行收运，则提醒业务员一次
                $text = "到期时间：{$buycar['endTime']},请业务员帮助客户尽快完成收运";
                $numSum = mysql_num_rows(mysql_query("select * from transport where buycarId = '$buycar[id]' and state = '已收运' "));
                if($endday == 60 and $numSum == 0){
                    ReturnUploadMessage($buycar['identifier'],$sign,$content1,$text,$array['wxOpenid']);
                }
                //每周周一推送已开票但未回款的消息
                if($buycar['invoice'] > $buycar['pay'] and date('w') == 1){
                    $noPay = $buycar['invoice']-$buycar['pay'];
                    $text = "请业务员尽快收回未回款金额{$noPay}";
                    ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$array['wxOpenid'] ,$text);
                }
                if(!empty($buycar['invoice']) and $buycar['pay'] <= $buycar['money'] and date('w') == 1){
                    //计算从已开票算起的次数
                    $buycarInvoice  =  mysql_fetch_array(mysql_query("SELECT * FROM buycarInvoice WHERE buycarId = '$buycar[id]' ORDER BY buycarId ASC LIMIT 0,1"));
                    //获取次数
                    if(!empty($buycarInvoice['id'])){
                        $n = 0;
                        $day = Days($buycarInvoice['time']);
                        if($day < 0){
                            $day = substr($day, '1');
                            $date1 = date('Y-m-d',strtotime($buycarInvoice['time']));
                            for($i=1;$i<$day;$i++){
                                $strtotime = date('Y-m-d',strtotime("$date1 +$i day"));
                                if( date('w',strtotime($strtotime)) == 1){$n++;}
                            }

                        }
                        $noPay = $buycar['money']-$buycar['pay'];
                        $text = "请尽快处理剩余未回全款{$noPay}金额";
                        ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$array['wxOpenid'],$buycar['invoice'].'（总）',$text);
                        if($n >= 4 and $n < 6){
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$marketingWx['wxOpenid'],$buycar['invoice'].'（总）',$text);
                        }elseif($n >= 6 and $n < 8){
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$marketingWx['wxOpenid'],$buycar['invoice'].'（总）',$text);
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$technologyWx['wxOpenid'],$buycar['invoice'].'（总）',$text);
                        }elseif($n >= 8 and $n < 10){
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$marketingWx['wxOpenid'],$buycar['invoice'].'（总）',$text);
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$technologyWx['wxOpenid'],$buycar['invoice'].'（总）',$text);
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$operateWx['operateWx'],$buycar['invoice'].'（总）',$text);
                        }else{
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$marketingWx['wxOpenid'],$buycar['invoice'].'（总）',$text);
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$technologyWx['wxOpenid'],$buycar['invoice'].'（总）',$text);
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$operateWx['operateWx'],$buycar['invoice'].'（总）',$text);
                            ReturnUploadMessage3($buycar['identifier'],$buycar['companyName'],$managerWx['operateWx'],$buycar['invoice'].'（总）',$text);
                        }
                    }
                }
            }


        }
    }
}
/*************如下代码必须在登录的情况下才能执行，否则返回未登录提示***************************/
if($ControlFinger == 2){
    $json['warn'] = $ControlWarn;
    /**********财务管理-收支平衡-新增或更新收支记录*********************/
}elseif($_GET['type'] == "adProfitEdit"){
    //赋值
    $direction = "收入";
    $money = $post['ProfitMoney'];//发生金额
    $type = $post['ProfitMoneyType'];//收款类型
    $source = $post['ProfitMoneySource'];//收款来源
    $text = $post['ProfitText'];//备注
    $PayDate = $post['year']."-".$_POST['moon']."-".$_POST['day'];//结算日
    $buyCarId = $post['buyCarId'];//合同id号
    $ProfitId = $post['ProfitId'];//收支平衡id号
    //判断并执行
    if(empty($money)){
        $json['warn'] = "请填写发生金额";
    }elseif(preg_match($CheckPrice,$money) == 0){
        $json['warn'] = "发生金额格式不正确";
    }elseif(empty($text)){
        $json['warn'] = "请填写备注";
    }elseif(empty($post['year'])){
        $json['warn'] = "请选择年";
    }elseif(empty($_POST['moon'])){
        $json['warn'] = "请选择月";
    }elseif(empty($_POST['day'])){
        $json['warn'] = "请选择日";
    }elseif(Repeat("Profit where direction = '收入' and type = '$type' and money = '$money' and text = '$text' and source = '$source' and buycarId = '$buyCarId' and PayDate = '$PayDate'  ","id",$ProfitId)){
        $json['warn'] = "本目录已经存在，请勿重复提交";
    }elseif(empty($ProfitId)){
        //判断新增数据是否重复提交
        $ProfitId = suiji();
        $bool = mysql_query(" insert into Profit (id,direction,type,money,text,buycarId,source,PayDate,UpdateTime,time)
		values ('$ProfitId','$direction','$type','$money','$text','$buyCarId','$source','$PayDate','$time','$time') ");
        if($bool){
            $buycar = query("buycar"," id = '$buyCarId' ");
            $admin = query("admin"," adid = '$buycar[adid]' ");
            ReturnUploadMessage2($buycar['identifier'],$buycar['name'],$money,$admin['wxOpenid']);
            LogText("收支平衡",$Control['adid'],"{$Control['adname']}新增了收支记录（方向：{$direction}，金额：{$money}，备注：{$text}）");
            $_SESSION['warn'] = "新增收支记录成功";
            $json['warn'] = 2;
        }else{
            $json['warn'] = "新增收支记录失败";
        }
    }else{
        $Profit = query("Profit"," id = '$ProfitId' ");
        $buyCarId = $Profit['buycarId'];
        if($Profit['id'] != $ProfitId){
            $json['warn'] = "未找到此收支记录";
        }else{
            $bool = mysql_query(" update Profit set
			type = '$type',
			money = '$money',
			text = '$text',
			source = '$source',
			PayDate = '$PayDate',
			UpdateTime = '$time' where id = '$ProfitId' ");
            if($bool){
                LogText("收支平衡",$Control['adid'],"{$Control['adname']}更新了收支记录（方向：{$direction}，金额：{$money}，备注：{$text}）");
                $_SESSION['warn'] = "变动记录更新成功";
                $json['warn'] = 2;
            }else{
                $json['warn'] = "变动记录更新失败";
            }
        }
    }
    //更新订单表的收款总金额
    $num = mysql_fetch_array(mysql_query("select sum(money) as total from Profit where direction = '收入' and buycarId = '$buyCarId' "));
    mysql_query(" update buycar set pay = '$num[total]' where id = '$buyCarId' ");
    //返回跳转url
    $json['href'] = root."control/finance/adProfitMx.php?id=".$ProfitId;
    /************内部管理-危险废物名录-新增或更新基本参数********************************************/
}elseif($_GET['type'] == "adCatalogEdit"){
    //赋值
    $id = $post['adCatalogId'];//危险废物名录ID号
    $type = $post['CatalogType'];//废物类别
    $industry = $post['CatalogIndustry'];//行业来源
    $code = $post['CatalogCode'];//废物代码
    $text = $post['CatalogText'];//危险废物说明
    $features = $post['CatalogFeatures'];//危险特性
    $own = $post['CatalogOwn'];//是否为本公司储运
    //判断
    if(empty($type)){
        $json['warn'] = "新填写废物类别";
    }elseif(empty($industry)){
        $json['warn'] = "新填写行业来源";
    }elseif(empty($code)){
        $json['warn'] = "新填写废物代码";
    }elseif(empty($text)){
        $json['warn'] = "新填写危险废物说明";
    }elseif(empty($features)){
        $json['warn'] = "新填写危险特性";
    }elseif(Repeat("Catalog where code = '$code' and text = '$text' ","id",$id)){
        $json['warn'] = "本目录已经存在，请勿重复提交";
    }elseif(empty($id)){
        $sql = mysql_query(" select * from Catalog ");
        while($array = mysql_fetch_array($sql)){
            $id = suijiNum();
            while(mysql_num_rows(mysql_query(" select * from Catalog where id = '$id' ")) > 0){
                $id = suijiNum();
            }
        }
        $bool = mysql_query(" insert into Catalog (id,type,industry,code,text,features,own,UpdateTime,time)
            values ('$id','$type','$industry','$code','$text','$features','$own','$time','$time') ");
        if($bool){
            $_SESSION['warn'] = "新建成功";
            $json['warn'] = 2;
        }else{
            $json['warn'] = "新建失败";
        }
    }else{
        $Catalog = query("Catalog"," id = '$id' ");
        if($Catalog['id'] != $id){
            $json['warn'] = "未找到该信息";
        }else{
            $bool = mysql_query(" update Catalog set
                type = '$type',
                industry = '$industry',
                code = '$code',
                text = '$text',
                features = '$features',
                own = '$own',
                UpDateTime = '$time' where id = '$id' ");
            if($bool){
                $_SESSION['warn'] = "更新成功";
                $json['warn'] = 2;
            }else{
                $json['warn'] = "更新失败";
            }
        }
    }
    $json['href'] = root."control/Internal/adCatalogMx.php?id=".$id;
    /*******客户管理-新增或更新行业基本资料*************************************/
}elseif($_GET['type'] == "IndustryEdit" ){
    //赋值
    $name = $post['name'];//行业名称
    $excess = $post['weight'];//是否允许重量
    $xian = $post['status'];//状态
    $list = $post['list'];//排序号
    $id = $post['adIndustryId'];//行业id
    //判断
    if(!power("客户管理")){
        $json['warn'] = "权限不足";
    }elseif(empty($name)){
        $json['warn'] = "请填行业名称";
    }elseif(Repeat("kehuIndustry where name = '$name' ","id",$id)){
        $json['warn'] = "行业名称重复";
    }elseif(empty($xian)){
        $json['warn'] = "请选择行业状态";
    }elseif(empty($list)){
        $json['warn'] = "请选择行业排序号";
    }elseif(preg_match($CheckInteger,$list) == 0){
        $json['warn'] = "排序号必须为正整数";
    }elseif(empty($excess)){
        $json['warn'] = "请填行业允许超出重量";
    }elseif(empty($id)){
        $id = suiji();
        $bool = mysql_query(" insert into kehuIndustry
            (id,name,excess,xian,list,updateTime,time)
            values
            ('$id','$name','$excess','$xian','$list','$time','$time')
            ");
        if($bool){
            $json['warn'] = 2;
            $_SESSION['warn'] = "新增成功";
            LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}新增了行业基本信息（行业名称：{$name}，客户ID：{$id}）");
        }else{
            $json['warn'] = "新增失败";

        }
    }else{
        $kehuIndustry = query("kehuIndustry"," id = '$id' ");
        if(empty($kehuIndustry['id'])){
            $json['warn'] = "本行业未找到";
        }else{
            $bool = mysql_query(" update kehuIndustry set
			name = '$name',
			excess = '$excess',
			xian = '$xian',
			list = '$list',
			updateTime = '$time' where id = '$id' ");
            if($bool){
                $_SESSION['warn'] = "行业基本资料更新成功";
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了行业基本信息（行业名称：{$name}，客户ID：{$id}）");
                $json['warn'] = 2;
            }else{
                $json['warn'] = "客户基本资料更新失败";
            }
        }
    }
    $json['href'] = root."control/adClientIndustryMx.php?id=".$id;
    /*******客户管理-新增或更新基本资料*************************************/
}elseif($_GET['type'] == "clientEdit" ){
    //赋值
    $contactName = $post['ContactName'];//联系人姓名
    $contactTel = $post['ContactTel'];//联系人手机
    $text = $post['text'];//简要介绍
    $id = $post['adClientId'];//客户ID
    //判断
    /*if(!power("客户管理")){
        $json['warn'] = "权限不足";
    }else*/if(empty($contactName)){
        $json['warn'] = "请填写联系人姓名";
    }elseif(empty($contactTel)){
        $json['warn'] = "请填写联系手机";
    }elseif(preg_match($CheckTel,$contactTel) == 0){
        $json['warn'] = "手机号码格式有误";
    }elseif(Repeat(" kehu where ContactTel = '$ContactTel' ","khid",$id)){
        $json['warn'] = "联系人手机号码重复";
    }elseif(empty($id)){
        $id = rand(1000000000,9999999999);
        while(mysql_num_rows(mysql_query(" select khid from kehu where khid = '$id' ")) > 0){
            $id = rand(1000000000,9999999999);
        }
        $bool = mysql_query(" INSERT INTO kehu
            (khid, adid, type, contactName, contactTel, text, UpdateTime, time)
            VALUES
            ('$id', '$Control[adid]', '私客', '$contactName', '$contactTel', '$text', '$time', '$time')
            ");
        if($bool){
            $json['warn'] = 2;
            $_SESSION['warn'] = "新增成功";
            LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}新增了客户基本信息（客户名称：{$contactName}，客户ID：{$id}）");
        }else{
            $json['warn'] = "新增失败";
        }
    }else{
        $kehu = query("kehu"," khid = '$id' ");
        if($kehu['khid'] != $id){
            $json['warn'] = "本客户未找到";
        }elseif($kehu['adid'] != $Control['adid'] ){
            $json['warn'] = "只有所属员工才能修改对应资料";
        }else{
            $bool = mysql_query(" update kehu set
                CompanyName = '$CompanyName',
                industry = '$industry',
                ContactName = '$ContactName',
                ContactTel = '$ContactTel',
                spareTel = '$spareTel',
                Landline = '$Landline',
                fax = '$fax',
                ContactQQ = '$ContactQQ',
		labeMaking = '$labeMaking',
                text = '$text',
                businessLicenseNum = '$businessLicenseNum',
                UpdateTime = '$time' where khid = '$id' ");
            if($bool){
                $_SESSION['warn'] = "客户基本资料更新成功";
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了客户基本信息（公司名称：{$CompanyName}，客户ID：{$id}）");
                $json['warn'] = 2;
            }else{
                $json['warn'] = "客户基本资料更新失败";
            }
        }
    }
    $json['href'] = root."control/adClientMx.php?id=".$id;
    /*******客户管理-变更有效客户状态*************************************/
}elseif($_GET['type'] == "changeClientValid" ){
    //赋值
    $valid = $post['clientValid']; //有效客户状态
    $khid = $post['khid'];//客户id
    $client = query("kehu"," khid = '$khid' ");
    if($valid == "是"){
        $json['contrary'] = "否";
    }elseif($valid == "否"){
        $json['contrary'] = "是";
    }else{
        $json['warn'] = "状态参数错误";
    }
    if(empty($json['warn'])){
        if(empty($valid)){
            $json['warn'] = "客户有效状态为空";
        }elseif($adDuty['department'] != "市场部" || $adDuty['name'] != "市场部主管"){
            $json['warn'] = "只有市场部主管才能变更客户有效状态";
        }elseif(empty($khid)){
            $json['warn'] = "客户id号为空";
        }elseif(empty($client['khid'])){
            $json['warn'] = " 未找到该客户";
        }else{
            $bool = mysql_query("update kehu set valid = '$valid',UpdateTime = '$time' where khid = '$khid' ");
            if($bool){
                $json['warn'] = 2;
                $json['valid'] = $valid;
            }else{
                $json['warn'] = "失败";
            }
        }
    }
    /********客户管理-变更客户性质**************************************/
}elseif($_GET['type'] == "changeClientFollowType"){
    //赋值
    $followType = $post['clientFollowType']; //有效客户状态
    $khid = $post['khid'];//客户id
    $client = query("kehu"," khid = '$khid' ");
    if($followType == "公客"){
        $json['contrary'] = "私客";
        $adid = "";
    }elseif($followType == "私客"){
        $json['contrary'] = "公客";
        $adid = $Control['adid'];
    }else{
        $json['warn'] = "状态参数错误";
    }
    if(empty($json['warn'])){
        if(empty($followType)){
            $json['warn'] = "客户性质为空";
        }elseif(empty($khid)){
            $json['warn'] = "客户id号为空";
        }elseif(empty($client['khid'])){
            $json['warn'] = " 未找到该客户";
        }elseif($client['followType'] == "私客" and $client['adid'] != $Control['adid']){
            $json['warn'] = " 这不是你的私客";
        }elseif($adDuty['department'] != "市场部" or $adDuty['name'] != "客户经理"){
            $json['warn'] = "只有市场部客户经理才能转换客户跟进性质";
        }else{
            $checkNum = mysql_num_rows(mysql_query(" select * from kehu where followType = '私客' and adid = '$Control[adid]' "));
            $maxNum = para("kh5ytgff");
            if($checkNum >= $maxNum and $followType == "私客" ){
                $json['warn'] = "私客数量不能超过".$maxNum."个";
            }else{
                $bool = mysql_query("update kehu set followType = '$followType',adid = '$adid',UpdateTime = '$time' where khid = '$khid' ");
                if($bool){
                    $json['warn'] = 2;
                    $json['followType'] = $followType;
                }else{
                    $json['warn'] = "失败";
                }
            }

        }
    }
    /********客户管理-批量分配客户**************************************/
}elseif($_GET['type'] == "allotClient"){
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
    }else{
        $x=0;
        foreach($ClientList as $id ){
            $kehu = query("kehu", " khid = '$id' ");
            mysql_query( " update kehu set
                type = '私客',
                adid = '$adid',
                UpdateTime = '$time' where khid = '$id' " );
            LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}把 {$kehu['contactName']}分配给了{$admin['adname']}");
            $x++;
        }
        $json['warn'] = 2;
        $_SESSION['warn'] = "管理员{$Control['adname']}为{$admin['adname']}新增了".$x."个客户";
    }
    /********客户管理-经理查看了某个员工的客户的联系的方式**************************************/
}elseif($_GET['type'] == "contactTel"){
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
    /********客户管理-新增或更新客户地址**************************************/
}elseif($_GET['type'] == "addressEdit" ){
    //赋值
    $khid = $post['khid'];//客户id
    $kehu = query('kehu'," khid = '$khid' ");
    $AddressName = $post['AddressName'];//联系人姓名
    $AddressTel = $post['AddressTel'];//联系人手机
    $RegionId = $post['area'];//区域id
    $AddressMx = $post['AddressMx'];//详细地址
    $longitude = $post['longitude'];//经度
    $latitude = $post['latitude'];//纬度
    $AddressIdIpt = $post['AddressIdIpt'];//默认地址选择
    $id = $post['adClientAddressId'];//表主键
    //判断
    if(!power("客户管理")){
        $json['warn'] = "权限不足";
    }elseif(empty($khid)){
        $json['warn'] = "请输入 客户ID号";
    }elseif($kehu['khid'] != $khid){
        $json['warn'] = "未找到此客户";
    }elseif(empty($AddressName)){
        $json['warn'] = "请输入联系人姓名";
    }elseif(empty($AddressTel)){
        $json['warn'] = "请输入联系人手机";
    }elseif(preg_match($CheckTel,$AddressTel) == 0){
        $json['warn'] = "手机号码格式不正确";
    }elseif(empty($RegionId)){
        $json['warn'] = "请选择所属区域";
    }elseif(empty($AddressMx)){
        $json['warn'] = "请输入详细地址";
    }elseif(empty($longitude)){
        $json['warn'] = "请输入经度";
    }elseif(empty($latitude)){
        $json['warn'] = "请输入纬度";
    }elseif(empty($AddressIdIpt)){
        $json['warn'] = "请确定是否是默认地址";
    }elseif(Repeat(" address where khid = '$khid' and RegionId = '$RegionId' and AddresssMx = '$AddressMx' ","id",$id)){
        $json['warn'] = "此客户已经存在该地址了";
    }elseif(empty($id)){
        $id = suiji();
        $bool = mysql_query(" insert into address (id,khid,AddressName,AddressTel,RegionId,AddressMx,longitude,latitude,UpdateTime,time)
            values
            ('$id','$khid','$AddressName','$AddressTel','$RegionId','$AddressMx','$longitude','$latitude','$time','$time') ");
        if($bool){
            LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}新增了客户地址（公司名称：{$kehu['CompanyName']}，客户ID：{$khid}）");
            $_SESSION['warn'] = "创建成功";
            $json['warn'] = 2;
        }else{
            $json['warn'] = "创建失败";
        }
    }else{
        $address = query("address"," id = '$id' ");
        if($address['id'] != $id){
            $json["warn"] = "未找到本记录！";
        }else{
            $bool = mysql_query("update address set
                AddressName = '$AddressName',
                AddressTel = '$AddressTel',
                RegionId = '$RegionId',
                AddressMx = '$AddressMx',
                longitude = '$longitude',
                latitude = '$latitude',
                UpdateTime = '$time' where id = '$id' ");
            if($bool){
                $_SESSION['warn'] = "修改成功";
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了客户地址（公司名称：{$kehu['CompanyName']}，客户ID：{$khid}）");
                $json['warn'] = 2;
            }else{
                $json['warn'] = "客户地址更新失败";
            }
        }
    }
    //如果是默认地址，则更新客户表默认地址ID号
    if($AddressIdIpt == "是"){
        mysql_query(" update kehu set AddressId = '$id' where khid = '$khid' ");

    }
    //如果不是默认地址，则更新客户表默认地址ID号为空
    if($AddressIdIpt != "是"){
        mysql_query(" update kehu set AddressId = ' ' where khid = '$khid' ");

    }    $json['href'] = root."control/adClientAddressMx.php?id=".$id;
    /*******跟进记录-新增跟进记录*************************************/
}elseif($_GET['type'] == "ClientFollow"){
    //赋值
    $text = $post['text'];//跟进信息
    $khid = $post['ClientId'];//被跟进的客户id号
    //判断
    if(!power("客户管理")){
        $json['warn'] = "权限不足";
    }elseif(empty($text)){
        $json['warn'] = "请填写跟进信息";
    }elseif(empty($khid)){
        $json['warn'] = "未指定跟进对象";
    }elseif(mysql_num_rows(mysql_query(" select * from kehu where khid = '$khid' ")) == 0){
        $json['warn'] = "未找到此客户";
    }else{
        $id = suiji();
        $text .= "【{$Control['adname']}】";//添加后缀，防止管理员被删除后无法通过管理员id查询到管理员姓名
        $bool = mysql_query(" insert into kehuFollow (khid,adid,text,time) values ('$khid','$Control[adid]','$text','$time') ");
        if($bool){
            $_SESSION['warn'] = "新增跟进成功";
            LogText("客户管理",$Control['adid'],"{$adDuty['department']}-{$adDuty['name']}-{$Control['adname']}新增了一条跟进记录（{$text}）【id号：{$id}】");
            $json['warn'] = 2;
        }else{
            $json['warn'] = "新增跟进失败";
        }
    }
    /********转运需求-新增转运信息**************************************/
}elseif($_GET['type'] == "transportAdd" ){
    //赋值
    $khNameEdit = $post['khNameEdit'];//公司名称
    $khid = $post['khid'];//客户id
    $addressId = $post['kehuAddress'];//客户收运地址
    $kehu = query("kehu"," khid =  '$khid' ");//查询该客户
    $car = $post['car'];//车牌号
    $state = $post['state'];//转运状态
    $bill = $post['bill'];//联单号
    $buycarId = $post['orderName'];//执行合同ID
    $buyCar = query('buycar',"id = '$buycarId'");//查合同是否到期
    $year = $post['year'];//年
    $moon = $post['moon'];//月
    $day = $post['day'];//日
    $data = $year."-".$moon."-".$day;
    $id = $post['adTransportId'];//转运id
    $Profit = mysql_query(" select COUNT(*) countNum from transport  where buycarId = '$buycarId' and state = '已收运'");//查相同合同id下的转运记录表
    $ProfitNum = mysql_fetch_array($Profit);//转运次数是否达到合同的总次数
    //查询是否属于客户自己的地址
    $address = query('address'," id = '$addressId' ");
    //判断
    if(!power("转运需求")){
        $json['warn'] = "权限不足";
    }elseif($adDuty['transportEdit'] != "是"){
        $json['warn'] = "您没有编辑权限";
    }elseif($buyCar['money'] > $buyCar['pay']){
        $json['warn'] = "回款金额小于合同金额，无法增加转运信息";
    }elseif(empty($khNameEdit)){
        $json['warn'] = "公司名称为空";
    }elseif(empty($khid)){
        $json['warn'] = "客户id为空";
    }elseif(empty($kehu['khid'])){
        $json['warn'] = "未找到该客户";
    }elseif(empty($buycarId)){
        $json['warn'] = "执行合同编号为空";
    }elseif($buyCar['khid'] != $khid){
        $json['warn'] = "该合同不属于该客户";
    }elseif(date("Y-m-d") > $buyCar['endTime']){
        $json['warn'] = "此合同已到期,无法提交转运信息";
    }elseif($buyCar['num'] == $ProfitNum['countNum']){
        $json['warn'] = "此合同转运信息次数已达到合同收运最高次数";
    }elseif(empty($addressId)){
        $json['warn'] = "请选择联系地址";
    }elseif(empty($address)){
        $json['warn'] = "地址不存在";
    }elseif($address['khid'] != $khid ){
        $json['warn'] = "该地址不属于该客户";
    }elseif(empty($id)){
        //id去重
        $id = suiji();
        $sql = mysql_query(" select * from transport where id = '$id' ");
        while(mysql_num_rows(mysql_query($sql)) > 0){
            $id = suiji();
        }
        $bool = mysql_query("insert into transport
		(id,khid,buycarId,addressId,car,urgent,state,bill,transportTime,updateTime,time)
		values
		('$id','$khid','$buycarId','$addressId','$car','一般','待收运','$bill','$data','$time','$time')");
        if($bool){
            LogText("转运需求",$Control['adid'],"管理员{$Control['adname']}新增了转运需求（公司名称：{$CompanyName}，客户ID：{$id}）");
            $_SESSION['warn'] = "新增成功";
            $json['warn'] = 2;
        }
        else{
            $_SESSION['warn'] = "新增失败";
        }
    }else{
        $transport = query("transport"," id = '$id' ");
        if($transport['id'] != $id){
            $json["warn"] = "未找到本记录！";
        }else{
            $bool = mysql_query("update transport set
			khid = '$khid',
			buycarId = '$buycarId',
			addressId = '$addressId',
			car = '$car',
			state = '$state',
			bill = '$bill',
			transportTime = '$data',
			updateTime = '$time' where id = '$id' ");
            if($bool){
                LogText("转运需求",$Control['adid'],"管理员{$Control['adname']}修改转运需求（公司名称：{$CompanyName}，客户ID：{$id}）");
                $_SESSION['warn'] = "修改成功";
                $json['warn'] = 2;
            }else{
                $_SESSION['warn'] = "修改失败";
            }
        }
    }
    $json['href'] = root."control/adTransportMx.php?id=".$id;
    /******************设为小组公客**************************************************************/
}elseif($get['type'] == "groupClient"){
    $khid = $post['khid'];
    $kehu = query("kehu","khid = '$khid' ");
    if(empty($kehu['khid'])){
        $json['warn'] = "参数错误";
    }else{
        if ($kehu['type'] == "私客") {
            mysql_query("UPDATE kehu SET type = '小组公客', updateTime='$time' WHERE khid='$khid' ");
        }
        $_SESSION['warn']= "设为小组公客成功";
        $json['warn'] = 2;
    }
    /******************设为公司公客**************************************************************/
}elseif($get['type'] == "firmClient"){
    $khid = $post['khid'];
    $kehu = query("kehu","khid = '$khid' ");
    if(empty($kehu['khid'])){
        $json['warn'] = "参数错误";
    }else{
        if ($kehu['type'] != "公司公客") {
            mysql_query("UPDATE kehu SET type = '公司公客', updateTime='$time' WHERE khid='$khid' ");
        }
        $_SESSION['warn']= "设为公司公客成功";
        $json['warn'] = 2;
    }
    /********转运需求-查询客户地址**************************************/
}elseif($_GET['type'] == "searchKehuAddress"){
    //赋值
    $khid = $post['khid'];//客户id
    $json['address'] = clientAddress("select","kehuAddress","--请选择地址--","",$khid);
    /********转运需求-执行合同编号**************************************/
}elseif($_GET['type'] == "searchOrderNum"){
    //赋值
    $khid = $post['khid'];//客户id
    $json['order'] = IdOption("buycar where khid = '$khid' and sign = '已签入' ","id","name","--选择合同名称--","");
    /*************转运需求-详细信息--修改转运需求状态***************************/
}elseif($_GET['type'] == 'collectionInfo'){
    //赋值
    $id = $post['transportId'];//转运id号
    $password = $post['password'];//密码
    $status = $post['status'];//切为+转运状态
    $transport = query("transport"," id  = '$id' "); //查看是否有该条转运需求
    if(!power('转运需求')){
        $json['warn']='权限不足';
    }elseif($adDuty['transportEdit'] != '是'){
        $json['warn']='您没有修改转运需求编辑的权限';
    }elseif(empty($password)){
        $json['warn']='请填写登录密码';
    }elseif($Control['adpas'] != $password){
        $json['warn']='登录密码错误';
    }elseif(empty($id)){
        $json['warn']='转运id为空';
    }elseif(empty($status)){
        $json['warn']='切换状态为空';
    }elseif($transport == false){
        $json['warn']='没有此条转运信息';
    }else{
        if($status == '切为收运中' or $status == '切为已收运' ){
            if($status == '切为收运中'){
                $word = "收运中";
            }else{
                $word = "已收运";
                //将数据自动统计到中catalogCount中
                $transportCatalogSql = mysql_query("select distinct catalogId from transportCatalog where transportId = '$id' ");
                while($array = mysql_fetch_array($transportCatalogSql)){
                    $Catalog = query("Catalog"," id = '$array[catalogId]' ");
                    $catalogCount = query("catalogCount"," catalogType = '$Catalog[type]' ");//判断危废大类是否存在
                    $weight = mysql_fetch_array(mysql_query("select sum(weightSteelyard) as total from transportCatalog where catalogId = '$array[catalogId]' and transportId = '$id' "));//已收运吨数
                    if(!empty($catalogCount['id'])){
                        //修改数据
                        $weightCom = $weight['total'] + $catalogCount['collectionWeight'];
                        mysql_query("update catalogCount set
							collectionWeight = '$weightCom',
							updateTime = '$time' where id = '$catalogCount[id]' ");
                    }else{
                        //添加数据
                        $idCount = suiji();
                        mysql_query(" insert into catalogCount
							(id,catalogType,collectionWeight,updateTime,time)
							values
							('$idCount','$Catalog[type]','$weight[total]','$time','$time')"
                        );
                    }
                }
            }
            $bool = mysql_query("update transport set
			  state = '$word',
			  updateTime = '$time' where id = '{$id}' ");
            if($bool){
                $_SESSION['warn'] = "切换成功";
                $json['warn'] = 2;
            }else{
                $json['warn'] = "切换失败";
            }
        }else{
            $json['warn'] = "切换失败";
        }
    }
    /********转运需求-本次转运废物新增**************************************/
}elseif($_GET['type'] == "transportCatalogEdit"){
    //赋值
    $id = $post['transportCatalogId'];//转运需求危废小类id
    $transportId = $post['transportId'];//转运id
    $CatalogTypeSelect = $post['CatalogType'];//废物类别
    $CatalogIndustrySelect = $post['CatalogIndustry'];//废物来源
    $catalogCodeId = $post['CatalogCode'];//废物代码
    $weightClient = $post['weightClient'];//客户评估重量
    $weightSpot = $post['weightSpot'];//现场评估重量
    $weightSteelyard = $post['weightSteelyard'];//过磅重量
    $physicalState = $post['physicalState'];//物理状态
    $packing = $post['packing'];//废物包装要求
    $stackingArea = $post['stackingArea'];//废物实际储存区域
    $transport = query("transport", " id = '$transportId' ");
    $buycar = query("buycar", " id = '$transport[buycarId]' ");
    $kehu = query("kehu", " khid = '$transport[khid]'");
    $transportCatalog = query("transportCatalog", " id = '$id' ");
    //判断
    if(!power("转运需求")){
        $json['warn'] = "权限不足";
    }elseif(empty($transportId)){
        $json['warn'] = "转运需求id为空";
    }elseif(empty($transport['id'])){
        $json['warn'] = "未找到此转运需求";
    }elseif(empty($buycar['id'])){
        $json['warn'] = "合同id为空";
    }elseif(empty($kehu['khid'])){
        $json['warn'] = "客户id为空";
    }elseif(!empty($id) and empty($transportCatalog['id'])){
        $json['warn'] = "该转运记录不存在";
    }else{
        $update = "";
        //如果有转运需求编辑权限
        if($adDuty['transportEdit'] == "是"){
            //危险废物编码
            $Catalog = query("Catalog", " id = '$catalogCodeId' ");
            //计算是否超量
            $out = mysql_fetch_array(mysql_query("select sum(weightSteelyard) as total from transportCatalog where buycarId = '$transport[buycarId]' and transportId != '$transportId' "));//之前已经完成的转运需求过磅的总重量
            $now = mysql_fetch_array(mysql_query("select sum(weightClient) as total from transportCatalog where buycarId = '$transport[buycarId]' and transportId = '$transportId' "));//本次转运需求客户评估总重量
            $all = $out['total'] + $now['total'] + $weightClient;//已经录入的总重量（之前过磅的总重量加上本次客户评估总重量），再加上本次的危废重量
            if(empty($CatalogTypeSelect)){
                $json['warn'] = "请选择废物类别";
            }elseif(empty($CatalogIndustrySelect)){
                $json['warn'] = "请选择废物行业";
            }elseif(empty($catalogCodeId)){
                $json['warn'] = "请选择废物代码";
            }elseif(Repeat(" transportCatalog where transportId = '$transportId' and catalogId = '$catalogCodeId ' ","id",$id)){
                $json['warn'] = "此危废小类已存在";
            }elseif(empty($weightClient)){
                $json['warn'] = "客户评估吨数为空";
            }elseif($weightClient < $weightSteelyard){
                $json['warn'] = "过磅重量超过客户总重量";
            }elseif($buycar['weight'] < $weightClient){
                $json['warn'] = "客户评估重量超过合同总重量";
            }elseif($weightClient < $weightSpot){
                $json['warn'] = "现场评估重量不能超过客户总重量";
            }elseif(empty($id)){//新增
                if($all > $buycar['weight']){
                    $json['warn'] = "您本次提交的分量超过了合同的总重量".($all - $buycar['weight'])."吨";
                }else{
                    $id = suiji();
                    //判断超没超过吨数
                    $bool = mysql_query(" insert into transportCatalog
                        (id,khid,transportId,buycarId,catalogId,catalogCode,weightClient,physicalState,packing,stackingArea,updateTime,time)
                        values
                        ('$id','$kehu[khid]','$transportId','$buycar[id]','$catalogCodeId','$Catalog[code]','$weightClient',physicalState,'$packing','$stackingArea','$time','$time')"
                    );
                    if($bool){
                        LogText("转运需求",$Control['adid'],"管理员{$Control['adname']}为转运需求（ID号：{$transportId}）新增了危废小类，危废代码：{$Catalog['code']}，客户评估吨数：{$weightClient}");
                        $_SESSION['warn'] = "本次转运废物新增成功";
                        $json['warn'] = 2;
                    }else{
                        $json['warn'] = "本次转运废物新增失败";
                    }
                }
            }else{//更新
                $all -= $transportCatalog['weightClient'];//扣除本转运需求危废小类已保存在数据库中的客户评估重量（因为$all累加了本记录从前端传回来最新的重量）
                if($all > $buycar['weight']){
                    $json['warn'] = "您本次提交的现场评估重量超过了合同的总重量".($all - $buycar['weight'])."吨";
                }else{
                    $update .= "
					catalogId = '$catalogCodeId',
					catalogCode = '$Catalog[code]',
					weightClient = '$weightClient',
					physicalState = '$physicalState',
					packing = '$packing',
					stackingArea = '$stackingArea',
					";
                    $finger = 1;
                }
                if(!empty($id)){
                    //如果有现场重量评估权限
                    if($adDuty['transportWeightSpot'] == "是"){
                        $update .= "
					weightSpot = '$weightSpot',
					";
                        $finger = 1;
                    }
                    //如果有过磅权限
                    if($adDuty['transportWeightSteelyard'] == "是"){
                        $update .= "
					weightSteelyard = '$weightSteelyard',
					";
                        $finger = 1;
                    }
                }
                //如果本转运需求小类有信息需要更新
                if($finger == 1){
                    $bool = mysql_query(" update transportCatalog set
				{$update}
				updateTime = '$time' where id = '$id' ");
                    if($bool){
                        LogText("转运需求",$Control['adid'],"管理员{$Control['adname']}为转运需求（ID号：{$transportId}）修改了危废小类，危废代码：{$Catalog['code']}");
                        $_SESSION['warn'] = "本次转运废物修改成功";
                        $json['warn'] = 2;
                    }else{
                        $json['warn'] = "本次转运废物修改失败";
                    }
                }
            }
        }
    }
    /********转运需求-本次转运废物查询**************************************/
}elseif($_GET['type'] == "searchTransportCatalog"){
    //赋值
    $id = $post['transportCatalogId'];//本次转运小类id
    $transportId = $post['transportId'];//转运id
    $transport = query("transport", " id = '$transportId'");//转运表
    //判断
    if(!power("转运需求")){
        $warn = "权限不足";
    }elseif(empty($transportId)){
        $warn = "转运id号为空";
    }elseif(empty($transport['id'])){
        $warn = "未找到此转运需求";
    }elseif(empty($id)){
        //新增转运需求
        if($adDuty['transportEdit'] == "是"){
            $catalogType = RepeatSelect("Catalog where own = '是' ","type","CatalogType","select","--选择--","");
            $catalogIndustry = "<select name='CatalogIndustry' class='select'><option value=''>--选择--</option></select>";
            $catalogCode = "<select name='CatalogCode' class='select'><option value=''>--选择--</option></select>";
            $weightClient = "<input name='weightClient' class='text TextPrice'/>&nbsp;吨";
            $weightSpot = $weightSteelyard = "未设置";
            $physicalState = "<input name='physicalState' class='text'/>";
            $packing  =  "<input name='packing' class='text '/>";
            $stackingArea = "<input name='stackingArea' class='text '/>";
            $finger = 2;
        }else{
            $warn = "您没有编辑权限";
        }
    }
    else{
        $transportCatalog = query("transportCatalog", " id = '$id'");
        $Catalog = query("Catalog", " id = '$transportCatalog[catalogId]' ");
        if($adDuty['transportEdit'] == "是"){
            $catalogType = RepeatSelect("Catalog where own = '是' ","type","CatalogType","select","--选择--",$Catalog['type']);
            $catalogIndustry = RepeatSelect("Catalog where own = '是' and type = '$Catalog[type]' ","industry","CatalogIndustry","select","--选择--",$Catalog['industry']);
            $catalogCode = IDSelect("Catalog where own = '是' and type = '$Catalog[type]' and industry = '$Catalog[industry]' ","CatalogCode","select","id","code","--选择--",$Catalog['id']);
            $weightClient = "<input name='weightClient' class='text TextPrice' value='$transportCatalog[weightClient]' />&nbsp;吨";
            $physicalState = "<input name='physicalState' class='text' value='$transportCatalog[physicalState]' />";
            $packing  =  "<input name='packing' class='text ' value='$transportCatalog[packing]'/>";
            $stackingArea = "<input name='stackingArea' class='text ' value='$transportCatalog[stackingArea]'/>";
            $finger = 2;
        }else{
            $catalogType = $Catalog['type'];
            $catalogIndustry = $Catalog['industry'];
            $catalogCode = $Catalog['code'];
            $weightClient = $transportCatalog['weightClient']."&nbsp;吨";
            $physicalState =$transportCatalog['physicalState'];
            $packing  = $transportCatalog['packing'];
            $stackingArea = $transportCatalog['stackingArea'];
        }
        if($adDuty['transportWeightSpot'] == "是"){
            $weightSpot = "<input name='weightSpot' class='text TextPrice' value='$transportCatalog[weightSpot]' />&nbsp;吨";
        }else{
            $weightSpot = $transportCatalog['weightSpot'];
        }
        if($adDuty['transportWeightSteelyard'] == "是"){
            $weightSteelyard = "<input name='weightSteelyard' class='text TextPrice' value='$transportCatalog[weightSteelyard]' />&nbsp;吨";
        }else{
            $weightSteelyard = $transportCatalog['weightSteelyard'];
        }
    }
    $json = array(
        "finger" => $finger,
        "warn" => $warn,
        "catalogType" => $catalogType,
        "catalogIndustry" => $catalogIndustry,
        "catalogCode" => $catalogCode,
        "weightClient" => $weightClient,
        "weightSpot" => $weightSpot,
        "weightSteelyard" => $weightSteelyard,
        "physicalState" => $physicalState,
        "packing" => $packing,
        "stackingArea" => $stackingArea
    );
    /********合同管理-新增更新合同管理信息信息**************************************/
}elseif($_GET['type'] == "orderEdit"){
    //赋值
    $khid = $post['khid'];//客户ID
    $kehu = query('kehu',"khid = '$khid' ");
    $money = $post['money'];//'金额
    $num = $post['orderNum'];//转运次数
    $weight = $post['orderWeight'];//转运重量
    $pact = $post['packSupplement'];//'补充
    $id = $post['adOrderId'];//订单ID
    $standard = $post['orderStandard'];//标准合同
    $addressMxId = $post['kehuAddress'];//合同详细地址id
    $startTime = $post['year1']."-".$post['moon1']."-".$post['day1'];//合同生效日期
    $endTime = $post['year2']."-".$post['moon2']."-".$post['day2'];//合同结束日期
    //合同详细地址
    $address = query("address"," id = '{$addressMxId}' ");
    $region = query("region"," id = '$address[RegionId]' ");
    $addressMx = $region['province'].$region['city'].$region['area'].$address['AddressMx'];
    //判断
    if(!power('合同管理')){
        $json['warn'] = "权限不足";
    }elseif($adDuty['orderEdit'] != '是'){
        $json['warn'] = "您没有合同编辑权限";
    }elseif(empty($khid)){
        $json['warn'] = "客户ID不能为空";
    }elseif(empty($kehu)){
        $json['warn'] = "客户不存在";
    }elseif(empty($money)){
        $json['warn'] = "金额不能为空";
    }elseif(preg_match($CheckPrice,$money) == 0){
        $json['warn'] = "金额格式不正确";
    }elseif(empty($num)){
        $json['warn'] = "转运次数不能为空";
    }elseif(preg_match($CheckInteger,$num) == 0){
        $json['warn'] = "收运次数必须为正整数";
    }elseif(empty($weight)){
        $json['warn'] = "转运总重量不能为空";
    }elseif(empty($standard)){
        $json['warn'] = "请选择合同是否是标准合同";
    }elseif(empty($addressMx)){
        $json['warn'] = "请选择，如过没有地址，请先新建地址";
    }elseif(empty($post['year1'])){
        $json['warn'] = "请选择合同生效日期年份";
    }elseif(empty($post['moon1'])){
        $json['warn'] = "请选择合同生效日期月份";
    }elseif(empty($post['day1'])){
        $json['warn'] = "请选择合同生效日期日份";
    }elseif(empty($post['year2'])){
        $json['warn'] = "请选择合同结束日期年份";
    }elseif(empty($post['moon2'])){
        $json['warn'] = "请选择合同结束日期月份";
    }elseif(empty($post['day2'])){
        $json['warn'] = "请选择合同结束日期日份";
    }elseif(empty($id)){
        //生成合同id
        $id = rand(1000000000,9999999999);
        while(mysql_num_rows(mysql_query(" select id from buycar where id = '$id' ")) > 0){
            $id = rand(1000000000,9999999999);
        }
        //生成合同名称
        $name = $kehu['CompanyName'].date('Y');
        $n = mysql_num_rows(mysql_query(" select id from buycar where name = '$name' "));
        if($n > 0){
            $json['warn'] = "此客户已经有了此合同";
        }else{
            $identifier = "WSXS-SC-".date("Ymd");
            $buyCarNew = query("buycar"," identifier like '%$identifier%' order by time desc");
            if(empty($buyCarNew['id'])){
                $identifier .= '001';
            }else{
                $identifierSub = substr($buyCarNew['identifier'], -3);
                $identifierNum = $identifierSub+1;
                if($identifierNum >= 1 && $identifierNum < 10){
                    $identifier .= "00{$identifierNum}";
                } elseif( $identifierNum < 100 && $identifierNum >= 10){
                    $identifier .= "0{$identifierNum}";
                }else {
                    $identifier .= $identifierNum;
                }
            }
            $bool = mysql_query(" insert into buycar
			(id,khid,adid,name,companyName,standard,identifier,num,weight,money,addressMx,pact,sign,startTime,endTime,updateTime,time)
			values
			('$id','$khid','$Control[adid]','$name','$kehu[CompanyName]','$standard','$identifier','$num','$weight','$money','$addressMx','$pact','编辑','$startTime','$endTime','$time','$time')");
            if($bool){
                LogText("合同管理",$Control['adid'],"管理员{$Control['adname']}新增了合同（合同名称：{$name}，合同ID：{$id}）");
                $_SESSION['warn'] = "新增成功";
                $json['warn'] = 2;
            }else{
                $json['warn'] = "新增失败";
            }
        }
    }else{
        $buyCar = query("buycar"," id = '$id' ");
        if($buyCar['id'] != $id){
            $json["warn"] = "未找到本记录！";
        }elseif($buyCar['adid'] != $Control['adid']){
            $json["warn"] = "这不是您的合同";
        }elseif($buyCar['sign'] != '编辑'){
            $json["warn"] = "此合同处于非编辑状态";
        }else{
            $bool = mysql_query("update buycar set
			num = '$num',
			weight = '$weight',
			money = '$money',
			pact = '$pact',
			standard = '$standard',
		    addressMx = '$addressMx',
			startTime = '$startTime',
			endTime = '$endTime',
			updateTime = '$time' where id = '$id' ");
            if($bool){
                LogText("订单管理",$Control['adid'],"管理员{$Control['adname']}修改订单信息（公司名称：{$CompanyName}，客户ID：{$id}）");
                $_SESSION['warn'] = "修改成功";
                $json['warn'] = 2;
            }else{
                $_SESSION['warn'] = "修改失败";
            }
        }
    }
    $json['href'] = root."control/adOrderMx.php?id=".$id;
    /********合同管理-客户经理提交合同审核**************************************/
//提交到初审
}elseif($_GET['type'] == "salesmanAuditing"){
    //赋值
    $orderId = $post['orderId'];//合同id号
    $order = query("buycar"," id = '$orderId' ");
    //查询是否存在危废种类
    $buycarCatalogSql = query("buycarCatalog"," buycarId = '{$orderId}' ");
    $buycarCatalog = mysql_fetch_assoc(" select sum(weight) as count from buycarCatalog where buycarId = '{$orderId}' ");
    //判断
    if(!power("合同管理")){
        $json['warn'] = "权限不足";
    }elseif(empty($orderId)){
        $json['warn'] = "合同号为空";
    }elseif(empty($order['id'])){
        $json['warn'] = "未找到该合同";
    }elseif($order['adid'] != $Control['adid']){
        $json['warn'] = "这不是您的合同";
    }elseif($buycarCatalogSql == false){
        $json['warn'] = "该合同暂时没有危险废物种类，请先添加有危险废物种类".$buycarCatalogSql['id'];
    }elseif($buycarCatalog['count'] > $order['weight']){
        $json['warn'] = "合同危险废物小类的总超过合同里面的总重量";
    }elseif($order['auditingOne'] == "审核中"){
        $json['warn'] = "该合同正在审核中";
    }else{
        $bool = mysql_query(" update buycar set
            auditingOne = '审核中',
            sign = '审核中',
            updateTime = '$time' where id = '$orderId' ");
        if($bool){
            //业务员的wxOpenid
            $admin = query("admin"," adid = '$order[adid]' ");
            ReturnUploadMessage($order['identifier'],"已提交合同审核",$order['companyName'],"提交合同审核时间：{$time}",$admin['wxOpenid']);
            //查一审的wxOpenid
            $adDuty = query("adDuty","orderAuditing = '初审' ");
            $Auditing = query("admin"," duty = '$adDuty[id]' ");
            ReturnUploadMessage4($order['identifier'],"初审",$order['companyName'],'请尽快进行初审审核',$Auditing['wxOpenid']);
            buycarAuditing($orderId,$text);
            $json['warn'] = 2;
            $text = $adDuty['department']."-".$adDuty['name']."-".$Control['adname']."发起了合同名为“{$order['name']}”的审核申请";
            $_SESSION['warn'] = "合同审核申请提交成功";
        }else{
            $json['warn'] = "合同审核申请提交失败";
        }
        $json['warn'] = 2;
        $_SESSION['warn'] = "合同审核申请提交成功";
    }
    /********合同审核状态**************************************/
}elseif($_GET['type'] == "auditingAdd" ){
    //1.合同正常申请流程，2.作废流程
    //赋值
    $text = $post['auditing'];//审核意见
    $state = $post['auditingBtn'];//审核状态
    $id = $post['adOrderId'];//合同ID
    $order = query("buycar", " id = '$id' ");
    $revokeArray = $post['revokeArray'];//驳回的审核等级
    $type = array("已通过","未通过");
    //业务员
    $admin = query("admin"," adid = '$order[adid]' ");
    //初审
    $adDutyOne = query("adDuty","orderAuditing = '初审' ");
    $one = query("admin"," duty = '$adDutyOne[id]' ");
    //二审
    $adDutyTwo = query("adDuty","orderAuditing = '二审' ");
    $two = query("admin"," duty = '$adDutyTwo[id]' ");
    //三审
    $adDutyThree = query("adDuty","orderAuditing = '三审' ");
    $three = query("admin"," duty = '$adDutyThree[id]' ");
    //四审
    $adDutyFour = query("adDuty","orderAuditing = '三审' ");
    $four = query("admin"," duty = '$adDutyFour[id]' ");
    //判断
    if(!power("合同管理")){
        $json['warn'] = "您没有修改的权限";
    }elseif(empty($state)){
        $json['warn'] = "审核状态为空";
    }elseif(empty($id)){
        $json['warn'] = "合同号为空";
    }elseif(empty($order['id'])){
        $json['warn'] = "没有找到该合同号";
    }elseif($state == "未通过" and !in_array($revokeArray,array("业务员","初审","二审","三审"))){
        $json['warn'] = "未指定驳回到哪一个级别";
    }
    elseif($adDuty['orderAuditing'] == "初审" ){
        if(in_array($order['auditingOne'],$type)){
            $json['warn'] = "您已经审核过了";
        }else{
            $sql = "
            auditingOneText = '$text',
            ";
            if($state == "已通过"){
                $sql .= "
                auditingOne = '$state',
                auditingTwo = '审核中',
                ";
                if($order['sign'] == '审核中'){
                    //一审消息
                    ReturnUploadMessage($order['identifier'],"初审通过",$order['companyName'],"初审通过时间:{$time}",$Control ['wxOpenid']);
                    //二审消息
                    ReturnUploadMessage4($order['identifier'],"初审通过",$order['companyName'],'请技术副总尽快进行二审审核',$two['wxOpenid']);
                }
            }
            //驳回
            if($revokeArray == "业务员"){
                $sql .= "
				auditingOne = '未通过',
				sign = '编辑',
				";
                if($order['sign'] == '审核中'){
                    ReturnUploadMessage($order['identifier'],"初审已驳回",$order['companyName'],'请业务员尽快处理相关合同',$admin['wxOpenid']);
                }
            }
        }
    }elseif($adDuty['orderAuditing'] == "二审"){
        if(in_array($order['auditingTwo'],$type)){
            $json['warn'] = "您已经审核过了";
        }else{
            $sql = "
            auditingTwoText = '$text',
            ";
            if($state == "已通过"){
                $sql .= "
                auditingTwo = '$state',
                auditingThree = '审核中',
                ";
                if($order['sign'] == '审核中'){
                    //二审消息
                    ReturnUploadMessage($order['identifier'],"二审通过",$order['companyName'],"二审通过时间:{$time}",$Control['wxOpenid']);
                    //三审消息
                    ReturnUploadMessage4($order['identifier'],"二审通过",$order['companyName'],'请运营副总尽快进行三审审核',$three['wxOpenid']);
                }
            }
            //驳回
            if($revokeArray == "业务员"){
                $sql .= "
				auditingOne = '未通过',
				auditingTwo = '未通过',
				sign = '编辑',
				";
                if($order['sign'] == '审核中'){
                    ReturnUploadMessage($order['identifier'],"二审已驳回",$order['companyName'],'请业务员尽快处理相关合同',$admin['wxOpenid']);
                }
            }elseif($revokeArray == "初审"){
                $sql .= "
				auditingOne = '审核中',
				auditingTwo = '未通过',
				";
                if($order['sign'] == '审核中'){
                    ReturnUploadMessage($order['identifier'],"二审已驳回",$order['companyName'],'请市场部主管尽快处理相关合同',$one['wxOpenid']);
                }
            }
        }
    }
    elseif($adDuty['orderAuditing'] == "三审"){
        if(in_array($order['auditingThree'],$type)){
            $json['warn'] = "您已经审核过了";
        }else{
            $sql = "
            auditingThreeText = '$text',
            ";
            if($state == "已通过"){
                $sql .= "
                auditingThree = '$state',
                auditingFour = '审核中',
                ";
                if($order['sign'] == '审核中'){
                    //三审消息
                    ReturnUploadMessage($order['identifier'],"三审通过",$order['companyName'],"三审通过时间:{$time}",$Control['wxOpenid']);
                    //四审消息
                    ReturnUploadMessage4($order['identifier'],"三审通过",$order['companyName'],'请总经理尽快进行四审审核',$four['wxOpenid']);
                }
            }
            //驳回
            if($revokeArray == "业务员"){
                $sql .= "
				auditingOne = '未通过',
				auditingTwo = '未通过',
				auditingThree = '未通过',
				sign = '编辑',
				";
                if($order['sign'] == '审核中'){
                    ReturnUploadMessage($order['identifier'],"三审已驳回",$order['companyName'],'请业务员尽快处理相关合同',$admin['wxOpenid']);
                }
            }elseif($revokeArray == "初审"){
                $sql .= "
				auditingOne = '审核中',
				auditingTwo = '未通过',
				auditingThree = '未通过',

				";
                if($order['sign'] == '审核中'){
                    ReturnUploadMessage($order['identifier'],"三审已驳回",$order['companyName'],'请市场部主管尽快处理相关合同',$one['wxOpenid']);
                }
            }elseif($revokeArray == "二审"){
                $sql .= "
				auditingTwo = '审核中',
				auditingThree = '未通过',
				";
                if($order['sign'] == '审核中'){
                    ReturnUploadMessage($order['identifier'],"三审已驳回",$order['companyName'],'请技术副总尽快处理相关合同',$two['wxOpenid']);
                }
            }
        }
    }elseif($adDuty['orderAuditing'] == "四审"){
        if(in_array($order['auditingFour'],$type)){
            $json['warn'] = "您已经审核过了";
        }else{
            $sql = "
            auditingFourText = '$text',
            ";
            if($order['sign'] == '审核中'){
                //通过
                if($state == "已通过"){
                    $sql .= "
					auditingFour = '$state',
					approvalTime = '$time',
					sign = '已通过',
					";
                    //四审消息
                    ReturnUploadMessage($order['identifier'],"四审通过",$order['companyName'],"四审通过时间:{$time}",$Control['wxOpenid']);
                    //通知业务员
                    ReturnUploadMessage($order['identifier'],"审核成功",$order['companyName'],"审核成功时间:{$time}",$admin['wxOpenid']);
                    //通知综合部主管和助理
                    $adDutySql = mysql_query("SELECT id FROM adDuty where department = '综合管理部' and d name in ('综合管理部主管','综合助理') ");
                    while($array = mysql_fetch_array($adDutySql)){
                        $adminSql = mysql_query("SELECT wxOpenid FROM admin where duty = '$array[id]' ");
                        while($adminArray = mysql_fetch_array($adminSql)){
                            ReturnUploadMessage($order['identifier'],"审核成功",$order['companyName'],"请综合部尽快安排打印合同",$adminArray['wxOpenid']);
                        }
                    }
                }
            }elseif($order['sign'] == '作废中'){
                $sql .= "
					auditingFour = '$state',
					approvalTime = '$time',
					sign = '已作废',
					";
            }
            //驳回
            if($revokeArray == "业务员"){
                $sql .= "
				auditingOne = '未通过',
				auditingTwo = '未通过',
				auditingThree = '未通过',
				auditingFour = '未通过',
				sign = '编辑',
				";
                if($order['sign'] == '已通过'){
                    ReturnUploadMessage($order['identifier'],"四审已驳回",$order['companyName'],'请业务员尽快处理相关合同',$admin['wxOpenid']);
                }
            }elseif($revokeArray == "初审"){
                $sql .= "
				auditingOne = '审核中',
				auditingTwo = '未通过',
				auditingThree = '未通过',
				auditingFour = '未通过',
				";
                if($order['sign'] == '已通过'){
                    ReturnUploadMessage($order['identifier'],"四审已驳回",$order['companyName'],'请市场部主管尽快处理相关合同',$one['wxOpenid']);
                }
            }elseif($revokeArray == "二审"){
                $sql .= "
				auditingTwo = '审核中',
				auditingThree = '未通过',
				auditingFour = '未通过',
				";
                if($order['sign'] == '已通过'){
                    ReturnUploadMessage($order['identifier'],"四审已驳回",$order['companyName'],'请技术副总尽快处理相关合同',$two['wxOpenid']);
                }
            }elseif($revokeArray == "三审"){
                $sql .= "
				auditingThree = '审核中',
				auditingFour = '未通过',
				";
                if($order['sign'] == '已通过'){
                    ReturnUploadMessage($order['identifier'],"四审已驳回",$order['companyName'],'请运营副总尽快处理相关合同',$three['wxOpenid']);
                }
            }
        }


    }else{
        $json['warn'] = "您没有审批资格";
    }
    //返回
    if(empty($json['warn'])){
        $bool = mysql_query("
            update buycar set
            {$sql}
        updateTime = '$time' where id = '$id' ");
        if($bool){
            $json['warn'] = 2;
            if($state == "已通过"){
                $result = $state;
            }else{
                $result = "驳回到：".$revokeArray;
            }
            $text = $adDuty['department']."-".$adDuty['name']."-".$Control['adname']."对合同“{$order['name']}”进行了“{$adDuty['orderAuditing']}”，审核结果：“{$result}”";
            buycarAuditing($id,$text);
            $_SESSION['warn'] = "审核意见提交成功";
        }else{
            $json['warn'] = "审核意见提交失败";

        }
    }
    /********合同管理-撤销合同审核**************************************/
}elseif($_GET['type'] == "revokeOrder" ){
    //赋值
    $orderId = $post['orderId'];
    $order = query("buycar"," id = '$orderId' ");
    //判断
    if(!power("合同管理")){
        $json['warn'] = "权限不足";

    }elseif(empty($orderId)){
        $json['warn'] = "合同号为空";
    }elseif(empty($order['id'])){
        $json['warn'] = "没有找到该合同";
    }else{
        if($adDuty['orderAuditing'] == "初审"){
            $auditingType = "auditingOne";//本级的审核权限
            $upperLevel = "auditingTwo";//更高一级的审核权限
        }elseif($adDuty['orderAuditing'] == "二审"){
            $auditingType = "auditingTwo";
            $upperLevel = "auditingThree";
        }elseif($adDuty['orderAuditing'] == "三审"){
            $auditingType = "auditingThree";
            $upperLevel = "auditingFour";
        }elseif($adDuty['orderAuditing'] == "四审"){
            $auditingType = "auditingFour";
            $upperLevel = "";
        }else{
            $json['warn'] = '您没有审核权限';
        }
        if(empty($json['warn'])){
            if($order[$upperLevel] == "已通过"){
                $json['warn'] = "上级审核已通过，不能撤销";
            }else{
                if(empty($upperLevel)){
                    $u = " sign = '审核中', ";
                }else{
                    $u = " {$upperLevel} = '', ";
                }
                $bool = mysql_query(" update buycar set
				{$auditingType} = '审核中',
				{$u}
				updateTime = '$time' where id = '$orderId' ");
                if($bool){
                    $json['warn'] = 2;
                    $text = $adDuty['department']."-".$adDuty['name']."-".$Control['adname']."撤销了自己的{$adDuty['orderAuditing']}结果。合同名称：{$order['name']}";
                    buycarAuditing($orderId,$text);
                    $_SESSION['warn'] = "合同审核撤销成功";

                }else{
                    $json['warn'] = "合同审核撤销失败";
                }
            }
        }
    }
    /******************合同管理-危险废物转运信息-新增**************************************************************/
}elseif($_GET['type'] == "buycarCatalogEdit"){
    //赋值
    $buycarId = $post['buycarId'];//合同id
    $name = $post['catalogName'];//废物名称
    $type = $post['CatalogType'];//废物类型
    $industry = $post['CatalogIndustry'];//废物行业来源
    $code = $post['CatalogCode'];//废物代码
    $packing = $post['catalogPacking'];//废物包装要求
    $buycar = query("buycar", " id = '$buycarId' ");
    $Catalog = query("Catalog", " id = '$code' ");
    $buycarCatalog = mysql_fetch_assoc(mysql_query(" select sum(weight) as count from buycarCatalog where buycarId = '{$buycarId}' "));
    if(!power("合同管理")){
        $json['warn'] = "权限不足";
    }elseif($adDuty['orderEdit'] != "是"){
        $json['warn'] = "您没有合同修改权限";
    }elseif(empty($buycarId)){
        $json['warn'] = "合同id号为空";
    }elseif(empty($buycar['id'])){
        $json['warn'] = "未找到此合同";
    }elseif(empty($name)){
        $json['warn'] = "请输入危险废物名称";
    }elseif(Repeat("buycarCatalog where buycarId = '$buycarId' and name = '$name' ","id",$id)){
        $json['warn'] = "本合同已存在此危废名称";
    }elseif(empty($type)){
        $json['warn'] = "请选择废物类型";
    }elseif(empty($industry)){
        $json['warn'] = "请选择废物来源";
    }elseif(empty($code)){
        $json['warn'] = "请选择废物代码";
    }elseif(empty($packing)){
        $json['warn'] = "请输入危险废物包装求";
    }else{
        $id = suiji();
        $bool = mysql_query(" insert into buycarCatalog
            (id,khid,buycarId,CatalogId,catalogCode,name,packing,time)
            values
            ('$id','$buycar[khid]','$buycarId','$code','$Catalog[code]','$name','$packing','$time')
            ");
        if($bool){
            $json['warn'] = 2;
            $_SESSION['warn'] = "转运危险废物信息新增成功";
            LogText("转运危险废物录入",$Control['adid'],"{$Control['adname']}新增了转运危险废物（危险废物编号：{$CatalogId}）");
        }else{
            $_SESSION['warn'] = "转运危险废物信息新增失败";
        }
    }
    /******************合同管理-危险废物转运信息-删除**************************************************************/
}elseif($_GET['type'] == "buycarCatalogDelete"){
    //赋值
    $id = $post['buycarCatalogId'];//合同转运需求id号
    $buycarCatalog = query("buycarCatalog","id = '$id' ");
    $buycar = query('buycar',"id = '$buycarCatalog[buycarId]'");
    if(!power("合同管理")){
        $json['warn'] = "权限不足";
    }elseif($adDuty['orderEdit'] != "是"){
        $json['warn'] = "您没有合同修改权限";
    }elseif(empty($id)){
        $json['warn'] = "合同危险废物id号为空";
    }elseif($buycarCatalog['id'] != $id){
        $json['warn'] = "没有该合同危险废物信息";
    }elseif($buycar['adid'] != $Control['adid']){
        $json['warn'] = "这不是你的合同";
    }elseif($buycar['sign'] != '编辑'){
        $json["warn"] = "此合同处于非编辑状态";
    }else{
        $bool = mysql_query(" delete from buycarCatalog where id = '$id' ");
        if($bool){
            $json['warn'] = 2;
            $_SESSION['warn'] = "删除成功";
            LogText("转运危险废物删除",$Control['adid'],"{$Control['adname']}删除了转运危险废物（危险废物编号：{$id}）");

        }else{
            $json['warn'] = "删除失败";
        }
    }
    /********转运管理-撤销收运状态**************************************/
}elseif($_GET['type'] == "revokeTransportation" ){
    //赋值
    $id = $post['transportId'];
    $transport = query("transport"," id = '$id' ");
    //判断
    if(!power("转运需求")){
        $json['warn'] = "权限不足";
    }elseif(empty($id)){
        $json['warn'] = "转运需求id为空";
    }elseif(empty($transport['id'])){
        $json['warn'] = "没有找到该转运需求";
    }else{
        $bool = mysql_query(" update transport set
				state = '待收运',
				updateTime = '$time' where id = '$id' ");
        if($bool){
            $json['warn'] = 2;
            $_SESSION['warn'] = "撤销状态成功";
        }else{
            $json['warn'] = "撤销状态失败";
        }
    }
    /******************合同管理-合同的签入签出**************************************************************/
}elseif($_GET['type'] == "signOrder"){
    //赋值
    $orderId = $post['orderId'];//合同id
    $order = query("buycar"," id = '$orderId' ");
    $signWord = $post['signWord'];//合同状态
    $admin = query("admin"," adid = '$order[adid]' ");//业务员
    if(!power("合同管理")){
        $json['warn'] = "权限不足";
    }elseif($adDuty['OrderStatus'] != "是"){
        $json['warn'] = "您没有修改合同状态权限";
    }else{
        if($signWord == "签出合同"){
            $word = "已签出";
            ReturnUploadMessage($order['identifier'],"已签出",$order['companyName'],"签出时间:{$time}",$admin['wxOpenid']);//业务员
            mysql_query("update buycar set
            signInDay = '$time',
            updateTime = '$time' where id = '$orderId' ");
            mysql_query("update transport set
            state = '收运中',
            updateTime = '$time' where buycarId = '$orderId' ");
        }elseif($signWord == "签入合同"){
            $word = "已签入";
            ReturnUploadMessage($order['identifier'],"已签入",$order['companyName'],"签入时间:{$time}",$admin['wxOpenid']);//业务员
            $adDutySql = mysql_query("SELECT id FROM adDuty where department = '财务部' ");
            //推送给财务所有人员
            while($array = mysql_fetch_array($adDutySql)){
                $adminSql = mysql_query("SELECT wxOpenid FROM admin where duty = '$array[id]' ");
                while($adminArray = mysql_fetch_array($adminSql)){
                    ReturnUploadMessage($order['identifier'],"已签入",$order['companyName'],"请财务人员尽快开票",$adminArray['wxOpenid']);//开票消息推送
                }
            }
            $update = '';
            //负责人
            $admin = query('admin',"adid = '$order[adid]'");
            //合同签约时甲方名称
            $kehu = query('kehu',"khid = '$order[khid]'");
            //合同地址
            $address = query('address',"id = '$kehu[AddressId]'");
            //合同主体
            $pact = query("content", "type = '内部资料' and classify = '合同' and title = '危险废物安全处置合同' ");
            $ArticleMx = ArticleMx($pact['id']);
            //字段串联
            $update .= "
			adName = '$admin[adname]',
			companyName = '$kehu[CompanyName]',
			addressId = '$kehu[AddressId]',
			addressName = '$address[AddressName]',
			addressTel = '$address[AddressTel]',
			addressMx = '$address[AddressMx]',
			regionId= '$address[RegionId]',
			body = '$ArticleMx',
			signOutDay = '$time',
			";
        }else{
            $json['warn'] = "非法执行指令";
        }
        if(empty($json['warn'])){
            $bool = mysql_query("update buycar set
                sign = '$word',
                {$update}
            updateTime = '$time' where id = '$orderId' ");
            if($bool){
                $json['warn'] = 2;
                $_SESSION['warn'] = "合同状态修改成功";
                LogText("签入签出合同",$Control['adid'],"{$Control['adname']}修改了合同状态（合同编号：{$order['id']}，合同状态：{$order['sign']}->{$word}）");
            }else{
                $json['warn'] = "合同状态修改失败";
            }
        }

    }
    /******************合同管理-合同综合部合同作废**************************************************************/
}elseif($_GET['type'] == "signVoid"){
    //赋值
    $orderId = $post['orderId'];//合同id
    $order = query("buycar"," id = '$orderId' ");
    $signVoid =  $post['signVoid'];//合同作废原因
    if(!power("合同管理")){
        $json['warn'] = "权限不足";
    }elseif($adDuty['OrderStatus'] != "是"){
        $json['warn'] = "您没有修改合同状态权限";
    }elseif(empty($orderId)){
        $json['warn'] = "合同id为空";
    }elseif(empty($order)){
        $json['warn'] = "未找到此合同";
    }elseif(empty($signVoid)){
        $json['warn'] = "您没有填写合同作废的原因";
    }else{
        $bool = mysql_query("update buycar set
            sign = '作废',
            updateTime = '$time' where id = '$orderId' ");
        if($bool){
            $json['warn'] = 2;
            $_SESSION['warn'] = "合同作废修改成功";
            $text = $adDuty['department']."-".$adDuty['name']."-".$Control['adname']."发起了合同名为“{$order['name']}”的合同作废"."作废原因：{$signVoid }";
            buycarAuditing($orderId,$text);
            LogText("签入签出合同",$Control['adid'],"{$Control['adname']}修改了合同状态（合同编号：{$order['id']}，合同状态：{$order['sign']}->{$word}）");
        }else{
            $json['warn'] = "合同作废修改失败";
        }

    }

    /******************合同管理-合同申请提交作废流程**************************************************************/
}elseif($_GET['type']=='voidApply'){
    //赋值
    $void = $_GET['void'];
    $orderId = $post['orderId'];//合同id
    $order = query("buycar"," id = '$orderId' ");
    $signVoid =  $post['signVoid'];//合同申请作废原因
    if(!power("合同管理")){
        $json['warn'] = "权限不足";
    }elseif(empty($orderId)){
        $json['warn'] = "合同id为空";
    }elseif(empty($order)){
        $json['warn'] = "未找到此合同";
    }elseif(empty($signVoid)){
        $json['warn'] = "您没有填写合同作废的原因";
    }elseif(!empty($void)){
        //客户经理提交申请
        if($void == 'apply'){
            if($order['adid'] != $Control['adid']){
                $json['warn'] = "该合同不属于您，您无法提交申请";
            }else{
                $bool = mysql_query("update buycar set
				sign = '作废中',
				auditingOne = '审核中',
				updateTime = '$time' where id = '$orderId' ");
                if($bool){
                    $json['warn'] = 2;
                    $_SESSION['warn'] = "合同作废申请提交成功";
                    $text = $adDuty['department']."-".$adDuty['name']."-".$Control['adname']."发起了合同名为“{$order['name']}”的合同作废申请"."作废申请原因：{$signVoid }";
                    buycarAuditing($orderId,$text);
                    LogText("签入签出合同",$Control['adid'],"{$Control['adname']}修改了合同状态（合同编号：{$order['id']}，合同状态：{$order['sign']}->{$word}）");
                }else{
                    $json['warn'] = "合同作废申请提交失败";
                }
            }
        }
    }














    /******************合同管理-新增开票记录**************************************************************/
}elseif($_GET['type'] == "invoiceOrder"){
    //赋值
    $ticketNumber = $post['number'];//开票号
    $ticketType	 = $post['type'];//开票类型
    $money = $post['money'];//开票金额
    $password = $post['password'];//管理登录密码
    $orderId = $post['invoiceId'];//管理合同id号
    $buycar = query('buycar'," id = '$orderId' ");
    //判断
    if(!power('合同管理')){
        $json['warn']='权限不足';
    }elseif($adDuty['invoice'] != '是'){
        $json['warn']='您没有开票的权限';
    }elseif(empty($orderId)){
        $json['warn']='合同id号为空';
    }elseif($buycar == false){
        $json['warn']='未找到此合同';
    }elseif(empty($ticketNumber)){
        $json['warn']='请填写开票号';
    }elseif(empty($ticketType)){
        $json['warn']='请选择开票类型';
    }elseif(empty($money)){
        $json['warn']='请填写开票金额';
    }elseif(preg_match($CheckPrice,$money) == 0){
        $json['warn']='开票金额必须为数字，可精确到小数点后两位';
    }elseif(empty($password)){
        $json['warn']='请填写登录密码';
    }elseif($Control['adpas'] != $password){
        $json['warn']='登录密码错误';
    }else{
        $moneyAll = $buycar['invoice'] + $money;
        $bool = mysql_query("update buycar set
		invoice = '$moneyAll',
		updateTime = '$time' where id = '$orderId' ");
        if($bool){

            $id = suiji();
            mysql_query(" insert into buycarInvoice (id,buycarId,num,type,money,time)
			values ('$id','$orderId','$ticketNumber','$ticketType','$money','$time')");
            $json['warn'] = 2;
            $_SESSION['warn'] = "开票成功";
        }else{
            $json['warn'] = "开票失败";
        }
    }
}elseif($_GET['type'] == "urgentOrder"){
    //赋值
    $urgent = $post['urgent'];//紧急程度
    $password = $post['password'];//管理登录密码
    $id = $post['urgentId'];//转运需求id号
    $transport = query('transport'," id = '$id' ");
    $buycar = query('buycar'," id = '$transport[buycarId]'");
    //判断
    if(!power('客户管理')){
        $json['warn']='权限不足';
    }elseif($adDuty['clientEdit'] != '是'){
        $json['warn']='您没有修改转运需求紧急程度的权限';
    }elseif($Control['adid'] != $buycar['adid']) {
        $json['warn']='这不是你的客户';
    }elseif(empty($id)){
        $json['warn']='转运需求id为空';
    }elseif($transport == false){
        $json['warn']='未找到此转运需求';
    }elseif(empty($urgent)){
        $json['warn']='请填选择转运需求紧急程度';
    }elseif(empty($password)){
        $json['warn']='请填写登录密码';
    }elseif($Control['adpas'] != $password){
        $json['warn']='登录密码错误';
    }else{
        $bool = mysql_query("update transport set
		urgent = '$urgent',
		updateTime = '$time' where id = '$id' ");
        if($bool){
            $json['warn'] = 2;
            $_SESSION['warn'] = "转运需求紧急程度设置成功";
        }else{
            $json['warn'] = "转运需求紧急程度设置失败";
        }
    }
    /**********查询客户*********************/
}elseif(isset($post['kehuNameKey'])){
    //赋值
    $key = $post['kehuNameKey'];
    $ProjectSql = mysql_query(" select * from kehu where CompanyName like '%$key%' order by time desc ");
    //判断
    if(mysql_num_rows($ProjectSql) == 0){
        $json['html'] = "<li>没有找到该公司</li>";
    }else{
        while($array = mysql_fetch_array($ProjectSql)){
            $json['html'] .= "<li ProjectId='{$array['khid']}'>{$array['CompanyName']}</li>";
        }
    }
    /*************客户管理-客户导出***************************/
}elseif($_GET['type'] == 'exportClient'){
    //赋值
    $password = $post['password'];//登录密码
    $Client = $_GET['Client'];
    if(empty($password)){
        $json['warn'] = "请填写密码";
    }elseif($adDuty['name'] != "超级管理员" and $adDuty['name'] != "客户经理"){
        $json['warn'] = "您不是超级管理员或者客户经理，无法具有导出客户的权限";
    }elseif($password != $Control['adpas']){
        $json['warn'] = "管理员登录密码输入错误";
    }elseif(!empty($Client)and $adDuty['name'] == "超级管理员"){
        //市场业务报表
        if($Client == 'adidClient'){
            $json['herf'] = "adidClient";
            //客户导出
        }elseif($Client == 'exportClient'){
            $json['herf'] = "exportClient";
            //市场业务年报表
        }elseif($Client == 'adidClientYear'){
            $json['herf'] = "adidClientYear";
        }elseif($Client == 'adidClientFollow'){
            $json['herf'] = "adidClientFollow";
        }
        $json['warn'] = 2;
        //客户经理只能导出自己的客户
    }elseif($adDuty['name'] == "客户经理"){
        $_SESSION['exportClient']['sql'] = " where adid = '$Control[adid]' or followType = '公客' ";
        $json['warn'] = 2;
    }
    /*************合同管理-合同导出***************************/
}elseif($_GET['type'] == 'exportOrder'){
    //赋值
    $password = $post['password'];//登录密码
    $order = $_GET['Order'];
    if(empty($password)){
        $json['warn'] = "请填写密码";
    }elseif($adDuty['name'] != "超级管理员" and $adDuty['name'] != "综合管理部主管"){
        $json['warn'] = "您不是超级管理员或者综合管理部主管，无法具有导出合同的权限";
    }elseif($password != $Control['adpas']){
        $json['warn'] = "登录密码输入错误";
    }else{
        if(!empty($order)){
            //串联查询语句
            if($order == 'order'){
                $json['herf'] = "exportOrder";
            }elseif($order == 'endTime'){
                $json['herf'] = "OrderEndTime";
            }
            $json['warn'] = 2;
        }else{
            $json['warn'] = "没有相关数据";
        }
    }
    /*************转运需求管理-转运导出***************************/
}elseif($_GET['type'] == 'exportTransport'){
    //赋值
    $password = $post['password'];//登录密码
    $transportExcel = $_GET['transport'];
    if(empty($password)){
        $json['warn'] = "请填写密码";
    }elseif($adDuty['name'] != "超级管理员" and $adDuty['name'] != "储运部主管"){
        $json['warn'] = "您不是超级管理员或者储运部主管，无法具有导出合同的权限";
    }elseif($Control['adpas'] != $password){
        $json['warn'] = "登录密码错误";
    }elseif(!empty($transportExcel)){
        //汇总表
        if($transportExcel == 'allTransport'){
            $json['herf'] = "allTransport";
            //按危废小类导出
        }elseif($transportExcel == 'samllTransport'){
            $json['herf'] = "samllTransport";
            //转运需求表
        }elseif($transportExcel == 'transport'){
            $json['herf'] = "exportTransport";
            //按企业导出的表
        }elseif($transportExcel == 'businessTransport'){
            $json['herf'] ="businessTransport";
            //按车辆导出的表
        }elseif($transportExcel == 'carTransport'){
            $json['herf'] ="carTransport";
        }
        $json['warn'] = 2;
    }else{
        $json['warn'] = '没有需要导出数据';
    }
    /*************出库管理管理-出库导出***************************/
}elseif($_GET['type'] == 'exportDepotOut'){
    //赋值
    $password = $post['password'];//登录密码
    $depotOutExcel = $_GET['depotOutExcel'];
    if(empty($password)){
        $json['warn'] = "请填写密码";
    }elseif($adDuty['name'] != "超级管理员" and $adDuty['name'] != "储运部主管"){
        $json['warn'] = "您不是超级管理员或者储运部主管，无法具有导出合同的权限";
    }elseif($Control['adpas'] != $password){
        $json['warn'] = "登录密码错误";
    }elseif(!empty($depotOutExcel)){
        //汇总表
        if($depotOutExcel == 'depotOutAll'){
            $json['herf'] = "depotOutAll";
            //按堆放区域导出的表
        }elseif($depotOutExcel == 'depotOutArea'){
            $json['herf'] ="depotOutArea";
        }
        $json['warn'] = 2;
    }else{
        $json['warn'] = '没有需要导出数据';
    }
    /*************财务管理- 收支平衡***************************/
}elseif($_GET['type'] == 'exportProfit'){
    //赋值
    $password = $post['password'];//登录密码
    $depotOutExcel = $_GET['depotOutExcel'];
    if(empty($password)){
        $json['warn'] = "请填写密码";
    }elseif($adDuty['name'] != "超级管理员" and $adDuty['name'] != "财务主管"){
        $json['warn'] = "您不是超级管理员或者财务主管，无法具有收支平衡导出的权限";
    }elseif($Control['adpas'] != $password){
        $json['warn'] = "登录密码错误";
    }else{
        //收支平衡数据
        $json['warn'] = 2;
    }
    /********查询危险废物********************************************/
//根据废物类别查询行业来源
}elseif($_GET['type'] == "getCatalogIndustry"){
    //赋值
    $type = $post['one'];//废物类别
    //查询
    $json['two'] = RepeatOption("Catalog where type = '$type' and own = '是' ","industry","-行业来源-","");
//根据行业来源查询废物代码
}elseif($_GET['type'] == "getCatalogCode"){
    //赋值
    $type = $post['one'];//废物类别
    $industry = $post['two'];//行业来源
    //查询
    $json['three'] = IdOption("Catalog where type = '$type' and industry = '$industry' and own = '是' ","id","code","--危废代码--","");
    /********危废出库--新增/修改**************************************/
}elseif($_GET['type'] == "depotOutEdit"){
    //赋值
    $id = $post['depotOutId'];//出库表的主键
    $CatalogType = $post['CatalogType'];//危险废物类型
    $CatalogIndustry = $post['CatalogIndustry'];//废物行业来源
    $CatalogCode = $post['CatalogCode'];//废物代码
    $Catalog = query('Catalog',"id = '$CatalogCode'");
    $weight = $post['DepotOutWeight'];//重量
    $company = $post['DepotOutCompany'];//目的公司
    $car = $post['DepotOutCarCode'];//车牌号
    $stackingArea = $post['stackingArea'];//堆放区域
    $outTime = $post['year1']."-".$post['moon1']."-".$post['day1'];//出库日期
    $beforeTime = time() - 60;//当前时间之前的一分钟
    //判断
    if(empty($CatalogType)){
        $json['warn'] = "请选择危险废物名录类型";
    }elseif(empty($CatalogIndustry)){
        $json['warn'] = "请选择行业来源";
    }elseif(empty($CatalogCode)){
        $json['warn'] = "请选择危废代码";
    }elseif(empty($Catalog)){
        $json['warn'] = "未找到这个危废小类";
    }elseif(empty($weight)){
        $json['warn'] = "新填写危废重量";
    }elseif(preg_match($CheckPrice,$weight) == 0){
        $json['warn'] = "重量必须为数字，可精确到小数点后两位";
    }elseif(empty($company)){
        $json['warn'] = "新填写目的公司";
    }elseif(empty($car)){
        $json['warn'] = "新填写车牌号";
    }elseif(empty($stackingArea)){
        $json['warn'] = "新填写堆放区域";
    }elseif(empty($post['year1'])){
        $json['warn'] = "请选择出库日期年份";
    }elseif(empty($post['moon1'])){
        $json['warn'] = "请选择出库日期月份";
    }elseif(empty($post['day1'])){
        $json['warn'] = "请选择出库日期日份";
    }elseif(Repeat("depotOut where catalogId = '$CatalogCode' and weight = '$weight' and company = '$company' and car = '$car' and updateTime > '$beforeTime' ","id",$id)){
        $json['warn'] = "本出库记录已经存在，请勿重复提交";
    }elseif(empty($id)){
        //出库一般指的当月数据
        $id = suiji();
        $bool = mysql_query(" insert into depotOut (id,catalogId,catalogCode,weight,company,car,stackingArea,outTime,updateTime,time)
            values ('$id','$Catalog[id]','$Catalog[code]','$weight','$company','$car','$stackingArea','$outTime','$time','$time') ");
        if($bool){
            //将数据自动统计到中catalogCount中
            $Catalog = query("Catalog"," id = '$Catalog[id]' ");
            $catalogCount = query("catalogCount"," catalogType = '$Catalog[type]' ");//查询危废大类
            //修改数据
            $weightCom = $weight + $catalogCount['depotOutWghit'];
            //本月储存量 = 往月储存量+本月收运-本月移除
            //判断是否是第录入数据是否是一个月
            if(empty($catalogCount['lastMoonWghit']) and empty($catalogCount['newMoonWghit']) ){
                //本月储存量
                $newMoonWghit = $catalogCount['collectionWeight'] - $weightCom;
            }else{
                $newMoonWghit = $catalogCount['lastMoonWghit'] + $catalogCount['collectionWeight'] - $weightCom;
            }
            //修改catalogCount数据
            mysql_query("update catalogCount set
			depotOutWghit  = '$weightCom',
			newMoonWghit  = '$newMoonWghit',
			updateTime = '$time' where id = '$catalogCount[id]' ");
            $_SESSION['warn'] = "新建成功".$catalogCount['lastMoonWghit'];
            $json['warn'] = 2;
        }else{
            $json['warn'] = "新建失败";
        }
    }else{
        $depotOut = query("depotOut"," id = '$id' ");
        if($depotOut['id'] != $id){
            $json['warn'] = "未找到该信息";
        }else{
            //取出原有出库数据
            $depotOut = query("depotOut"," id = '$id' ");
            $bool = mysql_query(" update depotOut set
			catalogId = '$Catalog[id]',
			catalogCode = '$Catalog[code]',
			weight = '$weight',
			company = '$company',
			car = '$car',
			stackingArea = '$stackingArea',
			outTime = '$outTime',
			updateTime = '$time' where id = '$id' ");
            if($bool){
                //将数据自动统计到中catalogCount中
                $Catalog = query("Catalog"," id = '$Catalog[id]' ");
                $catalogCount = query("catalogCount"," catalogType = '$Catalog[type]' ");//查询危废大类
                //判断重量
                if($depotOut['weight'] != '$weight'){
                    $num = $weight-$depotOut['weight'];
                    //本月移除量
                    $weightCom = $catalogCount['depotOutWghit']+$num;
                    //本月储存量
                    $newMoonWghit = $catalogCount['lastMoonWghit'] + $catalogCount['collectionWeight'] - $weightCom;
                }
                //修改catalogCount数据
                mysql_query("update catalogCount set
			depotOutWghit  = '$weightCom',
			newMoonWghit  = '$newMoonWghit',
			updateTime = '$time' where id = '$catalogCount[id]' ");
                $_SESSION['warn'] = "更新成功" ;
                $json['warn'] = 2;
            }else{
                $json['warn'] = "更新失败";
            }
        }
    }
    $json['href'] = root."control/adDepotOutMx.php?id=".$id;
    /*************合同管理-转运查询***************************/
}elseif($_GET['type'] == 'checkState'){
    //赋值
    $state = $post['status'];//转运状态
    $sql = " ";
    //串联查询语句
    if(!empty($state) and $state != '查看全部'){
        $sql = " state = '$state' ";
    }else{
        $sql = "";
    }
    //返回
    $_SESSION['stateSql'] = $sql;
    $json['warn'] = "2";
    /********批量处理**************************************/
}elseif(isset($post['PadWarnType'])){
    //赋值
    $type = $post['PadWarnType'];//执行指令
    $pas = $post['Password'];//密码
    $x = 0;
    //判断
    if(empty($type)){
        $json['warn'] = "执行指令为空";
    }elseif(empty($pas)){
        $json['warn'] = "请输入管理员登录密码";
    }elseif($pas != $Control['adpas']){
        $json['warn'] = "管理员登录密码输入错误";
    }elseif($type == "industryDelete"){
        $Array = $post['IndustryList'];
        if($adDuty['name'] != "超级管理员"){
            $json['warn'] = "只有超级管理员才能删除客户";
        }elseif(empty($Array)){
            $json['warn'] = "您一个行业都没有选择呢";
        }else{
            foreach($Array as $id){
                //查询本行业基本信息
                $kehuIndustry = query("kehuIndustry","  id= '$id' ");
                $kehu_num = mysqli_num_rows(mysql_query("select * from kehu where industry = '$kehuIndustry[id]'"));
                if($kehu_num == 0){
                    //最后删除本行业基本资料
                    if(mysql_query("delete from kehuIndustry where id = '$id' ")){
                        //添加日志
                        LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}删除行业（行业名称：{$kehuIndustry['name']}，行业ID：{$kehuIndustry['id']}）");
                        $x++;
                    }
                }
                $_SESSION['warn'] = "删除了{$x}个行业";
                $json['warn'] = 2;
            }
        }
    }elseif($type == "ClientDelete"){
        $Array = $post['ClientList'];
        if($adDuty['name'] != "超级管理员"){
            $json['warn'] = "只有超级管理员才能删除客户";

        }elseif(empty($Array)){
            $json['warn'] = "您一个客户都没有选择呢";
        }else{
            foreach($Array as $id){
                //查询本客户基本信息
                $kehu = query("kehu"," khid = '$id' ");
                //最后删除本客户基本资料
                mysql_query("delete from kehu where khid = '$id'");
                //添加日志
                LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}删除了客户（公司名称：{$kehu['CompanyName']}，客户ID：{$kehu['khid']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个客户";
            $json['warn'] = 2;
        }
        //删除转运需求
    }elseif($type == "oaR61257702vH"){
        $Array = $post['TransportList'];
        if($adDuty['name'] != "超级管理员"){
            $json['warn'] = "只有超级管理员才能删除转运需求";

        }elseif(empty($Array)){
            $json['warn'] = "请选择至少一个转运需求";
        }else{
            foreach($Array as $id){
                $transport = query("transport"," id = '$id' ");
                mysql_query("delete from transport where id = '$id'");
                unlink("../../{$transport['ico']}");
                //添加日志
                LogText("转运需求管理",$Control['adid'],"管理员{$Control['adname']}删除了转运需求（账号信息：{$transport['khid']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个转运需求";
            $json['warn'] = 2;
        }
        //删除联系地址
    }elseif($type == "iFY61492050lW"){
        $Array = $post['ClientAddressList'];
        if($adDuty['name'] != "超级管理员"){
            $json['warn'] = "只有超级管理员才能删除";
        }elseif(empty($Array)){
            $json['warn'] = "请选择至少一个联系地址";
        }else{

            foreach($Array as $id){
                $address = query("address"," id = '$id' ");
                mysql_query("delete from address where id = '$id'");
                unlink("../../{$address['ico']}");
                //添加日志
                LogText("地址管理",$Control['adid'],"管理员{$Control['adname']}删除了联系地址（账号信息：{$address['khid']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个联系地址";
            $json['warn'] = 2;
        }
        //删除订单信息
    }elseif($type == "ULi61340637OI"){
        $Array = $post['OrderList'];
        if($adDuty['name'] != "超级管理员"){
            $json['warn'] = "只有超级管理员才能删除";
        }elseif(empty($Array)){
            $json['warn'] = "请选择至少一个合同信息";
        }else{
            foreach($Array as $id){
                $buyCar = query("buycar"," id = '$id' ");
                mysql_query("delete from buycar where id = '$id'");
                unlink("../../{$buyCar['ico']}");
                //添加日志
                LogText("合同管理",$Control['adid'],"管理员{$Control['adname']}删除了转运需求（账号信息：{$buyCar['khid']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个合同信息";
            $json['warn'] = 2;
        }
        //删除跟进看记录
    }elseif($type == "tDh61490531kL"){
        $Array = $post['ClientFollowList'];
        if($adDuty['name'] != "超级管理员"){
            $json['warn'] = "只有超级管理员才能删除礼物";
        }elseif(empty($Array)){
            $json['warn'] = "请选择至少一个合同信息";
        }else{
            foreach($Array as $id){
                $kehuFollow = query("kehuFollow"," id = '$id' ");
                mysql_query("delete from kehuFollow where id = '$id'");
                unlink("../../{$kehuFollow['ico']}");

                //添加日志
                LogText("礼物管理",$Control['adid'],"管理员{$Control['adname']}删除了跟进记录（账号信息：{$kehuFollow['khid']}）");
                $x++;
            }
            $_SESSION['warn'] = "删除了{$x}个跟进记录";
            $json['warn'] = 2;
        }
    }else{
        $json['warn'] = "未知执行指令";
    }
}
/********返回**************************************/

echo json_encode($json);
?>