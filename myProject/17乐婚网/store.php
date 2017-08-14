<?php   
include "library/function.php";  
$ThisUrl = $root."store.php?seller=".$_GET['seller'];  
StoreID();echo head("pc");echo ThisHeader();
$SellerResult = query("seller"," seid = '$_GET[seller]' ");
if($SellerResult['seid'] == $_GET['seller'] and $_GET['seller'] !=""){
	$IP = $_SERVER["REMOTE_ADDR"];
    $LogTextQuery = query("LogText"," text = '$IP' and TargetId = '$SellerResult[seid]' ");
	if($LogTextQuery['id'] == ""){
		mysql_query("insert into LogText(Target,TargetId,text,time) values ('根据IP地址浏览店铺记录','$SellerResult[seid]','$IP','$time') ");
		mysql_query("update seller set PageView = PageView+1 where seid = '$SellerResult[seid]' ");
	}else{
		$TimeCuo = (int)strtotime($LogTextQuery['time']);
        if($time-$TimeCuo > 24*60*60){
			mysql_query("update LogText set time = '$time' where text = '$IP' ");
		    mysql_query("update seller set PageView = PageView+1 where seid = '$SellerResult[seid]' ");
		}
	}
}
echo insertBackUrl();
?>  
<style>  
.AlbumTitle{ background-color:#ffd2d2; padding:10px; margin:10px auto auto auto; color:#f85451;}  
.AlbumList li{ width:216px; height:216px; float:left; margin:9px 9px 40px 9px; position:relative;}  
.AlbumList li img{ margin:6px auto auto 6px; width:200px; height:200px;}  
.AlbumList li p{ width:216px; text-align:center; left:0; bottom:-30px; position:absolute;}  
</style>  
<div class="column">  
    <?php StoreHead($seller);?>  
    <!--店铺banner开始-->  
    <div style="height:10px;"></div>  
    <?php   
    $StoreBannerSql = mysql_query("select * from sellerBanner where sellerid = '$_GET[seller]' ");  
    $img = "";  
    $imgurl = "";  
    $x = 0;  
    while($StoreBanner = mysql_fetch_array($StoreBannerSql)){  
       if($StoreBanner['img'] != ""){  
           $img[$x] = $root.$StoreBanner['img'];  
           $imgurl[$x] = $root.$StoreBanner['imgurl'];  
           $x++;   
       }  
    }  
    BannerCurrency(1200,400,$img,$imgurl,"商户还没有上传任何图片呢");  
    ?>  
    <!--店铺banner结束-->  
    <!--商家相册开始-->  
    <?php  
    $AlbumSql = "select * from sellerAlbum where sellerid = '$_GET[seller]' ";  
    $AlbumNum = mysql_num_rows(mysql_query($AlbumSql));  
    ?>  
    <div class="AlbumTitle">  
        商家相册  
        <span class="FloatRight"><a href="<?php echo "{$root}album.php?seller={$_GET['seller']}";?>">共<?php echo $AlbumNum;?>个相册>></a></span>  
    </div>  
    <div class="kuang" style="min-height:552px;">  
        <?php  
        if($AlbumNum > 0){  
            $sellerAlbumSql = mysql_query($AlbumSql." order by time desc limit 10 ");  
            echo "<ul class='AlbumList'>";  
            while($album = mysql_fetch_array($sellerAlbumSql)){  
                if($album['name'] == ""){  
                    $album['name'] = "没有相册名称";  
                }  
                echo "  
                <a href='{$root}albumMx.php?seller={$_GET['seller']}&album={$album['id']}'>  
                <li>  
                    <img src='".ListImg($album['ico'],"seller/")."'>  
                    <p>".zishu($album['name'],12)."</p>  
                </li>  
                </a>  
                ";  
            }   
            echo "</ul>";  
        }else{  
            echo "小店还没有相册呢";  
        }  
        ?>  
        <div class="clear"></div>  
    </div>  
    <!--商家相册结束-->  
</div>  
<?php  echo warn();ThisFooter();?>