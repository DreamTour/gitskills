<?php
include "ku/adfunction.php";
ControlRoot("客户预约");
$ThisUrl = $adroot."adBespeak.php";
$sql="select * from bespeak ".$_SESSION['adBespeak']['Sql'];
paging($sql," order by time desc ",100);
$onion = array(
    "客户预约" => $ThisUrl
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
            <form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
                系统类别：<?php echo IDSelect("system","adType","select","name","name","--系统类别--",$_SESSION['adBespeak']['type']);?>
                故障现象描述：<input name="adBespeakText" type="text" class="text TextPrice" value="<?php echo $_SESSION['adBespeak']['bespeakText'];?>">
                联系人：<input name="adContactName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adBespeak']['contactName'];?>">
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
            <!--<span onclick="EditList('bespeakForm','bespeakDelete')" class="SpanButton FloatRight">删除所选</span>
            <span onclick="$('[name=bespeakForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=bespeakForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>-->
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="bespeakForm">
            <table class="TableMany">
                <tr>
                    <!--<td></td>-->
                    <td>系统类别</td>
                    <td>故障现象描述</td>
                    <td>预约维护时间</td>
                    <td>联系人</td>
                    <td>联系电话</td>
                    <td>备注</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($array = mysql_fetch_array($query)){
                        $system = query("system", "id = '$array[type]' ");
                        $mark = "";
                        if($array['isFeedback'] == '否') {
                            $mark = " <i class='mark-icon'>&#xe660;</i>";
                        }
                        echo "
				<tr>
					<!--<td><input name='bespeakList[]' type='checkbox' value='{$array['id']}'/></td>-->
					<td>".kong($system['name'])."</td>
					<td>".kong($array['bespeakText'])."</td>
					<td>".kong($array['bespeakTime'])."</td>
					<td>".kong($array['contactName'])." {$mark}</td>
					<td>".kong($array['contactTel'])."</td>
					<td>".kong($array['bespeakText'])."</td>
					<td><a href='{$adroot}adBespeakMx.php?id={$array['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
                    }
                }else{
                    echo "<tr><td colspan='8'>一个客户预约都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>