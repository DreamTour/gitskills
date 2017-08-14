<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$kehu = query("kehu","khid = '$get[kehu]' ");
if(empty($kehu['khid'])){
    $_SESSION['warn'] = "未找到这个客户的信息";
    header("location:{$root}control/adClient.php");
    exit(0);
}else{
    if ($kehu['staff'] == "") {
        $kehu['staff'] = "否";
    }
    if ($kehu['type'] == "") {
        $kehu['type'] = "普通会员";
    }
}
$onion = array(
    "客户管理" => root."control/adClient.php",
    "客户详情" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column MinHeight">
        <!--基本资料开始-->
        <div class="kuang">
            <form name="adClientMx" method="post" accept-charset="utf-8">
                <table class="TableRight">
                    <tr>
                        <td>客户ID号：</td>
                        <td><?php echo $kehu['khid'];?></td>
                    </tr>
                    <tr>
                        <td>是否为员工：</td>
                        <td><?php echo $kehu['staff'];?>
                            <a href="javascript:void(0)" onclick="options('<?php echo $kehu['khid']; ?>')"><span class="SpanButton">操作</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td>会员类型：</td>
                        <td><?php echo $kehu['type'];?>
                            <a href="javascript:void(0)" onclick="vipType('<?php echo $kehu['khid']; ?>')"><span class="SpanButton">设置vip会员</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td>头像：</td>
                        <td><?php echo ProveImgShow($kehu['wxIco'],"暂未上传");?></td>
                    </tr>
                    <tr>
                        <td>姓名：</td>
                        <td><?php echo kong($kehu['name']);?></td>
                    </tr>
                    <tr>
                        <td>昵称：</td>
                        <td><?php echo kong($kehu['wxNickName']);?></td>
                    </tr>
                    <tr>
                        <td>性别：</td>
                        <td><?php echo kong($kehu['wxSex']);?></td>
                    </tr>
                    <tr>
                        <td>手机号码：</td>
                        <td><?php echo kong($kehu['khtel']);?></td>
                    </tr>
                    <tr>
                        <td>积分余额：</td>
                        <td>
                            <?php echo kong($kehu['integral']);?>
                        </td>
                    </tr>
                    <tr>
                        <td>更新时间：</td>
                        <td><?php echo $kehu['updateTime'];?></td>
                    </tr>
                    <tr>
                        <td>注册时间：</td>
                        <td><?php echo $kehu['time'];?></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
    <script>
        //设置是否为员工
        function options(khid) {
            $.post('<?php echo root."control/ku/addata.php?type=operation"; ?>', {khid: khid}, function(data) {
                if(data.warn == 2){
                    if(data.href){
                        window.location.href = data.href;
                    }else{
                        window.location.reload();
                    }
                }else{
                    warn(data.warn);
                }
            },'json');
        }
        //设置为会员
        function vipType(khid) {
            $.post('<?php echo root."control/ku/addata.php?type=vipType"; ?>', {khid: khid}, function(data) {
                if(data.warn == 2){
                    if(data.href){
                        window.location.href = data.href;
                    }else{
                        window.location.reload();
                    }
                }else{
                    warn(data.warn);
                }
            },'json');
        }
    </script>
<?php echo warn().adfooter();?>