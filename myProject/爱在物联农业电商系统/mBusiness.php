<?php
include "../library/mFunction.php";
//循环留言
$talkSql = mysql_query("SELECT * FROM talk WHERE khid = '$kehu[khid]' ORDER BY time DESC ");
$talk = "";
if (mysql_num_rows($talkSql) == 0) {
    $talk = "";
}
else {
    while ($array = mysql_fetch_assoc($talkSql)) {
        if ($array['type'] == '留言') {
            $title = "<img src='{$kehu['wxIco']}' alt=''>";
            $talk .= "
                     <li class='client-li'>
                        <strong>{$title}</strong>
                        <span>{$array['text']}</span>
                    </li>
                ";
        }
        else {
            $title = '管理员';
            $talk .= "
                 <li class='control-li'>
                    <strong>{$title}</strong>
                    <span>{$array['text']}</span>
                </li>
            ";
        }

    }
}
echo head("m");
?>
<!-------头部---------->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root;?>m/mindex.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">在线帮助</p>
        </div>
        <a href="#" class="header-btn"></a>
    </div>
</div>
<!--改善建议-->
<div class="wrap">
    <ul>
        <?php echo $talk;?>
    </ul>
    <div class="leave-message">
        <div class="title">
            <h3>我的留言</h3>
        </div>
        <div class="content">
            <form name="messageForm" id="messageForm" method="post" enctype="multipart/form-data">
                <textarea name="message"  placeholder="如果你有好的建议或者需要帮助,欢迎留言......"></textarea>
                <input type="button" id="sendMessage" class="sendMessage" value="发送"/>
            </form>
        </div>
    </div>
</div>


<!----------底部---------->
<?php echo  mWarn(); ?>
<!--//-->
<script>
    $(function(){
        changeNav();
    })

    window.onload = function() {
        //反馈
        $("#sendMessage").click(function() {
            $.post(root+'library/mData.php?type=message',$("[name='messageForm']").serialize(), function(data) {
                if(data.warn == 2){
                    window.location.reload();
                    mwarn("留言成功");
                }else{
                    mwarn(data.warn);
                }
            },'json');
        });
    }
</script>
</body>
</html>