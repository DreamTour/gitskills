<?php
include "OpenFunction.php";

/*-----------------优职查询表单提交返回数据-------------------------------------------------------------*/
if(isset($_POST['searchJobKey'])){
	//赋值
	$province = $_POST['province'];//省份
	$city = $_POST['city'];//城市
	$area = $_POST['area'];//区县
	$type = $_POST['searchColumn'];//一级分类
	$name = $_POST['searchColumnChild'];//二级分类
	$key = $_POST['searchJobKey'];//搜索关键词
	$Subject = $_POST['searchSubject'];//劳务主体
	$where = " where 1=1 ";
	//判断
	if(!empty($province)){
	    if(empty($city)){
		    $where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' ) )";
		}else{
			if(empty($area)){
				$where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' and city = '$city' ) )";
			}else{
			    $where .= " and khid in ( select khid from kehu where RegionId = '$area' ) ";
			}
		}
	}
	if(!empty($type)){
	    if(empty($name)){
		    //$where .= " and ( ClassifyId = '1' or ClassifyId = '2' or ClassifyId = '3' or ClassifyId = '4' or ClassifyId = '5' or ClassifyId = '6' ) ";
		    //$where .= " and ClassifyId in ('1','2','3','4','5','6') ";
		    $where .= " and ClassifyId in ( select id from classify where type = '$type' ) ";
		}else{
		    $where .= " and ClassifyId = '$name' ";
		}
	}
	if(!empty($key)){
		$where .= " and ( title like '%$key%' or text like '%$key%' or KeyWord like '%$key%' ) ";
	}
	if(!empty($Subject)){
		$where .= "and IdentityType = '$Subject'";	
	}
	//查询返回结果
	$demandSql = mysql_query(" select * from demand {$where} order by UpdateTime desc " );
	$message = "
    <li class='po-co-item'>
    	<a href='javascript:;' class='clearfix po-text-box'>
            <h3 class='fl' style='padding-left:10px;color: #F44336'>没有您要的信息？去发布一条吧。</h3>
    	</a>
    	</li>
";
	if(mysql_num_rows($demandSql) == 0){
		$json['html'] = $message;
	}else{
		while($array = mysql_fetch_array($demandSql)){
			$kehu = query("kehu","khid = '$array[khid]'");
			$company = query("company","khid = '$kehu[khid]'");
			$UpdateTime = substr($array['UpdateTime'],0,10);
			$address = query("region", "id = '$kehu[RegionId]' ");
			//判断收费类型，根据收费类型显示内容
			if ($array['payType'] == "薪酬") {
				$pay = "{$array['pay']}/{$array['PayCycle']}";
			}
			else {
				$pay = $array['payType'];
			}
			$json['html'] .= "
    	<li class='po-co-item'><!--<input type='checkbox'>--><a href='{$root}m/mRecruit.php?demandMx_id={$array['id']}' class='clearfix po-text-box'><h2 class='fl' style='padding-left:10px;'>{$array['title']}</h2><span class='fr'>{$pay}</span></a></li>
			";	
		}
		$json['html'] .= $message;
	}
/*-----------------优才查询表单提交返回数据-------------------------------------------------------------*/
}elseif(isset($_POST['searchTalentKey'])){	
	//赋值
	$province = $_POST['province'];//省份
	$city = $_POST['city'];//城市
	$area = $_POST['area'];//区县
	$type = $_POST['searchColumn'];//一级分类
	$name = $_POST['searchColumnChild'];//二级分类
	$key = $_POST['searchTalentKey'];//搜索关键词
	$Subject = $_POST['searchSubject'];//劳务主体
	$where = " where 1=1 ";
	//判断
	if(!empty($province)){
	    if(empty($city)){
		    $where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' ) )";
		}else{
			if(empty($area)){
				$where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' and city = '$city' ) )";
			}else{
			    $where .= " and khid in ( select khid from kehu where RegionId = '$area' ) ";
			}
		}
	}
	if(!empty($type)){
	    if(empty($name)){
		    //$where .= " and ( ClassifyId = '1' or ClassifyId = '2' or ClassifyId = '3' or ClassifyId = '4' or ClassifyId = '5' or ClassifyId = '6' ) ";
		    //$where .= " and ClassifyId in ('1','2','3','4','5','6') ";
		    $where .= " and ClassifyId in ( select id from classify where type = '$type' ) ";
		}else{
		    $where .= " and ClassifyId = '$name' ";
		}
	}
	if(!empty($key)){
		$where .= " and ( title like '%$key%' or text like '%$key%' or KeyWord like '%$key%' ) ";
	}
	if(!empty($Subject)){
		$where .= "and IdentityType = '$Subject'";	
	}
	//查询返回结果
	$supplySql = mysql_query(" select * from supply {$where} order by UpdateTime desc " );
	$message = "
    <li class='po-co-item'>
    	<a href='javascript:;' class='clearfix po-text-box'>
            <h3 class='fl' style='padding-left:10px;color: #F44336'>没有您要的信息？去发布一条吧。</h3>
    	</a>
    	</li>
";
	if(mysql_num_rows($supplySql) == 0){ 
		$json['html'] = $message;
	}else{
		while($array = mysql_fetch_array($supplySql)){
			//判断收费类型，根据收费类型显示内容
			if ($array['payType'] == "薪酬") {
				$pay = "{$array['pay']}/{$array['PayCycle']}";
			}
			else {
				$pay = $array['payType'];
			}
			$json['html'] .= "
			    	<li class='po-co-item'><!--<input type='checkbox'>--><a href='{$root}m/mJobMx.php?supplyMx_id={$array['id']}' class='clearfix po-text-box'><h2 class='fl' style='padding-left:10px;'>{$array['title']}</h2><span class='fr'>{$pay}</span></a></li>
			";
		}
		$json['html'] .= $message;
	}
/*-----------------学生兼职查询表单提交返回数据-------------------------------------------------------------*/
}elseif(isset($_POST['searchPartKey'])){	
	//赋值
	$province = $_POST['province'];//省份
	$city = $_POST['city'];//城市
	$area = $_POST['area'];//区县
	$type = $_POST['searchColumn'];//一级分类
	$name = $_POST['searchColumnChild'];//二级分类
	$key = $_POST['searchPartKey'];//搜索关键词
	$Subject = $_POST['searchSubject'];//劳务主体
	$where = " where ClassifyId in (select id from classify where type in ('服务/市场','私教/培训')) ";
	//判断
	if(!empty($province)){
	    if(empty($city)){
		    $where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' ) )";
		}else{
			if(empty($area)){
				$where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' and city = '$city' ) )";
			}else{
			    $where .= " and khid in ( select khid from kehu where RegionId = '$area' ) ";
			}
		}
	}
	if(!empty($type)){
	    if(empty($name)){
		    //$where .= " and ( ClassifyId = '1' or ClassifyId = '2' or ClassifyId = '3' or ClassifyId = '4' or ClassifyId = '5' or ClassifyId = '6' ) ";
		    //$where .= " and ClassifyId in ('1','2','3','4','5','6') ";
		    $where .= " and ClassifyId in ( select id from classify where type = '$type' ) ";
		}else{
		    $where .= " and ClassifyId = '$name' ";
		}
	}
	if(!empty($key)){
		$where .= " and ( title like '%$key%' or text like '%$key%' or KeyWord like '%$key%' ) ";
	}
	if(!empty($Subject)){
		$where .= "and IdentityType = '$Subject'";	
	}
	//查询返回结果
	$demandSql = mysql_query(" select * from demand {$where} order by UpdateTime desc " );
	$message = "
    <li class='po-co-item'>
    	<a href='javascript:;' class='clearfix po-text-box'>
            <h3 class='fl' style='padding-left:10px;color: #F44336'>没有您要的信息？去发布一条吧。</h3>
    	</a>
    	</li>
";
	if(mysql_num_rows($demandSql) == 0){
		$json['html'] = $message;
	}else{
		while($array = mysql_fetch_array($demandSql)){
			$kehu = query("kehu","khid = '$array[khid]'");
			$company = query("company","khid = '$kehu[khid]'");
			$UpdateTime = substr($array['UpdateTime'],0,10);
			$address = query("region", "id = '$kehu[RegionId]' ");
			//判断收费类型，根据收费类型显示内容
			if ($array['payType'] == "薪酬") {
				$pay = "{$array['pay']}/{$array['PayCycle']}";
			}
			else {
				$pay = $array['payType'];
			}
			$json['html'] .= "
    	<li class='po-co-item'><!--<input type='checkbox'>--><a href='{$root}m/mRecruit.php?demandMx_id={$array['id']}' class='clearfix po-text-box'><h2 class='fl' style='padding-left:10px;'>{$array['title']}</h2><span class='fr'>{$pay}</span></a></li>
			";	
		}
		$json['html'] .= $message;
	}		
}
/*-----------------返回信息---------------------------------------------------------*/
echo json_encode($json);
?>