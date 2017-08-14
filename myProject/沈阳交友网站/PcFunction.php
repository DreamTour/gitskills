<?php
/*********************引入库文件*********************/
#前端不用管
require_once dirname(__FILE__)."/OpenFunction.php";
/*-----------如果是移动设备，则跳转到手机网站首页--------------------------------------------------------------*/
if(isMobile()){
	if(strstr($_SERVER['PHP_SELF'],"user/usRegister.php") == true){
		if(!empty($_GET['tel'])){
		    $get = "?tel=".$_GET['tel'];
		}
		header("Location:".root."m/user/mUsRegister.php".$get);
	}else{
		header("Location:{$mroot}mindex.php");
	}
	exit(0);//必不可少，$warn在底部会被执行清理
}
/*******************网站头部******************************/
function pcHeader(){
	if($GLOBALS['KehuFinger'] == 2) {
		$login = "";
	} else{
		$login = "<div id='outLogin' class='login'><a href='{$GLOBALS['root']}user/usLogin.php?detele=yes'>退出登录</a></div>";
	}
	$pcHeader = "
	<div class='header'>
		<a class='logo' href='javascript:;'><img src='".img("EeZ53378297Yq")."'></a>
		<div class='tel_number'>
			<div class='tel_text'><i class='tel icon'></i>客服电话</div>
			<div class='number'>".website('w5we63sd')."</div>
		</div>
	</div>
	<div style='position: relative;width: 1000px;margin: 0 auto;'>
		<ul class='nav_bar of'>
			<li class='nav_pink fl'><a href='{$GLOBALS['root']}index.php' class='fz16 ".menu("index.php","fz16 col fw1")."'>首页</a></li>
			<li class='nav_pink fl'><a href='{$GLOBALS['root']}user/user.php' class='fz16 ".menu("user/user.php","fz16 col fw1")."'>个人中心</a></li>
			<li class='nav_pink fl'><a href='{$GLOBALS['root']}search.php' class='fz16 ".menu("search.php","fz16 col fw1")."'>搜索意中人</a></li>
			<li class='nav_pink fl'><a href='{$GLOBALS['root']}success.php' class='fz16 ".menu("success.php","fz16 col fw1")."'>牵手成功</a></li>
			<li class='nav_pink fl'><a href='{$GLOBALS['root']}activity.php' class='fz16 ".menu("activity.php","fz16 col fw1")."'>活动展示 </a></li>
			<li class='nav_pink fl'><a href='{$GLOBALS['root']}cooperation.php' class='fz16 ".menu("cooperation.php","fz16 col fw1")."'>商务合作</a></li>
			<li class='nav_pink fl'><a href='{$GLOBALS['root']}contact.php' class='fz16 ".menu("contact.php","fz16 col fw1")."'>联系我们</a></li>
		</ul>
		{$login}
	</div>
	<div class='line'></div>
	";	
	return $pcHeader;
}
/*******************网站底部******************************/
function pcFooter(){
	$root = $GLOBALS['root'];
	$word = query("content","type = '最新资讯' and xian = '显示' order by list");
	$pcFooter = "
	<div class='footer'>
			<div class='footer_title_box'>
			   <p class='footer_title'>扫一扫关注我们</p>
			</div>
			<div class='footer_content'>
				<div class='footer_content_top'>
					<div style='float:left;' class='footer_barcode'>
						<a href='javascript:;'>
                            <div class='footer_barcode_weibo'>
								<div class='weibo_barcode'>
									<img style='width:80px;height:80px;' src='".img("cIu57176512cH")."'>
								</div>
								<div class='weibo_text'>
									<h1>微博二维码</h1>
									<p>每时每刻掌握最新动态 随时随地查阅相亲信息</p>
								</div>	
                            </div>
                        </a>
						<a href='javascript:;'>
							<div class='footer_barcode_weixin'>
								<div class='weixin_barcode'>
									<img style='width:80px;height:80px;' src='".img("SrV52701840eN")."'>
								</div>
								<div class='weixin_text'>
									<h1>微信公众号</h1>
									<p>每时每刻掌握最新动态 随时随地查阅相亲信息</p>
								</div>	
							</div>
						</a>
					</div>
				</div>
				<div class='footer_content_bottom'>
					<div class='footer_content_box'>
						<a href='{$root}index.php'>首页</a>　<span>|</span>　
						<a href='{$root}user/user.php'>个人中心</a>　<span>|</span>　
						<a href='{$root}search.php'>搜索意中人</a>　<span>|</span>　
						<a href='{$root}success.php'>牵手成功</a>　<span>|</span>　
						<a href='{$root}activity.php'>活动展示</a>　<span>|</span>
						<a href='{$root}cooperation.php'>商务合作</a>　<span>|</span>
						<a href='{$root}contact.php'>联系我们</a>　<span>|</span>　
						<a href='{$root}help.php?id={$word['id']}'>最新资讯</a>
					</div>
					<p class='copyright'>".website('uisjue410q')."</p>
				</div>
			</div>
		</div>
	</div> 
	";
	return $pcFooter;
}
/*******显示送礼物弹出层*************************************************/
function send_gift(){
	$root = $GLOBALS['root'];
	$giftSql = mysql_query("SELECT * FROM Gift");
	$count = 1;
	$a = array();
	while($array = mysql_fetch_assoc($giftSql)){
		$IGiftID = " GiftId='{$array['id']}' ";
		if($count == 1) {
			$GiftIdOne = $array['id'];
			$html = "<i class='gift_current' data-price=\"{$array['price']}\" data-flow='yes' {$IGiftID}></i>";
		}else{
			$html = "<i {$IGiftID} data-price=\"{$array['price']}\"></i>";
		} 
		array_push($a,"<div class='gift_content1'><img style='width:64px;' src='{$GLOBALS['root']}{$array['ico']}'>{$html}</div>");
		$count++; 
	};
		return "
	<!--赠送礼物弹出层-->
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
				document.PayForm.GiftId.value = $(this).find('i').attr('GiftId');
			});
			$('#close-gift').click(function(){
				G.hide();
			});
		},
		getValue:function(){
			$('[name=PayForm] [name=GiftId]').val('{$GiftIdOne}'); 	
		}
	}
	G.sent_gift();
	$(function(){
		G.getValue();
	})
	
