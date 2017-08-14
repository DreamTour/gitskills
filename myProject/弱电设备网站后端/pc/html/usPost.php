<?php
include "../library/OpenFunction.php";
UserRoot("pc");
/*------------------新增或更新个人中心我的头像-------------------------------------------------*/
if(isset($_FILES['headPortraitUpload'])){
    $FileName = "headPortraitUpload";//上传图片的表单文件域名称
    $cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
    $cut['width'] = "480";//裁剪宽度
    $cut['height'] = "480";//裁剪高度
    $cut['NewWidth'] = "";//缩放的宽度
    $cut['MaxHeight'] = "";//缩放后图片的最大高度
    $type['name'] = "更新图像";//"更新图像"or"新增图像"
    $type['num'] = 1;//新增图像时限定的图像总数
    $sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
    $column = "ico";//保存图片的数据库列的名称
    $suiji = suiji();
    $Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
    $Url['NewImgUrl'] = "img/usHead/{$suiji}.jpg";//新图片保存的网站根目录位置
    $NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";
    $ImgWarn = "我的头像更新成功";//图片保存成功后返回的文字内容
    UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
    /*------------------我的投诉-删除我的投诉记录-------------------------------------------------*/
}else if(!empty($_GET['complainDelete'])){
    $id = $_GET['complainDelete']; //预约id
    $complain = query("complain", " id = '$id' ");
    mysql_query("delete from complain where id = '$id'");
    $_SESSION['warn'] = "我的投诉删除成功";
    /*------------------我的预约-删除我的预约记录-------------------------------------------------*/
}else if(!empty($_GET['bespeakDelete'])){
    $id = $_GET['bespeakDelete']; //预约id
    $bespeak = query("bespeak", " id = '$id' ");
    mysql_query("delete from bespeak where id = '$id'");
    $_SESSION['warn'] = "我的预约删除成功";
    /*------------------我的维修记录-删除我的维修记录-------------------------------------------------*/
}else if(!empty($_GET['serviceDelete'])){
    $id = $_GET['serviceDelete']; //预约id
    $service = query("service", " id = '$id' ");
    mysql_query("delete from service where id = '$id'");
    $_SESSION['warn'] = "我的维修记录删除成功";
    /*------------------同城搜索-多条件模糊查询-------------------------------------------------*/
}else if(isset($_POST['searchSex']) and isset($_POST['searchMinAge']) and isset($_POST['searchMaxAge'])){
    //赋值
    $searchSex = $_POST['searchSex'];//性别
    $searchMinAge = $_POST['searchMinAge'];//最小年龄
    $searchMaxAge = $_POST['searchMaxAge'];//最大年龄
    $area = $_POST['area'];//所属区县ID号
    if(empty($kehu['Occupation'])){
        $_SESSION['warn'] = "请完善你的个人资料";
    }else if(empty($kehu['LoveOccupation'])){
        $_SESSION['warn'] = "请完善你的择偶意向";
    }else{
        //串联查询语句
        if(!empty($searchSex)){
            $x .= " and sex = '$searchSex' ";
        }
        if(empty($searchMinAge) or empty($searchMaxAge)){
            $searchMinAge =  $searchMaxAge = "";
        }else{
            $d = date("Y");
            $MaxYear = ($d - $searchMinAge)."-01-01";//最大出生日期
            $MinYear = ($d - $searchMaxAge)."-01-01";//最小出生日期
            $x .= " and Birthday > '$MinYear' and Birthday < '$MaxYear' ";
        }
        if(!empty($area)){
            $x .= " and RegionId = '$area' ";
        }
        //返回
        $_SESSION['userSearch'] = array(
            "sex" => $searchSex,"minAge" => $searchMinAge,"maxAge" => $searchMaxAge,"city" => $city,"area" => $area,"Sql" => $x);
    }
    //判断
    if(isMobile()){
        header("Location:{$root}m/mSearch.php");
        exit(0);
    }
}
/*-----------------跳转回刚才的页面---------------------------------------------------------*/
header("Location:".getenv("HTTP_REFERER"));
?>