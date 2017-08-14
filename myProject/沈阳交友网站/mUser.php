<?php
include "../mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
if($KehuFinger == 2) {
	$login = "";
} else{
	$login = "退出登录";
}
//支付
$minMonth = date("Y-m-d H:i:s",strtotime("$time - 1 month"));//当前时间减去一个月
$payMonth = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包月' and khid = '$kehu[khid]' and WorkFlow = '已支付' and UpdateTime > '$minMonth' "));
$minYear = date("Y-m-d H:i:s",strtotime("$time - 1 year"));//当前时间减去一年
$payYear = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包年' and khid = '$kehu[khid]' and WorkFlow = '已支付' and UpdateTime > '$minYear' "));
if($payMonth == 0){
	$payMonthValue = "yes";	
}
if($payYear == 0){
	$payYearValue = "yes";	
}		
?>
<!--头部-->
<div class="header fz16">
    <div class="head-center"><h3 style="font-size:14px;">永久免费收信和回信 来试试您的个人魅力吧</h3></div>
<!--    <div class="head-center"><a href="<?php echo $root;?>m/user/mUsLogin.php?Delete=kehu" class="col1"><?php echo $login;?></a></div>
--></div>
<!--我的-->
<div class="my-content">
	<?php echo my_top();?>
     <!--客户要求先取消掉-->
    <!--<div class="my-top-nav bg2">
    	<p class="fz16"><a href="<?php echo "{$root}m/user/mUsAlbum.php";?>"><i class="my-icon-top my-icon1"></i><span>我的相册</span></a></p>
       <p class="fz16"><a href="<?php echo "{$root}m/user/mUsGift.php";?>"><i class="my-icon-top my-icon2"></i><span>我的礼物</span></a></p>
    </div>-->
    <!--我的服务-->		
    <div class="my-service bg2">
    	<!--<h2>我的服务</h2>-->
        <ul class="my-service-list">
        	<li openId='1' data-price='<?php echo website('DDf52623284iE');?>'><a href="javascript:;"><i class="my-icon my-icon3"></i><p>发信包月</p></a></li>
            <li openId='2' data-price='<?php echo website('zQl52623335uv');?>'><a href="javascript:;"><i class="my-icon my-icon4"></i><p>发信包年</p></a></li>
            <li openId='3' data-price='<?php echo website('GCD52623356LP');?>'><a href="javascript:;"><i class="my-icon my-icon5"></i><p>排名提前</p></a></li>
            <li><a href="<?php echo "{$root}m/user/mUsSee.php";?>"><i class="my-icon my-icon6"></i><p>谁看过我</p></a></li>
            <li><a href="<?php echo "{$root}m/user/mUsFollow.php";?>"><i class="my-icon my-icon7"></i><p>谁关注我</p></a></li>
            <li><a href="<?php echo "{$root}m/mActivity.php";?>"><i class="my-icon my-icon8"></i><p>我的活动</p></a></li>
            <li><a href="<?php echo "{$root}m/user/mUsStory.php";?>"><i class="my-icon my-icon9"></i><p>成功故事</p></a></li>
            <li><a href="<?php echo "{$root}m/user/mUsCooperate.php";?>"><i class="my-icon my-icon10"></i><p>商务合作</p></a></li>
            <li><a href="<?php echo "{$root}m/user/mUsContact.php";?>"><i class="my-icon my-icon11"></i><p>联系我们</p></a></li>
        </ul>
    </div>
    <!--底部广告-->
<!--    <div class="my-ad">
    	<a href="<?php echo "{$root}m/user/mUsExtend.php";?>"><img src="<?php echo img("KKR54253637kM");?>"></a>
    </div>-->
</div>
<!--支付表单-->
<div class='hide'>
    <form name='letterPayForm' action='<?php echo $root?>alipay/alipayapi.php' method='post'>
        <input name='PayType' type='hidden' value=''>
    </form>
</div>
<!--支付弹出层-->
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
                    <label><span role='radio' class='spanCheck' name='pay' paymentType='weChat'></span><span>微信</span></label>
                    <label><span role='radio' class='spanCheck' name='pay' paymentType='alipay'></span><span>支付宝</span></label>
            </div>
        </div>	
        <div class='popup-box__fd'>
                <a href='javascript:;' class='popup-btn popup-btn0' role='button' paymentTrue>确认支付</a>
        </div>
    </div>
</div>
<!--底部-->
<?php echo warn().choosePay().mFooter();?>
<script>
$(function(){
	//打开支付弹出层
	function openPay(){
		this.eject();
	}
	openPay.prototype = {
		Show:function(){
			$('.popup-background').show();
			$('.popup-box').show();	
		},
		eject:function(){
			var _this = this;
			$('[openId]').click(function(){
				var attr = $(this).attr('openId');
				var str = $(this).text();
				var price = $(this).attr('data-price');
				$('[data-title]').html(str.replace(/>+/g,''));
				$('[data-money]').html('￥'+price);
				if(attr == 1 && '<?php echo $payMonthValue;?>' != 'yes'){
					warn('你已经包月过了');
				}else if(attr == 2 && '<?php echo $payYearValue;?>' != 'yes'){
					warn('你已经包年过了');
				}else{
					_this.Show();
					$('[name=PayType]').val(attr);
				} 
			})	
		}
	}
	new openPay();
})
</script>