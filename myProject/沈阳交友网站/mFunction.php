<?php
/*********************引入库文件*********************/
#前端不用管
/*本函数库存放手机端的函数*/
include dirname(dirname(dirname(__FILE__)))."/library/OpenFunction.php";
/*******************网站底部******************************/
function mFooter(){
	$root = $GLOBALS['root'];
	$mFooter = "
<div class='footer fz14'>
	<a href='{$root}m/mindex.php' class='bottom-nav ".menu("m/mindex.php","current")."'><i class='index-icon index-icon2 ".menu("m/mindex.php","index-icon1")."'></i><p>网站首页</p></a>
	<a href='{$root}m/mSearch.php' class='bottom-nav ".menu("m/mSearch.php","current")."'><i class='index-icon index-icon4 ".menu("m/mSearch.php","index-icon3")."'></i><p>精确搜索</p></a>
	<a href='{$root}m/mLetter.php' class='bottom-nav ".menu("m/mLetter.php","current")."'><i class='index-icon index-icon8 ".menu("m/mLetter.php","index-icon7")."'></i><p>收发消息</p></a>
	<a href='{$root}m/user/mUsDatum.php' class='bottom-nav ".menu("m/user/mUsDatum.php","current")."'><i class='index-icon index-icon6 ".menu("m/user/mUsDatum.php","index-icon5")."'></i><p>个人资料</p></a>
	<a href='{$root}m/user/mUser.php' class='bottom-nav ".menu("m/user/mUser.php","current")."'><i class='index-icon index-icon10 ".menu("m/user/mUser.php","index-icon9")."'></i><p>个人中心</p></a>
</div>
</body>
</html>
	";	
	return $mFooter;
}
function my_top(){
	$kehu = $GLOBALS['kehu'];
	$root = $GLOBALS['root'];
	$time = $GLOBALS['time'];
	$client = mysql_fetch_assoc(mysql_query("select * from kehu where khid = '$kehu[khid]' "));
	//包年包月发信
	$minMonth = date("Y-m-d H:i:s",strtotime("$time - 1 month"));//当前时间减去一个月
	$payMonth = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包月' and khid = '$client[khid]' and WorkFlow = '已支付' and UpdateTime > '$minMonth' "));
	$minYear = date("Y-m-d H:i:s",strtotime("$time - 1 year"));//当前时间减去一年
	$payYear = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包年' and khid = '$client[khid]' and WorkFlow = '已支付' and UpdateTime > '$minYear' "));
	if($payYear>0){
		$Grade = "年会员";	
	}else if($payMonth>0){
		$Grade = "月会员";	
	}else{
		$Grade = "普通会员";	
	}
	$my_top = "
	<div class='my-top'>
        <div class='my-in of'>
        	<img src='".HeadImg($client['sex'],$client['ico'])."' class='fl' onClick='document.headPortraitForm.headPortraitUpload.click()'>
            <div class='my-title fl'>
            	<p class='col1 fz16 fw2'>{$client['NickName']}</p>
                <p class='col1 fz14'>{$Grade}<i class='v-icon'></i></p>
            </div>
        </div>
    </div>
	<div class='hide'>
		<form name='headPortraitForm' action='{$root}library/usPost.php' method='post' enctype='multipart/form-data'>
			<input name='headPortraitUpload' type='file' onChange='document.headPortraitForm.submit()'>
		</form>
    </div>
	";	
	return $my_top;
}
//选择支付弹出层
function choosePay(){
	$root = $GLOBALS['root'];
	$choosePay = "
	<!--选择支付弹出层-->
	<div class='popup-background hide'></div>
	<div class='popup-box hide'>
		<div class='popup-box__hd'>
				<div class='popup-hd-ctrl close' role='button' aria-label='close'></div>
				<div class='popup-hd-title'>支付</div>
		</div>
		<div qr_code>
			<div class='popup-box__bd'>
				<p class='popup-new-attr' data-title>看信包月</p>
				<p class='popup-new-attr'><big data-money>￥220</big></p>
				<div class='popup-new-check' id='check'>
					<label><span role='radio' class='spanCheck' name='pay' paymentType='alipay'></span><span>支付宝</span></label>
				</div>
			</div>	
			<div class='popup-box__fd'>
					<a href='javascript:;' id='button' class='popup-btn popup-btn0' role='button' paymentTrue>确认支付</a>
			</div>
		</div>
	</div>
	<!--支付表单-->
	<div class='hide'>
		<form name='PayForm' action='{$root}alipaywap/alipayapi.php' method='post'>
			<input name='PayType' type='hidden' value=''>
			<input name='GiftId' type='hidden' value=''>
			<input name='TypeId' type='hidden'>
		</form>
	</div>
	<script>
	$(function(){
		//支付弹出层
		function choosePay(){
			this.Close();
			this.choose();
			this.alipay();
			this.weChat();
			this.paymentTrue();
		}
		choosePay.prototype = {
			Hide:function(){
				$('.popup-background').hide();
				$('.popup-box').hide();
			},
			Close:function(){
				var _this = this;
				$('.close').click(function(){
					_this.Hide();
				})	
			},
			choose:function(){
				var check = document.getElementsByClassName('spanCheck');
				for( var i=0;i<check.length;i++ ){
					check[i].onclick = function(){
					for( var i=0;i<check.length;i++ ){
						check[i].className = 'spanCheck'
					}
					this.className = 'spanCheck checked';
					}
				}
			},
			alipay:function(){
				$('[paymentType=alipay]').click(function(){
					var paymentType = $(this).attr('paymentType');
					$('[paymentTrue]').attr('paymentTrue',paymentType);
				})
			},
			weChat:function(){
				$('[paymentType=weChat]').click(function(){
					var paymentType = $(this).attr('paymentType');
					$('[paymentTrue]').attr('paymentTrue',paymentType);
				})	
			},
			paymentTrue:function(){
				$('#button').click(function(){
					var paymentTrue = $(this).attr('paymentTrue');
					if(paymentTrue == 'alipay'){
						$('[name=PayForm]').submit();	
					}
					if(paymentTrue == 'weChat'){
						//生成微信支付扫描二维码
						$.ajax({
							url:'{$root}library/usData.php?type=wxScanPay',
							data:$('[name=PayForm]').serialize(),
							type:'POST',
							dataType:'json',
							success:function(data){
								var url = data.src;
								var out_trade_no = data.orderId;
								var qr_code = '<img src=\"'+url+'\" />';
								$('[qr_code]').html(qr_code);	
								window.setInterval(function(){
									$.post('{$root}library/usData.php',{OutTradeNo:out_trade_no},function(data){
										if(data.warn == 2){
											window.location.reload();
										}
									},'json');
								},2000);
							},
							error:function(){
								alert('服务器错误');
							}	
						})	
					}
				})
			}	
		}
		new choosePay();
	})
	</script>
	";
	return $choosePay;	
} 
?>
