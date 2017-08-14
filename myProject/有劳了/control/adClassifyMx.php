<?php
include "ku/adfunction.php";
ControlRoot("分类管理");
if(empty($_GET['id'])){
    $title = "新建分类";	
}else{
	$Classify = query("classify"," id = '$_GET[id]' ");
	if($Classify['id'] != $_GET['id']){
		$_SESSION['warn'] = "未找到这个分类信息";
		header("location:{$root}control/adClassify.php");
		exit(0);
	}
    $title = $Classify['type']."-".$Classify['name'];
	//行驶证扫描件
	$CertificateIco = "&nbsp;<span onclick='document.adCertificateIcoForm.adCertificateIcoUpload.click();' class='SpanButton'>更新</span>";
}
$Region = query("region", "id = '$Classify[RegionId]' ");
$Brand = query("Brand", "id = '$Classify[BrandId]' ");
echo head("ad").adheader();
?>
<div class="column MinHeight">
	<!--标题开始-->
	<a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/adClassify.png";?>"></a>
	<p>
		<a href="<?php echo root."control/adClassify.php";?>">分类管理</a>&nbsp;&nbsp;>&nbsp;
        <a href="<?php echo $ThisUrl;?>"><?php echo $title;?></a>
	</p>
	<!--标题结束-->
	<!--基本资料开始-->
	<div class="kuang">
		<p>
			<img src="<?php echo root."img/images/text.png";?>">
			分类基本资料
		</p>
		<form name="ClassifyForm">
		<table class="TableRight">
			<tr>
			    <td style="width:200px;">分类ID号：</td>
				<td><?php echo kong($Classify['id']);?></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;一级分类：</td>
				<td>
                <?php echo RepeatSelect("classify","type","classifyTypeSelect","select","--选择--",$Classify['type']);?>
                <input name="ClassifyType" type="text" class="text" value="<?php echo $Classify['type'];?>">
                </td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;二级分类：</td>
				<td><input name="ClassifyName" type="text" class="text" value="<?php echo $Classify['name'];?>"></td>
			</tr>
            <tr>
            	<td><span class="must">*</span>&nbsp;排序号：</td>
                <td><input name="ClassifySort" type="text" class="text TextPrice" value="<?php echo $Classify['list']?>" /></td>
            </tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($Classify['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>创建时间：</td>
				<td><?php echo kong($Classify['time']);?></td>
			</tr>
			<tr>
			    <td><input name="adClassifyId" type="hidden" value="<?php echo $Classify['id'];?>"></td>
				<td><input onclick="Sub('ClassifyForm','<?php echo root."control/ku/addata.php";?>')" type="button" class="button" value="提交"></td>
			</tr>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
</div>
<div class="hide">
<form name="adCertificateIcoForm" action="<?php echo root."control/ku/adpost.php";?>" method="post" enctype="multipart/form-data">
<input name="adCertificateIcoUpload" type="file" onchange="document.adCertificateIcoForm.submit();">
<input name="adCertificateId" type="hidden" value="<?php echo $Classify['id'];?>">
</form>
</div>   
<script>
$(document).ready(function(){
	var Form = document.ClassifyForm;
	//将一级分类下拉菜单的值赋值到text
	Form.classifyTypeSelect.onchange = function(){
		Form.ClassifyType.value = this.value;
		Form.ClassifyName.value = "";
	}
	//根据省份获取下属城市下拉菜单
	document.ClassifyForm.province.onchange = function(){
		document.ClassifyForm.area.innerHTML = "<option value=''>--区县--</option>";
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
			document.ClassifyForm.city.innerHTML = data.city;
		},"json");
	}
	//根据省份和城市获取下属区域下拉菜单
	document.ClassifyForm.city.onchange = function(){
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:document.ClassifyForm.province.value,CityPostArea:this.value},function(data){
			document.ClassifyForm.area.innerHTML = data.area;
		},"json");
	}
});
</script>
<?php echo warn().adfooter();?>