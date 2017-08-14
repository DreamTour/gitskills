<?php
include "adfunction.php";
$type = $get['type']; //操作类型
if($ControlFinger == 2){
    $json['warn'] = $ControlWarn;
    /******************商品管理-根据商品一级分类调取二级分类**************************************************************/
}elseif($type=="queryOne"){
    $one = $post['goodsTypeOneIdGetTwoId'];
    $json['two'] = IdOption(" goodsTypeTwo where goodsTypeOneId = '$one' and xian = '显示' order by list ","id","name","--二级分类--","");
    /******************商品一级分类-新增或更新**************************************************************/
}elseif($type == "adGoodsTypeOneMx"){
    //赋值
    $id = $post['goodsTypeOneNameId']; //id
    $name = $post['goodsTypeOneName'];  //分类名称
    $list = $post['goodsTypeOneNameList'];  //排序号
    $xian = $post['goodsTypeOneNameShow']; //显示状态
    //判断
    if(empty($name)){
        $json['warn'] = "分类名称不能为空";
    }elseif(empty($list)){
        $json['warn'] = "请输入排序号";
    }elseif(preg_match($CheckInteger,$list) == 0){
        $json['warn'] = "排序号必须为正整数";
    }elseif(empty($xian)){
        $json['warn'] = "请选择显示状态";
    }elseif(empty($id)){
        $id = suiji();
        $bool = mysql_query(" insert into goodsTypeOne (id,name,list,xian,updateTime,time)
		values
		('$id','$name','$list','$xian','$time','$time') ");
        if($bool){
            $_SESSION['warn'] = "商品一级分类新增成功";
            $json['warn'] = 2;
            $json['href'] = root."control/adGoodsTypeOneMx.php?id=".$id;
        }else{
            $_SESSION['warn'] = "商品一级分类新增失败";
        }
    }else{
        $bool = mysql_query(" update goodsTypeOne set
		name = '$name',
		list = '$list',
		xian = '$xian',
	    updateTime = '$time' where id = '$id' ");
        if($bool){
            $_SESSION['warn'] = "商品一级分类更新成功";
            $json['warn'] = 2;
            $json['href'] = root."control/adGoodsTypeOneMx.php?id=".$id;
        }else{
            $json['warn'] = "商品一级分类更新失败";
        }
    }
    /******************商品二级分类-新增或更新**************************************************************/
}elseif($type == "adGoodsTypeTwoMx"){
    //赋值
    $oneId = $post['goodsTypeOne']; //一级id
    $name = $post['goodsTypeTwoName']; //分类名称
    $list = $post['goodsTypeTwoList']; //排序号
    $xian = $post['goodsTypeTwoShow']; //显示状态
    $id = $post['goodsTypeTwoId']; //id
    if(empty($oneId)){
        $json['warn'] = "请选择商品一级分类";
    }elseif(empty($name)){
        $json['warn'] = "请输入二级分类名称";
    }elseif(empty($xian)){
        $json['warn'] = "请输入显示状态";
    }elseif(Repeat(" goodsTypeTwo where goodsTypeOneId = '$oneId' and name = '$name' ","id",$id)){
        $json['warn'] = "相同一级商品分类下存在此二级分类名称";
    }elseif(empty($id)){
        $id = suiji();
        $bool = mysql_query(" insert into goodsTypeTwo values ('$id','$oneId','$name','$list','$xian','$time','$time') ");
        if($bool){
            $_SESSION['warn'] = "商品二级分类新增成功";
            $json['warn'] = 2;
        }else{
            $_SESSION['warn'] = "商品二级分类新增失败";
        }
    }else{
        $goodsTypeTwo = query("goodsTypeTwo","id = '$id' ");
        if(empty($goodsTypeTwo['id'])){
            $json['warn'] = "未找到此商品的二级分类";
        }else{
            $bool = mysql_query(" update goodsTypeTwo set
			goodsTypeOneId = '$oneId',
			name = '$name',
			list = '$list',
			xian = '$xian',
		    UpdateTime = '$time' where id = '$id' ");
            if($bool){
                if($goodsTypeTwo['goodsTypeOneId'] != $oneId){
                    mysql_query(" update goods set
		    		goodsTypeOneId = '$oneId',
		    		updateTime = '$time' where goodsTypeTwoId = '$id' ");
                }
                $_SESSION['warn'] = "更新成功";
                $json['warn'] = 2;
            }else{
                $json['warn'] = "更新失败";
            }
        }
    }
    $json['href'] = root."control/adGoodsTypeTwoMx.php?id=".$id;
    /******************商品管理-删除商品一级分类**************************************************************/
}elseif($type == "delGoodsTypeOne"){
    $Array = $post['GoodsTypeOneList'];
    $pas = md5($post['Password']);//密码
    $x = 0;
    if($adDuty['name'] != "超级管理员"){
        $json['warn'] = "只有超级管理员才能删除商品一级分类";
    }elseif(empty($Array)){
        $json['warn'] = "请选择要删除的商品一级分类";
    }elseif($pas != $Control['adpas']){
        $json['warn'] = "管理员登录密码输入错误";
    }else{
        foreach($Array as $id){
            $goodsTypeOne = query("goodsTypeOne"," id = '$id' ");
            $goodsTypeTwoNum = mysql_num_rows(mysql_query(" select * from goodsTypeTwo where goodsTypeOneId = '$id' "));
            if($goodsTypeTwoNum != 0){
                if(empty($warn)){
                    $a = "";
                }else{
                    $a = "，";
                }
                $warn .= $a."“{$goodsTypeOne['name']}”";
            }else{
                mysql_query("delete from goodsTypeOne where id = '$id'");
                //添加日志
                LogText("商品一级分类管理",$Control['adid'],"管理员{$Control['adname']}删除了商品一级分类（账号信息：{$goods['AccountNumber']}）");
                $x++;
            }
        }
        if(!empty($warn)){
            $wa = "如下一级分类旗下存在二级分类：".$warn;
        }
        $_SESSION['warn'] = "删除了{$x}个商品一级分类。".$wa;
        $json['warn'] = 2;
    }
    /******************商品管理-删除商品二级分类**************************************************************/
}elseif($type == "delGoodsTypeTwo"){
    $Array = $post['adGoodsTypeTwoList'];
    $pas = md5($post['Password']);//密码
    $x = 0;
    if($adDuty['name'] != "超级管理员"){
        $json['warn'] = "只有超级管理员才能删除商品二级分类";
    }elseif(empty($Array)){
        $json['warn'] = "请选择要删除的商品二级分类";
    }elseif($pas != $Control['adpas']){
        $json['warn'] = "管理员登录密码输入错误";
    }else{
        foreach($Array as $id){
            mysql_query("delete from goodsTypeTwo where id = '$id'");
        }
        $_SESSION['warn'] = "删除了商品二级分类成功。";
        $json['warn'] = 2;
    }
    /******************商品管理-新增修改商品明细**************************************************************/
}elseif($type == "upGoods"){
    //赋值
    $goodsName = $post['goodsName']; //商品名称
    $goodsTypeOneId = $post['goodsTypeOneId'];//一级分类
    $goodsTypeTwoId = $post['goodsTypeTwoId'];//二级分类
    $summary = $post['summary'];//摘要
    $promotion = $post['promotion'];//商品促销信息
    $agio = $post['agio']; //分销折扣
    $parameter = $post['parameter'];//商品参数详情
    $price = $post['price'];//价格
    $priceMarket = $post['priceMarket'];//市场价格
    $salesVolume = $post['salesVolume'];//销量
    $scareBuying = $post["scareBuying"];//是否为抢购商品
    $sellingToday = $post["sellingToday"];//是否为今日热销商品
    $publicGood = $post['publicGood'];  //是否为公益商品
    $number = $post['number'];  //领取次数
    $list = $post['GoodsList'];//排序号
    $xian = $post['GoodsShow'];//状态
    $id = $post['goodsid'];//id
    //判断
    if(empty($goodsName)){
        $json['warn'] = "请输入商品名称";
    }elseif(Repeat(" goods where name = '$name' ","id",$id)){
        $json['warn'] = "商品名称存在重复";
    }elseif (empty($goodsTypeOneId)) {
        $json['warn'] = "请选择商品一级分类";
    }elseif (empty($goodsTypeTwoId)) {
        $json['warn'] = "请选择商品二级分类";
    }elseif(empty($price)){
        $json['warn'] = "请输入商品单价";
    }elseif(preg_match($CheckPrice,$price) == 0){
        $json['warn'] = "商品单价格式不正确";
    }elseif(empty($priceMarket)){
        $json['warn'] = "请输入商品市场价";
    }elseif(preg_match($CheckPrice,$priceMarket) == 0){
        $json['warn'] = "商品市场价价格式不正确";
    }elseif(empty($list)){
        $json['warn'] = "请选择排序号";
    }elseif(preg_match($CheckInteger,$list) == 0){
        $json['warn'] = "排序号必须为正整数";
    }elseif(empty($xian)){
        $json['warn'] = "请输入显示状态";
    }elseif(empty($id)){
        $suiji = suiji();
        $bool = mysql_query(" insert into goods (id,goodsTypeOneId,goodsTypeTwoId,name,summary,promotion,agio,parameter,scareBuying,price,priceMarket,salesVolume,sellingToday,publicGood,number,ico,list,xian,updateTime,time)
		values ('$suiji','$goodsTypeOneId','$goodsTypeTwoId','$goodsName','$summary','$promotion','$agio','$parameter','$scareBuying','$price','$priceMarket','$salesVolume','$sellingToday','$publicGood','$number','','$list','$xian','$time','$time') ");
        if($bool){
            $_SESSION['warn'] = "商品新增成功";
            $json['warn'] = 2;
            $json['href'] = "{$adroot}adGoodsMx.php?id={$suiji}";
        }else{
            $json['warn'] = "商品新增失败";
        }
    }else{
        $goods = query("goods"," id = '$id' ");
        if($goods['id'] != $id){
            $json['warn'] = "未找到本商品";
        }else{
            $bool = mysql_query(" update goods set
			goodsTypeOneId = '$goodsTypeOneId',
			goodsTypeTwoId = '$goodsTypeTwoId',
			name = '$goodsName',
			summary = '$summary',
			promotion = '$promotion',
			agio = '$agio',
			parameter = '$parameter',
			scareBuying ='$scareBuying',
			price = '$price',
			priceMarket = '$priceMarket',
		    salesVolume = '$salesVolume',
		    sellingToday = '$sellingToday',
		    publicGood = '$publicGood',
		    number = '$number',
			list = '$list',
		    xian = '$xian',
		    UpdateTime = '$time' where id = '$id' ");
            if($bool){
                $_SESSION['warn'] = "商品更新成功";
                $json['warn'] = 2;
                $json['href'] = "{$adroot}adGoodsMx.php?id={$id}";
            }else{
                $json['warn'] = "商品更新失败";
            }
        }
    }
    /******************商品规格-新增或更新**************************************************************/
}elseif(isset($post['specName']) and isset($post['priceMarket'])){
    //赋值
    $GoodsId = $post['GoodsId'];//商品id
    $goods = query("goods"," id = '$GoodsId' ");
    $specName = $post['specName'];//规格名称
    $specPrice = $post['specPrice'];//规格单价
    $priceMarket = $post['priceMarket'];//规格市场价
    $specNumber = $post['specNumber'];//库存
    $skuNum = $post['skuNumber'];//货号
    $skuSeat = $post['skuSeat'];//货位信息
    $factory = $post['factory'];//货位信息
    $specId = $post['specId'];//规格id
    if(!power("商品管理")){
        $json['warn'] = "权限不足";
    }elseif(empty($GoodsId)){
        $json['warn'] = "商品id号为空";
    }elseif($goods['id'] != $GoodsId){
        $json['warn'] = "未找到此商品";
    }elseif(empty($specName)){
        $json['warn'] = "请输入规格名称";
    }elseif(empty($specPrice)){
        $json['warn'] = "请输入规格单价";
    }elseif(preg_match($CheckPrice ,$specPrice) == 0){
        $json['warn'] = "规格单价格式有误";
    }elseif(empty($priceMarket)){
        $json['warn'] = "请输入市场单价";
    }elseif(preg_match($CheckPrice ,$priceMarket) == 0){
        $json['warn'] = "市场价格式有误";
    }elseif(Repeat(" goodsSku where goodsId = '$GoodsId' and name = '$specName' ","id",$specId)){
        $json['warn'] = "已经存在此商品规格";
    }elseif($specNumber == ""){
        $json['warn'] = "请填写库存,可以为0";
    }elseif(preg_match($CheckInteger,$specNumber) == 0){
        $json['warn'] = "库存必须为正整数";
    }elseif(empty($specId)){
        $specId = suiji();
        $bool = mysql_query(" insert into goodsSku
		  (id,skuNum,goodsId,name,number,salesVolume,price,priceMarket,skuSeat,factory,updateTime,time)
		  values
		  ('$specId','$skuNum','$GoodsId','$specName','$specNumber','$goods[salesVolume]','$specPrice','$priceMarket','$skuSeat','$factory','$time','$time')
		  ");
        if($bool){
            $_SESSION['warn'] = "商品规格新增成功";
            $json['warn'] = 2;
            $json['href'] = "{$adroot}adGoodsMx.php?id={$GoodsId}";
        }else{
            $_SESSION['warn'] = "商品规格新增失败";
        }
    }else{
        $bool = mysql_query(" update goodsSku set
		id = '$specId',
		skuNum = '$skuNum',
		goodsId = '$GoodsId',
		name = '$specName',
		number = '$specNumber',
		price = '$specPrice',
		priceMarket = '$priceMarket',
		skuSeat = '$skuSeat',
		factory = '$factory',
	    updateTime = '$time' where id = '$specId' ");
        if($bool){
            $_SESSION['warn'] = "商品规格更新成功";
            $json['warn'] = 2;
            $json['href'] = "{$adroot}adGoodsMx.php?id={$GoodsId}";
        }else{
            $json['warn'] = "商品规格更新失败";
        }
    }
    /******************删除商品规格**************************************************************/
}elseif($type == "deleteSpecId"){
    $deleteSpecId = $post['deleteSpecId'];
    $num = mysql_fetch_array(mysql_query("select number from goodsSku where id = '$deleteSpecId'"));
    if( $num['number']> 0){
        $json['warn'] = "该商品规格下面还有库存，不可以删除";
    }else{
        mysql_query("delete  from goodsSku where id = '$deleteSpecId' ");
        $_SESSION['warn'] = "删除成功";
        $json['warn'] = 2;
    }
    /******************删除商品信息**************************************************************/
}elseif($type == "delGoods"){
    $Array = $post['goodsList'];
    $pas = md5($post['Password']);//管理员密码
    $x = 0;
    if($adDuty['name'] != "超级管理员"){
        $json['warn'] = "只有超级管理员才能删除商品";
    }elseif(empty($Array)){
        $json['warn'] = "请选择至少一个商品";
    }elseif($pas != $Control['adpas']){
        $json['warn'] = "管理员登录密码输入错误";
    }else{
        foreach($Array as $id){
            $goods = query("goods"," id = '$id' ");
            if (!empty($goods['id'])) {
                //删除商品规格
                mysql_query(" delete from goodsSku where goodsId = '{$goods['id']}' ");
                //删除商品橱窗图
                $goodsWinSql = mysql_query(" select * from goodsWin where goodsId = '{$goods['id']}' ");
                while($goodsWinArray = mysql_fetch_array($goodsWinSql)){
                    //删除商品图片
                    unlink(ServerRoot.$goodsWinArray['src']);
                }
                mysql_query("delete from goodsWin where goodsId = '{$goods['id']}' ");
                //删除商品列表图
                unlink(ServerRoot.$goods['ico']);
                //删除商品明细图
                $articleSql = mysql_query(" select * from article where TargetId = '{$goods['id']}' ");
                while($articleArray = mysql_fetch_array($articleSql)){
                    //删除商品图片
                    unlink(ServerRoot.$articleArray['img']);
                }
                mysql_query("delete from article where TargetId = '{$goods['id']}' ");
                //删除商品基本参数
                mysql_query(" delete from goods where id = '{$goods['id']}' ");
                //添加日志
                LogText("商品管理",$Control['adid'],"管理员{$Control['adname']}删除了一个商品（商品名称：{$goods['name']}，商品ID：{$goods['id']}）");
            }
        }
        $json['warn'] = 2;
        $_SESSION['warn'] = "商品删除成功";
    }
    /******************设置是否为员工**************************************************************/
}elseif($type == "operation"){
    $khid = $post['khid'];
    $kehu = query("kehu","khid = '$khid' ");
    if($adDuty['name'] != "超级管理员"){
        $json['warn'] = "只有超级管理员才能设置是否为员工";
    }elseif(empty($kehu['khid'])){
        $json['warn'] = "参数错误";
    }else{
        if ($kehu['staff'] == "是") {
            mysql_query("UPDATE kehu SET staff='否',updateTime='$time' WHERE khid='$khid' ");
        }else {
            mysql_query("UPDATE kehu SET staff='是',updateTime='$time' WHERE khid='$khid' ");
        }
        $_SESSION['warn']= "设置是否为员工成功";
        $json['warn'] = 2;
    }
    /******************设置vip会员**************************************************************/
}elseif($type == "vipType"){
    $khid = $post['khid'];
    $kehu = query("kehu","khid = '$khid' ");
    if($adDuty['name'] != "超级管理员"){
        $json['warn'] = "只有超级管理员才能设置vip会员";
    }elseif(empty($kehu['khid'])){
        $json['warn'] = "参数错误";
    }else{
        if ($kehu['type'] != "vip会员") {
            $receiveNumber = query("para", "paid = 'receiveNumber' "); //vip领取次数
            mysql_query("UPDATE kehu SET type = 'vip会员', receiveNumber = '$receiveNumber[paValue]',updateTime='$time' WHERE khid='$khid' ");
        }
        $_SESSION['warn']= "设置vip会员成功";
        $json['warn'] = 2;
    }

    /******************批量收货**************************************************************/
}elseif($type == "confirmOrder"){
    //赋值
    $pas = md5($post['Password']);//密码
    $Array = $post['OrderList'];
    //判断
    if(empty($pas)){
        $json['warn'] = "请输入管理员登录密码";
    }elseif($pas != $Control['adpas']){
        $json['warn'] = "管理员登录密码输入错误";
    }else if(strstr($adDuty['Power'],"订单管理") == false){
        $json['warn'] = "权限不足";
    }elseif (empty($Array)) {
        $json['warn'] = "请选择要收货的订单";
    }else{
        foreach($Array as $id){
            $buycar = query("buycar","WorkFlow = '已发货' and id = '$id' ");
            GoodsReceipt($buycar['id']); //收货和执行分销
        }
        $json['warn'] = 2;
        $_SESSION['warn'] = "批量收货操作成功";
    }
    /*************订单管理--修改订单号和物流公司*********************************************/
}else if($type == "sendGoods"){
    //赋值
    $buycarId =  $post['buycarId'];//订单号id
    $shipmentNum = $post['shipmentNum'];//物流单号
    $logisticsName = $post['logisticsName'];//物流公司
    if(!power("订单管理")){
        $json['warn'] = "权限不足";
    }else if(empty($buycarId)){
        $json['warn'] = "订单信息错误";
    }elseif (empty($logisticsName)) {
        $json['warn'] = "请选择物流公司名称";
    }elseif (empty($shipmentNum)) {
        $json['warn'] = "请输入物流单号";
    }else{
        $bool = mysql_query("UPDATE buycar SET
		shipmentNum = '$shipmentNum',
		logisticsName = '$logisticsName',
		WorkFlow='已发货',
		updateTime = '$time'
		WHERE id = '$buycarId' ");
        if($bool){
            $json['warn'] = 2;
            $_SESSION['warn'] = "发货成功";
            LogText("订单管理",$Control['adid'],"管理员{$Control['adname']}执行了订单发货，订单ID：{$buycarId}");
        }else{
            $json['warn'] = "发货失败";
        }
    }
    /*************建议反馈--反馈信息*********************************************/
}else if($_GET['type'] == "feedbackForm" ) {
    $id = $post['adFeedbackId']; //客户ID号
    $feedbackText = $post['feedbackText']; //反馈
    if (strstr($adDuty['Power'], "建议反馈") == false) {
        $json['warn'] = "权限不足";
    } elseif (empty($feedbackText)) {
        $json['warn'] = "请填写反馈";
    } else {
        $feedback = query("talk", " id = '$id' ");
        if ($feedback['id'] != $id) {
            $json['warn'] = "本留言未找到";
        } else {
            $nid = suiji();
            $client = query("kehu", "khid = '$feedback[khid]' ");
            $bool = mysql_query("INSERT INTO talk (id, type, khid, text, time) VALUES ('$nid', '反馈', '$client[khid]', '$feedbackText', '$time') ");
            if ($bool) {
                $_SESSION['warn'] = "反馈成功";
                LogText("建议反馈", $Control['adid'], "管理员{$Control['adname']}反馈了客户（昵称：{$client['wxNickName']}，ID：{$id}）");
                $json['warn'] = 2;
            } else {
                $json['warn'] = "反馈失败";
            }
        }
    }
    $json['href'] = root . "control/adFeedbackMx.php?id=" . $id;
    /******************删除建议反馈**************************************************************/
}elseif($type == "talkDelete"){
    $Array = $post['talkList'];
    $pas = md5($post['Password']);//密码
    $x = 0;
    if($adDuty['name'] != "超级管理员"){
        $json['warn'] = "只有超级管理员才能删除建议反馈";
    }elseif(empty($Array)){
        $json['warn'] = "请选择要删除的建议反馈";
    }elseif($pas != $Control['adpas']){
        $json['warn'] = "管理员登录密码输入错误";
    }else{
        foreach ($Array as $id) {
            //查询本建议反馈基本信息
            $talk = query("talk", " id = '$id' ");
            //删除本建议反馈
            mysql_query("delete from talk where id = '$id'");
            //添加日志
            LogText("系统管理", $Control['adid'], "管理员{$Control['adname']}删除了建议反馈（留言类型：{$talk['type']}，留言id：{$talk['id']}）");
            $x++;
        }
        $_SESSION['warn'] = "删除了{$x}个留言";
        $json['warn'] = 2;
    }
    /******************删除活动报名**************************************************************/
}elseif($type == "enrollDelete"){
    $Array = $post['enrollList'];
    $pas = md5($post['Password']);//密码
    $x = 0;
    if($adDuty['name'] != "超级管理员"){
        $json['warn'] = "只有超级管理员才能删除活动报名";
    }elseif(empty($Array)){
        $json['warn'] = "请选择要删除的活动报名";
    }elseif($pas != $Control['adpas']){
        $json['warn'] = "管理员登录密码输入错误";
    }else{
        foreach ($Array as $id) {
            //查询本活动报名基本信息
            $enroll = query("enroll", " id = '$id' ");
            //删除本活动报名
            mysql_query("delete from enroll where id = '$id'");
            //添加日志
            $client = query("kehu","khid = '$enroll[khid]'");
            $content = query("content","id = '$enroll[contentId]'");
            LogText("系统管理", $Control['adid'], "管理员{$Control['adname']}删除了活动报名（客户昵称：{$client['wxNickName']}，活动：{$content['title']}）");
            $x++;
        }
        $_SESSION['warn'] = "删除了{$x}个活动报名";
        $json['warn'] = 2;
    }
    /******************返回**************************************************************/
}
echo json_encode($json);
?>