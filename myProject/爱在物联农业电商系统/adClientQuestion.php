<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$ThisUrl = root."control/adClient.php";
$sql="SELECT * FROM kehuQuestion ".$_SESSION['adQuestion']['Sql'];
paging($sql," order by time desc",100);
$onion = array(
    "客户管理" => "{$root}control/adClient.php",
    "调查问卷" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minheight">
        <div class="kuang">
            <form name="Search" action="<?php echo "{$adroot}ku/adpost.php?type=adQuestion";?>" method="post">
                调查人昵称：<input name="adWxNickName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adQuestion']['wxNickName'];?>">
                调查题目：<input name="adQuestion" type="text" class="text TextPrice" value="<?php echo $_SESSION['adQuestion']['question'];?>">
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
    <span class="SpanButton">
      共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
      当前显示第<b class="must"><?php echo $page;?></b>页的信息
    </span>
            <span onclick="$('[name=questionForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=questionForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="questionForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>调查人昵称</td>
                    <td>调查题目</td>
                    <td>回答结果</td>
                    <td>创建时间</td>
                </tr>
                <?php
                if($num > 0){
                    while($array = mysql_fetch_array($query)){
                        $client = query("kehu", "khid = '$array[khid]' ");
                        $content = query("content", "id = '$array[contentId]' ");
                         echo "
                        <tr>
                          <td><input name='ClientList[]' type='checkbox' value='{$array['id']}'/></td>
                          <td>".kong($client['wxNickName'])."</td>
                          <td>".kong($content['question'])."</td>
                          <td>".kong($array['answer'])."</td>
                          <td>{$array['time']}</td>
                        </tr>
                    ";
                    }
                }else{
                    echo "<tr><td colspan='5'>一条信息都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo warn().adfooter();?>