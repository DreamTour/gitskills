<?php
include "OpenFunction.php";
$type = $_GET['type'];
if($KehuFinger == 2){
    $json['warn'] = "您未登录";
    /******************修改地址信息*******************/
}else if($type == "mUsInfo"){
    $wxNickName = $post['khNickName'] ; //昵称
    $name = $post['khName']; //姓名
    $wxSex = $post['khSex'] ; //性别
    if (empty($wxNickName)) {
        $json['warn'] = "请输入昵称";
    }elseif (empty($name)) {
        $json['warn'] = "请输入姓名";
    }else if(empty($wxSex)){
        $json['warn'] = "请选择性别";
    }else{
        $bool = mysql_query("UPDATE kehu SET wxSex='$wxSex',wxNickName='$wxNickName',name='$name' WHERE khid ='$kehu[khid]' ");
        if ($bool) {
            $json['warn'] = "资料更新成功";
        }else{
            $json[warn] = "未知错误，资料更新失败";
        }
    }
    /******************修改手机号码*******************/
}else if($type == "mUsTel"){
    $tel = $post['khTel'] ; //昵称
    $verCode = $post['verCode'] ; //验证码
    $result = query("kehu","tel='$tel'");
    if (preg_match($CheckTel, $tel)==0) {
        $json['warn'] = "手机号码输入错误";
    }else if(empty($verCode)){
        $json['warn'] = "请输入验证码";
    }else if($verCode != $_SESSION['Prove']['rand']){ //$_SESSION["yan"]
        $json['warn'] = "验证码输入错误";
    }elseif (!empty($result['tel'])) {
        $json['warn'] = "更新失败,手机号码已经存在";
    }else{
        $bool = mysql_query("UPDATE kehu SET tel='$tel' WHERE khid ='$kehu[khid]' ");
        if ($bool) {
            $_SESSION['warn'] = "手机号码更新成功";
            $json['warn'] = 2;
            $json['href'] = "{$root}m/mUser/mUsInfo.php";
        }else{
            $json[warn] = "未知错误，号码更新失败";
        }
    }
    /******************新增修改收货地址*******************/
}else if($type == "usAddress"){
    $id = $post['adId']; // ID
    $AddressName = $post['adName']; //收货姓名
    $AddressTel = $post['adTel']; //收货号码
    $RegionId = $post['area']; //地区
    $AddressMx = $post['adMx']; //详细地址
    $defaultAd = $post['defaultAd']; //是否默认收货地址
    if (empty($AddressName)) {
        $json['warn'] = "收货姓名不能为空";
    }elseif (preg_match($CheckTel, $AddressTel)==0) {
        $json['warn'] = "手机号码输入错误";
    }elseif (empty($RegionId)) {
        $json['warn'] = "请选择收货地区";
    }elseif (empty($AddressMx)) {
        $json['warn'] = "请输入详细地址";
    }else{
        if (empty($id)) {
            $id = suiji();
            $bool = mysql_query("INSERT INTO address(id, khid, AddressName, AddressTel, RegionId, AddressMx, UpdateTime, time) VALUES ('$id', '$kehu[khid]', '$AddressName', '$AddressTel', '$RegionId', '$AddressMx', '$time', '$time')");
            if ($bool) {
                $_SESSION['warn'] = "收货地址新增成功";
                $json['warn'] = 2;
                $json['href'] = "{$root}m/mUser/mUsAddressMx.php?address={$id}";
            }else{
                $json['warn'] = "未知错误，收货地址新增失败";
            }
        }else{
            $address = query("address","id = '$id'");
            if (empty($address['id'])) {
                $_SESSION['warn'] = "未知错误，修改失败";
                $json['warn'] = 2;
                $json['href'] = "{$root}m/mUser/mUsAddress.php";
            }else{
                $bool = mysql_query("UPDATE address SET AddressName='$AddressName',AddressTel='$AddressTel',RegionId='$RegionId',AddressMx='$AddressMx',UpdateTime='$time' WHERE id = '$id' AND khid='$kehu[khid]'");
                if ($bool) {
                    $json['warn'] = "收货地址更新成功";
                }else{
                    $json['warn'] = "未知错误，收货地址修改失败";
                }
            }
        }
        if($defaultAd == "是"){ //修改默认地址
            mysql_query("UPDATE kehu SET addressId='$id',updateTime='$time' WHERE khid='$kehu[khid]'");
        }
    }
    /******************删除收货地址*******************/
}else if ($type == "delAddress") {
    $id = $post['address']; //收货ID
    if (empty($id)) {
        $json['warn'] = "请选择要删除的收货地址";
    }else{
        $address = query("address","id = '$id'");
        if (empty($address['id'])) {
            $_SESSION['warn'] = "删除失败，未知错误";
            $json['warn'] = 2;
        }else{
            $bool = mysql_query("DELETE FROM address WHERE id = '$id' AND khid='$kehu[khid]'");
            if ($bool) {
                $_SESSION['warn'] = "删除收货地址成功";
                $json['warn'] = 2;
            }else{
                $json['warn'] = "未知错误，删除失败";
            }
        }
    }
    /******************删除购物车商品*******************/
}else if ($type == "delOrder") {
    $id = $post['order']; //收货ID
    if (empty($id)) {
        $json['warn'] = "请选择要删除的商品";
    }else{
        $buycar = query("buycar","id = '$id'");
        if (empty($buycar['id'])) {
            $_SESSION['warn'] = "删除失败，未知错误";
            $json['warn'] = 2;
        }else{
            $bool = mysql_query("DELETE FROM buycar WHERE id = '$id' AND khid='$kehu[khid]' AND WorkFlow='未选定'");
            if ($bool) {
                $_SESSION['warn'] = "删除购物车商品成功";
                $json['warn'] = 2;
            }else{
                $json['warn'] = "未知错误，删除失败";
            }
        }
    }
    /******************查询商品规格*******************/
}else if($type == "queryKu"){
    $id = $post['kid']; //规格id
    if (empty($id)) {
        $json['warn'] = "参数错误";
    }else {
        $goodsSku = query("goodsSku","id='$id' ");
        if (!empty($goodsSku['id'])) {
            $json['price'] = $goodsSku['price']; //单价
            $json['priceMarket'] = $goodsSku['priceMarket']; //市场价格
            $json['number'] = $goodsSku['number']; //库存
            $json['salesVolume'] = $goodsSku['salesVolume']; //销量
        }else{
            $json['price'] = 0; //单价
            $json['priceMarket'] = 0; //市场价格
            $json['number'] = 0; //库存
            $json['salesVolume'] = 0; //销量
        }
    }
    /******************商品购买*******************/
}else if ($type == "usBuy") {
    $goodsId = $post['gid']; //商品ID
    $goodsSkuId = $post['kid']; //商品规格ID
    $buyNumber = $post['buynum']; //购买数量
    $t = $get['t']; //类型
    if (empty($goodsId) || empty($goodsSkuId)) {
        $json['warn'] = "商品参数错误";
    }elseif (empty($buyNumber)) {
        $json['warn'] = "请选择购买数量";
    }else{
        $goods = query("goods","id = '$goodsId'"); //查询商品信息
        $goodsSku = query("goodsSku","id = '$goodsSkuId' "); //查询商品规格
        if (!empty($goods['id']) && !empty($goodsSku['id'])) {
            $id = suiji();
            if ($t == "mUsPay") {//类型为支付
                $msg = "";
                $href = "{$root}m/mUser/mUsPay.php?order={$id}";
                $WorkFlow = "已选定";
                $groupBuy = para("groupBuy"); //团购（满几件打折）
                $discountMoney = para("discountMoney"); //折扣价（满多少元打折）

            }else{ //类型为购物车
                $msg = "商品加入购物车成功";
                $href = "{$root}m/mUser/mUsBuyCar.php";
                $WorkFlow = "未选定";
            }
            $kehu = query("kehu","khid = '$kehu[khid]'"); // 查询默认地址
            $address = query("address","id = '$kehu[addressId]' and khid ='$kehu[khid]' "); //查询默认地址
            //判断是否存在默认收获地址
            if (!empty($kehu['addressId']) && !empty($address['id'])) {
                $bool = mysql_query("INSERT INTO buycar(id, khid, goodsId, goodsSkuId, goodsName, goodsSkuName, addressName, addressTel, regionId, addressMx, buyNumber, buyPrice, WorkFlow, updateTime, time) VALUES ('$id', '$kehu[khid]', '$goods[id]', '$goodsSku[id]', '$goods[name]', '$goodsSku[name]','$address[AddressName]', '$address[AddressTel]', '$address[RegionId]', '$address[AddressMx]', '$buyNumber', '$goodsSku[price]', '$WorkFlow', '$time', '$time')");
            }else{
                $bool = mysql_query("INSERT INTO buycar(id, khid, goodsId, goodsSkuId, goodsName, goodsSkuName, buyNumber, buyPrice, WorkFlow, updateTime, time) VALUES ('$id', '$kehu[khid]', '$goods[id]', '$goodsSku[id]', '$goods[name]', '$goodsSku[name]', '$buyNumber', '$goodsSku[price]', '$WorkFlow', '$time', '$time')");
            }
            if ($bool){
                $_SESSION['warn'] = $msg;
                $json['warn'] = 2;
                $json['href'] = $href;
            }else{
                $json['warn'] = "提交失败，未知错误";
            }
        }else{
            $json['warn'] = "商品参数错误";
        }
    }
    /******************修改收件人信息*******************/
}elseif ($type == "upAddress") {
    $AddressName = $post['adName']; //收货姓名
    $AddressTel = $post['adTel']; //收货号码
    $RegionId = $post['area']; //地区
    $AddressMx = $post['adMx']; //详细地址
    $order = $post['order']; //订单ID
    if (empty($AddressName)) {
        $json['warn'] = "收货姓名不能为空";
    }elseif (preg_match($CheckTel, $AddressTel)==0) {
        $json['warn'] = "手机号码输入错误";
    }elseif (empty($RegionId)) {
        $json['warn'] = "请选择收货地区";
    }elseif (empty($AddressMx)) {
        $json['warn'] = "请输入详细地址";
    }else{
        $address = query("address","AddressName = '$AddressName' and khid = '$kehu[khid]' ");
        if (empty($address['id'])) {
            $id = suiji();
            mysql_query("INSERT INTO address(id, khid, AddressName, AddressTel, RegionId, AddressMx, UpdateTime, time) VALUES ('$id', '$kehu[khid]', '$AddressName', '$AddressTel', '$RegionId', '$AddressMx', '$time', '$time')");
        }
        $bool = mysql_query("UPDATE buycar SET addressName='$AddressName', addressTel='$AddressTel', regionId='$RegionId', addressMx='$AddressMx' WHERE id = '$order' and khid = '$kehu[khid]' ");
        if ($bool) {
            $_SESSION['warn'] = "修改收货人信息成功";
            $json['warn'] = 2;
            $json['href'] = "{$root}m/mUser/mUsPay.php?order={$order}";
        }else{
            $json['warn'] = "提交失败，未知错误";
        }
    }
/******************在线帮助留言*******************/
}elseif ($type == "message") {
    $text = $post['message']; //留言
    if (empty($text)) {
        $json['warn'] = "请填写留言";
    }else{
        $id = suiji();
        $bool = mysql_query("INSERT INTO talk (id, type, khid, text, time) VALUES ('$id', '留言', '$kehu[khid]', '$text', '$time')");
        if ($bool) {
            $json['warn'] = 2;
        }else{
            $json['warn'] = "留言失败";
        }
    }
    /******************活动报名*******************/
}elseif ($type == "activity") {
    $contentId = $post['activityId'];//内容表的id号/活动的ID号
    $content = mysql_fetch_array(mysql_query("SELECT * FROM content WHERE id = '$contentId' "));//活动内容表
    $enroll = mysql_fetch_assoc(mysql_query("SELECT * FROM enroll WHERE contentId = '$contentId' AND khid = '$kehu[khid]' "));//活动报名
    //判断
    if (empty($contentId)) {
        $json['warn'] = "报名活动ID号为空";
    } else if ($content['id'] != $contentId) {
        $json['warn'] = "没找到这个活动的记录";
    } else if (mysql_num_rows(mysql_query("SELECT * FROM enroll WHERE contentId = '$contentId' AND khid = '$kehu[khid]' ")) > 0) {
        $json['warn'] = "这个活动你已经报过名了";
    } else {
        $id = suiji();
        $bool = mysql_query("INSERT INTO enroll (id,contentId,khid,time) VALUES ('$id','$contentId','$kehu[khid]','$time') ");
        if ($bool) {
            $json['warn'] = '报名成功';
        } else {
            $json['warn'] = '报名失败';
        }
    }
    /******************调查问卷*******************/
}elseif ($type == "question") {
    $answer = $post['answer'];//提交的答案
    $contentId = $post['contentId'];//文章ID号
    $content = query("content", "id = '$contentId' ");
    //判断
    if (empty($contentId)) {
        $json['warn'] = "文章ID号为空";
    } else if ($content['id'] != $contentId) {
        $json['warn'] = "没找到这个文章的记录";
    } else if (mysql_num_rows(mysql_query("SELECT * FROM kehuQuestion WHERE khid = '$kehu[khid]' AND contentId = '$contentId' ")) > 0) {
        $json['warn'] = "这个调查你已经提交过了";
    } else {
        $id = suiji();
        $bool = mysql_query("INSERT INTO kehuQuestion (id, khid, contentId, answer, time) VALUES ('$id','$kehu[khid]','$contentId','$answer','$time') ");
        if ($bool) {
            $json['warn'] = '提交成功';
        } else {
            $json['warn'] = '提交失败';
        }
    }
    /******************返回json数据*******************/
}
echo json_encode($json);
?>