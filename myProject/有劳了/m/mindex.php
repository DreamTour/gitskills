<?php 
include "../library/mFunction.php";
//劳务需求/优职列表
$demandSql = mysql_query("select * from demand order by UpdateTime desc limit 5 ");
$jobNum = mysql_num_rows($demandSql);
$jobList = "";
if($jobNum == 0){
	$jobList = "一条优职信息都没有";	
}else{
	while($array = mysql_fetch_assoc($demandSql)){
		//判断收费类型，根据收费类型显示内容
		if ($array['payType'] == "薪酬") {
			$pay = "{$array['pay']}/{$array['PayCycle']}";
		}
		else {
			$pay = $array['payType'];
		}
		$jobList .= "
				<li class='clearfix index-po-item'><a href='{$root}m/mRecruit.php?demandMx_id={$array['id']}'><span class='fl'>{$array['title']}</span><s class='fr'>{$pay}</s></a></li>
		";	
	}
	
}
//劳务供给/优才列表
$supplySql = mysql_query("select * from supply order by UpdateTime desc limit 5 ");
$telentNum = mysql_num_rows($supplySql);
$telentList = "";
if($telentNum == 0){
	$telentList = "一条优才信息都没有";	
}else{
	while($array = mysql_fetch_assoc($supplySql)){
		//判断收费类型，根据收费类型显示内容
		if ($array['payType'] == "薪酬") {
			$pay = "{$array['pay']}/{$array['PayCycle']}";
		}
		else {
			$pay = $array['payType'];
		}
		$telentList .= "
        	<li class='clearfix index-po-item'><a href='{$root}m/mJobMx.php?supplyMx_id={$array['id']}'><span class='fl'>{$array['title']}</span><s class='fr'>{$pay}</s></a></li>
		"; 	
	} 
}
//劳务需求//学生兼职
$partTimeJobSql = mysql_query("select * from demand where ClassifyId in (select id from classify where type in ('服务/市场','私教/培训') ) order by UpdateTime desc limit 5 ");
$partTimeJobNum = mysql_num_rows($partTimeJobSql);
$partTimeJobList = "";
if($partTimeJobNum == 0){
	$partTimeJobList = "一条学生兼职都没有";	
}else{
	while($array = mysql_fetch_assoc($partTimeJobSql)){
		//判断收费类型，根据收费类型显示内容
		if ($array['payType'] == "薪酬") {
			$pay = "{$array['pay']}/{$array['PayCycle']}";
		}
		else {
			$pay = $array['payType'];
		}
		$partTimeJobList .= "
        	<li class='clearfix index-po-item'><a href='{$root}m/mRecruit.php?demandMx_id={$array['id']}'><span class='fl'>{$array['title']}</span><s class='fr'>{$pay}</s></a></li>
		";	
	}
}
//资讯中心
$sql = mysql_query("select * from content where type = '热点资讯' order by UpdateTime desc limit 5 ");
$sqlNum = mysql_num_rows(mysql_query("select * from content where type = '热点资讯'"));
$news = "";
if($sqlNum == 0){
	$news = "一条资讯都没有";	
}else{
	while($array = mysql_fetch_assoc($sql)){
		$news .= "
        	<li class='clearfix index-po-item'><a href='{$root}m/mNewsMx.php?News_id={$array['id']}'><span class='fl'>{$array[title]}</span><s class='fr'>[查看详情]</s></a></li>
		";
	}
}
//判断登录注册
if($GLOBALS['KehuFinger'] == 2) {
	$login = "<a href='{$root}m/mSeller/mSeLogin.php'>企业登录</a>丨<a href='{$root}m/mUser/mUsLogin.php'>个人登录</a>";
} else{
	$login = "<a id='outLogin' href='{$root}m/mindex.php?delete=client'>退出登录</a>";
}
//首页循环分类
$classifyTypeSql = mysql_query("select distinct type from classify order by list limit 8");
$classify = "";
$count = 1;
while($array = mysql_fetch_assoc($classifyTypeSql)){
	$classify .= "
		<li class='nav-list'>
        	<a href='{$root}m/mTalent.php?classifyType={$array['type']}'>
            	<i class='classifyIcon{$count}'></i>
                <p>{$array['type']}</p>
            </a>
        </li>
	";
	$count++;
}
echo head("m");
?>
<!--页眉-->
<header id="top">
	<div class="index-top clearfix">
    	<a href="<?php echo $root;?>m/mindex.php"><img src="<?php echo img("oqX58150379Bb");?>" class="fl"></a>
        <div class="fr login-box">
            <?php echo $login;?>
        </div>
    </div>
    <div class="search-box">
        <input id='searchText' type="text" placeholder="搜优才"  value="<?php echo $_GET['search_text'];?>" />
