<?php 
include "library/PcFunction.php";
UserRoot("pc");
echo head("pc");
limit($kehu);
$contact = mysql_fetch_array(mysql_query("select * from content where type = '联系我们' and classify = '联系我们' "))
;?>
<script>
	
function firstChild(obj){
	return obj.firstChild.previousSibling;	
}

window.onload = function(){
	
	console.log(firstChild(document.getElementById('div')))
		
}	
</script>

<style>
.icon{ background:url(<?php echo img("WxN53377734Xb");?>)}
.contact_us{margin:20px auto 20px;width:1000px;padding-bottom:100px}
.contact_us_head{line-height:50px;border-bottom:1px solid #d4d4d4;margin-bottom:20px}
.contact_us_head a{color:#000;font-size:16px;margin-right:40px;display:inline-block;height:51px;border-bottom:2px solid #fff}
.contact_us a:hover{border-color:#f9a61c;color:#f9a61c}
.map{width:1000px;height:530px;border:1px solid #d4d4d4;margin-bottom:20px}
.contact_way s{font-weight:700}
.contact_way span{margin-right:30px}
.contact_way{margin:10px 0}
.company_info{width:1000px;margin:auto;text-align:center}
.company_info h1{font-size:16px;color:#000;margin-bottom:10px}
.company_info_content{text-align:left}
.company_info_content p{font-size:14px;line-height:160%;color:#000;text-indent:2em;margin-bottom:10px}
</style>
<!--头部-->
        <?php echo pcHeader();?>
    <!--内容-->
        <div class="contact_us">
        	<div id="tabBtn" class="contact_us_head">
            	<a href="javascript:;" class="current">公司介绍</a>
                <a href="javascript:;">联系我们</a>
            </div>
            <div class="switch_tab">
            	<div class="company_info">
                    <h1><?php echo $contact['title'];?></h1>
                    <div class="company_info_content">
                        <?php echo ArticleMx($contact['id']);?>
                    </div>
                </div>
            </div>
            <div id="switch_tab" class="switch_tab" style="display:none">
            	<div class="map">
                	<div style="height: 530px;" id="allmap"></div>
                </div>
            	<p class="contact_way"><s>电话：</s><span><?php echo website('w5we63sd');?></span><s>地址：</s><span><?php echo website('s87dsw');?></span></p>
            </div>
        </div>
<script type='text/javascript' src='http://api.map.baidu.com/api?v=2.0&ak=Iss0ggoRGunu9egMVppI2g1vzDanIHoo'></script>
<script>
window.onload = function() {
    var btn = document.getElementById('tabBtn').getElementsByTagName('a');
    var switchTab = document.getElementsByClassName('switch_tab');
    for(var i =0;i<btn.length;i++){
        btn[i].dataId = i;
        btn[i].onclick = function(){
            for(var i =0;i<btn.length;i++){
                switchTab[i].style.display = 'none';
                btn[i].className = '';
            }
            this.className = 'current'
            switchTab[this.dataId].style.display = 'block';
			showmap();
        }
    }
}
/********************百度地图引用****************************************/
function showmap() {
var map = new BMap.Map('allmap');//创建map实例
map.enableScrollWheelZoom(true);//开启鼠标滚轮缩放
var point = new BMap.Point(123.485557,41.848754);//定义一个坐标
map.centerAndZoom(point,20);//将此坐标设为中心点，且定义放大倍数
MorePoint(123.485557,41.848754,20,'<b>沈阳恋爱无忧相亲网</b><br>沈阳市大东区北大营海鲜市场');
function MorePoint(longitude,latitude,grade,word){
	var point = new BMap.Point(longitude,latitude);
	var myIcon = new BMap.Icon('img/images/GPS.png', new BMap.Size(25,25));//定义一个小图标
	var marker = new BMap.Marker(point,{icon:myIcon});//定义一个点
	var infoWindow = new BMap.InfoWindow(word);  // 创建信息窗口对象
	map.addOverlay(marker);//将这个点加到地图上
	marker.addEventListener('mouseover', function(){          
	   this.openInfoWindow(infoWindow);
	});
	marker.addEventListener('mouseout', function(){          
	   this.closeInfoWindow(infoWindow);
	});
	marker.addEventListener('click', function(){          
	   location.href='Campus.php?id=lasCx39917169&longitude=' + longitude + '&latitude=' + latitude + '&grade='+ grade +'&word=' + word;
	});
}
}
</script>
        <style>
		.current{    border-color: #f9a61c !important;
    color: #f9a61c !important;}
		</style>
<!--底部-->
<?php echo pcFooter();?>
</body>
</html>
