<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$ThisUrl = $adroot."adClient.php";
$sql="select * from kehu ".$_SESSION['adClient']['Sql'];
paging($sql," order by time desc ",100);
echo head("ad").adheader();
?>
<style>
.adimgList{ height:38px;}
.TableMany td{height:38px;}
.adimgList:hover{ position:absolute; left:-20px; top:-20px; height:200px; z-index:100;}
</style>
<div class="column minheight">
	<a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/AdTitleClient.png";?>"></a>
	<div class="kuang">
		<form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
        	<?php echo select("adClientType","select TextPrice","--类型--",array("企业","个人"),$_SESSION['adClient']['type']);?>
			联系人姓名：<input name="adClientContactName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['ContactName'];?>">
			联系人手机号码：<input name="adClientContactTel" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['ContactTel'];?>">
			<!--身份证号：<input name="adClientIDCard" type="text" class="text TextPrice" value="<?php /*echo $_SESSION['adClient']['IDCard'];*/?>">-->
			联系邮箱：<input name="adClientEmail" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['email'];?>">
			客户ID：<input name="adClientID" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['id'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<!--<select id="ClientOrderBy" onchange="location.replace(this.options[this.selectedIndex].value);">
			<option value="<?php echo "{$adroot}adClient.php?OrderBy=";?>">按注册时间降序排列</option>
			<option value="<?php echo "{$adroot}adClient.php?OrderBy=time";?>">按注册时间升序排列</option>
			<option value="<?php echo "{$adroot}adClient.php?OrderBy=RecommendDesc";?>">按推荐人数降序排列</option>
		</select>-->
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
		<span onclick="EditList('ClientForm','ClientDelete')" class="SpanButton FloatRight">删除所选</span>
		<span onclick="$('[name=ClientForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=ClientForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        <span class="SpanButton FloatRight"><a href="<?php echo $root?>control/ku/adExcel.php">客户信息提取</a></span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="ClientForm">
	<table class="TableMany">
		<tr>
			<td></td>
            <td>类型</td>
			<td>联系人姓名</td>
			<td>联系人手机号码</td>
			<td>身份证号</td>
			<td>联系邮箱</td>
			<td>所属区域</td>
			<td>详细地址</td>
			<td>注册时间</td>
			<td style=" min-width:42px;"></td>
		</tr>
		<?php
		if($num > 0){
			while($kehu = mysql_fetch_array($query)){
				$Region = query("region", "id = '$kehu[RegionId]' ");
				$age = date("Y") - substr($kehu['Birthday'],0,4);
				echo "
				<tr>
					<td><input name='ClientList[]' type='checkbox' value='{$kehu['khid']}'/></td>
					<td>".kong($kehu['type'])."</td>
					<td>".kong($kehu['ContactName'])."</td>
					<td>".kong($kehu['ContactTel'])."</td>
					<td>".kong($kehu['IDCard'])."</td>
					<td>".kong($kehu['email'])."</td>
					<td>".kong($Region['province']."-".$Region['city']."-".$Region['area'])."</td>
					<td>".kong($kehu['AddressMx'])."</td>
					<td>{$kehu['time']}</td>
					<td><a href='{$adroot}adClientMx.php?id={$kehu['khid']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='10'>一个客户都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>