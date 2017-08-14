<?php
include "ku/adfunction.php";
ControlRoot("消息管理");
if(isset($_GET['id']) and !empty($_GET['id'])){
	$id = $_GET['id'];
	//根据传过来的id号查询消息
    $message = query("talk"," id = '$id' ");
	//没有查询到
	if(empty($message['id'])){
		$_SESSION['warn'] = "未找到这条消息的信息";
		header("location:{$adroot}adMessage.php");
		exit(0);
	}else{
		//消息标题
		$title = $message['title'];
	}
}else{
	$title = "新建消息";
}
echo head("ad").adheader();
?>
<div class="column MinHeight">
    <!--标题开始-->
    <a href="<?php echo "{$adroot}adMessage.php";?>"><img src="<?php echo "{$root}img/adimg/adMessage.png";?>"></a>
	<p>
		<a href="<?php echo "{$adroot}adMessage.php";?>">消息管理</a>&nbsp;>&nbsp;
		<a href="<?php echo $ThisUrl;?>"><?php echo $title;?></a>
	</p>
	<!--标题结束-->
	<!--基本资料开始-->
	<div class="kuang">
    <p>
    	<img src="<?php echo root."img/images/PersonalData.png";?>">
        消息基本资料
    </p>
    <form name="messageForm">
    	<table class="TableRight">
			<tr>
			    <td style="width:200px;">消息ID号：</td>
				<td><?php echo kong($message['id']);?></td>
			</tr>
            <tr>
            	<td>客户ID号：</td>
                <td><?php echo kong($message['khid']);?></td>
            </tr>
			<tr>
			    <td>消息类型：</td>
				<td><?php echo kong($message['type']);?></td>
			</tr>
            <tr>
            	<td>消息标题：</td>
                <td><?php echo kong($message['title']);?></td>
            </tr>
			<tr>
			    <td>消息内容：</td>
				<td><?php echo kong($message['text']);?></td>
			</tr>
			<tr>
			    <td>浏览量：</td>
				<td><?php echo kong($message['num']);?></td>
			</tr>
			<tr>
			    <td>审核状态：</td>
				<td><?php echo select("messageAuditing","select","--选择--",array("审核中","已通过"),$message['Auditing']);?></td>
			</tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($message['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>创建时间：</td>
				<td><?php echo kong($message['time']);?></td>
			</tr>
            <tr>
            	<td><input name="adMessageId" type="hidden" value="<?php echo $message['id'];?>" /></td>
                <td><input type="button" class="button" value="提交" onClick="Sub('messageForm','<?php echo root."control/ku/addata.php";?>')" /></td>
            </tr>
		</table>
    </form>	
	</div>
	<!--基本资料结束-->
</div>
<?php echo warn().adfooter();?>