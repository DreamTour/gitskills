<script>
		$(function(){
			//包年包月支付
			$('[openId]').click(function(){
				/*var attr = $(this).attr('openId');
				var paymentTrue = $(this).attr('paymentTrue');
				console.log($(this).attr('paymentTrue'));
				if(attr == 1 && '{$payMonthValue}' != 'yes'){
					warn('你已经包月过了');
				}else if(attr == 2 && '{$payYearValue}' != 'yes'){
					warn('你已经包年过了');
				}else if(paymentTrue == 'alipay'){
					$('[name=PayType]').val(attr);
					$('[name=letterPayForm]').submit();	
				}*/
				console.log(1111);
			})
			//支付弹出层
			function pay(){
				this.Close();
				this.choose();
				this.alipay();
				this.weChat();
			}
			pay.prototype = {
				attr:'',
				Show:function(){
					$('.popup-background').show();
					$('.popup-box').show();	
				},
				Hide:function(){
					$('.popup-background').hide();
					$('.popup-box').hide();
				},
				eject:function(fn){
					_this = this;
					$('[data-shade]').click(function(){
						_this.Show();
						_this.attr = $(this).attr('data-shade');
						$('[openId]').attr('openId',_this.attr);
						fn(_this.attr);
					})	
				},
				Close:function(){
					_this = this;
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
					this.eject(function(e){
						$('[paymentType=alipay]').click(function(){
							var html = \"<a href='javascript:;' class='popup-btn popup-btn0' role='button' openId='\"+e+\"' paymentTrue>确认支付</a>\";
							$('.popup-box__fd').html(html);	
							var paymentType = $(this).attr('paymentType');
							$('[paymentTrue]').attr('paymentTrue',paymentType);
						})
					})
				},
				weChat:function(){
					$('[paymentType=weChat]').click(function(){
						var url = 'http://www.lianaiwuyou.com/img/WebsiteImg/iqy54860462hr.jpg';
						var qr_code = '<img src='+url+' />';
						$('.popup-box__fd').html(qr_code);	
					})	
				}	
			}
			new pay();
		})
		</script>
		
		
		
		<?php
include "library/PcFunction.php";
echo head("pc");
?>
<style>
.disclaimer_box{
	background-color:#f6f6f6;
}
.disclaimer{
	width:670px;
	margin:auto;
	background-color:#fff;
	padding:50px 35px;
}
.disclaimer h2{
	font-size:16px;
	color:#000;
	margin: 40px 15px 20px 25px;
	line-height:200%;
	border-bottom:1px solid #ddd;
}
.disclaimer_content p{
	font-size: 14px;
    line-height: 160%;
    margin: 0 15px 10px 25px;
	color:#000;
}
<script>
 	var banner = function(a) {
		var a = a || {};
		var count = 0;
		var sorts = jQuery(a.sortItem);
		var lists = JQuery(a.listItem);
		var sortItem = sorts.find('li');
		var listItem = lists.find('li');
		var length = listItem.length;
for(var i = 0;i<length;i++){
sorts.append('<li></li>')
}
sorts.find('li:first').addClass('cur').siblings().removeClass('cur');
lists.width(sorts.width()*length);
var w = window;
lists.find('li').width(w.innerWidth);
lists.find('img').width(w.innerWidth);
lists.width(w.innerWidth*length);
var resize = functoiin
}
</script>

