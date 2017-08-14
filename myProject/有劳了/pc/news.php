<?php
include "library/PcFunction.php";
$sql = " select * from content where type = '热点资讯' ";
paging($sql," order by UpdateTime desc ",10);
/*************热点资讯**********************************************/
$news = "";
if($num == 0){
    $news .= "一条热点资讯都没有";
}else{
    while($array = mysql_fetch_array($query)){
        /**$LabelArrray = explode("，",$array['Label']);
        $Label = "";
        foreach($LabelArrray as $v){
        $Label .= "<span>{$v}</span>";
        }**/
        $news .= "
		<li class='clearfix'>
			<div class='info-left fl'><a href='{$root}NewsMx.php?News_id={$array['id']}'><img src='{$array['ico']}' width='120' height='100'></a></div>
			<div class='info-right fl'>
				<div class='info-title-box clearfix'><a href='{$root}NewsMx.php?News_id={$array['id']}' class='info-title fl'>{$array['title']}</a><span class='fr'>".substr($array['UpdateTime'],0,10)."</span></div>
				<p class='info-article'>
					<a href='{$root}NewsMx.php?News_id={$array['id']}'>{$array['summary']}<span class='info-detail'>[详情]</span></a>
				</p>
				<div class='info-label-box'>
					<span class='info-label'>标签</span>
					<span>".str_replace("，","</span><span>",$array['Label'])."</span>
				</div>
			</div>
		</li>
		";
    }
}
echo head("pc","有劳了—新闻页").pcHeader();
?>
<!--内容-->
<div class="info-container">
    <?php echo pcNavigation();?>
    <!--row-->
    <div class="row">
        <!--广告-->
        <div class="info-ad"><a href="javascript:;"><img src="<?php echo img("RCV57016301qE")?>"></a></div>
        <!--热点资讯-->
        <div class="hot-info-box">
            <div class="hot-info-title clearfix"><i class="hot-icon03 site-icon info-icon fl"></i><h2 class="fl">热点资讯</h2></div>
            <ul class="hot-info-content">
                <?php echo $news?>
            </ul>
            <!--按钮-->
            <div class="page_btn_box">
                <?php echo fenye($ThisUrl,7);?>
            </div>
        </div>
    </div>
    <!--row-->
</div>
<!--页脚-->
<?php echo warn().pcFooter();?>
