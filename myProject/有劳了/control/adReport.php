<?php
include "ku/adfunction.php";
ControlRoot("举报管理");
$ThisUrl = $adroot."adReport.php";
$sql = "select * from report ".$_SESSION['adReport']['Sql'];
//生成年龄下拉菜单
for($n = 18;$n <= 60;$n++){
		$option[$n] = $n."岁";
	}
$Age1 = select('searchMinAge','select TextPrice',"年龄",$option);
$Age2 = select('searchMaxAge','select TextPrice',"年龄",$option);
paging($sql," order by time desc",100);
echo head("ad").adheader();
?>
<div class="column minheight">
    <a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/adReport.png";?>"></a>
    <!--查询开始-->
	<div class="kuang">
		<form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
            劳务类型：<input name="SearchReportType" type="text" class="text TextPrice" value="<?php echo $_SESSION['adReport']['type'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
        <span onclick="EditList('ReportForm','ReportDelete')" class="SpanButton FloatRight">删除所选</span>
		<span onclick="$('[name=ReportForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=ReportForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="ReportForm">
	<table class="TableMany">
		<tr>
			<td></td>
			<td>劳务标题</td>
			<td>劳务类型</td>
			<td>被举报客户</td>
			<td>劳务说明</td>
            <td>举报原因</td>
			<td>创建时间</td>
            <td></td>
		</tr>
		<?php
		if($num > 0){
			while($Report = mysql_fetch_array($query)){
				$client = query("kehu","khid = '$Report[khid]'"); //客户表
				$demand = query("demand","khid = '$client[khid]'"); //优职表
				$supply = query("supply","khid = '$client[khid]'");	//供给表
				if ($Report['type'] == "优职") {
					$title = $demand['title'];	//劳务标题
					$text = $demand['text'];	//劳务说明
					$url = "adDemandMx.php";	//详情地址
					$urlId = $demand['id'];	//跳转链接的ID号
				} else if ($Report['type'] == "优才") {
					$title = $supply['title'];	//同上
					$text = $supply['text'];
					$url = "adSupplyMx.php";
					$urlId = $supply['id'];
				}
				echo "
				<tr>
					<td><input name='ReportList[]' type='checkbox' value='{$Report['id']}'/></td>
					<td>{$title}</td>
					<td>{$Report['type']}</td>
					<td>{$client['ContactName']}</td>
					<td>{$text}</td>
					<td>{$Report['content']}</td>
					<td>{$time}</td>
					<td><a href='{$adroot}{$url}?id={$urlId}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='8'>一条信息都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<?php echo PasWarn("{$adroot}ku/addata.php").warn().adfooter();?>