<!DOCTYPE html>
<html>
<head>
<title>婚礼汇 - 重庆纸飞机影像馆</title>
<meta charset='utf-8'>
<meta name='keywords' content='婚礼汇,119婚庆网,办婚礼,重庆婚礼酒店,重庆婚庆,婚礼租车'>
<meta name='description' content='婚礼汇（原119婚庆网）是一家专业的婚礼服务平台，为消费者提供最具影响力的婚礼服务：婚礼公司、婚礼酒店、婚礼摄像、婚礼策划、婚礼跟妆、婚礼租车等婚礼行业信息，实用的婚礼攻略与经验交流尽在婚礼汇。'>
<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
<meta name='renderer' content='webkit'>
<link rel='stylesheet' type='text/css' href='http://www.119hqw.com/library/pc.css?t=pcZ57108141zX'>
<script type='text/javascript' src='http://www.119hqw.com/library/jquery-1.11.2.min.js'></script>
<script type='text/javascript'>window.CONFIG={root:'http://www.119hqw.com/',title:'婚礼汇'};</script>
<script type='text/javascript' src='http://www.119hqw.com/library/pc.js?t=alh57108141NR'></script>
<link rel='Bookmark'  type='image/x-icon'  href='http://www.119hqw.com/favicon.ico'/>  
<link rel='icon'  type='image/x-icon' href='http://www.119hqw.com/favicon.ico' />  
<link rel='shortcut icon'  type='image/x-icon' href='http://www.119hqw.com/favicon.ico' />  
<link rel='apple-touch-icon' href='http://www.119hqw.com/favicon.ico'>
</head>
<body><link type='text/css' rel='stylesheet' href='http://www.119hqw.com/library/pcUser.css?t=Dax57108141lK'>
<div id='public-navbar'>
	<div class='layout_center layout_clear' style='overflow:visible'>
		<div class='layout_fl'> 你好，欢迎来到 婚礼汇 </div>
		<ul class='layout_fr fl_li'>
			<li>
				<div class='use-layout'>
					<a href='javascript:;'><span class='use-status'>会员中心</span></a>
					<div class='use-option' style='display:none'>
						<a href='http://www.119hqw.com/user/usLogin.php' class='use-item' target='_blank'>会员登录</a><a href='http://www.119hqw.com/user/usRegister.php' target='_blank'>免费注册</a>
					</div>
					<i class='use-arrow page_icon'></i>
				</div>
			</li>
			<li><span class='use-hr'></span></li>
			<li><a href='http://www.119hqw.com/user/usBuyCar.php'>我的购物车</a></li>
			<li><span class='use-hr'></span></li>
			<li>
			    <div class='use-layout'>
			        <a href='javascript:;'><span class='use-status'>商户平台</span></a>
			        <div class='use-option' style='display:none'>
						<a href='http://www.119hqw.com/seller/seLogin.php' class='use-item' target='_blank'>商户登录</a><a href='http://www.119hqw.com/seller/seApplyOne.php' target='_blank'>免费入驻</a>
					</div>
					<i class='use-arrow page_icon'></i>
			    </div>
			</li>
			<li><span class='use-hr'></span></li>
			<li><a href='http://www.119hqw.com/help.php?id=xgy55203732qb'>联系我们</a></li>
		</ul>
	</div>
</div>

	<!--公共搜索栏-->
	<div id='public-toolbar' class='hidden_active user_adjust_public'>
		<div class='layout_center layout_clear' style='overflow:visible'>
			<!--logo-->
			<div class='page-logo layout_fl'><a href='http://www.119hqw.com/'><img src='http://www.119hqw.com/img/WebsiteImg/rxT54692503vu.jpg'></a></div>
			<!--地址-->
			
			<!--搜索-->
			<div class='page-search layout_fl'>
				<div class='page-search-bar layout_clear'>
					<div class='page-search-text layout_fl'><select class='search-type'><option>产品</option><option>商家</option></select><input type='text' class='search-cover' placeholder='产品,店铺'></div>
					<div class='page-search-btn layout_fl'><input type='button' value='搜索' class='search-button'></div>
				</div>
				<ul class='page-search-key layout_clear fl_li'>
					<li class='search-key-ous'>大家都在搜：</li>
					<li><a href='javascript:;'>酒店</a></li>
					<li><a href='javascript:;'>婚纱</a></li>
					<li><a href='javascript:;'>婚车</a></li>
					<li><a href='javascript:;'>拍摄场地</a></li>
				</ul>
			</div>
			<!--发布-->
			
			<!--联系电话-->
			<div class='page-tels layout_fr'>
				<span class='tel-show'> 全国免费咨询热线 </span>
				<span class='tel-pink'><strong>023-6766-4541</strong></span>
			</div>
		</div>
	</div>
	<script>
		$(function(){
			$('.search-button').click(function(e){
				if($('.search-cover').val() == ''){
					base.success('\u8bf7\u8f93\u5165\u641c\u7d22\u5173\u952e\u5b57');
					return;
				}
				if($('.search-type').val() == '\u4ea7\u54c1'){
					window.location = 'Goods.php?keywords='+$('.search-cover').val();
				}else{
					window.location = 'storeList.php?keywords='+$('.search-cover').val();
				}
			});
		})
	</script>
	<style>
