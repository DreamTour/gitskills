<?php
include "ku/adfunction.php";
ControlRoot("adStatistics");
$ThisUrl = root."control/adClient.php";
$sql="SELECT * FROM backstage ".$_SESSION['adStatisticsBack']['Sql'];
paging($sql," order by updateTime desc",100);
$onion = array(
    "数据统计" => root."control/adStatistics.php",
    "后台列表" => $ThisUrl
);
/*
 * 查询默认收货地址
 * $addressId 收货地址ID
 */
function queryAddress($addressId){
    if (empty($addressId)) {
        $str = "未设置默认地址";
    }else{
        $address = query("address","id = '{$addressId}'");
        if (empty($address['id'])) {
            $str = "未设置默认地址";
        }else{
            $str = Region($address['RegionId']).$address['AddressMx'];
        }
    }
    return $str;
}
echo head("ad").adheader($onion);
?>
    <div class="column minHeight">
        <div class="kuang">
            <form name="Search" action="<?php echo "{$adroot}ku/adpost.php?type=adStatisticsBack";?>" method="post">
                后台名称：<input name="adName" type="text" class="text textPrice" value="<?php echo $_SESSION['adStatisticsBack']['name'];?>">
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
    <span class="SpanButton">
      共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
      当前显示第<b class="must"><?php echo $page;?></b>页的信息
    </span>
            <a href="<?php echo "{$root}control/adStatisticsBackMx.php";?>"><span class="spanButton floatRight">新增后台</span></a>
            <span class="spanButton floatRight" onclick="EditList('statisticsForm','backDelete')">删除后台</span>
            <span onclick="$('[name=backForm] [type=checkbox]').prop('checked',false);" class="spanButton floatRight">取消选择</span>
            <span onclick="$('[name=backForm] [type=checkbox]').prop('checked',true);" class="spanButton floatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="backForm">
            <table class="tableMany">
                <tr>
                    <td></td>
                    <td>后台名称</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($array = mysql_fetch_array($query)){
                        echo "
                            <tr>
                              <td><input name='backList[]' type='checkbox' value='{$array['id']}'/></td>
                              <td>".kong($array['name'])."</td>
                              <td><a href='{$root}control/adStatisticsBackMx.php?id={$array['id']}'><span class='spanButton'>编辑</span></a></td>
                            </tr>
                        ";
                    }
                }else{
                    echo "<tr><td colspan='3'>一个后台都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>