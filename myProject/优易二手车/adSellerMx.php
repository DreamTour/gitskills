<?php
include "ku/adfunction.php";
ControlRoot("商户管理");
$Seller = query("seller"," seid = '$_GET[id]' ");
if(empty($Seller['seid']) and $Seller['seid'] != $_GET['id']){
	$_SESSION['warn'] = "未找到这个商户的信息";
	header("location:{$adroot}adSeller.php");
	exit(0);
}
$Region = query("region", "id = '$Seller[RegionId]' ");
echo head("ad").adheader();
?>
<div class="column MinHeight">
	<!--标题开始-->
	<a href="<?php echo "{$adroot}adSeller.php";?>"><img src="<?php echo "{$root}img/adimg/AdTitleSeller.png";?>"></a>
	<p>
		<a href="<?php echo $adroot."adSeller.php";?>">商户管理</a>&nbsp;>&nbsp;
		<a href="<?php echo $adroot."adSellerMx.php?id=".$_GET['id'];?>"><?php echo kong($Seller['name']);?></a>
	</p>
	<!--标题结束-->
	<!--基本资料开始-->
	<div class="kuang">
		<p>
			<img src="<?php echo root."img/images/text.png";?>">
			商户基本资料
		</p>
		<form name="SellerForm">
		<table class="TableRight">
			<tr>
			    <td style="width:200px;">商户ID号：</td>
				<td><?php echo kong($Seller['seid']);?></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;商家名称：</td>
				<td><input name="SellerName" type="text" class="text" value="<?php echo $Seller['name']?>" /></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;负责人电话：</td>
				<td><input name="SellerSetel" type="text" class="text" value="<?php echo $Seller['setel']?>" /></td>
            </tr>    
			<tr>
			    <td><span class="must">*</span>&nbsp;所属区域：</td>
				<td><select name="province" class="select"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                <select name="city" class="select"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                <select name="area" class="select"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$Seller['RegionId']);?></select></td>
			</tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;详细地址：</td>
				<td><input name="SellerAddress" type="text" class="text" value="<?php echo $Seller['address']?>" /></td>
            </tr>    
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($Seller['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>创建时间：</td>
				<td><?php echo kong($Seller['time']);?></td>
			</tr>
			<tr>
			    <td><input name="adSellerId" type="hidden" value="<?php echo $Seller['seid'];?>"></td>
				<td><input onclick="Sub('SellerForm','<?php echo root."control/ku/addata.php";?>')" type="button" class="button" value="提交"></td>
			</tr>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
</div>
<script>
$(document).ready(function(){
	var Form = document.SellerForm;
	//根据省份获取下属城市下拉菜单
	Form.province.onchange = function(){
		Form.area.innerHTML = "<option value=''>--区县--</option>";
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
			Form.city.innerHTML = data.city;
		},"json");
	}
	//根据省份和城市获取下属区域下拉菜单
	Form.city.onchange = function(){
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:Form.province.value,CityPostArea:this.value},function(data){
			Form.area.innerHTML = data.area;
		},"json");
	}
});
</script>
<?php echo warn().adfooter();?>