<?php
include "ku/adfunction.php";
ControlRoot("客户投诉");
$ThisUrl = $adroot."adComplain.php";
$sql="select * from complain ".$_SESSION['adComplain']['Sql'];
paging($sql," order by time desc ",100);
$onion = array(
    "客户投诉" => $ThisUrl
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
                联系人姓名：<input name="adComplainContactName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adComplain']['contactName'];?>">
                联系人号码：<input name="adComplainContactTel" type="text" class="text TextPrice" value="<?php echo $_SESSION['adComplain']['contactTel'];?>">
                投诉说明：<input name="adComplainText" type="text" class="text TextPrice" value="<?php echo $_SESSION['adComplain']['complainText'];?>">
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
                    <td>联系人姓名</td>
                    <td>联系人号码</td>
                    <td>投诉说明</td>
                    <td>投诉时间</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($array = mysql_fetch_array($query)){
                        $client = query("kehu", "khid = '$array[khid]' ");
                        echo "
				<tr>
					<!--<td><input name='bespeakList[]' type='checkbox' value='{$bespeak['id']}'/></td>-->
					<td>".kong($client['contactName'])."</td>
					<td>".kong($client['contactTel'])."</td>
					<td>".kong($array['complainText'])."</td>
					<td>{$array['time']}</td>
					<td><a href='{$adroot}adComplainMx.php?id={$array['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
                    }
                }else{
                    echo "<tr><td colspan='5'>一个投诉都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>