<?php
include "ku/adfunction.php";
ControlRoot("建议反馈");
$feedback = query("talk"," id = '$_GET[id]' ");
if(empty($feedback['id']) and $feedback['id'] != $_GET['id']){
    $_SESSION['warn'] = "未找到这个留言的信息";
    header("location:{$adroot}adFeedback.php");
    exit(0);
}
//查询客户信息
$client = query("kehu", "khid = '$feedback[khid]' ");
//循环留言
$talkSql = mysql_query("SELECT * FROM talk WHERE khid = '$feedback[khid]' ORDER BY time DESC ");
$talk = "";
if (mysql_num_rows($talkSql) == 0) {
    $talk = "";
}
else {
    while ($array = mysql_fetch_assoc($talkSql)) {
        if ($array['type'] == '留言') {
            $title = "<img src='{$client['wxIco']}' alt=''>";
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
$onion = array(
    "建议反馈" => "{$root}control/adFeedback.php",
    kong($client['wxNickName']) => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column MinHeight">
        <!--基本资料开始-->
        <div class="kuang">
            <form name="feedbackForm">
                <div class="wrap">
                    <ul>
                        <?php echo $talk;?>
                    </ul>
                    <div class="leave-message">
                        <div class="title">
                            <h3>我的反馈</h3>
                        </div>
                        <div class="content">
                            <form name="messageForm" id="messageForm" method="post" enctype="multipart/form-data">
                                <input name="adFeedbackId" type="hidden" value="<?php echo $feedback['id'];?>"></td>
                                <textarea name="feedbackText"  placeholder="可以在这里对客户进行反馈......"></textarea>
                                <input onclick="Sub('feedbackForm','<?php echo root."control/ku/addata.php?type=feedbackForm";?>')" type="button" id="sendMessage" class="sendMessage" value="发送"/>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
<?php echo warn().adfooter();?>