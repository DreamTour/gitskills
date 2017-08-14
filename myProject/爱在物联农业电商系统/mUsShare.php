<?php
include "../../library/mFunction.php";
if ($get['type'] == 'vip') {
    $clientSql = mysql_query("SELECT * FROM kehu WHERE shareId = '$kehu[khid]' AND type = 'vip会员' ");
}
else {
    $clientSql = mysql_query("SELECT * FROM kehu WHERE shareId = '$kehu[khid]' AND type = '' ");
}
$recommend = '';
if (mysql_num_rows($clientSql) == 0) {
    $recommend = '一个客户都没有';
}
else {
    $x= mysql_num_rows($clientSql);
    while ($array = mysql_fetch_assoc($clientSql)) {
        if (empty($array['type'])) {
            $array['type'] = '普通会员';
        }
        $recommend .= "
                <li class='clearfix' data-neighbor='jMC68522664KU'>
                    <div class='ranking-count fl'>{$x}</div>
                    <div class='ranking-message fl clearfix'>
                        <div class='message-pic fl'>
                            <img src='{$array['wxIco']}' alt='头像' data-kehu='jMC68522664KU'>
                        </div>
                        <div class='message-text fl'>
                            <strong>{$array['wxNickName']}</strong>
                            <span>{$array['type']}</span>
                        </div>
                    </div>
                </li>
            ";
        $x--;
    }
}
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root;?>m/mUser/mUser.php" class="header-btn header-return"><span class="return-ico"></span></a>
        <div class="align-content">
            <p class="align-text">我的推荐</p>
        </div>
        <a href="#" class="header-btn"></a>
    </div>
</div>
<!-- 推荐列表 -->
<div class="recommend" id="recommend">
    <ul>
        <?php echo $recommend;?>
    </ul>
</div>
<?php echo mWarn();?>

