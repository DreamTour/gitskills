<?php 
include "library/PcFunction.php";
echo head("pc");
$s = "select * from content where type = '最新资讯' and xian = '显示' order by list ";
$sql = mysql_query($s);
$sqlNum = mysql_num_rows($sql);
$cooperationTitle = "";
$cooperationContent = "";
if($sqlNum == 0){
	$cooperationTitle = "未设置";	
}else{
	while($array = mysql_fetch_assoc($sql)){
	$cooperationTitle .= "
		<a href='{$root}help.php?id={$array['id']}'><li class='business_item ".MenuGet("id",$array['id'],"fz16")."'>{$array['title']}</li><a>	
	";	
    }
}
?>
<style>
.icon{ background:url(<?php echo img("WxN53377734Xb");?>)}
/*广告*/
.ad{
	width:1000px;
	height:90px;
	clear:both;
	margin:20px auto 15px;
}
/*商务合作*/
.business_box{width:1000px;margin:20px auto;}
.business_box img{max-width:752px;margin:20px auto; display:block;}
.business_title_box{width:160px;border:1px solid #ddd;text-align:center;margin-right:20px;border-top:none;}
.business_title_box li{line-height:44px;border-top:1px solid #ddd;}
.business_title_box .business_title{color:#fff;background-color:#ff7c7c;border:none;}
.business_title_box .fz16{color:#fff;background-color:#ff7c7c;border:none;font-size:16px;}
.business_content{border:1px solid #ddd;padding:30px;}
.business_content p{max-width:750px;text-indent:2em;line-height:24px;}
</style>
<!--头部-->
    	<?php echo pcHeader();?>
    <!--广告-->
    <div class="ad">
    <a href="javascript:;"><img src="<?php echo img("uiJ53377569IG");?>"></a>
    </div>
   <!--商务合作-->
   <div class="business_box of" id="business_box">
   		<ul class="business_title_box fl">
            <?php echo $cooperationTitle;?>
        </ul>
        <div class='business_content fl'>
        	<?php echo ArticleMx($_GET['id']);?>
		</div>
   </div>
<!--底部-->
<?php echo pcFooter();?>
</body>
</html>

