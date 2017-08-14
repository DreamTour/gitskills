<?php
include "ku/adfunction.php";
ControlRoot("消息管理");
$ThisUrl = $adroot."adMessage.php";
$sql = "select * from talk ".$_SESSION['adMessage']['Sql'];
paging($sql," order by time desc",100);
echo head("ad").adheader();
?>
<div class="column minheight">
    <a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/adMessage.png";?>"></a>
    <!--查询开始-->
	<div class="kuang">
		<form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
        	消息类型：<input name="adMessageType" type="text" class="text TextPrice" value="<?php echo $_SESSION['adMessage']['type'];?>">
			消息标题：<input name="adMessageTitle" type="text" class="text TextPrice" value="<?php echo $_SESSION['adMessage']['title'];?>">
			消息内容： <input name="adMessageText" type="text" class="text TextPrice" value="<?php echo $_SESSION['adMessage']['text'];?>">
            审核状态：<input name="adMessageAuditing" type="text" class="text TextPrice" value="<?php echo $_SESSION['adMessage']['Auditing'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
<!--		<a href="<?php echo "{$adroot}adMessage.php";?>"><span class="SpanButton FloatRight">新建消息</span></a>-->
        <span onclick="EditList('messageForm','DeleteMessage')" class="SpanButton FloatRight">删除消息</span>
        <span onclick="$('[name=messageForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=messageForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="messageForm">
	<table class="TableMany">
		<tr>
			<td></td>
			<td>类型</td>
            <td width="15%">标题</td>
			<td width="50%">内容</td>
            <td>浏览量</td>
			<td>审核状态</td>
			<td>创建时间</td>
			<td></td>
		</tr>
		<?php
		if($num > 0){
			while($message = mysql_fetch_array($query)){
				echo "
				<tr>
					<td><input name='messageList[]' type='checkbox' value='{$message['id']}'/></td>
					<td>{$message['type']}</td>
					<td>{$message['title']}</td>
					<td>{$message['text']}</td>
					<td>{$message['num']}</td>
					<td>{$message['Auditing']}</td>
					<td>{$message['time']}</td>
					<td><a href='{$adroot}adMessageMx.php?id={$message['id']}'><span class='SpanButton'>详情</span></a></td>
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