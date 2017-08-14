<?php
/*
本函数库存放电脑端和手机端的公共函数
*/
include dirname(dirname(__FILE__))."/control/ku/configure.php";
//我的投诉分页
function share($page){
    $kehu = $GLOBALS['kehu'];
    $root = $GLOBALS['root'];
    $complain = '';
    $sql = mysql_query("select * from complain where khid = '$kehu[khid]' order by time desc limit ".(($page-1)*10).",10");
    if(mysql_num_rows($sql) == 0){
        $complain = "<tr><td>一条投诉记录都没有</td></tr>";
    }else{
        while($array = mysql_fetch_assoc($sql)){
            if (empty($array['feedbackText'])) {
                $array['feedbackText'] = '未反馈';
            }
            $complain .= "
            <tr class='trList'>
                <td width='290' align='left'>
                    <p class='order-name'>{$array['complainText']}</p>
                </td>
                <td width='84'>{$array['feedbackText']}</td>
                <td width='180'>{$array['time']}</td>
                <td width='180' align='center'>
                    <a data_del_id2='{$array['id']}'>删除</a>
                </td>
            </tr>
            ";
        }
    }
    $html = "<tr>
                <th width='290'>投诉说明</th>
                <th width='180'>反馈</th>
                <th width='180'>投诉时间</th>
                <th width='84'>操作</th>
            </tr>{$complain}";
    $json['html'] = $html;
    return $json;
}
//我的预约分页
function share2($page){
    $kehu = $GLOBALS['kehu'];
    $root = $GLOBALS['root'];
    $bespeak = '';
    $sql = mysql_query("select * from bespeak where khid = '$kehu[khid]' order by time desc limit ".(($page-1)*10).",10");
    if(mysql_num_rows($sql) == 0){
        $bespeak = "<tr><td>一条预约记录都没有</td></tr>";
    }else{
        while($array = mysql_fetch_assoc($sql)){
            $system = query("system", "id = '$array[type]' ");
            if (empty($array['feedbackText'])) {
                $array['feedbackText'] = '未设置';
            }
            $bespeak .= "
            <tr class='trList'>
                <td width='180' align='left'>
                    <p class='order-name'>{$system['name']}</p>
                </td>
                <td width='120'>{$array['bespeakText']}</td>
                <td width='84'>{$array['bespeakTime']}</td>
                <td width='100'>{$array['contactName']}</td>
                <td width='120'>{$array['contactTel']}</td>
                <td width='180'>{$array['remark']}</td>
                <td width='180'>
                    <!--<a class='td-color-two' href='{$root}user/feedback.php?bespeakId={$array['id']}'>反馈</a>-->
                    {$array['feedbackText']}
                </td>
                <td width='84' align='center'>
                    <a data_del_id='{$array['id']}'>删除</a>
                </td>
            </tr>
            ";
        }
    }
    $html = "<tr>
                <th width='120'>设备类型</th>
                <th width='180'>故障现象描述</th>
                <th width='84'>预约维护时间</th>
                <th width='100'>联系人</th>
                <th width='120'>联系电话</th>
                <th width='180'>备注</th>
                <th width='180'>反馈</th>
                <th width='84'>操作</th>
            </tr>{$bespeak}";
    $json['html2'] = $html;
    return $json;
}
//我的维修记录分页
function share3($page){
    $kehu = $GLOBALS['kehu'];
    $root = $GLOBALS['root'];
    $service = '';
    $sql = mysql_query("select * from service where khid = '$kehu[khid]' order by time desc limit ".(($page-1)*10).",10");
    if(mysql_num_rows($sql) == 0){
        $service = "<tr><td>一条维修记录都没有</td></tr>";
    }else{
        while($array = mysql_fetch_assoc($sql)){
            $service .= "
            <tr class='trList'>
                <td width='290' align='left'>
                    <p class='order-name'>{$array['serviceText']}</p>
                </td>
                <td width='84'>{$array['identifyId']}</td>
                <td width='180'>{$array['manner']}</td>
                <td width='180'>{$array['serviceName']}</td>
                <td width='180'>{$array['time']}</td>
                <td width='180'>{$array['status']}</td>
                <td width='180' align='center'>
                    <a data_del_id3='{$array['id']}'>删除</a>
                </td>
            </tr>
            ";
        }
    }
    $html = "<tr>
                <th width='290'>维修说明</th>
                <th width='84'>设备查询ID</th>
                <th width='180'>选择方式</th>
                <th width='180'>维修人</th>
                <th width='180'>完成时间</th>
                <th width='180'>状态</th>
                <th width='84'>操作</th>
            </tr>{$service}";
    $json['html3'] = $html;
    return $json;
}