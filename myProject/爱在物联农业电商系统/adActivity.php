<?php
include "ku/adfunction.php";
ControlRoot("活动报名");
$ThisUrl = $adroot."adEnroll.php";
$sql = "select * from enroll ".$_SESSION['adEnroll']['Sql'];
paging($sql," order by time desc",100);
echo head("ad").adheader();
?>
    <div class="column minheight">
        <!--查询开始-->
        <div class="kuang">
            <form name="Search" action="<?php echo "{$adroot}ku/adpost.php?type=adEnroll";?>" method="post">
                客户昵称：<input name="adWxNickName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adEnroll']['wxNickName'];?>">
                活动：<input name="adEnrollTitle" type="text" class="text TextPrice" value="<?php echo $_SESSION['adEnroll']['enrollTitle'];?>">
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
            <span class="SpanButton">
                共找到<b class="must"><?php echo $num;?></b>条信息
                当前显示第<b class="must"><?php echo $page;?></b>页的信息
            <span onclick="EditList('enrollForm','enrollDelete')" class="SpanButton FloatRight">删除所选</span>
            <span onclick="$('[name=enrollForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=enrollForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="enrollForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>客户昵称</td>
                    <td>活动</td>
                    <td>创建时间</td>
                </tr>
                <?php
                if($num > 0){
                    while($array = mysql_fetch_array($query)){
                        $client = query("kehu","khid = '$array[khid]'");
                        $content = query("content","id = '$array[contentId]'");
                        echo "
				<tr>
					<td><input name='enrollList[]' type='checkbox' value='{$array['id']}'/></td>
					<td>{$client['wxNickName']}</td>
					<td>{$content['title']}</td>
					<td>{$array['time']}</td>
				</tr>
				";
                    }
                }else{
                    echo "<tr><td colspan='4'>一条信息都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo PasWarn("{$adroot}ku/addata.php?type=enrollDelete").warn().adfooter();?>