<?php
require_once("library/PcFunction.php");
$tourMx = mysql_fetch_assoc(mysql_query("select * from content where id = '$_GET[tourId]' "));
$lunbo = mysql_query("select * from ContentWin where ContentId = '$tourMx[id]' ");
$img = "";
$x = 1;
$first_img = "";
while($array = mysql_fetch_array($lunbo)) {
	if($x == 1) {
		$first_img = "<img src='{$array['src']}'>";	
	}
	$img .= "<li><img src='{$array['src']}'></li>";
	$x++; 	
}
echo head("pc").pc_header();
?>
<style>
.local_bg{background-color:#fdfdfd;padding:20px 0 30px;}
.vip_icon{background-image:url(http://www.yumukeji.com/project/xiangyuepanzhou/img/WebsiteImg/xhz50520079GZ.jpg);}

/*位置*/
.news_place{width:1000px;margin:30px auto;}
.news_place span,.news_place a{font-size:14px;}
.news_place a{color:#ff536a;}
.news_place_icon{width:20px;height:20px;background-position:-22px -94px;margin-bottom:-3px;background-image:url(http://www.yumukeji.com/project/xiangyuepanzhou/img/WebsiteImg/rPH50462563Xd.jpg);}

/*顶部图片展示*/
#layout-top{ width:1000px;margin:20px auto;padding:25px; font-size:16px;background-color:#fff;border:1px solid #ddd;}
#layout-top:after{ content:''; display:block; clear:both;}
#user-image{ width:430px; float:left;}	
#user-data{ width:415px; float:left; margin-left:20px;}
#user-advem{ width:230px; height:230px; float:right; margin-left:40px; background:#f5f5f5}
.user-image-big{ background:#f5f5f5}
.user-image-big,.user-image-big img{height:240px;}
.user-image-list ul:after{ content:''; display:block; clear:both;}
.user-image-list ul{ position:relative; left:14px; transition:margin .123s linear;}
.user-image-list li{ float:left; margin-right:5px;}
.user-image-list li,.user-image-list img{width:80px; height:50px;}
.user-image-list{ width:430px; overflow:hidden; height:50px; margin-top:5px; position:relative;}
.image-switch-btn{ position:absolute; height:100%; width:12px;height:12px;background-position:0 0; top:0; z-index:100;margin-top: 20px;}
#prev{ left:0;}
#next{ right:0;}
#user-data .proto-text{ text-align:left; color:#000; font-size:16px;line-height:30px;}

/*顶部右边*/
.travel_content{width:500px;overflow:hidden;}
.travel_content h5{font-size:20px;line-height:30px;}
.travel_content p{line-height:24px;}
.travel_price{margin:15px 0;}
.travel_price *{color:#f9a61c;}
.travel_price s{margin-top:-5px;}
.travel_price span{font-size:24px;}
.book_btn{display:block;width:130px;line-height:36px;background-color:#f9a61c;color:#fff;text-align:center;font-size:18px;border-radius:3px;margin-top:20px;}

/*景点介绍*/
.travel_main{width:1000px;margin:20px auto 0;background-color:#fff;border:1px solid #ddd;padding:25px;}
.travel_title{margin-bottom:20px;}
.travel_title s{display:inline-block;width:3px;height:20px;background-color:#ff536a; margin:2px 3px 0 0;}
.travel_main p{line-height:24px;text-indent:2em;word-break:break-all;margin-bottom:10px;}
.travel_photo{margin-bottom:20px;text-align:center;margin-top:20px;}
.travel_main img{display:block;margin:auto;max-width:948px;}
</style>
<script>

var swiper = function() {
		var b = 0,
			c = function(a) {
				//获取id号
				if (a) return document.getElementById(a)
			},
			d = function(a, b) {
				//获取对象css
				return a.currentStyle ? a.currentStyle[b] : getComputedStyle(a, !1)[b]
			},
			m = c("image-big"),
			g = c("image-list"),
			e = g.getElementsByTagName("li"),
			f = e.length,
			h = c("prev"),
			k = c("next"),
			c = d(e[0], "width"),
			n = d(e[0], "height"),
			d = d(e[0], "margin-right"),
			l = parseInt(c.replace(/px/, ""));
		handleHeight = parseInt(n.replace(/px/, ""));
		handleMargin = parseInt(d.replace(/px/, ""));
		init = function() {
			//初始化对象
			g.style.width = (l + handleMargin) * f + "px";
			k && (k.onclick = function() {
				b++;
				b >= f && (b = f);
				move(b)
			}, h && (h.onclick = function() {
				b--;
				0 >= b && (b = 0);
				move(b)
			}))
		};
		move = function(a) {
			//执行列表图运行
			a >= f || (g.style.marginLeft = -(l + handleMargin) * a + "px")
		};
		selectImage = function() {
			//赋值src
			for (var a = 0; a < f; a++) e[a].onclick = function() {
				var a = this.getElementsByTagName("img")[0].src;
				m.getElementsByTagName("img")[0].src = a
			}
		};
		selectImage();
		init()
};
window.onload = function(){
	swiper();
}
</script>
<!--位置-->
<div class="local_bg">
    <div class="news_place"><i class="news_place_icon" id="news_btn"></i><span>您所在的位置：</span><a href='http://www.yumukeji.com/project/xiangyuepanzhou/Tour.php'>本地通</a><span>>></span><a href='http://www.yumukeji.com/project/xiangyuepanzhou/TourMx.php'>详情</a></div>
   <!--顶部-->
    <div id="layout-top">
     <!--顶部图片展示-->
        <div id="user-image" class="user-image-view">
            <div id="image-big" class="user-image-big">
            	<?php echo $first_img;?>
            </div>
            <div class="user-image-list">
                <div id="prev" class="image-switch-btn vip_icon" style="background-position: -22px -18px;"></div>
                <div id="next" class="image-switch-btn vip_icon" style="background-position: -3px 16px;"></div>
                <ul id="image-list"><?php echo $img;?></ul>
            </div>
        </div>
        <!--顶部右边-->
        <div class="travel_content fr">
        	<h5 class="fw1"><?php echo $tourMx['title'];?></h5>
            <div class="travel_price"><s>￥</s><span><?php echo $tourMx['money'];?></span></div>
            <p class="fz14">产品特色：<?php echo $tourMx['feature'];?><br/>供应商：<?php echo $tourMx['Supplier'];?><br/>
推荐理由：<?php echo $tourMx['Recommend'];?></p>
			<a href="javascript:;" class="book_btn" onClick="document.tourpay.submit();">立即预定</a>
   		</div>
    </div>
    <!--景点介绍-->
    <div class="travel_main">
	    <div class="travel_title of"><s class="fl"></s><h5 class="fl fz18 fw1">详情介绍</h5></div>
        	<?php echo ArticleMx($tourMx['id']);?>
    </div>
</div>
<div class="hide">
	<form name="tourpay" action="<?php echo $root."pay/alipayapi.php";?>" method="post">
    	<input name="type" type="hidden" value="本地通"/>
        <input name="tourId" type="hidden" value="<?php echo $tourMx['id'];?>"/>
    </form>
</div>
<?php echo warn().footer();?>