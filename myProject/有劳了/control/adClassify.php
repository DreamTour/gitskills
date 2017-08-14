<?php
include "ku/adfunction.php";
ControlRoot("分类管理");
$ThisUrl = root."control/adClassify.php";
$sql="select * from classify ".$_SESSION['adClassify']['Sql'];
paging($sql," order by time desc ",100);
echo head("ad").adheader();
?>
<div class="column minheight">
	<!--标题开始-->
	<a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/adClassify.png";?>"></a>
	<p>
		<a href="<?php echo $ThisUrl;?>">分类管理</a>
	</p>
	<!--标题结束-->
    <!--查询开始-->
	<div class="kuang">
		<form name="Search" action="<?php echo root."control/ku/adpost.php";?>" method="post">
            <?php echo RepeatSelect("classify","type","adClassifyClassifyType","text TextPrice","一级分类",$_SESSION['adClassify']['type']);?>
            <select name="adClassifyClassifyName" class="text TextPrice">
            	<?php echo IdOption("classify where type = '{$_SESSION['adClassify']['type']}' ","id","name","二级分类",$_SESSION['adClassify']['name']);?>
            </select>
            排序号：<input name="adClassifyList" type="text" class="select TextPrice" value="<?php echo $_SESSION['adClassify']['list'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
        <a href="<?php echo root."control/adClassifyMx.php";?>"><span class="SpanButton FloatRight">新建分类</span></a>
        <span onclick="EditList('ClassifyForm','DeleteClassify')" class="SpanButton FloatRight">删除分类</span>
        <span onclick="$('[name=ClassifyForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=ClassifyForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="ClassifyForm">
	<table class="TableMany">
		<tr>
        	<td></td>
			<td>一级分类</td>	
            <td>二级分类</td>
            <td>排序号</td>
            <td>更新时间</td>
			<td>创建时间</td>
        	<td></td>
		</tr>
		<?php
		if($num > 0){
			while($Classify = mysql_fetch_array($query)){
				echo "
				<tr>
					<td><input name='ClassifyList[]' type='checkbox' value='{$Classify['id']}'/></td>
					<td>{$Classify['type']}</td>
					<td>{$Classify['name']}</td>
					<td>{$Classify['list']}</td>
					<td>{$Classify['UpdateTime']}</td>
					<td>{$Classify['time']}</td>
					<td><a href='{$adroot}adClassifyMx.php?id={$Classify['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='7'>一个分类都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<script>
$(function(){
	//根据一级分类返回二级分类
	var Form = document.Search;
	Form.adClassifyClassifyType.onchange = function(){
		$.post("<?php echo root."control/ku/addata.php";?>",{adClassifyClassifyType:this.value},function(data){
			Form.adClassifyClassifyName.innerHTML = data.html;
		},"json")	
	}	
})
</script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>