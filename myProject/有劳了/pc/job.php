<?php 
include "library/PcFunction.php";
//获取查询时的一级分类名称
if(empty($_GET['classifyId'])){
	$ClassifyType = $_GET['classifyType'];		
}else{
	$Classify = query("classify","id = '$_GET[classifyId]' ");
	$ClassifyType = $Classify['type'];	
}
//劳务需求/优职列表
//查询分类
if (!empty ($_GET['classifyType']) ) {//一级分类
	$classifyType = FormSub($_GET['classifyType']);
	$where = " where ClassifyId in ( select id from classify where type = '$classifyType' ) ";
	
}else if (!empty ($_GET['classifyId']) ) {//二级分类
	$classifyId = FormSub($_GET['classifyId']);
	$Classify = query("classify","id = '$_GET[classifyId]' ");
	$where = " where ClassifyId = '$classifyId' ";
}
$sql = "select * from demand ".$where;
paging($sql," order by UpdateTime desc ",20);
$jobList = "";
$message = "<ul class='search-co-list clearfix'><li style='color: #F44336;'>没有您要的信息?去发布一条吧！</li></ul>";
if($num == 0){
	$jobList = $message;
}else{
	while($array = mysql_fetch_assoc($query)){
		$client = query("kehu","khid = '$array[khid]'");
		$company = query("company","khid = '$client[khid]'");
		$UpdateTime = substr($array['UpdateTime'],0,10);
		$address = query("region", "id = '$client[RegionId]' ");
		//判断收费类型，根据收费类型显示内容
		if ($array['payType'] == "薪酬") {
			$pay = "{$array['pay']}/{$array['PayCycle']}";
		}
		else {
			$pay = $array['payType'];
		}
		//判断我是个人还是商家，显示对应的名称
		if ($array['IdentityType'] == "商家") {
			$ContactName = $array['CompanyName'];
		}
		else {
			$ContactName = $client['ContactName'];
		}
		$jobList .= "
			<ul class='search-co-list clearfix'>
				<a href='{$root}recruit.php?demandMx_id={$array['id']}' style='display:inline-block'>
					<li class='search-co01'><input name='items' type='checkbox'>{$array['title']}</li>
					<li class='search-co02'>{$ContactName}</li>
					<li class='search-co03'>{$address['city']}-{$address['area']}</li>
					<li class='search-co04'>{$pay}</li>
					<li class='search-co05'>{$UpdateTime}</li>
				</a>
			</ul>
		";
	}
	$jobList .= $message;
}
echo head("pc").pcHeader();
?>
<!--内容-->
<div class="info-container"> 
   <!--导航-->
    <?php echo pcNavigation();?>
    <!--row-->
    <div class="row">
    	<!--条件搜索-->
        <form name="searchForm">
       <div class="search-condition">
       		<ul class="search-head clearfix">
                <li class="search-item"><span>工作地点</span>
                	<select name="province" class="select_width"><?php echo RepeatOption("region","province","--省份--",$_SESSION['searchJob']['province']);?></select>
                    <select name="city" class="select_width"><?php echo RepeatOption("region where province = '{$_SESSION['searchJob']['province']}' ","city","--城市--",$_SESSION['searchJob']['city']);?></select>
                                <select name="area" class="select_width"><?php echo IdOption("region where province = '{$_SESSION['searchJob']['province']}' and city = '{$_SESSION['searchJob']['city']}'","id","area","--区县--",$_SESSION['searchJob']['area']);?></select>
                </li>
            	<li class="search-item"><span>一级分类</span>
                	<?php echo RepeatSelect("classify","type","searchColumn","","请选择劳务主项目",$ClassifyType);?>
                </li>
                <li class="search-item"><span>二级分类</span>
                	<select name="searchColumnChild">
                    	<?php echo IdOption("classify where type = '$ClassifyType[type]' ","id","name","请选择劳务子项目",$Classify['id']);?>
                    </select>
                </li>
                <li class="search-item" style="margin-right:0"><span>关键词</span>
                	<input name="searchJobKey" type="text" placeholder="请输入搜索关键词" />
                </li>
            </ul>
            <ul class="search-detail">
                <li class="clearfix hot-place-box">
                    <span class="de-title fl">更多筛选</span>
                    <div class="fl search-select">
						<select name="searchMoney">
							<?php echo option("薪酬",array("面议","如约","0-1999","2000-4999","5000-9999","10000-19999","20000及以上"),"");?>
						</select>
                        <select name="searchType">
							<?php echo option("类型",array("全职","兼职"),"");?>
                        </select>
                        <select name="searchMode">
							<?php echo option("方式",array("上门","如约"),"");?>
                        </select>
                        <select name="searchSubject">
							<?php echo option("主体",array("个人","商家"),"");?>
                        </select>
                    </div>
                    <a href="javascript:;" class="search-co-btn fl fz16 col1" id="searchJobButton">点击搜索</a>
                </li>
            </ul>
       </div>
       </form>
       <!--搜索内容-->
       <div class="search-content-box">
       		<div class="search-co-head">
                <input name="checkedAll" type="checkbox" value="全选"><span class="fz14">全选</span>
                <a href="<?php echo "{$root}user/user.php";?>" class="apply-btn">我要发布</a>
                <!--<a href="javascript:;" class="collect-btn">收藏</a>-->
            </div>
            <div class="search-co-content">
            	<ul class="search-co-title clearfix">
                	<li class="search-co01">劳务需求</li>
                    <li class="search-co02">需求方</li>
                    <li class="search-co03">工作地点</li>
                    <li class="search-co04">薪酬</li>
                    <li class="search-co05">发布时间</li>
                </ul>
                <div class="search-co-body">
                	<?php echo $jobList;?>
                </div>
            </div>
            <div class="search-co-head">
                <input name="checkedAll" type="checkbox" value="全选"><span class="fz14">全选</span>
                <a href="<?php echo "{$root}user/user.php";?>" class="apply-btn">我要发布</a>
                <!--<a href="javascript:;" class="collect-btn">收藏</a>-->
            </div>
       </div>
         <!--按钮-->
        <div class="page_btn_box">
            <div class="activity_btn"><?php echo fenye($ThisUrl,7);?></div>			
       </div>
    </div>
    <!--row-->
