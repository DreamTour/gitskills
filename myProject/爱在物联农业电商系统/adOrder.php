<?php
include "ku/adfunction.php";
ControlRoot("订单管理");
//获取列表
$list = "";
$ThisUrl = $adroot."adOrder.php";
$sql = "select * from buycar ".$_SESSION['SearchOrder']['Sql'];
paging($sql," order by UpdateTime desc",100);
if($num == 0){
    $list .= "<tr><td colspan='13'>一个订单都没有</td></tr>";
}else{
    while($array = mysql_fetch_array($query)){
        $list .= "
    <tr>
      <td><input name='OrderList[]' type='checkbox' value='{$array['id']}'/></td>
      <td>".kong($array['goodsName'])."</td>
      <td>".kong($array['goodsSkuName'])."</td>
      <td>".kong($array['shipmentNum'])."</td>
      <td>".kong($array['id'])."</td>
      <td>".kong($array['addressName'])."</td>
      <td>".kong($array['addressTel'])."</td>
      <td>".kong($array['addressMx'])."</td>
      <td>{$array['buyNumber']}</td>
      <td>{$array['buyPrice']}</td>
      <td>{$array['WorkFlow']}</td>
      <td>{$array['payTime']}</td>
      <td><a href='{$adroot}adOrderMx.php?id={$array['id']}'><span class='SpanButton'>详情</span></a>
      </td>
    </tr>
    ";
    }
}
$onion = array(
    "订单管理" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minheight">
        <div class="kuang">
            <form name="search" action="<?php echo root."control/ku/adpost.php?type=searchOrder";?>" method="post">
                订单号：<input name="SearchOrderGoodsId" type="text" class="text TextPrice" value="<?php echo $_SESSION['SearchOrder']['buycarId'];?>">
                <!--商品名称：<input name="SearchOrderGoodsName" type="text" class="text TextPrice" value="<?php echo $_SESSION['SearchOrder']['GoodsName'];?>">-->
                规格名称：<input name="SearchOrderRuleName" type="text" class="text TextPrice" value="<?php echo $_SESSION['SearchOrder']['RuleName'];?>">
                收货人姓名：<input name="SearchOrderKhName" type="text" class="text TextPrice" value="<?php echo $_SESSION['SearchOrder']['khname'];?>">
                手机号码：<input name="SearchOrderKhtel" type="text" class="text TextPrice" value="<?php echo $_SESSION['SearchOrder']['khtel'];?>">
                收货地址：<input name="SearchOrderAddress" type="text" class="text TextPrice" value="<?php echo $_SESSION['SearchOrder']['address'];?>">
                <?php echo select("WorkFlow","select TextPrice","--订单状态--",array("未选定","已选定","已付款","已发货","已收货","已评价","已退款"),$_SESSION['SearchOrder']['WorkFlow']);?>
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
    <span class="SpanButton">
      共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
      当前显示第<b class="must"><?php echo $page;?></b>页的信息
    </span>
            <span onclick="EditList('OrderForm','confirmOrder')" class="SpanButton FloatRight">批量收货</span>
            <span onclick="$('[name=OrderForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=OrderForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="OrderForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td style="width:180px">商品名称</td>
                    <td>规格名称</td>
                    <td>物流单号</td>
                    <td>订单号</td>
                    <td>收货人</td>
                    <td>手机号码</td>
                    <td>收货地址</td>
                    <td>购买数量</td>
                    <td>购买单价</td>
                    <td>订单状态</td>
                    <td>付款时间</td>
                    <td></td>
                </tr>
                <?php echo $list;?>
            </table>
            <input name="EditPas" type="hidden">
            <input name="EditListType" type="hidden">
        </form>
        <?php echo fenye($ThisUrl,7);?>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php?type=confirmOrder").warn().adfooter();?>