<?php 
include "../library/mFunction.php";
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
//劳务需求/优职列表
$sql = "select * from demand where ClassifyId in (select id from classify where type in ('服务/市场','私教/培训') ) ";
paging($sql," order by UpdateTime desc ",20);
$jobList = "";
$message = "
    <li class='po-co-item'>
    	<a href='javascript:;' class='clearfix po-text-box'>
            <h3 class='fl' style='padding-left:10px;color: #F44336'>没有您要的信息？去发布一条吧。</h3>
    	</a>
    	</li>
";
if($num == 0){
	$jobList = $message;
}else{
	while($array = mysql_fetch_assoc($query)){
		$kehu = query("kehu","khid = '$array[khid]'");
		$company = query("company","khid = '$kehu[khid]'");
		$UpdateTime = substr($array['UpdateTime'],0,10);
		$address = query("region", "id = '$kehu[RegionId]' ");
        //判断收费类型，根据收费类型显示内容
        if ($array['payType'] == "薪酬") {
            $pay = "{$array['pay']}/{$array['PayCycle']}";
        }
        else {
            $pay = $array['payType'];
        }
		$jobList .= "
    	<li class='po-co-item'><!--<input type='checkbox'>--><a href='{$root}m/mRecruit.php?demandMx_id={$array['id']}' class='clearfix po-text-box'><h2 class='fl' style='padding-left:10px;'>{$array['title']}</h2><span class='fr'>{$pay}</span></a></li>
		";	
	}
    $jobList .= $message;
}
echo head("m").mHeader();
?>
<!--内容-->
<form name="searchForm">
<div class='position-search-box'>
    <input name='searchPartKey' id='searchText' type='text' placeholder='请输入搜索关键词' value='' />
    <i id='searchBtn' class='index-icon-se'></i>
</div>
<section id="position-content">
	<!--详细搜索-->
    <div class="po-se-box">
    	<select name="province" class="select_width"><?php echo RepeatOption("region","province","--省份--",$_GET['province']);?></select>
                    <select name="city" class="select_width"><?php echo RepeatOption("region where province = '$_GET[province]' ","city","--城市--",$_GET['city']);?></select>
                                <select name="area" class="select_width"><?php echo IdOption("region where province = '$_GET[province]' and city = '$_GET[city]'","id","area","--区县--","");?></select>
        <?php echo RepeatSelect("classify","type","searchColumn","","劳务主项目",$ClassifyType);?>
        <select name="searchColumnChild">
			<?php echo IdOption("classify where type = '$Classify[type]' ","id","name","劳务子项目",$_GET['classifyId']);?>
        </select>
        <select name="searchSubject">
			<?php echo option("劳务主体",array("个人","商家"),"");?>
        </select>
    </div>
    </form>
	<ul class="po-content">
		<?php echo $jobList;?>
    </ul>
	<!--<div class="po-btn-box">
    	<a href="javascript:;">首页</a>
        <a href="javascript:;"><<</a>
        <a href="javascript:;"><select><option>1</option></select></a>
        <a href="javascript:;">>></a>
        <a href="javascript:;">末页</a>
    </div>-->
    <div class="po-bottom clearfix">
    	<!--<div class="check-all fl"><input type="checkbox"><span>全选</span></div>-->
        <a href="<?php echo $mUsIssue;?>" class="po-apply-btn myClick">我要发布</a>
        <!--<div class="collect fl"><i class="po-co-icon"></i><span>收藏</span></div>-->
    </div>    
</section>
<!--页脚-->
</body>
<?php echo $js;?>
</html>
<?php echo warn().mFormSubmit();?>