<?php 
include "library/function.php";
$ThisUrl = $root."goods.php?TypeOne=".$_GET['TypeOne'];
echo head("pc");
ThisHeader();
echo banner();
?>
<div class="GoodsList minheight">
    <!--商品列表开始-->
    <?php
    $TypeTwoSql = mysql_query("select * from TypeTwo where TypeOneId = '$_GET[TypeOne]' order by list ");
    while($TypeTwo = mysql_fetch_array($TypeTwoSql)){
        $GoodsSql = mysql_query("select * from goods where Auditing = '已通过' and sellerid in (select seid from seller where prove = '已通过' ) and TypeTwoId = '$TypeTwo[id]' order by UpdateTime desc limit 4 ");
        if(mysql_num_rows($GoodsSql) > 0 ){
            echo "
            <ul class='GoodsListUl'>
                <div class='GoodsListTitle'>
                    {$TypeTwo['name']}
                    <a href='{$root}StoreList.php?TypeOne={$_GET['TypeOne']}'><span class='SotreMore'>更多商家>></span></a>
                </div>
            ";
            while($Goods = mysql_fetch_array($GoodsSql)){
                if($Goods['name'] == ""){
                    $Goods['name'] = "暂无商品名称";
                }
                echo "
                <a href='{$root}goodsmx.php?TypeOne={$_GET['TypeOne']}&goods={$Goods['id']}'>
                <li>
                    <img class='GoodsListIco' src='".ListImg($Goods['ico'])."'>
                    <p class='GoodsListName'>".zishu($Goods['name'],20)."</p>
                    <p class='GoodsListPrice'>￥{$Goods['price']}</p>
                    <p class='IndexSellerBrand'>{$Goods['Brand']}</p>
                </li>
                </a>
                ";
            }
            echo "
            </ul>
            <div class='clear'></div>
            ";
        }
    }
    ?>
    <!--商品列表结束-->
</div>
<?php 
echo warn();
ThisFooter();
?>  