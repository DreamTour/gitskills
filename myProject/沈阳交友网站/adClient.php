<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$ThisUrl = $adroot."adClient.php";
$sql="select * from kehu ".$_SESSION['adClient']['Sql'];
//生成年龄下拉菜单
for($n = 18;$n <= 60;$n++){
		$option[$n] = $n."岁";
	}
$Age1 = select('searchMinAge','select TextPrice',"年龄",$option);
$Age2 = select('searchMaxAge','select TextPrice',"年龄",$option);
paging($sql," order by UpdateTime desc ",100);
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
			微信名：<input name="adClientNickName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['NickName'];?>">
			<select name="adClientSex" class="select TextPrice">
			    <option value="">--性别--</option>
				<option value="男">男</option>
				<option value="女">女</option>
			</select>
			<?php echo $Age1;?>
            <span style="margin-right:10px;">至</span>
            <?php echo $Age2;?>
            <select name="area" class="select TextPrice">
            	<?php echo IdOption("region where province = '辽宁省' and city = '沈阳市'","id","area","--区县--",$_SESSION['adClient']['area']);?>
            </select>
			手机号码：<input name="adClientTel" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['khtel'];?>">
			审核状态：<input name="adClientAuditing" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['Auditing'];?>">
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
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="ClientForm">
	<table class="TableMany">
		<tr>
			<td></td>
			<td>微信名</td>
			<td>性别</td>
			<td>地址</td>
			<td>年龄</td>
			<td>婚姻状况</td>
			<td>身高</td>
			<td>职业</td>
           	<td>审核状态</td> 
			<td>微信号</td>
			<td>手机号码</td>
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
					<td>".kong($kehu['NickName'])."</td>
					<td>".kong($kehu['sex'])."</td>
					<td>".kong($Region['city'].$Region['area'])."</td>
					<td>".kong($age)."</td> 
					<td>".kong($kehu['marry'])."</td>
					<td>".kong($kehu['height'])."</td>
					<td>".kong($kehu['Occupation'])."</td>
					<td>".kong($kehu['Auditing'])."</td>
					<td>".kong($kehu['wxNum'])."</td>
					<td>".kong($kehu['khtel'])."</td>
					<td>{$kehu['time']}</td>
					<td><a href='{$adroot}adClientMx.php?id={$kehu['khid']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='13'>一个客户都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<script>
$(document).ready(function(){
	//根据省份获取下属城市下拉菜单
	$(document).on('change','[name="Search"] [name=province]',function(){
		$.post('<?php echo root."library/OpenData.php";?>',{ProvincePostCity:$(this).val()},function(data){
			$('[name="Search"] [name=city]').html(data.city);
		},'json');
	});
	/*搜索*/
	<?php 
	echo 
	KongSele("Search.adClientSex",$_SESSION['adClient']['sex']).
	KongSele("Search.searchMinAge",$_SESSION['adClient']['minAge']).
	KongSele("Search.searchMaxAge",$_SESSION['adClient']['maxAge']);
	?>
});
</script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>