<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$ThisUrl = root."control/adClient.php";
$sql="select * from kehu ".$_SESSION['adClient']['Sql'];
paging($sql," order by UpdateTime desc",100);
$onion = array(
    "客户管理" => $ThisUrl
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
    <div class="column minheight">
        <div class="kuang">
            <form name="Search" action="<?php echo "{$adroot}ku/adpost.php?type=adClient";?>" method="post">
                昵称：<input name="adClientNickName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['wxNickName'];?>">
                姓名：<input name="adClientName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['name'];?>">
                <select name="adClientSex" class="select TextPrice">
                    <?php echo option("--性别--",array('男','女'),$_SESSION['adClient']['wxSex']) ?>
                </select>
                手机号码：<input name="adClientTel" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['khtel'];?>">
                客户类型：
                <select name="adClientType" class="select TextPrice">
                    <?php echo option("--类型--",array('普通会员','vip会员'),$_SESSION['adClient']['type']) ?>
                </select>
                推荐人：<input name="adShareId" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['shareId'];?>">
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
    <span class="SpanButton">
      共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
      当前显示第<b class="must"><?php echo $page;?></b>页的信息
    </span>
            <a href="<?php echo "{$root}control/adClientQuestion.php";?>"><span class="SpanButton FloatRight">调查问卷</span></a>
            <span onclick="$('[name=ClientForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=ClientForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="ClientForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>昵称</td>
                    <td>客户姓名</td>
                    <td>性别</td>
                    <td>手机号码</td>
                    <td>客户类型</td>
                    <td>是否为员工</td>
                    <td>推荐人</td>
                    <td>默认收货地址</td>
                    <td>更新时间</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($array = mysql_fetch_array($query)){
                        if ($array['staff'] == "") {
                            $array['staff'] = "否";
                        }
                        if ($array['type'] == '') {
                            $array['type'] = '普通会员';
                        }
                        $client = query("kehu", "khid = '$array[shareId]' ");
                        echo "
        <tr>
          <td><input name='ClientList[]' type='checkbox' value='{$array['khid']}'/></td>
          <td>".kong($array['wxNickName'])."</td>
          <td>".kong($array['name'])."</td>
          <td>".kong($array['wxSex'])."</td>
          <td>".kong($array['khtel'])."</td>
          <td>{$array['type']}</td>
          <td>{$array['staff']}</td>
          <td>{$client['wxNickName']}</td>
          <td>".queryAddress($array['addressId'])."</td>
          <td>{$array['updateTime']}</td>
          <td><a href='{$root}control/adClientMx.php?kehu={$array['khid']}'><span class='SpanButton'>详情</span></a></td>
        </tr>
        ";
                    }
                }else{
                    echo "<tr><td colspan='10'>一个客户都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo warn().adfooter();?>