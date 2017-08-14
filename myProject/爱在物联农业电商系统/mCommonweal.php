<?php
include "../library/mFunction.php";
$ThisUrl = "{$root}m/mCommonweal.php";
$sql = "SELECT * FROM goods WHERE publicGood='是' AND xian='显示'  ";
paging($sql,"order by list desc",15);
if($num > 0){
    while($goods = mysql_fetch_array($query)){
        $liStr = "";
        if (empty($goods['ico'])) {
            $ico = img('vLl67366152My'); //默认图片
        }else{
            $ico = root.$goods['ico'];
        }
        $liStr .= "
				<li>
					<a href='{$root}m/mGoodsMx.php?gid={$goods['id']}'>
					<img src='{$ico}'/>
					<p class='nameSpc'>{$goods['name']}</p>
					<p class='textSale'> <em class='text-price'>￥{$goods['price']}</em> <em class='text-sale'>销量:{$goods['salesVolume']}</em> </p>
					</a>
				</li>";
    }
}else{
    $liStr = "<li class='nodata'>暂无此分类商品</li>";
}
//活动报名
$article = query("content", "type = '活动报名' AND classify = '活动报名' ORDER BY time DESC ");
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root;?>m/mindex.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">活动报名</p>
        </div>
        <a href="#" class="header-btn header-login"></a>
    </div>
</div>
<!--//-->
<div class="container">
    <div class="activity-con mui-ptop45">
        <h2><?php echo $article['title'];?></h2>
        <p><?php echo ArticleMx($article['id']);?></p>
        <div class="register-btn" id="registerBtn">立即报名</div>
        <input id="activityId" type="hidden" value="<?php echo $article['id'];?>" />
    </div>
    <!--产品列表-->
    <!--<div class="product">
        <h2>公益推荐产品</h2>
        <ul class="product-lists mui-dis-flex">
            <?php /*echo $liStr; */?>
        </ul>
    </div>-->
</div>
<!--底部-->
<?php echo  Footer().mWarn(); ?>
<!--//-->
<script>
    $(function(){
        /***********************导航栏变色****************************/
        changeNav();
    });
    window.onload = function() {
        var registerBtn = document.getElementById('registerBtn');
        var activityId = document.getElementById('activityId').value;
        registerBtn.onclick = function() {
            ajax({
                type:"POST",
                url:"<?php echo "{$root}library/mData.php?type=activity";?>",
                dataType:"json",
                data:{activityId:activityId},
                success:function(data){
                    mwarn(data.warn);
                },
                error:function(){
                    mwarn('出错了');
                }
            })
        }
    }

    function ajax(){
        var ajaxData = {
            type:arguments[0].type || "GET",
            url:arguments[0].url || "",
            async:arguments[0].async || "true",
            data:arguments[0].data || null,
            dataType:arguments[0].dataType || "text",
            contentType:arguments[0].contentType || "application/x-www-form-urlencoded",
            beforeSend:arguments[0].beforeSend || function(){},
            success:arguments[0].success || function(){},
            error:arguments[0].error || function(){}
        }
        ajaxData.beforeSend()
        var xhr = createxmlHttpRequest();
        xhr.responseType=ajaxData.dataType;
        xhr.open(ajaxData.type,ajaxData.url,ajaxData.async);
        xhr.setRequestHeader("Content-Type",ajaxData.contentType);
        xhr.send(convertData(ajaxData.data));
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if(xhr.status == 200){
                    ajaxData.success(xhr.response)
                }else{
                    ajaxData.error()
                }
            }
        }
    }

    function createxmlHttpRequest() {
        if (window.ActiveXObject) {
            return new ActiveXObject("Microsoft.XMLHTTP");
        } else if (window.XMLHttpRequest) {
            return new XMLHttpRequest();
        }
    }

    function convertData(data){
        if( typeof data === 'object' ){
            var convertResult = "" ;
            for(var c in data){
                convertResult+= c + "=" + data[c] + "&";
            }
            convertResult=convertResult.substring(0,convertResult.length-1)
            return convertResult;
        }else{
            return data;
        }
    }
</script>
</body>
</html>