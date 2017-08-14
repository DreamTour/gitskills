<?php
include "../mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
$params = jsApi("{$root}m/user/mUsExtend.php");
//查询分享的人数
$shareNumber = mysql_num_rows(mysql_query("select * from kehu where ShareId = '$kehu[khid]' "));
?>
<style>
#text{border:none;}
</style>
<!--头部-->
<div class="header fz16">
    <div class="head-center"><div class="head-left"><a href="<?php echo getenv("HTTP_REFERER")?>" class="col1"><返回</a></div>
</div>
</div>
<!--内容-->
<div class="activity-details-content">
    <ul class="activity-details-list">
    	<li class="activity-details-item">
            <h2>我的分享码</h2>
            <p><?php echo $kehu['ShareCode'];?></p>
        </li>
    	<li class="activity-details-item">
            <h2>分享码注册链接</h2>
            <p><input id="ClientShareCode" type="text" value="<?php echo "{$root}m/user/mUsRegister.php?ShareCode={$kehu['ShareCode']}";?>" /><input type="button" value="长按字母处全选复制" id="copy"  /></p>
        </li>
    	<li class="activity-details-item">
        	<h2>分享规则</h2>
            <p>推荐一位身边的单身朋友加入本站并成功成为会员 您就可以获得免费发信的权利  成功一人奖励一天 没有上限 多劳多得 让更多的单身朋友加入进来吧</p>
        </li>
        <li class="activity-details-item">
        	<h2>分享方式</h2>
            <p>一：手机登录和电脑登录可以复制上面分享链接 发送给QQ好友 QQ群 论坛 贴吧等  对方点击后直接可以进入注册页面 系统可以自动填写好分享码<br />
二：手机登录可以点击本页面右上角分享到微信朋友圈和微信好友 对方点击后直接可以进入注册页面 系统可以自动填写好分享码</li>
        <li class="activity-details-item">
        	<h2>您已成功分享</h2>
            <p><?php echo $shareNumber;?>人</p>
        </li>
    </ul>
</div>
<!--底部-->
</body>
<script type='text/javascript' src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
$(document).ready(function(){
	wx.config({
		debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId: '<?php echo $params['app_id'];?>', // 必填，公众号的唯一标识
		timestamp:<?php echo $params['timestamp'];?>, // 必填，生成签名的时间戳
		nonceStr: '<?php echo $params['noncestr'];?>', // 必填，生成签名的随机串
		signature: '<?php echo $params['signature'];?>',// 必填，签名，见附录1
		jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
	wx.ready(function(){
		//分享到朋友圈
		wx.onMenuShareTimeline({
			title: '<?php echo website("rZq60655518FO");?>', // 分享标题
			link: $("#ClientShareCode").val(), // 分享链接
			imgUrl: '<?php echo img("xRk60655737TS");?>', // 分享图标
			success: function () { 
				// 用户确认分享后执行的回调函数
			},
			cancel: function () { 
				// 用户取消分享后执行的回调函数
			}
		});
		//分享给朋友
		wx.onMenuShareAppMessage({
			title: '<?php echo website("rZq60655518FO");?>', // 分享标题
			desc: '<?php echo website("wMu60658891ZS");?>', // 分享描述
			link: $("#ClientShareCode").val(), // 分享链接
			imgUrl: '<?php echo img("xRk60655737TS");?>', // 分享图标
			type: '', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function () { 
				// 用户确认分享后执行的回调函数
			},
			cancel: function () { 
				// 用户取消分享后执行的回调函数
			}
		});
	});
});
window.onload = function(){
	var text = document.getElementById('ClientShareCode');
	var btn = document.getElementById('copy');
	btn.onclick = function(){
		text.select();
		document.execCommand('copy');	
	}	
}
</script>
</html>
