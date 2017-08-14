<?php 
include "library/PcFunction.php";
$NewsMx = mysql_fetch_array(mysql_query("select * from content where id = '$_GET[News_id]' "));
echo head("pc").pcHeader();
?>
<!--内容-->
<div class="info-container"> 
    <!--row-->
    <div class="row">
        <!--广告-->
        <div class="info-ad"><a href="javascript:;"><img src="<?php echo img("RCV57016301qE");?>"></a></div>
        <!--资讯详情-->
        <div class="info-de-box">
        	<h2 class="info-de-title"><?php echo $NewsMx['title']?></h2>
            <div class="info-de-article"><p><?php echo ArticleMx($NewsMx['id']);?></p></div>
        </div>
    </div>
    <!--row-->
</div>
<!--页脚-->
<?php echo warn().pcFooter();?>