</div>
<!--页脚-->
<script>
$(document).ready(function(){
	var Form = document.searchForm;
	//根据省份获取下属城市下拉菜单
	Form.province.onchange = function(){
		Form.area.innerHTML = "<option value=''>--区县--</option>";
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
			Form.city.innerHTML = data.city;
		},"json");
	}
	//根据省份和城市获取下属区域下拉菜单
	Form.city.onchange = function(){
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:Form.province.value,CityPostArea:this.value},function(data){
			Form.area.innerHTML = data.area;
		},"json");
	}
	//搜索根据主项目返回子项目
	Form.searchColumn.onchange = function(){
		$.post("<?php echo root."library/PcData.php";?>",{searchColumnTwoChild:this.value},function(data){
			Form.searchColumnChild.innerHTML = data.ColumnChild;
		},"json");	
	}
	//搜索表单提交
	$('#searchJobButton').click(function(){
		$.post("<?php echo root."library/PcData.php";?>",$("[name=searchForm]").serialize(),function(data){
			console.log($("[name=searchForm]").serialize());
			$('.search-co-body').html(data.html);
		},"json");	
	});
	//选择/不选择全部
	var items = $('[name=items]:checkbox');
	var checkedAll = $('[name=checkedAll]');
	checkedAll.click(function(){
		if(this.checked){
			items.prop('checked', true);
		}else{
			items.prop('checked', false);	
		}	
	})
	items.click(function(){
		var flag = true;
		items.each(function(index, element) {
            if(!this.checked){
				flag = false;	
			}
			if(flag){
				checkedAll.prop('checked', true);	
			}else{
				checkedAll.prop('checked', false);	
			}
        });	
	})
})
</script>
<?php echo pcFooter().warn();?>
