<?php
include "adfunction.php";
ControlRoot();
/******************更新商品列表图像*******************************/
if($get['type'] == "goodsIco"){
    //赋值
    $id = $post['GoodsId'];
    //判断
    $goods = query("goods"," id = '$id' ");
    if(empty($id)){
        $_SESSION['warn'] = "请先提交商品基本资料";
    }elseif($goods['id'] != $id){
        $_SESSION['warn'] = "未找到本商品";
    }else{
        $FileName = "GoodsIcoUpload";//上传图片的表单文件域名称
        $Rule['MaxSize'] = 1000000;//图像的最大容量
        $Rule['width'] = 800;//图像要求的宽度
        $Rule['height'] = 800;//图像要求的高度
        $Rule['MaxHeight'] = "";//当图像要求的高度为空时，判断图片要求最高的高度（超高图片切片时需要）
        $type['name'] = "更新图像";//《更新图像》或《新增图像》
        $type['num'] = "";//新增图像时限定的图像总数
        $sql = " select * from goods where id = '$id' ";//查询图片的数据库代码
        $column = "ico";//保存图片的数据库列的名称
        $Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
        $Url['NewImgUrl'] = "img/goodsIco/{$id}.jpg";//新图片保存的网站根目录位置
        $NewImgSql = " update goods set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where id = '$id' ";//保存图片的数据库代码
        $ImgWarn = "商品列表图像更新成功";//图片保存成功后返回的文字内容
        UpdateCheckImg($FileName,$Rule,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
    }
    /*------------------新增商品橱窗图像----------------------------------------------------------------------------------------------------------------------*/
}elseif($get['type'] == "goodsWin"){
    //赋值
    $goodsId = $post['GoodsId'];
    //判断
    $goods = query("goods"," id = '$goodsId' ");
    if(empty($goodsId)){
        $_SESSION['warn'] = "请先提交商品基本资料";
    }elseif($goods['id'] != $goodsId){
        $_SESSION['warn'] = "未找到本商品";
    }else{
        $FileName = "GoodsWinUpload";//上传图片的表单文件域名称
        $Rule['MaxSize'] = 1000000;//图像的最大容量
        $Rule['width'] = 800;//图像要求的宽度
        $Rule['height'] = 800;//图像要求的高度
        $Rule['MaxHeight'] = "";//当图像要求的高度为空时，判断图片要求最高的高度（超高图片切片时需要）
        $type['name'] = "新增图像";//《更新图像》或《新增图像》
        $type['num'] = 5;//新增图像时限定的图像总数
        $sql = " select * from goodsWin where goodsId = '$goodsId' ";//查询图片的数据库代码
        $column = "img";//保存图片的数据库列的名称
        $id = suiji();
        $Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
        $Url['NewImgUrl'] = "img/goodsWin/{$id}.jpg";//新图片保存的网站根目录位置
        $NewImgSql = " insert into goodsWin (id,goodsId,src,time) values ('$id','$goodsId','$Url[NewImgUrl]','$time') ";//保存图片的数据库代码
        $ImgWarn = "商品橱窗图像新增成功";//图片保存成功后返回的文字内容
        UpdateCheckImg($FileName,$Rule,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
    }
    /******************删除橱窗图*******************************/
}elseif(!empty($get['GoodsWinDelete'])){
    $id = $_GET['GoodsWinDelete'];
    $win = query("goodsWin"," id = '$id' ");
    unlink(ServerRoot.$win['src']);
    mysql_query("delete from goodsWin where id = '$id'");
    $_SESSION['warn'] = "商品橱窗图像删除成功";
    /******************商品--模糊查询*******************************/
}elseif(isset($post['goodsTypeOneId']) and isset($post['SearchShow']) and isset($post['SearchGoodsName'])){
    //赋值
    $one = $post['goodsTypeOneId'];
    $show = $post['SearchShow'];
    $name = $post['SearchGoodsName'];
    $x = "where 1 = 1 ";
    if(!empty($one)){
        $x .= " and goodsTypeOneId = '$one' ";
    }
    if(!empty($show)){
        $x .= " and xian = '$show' ";
    }
    if(!empty($name)){
        $x .= " and name like '%$name%' ";
    }
    //返回值
    $_SESSION['SearchGoods'] = array("goodsTypeOneId" => $one,"xian" => $show,"GoodsName" => $name,"Sql" => $x);
    /******************商品管理-二级分类-多条件模糊查询*******************************/
}elseif($get['type'] == "searchGoodsTypeTwo"){
    //赋值
    $one = $post['goodsTypeOne'];//商品一级分类ID号
    $xian = $post['goodsTypeTwoShow'];//商品二级分类显示状态
    $x = " where 1=1 ";
    //判断
    if(!empty($one)){
        $x .= " and goodsTypeOneId = '$one' ";
    }
    if(!empty($xian)){
        $x .= " and xian = '$xian' ";
    }
    //返回值
    $_SESSION['goodsTypeTwo'] = array("one" => $one,"xian" => $xian,"Sql" => $x);
    /******************客户管理-多条件模糊查询*******************************/
}elseif($get['type'] == "adClient"){
    //赋值
    $wxNickName = $post['adClientNickName'];//客户昵称
    $name = $post['adClientName'];//客户姓名
    $wxSex = $post['adClientSex'];//客户性别
    $khtel = $post['adClientTel'];//手机号码
    $status = $post['adClientStatus'];//状态
    $type = $post['adClientType']; //类型
    $shareId = $post['adShareId']; //推广人
    $x = " where 1=1 ";
    //串联查询语句
    if(!empty($wxNickName)){
        $x .= " and wxNickName like '%$wxNickName%' ";
    }
    if(!empty($name)){
        $x .= " and name like '%$name%' ";
    }
    if(!empty($wxSex)){
        $x .= " and wxSex = '$wxSex' ";
    }
    if(!empty($khtel)){
        $x .= " and khtel like '%$khtel%' ";
    }
    if(!empty($status)){
        $x .= " and status = '$status' ";
    }
    if ($type == "vip会员") {
        $x .= " and type = 'vip会员' ";
    }
    if(!empty($shareId)){
        $x .= " AND shareId in (SELECT khid FROM kehu WHERE wxNickName like '%$shareId%') ";
    }

    //返回
    $_SESSION['adClient'] = array(
        "wxNickName" => $wxNickName,"name" => $name,"wxSex" => $wxSex,"khtel" => $khtel,"status" => $status,"shareId" => $shareId,"Sql" => $x);
    /******************订单模糊查询*******************************/
}elseif($get['type'] == "searchOrder"){
    //赋值
    $buycarId = $post['SearchOrderGoodsId'];//订单号
    $RuleName = $post['SearchOrderRuleName'];//规格名称
    $khname = $post['SearchOrderKhName'];//收货人姓名
    $khtel = $post['SearchOrderKhtel'];//收货人手机号码
    $address = $post['SearchOrderAddress'];//收货地址
    $WorkFlow = $post['WorkFlow'];//订单状态
    $x = " where 1=1 ";
    //串联查询语句
    if(!empty($buycarId)){
        $x .= " and id like '%$buycarId%' ";
    }
    if(!empty($RuleName)){
        $x .= " and goodsSkuName like '%$RuleName%' ";
    }
    if(!empty($khname)){
        $x .= " and addressName like '%$khname%' ";
    }
    if(!empty($khtel)){
        $x .= " and addressTel like '%$khtel%' ";
    }
    if(!empty($address)){
        $x .= " and addressMx like '%$address%' ";
    }
    if(!empty($WorkFlow)){
        $x .= " and WorkFlow = '$WorkFlow' ";
    }
    //返回值
    $_SESSION['SearchOrder'] = array("buycarId" => $buycarId,"RuleName" => $RuleName,"khname" => $khname,"khtel" => $khtel,"address" => $address,"WorkFlow" => $WorkFlow,"Sql" => $x);
/******************留言模糊查询*******************************/
}elseif($get['type'] == "adFeedback"){
    //赋值
    $wxNickName = $post['adWxNickName'];//昵称
    $text = $post['adFeedback'];//留言
    //串联查询语句
    if(!empty($wxNickName)){
        $x .= " and khid in ( select khid from kehu where wxNickName like '%$wxNickName%' ) ";
    }
    if(!empty($text)){
        $x .= " and text like '%$text%' ";
    }
    //返回值
    $_SESSION['adTalk'] = array("wxNickName" => $wxNickName,"text" => $text,"Sql" => $x);
/******************活动报名查询*******************************/
}elseif($get['type'] == "adEnroll"){
    //赋值
    $wxNickName = $post['adWxNickName'];//昵称
    $enrollTitle = $post['adEnrollTitle'];//活动
    $x = " WHERE 1=1 ";
    //串联查询语句
    if(!empty($wxNickName)){
        $x .= " AND khid in ( SELECT khid FROM kehu WHERE wxNickName LIKE '%$wxNickName%' ) ";
    }
    if(!empty($enrollTitle)){
        $x .= " AND contentId in ( SELECT id FROM content WHERE title LIKE '%$enrollTitle%' ) ";
    }
    //返回值
    $_SESSION['adEnroll'] = array("wxNickName" => $wxNickName,"enrollTitle" => $enrollTitle,"Sql" => $x);
/******************调查问卷查询*******************************/
}elseif($get['type'] == "adQuestion"){
    //赋值
    $wxNickName = $post['adWxNickName'];//调查人昵称
    $question = $post['adQuestion'];//调查题目
    $x = " WHERE 1=1 ";
    //串联查询语句
    if(!empty($wxNickName)){
        $x .= " AND khid in ( SELECT khid FROM kehu WHERE wxNickName LIKE '%$wxNickName%' ) ";
    }
    if(!empty($question)){
        $x .= " AND contentId in ( SELECT id FROM content WHERE question LIKE '%$question%' ) ";
    }
    //返回值
    $_SESSION['adQuestion'] = array("wxNickName" => $wxNickName,"question" => $question,"Sql" => $x);
}
/******************跳转回刚才的页面*******************************/
header("Location:".getenv("HTTP_REFERER"));
?>