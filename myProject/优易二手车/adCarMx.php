<?php
include "ku/adfunction.php";
ControlRoot("车辆管理");
if(empty($_GET['id'])){
    $title = "新建车辆";	
}else{
	$Car = query("Car"," id = '$_GET[id]' ");
	if($Car['id'] != $_GET['id']){
		$_SESSION['warn'] = "未找到这个车辆信息";
		header("location:{$root}control/adCar.php");
		exit(0);
	}
    $title = $Car['type']."-".$Car['name'];
	//行驶证扫描件
	$CertificateIco = "&nbsp;<span onclick='document.adCertificateIcoForm.adCertificateIcoUpload.click();' class='SpanButton'>更新</span>";
	//车辆列表图像
	$listIco = "&nbsp;<span onclick='document.adListIcoForm.adListIcoUpload.click();' class='SpanButton'>更新</span>";
}
$Region = query("region", "id = '$Car[RegionId]' ");
$Brand = query("Brand", "id = '$Car[BrandId]' ");
//车辆详情图片
	$carImg = "
	<tr>
	   <td>车辆详情图片：</td>
	   <td>
	";
	$carImgSql = mysql_query(" select * from CarImg where CarId = '$Car[id]' order by time desc ");
	$num = mysql_num_rows($carImgSql);
	if($num > 0){
		while($array = mysql_fetch_array($carImgSql)){
			$carImg .= "
			<a class='GoodsWin' target='_blank' href='{$root}{$array['src']}'><img src='{$root}{$array['src']}'></a>
			<a href='{$root}control/ku/adpost.php?carImgDelete={$array['id']}'><div>X</div></a>
			";
		}
	}else{
		$carImg .= "一张图片都没有";
	}
	if($num < 4){
		$carImg .= "&nbsp;<span onclick='document.adcarMxIcoForm.adcarMxIcoUpload.click();' class='SpanButton'>新增</span> <span class='must'>最好是按照2:1的比例新增图片</span>";
	}
	$carImg .= "
       </td>
    </tr>
	";
