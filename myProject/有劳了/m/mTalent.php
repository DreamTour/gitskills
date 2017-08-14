<?php 
include "../library/mFunction.php";
//分类搜索
if(!empty ($_GET['search_text']) ){//首页网页顶部搜索
	$key = FormSub($_GET['search_text']);
	$where = "where title like '%$key%' or KeyWord like '%$key%' or text like '%$key%'";
		
}else if (!empty ($_GET['classifyType']) ) {//一级分类
	$classifyType = FormSub($_GET['classifyType']);
	$where = " where ClassifyId in ( select id from classify where type = '$classifyType' ) ";
}else if (!empty ($_GET['province']) and !empty ($_GET['city']) ){
	$province = FormSub($_GET['province']);
	$city = FormSub($_GET['city']);
	$where = "where khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' and city = '$city' ) ) ";	
}
//判断我要发布应该跳转的连接
if ( $kehu['type'] == "个人" ) {
	$mUsIssue =  root."m/mUser/mUsIssue.php";
	$js = "";
}
else if ( $kehu['type'] == "企业" ) {
	$mUsIssue =  root."m/mUser/mUsIssue.php";
	$js = "";
}
else{
	$mUsIssue =  "javascrit:;";
	$js = "
		<script>
		$(function() {
			$('.myClick').click(function() {
				warn('请在网站右上角选择登陆');
			})
		})
		</script>
		";
}
//劳务供给/优才列表
$sql = "select * from supply ".$where;
paging($sql," order by UpdateTime desc ",20);
$telentList = "";
$message = "
    <li class='po-co-item'>
    	<a href='javascript:;' class='clearfix po-text-box'>
            <h3 class='fl' style='padding-left:10px;color: #F44336'>没有您要的信息？去发布一条吧。</h3>
    	</a>
    	</li>
";
if($num == 0){
	$telentList = $message;
}else{
	while($array = mysql_fetch_assoc($query)){
		$kehu = query("kehu","khid = '$array[khid]'");
		$personal = query("personal","khid = '$kehu[khid]'");
		$age = date("Y") - substr($personal['Birthday'],0,4);
		//判断收费类型，根据收费类型显示内容
		if ($array['payType'] == "薪酬") {
			$pay = "{$array['pay']}/{$array['PayCycle']}";
		}
		else {
			$pay = $array['payType'];
		}
		$telentList .= "
    	<li class='po-co-item'><!--<input type='checkbox'>--><a href='{$root}m/mJobMx.php?supplyMx_id={$array['id']}' class='clearfix po-text-box'><h2 class='fl' style='padding-left:10px;'>{$array['title']}</h2><span class='fr'>{$pay}</span></a></li>
		";	
	}
	$telentList .= $message;
}
//根据劳务主项目循环对应的子项目
$classifyChildTypeSql = mysql_query("select * from classify where type = '$_GET[classifyType]' ");
$classifyChildType = "";
while ($array = mysql_fetch_array($classifyChildTypeSql)) {
	$classifyChildType .= "
		<li><a href='javascript:;' class='classifyChildType' classifyId='{$array['id']}'>{$array['name']}</a></li>
	";
}
echo head("m").mHeader();
?>
<!--内容-->
	<form name="searchForm">
		<div class='position-search-box'>
			<input name='searchTalentKey' id='searchText' type='text' placeholder='请输入搜索关键词' value='' />
			<i id='searchBtn' class='index-icon-se'></i>
		</div>
		<!--搜索标签-->
		<ul class="searchLabel clearfix">
			<?php echo $classifyChildType;?>
		</ul>
		<section id="position-content">
			<!--详细搜索-->
			<div class="po-se-box">
				<select name="province" class="select_width"><?php echo RepeatOption("region","province","--省份--",$_GET['province']);?></select>
				<select name="city" class="select_width"><?php echo RepeatOption("region where province = '$_GET[province]' ","city","--城市--",$_GET['city']);?></select>
				<select name="area" class="select_width"><?php echo IdOption("region where province = '$_GET[province]' and city = '$_GET[city]'","id","area","--区县--","");?></select>
				<?php echo RepeatSelect("classify","type","searchColumn","","劳务主项目",$classifyType);?>
				<select name="searchColumnChild">
					<?php echo IdOption("classify where type = '$classifyType' ","id","name","劳务子项目","");?>
				</select>
				<select name="searchSubject">
					<?php echo option("劳务主体",array("个人","商家"),"");?>
				</select>
			</div>
	</form>
	<ul class="po-content">
    	<?php echo $telentList;?>
    </ul>
    <div class="po-bottom clearfix">
        <a href="<?php echo $mUsIssue;?>" class="po-apply-btn myClick">我要发布</a>
    </div>    
</section>
<!--页脚-->
</body>
<script>
	window.onload = function() {
		/**
		 * 改变背景颜色
		 * @param opt 传递参数
		 * @returns {Array} 返回随机数组
		 */
		function getRandom(opt) {
			var old_arry = opt.arry,
				range = opt.range;
			//防止超过数组的长度
			range = range > old_arry.length?old_arry.length:range;
			var newArray = [].concat(old_arry), //拷贝原数组进行操作就不会破坏原数组
				valArray = [];
			for (var n = 0; n < range; n++) {
				var r = Math.floor(Math.random() * (newArray.length));
				valArray.push(newArray[r]);
				//在原数组删掉，然后在下轮循环中就可以避免重复获取
				newArray.splice(r, 1);
			}
			return valArray;
		}
		var paramArray = ["#59a3ff","#2ecc71","#2fc0f0","#fe9126","#ff6969","#ffc000","#a4cd05","#6f82cb","#59a3ff","#2ecc71"];
		var use = getRandom({
			'arry': paramArray,
			'range': 20
		});
		$('.classifyChildType').each(function(index) {
            $(this).css({background:use[index]});
        });
		//劳务子项目点击改变下拉菜单对应的值提交表单进行查询
		$("[classifyId]").click(function() {
			var classifyId = $(this).attr("classifyId");
			$("[name=searchForm] [name=searchColumnChild]").val(classifyId);
			$.post('<?php echo "{$root}library/mData.php";?>',$('[name=searchForm]').serialize(),function(data){
				$('.po-content').html(data.html);
			},'json');	
		})
	}
</script>
<?php echo $js;?>
</html>
<?php echo warn().mFormSubmit();?>