.curl { color: #ff5384 !important; }
.hasHover .shops-transdx-inset { max-height: 2000px!important }
</style>
<div id='page-middle-bar'>
	<div class='layout_center layout_clear'>
		<div class="button layout_fl"> 全部分类 </div>
				<ul class='layout_clear layout_fl fl_li'>
			<li><a href='http://www.119hqw.com/'>首页</a></li><li><a href='http://www.119hqw.com/Goods.php?TypeOne=j4174sq'>婚宴场地</a></li><li><a href='http://www.119hqw.com/Goods.php?TypeOne=j1457dqw'>婚纱摄影</a></li><li><a href='http://www.119hqw.com/Goods.php?TypeOne=g14dws'>婚庆用车</a></li><li><a href='http://www.119hqw.com/Goods.php?TypeOne=h14dq'>婚庆公司</a></li><li><a href='http://www.119hqw.com/Goods.php?TypeOne=h4214sq'>婚具租赁</a></li><li><a href='http://www.119hqw.com/Goods.php?TypeOne=f42lq'>定制人员</a></li><li><a href='http://www.119hqw.com/Goods.php?TypeOne=h49dqs'>婚品商城</a></li><li><a href='http://www.119hqw.com/Goods.php?TypeOne=nq34k'>蜜月度假</a></li>		</ul>
	</div>
</div>
<!--布局开始-->
<div id="page-shops">
	<div class="layout_center"> 
		<!--店铺详情-->
		<div id="shops-header" class="header layout_clear"> 
			<!--店铺logo-->
			<div class="shops-cover layout_fl"> <img src="http://www.119hqw.com//UpFile/user/20160628/20160628661702.jpg" /> </div>
			<!--店铺信息-->
			<div class="shops-deta layout_clear layout_fl"> 
				<!--//-->
				<div class="shops-info layout_fl">
					<h1 class="shops-info-name">重庆纸飞机影像馆</h1>
					<div class="shops-info-local"><i class="page_icon in-shop-local-icon"></i>重庆市渝中区石油路渝州新都5栋26-1</div>
					<ul class="shops-info-list">
											</ul>
				</div>
				<!--店铺参数-->
				<div class="shops-label layout_fl">
					<h4 class="shops-label-name">店铺：重庆纸飞机影像馆</h4>
					<div class="shops-label-param"> <span class="shops-label-item"> <span class="shops-label-up">描述</span> <span class="shops-label-down">4.8</span> </span> <span class="shops-label-item"> <span class="shops-label-up">服务</span> <span class="shops-label-down">5.8</span> </span> <span class="shops-label-item"> <span class="shops-label-up">保障</span> <span class="shops-label-down">4.8</span> </span> </div>
					<a href="javascript:;" class="shops-btn shops-btn0" data-seid="{CollectSeid:'rTT56077566jU'}">收藏店铺</a> <a href="javascript:;" class="shops-btn shops-btn1">联系客服</a> </div>
				<!--end--> 
			</div>
		</div>
		<!--店铺产品-->
		<div id="shops-section" class="content">
			<div class="shops-grids" >
				<div class="shops-grids-hd layout_clear"> 
					<!--<a href="javascript:;" class="layout_fr">全部套餐<i class="page_icon in-shop-arrow"></i></a>--></div>
							</div>
			<!--婚宴场地-->
			<div class="shops-grids">
								
				<!--排序--> 
				
			</div>
			<!--酒店介绍-->
			<div class="shops-grids">
				<div class="shops-grids-hd">
					<h1 class="shops-grids-h1">商家信息</h1>
				</div>
				<!--排序-->
				<div class="shops-gdx-wrap">
					<div class="shops-gdx-transdx">
						<div class="shops-transdx-map" id="allmap"></div>
						<div class="shops-transdx-data">
							<div class="shops-transdx-table">
								<ul>
																</ul>
							</div>
							<div class="shops-transdx-text">
								<div class="shops-transdx-inset"> <span style="font-family:arial, 宋体;color:#4b4b4b;font-size: 14px; line-height: 28px;">我们不只是用相机拍照。我们带到摄影中去的是所有我们读过的书，看过的电影，听过的音乐，爱过的人。</span> </div>
								<span class="drapdown" title='展开'></span> </div>
						</div>
					</div>
				</div>
			</div>
			<script type='text/javascript' src='http://api.map.baidu.com/api?v=2.0&ak=yaMnqGiWDKzftga34qkznzCydHNs2H52'></script>
			<script type="text/javascript">
				var map = new BMap.Map("allmap");        
				var point = new BMap.Point(0,0); 
				map.centerAndZoom(point, 18);
				MorePoint(0,0,50,'重庆市渝中区石油路渝州新都5栋26-1'); 
				function MorePoint(longitude,latitude,grade,word){
					var point = new BMap.Point(longitude,latitude);
					var myIcon = new BMap.Icon("http://www.119hqw.com/img/WebsiteImg/wes55386485sm.jpg", new BMap.Size(48,60), {offset: new BMap.Size(60,60),imageOffset: new BMap.Size(8,22)});  
					var marker = new BMap.Marker(point,{icon:myIcon});
					var infoWindow = new BMap.InfoWindow(word);
					map.addOverlay(marker);
					marker.openInfoWindow(infoWindow);
				}
				function zoom() { 
					this.defaultAnchor = BMAP_ANCHOR_BOTTOM_RIGHT;
					this.defaultOffset = new BMap.Size(10, 10);
				}   
				zoom.prototype = new BMap.Control();
				zoom.prototype.initialize = function (map) {
					var img_div = document.createElement("div");
					var img_minus = document.createElement("img");
					img_minus.style.cssText = "cursor:pointer;display: inline-block;float: left;";
					img_minus.setAttribute("src", "http://www.119hqw.com/img/WebsiteImg/JVL56398970QP.jpg");
					img_minus.onclick = function () {
						map.zoomTo(map.getZoom() - 1);
					}
					var img_plus = document.createElement("img");
					img_plus.style.cssText = "cursor:pointer;display: inline-block;";
					img_plus.setAttribute("src", "http://www.119hqw.com/img/WebsiteImg/mzH56398976tq.jpg");
					img_plus.onclick = function () {
						map.zoomTo(map.getZoom() + 1);
					}
					img_div.appendChild(img_plus);
					img_div.appendChild(img_minus);
					map.getContainer().appendChild(img_div);
					return img_div;
				}
				var zoo = new zoom();
				map.addControl(zoo);  
			</script>
			
					<div class='shops-grids'>
					<div class='shops-grids-hd layout_clear'>
						<h1 class='shops-grids-h1 layout_fl'>精选套餐</h1>
						<ul class='shops-grids-hlist layout_fl'>
							<li><a href='javascript:;' class='curl' data-num='1' data-store-type='yJr56592974sJ'>热门推荐</a></li>
						</ul>
						<a href='http://www.119hqw.com/storeGoods.php?seid=rTT56077566jU&store_type_id=yJr56592974sJ' class='layout_fr'>更多商品<i class='page_icon in-shop-arrow'></i></a></div>
					<!--产品筛选-->
					<div class='shops-grids-inset'>
						<ul class='shops-inset-set layout_clear fl_li'>
							<li class='shops-inset-into'>综合排序</li>
							<li><a href='javascript:;'>销量<i class='page_icon in-shop-scre-icon0'></i></a></li>
							<li><a href='javascript:;'>收藏<i class='page_icon in-shop-scre-icon0'></i></a></li>
							<li><a href='javascript:;'>新品<i class='page_icon in-shop-scre-icon0'></i></a></li>
							<li><a href='javascript:;'>价格<i class='page_icon in-shop-scre-icon0'></i></a></li>
						</ul>
					</div>
					<!--排序-->
					<div class='shops-gdx-wrap'>
						<ul class='shops-gdx-list2 layout_clear fl_li' data-region='1'>
									<li>
									<a href='http://www.119hqw.com/GoodsMx.php?goodsid=sww56077566zj'>
										<div>
											<div class='gdx-img'><img src='http://www.119hqw.com//UpFile/user/20160507/20160507925768.jpg' style='width: 100%;' /></div>
											<div class='gdx-data'>
												<div class='gdx-name'>旅拍套餐</div>
												<div class='gdx-price'><span class='price-strong'>￥4880.00</span><!--<span class='price-text'>原价<span class='price-through'>$8999</span></span>--></div>
												<div class='gdx-label'>
													<p class='label-line'><span>产品摘要：</span>旅拍套餐,重庆纸飞机影像馆</p>
													<p class='label-line'><span>销量：</span>0</p>
												</div>
											</div>
										</div>
									</a>
									</li>
									
									<li>
									<a href='http://www.119hqw.com/GoodsMx.php?goodsid=fsm56077566Ed'>
										<div>
											<div class='gdx-img'><img src='http://www.119hqw.com//UpFile/user/20160507/20160507602732.jpg' style='width: 100%;' /></div>
											<div class='gdx-data'>
												<div class='gdx-name'>姐妹照</div>
												<div class='gdx-price'><span class='price-strong'>￥1000.00</span><!--<span class='price-text'>原价<span class='price-through'>$8999</span></span>--></div>
												<div class='gdx-label'>
													<p class='label-line'><span>产品摘要：</span>姐妹照,重庆纸飞机影像馆</p>
													<p class='label-line'><span>销量：</span>0</p>
												</div>
											</div>
										</div>
									</a>
									</li>
									</ul>
					</div>
				</div>
								<!--案例欣赏-->
						<div class="shops-grids">
				<div class="shops-grids-hd layout_clear" style="margin-bottom:0;">
					<h1 class="shops-grids-h1 layout_fl">案例欣赏</h1>
					<a href="http://www.119hqw.com/storeCase.php?seid=rTT56077566jU" class="layout_fr">全部图片<i class="page_icon in-shop-arrow"></i></a></div>
					<ul class="shops-case">
					
						<li>
							<div class='shops-case-box'>
								<div class='shops-case-cover' title='点击查看' data-imglength='15' data-imagelist='http://www.119hqw.com//UpFile/user/20160628/20160629061166.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628570600.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628549178.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628482217.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628960426.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628393238.jpg||http://www.119hqw.com//UpFile/user/20160628/20160629144429.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628836236.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628891745.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628580997.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628750189.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628269099.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628771286.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628623302.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628935645.jpg' data-imagename='我知道这里有风'><div><img src='http://www.119hqw.com//UpFile/user/20160628/20160629061166.jpg'><span class='shops-case-lab'>15张</span></div></div>
								<div class='shops-case-slide'>
									<ul class='displace-wrapper' style='width:1950px'>
										<li><img src='http://www.119hqw.com//UpFile/user/20160628/20160629061166.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628570600.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628549178.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628482217.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628960426.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628393238.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160629144429.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628836236.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628891745.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628580997.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628750189.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628269099.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628771286.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628623302.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628935645.jpg'></li>
									</ul>
									<a href='javascript:;' class='abtn aleft page_icon'></a>
									<a href='javascript:;' class='abtn aright page_icon'></a>
								</div>
							</div>
						</li>
						
						<li>
							<div class='shops-case-box'>
								<div class='shops-case-cover' title='点击查看' data-imglength='12' data-imagelist='http://www.119hqw.com//UpFile/user/20160507/20160507779412.jpg||http://www.119hqw.com//UpFile/user/20160507/20160508084671.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628838145.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628525895.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628649822.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628387029.jpg||http://www.119hqw.com//UpFile/user/20160628/20160629087134.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628785890.jpg||http://www.119hqw.com//UpFile/user/20160628/20160629140035.jpg||http://www.119hqw.com//UpFile/user/20160628/20160629133443.jpg||http://www.119hqw.com//UpFile/user/20160628/20160629114138.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628453970.jpg' data-imagename='in a field'><div><img src='http://www.119hqw.com//UpFile/user/20160507/20160507779412.jpg'><span class='shops-case-lab'>12张</span></div></div>
								<div class='shops-case-slide'>
									<ul class='displace-wrapper' style='width:1560px'>
										<li><img src='http://www.119hqw.com//UpFile/user/20160507/20160507779412.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160507/20160508084671.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628838145.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628525895.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628649822.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628387029.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160629087134.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628785890.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160629140035.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160629133443.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160629114138.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628453970.jpg'></li>
									</ul>
									<a href='javascript:;' class='abtn aleft page_icon'></a>
									<a href='javascript:;' class='abtn aright page_icon'></a>
								</div>
							</div>
						</li>
						
						<li>
							<div class='shops-case-box'>
								<div class='shops-case-cover' title='点击查看' data-imglength='13' data-imagelist='http://www.119hqw.com//UpFile/user/20160628/20160629041812.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628393778.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628832986.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628811166.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628796501.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628910294.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628422393.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628787307.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628854546.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628420067.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628312047.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628849884.jpg||http://www.119hqw.com//UpFile/user/20160628/20160628306833.jpg' data-imagename='林间'><div><img src='http://www.119hqw.com//UpFile/user/20160628/20160629041812.jpg'><span class='shops-case-lab'>13张</span></div></div>
								<div class='shops-case-slide'>
									<ul class='displace-wrapper' style='width:1690px'>
										<li><img src='http://www.119hqw.com//UpFile/user/20160628/20160629041812.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628393778.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628832986.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628811166.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628796501.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628910294.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628422393.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628787307.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628854546.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628420067.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628312047.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628849884.jpg'></li><li><img src='http://www.119hqw.com//UpFile/user/20160628/20160628306833.jpg'></li>
									</ul>
									<a href='javascript:;' class='abtn aleft page_icon'></a>
									<a href='javascript:;' class='abtn aright page_icon'></a>
								</div>
							</div>
						</li>
											</ul>
			</div>
						<!--视频展示-->
						<!--店铺点评-->
			<div class="shops-grids">
				<div class="shops-speak layout_clear">
					<div class="shops-speak-label layout_fl">会员点评</div>
					<a href="http://www.119hqw.com/storeComment.php?seid=rTT56077566jU" class="layout_fr">全部点评<i class="page_icon in-shop-arrow" style="top:14px;"></i></a> </div>
				<div class="shops-speak-area">
					<ul class="cmts-wrapper" id="getHTML">
										</ul>
					<div class="cmts-more"><a href="http://www.119hqw.com/storeComment.php?seid=rTT56077566jU">查看更多</a></div>
					<div class="cmts-btn" style="height: 33px;"> <span></span> <a href="http://www.119hqw.com/storeComment.php?seid=rTT56077566jU#edit">我要评论</a> </div>
				</div>
			</div>
		</div>
		<!--<div id="fd" class="footer"></div>--> 
		<!--////--------->
		<div style="height:0"><!--代码结束--></div>
	</div>
</div>
<!--相册幻灯片-->
<div id="backdrop" style="display:none"></div>
<div id="photoWrapper" onContextmenu="return false" style="display:none">
	<div id="photoAlbum">
		<div class="btnClose" data-ctrl-btn="close" title="关闭"></div>
		<div class="btnLeft" data-ctrl-btn="prev" title="上一张"></div>
		<div class="btnRight" data-ctrl-btn="next" title="下一张"></div>
		<div class="photoContainer">
			<div class="photoShow"></div>
		</div>
		<div class="infoBar">
			<div class="info"><span class="count"><span class="count-cur" data-photo-index="0"></span>/<span class="count-all" data-photo-index="0"></span></span><span class="title" data-photo-name="undefined">聚缘厅</span></div>
			<div class="previewBar">
				<div class="previewContainer">
					<ul class="navContainer">
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--相册幻灯片--> 
<script type="text/javascript">
$(document).ready(function(e) {		
		var insetBanner = $('.shops-slide');//设置轮播图
		insetBanner.slides({preload: true,play: 5000,pause: 2500,hoverPause: true});
		insetBanner.hover(function(){//鼠标hover 处理
				$(this).children('.slider-button').show();
		},function(){
				$(this).children('.slider-button').hide();
		});
		/////////////		
		var xscroll_btn = $('.abtn');
		var xscroll_box = $('.shops-case-box');
		var xscroll_imagelist = $('.displace-wrapper');
		var xscroll_slide = $(".shops-case-slide");
		var xscroll_imagesrc = '';
	 	xscroll_btn.hide();
	 	xscroll_box.hover(function(){//鼠标hover 处理
			$(this).find('.abtn').show()
	 	},function(){
			$(this).find('.abtn').hide();
	 	});
		xscroll_imagelist.children('li').click(function(){//点击读取图片
			xscroll_imagesrc = $(this).find('img').attr('src');
			$(this).parent().parent().prev().find('img').attr('src',xscroll_imagesrc)
		});
		xscroll_slide.xslider({unitdisplayed:3,movelength:1,unitlen:130});//设置横屏滚动
		/////////////		
		$("[data-num]").click(function(e){
			var _this = $(this);
			var $num = _this.attr('data-num');
			var $TypeId = _this.attr('data-store-type');
			$.getJSON(CONFIG.root + 'library/PcData.php?action=get_store_type',{TypeId:$TypeId,num:$num,seid:"rTT56077566jU"},function(data){
				if(data.flag == 2){
					$("[data-region="+$num+"]").html(data.html);
					_this.addClass('curl');
					_this.parent('li').siblings().find('a').removeClass('curl')
				}
			});
		});
		/////////////
		var photoWrapper = $('#photoWrapper');
		var photoMask = $('#backdrop');
		var photoShow = $('.shops-trans-cover,.shops-case-cover');
		var photoClose = $('.btnClose');
		var domElement = $('body');
		var domWrapper = $(window);
		var displace = $('.displace-wrapper');
		var trandxText = $('.shops-transdx-text');
		var trandxInset = $('.shops-transdx-inset');
		var trandxDrap = $('.drapdown');
		
		photoShow.click(function() {
			if(!$(this).attr('data-imagelist')){//data为空时,阻止弹出.
				return;
			};
			photoMask.show();
			photoWrapper.fadeIn(320);
			domElement.css({height:domWrapper.height,overflow:'hidden',position:'relative'})
			new photoAlbum(
			{
				target: this//传递一个要打开的相册对象
			}, {//设置相册所有dom元素参数
				container: "#photoAlbum",
				photoContainer: "#photoAlbum .photoContainer",
				prevButton: "#photoAlbum .btnLeft",
				nextButton: "#photoAlbum .btnRight",
				photoToolbar: "#photoAlbum .infoBar",
				photoImage: "#photoAlbum .photoShow",
				photoImageList: "#photoAlbum .navContainer",
				curImgNum: "#photoAlbum .count-cur",
				allImgNum: "#photoAlbum .count-all",
				photoName: "#photoAlbum .title",
			});
		});
		photoClose.click(function() {//关闭相册
			photoWrapper.hide();
			photoMask.fadeOut(320);
			domElement.css({height:'auto',overflow:'auto',position:'initial'})
		});
		if(trandxInset.height() < 120){//当"trandxInset"可视区高度低于120 隐藏"trandxDrap" || 阻止hover
			trandxDrap.hide();
			return;
		};
		trandxText.hover(function(){//鼠标hover 处理
			if( $(this).hasClass('hasHover') ){
					$(this).removeClass('hasHover')
					trandxDrap.show();
			}else{
					$(this).addClass('hasHover')
					trandxDrap.hide();
			}	
		})
});
</script> 
<script type="text/javascript">base.url();</script> 
<div class='page-footer'>
	<div class='layout_center'>
		<div class='footer-list'>
		    <dl class='footer-item'><h3>新手上路</h3><a href='http://www.119hqw.com/help.php?id=cIN55127168wm'><dd><b></b>如何注册</dd></a><a href='http://www.119hqw.com/help.php?id=Pis56501135Cg'><dd><b></b>如何登录</dd></a><a href='http://www.119hqw.com/help.php?id=NWK56501170FJ'><dd><b></b>如何预订</dd></a><a href='http://www.119hqw.com/help.php?id=lBp56501200KD'><dd><b></b>购物流程</dd></a><a href='http://www.119hqw.com/help.php?id=rGg56501231Jp'><dd><b></b>预订须知</dd></a></dl><dl class='footer-item'><h3>公司信息</h3><a href='http://www.119hqw.com/help.php?id=xgy55203732qb'><dd><b></b>关于我们</dd></a><a href='http://www.119hqw.com/help.php?id=LJC56499197Ly'><dd><b></b>用户协议</dd></a><a href='http://www.119hqw.com/help.php?id=agb56499684Cc'><dd><b></b>隐私声明</dd></a><a href='http://www.119hqw.com/help.php?id=Fcg56499767rt'><dd><b></b>商家入驻协议</dd></a><a href='http://www.119hqw.com/help.php?id=PZq56499802Zo'><dd><b></b>安全需知</dd></a></dl><dl class='footer-item'><h3>合作联系</h3><a href='http://www.119hqw.com/help.php?id=mHc55203779fl'><dd><b></b>联系我们</dd></a><a href='http://www.119hqw.com/help.php?id=aNJ56501338io'><dd><b></b>招商加盟</dd></a><a href='http://www.119hqw.com/help.php?id=Dnc56501454WB'><dd><b></b>商户平台</dd></a><a href='http://www.119hqw.com/help.php?id=bTx56501486Hi'><dd><b></b>招聘信息</dd></a></dl><dl class='footer-item'><h3>帮助中心</h3><a href='http://www.119hqw.com/help.php?id=zUS55203881ck'><dd><b></b>忘记密码</dd></a><a href='http://www.119hqw.com/help.php?id=QPV56501556Ks'><dd><b></b>常见问题</dd></a><a href='http://www.119hqw.com/help.php?id=Gxf56501579ft'><dd><b></b>在线客服</dd></a><a href='http://www.119hqw.com/help.php?id=pZO56501605oF'><dd><b></b>如何上传产品</dd></a><a href='http://www.119hqw.com/help.php?id=pqc56501684ha'><dd><b></b>如何成为商家</dd></a></dl>
			<div class='footer-mobile'>
				<img src='http://www.119hqw.com/img/WebsiteImg/QzF55116022Vw.jpg'>
				<h2>移动端</h2>
			</div>
		</div>
		<!--认证-->
		<div class='footer-data0' oncontextmenu='return false;'>
			<a href='javascript:;'><i class='footer-ad0' title='可信网站身份验证'></i></a><a href='javascript:;'><i class='footer-ad1' title='重庆网警备案'></i></a><a href='javascript:;'><i class='footer-ad2' title='重庆工商行政管理'></i></a><a href='javascript:;'><i class='footer-ad3' title='安全联盟认证'></i></a>
		</div>
		<!--友情链接-->
		<div class='footer-data1'>友情链接：<a href='https://www.baidu.com/' target="_blank">百度</a><em>|</em><a href='https://www.taobao.com/' target="_blank">淘宝</a></div>
		<!--copy-->
		<div class='footer-data2'>
			 CopyRight 2016 婚礼汇 All Rights Reserved <a href='javascript:;'>渝ICP备14001673号</a>
		</div>
	</div>
</div>
<!--end-->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?dc0f6125fd030c01ce68aba6f2c54b9f";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>
	 
