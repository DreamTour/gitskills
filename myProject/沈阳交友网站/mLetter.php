<?php
include "mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
limit($kehu);
$sql = mysql_query(" select * from message where TargetId = '$kehu[khid]' order by time desc ");
$sqlNum = mysql_num_rows(mysql_query("select * from message where TargetId = '$kehu[khid]' "));
$letter = "";
if($sqlNum == 0){
	$letter .= "一个信件都没有";
}else{
	while($array = mysql_fetch_array($sql)){
		$client = query("kehu","khid = '$array[khid]'");
		$dataTime = date("Y-m-d",strtotime($client['UpdateTime']));
		$letter .= "
	<li class='message-item of' data-id={$array['id']}>
    	<a href='{$root}m/userDatum.php?search_khid={$array['khid']}'><img src='{$root}{$client['ico']}' class='fl'></a>
        <div class='message-text fr'>
        	<div class='message-title of'> 
                <h2 class='fl col2 fw2'>{$client['NickName']}</h2>
                <span class='fr'>{$dataTime}</span>
            </div>
            <p class='fz14'>{$array['text']}</p>
        </div>
		<a href='{$root}library/usPost.php?delectLetter={$array['id']}' class='read_btn'>删除</a>
    </li>
		";
	}
}
?>
<style>
.read_btn{float:right;font-size:14px;margin-top: 8px;}
body{position:relative;}
.hide{ display:none;}
.receive-letter-bg,.receive-letter{position:fixed;top:0;bottom:0;right:0;left:0;margin:auto;color:#fff;}
.receive-letter-bg{background-color:rgba(0,0,0,.4);z-index:2;}
.receive-letter{width:90%;height:80%;z-index:3;box-shadow:0 0 5px rgba(0, 0, 0, 0.5);}
.pop-top{background-color:#fd8eb9;}
.pop-top h5{padding:8px 0 8px 5px;}
.pop-icon{display:inline-block;width:12px;height:12px;background:url(<?php echo img("YgH55362469IL");?>)no-repeat scroll center/20px 20px;margin:9px 5px 0 0;}
.receive-letter form{width:100%;height:100%;}
.receive-letter .col,.receive-letter textarea{margin:20px;height:33%;margin:5%;width:
90%;padding:10px;}
.receive-letter .col{border:1px solid #ddd;}
.pop-re-btn{display:block;width:25%;height:30px;line-height:30px;background-color:#f9a61c;text-align:center;border-radius:3px;margin-right:15px;}
</style>
<!--头部-->
<div class="header fz16">
    <a href="<?php echo "{$root}m/user/mUsExtend.php";?>"><img src="<?php echo img("KKR54253637kM");?>"></a>
    <div class="head-center"><h3></h3></div>
</div>
<!--信息-->
<ul class="message-content">
	<?php echo $letter;?>
</ul>
<div class="receive-letter-bg hide"></div>
<div class="receive-letter bg2 of hide">
	<div class="pop-top of"><h5 class="fl">我收到的信</h5><i class="pop-icon fr"></i></div>
    <p class="col" receiveId>你好，很高兴认识你。</p>
    <form name="messageReplyForm">
    	<textarea name="messageReplyText"></textarea>
        <input name='messageId' type='hidden' value="" />
	    <a href="javascript:;" class="pop-re-btn fr col1 fz14">点击回复</a>
    </form>
    </div>
<!--底部-->
<?php echo warn().mFooter();?>
<script>
	$(function(){
		//我收到的信
		$('[data-id]').click(function(){
			var sendLetterId = $(this).attr('data-id');
			$.ajax({
				url:"<?php echo "{$root}library/usData.php";?>",
				data:{sendLetterId:sendLetterId},
				type:"POST",
				dataType:"json",
				success: function(data){
					if(data.warn == 2){
						//收到的信件
						$("[receiveId]").html(data.receive);
						//回复的信件的内容
						$("[name=messageReplyForm] [name=messageReplyText]").html(data.text);
						//当前信件的ID
						$("[name=messageReplyForm] [name=messageId]").val(data.id);	
					}else{
				    	warn(data.warn);
					}	
				},
				error: function(){
					alert('服务器错误');	
				}	
			});		
		})
		//点击回复
		$('.pop-re-btn').click(function(){
			$.ajax({
				url:"<?php echo "{$root}library/usData.php";?>",
				data:$("[name=messageReplyForm]").serialize(),
				type:"POST",
				dataType:"json",
				success: function(data){
					if(data.warn == 2){
						window.location.reload();
					}else{
				    	warn(data.warn);
					}	
				},
				error: function(){
					alert('服务器错误');	
				}	
			});		
		})
		//发信
		function fn(){
			this.eject();
			this.Close();	
		}
		fn.prototype = {
			show:function(){
				$('.receive-letter-bg').show();
				$('.receive-letter').show();	
			},
			hide:function(){
				$('.receive-letter-bg').hide();
				$('.receive-letter').hide();	
			},
			eject:function(){
				var self = this;
				$('.message-text').click(function(){
					self.show();	
				})
			},
			Close:function(){
				var self = this;
				$('.pop-icon').click(function(){
					self.hide();
				})	
			}	
		}	
		new fn();
	})
</script>
