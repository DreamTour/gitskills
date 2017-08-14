<?php
include "ku/adfunction.php";
ControlRoot("商品管理");
if(empty($get['id'])){
    $title = "新建商品";
    $button = "新建";
    $goods['scareBuying'] = "否"; //抢购
    $goods['sellingToday'] = "否"; //今日热销
    $goods['publicGood'] = "否"; //公益商品
}else{
    $goods = query("goods"," id = '$get[id]' ");
    if($goods['id'] != $get['id']){
        $_SESSION['warn'] = "未找到本商品";
        header("location:{$root}control/adGoods.php");
        exit(0);
    }
    //列表图像
    $goodsIco = "
  <tr>
    <td>商品列表图像：</td>
    <td>
  ".ProveImgShow($goods['ico'])."
    <span onclick='document.GoodsIcoForm.GoodsIcoUpload.click();' class='SpanButton'>更新</span>
    <span class='smallword'>图像尺寸：宽800px*高800px，最大体积1M</span>
    </td>
  </tr>
  ";
    //橱窗图片
    $GoodsWin = "
  <tr>
    <td>商品橱窗图：</td>
    <td>
  ";
    $GoodsWinSql = mysql_query(" select * from goodsWin where goodsId = '$goods[id]' order by time desc ");
    $GoodsWinNum = mysql_num_rows($GoodsWinSql);
    if($GoodsWinNum == 0){
        $GoodsWin .= "一张图片都没有";
    }else{
        while($array = mysql_fetch_array($GoodsWinSql)){
            $GoodsWin .= "
      <a class='GoodsWin' target='_blank' href='{$root}{$array['src']}'><img src='{$root}{$array['src']}'></a>
      <a href='{$root}control/ku/adpost.php?GoodsWinDelete={$array['id']}'><div>X</div></a>
      ";
        }
    }
    if($GoodsWinNum < 5){
        $GoodsWin .= "<span onclick='document.GoodsWinForm.GoodsWinUpload.click();' class='SpanButton'>新增</span>";
    }
    $GoodsWin .= "
  <span class='smallword'>图片尺寸：宽800px*高800px，最大体积1M</span>
    </td>
  </tr>
  ";
    //商品规格
    $goodsKu = "";
    $RuleSql = mysql_query(" select * from goodsSku where goodsId = '$goods[id]' order by updateTime desc ");
    if(mysql_num_rows($RuleSql) == 0){
        $goodsKuInfo .= "<tr><td colspan='10'>一条记录都没有</td></tr>";
    }else{
        while($Rule = mysql_fetch_array($RuleSql)){
            $goodsKuInfo .="
      <tr>
        <td><span EditRule='{$Rule['id']}' class='SpanButton'>编辑</span></td>
        <td>{$Rule['name']}</td>
        <td>{$Rule['price']}</td>
        <td>{$Rule['priceMarket']}</td>
        <td>{$Rule['number']}</td>
        <td>{$Rule['skuNum']}</td>
        <td>{$Rule['skuSeat']}</td>
        <td>{$Rule['factory']}</td>
        <td>{$Rule['updateTime']}</td>
        <td><span value='{$Rule['id']}' name='deleteSpec' class='SpanButton'>删除</span></td>
      </tr>
      ";
        }
    }
    $goodsKu .="
  <form>
  <table class='TableMany'>
    <tr>
      <td><span EditRule='' class='SpanButton'>添加</span></td>
      <td>规格名称</td>
      <td>规格单价</td>
      <td>规格市场价</td>
      <td>库存</td>
      <td>货号</td>
      <td>货位信息</td>
      <td>厂家信息</td>
      <td>更新时间</td>
      <td></td>
    </tr>
    {$goodsKuInfo}
  </table>
    </form>
  ";
    //其他参数
    $title = $goods['name'];
    $button = "更新";
    $article = "
  <div class='kuang smallword'>产品详情的图片超过950px时会被压缩</div>
  ".article("商品明细",$goods['id'],$goods['goodsTypeOneId'],950);
}
$onion = array(
    "商品管理" => root."control/adGoods.php",
    $title => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minheight">
        <!--商品明细开始-->
        <div class="kuang">
            <img src="<?php echo "{$root}img/images/edit.png";?>">
            商品基本参数
            <form name="GoodsForm">
                <table class="TableRight">
                    <tr>
                        <td><span class="must">*</span>&nbsp;商品ID：</td>
                        <td>
                            <?php echo kong($goods['id']);?>
                            <a target="_blank" href="<?php echo root."m/mGoodsMx.php?gid=".$goods['id'];?>"><span class="SpanButton FloatRight">预览商品</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;商品名称：</td>
                        <td><input name="goodsName" type="text" class="text" value="<?php echo $goods['name'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;分类</td>
                        <td>
                            <?php echo IDSelect("goodsTypeOne  order by list ","goodsTypeOneId","select","id","name","--一级分类--",$goods['goodsTypeOneId']);?>
                            <select name="goodsTypeTwoId" class="select">
                                <?php echo IdOption(" goodsTypeTwo where goodsTypeOneId = '$goods[goodsTypeOneId]' and xian = '显示' order by list ","id","name","--二级分类--",$goods['goodsTypeTwoId']);?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>摘要：</td>
                        <td>
                            <textarea name="summary" class="textarea"  ><?php echo $goods['summary'];?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>促销信息：</td>
                        <td>
                            <textarea name="promotion" class="textarea"  ><?php echo $goods['promotion'];?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>商品详细参数：</td>
                        <td>
                            <textarea name="parameter" class="textarea"  ><?php echo $goods['parameter'];?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;商品单价：</td>
                        <td><input name="price" type="text" class="text TextPrice" value="<?php echo $goods['price'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;市场价：</td>
                        <td><input name="priceMarket" type="text" class="text TextPrice" value="<?php echo $goods['priceMarket'];?>"></td>
                    </tr>
                    <tr>
                        <td>是否为免费商品：</td>
                        <td><?php echo radio("publicGood",array("是","否"),$goods['publicGood']);?></td>
                    </tr>
                    <?php echo $goodsIco.$GoodsWin;?>
                    <tr>
                        <td>商品二维码：</td>
                        <td><img src="<?php echo "{$root}pay/wxpay/wxScanPng.php?url={$root}m/mGoodsMx.php?gid={$get['id']}";?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;排序号：</td>
                        <td><input name="GoodsList" type="text" class="text TextPrice" value="<?php echo $goods['list'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;前端状态：</td>
                        <td><?php echo radio("GoodsShow",array("显示","隐藏"),$goods['xian']);?></td>
                    </tr>
                    <tr>
                        <td>更新时间：</td>
                        <td><?php echo kong($goods['updateTime']);?></td>
                    </tr>
                    <tr>
                        <td>创建时间：</td>
                        <td><?php echo kong($goods['time']);?></td>
                    </tr>
                    <tr>
                        <td><input name="goodsid" type="hidden" value="<?php echo $goods['id'];?>"></td>
                        <td><input type="button" class="button" value="<?php echo $button;?>" onclick="Sub('GoodsForm',root+'control/ku/addata.php?type=upGoods')"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--商品明细结束-->
        <?php echo $goodsKu.$article;?>
    </div>
    <!--规格弹出编辑层开始-->
    <div class="hide" id="adGoodsRule">
        <div class="dibian"></div>
        <div class="win" style="+
        width: 600px; height:350px; margin: -174px 0px 0px -300px;">
            <p class="winTitle">编辑商品规格<span onclick="$('#adGoodsRule').hide()" class="winClose">×</span></p>
            <form name="SpecForm">
                <table class="TableRight">
                    <tr>
                        <td style="width:100px;">规格名称：</td>
                        <td><input name="specName" type="text" class="text"></td>
                    </tr>
                    <tr>
                        <td>规格单价：</td>
                        <td><input name="specPrice" type="text" class="text TextPrice">&nbsp;元</td>
                    </tr>
                    <tr>
                        <td>规格市场价：</td>
                        <td><input name="priceMarket" type="text" class="text TextPrice">&nbsp;元</td>
                    </tr>
                    <tr>
                        <td>库存：</td>
                        <td><input name="specNumber" type="text" class="text TextPrice"></td>
                    </tr>
                    <tr>
                        <td>货号：</td>
                        <td><input name="skuNumber" type="text" class="text TextPrice"></td>
                    </tr>
                    <tr>
                        <td>货位信息：</td>
                        <td><input name="skuSeat" type="text" class="text TextPrice"></td>
                    </tr>
                    <tr>
                        <td>厂家信息：</td>
                        <td><input name="factory" type="text" class="text"></td>
                    </tr>
                    <tr>
                        <td>
                            <input name="specId" type="hidden" >
                            <input name="GoodsId" type="hidden" value="<?php echo $get['id'];?>">
                        </td>
                        <td><input id="specSub" type="button" class="button" onclick="Sub('SpecForm','<?php echo root."control/ku/addata.php";?>')" value="确认提交"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!--规格弹出编辑层结束-->
    <!--隐藏域开始-->
    <div class="hide">
        <form name="GoodsIcoForm" action="<?php echo root."control/ku/adpost.php?type=goodsIco";?>" method="post" enctype="multipart/form-data">
            <input name="GoodsIcoUpload" type="file" onchange="document.GoodsIcoForm.submit();">
            <input name="GoodsId" type="hidden" value="<?php echo $goods['id'];?>">
        </form>
        <form name="GoodsWinForm" action="<?php echo root."control/ku/adpost.php?type=goodsWin";?>" method="post" enctype="multipart/form-data" change="Upload" style="display:none;">
            <input name="GoodsWinUpload" type="file" onchange="document.GoodsWinForm.submit();">
            <input name="GoodsId" type="hidden" value="<?php echo $goods['id'];?>">
        </form>
    </div>
    <!--隐藏域结束-->
    <script>
        $(function(){
            //查询一级分类
            var GoodsForm = document.GoodsForm;
            GoodsForm.goodsTypeOneId.onchange = function(){
                $.post(root+"control/ku/addata.php?type=queryOne",{goodsTypeOneIdGetTwoId:this.value},function(data){
                    GoodsForm.goodsTypeTwoId.innerHTML = data.two;
                },"json");
            }
            //删除商品规格
            $("[name=deleteSpec]").click(function(){
                $.post(root+"control/ku/addata.php?type=deleteSpecId",{deleteSpecId:$(this).attr("value")},function(data){
                    if(data.warn == "2"){
                        location.reload();
                    }else{
                        warn(data.warn);
                    }

                },"json");
            })
            //显示规格弹出层
            $("[EditRule]").click(function(){
                var editId = $(this).attr("editrule");
                $("#adGoodsRule").show();
                $.post(root+"control/ku/addata.php",{editId:$(this).attr("editrule")},function(data){
                    $("input[name=specName]").val(data['warn']['name']);//规格名称
                    $("input[name=specPrice]").val(data['warn']['price']);//规格单价
                    $("input[name=priceMarket]").val(data['warn']['priceMarket']);//市场单价
                    $("input[name=specNumber]").val(data['warn']['number']);//库存
                    $("input[name=skuNumber]").val(data['warn']['skuNum']);//货号
                    $("input[name=skuSeat]").val(data['warn']['skuSeat']);//货位信息
                },"json");
                $("input[name=specId]").val(editId);
            });
        });
    </script>
<?php echo warn().adfooter();?>