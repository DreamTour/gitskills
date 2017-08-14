<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
//权限判断
if ($adDuty['name'] == "超级管理员") {
    $where = "";
    //专属于超级管理员的操作按钮
    $operate = "
		<span class='SpanButton FloatRight' id='allotInter'>分配内勤</span>
		<span class='SpanButton FloatRight' id='allotOut'>分配外勤</span>
        <span class=\"SpanButton FloatRight\"><a href='{$root}control/adClientMx.php'>新增客户</a></span>
        <span onclick=\"EditList('ClientForm','ClientDelete')\" class=\"SpanButton FloatRight\">删除所选</span>
        <span onclick=\"$('[name=ClientForm] [type=checkbox]').prop('checked',false);\" class=\"SpanButton FloatRight\">取消选择</span>
        <span onclick=\"$('[name=ClientForm] [type=checkbox]').prop('checked',true);\" class=\"SpanButton FloatRight\">选择全部</span>
	";
}else {
    $where = " and adid = '$Control[adid]' ";
}
//内勤和外勤

$ThisUrl = $adroot."adClient.php";
$sql="select * from kehu WHERE 1=1".$where.$_SESSION['adClient']['Sql'];
paging($sql," order by time desc ",100);
$onion = array(
    "客户管理" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <style>
        .adimgList{ height:38px;}
        .TableMany td{height:38px;}
        .adimgList:hover{ position:absolute; left:-20px; top:-20px; height:200px; z-index:100;}
    </style>
    <div class="column minheight">
        <div class="kuang">
            <form name="Search" action="<?php echo "{$root}control/ku/adpost.php";?>" method="post">
                登录帐号：<input name="adClientAccountNumber" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['accountNumber'];?>">
                公司名称：<input name="adClientCompanyName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['companyName'];?>">
                联系人姓名：<input name="adClientContactName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['ContactName'];?>">
                联系人手机号码：<input name="adClientContactTel" type="text" class="text TextPrice" value="<?php echo $_SESSION['adClient']['ContactTel'];?>">
                <input type="submit" value="模糊查询">
                <a href="<?php echo "{$adroot}ku/adpost.php?type=deleteSearch&searchName=adClient";?>"><span class="SpanButton">返回列表</span></a>
            </form>
        </div>
        <div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
            <?php echo $operate;?>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="ClientForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>登录帐号</td>
                    <td>公司名称</td>
                    <td>详细地址</td>
                    <td>联系人姓名</td>
                    <td>联系人手机号码</td>
                    <td>外勤</td>
                    <td>内勤</td>
                    <td>创建时间</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($array = mysql_fetch_array($query)){
                        //查询分配客户服务预约有没有反馈
                        $bespeakNum = mysql_num_rows(mysql_query("select * from bespeak where khid = '$array[khid]' and isFeedback = '否' "));
						if ($bespeakNum > 0) {
							$mark = "<i class='mark-icon'>&#xe660;</i>";
						}else {
							$mark = "";
						}
						$Region = query("region", "id = '$array[RegionId]' ");
                        $age = date("Y") - substr($array['Birthday'],0,4);
                        $adminOut = query("admin", "adid = '$array[adidOut]' ");//外勤
                        $adminInter = query("admin", "adid = '$array[adidInter]' ");//内勤
                        echo "
				<tr>
					<td><input name='ClientList[]' type='checkbox' value='{$array['khid']}'/></td>
					<td>".kong($array['accountNumber'])."</td>
					<td>".kong($array['companyName']).$img."</td>
					<td>".kong($array['addressMx'])."</td>
					<td>".kong($array['contactName'])." {$mark}</td>
					<td>".kong($array['contactTel'])."</td>
					<td>".kong($adminOut['adname'])."</td>
					<td>".kong($adminInter['adname'])."</td>
					<td>{$array['time']}</td>
					<td><a href='{$adroot}adClientMx.php?id={$array['khid']}'><span class='SpanButton'>详情</span></a></td>
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
    <!--分配内勤弹出层-->
    <div class='hide' id='allotInterShade'>
        <div class='dibian'></div>
        <div class='win' style='width:500px; height:230px; margin:-115px 0 0 -250px;'>
            <p class='winTitle'>分配内勤<span class='winClose' onclick="$('#allotInterShade').hide()">×</span></p>
            <form name='clientInterShadeForm'>
                <table class='TableRight'>
                    <tr>
                        <td style='width:100px;'>分配信息：</td>
                        <td>将选中的客户分配给内勤</td>
                    </tr>
                    <tr>
                        <td>内勤：</td>
                        <td>
                            <?php echo IDSelect("admin","taskAllotInter","select","adid","adname","--分配--","");?>
                        </td>
                    </tr>
                    <tr>
                        <td>执行方向：</td>
                        <td><?php echo radio("direction", array("分配", "撤销分配"), "");?></td>
                    </tr>
                    <tr>
                        <td>登录密码：</td>
                        <td><input name="taskPassword" type="password" class="text short"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" class="button" value="确认提交" onclick="Sub('ClientForm,clientInterShadeForm','<?php echo "{$root}control/ku/addata.php?type=clientInterShadeForm";?>')"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!--分配弹出层-->
    <!--分配外勤弹出层-->
    <div class='hide' id='allotOutShade'>
        <div class='dibian'></div>
        <div class='win' style='width:500px; height:230px; margin:-115px 0 0 -250px;'>
            <p class='winTitle'>分配外勤<span class='winClose' onclick="$('#allotOutShade').hide()">×</span></p>
            <form name='clientOutShadeForm'>
                <table class='TableRight'>
                    <tr>
                        <td style='width:100px;'>分配信息：</td>
                        <td>将选中的客户分配给外勤</td>
                    </tr>
                    <tr>
                        <td>外勤：</td>
                        <td>
                            <?php echo IDSelect("admin","taskAllotOut","select","adid","adname","--分配--","");?>
                        </td>
                    </tr>
                    <tr>
                        <td>执行方向：</td>
                        <td><?php echo radio("direction", array("分配", "撤销分配"), "");?></td>
                    </tr>
                    <tr>
                        <td>登录密码：</td>
                        <td><input name="taskPassword" type="password" class="text short"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" class="button" value="确认提交" onclick="Sub('ClientForm,clientOutShadeForm','<?php echo "{$root}control/ku/addata.php?type=clientOutShadeForm";?>')"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!--分配弹出层-->
    <script>
        window.onload = function() {
            document.getElementById('allotInter').onclick = function() {
                $('#allotInterShade').fadeIn();
            }
            document.getElementById('allotOut').onclick = function() {
                $('#allotOutShade').fadeIn();
            }
        }
    </script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>