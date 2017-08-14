<?php
include "ku/adfunction.php";
ControlRoot("商品管理");
$ThisUrl = root."control/adGoods.php";
$sql = " select * from goods ".$_SESSION['SearchGoods']['Sql'];
paging($sql," order by updateTime desc ",100);
$onion = array(
    "商品管理" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <style>
        .summary{width:333px;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    </style>
    <div class="column minheight">
        <!--查询开始-->
        <div class="search">
            <form name="search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
                <?php echo IDSelect("goodsTypeOne","goodsTypeOneId","select","id","name","选择商品一级分类",$_SESSION['SearchGoods']['goodsTypeOneId']);?>
                <select name="SearchShow" id="SearchShow" class="select TextPrice">
                    <option value="">--显示状态--</option>
                    <option value="显示">显示</option>
                    <option value="隐藏">隐藏</option>
                </select>
                商品名称：
                <input name="SearchGoodsName" type="text" class="text short" value="<?php echo $_SESSION['SearchGoods']['GoodsName'];?>">
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="search">
    <span class="smallword">
      共找到<b class="must"><?php echo $num;?></b>条信息
      当前显示第<b class="must"><?php echo $page;?></b>页的信息
    </span>
            <span onclick="EditList('GoodsForm','delGoods')" class="SpanButton FloatRight">删除所选</span>
            <a href="<?php echo root."control/adGoodsMx.php";?>"><span class="SpanButton FloatRight">新建商品</span></a>
            <span onclick="$('[name=GoodsForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=GoodsForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
            <a href="<?php echo root."control/adGoodsTypeTwo.php";?>"><span class="SpanButton FloatRight">商品二级分类</span></a>
            <a href="<?php echo root."control/adGoodsTypeOne.php";?>"><span class="SpanButton FloatRight">商品一级分类</span></a>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="GoodsForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>商品名称</td>
                    <td>商品一级分类</td>
                    <td>商品二级分类</td>
                    <td class="summary">摘要</td>
                    <td>单价</td>
                    <td>市场价</td>
                    <td>销量</td>
                    <td>显示状态</td>
                    <td>更新时间</td>
                    <td style="width:54px;">操作</td>
                </tr>
                <?php
                if($num > 0){
                    while($goods = mysql_fetch_array($query)){
                        $goodsTypeTwo = query("goodsTypeTwo","id = '$goods[goodsTypeTwoId]'");
                        $goodsTypeOne = query("goodsTypeOne","id = '$goods[goodsTypeOneId]'");
                        echo "
        <tr>
          <td><input name='goodsList[]' type='checkbox' value='{$goods['id']}'/></td>
          <td>".zishu(kong($goods['name']),15)."</td>
          <td>{$goodsTypeOne['name']}</td>
          <td>{$goodsTypeTwo['name']}</td>
          <td class='summary'>".kong($goods['summary'])."</td>
          <td>{$goods['price']}</td>
          <td>{$goods['priceMarket']}</td>
          <td>{$goods['salesVolume']}</td>
          <td>{$goods['xian']}</td>
          <td>{$goods['updateTime']}</td>
          <td><a href='{$root}control/adGoodsMx.php?id={$goods['id']}'><span class='SpanButton'>详情</span></a></td>
        </tr>
        ";
                    }
                }else{
                    echo "<tr><td colspan='12'>一个商品都没有</td></tr>";
                }

                ?>
            </table>
        </form>
        <?php echo fenye($ThisUrl,7);?>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php?type=delGoods").warn().adfooter();?>