<?php
include "ku/adfunction.php";
ControlRoot("需求管理");
$ThisUrl = $adroot."adDemand.php";
$sql="select * from demand ".$_SESSION['adDemand']['Sql'];
paging($sql," order by time desc ",100);
echo head("ad").adheader();
?>
<style>
.adimgList{ height:38px;}
.TableMany td{height:38px;}
.adimgList:hover{ position:absolute; left:-20px; top:-20px; height:200px; z-index:100;}
</style>
<div class="column minheight">
	<a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/adDemand.png";?>"></a>
	<div class="kuang">
		<form name="Search" action="<?php echo "{$root}control/ku/adpost.php";?>" method="post">
       		<?php echo RepeatSelect("classify","type","adDemandClassifyType","text TextPrice","一级分类",$_SESSION['adDemand']['ClassifyType']);?>
            <select name="adDemandClassifyName" class="text TextPrice">
            	<?php echo IdOption("classify where type = '{$_SESSION['adDemand']['ClassifyType']}' ","id","name","二级分类",$_SESSION['adDemand']['ClassifyName']);?>
            </select>
			方式：<input name="adDemandMode" type="text" class="text TextPrice" value="<?php echo $_SESSION['adDemand']['mode'];?>">
			面向：<input name="adDemandFace" type="text" class="text TextPrice" value="<?php echo $_SESSION['adDemand']['face'];?>">
			类型：<input name="adDemandType" type="text" class="text TextPrice" value="<?php echo $_SESSION['adDemand']['type'];?>">
            标题：<input name="adDemandTitle" type="text" class="text TextPrice" value="<?php echo $_SESSION['adDemand']['title'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<!--<select id="DemandOrderBy" onchange="location.replace(this.options[this.selectedIndex].value);">
			<option value="<?php echo "{$adroot}adDemand.php?OrderBy=";?>">按注册时间降序排列</option>
			<option value="<?php echo "{$adroot}adDemand.php?OrderBy=time";?>">按注册时间升序排列</option>
			<option value="<?php echo "{$adroot}adDemand.php?OrderBy=RecommendDesc";?>">按推荐人数降序排列</option>
		</select>-->
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
		<span onclick="EditList('DemandForm','DemandDelete')" class="SpanButton FloatRight">删除所选</span>
		<span onclick="$('[name=DemandForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=DemandForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="DemandForm">
	<table class="TableMany">
		<tr>
			<td></td>
            <td>一级分类</td>
			<td>二级分类</td>
			<td>方式</td>
			<td>面向</td>
			<td>收费</td>
			<td>类型</td>
			<td>标题</td>
			<td>注册时间</td>
			<td style=" min-width:42px;"></td>
		</tr>
		<?php
		if($num > 0){
			while($demand = mysql_fetch_array($query)){
				$classify = query("classify", "id = '$demand[ClassifyId]' ");
				//判断收费类型，根据收费类型显示内容
				if ($demand['payType'] == "薪酬") {
					$pay = "{$demand['pay']}/{$demand['PayCycle']}";
				}
				else {
					$pay = $demand['payType'];
				}
				echo "
				<tr>
					<td><input name='DemandList[]' type='checkbox' value='{$demand['id']}'/></td>
					<td>".kong($classify['type'])."</td>
					<td>".kong($classify['name'])."</td>
					<td>".kong($demand['mode'])."</td>
					<td>".kong($demand['face'])."</td>
					<td>".$pay."</td>
					<td>".kong($demand['type'])."</td>
					<td>".kong($demand['title'])."</td>
					<td>{$demand['time']}</td>
					<td><a href='{$adroot}adDemandMx.php?id={$demand['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='10'>一个需求都没有</td></tr>";
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
	Form.adDemandClassifyType.onchange = function(){
		$.post("<?php echo root."control/ku/addata.php";?>",{adDemandClassifyType:this.value},function(data){
			Form.adDemandClassifyName.innerHTML = data.html;
		},"json")	
	}	
})
</script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>