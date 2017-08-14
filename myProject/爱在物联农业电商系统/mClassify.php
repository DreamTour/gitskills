<?php
include "../library/mFunction.php";
//记住选择的一级分类
if (isset($get['oid']) && !empty($get['oid'])) {
    $oid = $get['oid'];
    $_SESSION['mClassify']['oid'] = $oid;
}else{
    $oid = $_SESSION['mClassify']['oid'];
    if (empty($oid)) {
        $oArr = query("goodsTypeOne","1 order by list");
        $oid = $oArr['id'] ;
    }
}
$goodsTypeOne = "";
$result = mysql_query("SELECT * FROM goodsTypeOne WHERE xian='显示' ORDER BY list");
$nums = mysql_num_rows($result);
if ($nums > 0) {
    $x = 0;
    while ($array = mysql_fetch_array($result)){
        $goodsTypeOne .= "
			<li><a href='?oid={$array['id']}' oid='{$array['id']}'>{$array['name']}</a></li>
			";
    }
}
/*
 * 查询二级分类函数
 * $oid 一级分类ID
 */
function typeTwo($oid){
    if (empty($oid)) {
        return "<dd>暂无二级分类信息</dd>";
    }else{
        $result = mysql_query("SELECT * FROM goodsTypeTwo WHERE goodsTypeOneId = '$oid' ");
        $nums = mysql_num_rows($result);
        if ($nums > 0) {
            $x = 0;
            while ($array = mysql_fetch_array($result)){
                $goodsTypeTwo .= "
					<dd><a href='{$root}mGoods.php?tid={$array['id']}'>{$array['name']}</a></dd>
					";
            }
        }else{
            $goodsTypeTwo = "<dd>暂无二级分类信息</dd>";
        }
        return $goodsTypeTwo;
    }
}
/**
 * 商品显示函数
 * @param  $oid 一级分类ID
 * @return 商品显示列表
 */
function goods($oid){
    global $root;
    if (empty($oid)) {
        return "<li>暂无该分类商品信息</li>";
    }else{
        $sql = "SELECT * FROM goods WHERE goodsTypeOneId = '$oid' limit 0,50";
        $result = mysql_query($sql);
        $nums = mysql_num_rows($result);
        if ($nums > 0) {
            $content = "";
            while ($goods = mysql_fetch_array($result)){
                if (empty($goods['ico'])) {
                    $ico = $root.img("Ymu67366525YP");
                }else{
                    $ico = $root.$goods['ico'];
                }
                $content .= "
				    <li>
						<a href='{$root}m/mGoodsMx.php?gid={$goods['id']}'>
						<img src='{$ico}'/>
					  	<p class='nameSpc'>{$goods['name']}</p>
					  	<p class='textSale'> <em class='text-price'>￥{$goods['price']}</em> <em class='text-sale'>销量:{$goods['salesVolume']}</em> </p>
					  	</a>
					</li>";
            }
        }else{
            $content = "<li>暂无该分类商品信息</li>";
        }
        return $content;
    }
}
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root?>m/mindex.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text"><input type="text" class="search" id="keyword" placeholder="请输入要搜索的商品名称" /></p>
        </div>
        <a href="<?php echo $root.'m/mGoods.php';?>" class="header-btn search-href"><input type="submit" class="search-btn" value="搜索" /></a>
    </div>
</div>
<!--//-->
<div class="container">
    <div class="mclass">
        <div class="mclass-content mui-dis-flex">
            <!--分类导航-->
            <div class="mclass-menu  mui-mbottom60 ">
                <ul id="mclass">
                    <!-- 一级分类 -->
                    <?php echo $goodsTypeOne; ?>
                </ul>
            </div>
            <!--分类商品-->
            <div class="mclass-panel flex-ratio   mui-mbottom60">
                <div class="mclass-advert"></div>
                <div class="product">
                    <dl>
                        <!-- 二级分类 -->
                        <?php echo typeTwo($oid); ?>
                    </dl>
                    <ul class="product-lists mui-dis-flex goods-lists ">
                        <!-- 商品部分 -->
                        <?php echo goods($oid); ?>
                    </ul>
                </div>
                <div class="page"></div>
            </div>
            <!--//-->
        </div>
    </div>
</div>
<!--底部-->
<?php echo mWarn().Footer(); ?>
<!--//-->
<script>
    //导航高亮
    $(document).ready(function(){
        var oid = '<?php echo $oid;?>';
        $("[oid="+ oid +"]").parent().addClass("current");
    })
    $(function(){
        changeNav();
        //搜索
        $("#keyword").on("blur",function(){
            var keyword = $.trim($("#keyword").val());
            $(".search-href").attr("href",$(".search-href").attr("href") + "?keyword="+keyword);
        })
    })
</script>
</body>
</html>