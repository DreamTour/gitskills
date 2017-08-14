<?php
include "ku/adfunction.php";
ControlRoot("商品管理");
$ThisUrl = root."control/adGoodsTypeTwo.php";
$sql = " select * from goodsTypeTwo ".$_SESSION['goodsTypeTwo']['Sql'];
paging($sql," order by UpdateTime desc ",100);
$onion = array(
    "商品管理" => root."control/adGoods.php",
    "商品二级分类" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minheight">
        <!--查询开始-->
        <div class="search">
            <form name="search" action="<?php echo root."control/ku/adpost.php?type=searchGoodsTypeTwo";?>" method="post">
                <?php
                echo
                    IDSelect("goodsTypeOne","goodsTypeOne","select","id","name","--商品一级分类--",$_SESSION['goodsTypeTwo']['one']).
                    select("goodsTypeTwoShow","select","--状态--",array("显示","隐藏"),$_SESSION['goodsTypeTwo']['xian']);
                ?>
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="search">
    <span class="smallword">
      共找到<b class="must"><?php echo $num;?></b>条信息
      当前显示第<b class="must"><?php echo $page;?></b>页的信息
    </span>
            <span onclick="EditList('GoodsTypeTwoForm','delGoodsTypeTwo')" class="SpanButton FloatRight">删除所选</span>
            <a href="<?php echo "{$adroot}adGoodsTypeTwoMx.php";?>"><span class="SpanButton FloatRight">新建商品二级分类</span></a>
            <span onclick="$('[name=GoodsTypeTwoForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=GoodsTypeTwoForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="GoodsTypeTwoForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>一级分类</td>
                    <td>二级分类</td>
                    <td>排序</td>
                    <td>状态</td>
                    <td>更新时间</td>
                    <td>操作</td>
                </tr>
                <?php
                if($num == 0){
                    echo "<tr><td colspan='7'>一个商品都没有</td></tr>";
                }else{
                    while($array = mysql_fetch_array($query)){
                        $goodsTypeOne = query("goodsTypeOne"," id = '$array[goodsTypeOneId]' ");
                        echo "
        <tr>
          <td><input name='adGoodsTypeTwoList[]' type='checkbox' value='{$array['id']}'/></td>
          <td>{$goodsTypeOne['name']}</td>
          <td>{$array['name']}</td>
          <td>{$array['list']}</td>
          <td>{$array['xian']}</td>
          <td>{$array['updateTime']}</td>
          <td><a href='{$root}control/adGoodsTypeTwoMx.php?id={$array['id']}'><span class='SpanButton'>详情</span></a></td>
        </tr>
        ";
                    }
                }
                ?>
            </table>
        </form>
        <?php echo fenye($ThisUrl,7);?>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php?type=delGoodsTypeTwo").warn().adfooter();?>