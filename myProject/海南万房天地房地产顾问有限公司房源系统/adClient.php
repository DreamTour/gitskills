<?php
include "ku/adfunction.php";
ControlRoot("adClient");
$ThisUrl = root."control/adClient.php";
//判断是否第一次进入当前页面，如果不是则清除session值，是则保留session值
if($_SERVER['HTTP_REFERER'] != $ThisUrl){
    unset($_SESSION['adClient']);
}
//判断是否具有客户分配的权限
if($adDuty['name'] != '员工'){
    $allotClient = "<span class='spanButton floatRight' onclick=\"$('#allotClient').fadeIn()\">客户分配</span>";
}
//判断是否具有新建客户的权限
if($adDuty['name'] == '员工'){
    $createClient = "<a href='{$root}control/adClientMx.php'><span class='spanButton floatRight'>新建客户</span></a>";
    $where .= " AND adid = '$Control[adid]' ";
}
//经理的客户
if($adDuty['name'] == '经理'){
    $where .= " AND adid in (SELECT adid FROM admin WHERE managerId = '$Control[adid]') ";
    $contactTelTd  = "";
}
else {
    $contactTelTd  = "<td>联系人手机</td>";
}
//查重复号码
$contactTelSql = mysql_query("SELECT * FROM kehu ");
$contactTelSet = array();
while ($array = mysql_fetch_assoc($contactTelSql)) {
    $contactTelSet[] = $array['contactTel'];
}
function isRepeat($array) {
    $temp = array();
    $tempRepeat = array();
    foreach ($array as $value) {
        if (in_array($value,$temp)) {
            $tempRepeat[] = $value;
        } else {
            $temp[] = $value;
        }
    }
    return $tempRepeat;
}
$contactTelRepeat = isRepeat($contactTelSet);
//客户分配
if ($adDuty['name'] == '超级管理员') {
    $staffSet = IDSelect("admin WHERE duty = 'Jsc62913097wj' ","adId","selectShort","adid","adname","-所属员工-",$_SESSION['adClient']['adid']);
}
else {
    $staffSet = IDSelect("admin WHERE managerId = '$Control[adid]' ","adId","selectShort","adid","adname","-所属员工-",$_SESSION['adClient']['adid']);
}
$sql = "select * from kehu where 1=1 ".$where.$_SESSION['adClient']['Sql'].'ORDER BY sort ASC';
//权限
if($adDuty['name'] == '超级管理员'){
    $where .= "AND duty = 'Jsc62913097wj' ";
}
paging($sql,"  order by time desc",100);
$onion = array(
    "客户管理" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minHeight">
        <!--查询开始-->
        <div class="search">
            <form name="Search" action="<?php echo root."control/ku/adpost.php?type=selectClient";?>" method="post" style="overflow: hidden;">
                <?php echo select("type","select textPrice","-客户性质-",array("私客","小组公客","公司公客"),$_SESSION['adClient']['type']);?>
                联系人姓名：<input name="contactName" type="text" class="text textPrice" value="<?php echo $_SESSION['adClient']['contactName'];?>">
                联系人手机：<input name="contactTel" type="text" class="text textPrice" value="<?php echo $_SESSION['adClient']['contactTel'];?>">
                <?php echo select("clientStatus","select textPrice","-客户状态-",array("成交","放弃","待回访","今日需回访","今日已回访","逾期未回访"),$_SESSION['adClient']['clientStatus']);?>
                <?php echo select("intentionArea","select textPrice","-意向区域-",array("海口","临高","澄迈","定安","文昌","儋州","屯昌","琼海","昌江","白沙","琼中","万宁","东方","五指山","保亭","陵水","乐东","三亚"),$_SESSION['adClient']['intentionArea']);?>
                <?php echo select("fromArea","select textPrice","-来自区域-",explode('，',website("lpz74025452eD")),$_SESSION['adClient']['fromArea']);?>
                <?php echo select("clientLevel","select textPrice","-客户等级-",array("0分","10分","20分","30分","40分","50分","60分","70分","80分","90分","100分"),$_SESSION['adClient']['clientLevel']);?>
                <?php echo select("clientType","select textPrice","-客户类型-",array("投资","度假","养老","刚需"),$_SESSION['adClient']['clientType']);?>
                <?php echo select("clientSourceOne","select textPrice","-来电方式-",array("来电","商桥聊天","商桥留言","网站留言"),$_SESSION['adClient']['clientSourceOne']);?>
                <div style="margin-top: 10px;">
                    <?php echo IDSelect("admin where 1=1 $where","adname","select textPrice","adid","adname","-销售员-",$_SESSION['adClient']['adname']);?>
                    来电开始时间：<input name='callTimeStart' style='width: 187px' class='datainp text' id='callTimeStart' type='text' placeholder='请选择' value='<?php echo $_SESSION['adClient']['callTimeStart'];?>'  readonly>
                    来电结束时间：<input name='callTimeEnd' style='width: 187px' class='datainp text' id='callTimeEnd' type='text' placeholder='请选择' value='<?php echo $_SESSION['adClient']['callTimeEnd'];?>'  readonly>
                    <input type="submit" class="floatRight" style="margin-top: 10px" value="模糊查询">
                </div>
            </form>
        </div>
        <div class="search">
		<span class="smallWord">
			共找到<b class="red"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="red"><?php echo $page;?></b>页的信息
		</span>
            <span class="spanButton floatRight" onclick="EditList('ClientForm','deleteClient')">删除客户</span>
            <?php echo $createClient.$allotClient;?>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="ClientForm">
            <table class="tableMany" id='contactTel'>
                <tr>
                    <td></td>
                    <td>客户性质</td>
                    <td>联系人姓名</td>
                    <?php echo $contactTelTd;?>
                    <td>客户状态</td>
                    <td>销售员</td>
                    <td>创建时间</td>
                    <td width="45px"></td>
                </tr>
                <?php
                if($num == 0){
                    echo "<tr><td colspan='18'>一条信息都没有</td></tr>";
                }else{
                    $query = mysql_query($sql);
                    while($kehu = mysql_fetch_array($query)){
                        if(in_array($kehu['contactTel'], $contactTelRepeat)) {
                            $red = 'red';
                            $contactTel = 'contactTel';
                            $clientSql = mysql_query("SELECT adname FROM admin WHERE adid in (SELECT adid FROM kehu WHERE contactTel = '$kehu[contactTel]')  ");
                            $adName = '';
                            while ($array = mysql_fetch_assoc($clientSql)) {
                                $adName .= ",".$array['adname'];
                            }
                            $adNameSet = substr($adName,1);
                        } else {
                            $red = '';
                            $contactTel = '';
                            $adNameSet = '';
                        }
                        //经理权限
                        if($adDuty['name'] == '经理'){
                            $contactTelTdMx = "";
                        }
                        else {
                            $contactTelTdMx = "<td class='{$red} {$contactTel}'>{$kehu['contactTel']}<div class='hide staff'>{$adNameSet}</div></td>";
                        }
                        //销售员
                        $admin = query("admin", " adid = '$kehu[adid]' ");
                        echo "
				<tr>
					<td><input name='ClientList[]' type='checkbox' value='{$kehu['khid']}'/></td>
					<td>{$kehu['type']}</td>
					<td>{$kehu['contactName']}</td>
                    {$contactTelTdMx}
					<td class='clientStatus'>{$kehu['clientStatus']}</td>
					<td>{$admin['adname']}</td>
					<td>{$kehu['time']}</td>
					<td><a href='{$root}control/adClientMx.php?id={$kehu['khid']}'><span class='spanButton'>编辑</span></a></td>
				</tr>
				";
                    }
                }
                ?>
            </table>
        </form>
        <?php echo fenye($ThisUrl,7);?>
        <!--列表结束-->

        <!--统计员工信息-->
        <form name="employeeForm">
            <table class="tableMany" >
                <tr>
                    <td>员工姓名</td>
                    <td>客户上限</td>
                    <td>客户数量</td>
                    <td>逾期</td>
                    <td>今日需回访</td>
                    <td>今日已回访</td>
                    <td>今日创建客户</td>
                </tr>
                <?php
                $adminSql = mysql_query("SELECT * FROM admin WHERE 1=1 {$where} ");
                if(mysql_num_rows($adminSql) == 0){
                    echo "<tr><td colspan='2'>一条信息都没有</td></tr>";
                }
                else{
                    while($array = mysql_fetch_assoc($adminSql)){
                        $clientNum = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE adid = '$array[adid]' "));
                        $overdueNum = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE adid = '$array[adid]' AND clientStatus LIKE '%逾期未回访%' "));
                        $needNum = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE adid = '$array[adid]' AND clientStatus LIKE '%今日需回访%' "));
                        $alreadyNum = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE adid = '$array[adid]' AND clientStatus LIKE '%今日已回访%' "));
                        $createNum = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE adid = '$array[adid]' AND callTime LIKE '$date%' "));
                        echo "
                            <tr>
                                <td>{$array['adname']}</td>
                                <td>{$array['clientNum']}</td>
                                <td>{$clientNum}</td>
                                <td>{$overdueNum}</td>
                                <td>{$needNum}</td>
                                <td>{$alreadyNum}</td>
                                <td>{$createNum}</td>
                            </tr>
                        ";
                    }
                }
                ;?>
            </table>
        </form>
        <!--统计员工信息结束-->
    </div>
    <!--客户分配开始-->
    <div class="hide" id="allotClient">
        <div class="dibian"></div>
        <div class="win" style="width: 500px; height: 234px; margin: -117px 0px 0px -250px;">
            <p class="winTitle">客户分配<span onclick="$('#allotClient').hide()" class="winClose">×</span></p>
            <form name="allotClientForm">
                <table class="tableRight">
                    <tr>
                        <td style="width:100px;">提示信息：</td>
                        <td>把某成员的客户批量转移给其他成员，一旦分配成功，对方将立即看到所属客户的基本信息，你确定要这样做吗？</td>
                    </tr>
                    <tr>
                        <td>选择：</td>
                        <td> <?php echo $staffSet;?></td>
                    </tr>
                    <tr>
                        <td>登录密码：</td>
                        <td><input name="Password" type="password" class="text short"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input onclick="Sub('allotClientForm,ClientForm',root+'control/ku/addata.php?type=allotClient')" type="button" class="button" value="确认分配"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!--客户分配结束-->
    <script type="text/javascript" src="<?php echo $root;?>jeDate/jedate.js"></script>
    <script>
        window.onload = function() {
            //来电开始时间
            jeDate({
                dateCell:"#callTimeStart",
                format:"YYYY-MM-DD",
                isinitVal:false,
                isTime:true, //isClear:false,
                minDate:"2014-09-19 00:00:00",
                choosefun:function(val){
                    var Date = document.getElementById('callTimeStart');
                    Date.value = val;
                    Date.setAttribute('value', val);
                }
            })

            //来电结束时间
            jeDate({
                dateCell:"#callTimeEnd",
                format:"YYYY-MM-DD",
                isinitVal:false,
                isTime:true, //isClear:false,
                minDate:"2014-09-19 00:00:00",
                choosefun:function(val){
                    var Date = document.getElementById('callTimeEnd');
                    Date.value = val;
                    Date.setAttribute('value', val);
                }
            })

            //鼠标移到手机号码上面时，可以显示是哪些员工在跟进
            var contactTel = document.getElementById('contactTel');
            var tdSet = contactTel.querySelectorAll('.contactTel');
            for (var i=0;i<tdSet.length;i++) {
                tdSet[i].onmouseover = function() {
                    var staffSet = this.querySelectorAll('.staff')[0];
                    staffSet.style.display = 'block';
                }
                tdSet[i].onmouseout = function() {
                    var staffSet = this.querySelectorAll('.staff')[0];
                    staffSet.style.display = 'none';
                }
            }

            //客户状态变化
            $.ajax({
                url: '<?php echo root."control/ku/addata.php?type=changeStatus";?>',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                },
                error: function() {
                    alert('服务器错误');
                },
            })
        }
    </script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>