echo head("ad").adheader();
?>
<div class="column MinHeight">
	<!--标题开始-->
	<a href="<?php echo "{$root}control/adCar.php";?>"><img src="<?php echo "{$root}img/adimg/adCar.png";?>"></a>
	<p>
		<a href="<?php echo root."control/adCar.php";?>">车辆管理</a>&nbsp;&nbsp;>&nbsp;
        <a href="<?php echo $ThisUrl;?>"><?php echo $title;?></a>
	</p>
	<!--标题结束-->
	<!--基本资料开始-->
	<div class="kuang">
		<p>
			<img src="<?php echo root."img/images/text.png";?>">
			车辆基本资料
		</p>
		<form name="CarForm">
		<table class="TableRight">
			<tr>
			    <td style="width:200px;">车辆ID号：</td>
				<td><?php echo kong($Car['id']);?></td>
			</tr>
            <tr>
			    <td>车辆列表图片：</td>
				<td><?php echo ProveImgShow($Car['ico']).$listIco;?></td>
			</tr>
            <?php echo $carImg;?>
			<tr>
			    <td><span class="must">*</span>&nbsp;品牌：</td>
				<td>
                <?php echo RepeatSelect("Brand","type","BrandTypeSelect","select","--选择--",$Brand['type']);?>
                 <select name="BrandName" class="select">
				 	<?php echo RepeatOption("Brand where type = '$Brand[type]' ","name","--子品牌--",$Brand['name']);?>
                 </select>
                 <select name="BrandModelYearSelect" class="select">
                	<?php echo RepeatOption("Brand where type = '$Brand[type]' and name = '$Brand[name]'","ModelYear","--选择--",$Brand['ModelYear']);?>
                 </select>
                 <select name="BrandMotorcycleType" class="select">
                	<?php echo IdOption("Brand where type = '$Brand[type]' and name = '$Brand[name]' and ModelYear = '$Brand[ModelYear]'","id","MotorcycleType","--选择--",$Brand['id']);?>
                 </select>
                </td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;名称：</td>
				<td><input name="CarName" type="text" class="text" value="<?php echo $Car['name'];?>"></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;颜色：</td>
				<td><?php echo select("CarColour","select","--选择--",explode("，",website("yeD57541180Jq")),$Car['colour']);?></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;行驶里程：</td>
				<td><input name="CarMileage" type="text" class="text TextPrice" value="<?php echo $Car['mileage'];?>">万公里</td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;补充说明：</td>
				<td><textarea name="CarText" class="textarea"><?php echo $Car['text'];?></textarea></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;价格：</td>
				<td><input name="CarPrice" type="text" class="text TextPrice" value="<?php echo $Car['price'];?>"> 万元</td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;车架号：</td>
				<td><input name="CarVin" type="text" class="text" value="<?php echo $Car['vin'];?>"></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;拍卖开始时间：</td>
				<td><?php echo year('StartYear','select TextPrice','',$Car['AuctionTimeStart']).moon('StartMoon','select TextPrice',$Car['AuctionTimeStart']).day('StartDay','select TextPrice',$Car['AuctionTimeStart']).hour("StartHour","select TextPrice",$Car['AuctionTimeStart']).minute("StartMinute","select TextPrice",$Car['AuctionTimeStart']);?></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;拍卖结束时间：</td>
				<td><?php echo year('EndYear','select TextPrice','',$Car['AuctionTimeEnd']).moon('EndMoon','select TextPrice',$Car['AuctionTimeEnd']).day('EndDay','select TextPrice',$Car['AuctionTimeEnd']).hour("EndHour","select TextPrice",$Car['AuctionTimeEnd']).minute("EndMinute","select TextPrice",$Car['AuctionTimeEnd']);?></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;是否拍卖：</td>
				<td><?php echo radio("CarAuction",array("是","否"),$Car['auction']);?></td>
			</tr>
			<tr>
			    <td>行驶证扫描件：</td>
				<td><?php echo ProveImgShow($Car['DrivingLicense']).$CertificateIco;?></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;看车地区：</td>
				<td><select name="province" class="select"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                <select name="city" class="select"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                <select name="area" class="select"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$Car['RegionId']);?></select></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;首次上牌时间：</td>
				<td><?php echo year('year','select','',$Car['RegisterTime']).moon('moon','select',$Car['RegisterTime']).day('day','select',$Car['RegisterTime']);?></td>
			</tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($Car['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>创建时间：</td>
				<td><?php echo kong($Car['time']);?></td>
			</tr>
			<tr>
			    <td><input name="adCarId" type="hidden" value="<?php echo $Car['id'];?>"></td>
				<td><input onclick="Sub('CarForm','<?php echo root."control/ku/addata.php";?>')" type="button" class="button" value="提交"></td>
			</tr>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
</div>
<div class="hide">
<!--行驶证扫描件-->
<form name="adCertificateIcoForm" action="<?php echo root."control/ku/adpost.php";?>" method="post" enctype="multipart/form-data">
<input name="adCertificateIcoUpload" type="file" onchange="document.adCertificateIcoForm.submit();">
<input name="adCertificateId" type="hidden" value="<?php echo $Car['id'];?>">
</form>
<!--车辆列表图片-->
<form name="adListIcoForm" action="<?php echo root."control/ku/adpost.php";?>" method="post" enctype="multipart/form-data">
<input name="adListIcoUpload" type="file" onchange="document.adListIcoForm.submit();">
<input name="adListId" type="hidden" value="<?php echo $Car['id'];?>">
</form>
<!--车辆详情图片-->
<form name="adcarMxIcoForm" action="<?php echo root."control/ku/adpost.php";?>" method="post" enctype="multipart/form-data">
<input name="adcarMxIcoUpload" type="file" onchange="document.adcarMxIcoForm.submit();">
<input name="adcarMxId" type="hidden" value="<?php echo $Car['id'];?>">
</form>
</div>   
<script>
$(document).ready(function(){
	var Form = document.CarForm;
    //将品牌分类下拉菜单的值赋值到text
	Form.BrandTypeSelect.onchange = function(){
		Form.BrandModelYearSelect.innerHTML = "<option value=''>--年款--</option>";
		Form.BrandMotorcycleType.innerHTML = "<option value=''>--车型--</option>";
		$.post("<?php echo root."control/ku/addata.php";?>",{BrandTypeGetName:this.value},function(data){
			Form.BrandName.innerHTML = data.name;
		},"json");
	};
	//将子品牌下拉菜单的值赋值到text
	Form.BrandName.onchange = function(){
		Form.BrandMotorcycleType.innerHTML = "<option value=''>--车型--</option>";
		$.post("<?php echo root."control/ku/addata.php";?>",{
			BrandTypeGetModelYear:Form.BrandTypeSelect.value,
			BrandNameGetModelYear:this.value
		},function(data){
			Form.BrandModelYearSelect.innerHTML = data.ModelYear;
		},"json");
	};
	//将年款下拉菜单的值赋值到text
	Form.BrandModelYearSelect.onchange = function(){
		$.post("<?php echo root."control/ku/addata.php";?>",{
			BrandTypeGetMotorcycleType:Form.BrandTypeSelect.value,
			BrandNameGetMotorcycleType:Form.BrandName.value,
			BrandModelYearGetMotorcycleType:this.value
		},function(data){
			Form.BrandMotorcycleType.innerHTML = data.MotorcycleType;
		},"json");
	};
	//根据省份获取下属城市下拉菜单
	document.CarForm.province.onchange = function(){
		document.CarForm.area.innerHTML = "<option value=''>--区县--</option>";
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
			document.CarForm.city.innerHTML = data.city;
		},"json");
	};
	//根据省份和城市获取下属区域下拉菜单
	document.CarForm.city.onchange = function(){
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:document.CarForm.province.value,CityPostArea:this.value},function(data){
			document.CarForm.area.innerHTML = data.area;
		},"json");
	}
});
</script>
<?php echo warn().adfooter();?>