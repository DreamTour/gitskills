<?php
include "ku/adfunction.php";
ControlRoot("adStatistics");
header("Content-Type: text/html; charset=UTF-8");
//判断客户id是否存在
$id = FormSub($_GET['id']);
if(empty($id)){
    if($adDuty['edit'] != '是'){
        $_SESSION['warn'] = "您没有新建客户的权限";
        header("location:{$root}control/adClient.php");
        exit(0);
    }
    $title = "新建计划";
    $button = "新建";
}else{
    //根据传过来的id号查询客户
    $statistics = query("statistics"," id = '$id' ");
    //如果未找到
    if(empty($statistics['id'])){
        $_SESSION['warn'] = "未找到这个计划的信息";
        header("location:{$root}control/adStatistics.php");
        exit(0);
    }
    //其他参数
    $title = $statistics['planName'];
    $button = "更新";
    $floowDivDisplay = "";
    $other = "
	<tr>
		<td>更新时间：</td>
		<td>{$statistics['updateTime']}</td>
	</tr>
	<tr>
		<td>创建时间：</td>
		<td>{$statistics['time']}</td>
	</tr>
	";
}
//判断员工是否有此客户的编辑权：当本职位有客户编辑权时，新建客户或为本员工的私客，则有编辑权限。
if (
    /*$adDuty['edit'] == '是' and
    (empty($id) or $kehu['adid'] == $Control['adid'])*/
    true
){
    $backstageSql = mysql_query("SELECT * FROM backstage");
    $i=0;
    while($array = mysql_fetch_assoc($backstageSql)) {
        if ($i == 0) {
            $backstageName .= $array['name'];
        } else {
            $backstageName .= '，'.$array['name'];
        }
        $i++;
    }
    $Region = query("region", "id = '$kehu[intentionArea]' ");
    $planName = "<input name='planName' type='text' class='text' value='{$statistics['planName']}'>";
    $planDate = "<input style='width: 187px' name='planDateStart' class='datainp text' id='planDateStart' type='text' placeholder='请选择' value='{$statistics['planDateStart']}'  readonly> - <input style='width: 187px' name='planDateEnd' class='datainp text' id='planDateEnd' type='text' placeholder='请选择' value='{$statistics['planDateEnd']}'  readonly>";
    $backstage = checkbox("backstage",explode("，",$backstageName),delquod(explode(",",$statistics['backstage'])))." <span class='spanButton' id='backstage'>全选</span>";
    $telegram = checkbox("telegram",explode("，",website("tgl73981646Da")),delquod(explode(",",$statistics['telegram'])))." <span class='spanButton' id='telegram'>全选</span>";
    $chat = checkbox("chat",explode("，",website("mkM74025300Co")),delquod(explode(",",$statistics['chat'])))." <span class='spanButton' id='chat'>全选</span>";
    $bridge = checkbox("bridge",explode("，",website("OnI74025361gq")),delquod(explode(",",$statistics['bridge'])))." <span class='spanButton' id='bridge'>全选</span>";
    $website = checkbox("website",explode("，",website("TVG74025425OH")),delquod(explode(",",$statistics['website'])))." <span class='spanButton' id='website'>全选</span>";
    $area = checkbox("area",explode("，",website("lpz74025452eD")),delquod(explode(",",$statistics['area'])))." <span class='spanButton' id='area'>全选</span>";
    $telegramDan = "<input name='telegramDan' type='text' class='text' value='{$statistics['telegramDan']}'> <span class='spanButton' id='telegramDan'>全选</span>";
    $clientLevel = checkbox("clientLevel",explode("，",website("iJS74478090Ws")),delquod(explode(",",$statistics['clientLevel'])))." <span class='spanButton' id='clientLevel'>全选</span>";
    $intention = checkbox("intention",explode("，",website("SGi74478318uF")),delquod(explode(",",$statistics['intention'])))." <span class='spanButton' id='intention'>全选</span>";
    $clientType = checkbox("clientType",explode("，",website("XJS74478380Vt")),delquod(explode(",",$statistics['clientType'])))." <span class='spanButton' id='clientType'>全选</span>";
    $remark = "<textarea  name='remark' class='textarea'>{$statistics['remark']}</textarea>";
    $IsButton = "
	<tr>
		<td><input name='adStatisticsId' type='hidden' value='{$statistics['id']}'></td>
		<td><input onclick=\"Sub('clientForm',root+'control/ku/addata.php?type=statistics')\" type='button' class='button' value='{$button}'></td>
	</tr>
";
}else{
    $planName = kong($statistics['planName']);
    $telegram = kong($statistics['telegram']);
}
$onion = array(
    "数据统计" => root."control/adStatistics.php",
    $title => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minHeight">
        <!--基本资料开始-->
        <div class="kuang">
            <p>
                <img src="<?php echo root."img/images/text.png";?>">
                计划基本资料
            </p>
            <form name="clientForm">
                <table class="tableRight">
                    <tr>
                        <td style="width:200px;">计划id号：</td>
                        <td> <?php echo kong($statistics['id']);?> </td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span>&nbsp;计划名称：</td>
                        <td><?php echo $planName;?></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span>&nbsp;日期：</td>
                        <td><?php echo $planDate;?></td>
                    </tr>
                    <tr>
                        <td>推广后台：</td>
                        <td><?php echo $backstage;?></td>
                    </tr>
                    <tr>
                        <td>来电：</td>
                        <td><?php echo $telegram;?></td>
                    </tr>
                    <tr>
                        <td>商桥聊天：</td>
                        <td><?php echo $chat;?></td>
                    </tr>
                    <tr>
                        <td>商桥留言：</td>
                        <td><?php echo $bridge;?></td>
                    </tr>
                    <tr>
                        <td>网站留言：</td>
                        <td><?php echo $website;?></td>
                    </tr>
                    <tr>
                        <td>来电区域：</td>
                        <td><?php echo $area;?></td>
                    </tr>
                    <!--<tr>
                        <td>来电时间段：</td>
                        <td><?php /*echo $telegramDan;*/?></td>
                    </tr>-->
                    <tr>
                        <td>客户级别：</td>
                        <td><?php echo $clientLevel;?></td>
                    </tr>
                    <tr>
                        <td>意向区域：</td>
                        <td><?php echo $intention;?></td>
                    </tr>
                    <tr>
                        <td>客户类型：</td>
                        <td><?php echo $clientType;?></td>
                    </tr>
                    <tr>
                        <td>备注：</td>
                        <td><?php echo $remark;?></td>
                    </tr>
                    <?php echo $other,$IsButton;?>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
    <script type="text/javascript" src="<?php echo $root;?>jeDate/jedate.js"></script>
    <script>
        window.onload = function() {
            //调用全选
            checkAll('backstage', 'backstage');
            checkAll('telegram', 'telegram');
            checkAll('chat', 'chat');
            checkAll('bridge', 'bridge');
            checkAll('website', 'website');
            checkAll('area', 'area');
            checkAll('clientLevel', 'clientLevel');
            checkAll('intention', 'intention');
            checkAll('clientType', 'clientType');

            //日期开始
            jeDate({
                dateCell:"#planDateStart",
                format:"YYYY-MM-DD hh",
                isinitVal:true,
                isTime:true, //isClear:false,
                minDate:"2014-09-19 00:00:00",
                choosefun:function(val){
                    var planDateStart = document.getElementById('planDateStart');
                    planDateStart.value = val;
                    planDateStart.setAttribute('value', val);
                },
                okfun:function(val){
                    var planDateStart = document.getElementById('planDateStart');
                    planDateStart.value = val;
                    planDateStart.setAttribute('value', val);
                },
            })
            //日期结束
            jeDate({
                dateCell:"#planDateEnd",
                format:"YYYY-MM-DD hh",
                isinitVal:true,
                isTime:true, //isClear:false,
                minDate:"2014-09-19 00:00:00",
                choosefun:function(val){
                    var planDateEnd = document.getElementById('planDateEnd');
                    planDateEnd.value = val;
                    planDateEnd.setAttribute('value', val);
                },
                okfun:function(val){
                    var planDateEnd = document.getElementById('planDateEnd');
                    planDateEnd.value = val;
                    planDateEnd.setAttribute('value', val);
                },
            })
        }

        function ajax(){
            var ajaxData = {
                type:arguments[0].type || "GET",
                url:arguments[0].url || "",
                async:arguments[0].async || "true",
                data:arguments[0].data || null,
                dataType:arguments[0].dataType || "text",
                contentType:arguments[0].contentType || "application/x-www-form-urlencoded",
                beforeSend:arguments[0].beforeSend || function(){},
                success:arguments[0].success || function(){},
                error:arguments[0].error || function(){}
            }
            ajaxData.beforeSend()
            var xhr = createxmlHttpRequest();
            xhr.responseType=ajaxData.dataType;
            xhr.open(ajaxData.type,ajaxData.url,ajaxData.async);
            xhr.setRequestHeader("Content-Type",ajaxData.contentType);
            xhr.send(convertData(ajaxData.data));
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if(xhr.status == 200){
                        ajaxData.success(xhr.response)
                    }else{
                        ajaxData.error()
                    }
                }
            }
        }

        function createxmlHttpRequest() {
            if (window.ActiveXObject) {
                return new ActiveXObject("Microsoft.XMLHTTP");
            } else if (window.XMLHttpRequest) {
                return new XMLHttpRequest();
            }
        }

        function convertData(data){
            if( typeof data === 'object' ){
                var convertResult = "" ;
                for(var c in data){
                    convertResult+= c + "=" + data[c] + "&";
                }
                convertResult=convertResult.substring(0,convertResult.length-1)
                return convertResult;
            }else{
                return data;
            }
        }

        /**
         * 全选
         * @author he hui
         * @param btn 按钮
         * @param name 名字
         */
        function checkAll(btn, name) {
            var btn = document.getElementById(btn);
            var name = document.getElementsByName(name+'[]');
            var off = true;
            btn.onclick = function() {
                if (off) {
                    for (var i=0;i<name.length;i++) {
                        name[i].checked = true;
                    }
                    off = false;
                } else {
                    for (var i=0;i<name.length;i++) {
                        name[i].checked = false;
                    }
                    off = true;
                }

            }
        }
    </script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>