<?php
include "library/PcFunction.php";
echo head("pc").headerPC().navOne();
;?>
<!-- 大图 -->
<div class="contact-banner banner"></div>
<!--内容-->
<!--位置-->
<div class="location container">
    <a href="<?php echo $root;?>index.php">首页</a><span>&gt;</span>
    <a href="<?php echo $root;?>contact.php">联系我们</a>
</div>
<!--联系我们-->
<div class="contactUs-box container">
    <div class="contactUs-title"><h1>联系我们</h1><p>contact us</p></div>
    <div class="contactUs-content clearfix">
        <ul class="contactUs-body">
            <li><strong>地址：</strong><span><?php echo website("cPE65754528ib");?></span></li>
            <li><strong>总机(Tel)：</strong><span><?php echo website("wit65754548oS");?></span></li>
            <li><strong>传真(Fax)：</strong><span><?php echo website("fRr65754564im");?></span></li>
            <li><strong>邮编(Zip)：</strong><span><?php echo website("Eaf65754579gn");?></span></li>
            <li><strong>邮箱(Email)：</strong><span><?php echo website("Ptc65754592xT");?></span></li>
            <li><strong>技术咨询（TECH CONSULT）：</strong><span><?php echo website("rHT65754612qT");?></span></li>
        </ul>
        <div class="mapBox" id="allmap"></div>
    </div>
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script type='text/javascript' src='http://api.map.baidu.com/api?v=2.0&ak=yaMnqGiWDKzftga34qkznzCydHNs2H52'></script>
<script>
    var map = new BMap.Map('allmap');//创建map实例
    map.enableScrollWheelZoom(true);//开启鼠标滚轮缩放
    var point = new BMap.Point(121.610784,38.907622);//定义一个坐标
    map.centerAndZoom(point,20);//将此坐标设为中心点，且定义放大倍数
    MorePoint(121.610784,38.907622,20,'<b>动力街区</b><br>大连市西岗区胜利路121号动力街区3单元3F-1');
    function MorePoint(longitude,latitude,word){
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
    }
    //导航移动
    $(".nav").movebg({
        width:134,  /*滑块的大小*/
        extra:0,    /*额外反弹的距离*/
        speed:400,  /*滑块移动的速度*/
        rebound_speed:400   /*滑块反弹的速度*/
    });
</script>
</html>