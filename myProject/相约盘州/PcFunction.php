<?php
/*********************引入库文件*********************/
#前端不用管
require_once(dirname(dirname(__FILE__))."/control/ku/configure.php");
/*********************网站顶部*********************/
function pc_header(){
//判断是否应该显示登录注册
	if($GLOBALS['KehuFinger'] == 2) {
		$login = "<div class='login'>
                    <a href='{$GLOBALS['root']}user/usLogin.php'>登录</a>
                    <a href='{$GLOBALS['root']}user/usRegister.php'>注册</a>
                </div>";
	} else{
		$login = "<div id='outLogin' class='login'><a style='width:100px;' href='{$GLOBALS['root']}index.php?detele=yes'>退出登录</a></div>";
	}
	return "
	<!--头部-->
    	<div class='header'>
        	<a class='logo' href='{$GLOBALS['root']}index.php'><img src='".img("ULa49857883GM")."'></a>
            <div class='tel_number'>
            	<div class='tel_text'><i class='tel icon'></i>全国咨询热线</div>
                <div class='number'>".website('w5we63sd')."</div>
            </div>
        </div>
        <!--导航-->
        <div class='nav_box'>
        	<div class='nav'>
                <ul class='nav_bar'>
                    <a href='{$GLOBALS['root']}index.php'>
                        <li class='nav_pink ".menu("index.php","nav_item01")."'>首页</li>
                    </a>
                    <a href='{$GLOBALS['root']}user/user.php'>
                        <li class='nav_pink ".menu("user/user.php","nav_item01")."'>个人中心</li>
                    </a>
                    <a href='{$GLOBALS['root']}Activity.php'>
                        <li class='nav_pink ".menu("Activity.php","nav_item01")."'>最新活动</li>
                    </a>
                    <a href='{$GLOBALS['root']}Search.php'>
                        <li class='nav_pink ".menu("Search.php","nav_item01")."'>缘分搜索</li>
                    </a>
                    <a href='{$GLOBALS['root']}Talk.php'>
                        <li class='nav_pink ".menu("Talk.php","nav_item01")."'>交友手札</li>
                    </a>
                    <a href='{$GLOBALS['root']}Story.php'>
                        <li class='nav_pink ".menu("Story.php","nav_item01")."'>成功案例</li>
                    </a>
                    <a href='{$GLOBALS['root']}Tour.php'>
                        <li class='nav_pink ".menu("Tour.php","nav_item01")."'>本地通</li>
                    </a>
                    <a href='{$GLOBALS['root']}About.php'>
                        <li class='nav_pink ".menu("About.php","nav_item01")."'>关于我们</li>
                    </a>
                </ul>
                {$login}
            </div>
        </div>
	";
}
/*********************网站底部*********************/
function footer(){
	return "
<!--底部-->
<div class='footer'>
			<div class='footer_title_box'>
			   <p class='footer_title'>联系方式</p>
			</div>
			<div class='footer_content'>
				<div class='footer_content_top'>
					<ul class='footer_contact'>
						<li>电话：".website('w5we63sd')."</li>
						<li>传真：".website('QWZ51580195qJ')."</li>
						<li>地址：".website('s87dsw')."</li>
						<li>邮箱：".website('LwM51580069zD')."</li>
					</ul>
					<div class='footer_barcode'>
						<a href='javascript:;'>
						<div class='footer_barcode_qq'>	
								<div class='qq_barcode'>
									<img src='".img("Tec48129338Nw")."'>
								</div>
								<div class='qq_text'>
									<h1>QQ在线咨询</h1>
									<p>客服:&nbsp;2813140631<br/>客服:&nbsp;116530778</p>
								</div>
						</div>
						</a>
						<a href='javascript:;'>
						<div class='footer_barcode_weibo'>
								<div class='weibo_barcode'>
									<img src='".img("nNE49914550SZ")."'>
								</div>
								<div class='weibo_text'>
									<h1>新浪微博</h1>
									<p>扫描二维码&nbsp;关注更多信息内容</p>
								</div>	
						</div>
						</a>
						<a href='javascript:;'>
							<div class='footer_barcode_weixin'>
								<div class='weixin_barcode'>
									<img src='".img("SrV52701840eN")."'>
								</div>
								<div class='weixin_text'>
									<h1>微信公众号</h1>
									<p>每时每刻掌控最新动态&nbsp;随时随地知晓盘州资讯</p>
								</div>	
							</div>
						</a>
					</div>
				</div>
				<div class='footer_content_bottom'>
					<div class='footer_content_box'>
						<a href='{$GLOBALS['root']}index.php'>首页</a>　<span>|</span>　
						<a href='{$GLOBALS['root']}user/user.php'>个人中心</a>　<span>|</span>　
						<a href='{$GLOBALS['root']}Activity.php'>最新活动</a>　<span>|</span>　
						<a href='{$GLOBALS['root']}Search.php'>缘分搜索</a>　<span>|</span>　
						<a href='{$GLOBALS['root']}Talk.php'>交友手札</a>　<span>|</span>
						<a href='{$GLOBALS['root']}Story.php'>成功案例</a>　<span>|</span>　
						<a href='{$GLOBALS['root']}About.php'>关于我们</a>
					</div>
					<p class='copyright'>".website('uisjue410q')."</p>
					<p>".website('qvg55901281vv')."</p>
				</div>
			</div>
		</div>
	</div> 
</body>
</html>";
}
/*******显示送礼物弹出层*************************************************/
function send_gift(){
	$giftSql = mysql_query("SELECT * FROM Gift");
	$count = 1;
	$a = array();
	while($array = mysql_fetch_assoc($giftSql)){
		$IGiftID = " GiftId='{$array['id']}' ";
		if($count == 1) {
			$html = "<i class='gift_current' data-flow='yes' {$IGiftID}></i>";
			$GiftId = $array['id'];
		}else{
			$html = "<i {$IGiftID}></i>";
		} 
		array_push($a,"<div class='gift_content1'><img style='width:64px;' src='{$GLOBALS['root']}{$array['ico']}'>{$html}</div>");
		$count++; 
	};
		return "
	<div class='gift_zzc' id='bg-gift' style='display:none;'></div>
	<div class='gift' id='gift' style='display:none;'>
		<div class='gift_header'>
			<span>赠送礼物</span>
			<i class='pop-up' id='close-gift' style='cursor:pointer;'></i>
		</div>
		<div class='gift_content' id='bg'>
			".join('',$a)."
		</div>
		<a href='javascript:;' class='pop-up_btn' id='send-mes'>点击赠送</a>
	</div>
	<div class='hide'>
	<form name='GiftPayForm' action='{$root}pay/alipayapi.php' method='post'>
	<input name='GiftId' type='hidden' value='{$GiftId}'>
	<input name='TypeId' type='hidden'>
	<input name='type' type='hidden' value='赠送礼物'>
	</form>
	</div>
	<script>
	var G ={
		show:function(){
			$('#bg-gift').show();
			$('#gift').fadeIn(300);
		},
		hide:function(){
			$('#bg-gift').hide();
			$('#gift').hide();
		},
		sent_gift:function(){
			$('#bg > div').click(function(){
				$(this).find('i').addClass('gift_current').attr('data-flow','yes');
				$(this).siblings().find('i').removeClass('gift_current').removeAttr('data-flow');
				document.GiftPayForm.GiftId.value = $(this).find('i').attr('GiftId');
			});
			$('#close-gift').click(function(){
				G.hide();
			});
		}
	}
	G.sent_gift();
	$(document).ready(function(){
	    //提交礼物赠送支付
		$('#send-mes').click(function(){
		    document.GiftPayForm.submit();
		});
	});
	</script>
	";
}
/********我收到的礼物弹出层********************************************************/
function my_gift(){
	$kehu = $GLOBALS['kehu'];
	$gift = mysql_fetch_assoc(mysql_query("select * from Gift "));
	$giftGiveNum = mysql_num_rows(mysql_query("select * from GiftGive where TargetId = '$kehu[khid]' "));
	$giftGive = mysql_query("select * from GiftGive where TargetId = '$kehu[khid]' ");
	$getGift = "";
	if($giftGiveNum == 0) {
		$getGift .= "你一件礼物都没有收到";
	}else{
		while($array = mysql_fetch_array($giftGive)){
			$client = mysql_fetch_array(mysql_query("select * from kehu where khid = '$array[khid]' "));
			$getGift .= "
			<div class='gift_content1'><img width='64px' src='{$GLOBALS['root']}".$gift['ico']."'>
				<p><a href='{$GLOBALS['root']}SearchMx.php?search_khid={$array['khid']}'>{$client['NickName']}</a></p>
			</div>";
		}
	}
	return "
	<div class='gift_zzc' id='bg-my-gift' style='display:none;'></div>
	<div class='gift' id='my-gift' style='display:none;'>
		<div class='gift_header'>
			<span>我收到的礼物</span>
			<i class='pop-up' id='close-my-gift' style='cursor:pointer;'></i>
		</div>
		<div class='gift_content' id='bg-my'>
			".$getGift."
		</div>
	</div>
	<script>
	var MG ={
		show:function(){
			$('#bg-my-gift').show();
			$('#my-gift').fadeIn(300);
		},
		hide:function(){
			$('#bg-my-gift').hide();
			$('#my-gift').hide();
		},
		sent_gift:function(){
			$('#close-my-gift').click(function(){
				MG.hide();
			});
		}
	}
	MG.sent_gift();
	</script>
	";
}
/********发信弹出层***************************************************************/
function letter($type = null,$ClientId){
	if($type == "receive"){
		$type_html ="
		<div class='gift_header'>
			<span>我收到的信</span>
			<i class='pop-up' id='close-let' style='cursor:pointer;'></i>
		</div>
		<div class='send_letter_content' style='padding:10px;' receiveId></div>
		<form name='messageReplyForm'>
			<textarea name='messageReplyText' class='send_letter_content' style='padding:10px;'></textarea>
			<input name='messageId' type='hidden' />
			<button type='button' class='pop-up_btn' id='sure-close' onClick=\"Sub('messageReplyForm','".root.'user/usData.php'."')\">点击回复</button>
		</form>
		";
	}else{
		$type_html ="
		<div class='gift_header'>
			<span>发信</span>
			<i class='pop-up' id='close-let' style='cursor:pointer;'></i>
		</div>
		<form name='sendLetterForm'>
			<div class='send_letter_content' style='padding:0;'>
				<textarea name='sendLetter' style='width: 435px;height: 150px; padding:10px;'></textarea>
            	<input name='TargetId' type='hidden' value='{$ClientId}' />
			</div>
			<a class='pop-up_btn' id='send-let' href='javascript:;' onClick=\"Sub('sendLetterForm','".root.'user/usData.php'."')\">点击发布</a>
		</form>
		";
	}
	return "
	<div class='gift_zzc' id='bg-let' style='display: none;'></div>
	<div class='gift' id='let-q' style='display: none;'>
	{$type_html}
	</div>
	<script>
	var LG ={
		show:function(){
			$('#bg-let').show();
			$('#let-q').fadeIn(300);
		},
		hide:function(){
			$('#bg-let').hide();
			$('#let-q').hide();
		},
		sent_gift:function(){
			$('#close-let').click(function(){
				LG.hide();
			});
		}
	}
	LG.sent_gift();
	</script>
	";
}
/********收信****************************************/
function receive_letter(){
	return "
	
	";
}
/********个人资料*********************************************/
function center(){
	$kehu = $GLOBALS['kehu'];
	$root = root;
	$messageNum = mysql_num_rows(mysql_query(" select * from message where TargetId = '$kehu[khid]' "));
	$giftNum = mysql_num_rows(mysql_query(" select * from GiftGive where TargetId = '$kehu[khid]' "));
	$enrollNum = mysql_num_rows(mysql_query(" select * from Enroll where khid = '$kehu[khid]' "));
	return "
	<div class='personal'>
		<img style='width:100px;' src='".HeadImg($kehu['sex'],$kehu['ico'])."'>
		<a class='upload_pictures_btn' href='javascript:;' onClick='document.headPortraitForm.headPortraitUpload.click()'>上传头像</a>
		<a class='edit_profile_btn' href='{$root}user/user.php' >编辑资料</a>
		<div class='personal_message'>
			<div class='personal_message_head'><h2 class='personal_title'>".kong($kehu['NickName'])."</h2><i class='personal_icon'></i></div>
			<div class='id_number'><span>我的等级：</span><span id='yellow'>".kong($kehu['Grade'])."</span></div>
		</div>
		<div class='function_tab_box'>
			<a class='function_tab' href='{$root}user/usLetter.php'><span class='function_tab_message'>{$messageNum}</span><div class='function_tab_text'>信件</div></a>
			<a class='function_tab function_tab_special' href='javascript:;'><span class='function_tab_message'>{$giftNum}</span><div class='function_tab_text' id='show-my-gift'>礼物</div></a>
			<a class='function_tab' href='{$root}Activity.php'><span class='function_tab_message'>{$enrollNum}</span><div class='function_tab_text'>活动</div></a>
		</div>
		</div>
<!--隐藏表单开始-->
<div class='hide'>
	<form name='headPortraitForm' action='{$root}user/usPost.php' method='post' enctype='multipart/form-data'>
		<input name='headPortraitUpload' type='file' onChange='document.headPortraitForm.submit()'>
	</form>
</div>
<!--隐藏表单结束-->
        ";
}
/********个人会员开通*********************************************/
function serve(){
	$kehu = $GLOBALS['kehu'];
	return "
	<div class='personal_service'>
		<h2>推荐服务</h2>
		<div class='personal_member'>
			<i class='personal_service_icon personal_service_icon01'></i>
			<span>银牌会员</span>
			 <a href='javascript:;' openId='2'>开通</a>
			 <p>相互关注动态,玫瑰赠送<br />人气排行榜,情书互动</p>
		</div>
		<div class='personal_member'>
			<i class='personal_service_icon personal_service_icon02'></i>
			<span>金牌会员</span>
			 <a href='javascript:;' openId='3'>开通</a>
			 <p>择偶意向<br />客服详细推荐</p>
		</div>
		<div class='personal_member'>
			<i class='personal_service_icon personal_service_icon03'></i>
			<span>钻石会员</span>
			 <a href='javascript:;' openId='4'>开通</a>
			 <p>可预约本站会员并可预约见面&nbsp;&nbsp;每月可以预约2次</p>
		</div>
		<div class='personal_member'>
			<i class='personal_service_icon personal_service_icon04'></i>
			<span>红娘会员</span>
			 <a href='javascript:;' openId='5'>开通</a>
			 <p>享有本站所有功能<br />每月可以预约4次</p>
		</div>
	</div>
	<div class='hide'>
		<form name='PayForm' action='".root."pay/alipayapi.php' method='post'>
			<input name='GradeNum' type='hidden'>
			<input name='type' type='hidden' value='会员升级'>
		</form>
	</div>
	<script>
	$(function() {
		//提升会员等级
		$('[openId]').click(function() {
			//自己当前的会员等级
			var GradeNum = ".UserGradeNum($kehu['Grade']).";
			//要提升的会员等级
			var clickNum = $(this).attr('openId');
			if(GradeNum >= clickNum) {
				warn('新开通的会员等级不能低于当前会员等级');
			}else{
				document.PayForm.GradeNum.value = clickNum;
				document.PayForm.submit();
			}
		})	
	})
	</script>
	";	
}
/***********会员等级数字化函数*******************************************************/
function UserGradeNum($Grade){
    if($Grade == "铜牌会员"){
		$num = 1;
	}elseif($Grade == "银牌会员"){
		$num = 2;
	}elseif($Grade == "金牌会员"){
		$num = 3;
	}elseif($Grade == "钻石会员"){
		$num = 4;
	}elseif($Grade == "红娘会员"){
		$num = 5;
	}else{
		$num = 0;
	}
	return $num;
}
?>