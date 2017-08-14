<?php
include "ku/adfunction.php";
ControlRoot("adStatistics");
$backstage = query("backstage","id = '$get[id]' ");
/*if(empty($kehu['khid'])){
    $_SESSION['warn'] = "未找到这个客户的信息";
    header("location:{$root}control/adClient.php");
    exit(0);
}*/
$onion = array(
    "数据统计" => root."control/adStatistics.php",
    "后台列表" => root."control/adStatisticsBack.php",
    kong($backstage['name']) => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minHeight">
        <!--基本资料开始-->
        <div class="kuang">
            <form name="adStatisticsBack" method="post" accept-charset="utf-8">
                <table class="tableRight">
                    <tr>
                        <td>后台ID号：</td>
                        <td><?php echo kong($backstage['id']);?></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span> 后台名称：</td>
                        <td><input name='name' type='text' class='text' value='<?php echo $backstage['name'];?>'></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span> 日期：</td>
                        <td><input style='width: 187px' name='backDate' class='datainp text' id='backDate' type='text' placeholder='请选择' value='<?php echo $backstage['backDate'];?>' readonly></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span> 花费：</td>
                        <td><input name='spend' type='text' class='text' value='<?php echo $backstage['spend'];?>'></td>
                    </tr>
                    <tr>
                        <td>更新时间：</td>
                        <td><?php echo kong($backstage['updateTime']);?></td>
                    </tr>
                    <tr>
                        <td>注册时间：</td>
                        <td><?php echo kong($backstage['time']);?></td>
                    </tr>
                    <tr>
                        <td><input name='adStatisticsBackId' type='hidden' value='<?php echo $backstage['id'];?>'></td>
                        <td><input onclick="Sub('adStatisticsBack',root+'control/ku/addata.php?type=adStatisticsBack')" type='button' class='button' value='提交'></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--后台花费开始-->
        <div class="column">
            <form name="clinchRecordForm">
                <table class="tableMany">
                    <tr>
                        <td>序号</td>
                        <td>日期</td>
                        <td>花费</td>
                        <td width="45px"></td>
                    </tr>
                    <?php
                    $backSpendSql = mysql_query("SELECT * FROM backSpend WHERE backId = '$get[id]' ORDER BY time DESC ");
                    $i = 0;
                    if(mysql_num_rows($backSpendSql) == 0){
                        echo "<tr><td colspan='5'>一条信息都没有</td></tr>";
                    }else{
                        while($array = mysql_fetch_array($backSpendSql)){
                            $i++;
                            echo "
                                <tr>
                                    <td>$i</td>
                                    <td>{$array['date']}</td>
                                    <td>{$array['spend']}</td>
                                    <td>
                                        <a href='{$root}control/ku/adpost.php?DeleteBackSpend={$array['id']}'>
                                            <span class='spanButton'>删除</span>
                                        </a>
                                    </td>
                                </tr>
                                ";
                        }
                    }
                    ?>
                </table>
            </form>
        </div>
        <!--后台花费结束-->
        <!--基本资料结束-->
    </div>
    <script type="text/javascript" src="<?php echo $root;?>jeDate/jedate.js"></script>
    <script>
        window.onload = function() {
            //日期
            jeDate({
                dateCell:"#backDate",
                format:"YYYY-MM-DD",
                isinitVal:true,
                isTime:true, //isClear:false,
                minDate:"2014-09-19 00:00:00",
                choosefun:function(val){
                    var Date = document.getElementById('backDate');
                    Date.value = val;
                    Date.setAttribute('value', val);
                },
                okfun:function(val){
                    var Date = document.getElementById('backDate');
                    Date.value = val;
                    Date.setAttribute('value', val);
                },
            })
        }
    </script>
<?php echo warn().adfooter();?>