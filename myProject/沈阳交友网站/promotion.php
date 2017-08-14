<?php 
include "library/PcFunction.php";
echo head("pc");
UserRoot("pc");	
//查询分享的人数
$shareNumber = mysql_num_rows(mysql_query("select * from kehu where ShareId = '$kehu[khid]' "));
if($shareNumber % 5 == 0){
	$total_page = intval($shareNumber / 5);
}else{
	$total_page = intval($shareNumber / 5)+1;
}
?>
<style>
.icon{ background:url(<?php echo img("WxN53377734Xb");?>);}
.ad{width:1000px;height:90px;clear:both;margin:20px auto 15px}
.share_content{width:1000px;margin:20px auto}
.share-left{width:680px}
.share_line{width:3px;height:20px;background-color:#ff7c7c;margin:4px 3px 0 0}
.share_list{margin-bottom:20px}
.share_code,.share_list h5{font-size:20px}
.share_code{color:#ff7c7c}
.sp{width:680px;padding:15px;line-height:24px;border:1px solid #ddd;margin-top:15px}
.share_table{width:340px;text-align:center;border:1px solid #ddd}
.share_table dd,.share_table dt{line-height:40px}
.share_table dt{color:#fff;background-color:#ff7c7c;font-size:16px}
.share_table dd{font-size:14px;border-bottom:1px solid #ddd}
.share_table:last-child{border-left:none}
.share_table dd:last-child{border:none}
.meet_love{border:1px solid #d9d9d9}
.meet_love{width:280px;height:450px;float:right}
.meet_love_title{height:42px;line-height:42px;text-align:center;background-color:#f6f6f6}
.meet_love_icon{margin:9px 5px 0 18px;width:25px;height:25px;display:inline-block;float:left}
.meet_love_icon{background-position:-20px -199px}
.meet_love_title h2{float:left;font-size:16px;font-weight:700;color:#000}
.shop_box{height:126px}
.shop{width:250px;height:126px;border-bottom:1px dotted #d9d9d9;margin:0 15px;padding-top:30px}
.shop_icon{float:left;display:inline-block;width:65px;height:65px}
.shop_icon01{background-position:-90px -31px}
.shop_icon02{background-position:-90px -105px}
.shop_icon03{background-position:-90px -180px}
.shop_icon04{background-position:-90px -262px}
.shop_text{float:left;margin-left:15px}
.shop_text_title{font-size:14px;color:#f55173;text-decoration:underline;margin-bottom:12px}
.shop_text_content1{margin:10px 0 4px 0}
.shop_text_icon{width:0;height:0;border-top:5px solid transparent;border-bottom:5px solid transparent;border-left:5px solid #f55173;margin-right:2px}
#shop-special{border-bottom:none}

.tcdPageCode{padding: 15px 20px;text-align: left;color: #ccc;text-align:center;}
.tcdPageCode a{display: inline-block;color: #428bca;display: inline-block;height: 25px;	line-height: 25px;	padding: 0 10px;border: 1px solid #ddd;	margin: 0 2px;border-radius: 4px;vertical-align: middle;}
.tcdPageCode a:hover{text-decoration: none;border: 1px solid #428bca;}
.tcdPageCode span.current{display: inline-block;height: 25px;line-height: 25px;padding: 0 10px;margin: 0 2px;color: #fff;background-color: #428bca;	border: 1px solid #428bca;border-radius: 4px;vertical-align: middle;}
.tcdPageCode span.disabled{	display: inline-block;height: 25px;line-height: 25px;padding: 0 10px;margin: 0 2px;	color: #bfbfbf;background: #f2f2f2;border: 1px solid #bfbfbf;border-radius: 4px;vertical-align: middle;}
#text{width:90%;}
#copy{padding:5px;border-radius: 5px;}
</style>
<!--头部-->
<?php echo pcHeader();?>
   <!--顶部广告-->
   <div class="ad">
   	 <a href="javascript:;"><img src="<?php echo img("uiJ53377569IG");?>"></a>
   </div>
   <!--内容-->
   <div class="share_content of">
       <!--左边-->
       <ul class="share-left fl">
       		<li class="of share_list"><div class="fl share_line"></div><h5 class="fl fw2">我的分享码：</h5><span class="fl share_code"><?php echo $kehu['ShareCode'];?></span></li>
            <li class="of share_list"><div class="fl share_line"></div><h5 class="fl fw2">分享链接：</h5><p class="fl sp fz14"><input type="text" value="<?php echo "{$root}user/usRegister.php?ShareCode={$kehu['ShareCode']}";?>" id="text" /><input type="button" value="复制" id="copy"  /></p></li>
            <li class="of share_list"><div class="fl share_line"></div><h5 class="fl fw2">分享规则：</h5><p class="fl sp fz14">推荐一位身边的单身朋友加入本站并成功成为会员 您就可以获得免费发信的权利  成功一人奖励一天 没有上限 多劳多得 让更多的单身朋友加入进来吧
</p></li>
            <li class="of share_list"><div class="fl share_line"></div><h5 class="fl fw2">分享方式：</h5><p class="fl sp fz14">一：手机登录和电脑登录可以复制上面分享链接 发送给QQ好友 QQ群 论坛 贴吧等  对方点击后直接可以进入注册页面 系统可以自动填写好分享码<br />
二：手机登录可以点击本页面右上角分享到微信朋友圈和微信好友 对方点击后直接可以进入注册页面 系统可以自动填写好分享码
</p></li>
            <li class="of share_list"><div class="fl share_line"></div><h5 class="fl fw2">您已成功分享：<span class="share_code"><?php echo $shareNumber;?></span>人</h5></li>
            <li class="of share_list" id="list" style="height:246px;">
            <?php
			$json = share(1);
			echo $json['html1'].$json['html2'];
			?>
            </li>
            <li><div class="tcdPageCode"></div></li>
       </ul>
        <!--右侧帮你遇见爱-->
        <?php echo meet_love();?>
    </div>
<!--底部-->
<?php echo send_gift().warn().pcFooter();?>
</body>
<script>
	$(function(){
		//复制
		var text = document.getElementById('text');
		var btn = document.getElementById('copy');
		btn.onclick = function(){
			text.select();
			document.execCommand('copy');
		}
		//分页
		$(".tcdPageCode").createPage({
			pageCount:<?php echo $total_page;?>,
			current:1,
			backFn:function(p){
				$.getJSON('<?php echo $root;?>library/usData.php?act=share',{page:p},function(data){
					$("#list").html(data.html1+data.html2);
				});
			}
		});
	})
	var ms = {
		init:function(obj,args){
			return (function(){
				ms.fillHtml(obj,args);
				ms.bindEvent(obj,args);
			})();
		},
		//填充html
		fillHtml:function(obj,args){
			return (function(){
				obj.empty();
				//上一页
				if(args.current > 1){
					obj.append('<a href="javascript:;" class="prevPage">上一页</a>');
				}else{
					obj.remove('.prevPage');
					obj.append('<span class="disabled">上一页</span>');
				}
				//中间页码
				if(args.current != 1 && args.current >= 4 && args.pageCount != 4){
					obj.append('<a href="javascript:;" class="tcdNumber">'+1+'</a>');
				}
				if(args.current-2 > 2 && args.current <= args.pageCount && args.pageCount > 5){
					obj.append('<span>...</span>');
				}
				var start = args.current -2,end = args.current+2;
				if((start > 1 && args.current < 4)||args.current == 1){
					end++;
				}
				if(args.current > args.pageCount-4 && args.current >= args.pageCount){
					start--;
				}
				for (;start <= end; start++) {
					if(start <= args.pageCount && start >= 1){
						if(start != args.current){
							obj.append('<a href="javascript:;" class="tcdNumber">'+ start +'</a>');
						}else{
							obj.append('<span class="current">'+ start +'</span>');
						}
					}
				}
				if(args.current + 2 < args.pageCount - 1 && args.current >= 1 && args.pageCount > 5){
					obj.append('<span>...</span>');
				}
				if(args.current != args.pageCount && args.current < args.pageCount -2  && args.pageCount != 4){
					obj.append('<a href="javascript:;" class="tcdNumber">'+args.pageCount+'</a>');
				}
				//下一页
				if(args.current < args.pageCount){
					obj.append('<a href="javascript:;" class="nextPage">下一页</a>');
				}else{
					obj.remove('.nextPage');
					obj.append('<span class="disabled">下一页</span>');
				}
			})();
		},
		//绑定事件
		bindEvent:function(obj,args){
			return (function(){
				obj.on("click","a.tcdNumber",function(){
					var current = parseInt($(this).text());
					ms.fillHtml(obj,{"current":current,"pageCount":args.pageCount});
					if(typeof(args.backFn)=="function"){
						args.backFn(current);
					}
				});
				//上一页
				obj.on("click","a.prevPage",function(){
					var current = parseInt(obj.children("span.current").text());
					ms.fillHtml(obj,{"current":current-1,"pageCount":args.pageCount});
					if(typeof(args.backFn)=="function"){
						args.backFn(current-1);
					}
				});
				//下一页
				obj.on("click","a.nextPage",function(){
					var current = parseInt(obj.children("span.current").text());
					ms.fillHtml(obj,{"current":current+1,"pageCount":args.pageCount});
					if(typeof(args.backFn)=="function"){
						args.backFn(current+1);
					}
				});
			})();
		}
	}
	$.fn.createPage = function(options){
		var args = $.extend({
			pageCount : 15,
			current : 1,
			backFn : function(){}
		},options);
		ms.init(this,args);
	}
</script>
</html>