$(function(){	
	//支付弹出层
	function openGiftpay(){
		this.eject();
	}
	openGiftpay.prototype = {
		eject:function(){
			var _this = this;
			$('#send-mes').click(function(){
				_this.Show();
				var price = _this.giftPrice();
				$('[data-title]').html('赠送礼物');
				$('[data-money]').html('￥'+price);
				$('#bg-gift').hide();
				$('#gift').hide();
				$('[name=PayForm] [name=PayType]').val('赠送礼物'); 	
			})	
		},
		Show:function(){
			$('.popup-background').show();
			$('.popup-box').show();	
		},
		Hide:function(){
			$('.popup-background').hide();
			$('.popup-box').hide();
		},
		giftPrice:function(){
			var price = 0;
			$('[data-price]').each(function(index, element) {
				if($(this).hasClass('gift_current')){
					price=$(this).attr('data-price');
				}
			});		
			return price;
		}	
	}
	new openGiftpay();
})	
	</script>
	";
}
/********个人资料*********************************************/
function data(){
	$kehu = $GLOBALS['kehu'];
	$root = $GLOBALS['root'];
	$messageNum = mysql_num_rows(mysql_query("select * from message where TargetId = '$kehu[khid]' "));
	$giftNum = mysql_num_rows(mysql_query("select * from GiftGive where TargetId = '$kehu[khid]' "));
	$enrollNum = mysql_num_rows(mysql_query("select * from Enroll where khid = '$kehu[khid]' "));
	return "
		<div class='personal' style='position:relative;'>
				<img id='HeadImg' style='width:120px; height:150px;' src='".HeadImg($kehu['sex'],$kehu['ico'])."'>
				<div class='HeadImgCove' style='width:120px; height:150px;background:rgba(33,33,33,.5);position:absolute;top:20px;left:20px;color:#fff;text-align:center;line-height:150px;font-size:16px;cursor:pointer;z-index:2;display:none;' onClick='document.headPortraitForm.headPortraitUpload.click()'>上传头像</div>
            <div class='personal_message'>
                <div class='personal_message_head'><h2 class='personal_title'>".kong($kehu['NickName'])."</h2><i class='personal_icon'></i></div>
            </div>
            <div class='function_tab_box'>
                <a class='function_tab' href='{$root}user/usMessage.php'><span class='function_tab_message'>{$messageNum}</span><div class='function_tab_text'>信件</div></a>
                <a class='function_tab function_tab_special' href='javascript:;'><span class='function_tab_message'>{$giftNum}</span><div id='show-my-gift' class='function_tab_text'>礼物</div></a>
                <a class='function_tab' href='{$root}activity.php'><span class='function_tab_message'>{$enrollNum}</span><div class='function_tab_text'>活动</div></a>
            </div>
			<div class='center_btn_box'><a href='{$root}searchMx.php?search_khid={$kehu['khid']}' class='center_btn_user' type='button'>预览</a></div>
            <div class='look_box of'>
            	<a href='{$root}user/usSee.php' style='width:80px;border-right:1px solid #fff;'>谁看过我</a>
                <a href='{$root}user/usFollow.php' style='margin-left:5px;' follow>谁关注我</a>
            </div>
            </div>
            <!--推荐服务-->
            <!--<div class='personal_service'>

            	<div class='ps-line of'><p class='fl'></p><h2 class='fl'>推荐服务</h2></div>
                <div class='personal_member'>
                	<i class='personal_service_icon personal_service_icon01'></i>
                    <span>发信包月</span>
                     <a href='javascript:;' openId='1' data-price='".website('DDf52623284iE')."'>开通</a>
                     <p>当月免费发送所有信件</p>
                     <p>尊贵月会员标识</p>
                </div>
                <div class='personal_member'>
                	<i class='personal_service_icon personal_service_icon02'></i>
                    <span>发信包年</span>
                     <a href='javascript:;' openId='2' data-price='".website('zQl52623335uv')."'>开通</a>
                     <p>当年免费发送所有信件</p>
                     <p>尊贵年会员标识</p>
                </div>
                <div class='personal_member'>
                	<i class='personal_service_icon personal_service_icon03'></i>
                    <span>排名提前</span>
                     <a href='javascript:;' openId='3' data-price='".website('GCD52623356LP')."'>开通</a>
                     <p>个人资料优先展示</p>
                     <p>吸引更多异性关注</p>
                </div>
            </div>-->
            <!--推广链接-->
            <!--<div class='ad_link'>
            	<h2 class='fz16 col fw2'>邀请朋友就送免费发信</h2>
                <i class='link_icon'></i>
                <p></p>
                <a href='{$root}promotion.php' class='link_btn fz14'>立即邀请领取</a>
            </div>-->
        </div>
		<script>
			$(function(){
				var HeadImgCove = $('.HeadImgCove');
				$('#HeadImg').mouseenter(function(){
					HeadImgCove.show();	
				})
				HeadImgCove.mouseleave(function(){
					$(this).hide();	
				})
			})
		</script>
	".openPay();
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
				<p><a href='{$GLOBALS['root']}searchMx.php?search_khid={$array['khid']}'>{$client['NickName']}</a></p>
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
/********发信,阅读信件弹出层***************************************************************/
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
			<button type='button' class='pop-up_btn' id='sure-close' onClick=\"Sub('messageReplyForm','".root.'library/usData.php'."')\">点击回复</button>
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
			<a class='pop-up_btn' id='send-let' href='javascript:;' onClick=\"Sub('sendLetterForm','".root.'library/usData.php'."')\">点击发送</a>
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
/********服务中心***************************************************************/
function meet_love(){
	$service  = "
		<div class='meet_love'>
			<div class='meet_love_title'>
				<i class='meet_love_icon icon'></i>
				<h2>服务中心</h2>
			</div>
			<div class='meet_love_content'>
				<div class='shop_box'>
					<div class='shop'>
						<i class='shop_icon01 shop_icon icon'></i>
						<div class='shop_text'>
							 <a class='shop_text_title' href='javascript:;' openId='1' data-price='".website('DDf52623284iE')."'>发信包月>></a>
							 <div class='shop_text_content1'>
								<i class='shop_text_icon'></i>
								<span>当月免费发送所有信件</span>
							 </div>
							 <div class='shop_text_content'>
								<i class='shop_text_icon'></i>
								<span>尊贵月会员标识</span>
							 </div>
						</div>
					</div>
				</div>
				<div class='shop_box'>
					<div class='shop'>
						<i class='shop_icon02 shop_icon icon'></i>
						<div class='shop_text'>
							 <a class='shop_text_title' href='javascript:;' openId='2' data-price='".website('zQl52623335uv')."'>发信包年>></a>
							 <div class='shop_text_content1'>
								<i class='shop_text_icon'></i>
								<span>当年免费发送所有信件</span>
							 </div>
							 <div class='shop_text_content'>
								<i class='shop_text_icon'></i>
								<span>尊贵年会员标识</span>
							 </div>
						</div>
					</div>
				</div>
				<div class='shop_box'>
					<div class='shop' id='shop-special'>
						<i class='shop_icon03 shop_icon icon'></i>
						<div class='shop_text'>
							 <a class='shop_text_title' href='javascript:;' openId='3' data-price='".website('GCD52623356LP')."'>排名提前>></a>
							 <div class='shop_text_content1'>
								<i class='shop_text_icon'></i>
								<span>个人资料优先展示</span>
							 </div>
							 <div class='shop_text_content'>
								<i class='shop_text_icon'></i>
								<span>吸引更多异性关注</span>
							 </div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
	".openPay();
	return $service;	
}
function openPay(){
	$time = $GLOBALS['time'];
	$kehu = $GLOBALS['kehu'];
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
	$openPay = "
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
					if(attr == 1 && '{$payMonthValue}' != 'yes'){
						warn('你已经包月过了');
					}else if(attr == 2 && '{$payYearValue}' != 'yes'){
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
	";
	return $openPay;	
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
						<label><span role='radio' class='spanCheck' name='pay' paymentType='weChat'></span><span>微信</span></label>
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
		<form name='PayForm' action='{$root}alipay/alipayapi.php' method='post'>
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