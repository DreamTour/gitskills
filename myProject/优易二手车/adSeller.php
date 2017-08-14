<?php
include "ku/adfunction.php";
ControlRoot("商户管理");
$ThisUrl = $adroot."adSeller.php";
$sql="select * from seller ".$_SESSION['adSeller']['Sql'];
paging($sql," order by time desc ",100);
echo head("ad").adheader();
?>
<style>
.adimgList{ height:38px;}
.TableMany td{height:38px;}
.adimgList:hover{ position:absolute; left:-20px; top:-20px; height:200px; z-index:100;}
</style>
<div class="column minheight">
	<a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/AdTitleSeller.png";?>"></a>
	<div class="kuang">
		<form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
			商家名称：<input name="adSellerName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adSeller']['name'];?>">
			负责人电话：<input name="adSellerSetel" type="text" class="text TextPrice" value="<?php echo $_SESSION['adSeller']['setel'];?>">
            详细地址：<input name="adSellerAddress" type="text" class="text TextPrice" value="<?php echo $_SESSION['adSeller']['address'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<!--<select id="ClientOrderBy" onchange="location.replace(this.options[this.selectedIndex].value);">
			<option value="<?php echo "{$adroot}adSeller.php?OrderBy=";?>">按注册时间降序排列</option>
			<option value="<?php echo "{$adroot}adSeller.php?OrderBy=time";?>">按注册时间升序排列</option>
			<option value="<?php echo "{$adroot}adSeller.php?OrderBy=RecommendDesc";?>">按推荐人数降序排列</option>
		</select>-->
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
        <a href="<?php echo root."control/adSellerMx.php";?>"><span class="SpanButton FloatRight">新建商户</span></a>
        <a href="<?php echo root."control/adSellerStaff.php";?>"><span class="SpanButton FloatRight">员工管理</span></a>
		<span onclick="EditList('SellerForm','DeleteSeller')" class="SpanButton FloatRight">删除所选</span>
		<span onclick="$('[name=SellerForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=SellerForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="SellerForm">
	<table class="TableMany">
		<tr>
			<td></td>
			<td>商家名称</td>
			<td>负责人电话</td>
            <td>所属区域</td>
			<td>详细地址</td>
			<td>更新时间</td>
			<td>创建时间</td>
			<td></td>
		</tr>
		<?php
		if($num > 0){
			while($Seller = mysql_fetch_array($query)){
				$Region = query("region", "id = '$Seller[RegionId]' ");
				$age = date("Y") - substr($Seller['Birthday'],0,4);
				echo "
				<tr>
					<td><input name='SellerList[]' type='checkbox' value='{$Seller['seid']}'/></td>
					<td>".kong($Seller['name'])."</td>
					<td>".kong($Seller['setel'])."</td>
					<td>".kong($Region['province']."-".$Region['city']."-".$Region['area'])."</td>
					<td>".kong($Seller['address'])."</td>
					<td>{$Seller['UpdateTime']}</td>
					<td>{$Seller['time']}</td>
					<td><a href='{$adroot}adSellerMx.php?id={$Seller['seid']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='8'>一个商户都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>