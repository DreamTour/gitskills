<?php
include "ku/adfunction.php";
ControlRoot("adStatistics");
$ThisUrl = root."control/adStatistics.php";
//判断是否第一次进入当前页面，如果不是则清除session值，是则保留session值
if($_SERVER['HTTP_REFERER'] != $ThisUrl){
    unset($_SESSION['adStatistics']);
}
//判断是否具有新建计划的权限
if($adDuty['name'] == '超级管理员'){
    $createStatistics = "<a href='{$root}control/adStatisticsMx.php'><span class='spanButton floatRight'>新建计划</span></a>";
    $mergeStatistics = "<span class='spanButton floatRight' id='mergeStatisticsBtn'>合并计划</span>";
    $adStatisticsBack = "<a href='{$root}control/adStatisticsBack.php'><span class='spanButton floatRight'>后台列表</span></a>";
    $where .= " AND adid = '$Control[adid]' ";
}
$sql = "select * from statistics where 1=1 ".$_SESSION['adStatistics']['Sql'].'order by updateTime desc';
paging($sql,"  order by time desc",100);
$onion = array(
    "数据统计" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minHeight">
        <!--查询开始-->
        <div class="search">
            <form name="Search" action="<?php echo root."control/ku/adpost.php?type=adStatistics";?>" method="post">
                计划名称：<input name="planName" type="text" class="text textPrice" value="<?php echo $_SESSION['adStatistics']['planName'];?>">
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="search">
		<span class="smallWord">
			共找到<b class="red"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="red"><?php echo $page;?></b>页的信息
		</span>
            <span class="spanButton floatRight" onclick="EditList('statisticsForm','deleteStatistics')">删除计划</span>
            <?php echo $createStatistics.$mergeStatistics.$adStatisticsBack;?>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="statisticsForm">
            <table class="tableMany" id='plan'>
                <tr>
                    <td></td>
                    <td>计划名称</td>
                    <td>备注</td>
                    <td>创建时间</td>
                    <td width="45px"></td>
                </tr>
                <?php
                if($num == 0){
                    echo "<tr><td colspan='9'>一条信息都没有</td></tr>";
                }else{
                    $query = mysql_query($sql);
                    while($array = mysql_fetch_array($query)){
                        if ($array['type'] == '合并计划') {
                            $button = '';
                        }
                        else {
                            $button = "<span class='spanButton'>编辑</span>";
                        }
                        echo "
				<tr>
					<td><input class='planChoose' name='statisticsList[]' type='checkbox' value='{$array['id']}'/></td>
					<td>{$array['planName']}</td>
					<td>".kong($array['remark'])."</td>
					<td>{$array['time']}</td>
					<td><a href='{$root}control/adStatisticsMx.php?id={$array['id']}'>{$button}</a></td>
				</tr>
				";
                    }
                }
                ?>
            </table>
        </form>
        <div id="main" style="width: 1200px;height:600px; margin-top:20px;"></div>
        <?php echo fenye($ThisUrl,7);?>
        <!--列表结束-->
    </div>
    <div class="hide" id="mergeStatistics">
        <div class="dibian"></div>
        <div class="win" style=" height:400px; width:963px; margin:-200px 0 0 -482px;">
            <p class="winTitle">合并计划<span class="winClose" onclick="$('#mergeStatistics').hide()">×</span></p>
            <form name="mergeStatisticsForm">
                <table class="tableRight">
                    <tbody>
                        <tr>
                            <td><span class="red">*</span>&nbsp;计划名称：</td>
                            <td><input name='planName' type='text' class='text' value='<?php echo $statistics['planName'];?>'></td>
                        </tr>
                        <!--<tr>
                            <td><span class="red">*</span>&nbsp;日期：</td>
                            <td><input name='planDateStart' class='datainp text' id='planDateStart' type='text' placeholder='请选择' value='<?php /*echo $statistics['planDateStart'];*/?>'  readonly> - <input name='planDateEnd' class='datainp text' id='planDateEnd' type='text' placeholder='请选择' value='<?php /*echo $statistics['planDateEnd'];*/?>'  readonly></td>
                        </tr>-->
                        <tr>
                            <td>备注：</td>
                            <td><textarea  name='remark' class='textarea'><?php echo $statistics['remark'];?></textarea></td>
                        </tr>
                        <tr>
                            <td style="width:100px;height:100px;">警告信息：</td>
                            <td>合并计划会清理原来计划的所有信息，您确定要这样做吗？</td>
                        </tr>
                        <tr>
                            <td>登录密码：</td>
                            <td><input name="Password" type="password" class="text short"></td>
                        </tr>
                        <tr>
                            <td>
                                <input name="FormName" type="text" class="hide">
                                <input name="PadWarnType" type="text" class="hide">
                            </td>
                            <td><input type="button" class="button" value="确认提交" onclick="Sub('mergeStatisticsForm,statisticsForm' ,'<?php echo "{$root}control/ku/addata.php?type=mergeStatisticsForm";?>')"></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo $root;?>jeDate/jedate.js"></script>
    <script>
        window.onload = function() {
            //合并计划
            var mergeStatisticsBtn = document.getElementById('mergeStatisticsBtn');
            var mergeStatistics = document.getElementById('mergeStatistics');
            if (mergeStatisticsBtn) {
                mergeStatisticsBtn.onclick = function() {
                    mergeStatistics.style.display = 'block';
                }
            }
            // 统计
            var plan = document.getElementById('plan');
            var planChoose = plan.querySelectorAll('.planChoose');
            // 初始化实例
            var main = document.getElementById('main');
            var myChart = echarts.init(main);
            for (var i=0;i<planChoose.length;i++) {
                planChoose[i].onclick = function() {
                    var str = '';
                    for (var i=0;i<planChoose.length;i++) {
                        if (planChoose[i].checked) {
                            str += '-' + planChoose[i].value;
                        }
                    }
                    str = str.substring(1,str.length)
                    $.ajax({
                        url: '<?php echo "{$root}control/ku/addata.php?type=planChoose";?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {statisticsId: str},
                        success: function(data) {
                            myChart.setOption({
                                tooltip : {
                                    trigger: 'axis',
                                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                                    }
                                },
                                legend: {
                                    data: data.planType,
                                },
                                grid: {
                                    left: '3%',
                                    right: '0%',
                                    bottom: '3%',
                                    containLabel: true
                                },
                                xAxis : [
                                    {
                                        type : 'category',
                                        data : data.planName,
                                    }
                                ],
                                yAxis : [
                                    {
                                        type : 'value'
                                    }
                                ],
                                series : [
                                    {
                                        name:data.planType[0],
                                        type:'bar',
                                        data: data.spend,
                                    },
                                    {
                                        name:data.planType[1],
                                        type:'bar',
                                        data:data.clientNum,
                                    },
                                    {
                                        name:data.planType[2],
                                        type:'bar',
                                        data:data.lookNum,
                                    },
                                    {
                                        name:data.planType[3],
                                        type:'bar',
                                        data:data.intentionNum
                                    },
                                    {
                                        name:data.planType[4],
                                        type:'bar',
                                        data:data.lookIntention
                                    },
                                    {
                                        name:data.planType[5],
                                        type:'bar',
                                        data:data.cost
                                    },
                                    {
                                        name:data.planType[6],
                                        type:'bar',
                                        data:data.price
                                    },
                                ]
                            });
                        },
                        error: function() {
                            alert('服务器错误');
                        },
                    })
                }
            }

        }
    </script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>