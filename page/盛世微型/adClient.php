<?php
include "ku/adfunction.php";
ControlRoot("adClient");
$ThisUrl = root."control/adClient.php";
//判断是否第一次进入当前页面，如果不是则清除session值，是则保留session值
if($_SERVER['HTTP_REFERER'] != $ThisUrl){
    unset($_SESSION['adClient']);
}
//判断是否具有查看全部的客户权限
/*if($adDuty['see'] == '是' ){
    $where = "";
    $allotClient = "<span class='spanButton FloatRight' onclick=\"$('#allotClient').fadeIn()\">客户分配</span>";
    $searchAdId = IDSelect("admin where duty in (select id from adDuty where department = '市场部')","adId","selectShort","adid","adname","-所属员工-",$_SESSION['adClient']['adid']);
}else{
    $where = " and ( adid = '$Control[adid]' or followType = '公客' ) ";
}*/
//判断是否具有客户分配的权限
if($adDuty['name'] != '员工'){
    $allotClient = "<span class='spanButton FloatRight' onclick=\"$('#allotClient').fadeIn()\">客户分配</span>";
}
$staffSet = IDSelect("admin","adId","selectShort","adid","adname","-所属员工-",$_SESSION['adClient']['adid']);
$sql = "select * from kehu where 1=1 ".$where.$_SESSION['adClient']['Sql'].'order by time desc';
paging($sql,"  order by time desc",100);
$province = $_SESSION['adClient']['province'];//省
$city = $_SESSION['adClient']['city'];//城市
$area = $_SESSION['adClient']['area'];//区域
$onion = array(
    "客户管理" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minHeight">
        <!--查询开始-->
        <div class="search">
            <form name="Search" action="<?php echo root."control/ku/adpost.php?type=selectClient";?>" method="post">
                <div class="inputKuang">
               <span>
                联系人姓名：<input name="ContactName" type="text" class="selectShort TextPrice" value="<?php echo $_SESSION['adClient']['ContactName'];?>">
               </span>
               <span>
                联系人手机：<input name="ContactTel" type="text" class="selectShort TextPrice" value="<?php echo $_SESSION['adClient']['ContactTel'];?>">
               </span>
                </div>
                <div class="selectKuang">
                    <?php echo $searchAdId; ?>
                    <?php echo select("FollowType","selectShort","-客户性质-",array("公客","私客"),$_SESSION['adClient']['FollowType']);?>
                    <div>
                        <span class="title">区域</span>
                        <?php echo RepeatSelect("region","province","province","selectShort index","--省份--",$province);?>
                        <select name="city" class="selectShort">
                            <?php echo RepeatOption("region where province = '$province' ","city","--城市--",$city);?>
                        </select>
                        <select name="area" class="selectShort">
                            <?php echo IdOption("region where province = '$province' and city = '$city' ","id","area","--区域--",$area);?>
                        </select>
                    </div>
                </div>
                <div>
                    创建日:
                    <?php
                    echo year("year1","selectShort index","new",$_SESSION['adClient']['startTime']).
                        moon("moon1","selectShort",$_SESSION['adClient']['startTime']).
                        day("day1","selectShort",$_SESSION['adClient']['startTime'])."--".
                        year("year2","selectShort index","new",$_SESSION['adClient']['endTime']).
                        moon("moon2","selectShort",$_SESSION['adClient']['endTime']).
                        day("day2","selectShort",$_SESSION['adClient']['endTime']);
                    ?>
                </div>
                <div>
                    查询时间段:
                    <?php
                    echo year("year3","selectShort index","new",$_SESSION['adClient']['startTime1']).
                        moon("moon3","selectShort",$_SESSION['adClient']['startTime1']).
                        day("day3","selectShort",$_SESSION['adClient']['startTime1'])."--".
                        year("year4","selectShort index","new",$_SESSION['adClient']['endTime1']).
                        moon("moon4","selectShort",$_SESSION['adClient']['endTime1']).
                        day("day4","selectShort",$_SESSION['adClient']['endTime1']);
                    ?>
                    <input type="submit" value="模糊查询">
                </div>
            </form>
        </div>
        <div class="search">
		<span class="smallWord">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
            <span class="spanButton FloatRight" onclick="EditList('ClientForm','ClientDelete')">删除客户</span>
            <span class='spanButton FloatRight' client="exportClient" onclick="pwsFloor($(this));">客户导出</span>
            <span class="spanButton FloatRight" onclick="$('#adClientCsv').fadeIn()">批量导入</span>
            <a href="<?php echo root."control/adClientFollow.php";?>"><span class="spanButton FloatRight">跟进记录</span></a>
            <a href="<?php echo root."control/adClientMx.php";?>"><span class="spanButton FloatRight">新建客户</span></a>
            <?php echo $allotClient;?>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="ClientForm">
            <table class="tableMany">
                <tr>
                    <td></td>
                    <td>客户类型</td>
                    <td>联系人姓名</td>
                    <td>联系人手机</td>
                    <td>简要说明</td>
                    <td>创建时间</td>
                    <td width="45px"></td>
                </tr>
                <?php
                if($num == 0){
                    echo "<tr><td colspan='18'>一条信息都没有</td></tr>";
                }else{
                    $query = mysql_query($sql);
                    while($kehu = mysql_fetch_array($query)){
                        $admin = query("admin","adid = '$kehu[adid]' ");
                        $kehuIndustry = query("kehuIndustry"," id = '$kehu[industry]' ");
                        $buycar = mysql_fetch_assoc(mysql_query(" select * from buycar where khid = '$kehu[khid]' order by time desc "));
                        if($buycar['pay'] >0){
                            $payStatus = "已回款";
                        }else{
                            $payStatus = "未回款";
                        }
                        if($buycar['invoice'] >0){
                            $invoiceStatus = "已开票";
                        }else{
                            $invoiceStatus = "未开票";
                        }
                        echo "
				<tr>
					<td><input name='ClientList[]' type='checkbox' value='{$kehu['khid']}'/></td>
					<td>{$kehu['type']}</td>
					<td>{$kehu['contactName']}</td>
					<td>{$kehu['contactTel']}</td>
					<td>{$kehu['text']}</td>
					<td>{$kehu['time']}</td>
					<td><a href='{$root}control/adClientMx.php?id={$kehu['khid']}'><span class='spanButton'>详情</span></a></td>
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
    <!--Excel客户批量导入开始-->
    <div class="hide" id="adClientCsv">
        <div class="dibian"></div>
        <div class="win" style="width: 500px; height: 295px; margin: -128px 0px 0px -250px;">
            <p class="winTitle">客户批量导入（CSV格式）<span onclick="$('#adClientCsv').hide()" class="winClose">×</span></p>
            <form name="ExcelForm" action="<?php echo root."control/ku/adpost.php?type=ClientCsv";?>" method="post" enctype="multipart/form-data">
                <table class="TableRight">
                    <tr>
                        <td style="width:100px;">提示信息：</td>
                        <td>您可以通过这里批量导入客户数据，Excel中以行为单位作为一条客户信息，按字段顺序（公司名称、行业名称、联系人姓名、联系人手机、联系人备用手机号码、联系人座机号码、社会统一信用代码、客户经理、跟进时间、所属区域、客户地址、标牌制作）新增客户。（另存为CSV格式导入）</td>
                    </tr>
                    <tr>
                        <td>选择：</td>
                        <td><input name="ExcelClient" type="file"></td>
                    </tr>
                    <tr>
                        <td>登录密码：</td>
                        <td><input name="Password" type="password" class="text short"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="button" value="确认提交">
                            <a href="<?php echo root.'control/ku/adClientExcelIn.php?Excel=client';?>">
                                <span class='spanButton'>导入模板</span>
                            </a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!--Excel客户批量导入结束-->
    <!--客户分配开始-->
    <div class="hide" id="allotClient">
        <div class="dibian"></div>
        <div class="win" style="width: 500px; height: 256px; margin: -128px 0px 0px -250px;">
            <p class="winTitle">客户分配<span onclick="$('#allotClient').hide()" class="winClose">×</span></p>
            <form name="allotClientForm">
                <table class="TableRight">
                    <tr>
                        <td style="width:100px;">提示信息：</td>
                        <td>市场部主管可以将选定的客户批量分配给制定的市场部经理，一旦分配成功，对方将立即看到所属客户的基本信息，你确定要这样做吗？</td>
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
    <!-- 超级管理员导出密码检测开始-->
    <div class='hide' id='exportClient'>
        <div class='dibian'></div>
        <div class='win' style='width:300px; height:123px; margin:-80px 0 0 -150px;'>
            <p class='winTitle'><span class="smallWord">导出合同</span><span class='winClose' onclick="$('#exportClient').hide()">×</span></p>
            <div exportClient>
                <table class="TableRight">
                    <tr>
                        <td>登录密码：</td>
                        <td><input name="password" type="password" class="text TextPrice"  exportClientPswd></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="button" value="确认提交" exportClientButton></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <!--超级管理员导出密码检测开始-->
    <script>
        $(function(){
            //模糊查询--所在区域
            region("Search","province","city","area");
            $("[exportClientButton]").click(function(){
                console.log(attribute);
                $.post(root+"control/ku/addata.php?type=exportClient&Client="+attribute,{password:$("[exportClientPswd]").val()},function(data){
                    if(data.warn == 2){
                        location.href=root+"control/ku/adClientExcelIn.php?Excel="+data.herf;
                    }else{
                        warn(data.warn);
                    }
                },"json");
            })
        })
        //密码登录函数并获取相对应的属性值
        function  pwsFloor(obj){
            $('#exportClient').fadeIn();
            attribute = obj.attr("client");
        }
    </script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>