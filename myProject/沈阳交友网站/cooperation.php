<?php 
include "library/PcFunction.php";
echo head("pc");
UserRoot("pc");
limit($kehu);
$sql = mysql_query("select * from content where type = '商务合作' and xian = '显示' ");
$sqlNum = mysql_num_rows(mysql_query("select * from content where type = '商务合作' and xian = '显示' "));
$cooperationTitle = "";
$cooperationContent = "";
if($sqlNum == 0){
	$cooperationTitle = "未设置";	
	$cooperationContent = "一个商务合作都没有";
}else{
	while($array = mysql_fetch_assoc($sql)){
	$cooperationTitle .= "
		<li class='business_item fz14'>".$array['title']."</li>		
	";	
	$cooperationContent .= "
		<div class='business_content fl' style='display:none;'>
        	".ArticleMx($array['id'])."
		</div>
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
<!--    <div class="ad">
    <a href="javascript:;"><img src="<?php echo img("uiJ53377569IG");?>"></a>
    </div>
-->   <!--商务合作-->
   <div class="business_box of" id="business_box">
   		<ul class="business_title_box fl">
            <?php echo $cooperationTitle;?>
        </ul>
        <?php echo $cooperationContent;?>
   </div>
<!--底部-->
<?php echo pcFooter();?>
</body>
<script>
	window.onload = function(){
		var wrap = document.getElementById('business_box');
		var li = wrap.getElementsByTagName('li');
		var div = wrap.getElementsByTagName('div');
		li[0].className = 'business_item fz16';
		div[0].style.display = 'block';
		for(var i=0;i<li.length;i++){
			li[i].index = i;
			li[i].onclick = function(){
				for(var i=0;i<div.length;i++){
					div[i].style.display = 'none';
					li[i].className = 'business_item fz14';	
				}
				div[this.index].style.display = 'block';
				this.className = 'business_item fz16';	
			}
		}
	}
</script>
</html>