<!--        <div class="index-position"><span>昆明</span><i class="index-icon-po"></i></div>-->
        <i class="index-icon-se" id='searchBtn'></i>
    </div>
</header>
<!--内容-->
<section>
	<!--导航-->
	<ul class="home-nav clearfix">
        <?php echo $classify;?>
    </ul>
    <!--广告-->
    <div class="ad"><a href="javascript:;"><img src="<?php echo img("Vls58315686MZ");?>"></a></div>
    <!--优职-->
    <div class="position-box">
    	<div class="position-header clearfix">
			<i class="fl index-nav-icon index-nav-icon1"></i>
			<a href="<?php echo $root;?>m/mJob.php"><h2 class="fl">优职</h2></a>
			<a href="<?php echo $root;?>m/mJob.php" class="fr">更多>></a>
		</div>
        <ul class="index-po-list">
			<?php echo $jobList;?>
        </ul>
    </div>
    <!--优才-->
    <div class="talents-box">
    	<div class="talents-header clearfix">
			<i class="fl index-nav-icon index-nav-icon2"></i>
			<a href="<?php echo $root;?>m/mTalent.php"><h2 class="fl">优才</h2></a>
			<a href="<?php echo $root;?>m/mTalent.php" class="fr">更多>></a></div>
        <ul class="index-po-list">
			<?php echo $telentList;?>
        </ul>
    </div>
    <!--学生兼职-->
    <div class="partTime-box">
    	<div class="partTime-header clearfix">
			<i class="fl index-nav-icon index-nav-icon3"></i>
			<a href="<?php echo $root;?>m/mPartTimeJob.php"><h2 class="fl">学生兼职</h2></a>
			<a href="<?php echo $root;?>m/mPartTimeJob.php" class="fr">更多>></a></div>
        <ul class="index-po-list">
			<?php echo $partTimeJobList;?>
        </ul>
    </div>
    <!--资讯-->
    <div class="info-box">
    	<div class="info-header clearfix">
			<i class="fl index-nav-icon index-nav-icon4"></i>
			<a href="<?php echo $root;?>m/mNews.php"><h2 class="fl">资讯</h2></a>
			<a href="<?php echo $root;?>m/mNews.php" class="fr">更多>></a></div>
        <ul class="index-po-list">
        	<?php echo $news;?>
        </ul>
    </div>
</section>
<!--页脚-->
<footer id="footer">
	<p>
        <a href='<?php echo $root;?>m/mContact.php'>联系我们</a>
        <a href='<?php echo $root;?>m/mMap.php'>关于我们</a>
        <a href='<?php echo $root;?>m/mLaw.php'>法律声明</a>
    </p>
    <p><?php echo website("GWe61321589qY");?></p>
    <p><?php echo website("Mbm61321629nK");?></p>
</footer>
<!--底部-->
<script>
$(function() {
	//顶部搜索
	var searchBtn = document.getElementById('searchBtn');
	var searchText = document.getElementById('searchText');
	searchBtn.onclick = function() {
		window.location.href = "<?php echo $root;?>m/mTalent.php?search_text=" + searchText.value;	
	}
	$('#back,#wind').on('click', function() {
		$('#back,#wind').hide();
	})
})
</script>
<?php echo warn().mFooter();?>