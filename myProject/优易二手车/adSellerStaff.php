<?php
include "ku/adfunction.php";
ControlRoot("商户管理");
$ThisUrl = root."control/adSellerStaff.php";
$sql="select * from SellerStaff ".$_SESSION['adSellerStaff']['Sql'];
paging($sql," order by time desc ",100);
echo head("ad").adheader();
?>
<div class="column minheight">
	<!--标题开始-->
	<a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/AdTitleSeller.png";?>"></a>
	<p>
		<a href="<?php echo root."control/adSeller.php";?>">商户管理</a>&nbsp;&nbsp;>&nbsp;
        <a href="<?php echo root."control/adSellerStaff.php";?>">员工管理</a>
	</p>
	<!--标题结束-->
    <!--查询开始-->
	<div class="kuang">
    	<form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
			员工姓名：<input name="adSellerStaffName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adSellerStaff']['name'];?>">	
            员工手机号码：<input name="adSellerStaffTel" type="text" class="text TextPrice" value="<?php echo $_SESSION['adSellerStaff']['tel'];?>">
            本员工的微信OpenId：<input name="adSellerStaffOpenId" type="text" class="text TextPrice" value="<?php echo $_SESSION['adSellerStaff']['OpenId'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
        <a href="<?php echo root."control/adSellerStaffMx.php";?>"><span class="SpanButton FloatRight">新建员工</span></a>
        <span onclick="EditList('SellerStaffForm','DeleteSellerStaff')" class="SpanButton FloatRight">删除员工</span>
        <span onclick="$('[name=SellerStaffForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=SellerStaffForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="SellerStaffForm">
	<table class="TableMany">
		<tr>
        	<td></td>
            <td>商户名称</td>
			<td>员工姓名</td>
			<td>员工手机号码</td>
            <td>本员工的微信OpenId</td>
			<td>更新时间</td>
            <td></td>
		</tr>
		<?php
		if($num > 0){
			while($SellerStaff = mysql_fetch_array($query)){
				$seller = query("seller", "seid = '$SellerStaff[seid]' ");
				echo "
				<tr>
					<td><input name='SellerStaffList[]' type='checkbox' value='{$SellerStaff['id']}'/></td>
					<td>{$seller['name']}</td>
					<td>{$SellerStaff['name']}</td>
					<td>{$SellerStaff['tel']}</td>
					<td>{$SellerStaff['OpenId']}</td>
					<td>{$SellerStaff['UpdateTime']}</td>
					<td><a href='{$adroot}adSellerStaffMx.php?id={$SellerStaff['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='7'>一个员工都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>