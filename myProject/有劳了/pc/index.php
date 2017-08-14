<?php
include "library/PcFunction.php";
//劳务供给/优职列表
$sql = "select * from demand";
paging($sql," order by UpdateTime desc ",6);
$jobList = "";
if($jobNum == 0){
    $jobList = "";
}
while($array = mysql_fetch_assoc($query)){
    $client = query("kehu","khid = '$array[khid]'");
    $company = query("company","khid = '$client[khid]'");
    $UpdateTime = substr($array['UpdateTime'],0,10);
    $region = query("region","id = '$client[RegionId]'");
    if ($client['ico'] == "") {
        $client['ico'] = img("PGI58296514zx");
    }
    $jobList .= "
		<li class='recruit-list clearfix'>
			<div class='recruit-dt fl'> <a href='{$root}recruit.php?demandMx_id={$array['id']}'><span class='post-title fz18 col3'>{$array['title']}</span></a>
			  <p class='dt-more'><span>{$array['mode']}</span><span>{$region['city']}</span><span>{$array['type']}</span></p>
			</div>
			<div class='recruit-logo fr'><a href='{$root}recruit.php?demandMx_id={$array['id']}'><img src='{$client['ico']}' width='60' height='60' /></a></div>
		  </li>
	";
}
//劳务供给/优才列表
$sql = "select * from supply";
paging($sql," order by UpdateTime desc ",6);
$telentList = "";
if($telentNum == 0){
    $telentList = "";
}
while($array = mysql_fetch_assoc($query)){
    $client = query("kehu","khid = '$array[khid]'");
    $personal = query("personal","khid = '$client[khid]'");
    $age = date("Y") - substr($personal['Birthday'],0,4);
    if ($client['ico'] == "") {
        $client['ico'] = img("PGI58296514zx");
    }
    $telentList .= "
		<li class='recruit-list clearfix'>
			<div class='recruit-dt fl'> <a href='{$root}JobMx.php?supplyMx_id={$array['id']}'><span class='post-title fz18 col3'>{$array['title']}</span></a>
			  <p class='dt-more'>{$array['text']}</p>
			</div>
			<div class='recruit-logo fr'><a href='{$root}JobMx.php?supplyMx_id={$array['id']}'><img src='{$client['ico']}' width='60' height='60' /></a></div>
		  </li>
	";
}
/****资讯中心****/
$sql = mysql_query("select * from content where type = '热点资讯' order by UpdateTime desc limit 12 ");
$sqlNum = mysql_num_rows(mysql_query("select * from content where type = '热点资讯'"));
$news = "";
if($sqlNum == 0){
    $news = "一条资讯都没有";
}else{
    $i = 0;
    while($array = mysql_fetch_assoc($sql)){
        $i++;
        if($i == 7){
            $news .= "</ul><ul class='infor-list clearfix'>";
        }
        $news .= "
		<li class='recruit-item'>
			<p></p>
			<a href='{$root}NewsMx.php?News_id={$array['id']}'><span>{$array['title']}</span></a>
		</li>
		";
    }
}
/******循环分类******/
$classifyTypeSql = mysql_query("select distinct type from classify order by list limit 8");
$classify = "";
$x = 1;
while($array = mysql_fetch_assoc($classifyTypeSql)){
    //二级分类
    $classifyNameSql = mysql_query(" select * from classify where type = '$array[type]' order by list limit 11");
    $classifyName = "";
    while($TwoArray = mysql_fetch_array($classifyNameSql)){
        $classifyName .= "<p><a href='{$root}talent.php?classifyId={$TwoArray['id']}'>{$TwoArray['name']}</a></p>";
    }
    //
    $classify .= "
		<li>
            <div class='menu-listTitle'>
			    <div class='menu-first'>
				    <i class='side-icon0{$x} site-icon'></i>
					<a href='{$root}talent.php?classifyType={$array['type']}'>{$array['type']}</a>
			        <i class='menu-arrow'>></i>
			    </div>

                <div class='menu-children' style='display:none'>{$classifyName}</div>

            </div>
          </li>
	";
    $x++;
}
//判断个人中心应该跳转的连接
if ( $client['type'] == "个人" ) {
    $myUrl = "user/user.php";
}
else if ( $client['type'] == "企业" ) {
    $myUrl = "seller/seller.php";
}
echo head("pc").pcHeader();
?>
<style>
    .box,.box2{ border: 1px solid #ddd;padding:20px; width:350px; position:absolute;top:100px;left:600px;z-index:9999; background: #fff; display:none;}
    .box2{left:630px;}
    .box a,.box2 a{ display:inline-block;margin:5px; font-size:14px;color: #555;}
</style>
<!--内容-->
<div class="container">
    <!--row-->
    <div class="main-nav">
        <ul class="row">
            <li class="nav-classify bg1 col1">分类</li>
            <li class="nav-list"><a href="<?php echo $root;?>job.php">优职</a></li>
            <li class="nav-list"><a href="<?php echo $root;?>talent.php">优才</a></li>
            <li class="nav-list"><a href="<?php echo $root;?>PartTimeJob.php">学生兼职</a></li>
            <li class="nav-list"><a href="<?php echo $root;?>news.php">资讯</a></li>
            <li class="nav-list"><a href="<?php echo "{$root}{$myUrl}";?>">我的</a></li>
            <li class="nav-list" id="attention"><a href="javascript:;">关注</a></li>
            <li class="attention-box" id="attentionBox" style="right:340px"><img src="<?php echo img("EUL61841061Oa");?>" width="164" height="200"></li>
        </ul>
    </div>
    <div class="row">
        <div class="banner">
            <div class="banner-menu">
                <ul class="menu-list">
                    <?php echo $classify;?>
                </ul>
            </div>
            <div class="banner-slider">
                <ul class="slider"id="silder">
                    <li><a href="javascript:;"><img alt="undefined" src="<?php echo img("Yqt57016164BO");?>"></a></li>
                    <li><a href="javascript:;"><img alt="undefined" src="<?php echo img("QnX57892686YZ");?>"></a></li>
                    <li><a href="javascript:;"><img alt="undefined" src="<?php echo img("lre57892714QD");?>"></a></li>
                    <li><a href="javascript:;"><img alt="undefined" src="<?php echo img("Jnh63434896zl");?>"></a></li>
                </ul>
                <div class="btn prev" id="prev"><i class="prev-btn site-icon"></i></div>
                <div class="btn next" id="next"><i class="next-btn  site-icon"></i></div>
                <ul class="button" id="button">
                </ul>
            </div>
        </div>
        <!--首页广告1-->
        <div class="index-ad"><a href="javascript:;"><img src="<?php echo img("RCV57016301qE");?>"></a></div>
        <div class="content-box clearfix">
            <!--左边-->
            <div class="content-left fl">
                <!--热门招聘-->
                <div class="hot-recruit">
                    <div class="recruit-head clearfix"> <i class="hot-icon01 site-icon"></i>
                        <a href="<?php echo $root;?>job.php"><h2>优职</h2></a>
                        <a class="more" href="<?php echo $root;?>job.php">更多&gt;&gt;</a> </div>
                    <ul class="recruit-body clearfix">
                        <?php echo $jobList;?>
                    </ul>
                </div>
                <!--热门求职-->
                <div class="hot-recruit">
                    <div class="recruit-head clearfix"> <i class="hot-icon02 site-icon"></i>
                        <a href="<?php echo $root;?>talent.php"><h2>优才</h2></a>
                        <a class="more" href="<?php echo $root;?>talent.php">更多&gt;&gt;</a> </div>
                    <ul class="recruit-body clearfix">
                        <?php echo $telentList;?>
                    </ul>
                </div>
                <!--资讯中心-->
                <div class="hot-recruit">
                    <div class="recruit-head clearfix"> <i class="hot-icon03 site-icon"></i>
                        <a href="<?php echo $root;?>news.php"><h2>资讯中心</h2></a>
                        <a class="more" href="<?php echo "{$root}news.php";?>">更多资讯&gt;&gt;</a> </div>
                    <div class="recruit-body clearfix">
                        <ul class="infor-list clearfix"><?php echo $news;?></ul>
                    </div>
                </div>
            </div>
            <!--左边-->
            <!--右边广告-->
            <ul class="right-ad fr">
                <li><a href="javascript:;"><img src="<?php echo $root;?>img/WebsiteImg/KXQ57016334gu.jpg"></a></li>
                <li><a href="javascript:;"><img src="<?php echo $root;?>img/WebsiteImg/eZn57016371kp.jpg"></a></li>
                <li><a href="javascript:;"><img src="<?php echo $root;?>img/WebsiteImg/FlH57016428QU.jpg"></a></li>
            </ul>
        </div>
    </div>
</div>
<!--row-->
</div>
</div>
<!--页脚-->
<!--广告-->
<script>
    //banner切换
    easySlider({
        mainCell:document.getElementById("silder"),
        titleCell:document.getElementById("button"),
        prev:document.getElementById("prev"),
        next:document.getElementById("next"),
        autoplay:true,
        speed:2000,
        type:"move",
        active:"current"

    });

    $(document).ready(function(e) {
        //二级菜单弹出层
        var menu = document.getElementsByClassName('menu-list')[0];
        var menuLi = menu.getElementsByTagName("li");
        var length = menuLi.length;
        for( var i = 0;i< length;i++){

            menuLi[i].index = i;
            menuLi[i].onmouseover = function(){
                if(this.getElementsByClassName("menu-children")[0]){
                    this.getElementsByClassName("menu-children")[0].style.display = "block"
                }
            }
            menuLi[i].onmouseout = function(){
                if(this.getElementsByClassName("menu-children")[0]){
                    this.getElementsByClassName("menu-children")[0].style.display = "none"
                }
            }
        }

        //关注鼠标移入移出
        var attention=document.getElementById("attention"),
            attentionBox=document.getElementById("attentionBox");
        attention.onmouseover=function(){
            attentionBox.style.display="block";
        };
        attention.onmouseout=function(){
            attentionBox.style.display="none";
        };

    });
</script>
<?php echo pcFooter().warn();?>

