<?php
include "ku/adfunction.php";
ControlRoot("建议反馈");
$ThisUrl = $adroot."adFeedback.php";
$sql="select * from talk WHERE type = '留言' ".$_SESSION['adTalk']['Sql'];
paging($sql," order by time desc ",100);
$onion = array(
    "建议反馈" => $ThisUrl
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
            <form name="Search" action="<?php echo "{$adroot}ku/adpost.php?type=adFeedback";?>" method="post">
                昵称：<input name="adWxNickName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adTalk']['wxNickName'];?>">
                留言：<input name="adFeedback" type="text" class="text TextPrice" value="<?php echo $_SESSION['adTalk']['text'];?>">
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
            <span onclick="EditList('talkForm','talkDelete')" class="SpanButton FloatRight">删除所选</span>
            <span onclick="$('[name=talkForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=talkForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="talkForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>昵称</td>
                    <td>留言</td>
                    <td>留言时间</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($array = mysql_fetch_array($query)){
                        $client = query("kehu", "khid = '$array[khid]' ");
                        echo "
				<tr>
					<td><input name='talkList[]' type='checkbox' value='{$array['id']}'/></td>
					<td>".kong($client['wxNickName'])."</td>
					<td>".kong($array['text'])."</td>
					<td>{$array['time']}</td>
					<td><a href='{$adroot}adFeedbackMx.php?id={$array['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
                    }
                }else{
                    echo "<tr><td colspan='6'>一条留言都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php?type=talkDelete").warn().adfooter();?>