<?php
include "../library/mFunction.php";
echo head("m").mHeader();
;?>
<div class="mContact">
    <h3>地址：</h3>
    <div><?php echo website("cPE65754528ib");?></div>
    <h3>总机(Tel)：</h3>
    <div><?php echo website("wit65754548oS");?></div>
    <h3>传真(Fax)：</h3>
    <div><?php echo website("fRr65754564im");?></div>
    <h3>邮编(Zip)：</h3>
    <div><?php echo website("Eaf65754579gn");?></div>
    <h3>邮箱(Email)：</h3>
    <div><?php echo website("Ptc65754592xT");?></div>
    <h3>技术咨询（TECH CONSULT）：</h3>
    <div><?php echo website("rHT65754612qT");?></div>
    <h3>联系我们</h3>
    <div class="mapBox" id="allmap"></div>
</div>
<?php echo mFooter().mNav().warn();?>
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
        var myIcon = new BMap.Icon('../img/images/GPS.png', new BMap.Size(25,25));//定义一个小图标
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
</script>

</html>