<?php 
include "library/PcFunction.php";
//获取查询时的一级分类名称
if(empty($_GET['classifyId'])){
	$ClassifyType = $_GET['classifyType'];		
}else{
	$Classify = query("classify","id = '$_GET[classifyId]' ");
	$ClassifyType = $Classify['type'];	
}
//劳务供给/优才列表
if (!empty ($_GET['search_text']) ) {//网页顶部搜索
	$key = FormSub($_GET['search_text']);
	$where = "where title like '%$key%' or KeyWord like '%$key%' or text like '%$key%'";	
	
}
else if (!empty ($_GET['classifyType']) ) {//一级分类
	$classifyType = FormSub($_GET['classifyType']);
	$where = " where ClassifyId in ( select id from classify where type = '$classifyType' ) ";
	
}
else if (!empty ($_GET['classifyId']) ) {//二级分类
	$classifyId = FormSub($_GET['classifyId']);
	$where = " where ClassifyId = '$classifyId' ";
	
}
else if (!empty ($_GET['province']) and !empty ($_GET['city']) ){
	$province = FormSub($_GET['province']);
	$city = FormSub($_GET['city']);
	$where = "where khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' and city = '$city' ) ) ";	
}
$sql = "select * from supply ".$where;
paging($sql," order by UpdateTime desc ",20);
$telentList = "";
$message = "<ul class='search-co-list clearfix'><li style='color: #F44336;'>没有您要的信息?去发布一条吧！</li></ul>";
if($num == 0){
	$telentList = $message;
}
else{
	while($array = mysql_fetch_assoc($query)){
		$client = query("kehu","khid = '$array[khid]'");
		$personal = query("personal","khid = '$client[khid]'");
		$age = date("Y") - substr($personal['Birthday'],0,4);
		//判断是企业供给的情况下性别，年龄，学历是否为空
		if ($personal['sex'] == "") {
			$personal['sex'] = "--";
		}
		if ($age == "2017") {
			$age = "--";
		}
		if ($personal['EducationLevel'] == "") {
			$personal['EducationLevel'] = "--";
		}
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
		//打印供给列表 
		$telentList .= "
			<ul class='search-co-list clearfix'>
				<a href='{$root}JobMx.php?supplyMx_id={$array['id']}' style='display:inline-block'>
					<li class='search-ta01'><input name='items' type='checkbox'>{$array['title']}</li>
					<li class='search-ta02'>{$ContactName}</li>
					<li class='search-ta03'>{$personal['sex']}</li>
					<li class='search-ta04'>{$age}</li>
					<li class='search-ta05'>{$personal['EducationLevel']}</li>
					<li class='search-ta06'>{$pay}</li>
				</a>
			</ul>
		";	
	}
	$telentList .= $message;
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
                	<select name="province" class="select_width"><?php echo RepeatOption("region","province","--省份--",$_GET['province']);?></select>
                    <select name="city" class="select_width"><?php echo RepeatOption("region where province = '$_GET[province]' ","city","--城市--",$_GET['city']);?></select>
                                <select name="area" class="select_width"><?php echo IdOption("region where province = '$_GET[province]' and city = '$_GET[city]'","id","area","--区县--","");?></select>
                </li>
            	<li class="search-item"><span>一级分类</span>
                	<?php echo RepeatSelect("classify","type","searchColumn","","请选择劳务主项目",$ClassifyType);?>
                </li>
                <li class="search-item"><span>二级分类</span>
                	<select name="searchColumnChild">
                    	<?php echo IdOption("classify where type = '$Classify[type]' ","id","name","请选择劳务子项目",$_GET['classifyId']);?>
                    </select>
                </li>
                <li class="search-item" style="margin-right:0"><span>关键词</span>
                	<input name="searchTalentKey" type="text" placeholder="请输入搜索关键词" />
                </li>
            </ul>
            <ul class="search-detail">
            	<!--商家没有年龄-->
                <!--<li class="clearfix hot-place-box">
                	<span class="de-title fl">年龄范围</span>
                    <p class="fl hot-place" id="searchJobTag">
                    	<a href="javascript:;" minYear='0' maxYear='100'>不限</a>
                    	<a href="javascript:;" minYear='16' maxYear='20'>16-20岁</a>
                        <a href="javascript:;" minYear='21' maxYear='30'>21-30岁</a>
                        <a href="javascript:;" minYear='31' maxYear='40'>31-40岁</a>
                        <a href="javascript:;" minYear='41' maxYear='50'>41-50岁</a>
                        <a href="javascript:;" minYear='50' maxYear='100'>50岁以上</a>
                    </p>
                </li>-->
                
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
                    <a href="javascript:;" class="search-co-btn fl fz16 col1"  id="searchTelentButton">点击搜索</a>
                </li>
            </ul>
       </div>
       <input name="searchMinYear" type="hidden" />
       <input name="searchMaxYear" type="hidden" />
       </form>
       <!--搜索内容-->
       <div class="search-content-box">
       		<div class="search-co-head">
                <input name="checkedAll" type="checkbox" value="全选"><span class="fz14">全选</span>
                <a href="<?php echo "{$root}user/user.php";?>" class="apply-btn">我要发布</a>
                <!--<a href="javascript:;" class="collect-btn">收藏</a>-->
            </div>
            <div class="search-co-content" id="searchJobTag">
            	<ul class="search-co-title clearfix">
                	<li class="search-ta01">劳务供给</li>
                    <li class="search-ta02">供给方</li>
                    <li class="search-ta03">性别</li>
                    <li class="search-ta04">年龄</li>
                    <li class="search-ta05">学历</li>
                    <li class="search-ta06">薪酬</li>
                </ul>
                <div class="search-co-body">
                	<?php echo $telentList;?>
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
	$('#searchTelentButton').click(function(){
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
		items.each(function() {
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
	//点击搜索标签	
	var searchJobTag = $('#searchJobTag>a');
	searchJobTag.click(function(){
		var minYear = $(this).attr('minYear');
		var maxYear = $(this).attr('maxYear');
		$(this).addClass('searchJobTag').siblings().removeClass('searchJobTag');
		$('[name=searchMinYear]').val(minYear);	
		$('[name=searchMaxYear]').val(maxYear);
	})
})
</script>
<?php echo pcFooter().warn();?>