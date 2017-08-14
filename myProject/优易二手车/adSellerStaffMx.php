<?php
include "ku/adfunction.php";
ControlRoot("商户管理");
if(empty($_GET['id'])){
    $title = "新建员工";	
}else{
	$SellerStaff = query("SellerStaff"," id = '$_GET[id]' ");
	if($SellerStaff['id'] != $_GET['id']){
		$_SESSION['warn'] = "未找到这个商户员工信息";
		header("location:{$root}control/adSellerStaff.php");
		exit(0);
	}
    $title = $SellerStaff['name'];	
}
$seller = query("seller", "seid = '$SellerStaff[seid]' ");
echo head("ad").adheader();
?>
<div class="column MinHeight">
	<!--标题开始-->
	<a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/AdTitleSeller.png";?>"></a>
	<p>
		<a href="<?php echo root."control/adSeller.php";?>">商户管理</a>&nbsp;&nbsp;>&nbsp;
        <a href="<?php echo root."control/adSellerStaff.php";?>">员工管理</a>&nbsp;&nbsp;>&nbsp;
        <a href="<?php echo $ThisUrl;?>"><?php echo $title;?></a>
	</p>
	<!--标题结束-->
	<!--基本资料开始-->
	<div class="kuang">
		<p>
			<img src="<?php echo root."img/images/text.png";?>">
			员工基本资料
		</p>
		<form name="SellerStaffForm">
		<table class="TableRight">
			<tr>
			    <td style="width:200px;">员工ID号：</td>
				<td><?php echo kong($SellerStaff['id']);?></td>
			</tr>
            <tr>
			    <td><span class="must">*</span>&nbsp;商户名称：</td>
				<td>
                 <select name="sellerName" class="select">
                	<?php echo IdOption("seller","seid","name","--选择--",$seller['seid']);?>
                 </select>
                </td>
			</tr>
            <tr>
            	<td><span class="must">*</span>&nbsp;员工姓名：</td>
                <td><input name="SellerStaffName" type="text" class="text" value="<?php echo $SellerStaff['name']?>" /></td>
            </tr>
            <tr>
            	<td><span class="must">*</span>&nbsp;员工手机号码：</td>
                <td><input name="SellerStaffTel" type="text" class="text" value="<?php echo $SellerStaff['tel']?>" /></td>
            </tr>
            <tr>
            	<td><span class="must">*</span>&nbsp;本员工的微信OpenId：</td>
                <td><input name="SellerStaffOpenId" type="text" class="text" value="<?php echo $SellerStaff['OpenId']?>" /></td>
            </tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($SellerStaff['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>创建时间：</td>
				<td><?php echo kong($SellerStaff['time']);?></td>
			</tr>
			<tr>
			    <td><input name="adSellerStaffId" type="hidden" value="<?php echo $SellerStaff['id'];?>"></td>
				<td><input onclick="Sub('SellerStaffForm','<?php echo root."control/ku/addata.php";?>')" type="button" class="button" value="提交"></td>
			</tr>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
</div>
<?php echo warn().adfooter();?>