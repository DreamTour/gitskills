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
    $Follow = "请先创建客户基本资料，再填写跟进记录";
    $title = "新建客户";
    $button = "新建";
    $floowDivDisplay = "hide";
    //员工客户上限
    $staffClientNum = mysql_num_rows(mysql_query("SELECT * FROM kehu WHERE adid = '$Control[adid]' AND type = '私客' "));
    if ($staffClientNum > $Control['clientNum']) {
        $_SESSION['warn'] = '你的客户已经达到上限了';
        header("location:{$root}control/adClient.php");
        exit(0);
    }
}else{
    //根据传过来的id号查询客户
    $kehu = query("kehu"," khid = '$id' ");
    //如果未找到
    if(empty($kehu['khid'])){
        $_SESSION['warn'] = "未找到这个客户的信息";
        header("location:{$root}control/adClient.php");
        exit(0);
    }
    //经理设为公司公客
    if ($adDuty['name'] == '经理') {
        $firmClientBtn = "<a href='javascript:void(0)' onclick='firmClient($kehu[khid])'><span class='spanButton'>设为公司公客</span></a>";
    }
    //客户不是私客，不显示按钮
    if ($kehu['type'] == '私客') {
        $groupClientBtn = "<a href='javascript:void(0)' onclick='groupClient($kehu[khid])'><span class='spanButton'>设为小组公客</span></a>";
    }
    //如果不是自己的客户、没有查看所有客户的权限、不是公客
    /*if($kehu['adid'] != $Control['adid'] and $adDuty['clientPower'] != '是' and $kehu['followType'] != '公客' ){
        $_SESSION['warn'] = "您没有权限查看这个客户";
        header("location:{$root}control/adClient.php");
        exit(0);
    }*/
    //查询所属员工
    $admin = query("admin","adid = '$kehu[adid]' ");
    //默认收货地址
    if(!empty($kehu['AddressId'])){
        $address = query("address"," id = '$kehu[AddressId]' ");
        $region = query("region"," id = '$address[RegionId]' ");
        //地址拼接
        if(!empty($address['id'])){
            $AddressMx = "{$address['AddressName']}-{$address['AddressTel']}-{$region['province']}-{$region['city']}-{$region['area']}-{$address['AddressMx']}";
        }else{
            $AddressMx = "未设置";
        }
        $addressButton = "<a href='".root."control/adClientAddress.php?khid={$kehu['khid']}'><span class='SpanButton'>查询所有</span></a>";
    }
    //此客户所有联系地址
    $addressSql = mysql_query(" select * from address where khid = '$id' order by time desc ");
    if(mysql_num_rows($addressSql) == 0){
        $addressAll = "暂无联系地址";
    }else{
        $addressAll = "<ul>";
        while($array = mysql_fetch_array($addressSql)){
            $region = query("region"," id = '$array[RegionId]' ");
            $addressAll .= "<li>{$region['province']}-{$region['city']}-{$region['area']}-{$array[AddressMx]}</li>";
        }
        $addressAll.= "</ul>";
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
    //有效客户的切换权限
    if($adDuty['department'] == "市场部" && $adDuty['name'] == "市场部主管"){
        if($kehu['valid'] == "是"){
            $validRedio = "否";
        }else{
            $validRedio = "是";
        }
        $validButton = "<span class='SpanButton' clientValid='{$validRedio}'>切换为：{$validRedio}</span>";
    }
    //客户性质
    if($kehu['followType'] == "公客"){
        $followType = "私客";
    }else{
        $followType = "公客";
    }
    //如果此员工有此客户的编辑权限
    if($adDuty['clientEdit'] == '是'){
        if($kehu['adid'] == $Control['adid']){
            $orderBtn = "<a href='".root."control/adOrderMx.php?khid={$kehu['khid']}' target='_blank'><span class='SpanButton FloatRight'>创建合同</span></a>";
            $NewAddr =  "<a href='".root."control/adClientAddressMx.php?khid={$kehu['khid']}'><span class='SpanButton'>新建地址</span></a>";
        }
        $followTypeButton = "<span class='SpanButton' clientFollowType='{$followType}'>切换为：{$followType}</span>";
    }
    //其他参数
    $title = $kehu['CompanyName'];
    $button = "更新";
    $floowDivDisplay = "";
    $other = "
	<tr>
		<td>有效客户：</td>
		<td>
		<span id='validRadioSpan'>".kong($kehu['valid'])."</span>
		{$validButton}
		</td>
	</tr>
	<tr>
        <td>默认联系地址：</td>
        <td>
        ".kong($AddressMx)."{$NewAddr}{$addressButton}
        </td>
    </tr>
	<tr>
		<td>联系地址：</td>
		<td>{$addressAll}</td>
	</tr>
	<tr>
		<td>来源：</td>
		<td>".kong($kehu['source'])."</td>
	</tr>
	<tr>
		<td>跟进性质：</td>
		<td>
			<span id='followTypeSpan'>".kong($kehu['followType'])."</span>
			{$followTypeButton}
		</td>
	</tr>
	<tr>
		<td>所属员工：</td>
		<td>".kong($admin['adname'])."</td>
	</tr>
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
//判断员工是否有此客户的编辑权：当本职位有客户编辑权时，新建客户或为本员工的私客，则有编辑权限。
if (
    $adDuty['edit'] == '是' and
    (empty($id) or $kehu['adid'] == $Control['adid'])
){
    $CompanyName = "<input name='CompanyName' type='text' class='text' value='{$kehu['CompanyName']}'>";
    $IndustryName = IDSelect("kehuIndustry","IndustryName","select","id",'name',"--选择--",$kehu['industry']);
    $ContactName = "<input name='ContactName' type='text' class='text' value='{$kehu['ContactName']}'>";
    $ContactTel = "<input  name='ContactTel' type='text' class='text' value='{$kehu['ContactTel']}'>";
    $spareTel = "<input  name='spareTel' type='text' class='text' value='{$kehu['spareTel']}'>";
    $Landline = "<input  name='Landline' type='text' class='text' value='{$kehu['Landline']}'>";
    $fax = "<input  name='fax' type='text' class='text' value='{$kehu['fax']}'>";
    $ContactQQ = "<input  name='ContactQQ' type='text' class='text' value='{$kehu['ContactQQ']}'>";
    $labeMaking = "<input name='labeMaking' type='text' class='text' value='{$kehu['labeMaking']}' />";
    $text = "<textarea  name='text' class='textarea'>{$kehu['text']}</textarea>";
    $businessLicenseNum = "<input  name='businessLicenseNum' type='text' class='text' value='{$kehu['businessLicenseNum']}'>";
    $IsButton = "
	<tr>
		<td><input name='adClientId' type='hidden' value='{$kehu['khid']}'></td>
		<td><input onclick=\"Sub('ClientForm',root+'control/ku/addata.php?type=clientEdit')\" type='button' class='button' value='{$button}'></td>
	</tr>
";
}else{
    //经理点击查看才看得到联系方式
    if ($adDuty['name'] == '经理') {
        $ContactTel = "<a href='javascript:void(0)' id='contactTel'><span class='spanButton'>点击查看联系方式</span></a>";
    } else {
        $ContactTel = kong($kehu['contactTel']);
    }
    $CompanyName = kong($kehu['CompanyName']);
    $IndustryName = kong($kehu['industry']);
    $ContactName = kong($kehu['contactName']);
    $spareTel = kong($kehu['spareTel']);
    $Landline = kong($kehu['Landline']);
    $fax = kong($kehu['fax']);
    $ContactQQ = kong($kehu['ContactQQ']);
    $labeMaking = kong($kehu['labeMaking']);
    $text = kong($kehu['text']);
    $businessLicenseNum = kong($kehu['businessLicenseNum']);
}
//合同列表
$buyCarInfo = "";
$buyCarHeard = "";
$buyCarSql = mysql_query(" select * from buycar where khid = '$id' ");
if(mysql_num_rows($buyCarSql) == 0){
    $buyCarInfo .= "<tr><td colspan='11'>一个记录都没有</td></tr>";
}else{
    while($array = mysql_fetch_array($buyCarSql)){
        $buycarInvoice =mysql_fetch_assoc(mysql_query(" select * from buycarInvoice where buycarId = '{$array[id]}' order by time desc "));
        $transport = mysql_fetch_assoc(mysql_query(" select *,count(*) as total from transport where buycarId = '{$array[id]}' and state = '已收运' "));
        $transportCatalog = mysql_fetch_assoc(mysql_query(" select sum(weightSteelyard) as weightTotal from transportCatalog where buycarId = '{$array[id]}' "));
        $buyCarInfo .="
	<tr>
			<td>{$array['name']}</td>
			<td>{$array['money']}</td>
			<td>{$array['pay']}</td>
			<td>".kong($buycarInvoice['time'])."</td>
			<td>".kong($array['invoice'])."</td>
			<td>".kong($transport['total'])."</td>
			<td>".kong($transportCatalog['weightTotal'])."</td>
			<td><a href='{$root}control/adOrderMx.php?id={$array['id']}'><span class='SpanButton'>详情</span></a></td>
		</tr>
	";
    }
}
$buyCarHeard = "
<form name='buyCarForm' action='post'>
	<table class='tableMany'>
		<tr><td colspan='11' class='tableHeader'>合同列表</td></tr>
		<tr>
			<td>合同名称</td>
			<td>合同金额</td>
			<td>回款金额</td>
			<td>开票日期（最后一次）</td>
			<td>开票总金额</td>
			<td>收运次数</td>
			<td>收运重量</td>
			<td></td>
		</tr>
		{$buyCarInfo}
		</table>
</form>
";
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
            <form name="ClientForm">
                <table class="tableRight">
                    <tr>
                        <td style="width:200px;">客户ID号：</td>
                        <td> <?php echo kong($kehu['khid']).$orderBtn;?> </td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;联系人姓名：</td>
                        <td><?php echo $ContactName;?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;联系人手机：</td>
                        <td><?php echo $ContactTel;?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;客户性质：</td>
                        <td>
                            <?php echo kong($kehu['type']);?>
                            <?php echo $groupClientBtn;?>
                            <?php echo $firmClientBtn;?>
                        </td>
                    </tr>
                    </tr>
                    <tr>
                        <td>简要介绍：</td>
                        <td><?php echo $text;?></td>
                    </tr>
                    <?php echo /*$other,*/$IsButton;?>

                </table>
            </form>
        </div>
        <!--基本资料结束-->
        <!--合同列表开始-->
        <?php echo $buyCarHeard;?>
        <!--合同列表结束-->
        <!--跟进开始-->
        <div class="kuang <?php echo $floowDivDisplay;?>">
            <p>
                <img src="<?php echo root."img/images/edit.png";?>">
                跟进记录
            </p>
            <form name="FollowForm">
                <table class="TableRight">
                    <tr>
                        <td style="width:100px;">历史跟进：</td>
                        <td class="FollowTd"><?php echo $Follow;?></td>
                    </tr>
                    <tr>
                        <td>新增跟进：</td>
                        <td><textarea name="text" class="textarea"></textarea></td>
                    </tr>
                    <tr>
                        <td><input name="ClientId" type="hidden" value="<?php echo $_GET['id'];?>"></td>
                        <td><input type="button" class="button" value="添加" onclick="Sub('FollowForm','<?php echo root."control/ku/addata.php?type=ClientFollow";?>')"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--跟进结束-->
    </div>
    <script>
        $(function(){
            var khid = "<?php echo $id;?>";
            //市场主管变更有效可状态
            $("[clientValid]").click(function(){
                $.post(root+"control/ku/addata.php?type=changeClientValid",{clientValid:$(this).attr("clientValid"),khid:khid},function(data){
                    if(data.warn == 2 ){
                        $("#validRadioSpan").html(data.valid);
                        $("[clientValid]").attr("clientValid",data.contrary);
                        $("[clientValid]").html("切换为："+data.contrary);
                    }else{
                        warn(data.warn);
                    }

                },"json");
            });
            //跟进性质切换
            $("[clientFollowType]").click(function(){
                $.post(root+"control/ku/addata.php?type=changeClientFollowType",{clientFollowType:$(this).attr("clientFollowType"),khid:khid},function(data){
                    if(data.warn == 2 ){
                        document.location.reload();
                    }else{
                        warn(data.warn);
                    }

                },"json");
            });
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
                    }else{
                        window.location.reload();
                    }
                }else{
                    warn(data.warn);
                }
            },'json');
        }
        window.onload = function() {
            //经理查看了某个员工的客户的联系的方式
            var contactTel = document.getElementById('contactTel');
            contactTel.onclick = function() {
                var _this = this;
                ajax({
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
    </script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>