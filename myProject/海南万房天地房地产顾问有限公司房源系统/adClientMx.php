<?php
include "ku/adfunction.php";
ControlRoot("adClient");
//判断客户id是否存在
$id = FormSub($_GET['id']);
if(empty($id)){
    if($adDuty['edit'] != '是'){
        $_SESSION['warn'] = "您没有新建客户的权限";
        header("location:{$root}control/adClient.php");
        exit(0);
    }
    /*$Follow = "<textarea  name='returnVisit' class='textarea'>{$kehu['returnVisit']}</textarea>";*/
    $title = "新建客户";
    $button = "新建";
    //员工客户上限
    $staffClientNum = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE adid = '$Control[adid]' AND type = '私客' "));
    if ($staffClientNum >= $Control['clientNum']) {
        $_SESSION['warn'] = '你的客户已经达到上限了';
        header("location:{$root}control/adClient.php");
        exit(0);
    }
    $red = "<span class='red'>*</span>&nbsp;";
}else{
    $red = "";
    //根据传过来的id号查询客户
    $kehu = query("kehu"," khid = '$id' ");
    //如果未找到
    if(empty($kehu['khid'])){
        $_SESSION['warn'] = "未找到这个客户的信息";
        header("location:{$root}control/adClient.php");
        exit(0);
    }
    //经理设为公司公客
    if ($adDuty['name'] == '经理' && $kehu['type'] != '公司公客') {
        $firmClientBtn = "<a href='javascript:void(0)' onclick='firmClient($kehu[khid])'><span class='spanButton'>设为公司公客</span></a>";
    }
    //客户不是私客，不显示按钮
    if ($kehu['type'] == '私客') {
        $groupClientBtn = "<a href='javascript:void(0)' onclick='groupClient($kehu[khid])'><span class='spanButton'>设为小组公客</span></a>";
        $clinchClientBtn = "<a href='javascript:void(0)' onclick='groupClient($kehu[khid])'><span class='spanButton'>成交待回访</span></a>";
    }

    //历史跟进记录
    $Follow = "";
    $Sql = mysql_query(" select * from kehuFollow where khid = '$id' order by time desc ");
    if(mysql_num_rows($Sql) == 0){
        $Follow = "暂无跟进";
    }else{
        while($array = mysql_fetch_array($Sql)){
            if($adDuty['name'] == "超级管理员"){
                $d = "<a href='{$root}control/ku/adpost.php?DeleteClientFollow={$array['id']}'>删除</a>";
            }else{
                $d = "";
            }
            $Follow .=  "
			<p>
				{$array['text']}
				<span class='FollowTime'>{$array['time']}</span>&nbsp;
				{$d}
			</p>
			";
        }
    }
    //其他参数
    $title = $kehu['contactName'];
    $button = "更新";
    $floowDivDisplay = "";
    $other = "
	<tr>
		<td>更新时间：</td>
		<td>{$kehu['updateTime']}</td>
	</tr>
	<tr>
		<td>注册时间：</td>
		<td>{$kehu['time']}</td>
	</tr>
	";
}
//客户信息
$kehuMsgSql = mysql_query("SELECT * FROM kehuMsg WHERE khid = '$id' ");
$nameShow = '';
$telShow = '';
$wxQqShow = '';
while ($array = mysql_fetch_assoc($kehuMsgSql)) {
    $nameShow .= '，'.$array['name'];
    $telShow .= '，'.$array['tel'];
    $wxQqShow .= '，'.$array['wxQq'];
}
$nameShow = substr($nameShow,3);
$telShow = substr($telShow,3);
$wxQqShow = substr($wxQqShow,3);
//判断员工是否有此客户的编辑权：当本职位有客户编辑权时，新建客户或为本员工的私客，则有编辑权限。
if (
    $adDuty['edit'] == '是' and
    (empty($id) or $kehu['adid'] == $Control['adid'])
){
    $Region = query("region", "id = '$kehu[intentionArea]' ");
    $contactName = "{$nameShow} <input name='contactName' type='text' class='text textPrice' value=''>";
    $contactTel = "{$telShow} <input  name='contactTel' type='text' class='text textPrice' value=''>";
    $wxQq = "{$wxQqShow} <input  name='wxQq' type='text' class='text textPrice' value=''>";
    $intentionArea = select("intentionArea","select textPrice","-意向区域-",array("海口","临高","澄迈","定安","文昌","儋州","屯昌","琼海","昌江","白沙","琼中","万宁","东方","五指山","保亭","陵水","乐东","三亚"),$kehu['intentionArea']);
    $fromArea = "<select name='fromProvince' class='select textPrice'>".RepeatOption("region",'province','--省份--',$kehu['fromArea'])."</select>";
    $clientLevel = select("clientLevel","select textPrice","-客户级别-",array("0分","10分","20分","30分","40分","50分","60分","70分","80分","90分","100分"),$kehu['clientLevel']);
    $clientType = select("clientType","select textPrice","-客户类型-",array("投资","度假","养老","刚需"),$kehu['clientType']);
    $clientIntention = select("clientIntention","select textPrice","-客户意向-",array("放弃","成交"),$kehu['clientIntention']);
    $clientStatus = kong($kehu['clientStatus']);
    $clientSourceOne = select("clientSourceOne","select textPrice","--一级选项--",array("来电","商桥聊天","商桥留言","网站留言"),$kehu['clientSourceOne']);
    $clientSourceTwo = "<select name='clientSourceTwo' class='select textPrice'><option value='{$kehu['clientSourceTwo']}'>{$kehu['clientSourceTwo']}</option></select>";
    $callTime = "<input name='callTime' style='width: 187px' class='datainp text' id='callTime' type='text' placeholder='请选择' value='{$kehu['callTime']}'  readonly>";
    $visitTime = "<input name='visitTime' style='width: 187px' class='datainp text' id='visitTime' type='text' placeholder='请选择' value='{$kehu['visitTime']}'  readonly>";
    $returnVisit = "<textarea  name='returnVisit' class='textarea'></textarea> <label><input name='look' type='checkbox' value='带看' />带看</label>";
    $IsButton = "
	<tr>
		<td><input name='adClientId' type='hidden' value='{$kehu['khid']}'></td>
		<td><input onclick=\"Sub('clientForm',root+'control/ku/addata.php?type=clientEdit')\" type='button' class='button' value='{$button}'></td>
	</tr>
";
}else{
    //经理点击查看才看得到联系方式
    if ($adDuty['name'] == '经理') {
        $contactTel = "<a href='javascript:void(0)' id='contactTel'><span class='spanButton'>点击查看联系方式</span></a>";
    } else {
        $contactTel = kong($kehu['contactTel']);
    }
    $contactName = kong($kehu['contactName']);
    $wxQq = kong($kehu['wxQq']);
    $intentionArea = kong($kehu['intentionArea']);
    $fromArea = kong($kehu['fromArea']);
    $clientLevel = kong($kehu['clientLevel']);
    $clientType = kong($kehu['clientType']);
    $clientIntention = kong($kehu['clientIntention']);
    $clientStatus = kong($kehu['clientStatus']);
    $clientSourceOne = kong($kehu['clientSourceOne']);
    $clientSourceTwo = kong($kehu['clientSourceTwo']);
    $callTime = kong($kehu['callTime']);
    $visitTime = kong($kehu['visitTime']);
    $returnVisit = kong($kehu['returnVisit']);
}
//跟进记录编辑权限
if ($adDuty['name'] == '员工') {
    $addFollow = "
             <tr>
                <td>新增回访：</td>
                <td><textarea name='text' class='textarea'></textarea></td>
            </tr>
            <tr>
                <td><input name='ClientId' type='hidden' value='{$_GET['id']}'></td>
                <td><input type='button' class='button' value='添加' onclick=\"Sub('FollowForm','{$root}control/ku/addata.php?type=clientFollow')\"></td>
            </tr>
        ";
}
$onion = array(
    "客户管理" => root."control/adClient.php",
    $title => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column minHeight">
        <!--基本资料开始-->
        <div class="kuang">
            <p>
                <img src="<?php echo root."img/images/text.png";?>">
                客户基本资料
            </p>
            <form name="clientForm">
                <table class="tableRight">
                    <tr>
                        <td style="width:200px;">客户ID号：</td>
                        <td> <?php echo kong($kehu['khid']).$orderBtn;?> </td>
                    </tr>
                    <tr>
                        <td><?php echo $red;?>姓名：</td>
                        <td><?php echo $contactName;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $red;?>手机：</td>
                        <td><?php echo $contactTel;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $red;?>微信/QQ：</td>
                        <td><?php echo $wxQq;?></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span>&nbsp;意向区域：</td>
                        <td><?php echo $intentionArea;?></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span>&nbsp;来自区域：</td>
                        <td><?php echo $fromArea;?></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span>&nbsp;客户等级：</td>
                        <td><?php echo $clientLevel;?></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span>&nbsp;客户类型：</td>
                        <td><?php echo $clientType;?></td>
                    </tr>
                    <!--<tr>
                        <td>客户意向：</td>
                        <td><?php /*echo $clientIntention;*/?></td>
                    </tr>-->
                    <tr>
                        <td>客户状态：</td>
                        <td id="clientStatus"><?php echo $clientStatus;?></td>
                    </tr>
                    <tr>
                        <td>客户性质：</td>
                        <td>
                            <?php echo kong($kehu['type']);?>
                            <?php /*echo $clinchClientBtn;*/?>
                            <?php echo $groupClientBtn;?>
                            <?php echo $firmClientBtn;?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span>&nbsp;客户来源：</td>
                        <td><?php echo $clientSourceOne.' '.$clientSourceTwo;?></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span>&nbsp;来电时间：</td>
                        <td><?php echo $callTime;?></td>
                    </tr>
                    <tr>
                        <td><span class="red">*</span>&nbsp;回访时间：</td>
                        <td><?php echo $visitTime;?></td>
                    </tr>
                    <tr>
                        <td>回访记录：</td>
                        <td><?php echo $returnVisit;?></td>
                    </tr>
                    <?php echo $other,$IsButton;?>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
        <!--回访记录开始-->
        <div class="column">
            <form name="clinchRecordForm">
                <table class="tableMany">
                    <tr>
                        <td>序号</td>
                        <td>回访记录</td>
                        <td>员工</td>
                        <td>回访时间</td>
                        <td width="45px"></td>
                    </tr>
                    <?php
                    $kehuFollowSql = mysql_query("SELECT * FROM kehuFollow WHERE khid = '$id' ORDER BY time DESC ");
                    $i = 0;
                    if(mysql_num_rows($kehuFollowSql) == 0){
                        echo "<tr><td colspan='5'>一条信息都没有</td></tr>";
                    }else{
                        while($array = mysql_fetch_array($kehuFollowSql)){
                            if ($array['look'] == '带看' ) {
                                $red = 'red';
                            }
                            else {
                                $red = '';
                            }
                            $i++;
                            echo "
                                <tr>
                                    <td>$i</td>
                                    <td data-text class='{$red}'>{$array['text']}</td>
                                    <td>{$Control['adname']}</td>
                                    <td>{$array['time']}</td>
                                    <td>
                                        <a href='{$root}control/ku/adpost.php?DeleteClientFollow={$array['id']}'>
                                            <span class='spanButton'>删除</span>
                                        </a>
                                    </td>
                                </tr>
                                ";
                            }
                        }
                    ?>
                </table>
            </form>
        </div>
        <!--回访记录结束-->
        <!--成交记录开始-->
        <?php echo $buyCarHeard;?>
        <div class="column">
            <form name="clinchRecordForm">
                <table class="tableMany">
                    <tr>
                        <td>时间</td>
                        <td>楼盘信息</td>
                        <td>房款</td>
                        <td>佣金类型</td>
                        <td>点数</td>
                        <td>让利</td>
                        <td>让利说明</td>
                        <td>佣金</td>
                        <td>联系方式</td>
                        <td width="45px"><span class='spanButton' assetsEdit='new'>添加成交记录</span></td>
                    </tr>
                    <?php
                    $kehuClinchSql = mysql_query("SELECT * FROM kehuClinch WHERE khid = '$id' ORDER BY time DESC ");
                    if(mysql_num_rows($kehuClinchSql) == 0){
                        echo "<tr><td colspan='10'>一条信息都没有</td></tr>";
                    }else{
                        while($array = mysql_fetch_array($kehuClinchSql)){
                            if (empty($array['points'])) {
                                $array['points'] = '未设置';
                            }
                            echo "
                             <tr>
                                <!--<td><span class='spanButton' assetsEdit='edit' clinchRecordId='{$array['id']}'>编辑</span></td>-->
                                <td>{$array['clinchTime']}</td>
                                <td>{$array['estateMsg']}</td>
                                <td>{$array['houseMoney']}</td>
                                <td>{$array['houseType']}</td>
                                <td>{$array['points']}</td>
                                <td>{$array['concede']}</td>
                                <td>{$array['concedeText']}</td>
                                <td>{$array['houseCommission']}</td>
                                <td>{$array['contact']}</td>
                                <!--<td data-text>{$array['text']}</td>-->
                                <td>
                                    <a href='{$root}control/ku/adpost.php?deleteKehuClinch={$array['id']}'>
                                        <span class='spanButton'>删除</span>
                                    </a>
                                </td>

                            </tr>
                            ";
                        }
                    }
                    ?>
                </table>
            </form>
        </div>
        <!--成交记录结束-->
    </div>
    <!--成交记录弹出层开始-->
    <div class="hide" id="assetsNum">
        <div class="dibian"></div>
        <div class="win" style=" height:426px; width:600px; margin:-213px 0 0 -300px;">
            <p class="winTitle">成交记录<span class="winClose" onclick="$('#assetsNum').hide()">×</span></p>
            <form name="PasForm">
                <table class="tableRight">
                    <tr>
                        <td><span class="red">* </span>时间：</td>
                        <td>
                            <input name='clinchTime' style='width: 187px' class='datainp text' id='clinchTime' type='text' placeholder='请选择' value=''  readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="red">* </span>楼盘信息：</td>
                        <td>
                            <input name='estateMsg'  class='text' type='text' placeholder="楼盘名称+楼栋+房号+平米+户型" value=''/>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="red">* </span>房款：</td>
                        <td>
                            <input name='houseMoney'  class='text' type='text' value=''/>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="red">* </span>佣金类型：</td>
                        <td id>
                            <?php echo select("houseType","select textPrice","-佣金类型-",array("点数","套数"),$kehu['houseType']);?>
                            <input name='points'  class='text textPrice hide' type='text' placeholder="点数" value='<?php echo $kehu['points'];?>'/>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="red">* </span>让利：</td>
                        <td>
                            <input name='concede'  class='text' type='text' value=''/>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="red">* </span>让利说明：</td>
                        <td>
                            <input name='concedeText'  class='text' type='text' value=''/>
                        </td>
                    </tr>
                    <tr>
                        <td>佣金：</td>
                        <td>
                            <input name='houseCommission'  class='text' type='text' value=''/>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="red">* </span>联系方式：</td>
                        <td>
                            <input name='contact'  class='text' type='text' placeholder="置业顾问姓名电话+渠道姓名电话" value=''/>
                        </td>
                    </tr>
                    <!--<tr>
                        <td><span class="red">*</span>成交说明：</td>
                        <td>
                            <textarea name="text" style="padding:5px;width:422px;height:100px;"></textarea>
                        </td>
                    </tr>-->
                    <tr>
                        <td><span class="red">* </span>登录密码：</td>
                        <td><input name="password" type="password" class="text short"></td>
                    </tr>
                    <tr>
                        <td>
                            <input name="clientId" type="text" class="hide" value="<?php echo $id;?>">
                            <input name="clinchRecordId" type="text" class="hide" value="">
                        </td>
                        <td><input id="submit-btn" type="button" class="button" value="确认提交" onclick="addAssets()"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!--成交记录弹出层结束-->
    <script type="text/javascript" src="<?php echo $root;?>jeDate/jedate.js"></script>
    <script>
        $(function(){
            //成交记录
            $("[assetsEdit]").click(function(){
                $("#assetsNum").fadeIn();
                var assetsEdit = $(this).attr('assetsEdit');
                if (assetsEdit == 'new') {
                    $('[name=PasForm] [name=clinchRecordId]').attr('value', ' ');
                    $('[name=PasForm] [name=text]').html(' ');
                } /*else {
                    var clinchRecordId = $(this).attr("clinchRecordId");//成交记录Id
                    $('[name=PasForm] [name=clinchRecordId]').attr('value', clinchRecordId);
                    var text = $(this).parents('tr').find('[data-text]').html();
                    $('[name=PasForm] [name=text]').html(text);
                }*/
            });

            var from = document.clientForm;
            //根据省份获取下属城市下拉菜单
            if (from.intentionProvince) {
                //根据省份获取下属城市下拉菜单
                from.intentionProvince.onchange = function(){
                    from.intentionArea.innerHTML = "<option value=''>--区县--</option>";
                    $.post("<?php echo root."library/libData.php";?>",{ProvincePostCity:this.value},function(data){
                        from.intentionCity.innerHTML = data.city;
                    },"json");
                };
                //根据省份和城市获取下属区域下拉菜单
                from.intentionCity.onchange = function(){
                    $.post("<?php echo root."library/libData.php";?>",{ProvincePostArea:from.intentionProvince.value,CityPostArea:this.value},function(data){
                        from.intentionArea.innerHTML = data.area;
                    },"json");
                };
            }
        });

        //设为小组公客
        function groupClient(khid) {
            $.post('<?php echo root."control/ku/addata.php?type=groupClient"; ?>', {khid: khid}, function(data) {
                if(data.warn == 2){
                    if(data.href){
                        window.location.href = data.href;
                    }else{
                        window.location.reload();
                    }
                }else{
                    warn(data.warn);
                }
            },'json');
        }

        //设为公司公客
        function firmClient(khid) {
            $.post('<?php echo root."control/ku/addata.php?type=firmClient"; ?>', {khid: khid}, function(data) {
                if(data.warn == 2){
                    if(data.href){
                        window.location.href = data.href;
                    }
                    else{
                        window.location.reload();
                    }
                }
                else{
                    warn(data.warn);
                }
            },'json');
        }
        window.onload = function() {
            //客户状态变化
            var clientStatus = document.getElementById('clientStatus');
            $.ajax({
                url: '<?php echo root."control/ku/addata.php?type=changeStatus";?>',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                   /* clientStatus.innerHTML = data.clientStatus;*/
                },
                error: function() {
                    alert('服务器错误');
                },
            })

            //佣金类型是点数显示点数
            var houseType = document.getElementsByName('houseType')[0];
            var points = document.getElementsByName('points')[0];
            houseType.onchange = function() {
                if (this.value == '点数') {
                    points.style.display = 'inline-block';
                }
                else {
                    points.style.display = 'none';
                }
            }
            // 客户来源根据一级分类返回二级分类
            var clientSourceOne = document.getElementsByName('clientSourceOne')[0];
            var clientSourceTwo = document.getElementsByName('clientSourceTwo')[0];
            if (clientSourceOne) {
                clientSourceOne.onchange = function() {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo "{$root}control/ku/addata.php?type=clientSourceOne";?>',
                        dataType: 'json',
                        data: {clientSourceOne: this.value},
                        success: function(data) {
                            clientSourceTwo.innerHTML = data.warn;
                        },
                        error: function() {
                            warn('出错了');
                        }
                    })
                }
            }

            //经理查看了某个员工的客户的联系的方式
            var contactTel = document.getElementById('contactTel');
            if ('contactTel' in window) {
                contactTel.onclick = function() {
                    var _this = this;
                    $.ajax({
                        type:"POST",
                        url:"<?php echo "{$root}control/ku/addata.php?type=contactTel";?>",
                        dataType:"json",
                        data:{clientId:'<?php echo $get['id'];?>'},
                        success:function(data){
                            if (data.warn == 2) {
                                _this.innerHTML = '<?php echo $kehu['contactTel'];?>';
                                warn("查看成功");
                            }
                        },
                        error:function(){
                            warn('出错了');
                        }
                    })
                }
            }

            //来电时间
            jeDate({
                dateCell:"#callTime",
                format:"YYYY-MM-DD hh",
                isinitVal:false,
                isTime:true, //isClear:false,
                minDate:"2014-09-19 00:00:00",
                choosefun:function(val){
                    var Date = document.getElementById('callTime');
                    Date.value = val;
                    Date.setAttribute('value', val);
                }
            })

            //回访时间
            var submitBtn = document.getElementById('submit-btn');
            var count = 0;
            var limitTime = null;
            submitBtn.onclick = function() {
                count++;
            }
            if (count < 3) {
                limitTime = currentTime(7);
            }
            else {
                limitTime = currentTime(7);
            }
            jeDate({
                dateCell:"#visitTime",
                format:"YYYY-MM-DD hh",
                isinitVal:false,
                isTime:true, //isClear:false,
                minDate: currentTime(0),
                maxDate: limitTime,
                choosefun:function(val){
                    var Date = document.getElementById('visitTime');
                    Date.value = val;
                    Date.setAttribute('value', val);
                }
            })

            //成交时间
            jeDate({
                dateCell:"#clinchTime",
                format:"YYYY-MM-DD hh",
                isinitVal:false,
                isTime:true, //isClear:false,
                minDate:"2014-09-19 00:00:00",
                choosefun:function(val){
                    var Date = document.getElementById('clinchTime');
                    Date.value = val;
                    Date.setAttribute('value', val);
                }
            })
        }
        /**
         * 成交记录
         */
        function addAssets(){
            $.post(root+'control/ku/addata.php?type=addAssets',$("[name='PasForm']").serialize(),function(data){
                if(data.warn == 2){
                    if(data.href){
                        window.location.href = data.href;
                    }else{
                        window.location.reload();
                    }
                }else{
                    warn(data.warn);
                }
            },'json');
        }

        /**
         * 当前时间
         * @param addDay 添加天数
         * @returns {string} 返回时间
         */
        function currentTime (addDay) {
            var now = new Date();
            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var day = now.getDate() + addDay;
            var hh = now.getHours();
            var mm = now.getMinutes();
            var ss = now.getSeconds();
            var clock = year + '-';
            if (month < 10) {
                clock += '0';
            }
            clock += month + "-";
            if (day < 10) {
                clock +="0";
            }
            clock += day + " ";
            if (hh < 10) {
                clock +="0";
            }
            clock += hh +':';
            if (mm < 10) {
                clock += '0';
            }
            clock += mm+':';
            if (ss<10) {
                clock += '0';
            }
            clock +=ss;
            return(clock);
        }
    </script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>