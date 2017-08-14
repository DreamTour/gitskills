<?php
include "../library/mFunction.php";
$ThisUrl = "{$root}m/mGoods.php";

//查询
if(!empty($get['keyword'])){  //关键字
    $where .= " and name like '%$get[keyword]%' ";
    $ThisUrl .= "?keyword=".$get['keyword'];
}else if(!empty($get['tid'])){ //二级分类
    $where .= " and goodsTypeTwoId = '$get[tid]' ";
    $ThisUrl .= "?tid=".$get['tid'];
}
if(strstr($ThisUrl,"?")==false){
    $b="?";
}else{
    $b="&";
}
//排序
//按销量
if($get['salesVolume'] == "down"){
    $order = " order by salesVolume desc";
    $priceOrder = "{$b}price=down";
    $numOrder = "{$b}salesVolume=down";
    $allOrder = "{$b}time=all";
}
//按价格
elseif($get['price'] == "down"){
    $order = " order by price desc";
    $priceOrder = "{$b}price=up";
    $numOrder = "{$b}salesVolume=down";
    $allOrder = "{$b}time=all";
}
elseif($get['price'] == "up"){
    $order = " order by price asc";
    $priceOrder = "{$b}price=down";
    $numOrder = "{$b}salesVolume=down";
    $allOrder = "{$b}time=all";
//综合排序
}elseif($get['time'] == "all"){
    $order = " order by time desc";
    $priceOrder = "{$b}price=down";
    $numOrder = "{$b}salesVolume=down";
    $allOrder = "{$b}time=all";
}else{
    $priceOrder = "{$b}price=down";
    $numOrder = "{$b}salesVolume=down";
}

$sql="SELECT * FROM goods WHERE xian='显示' {$where}";
paging($sql,"{$order}",10);
if($num > 0){
    while($goods = mysql_fetch_array($query)){
        if (empty($goods['ico'])) {
            $ico = $root.img("Ymu67366525YP");
        }else{
            $ico = $root.$goods['ico'];
        }
        $content .= "<li>
                  <a href='{$root}m/mGoodsMx.php?gid={$goods['id']}'>
                    <img src='{$ico}'/>
                    <p class='nameSpc'>{$goods['name']}</p>
                    <p class='textSale'> <em class='text-price'>￥{$goods['price']}</em> <em class='text-sale'>销量:{$goods['salesVolume']}</em> </p>
                  </a>
              </li>";
    }
}else{
    $content = "<li>
                <p>暂无此类型商品</p>
               </li>";
}
echo head("m");
?>
<style>
    .filter{top:45px;z-index:100;height:50px;line-height:50px;background-color:#f5f5f5;border-bottom:1px solid #dfdfdf;overflow:hidden;position:fixed;left:0;right:0;width:100%}
    .filter-line {display: flex;}
    .single{display:block;-webkit-flex:1;flex:1;text-align:center;position:relative;font-size:15px}
    .margin-top{margin-top: 95px;}
    form{width: 85%;display: -webkit-flex;}
</style>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo $root;?>m/mindex.php" class="header-btn header-return"><span class="return-ico"></span></a>
        <!-- <form name="" method="get"></form> -->
        <form name="searchForm" method="get">
            <div class="align-content">
                <p class="align-text"><input type="text" name="keyword" class="search" placeholder="请输入要搜索的商品名称"></p>
            </div>
            <a href="#" class="header-btn"><input type="submit" class="search-btn" value="搜索"></a>
        </form>
    </div>
</div>
<!--//-->
<div class="container">
    <!--筛选-->
    <div class="filter header-fixed">

        <div class="filter-line">
            <a class="single <?php echo MenuGet('time','all','current')?>" href="<?php echo $ThisUrl."{$allOrder}";?>">综合<i></i></a>
            <a class="single <?php echo MenuGet('salesVolume','down','current')?>" href="<?php echo $ThisUrl."{$numOrder}";?>" >按销量<i></i></a>
            <a class="single filter-prices <?php echo MenuGet('price','down','current')?> <?php echo MenuGet('price','up','current')?>" href="<?php echo $ThisUrl."{$priceOrder}";?>" ><em>按价格</em><i></i></a>
        </div>
    </div>
    <!---->
    <!--产品列表-->
    <div class="product mui-mbottom60 margin-top">
        <ul class="product-lists mui-dis-flex">
            <?php echo $content;?>
        </ul>
    </div>
    <!-- 分页 -->
    <div class="panel_pager ">
        <?php echo fenye($ThisUrl); ?>
    </div>
</div>
<!--底部-->
<?php echo mWarn().Footer(); ?>
<!--//-->
<script>
    $(function(){
        /***********************导航栏变色****************************/
        changeNav();
    });
</script>
</body>
</html>