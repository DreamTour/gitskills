<?php
include "mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
limit($kehu);
$s = "select * from kehu where Auditing = '已通过' and khid != '$kehu[khid]' {$_SESSION['userSearch']['Sql']} order by rankingTop='是' desc,UpdateTime desc";
$sql = mysql_query($s);
$num = mysql_num_rows(mysql_query("select * from kehu where khid != '$kehu[khid]' {$_SESSION['userSearch']['Sql']}"));
/*************会员列表**********************************************/
$client = "";
if($num == 0){
	$client = "一条搜索都没有";
}else{
	while($array = mysql_fetch_array($sql)){
		$age = date("Y") - substr($array['Birthday'],0,4);
		$region = query("region","id = '$array[RegionId]' ");
		//检查是否已经关注过  如果已经关注打印已关注 把背景色，border调灰色
		$followNum = mysql_num_rows(mysql_query("select * from follow where type = '1' and khid = '$kehu[khid]' and TargetId = '$array[khid]' "));
		if($followNum > 0){
			$value = "取消关注";	
		}else{
			$value = "关注";
		}
		$client .= "
	<li class='search-list'>
    	<div class='search-top of'> 
            <a href='{$root}m/userDatum.php?search_khid={$array['khid']}'><img src='".HeadImg($array['sex'],$array['ico'])."' class='fl'></a>
            <div class='search-text fr'>
                <h5 class='fz14'><a href='{$root}m/userDatum.php?search_khid={$array['khid']}'>{$array['NickName']}</a></h5>
                <p class='search-message'>{$age}岁&nbsp;{$array['height']}cm&nbsp;沈阳{$region['area']}&nbsp;{$array['degree']}&nbsp;{$array['salary']}</p>
                <div class='search-mo'>
                    <span class='se-mo fw2 bg1'>内心独白</span>
                    <span class='mo-text'>{$array['summary']}</span>
                </div>
            </div>
        </div>
        <ul class='search-bottom'>
        	<li follow='{$array[khid]}'><i class='search-icon search-icon1'></i><span class='fz14'>{$value}</span></li>
            <li data-letter='{$array[khid]}'><i class='search-icon search-icon2'></i><span class='fz14'>发信</span></li>
        </ul>
    </li>
		";
	}
}
?>
<style>
body{position:relative;}
.hide{ display:none;}
.send-letter-bg,.send-letter{position:fixed;top:0;bottom:0;right:0;left:0;margin:auto;color:#fff;}
.send-letter-bg{background-color:rgba(0,0,0,.4);z-index:2;}
.send-letter{width:90%;height:50%;z-index:3;box-shadow:0 0 5px rgba(0, 0, 0, 0.5);}
.pop-top{background-color:#fd8eb9;}
.pop-top h5{padding:8px 0 8px 5px;}
.pop-icon{display:inline-block;width:12px;height:12px;background:url(<?php echo img("YgH55362469IL");?>)no-repeat scroll center/20px 20px;margin:9px 5px 0 0;}
.send-letter form{width:100%;height:100%;}
.send-letter textarea{margin:20px;height:60%;margin:5%;min-height:30%;width:90%;padding:10px;}
.pop-re-btn{display:block;width:25%;height:30px;line-height:30px;background-color:#f9a61c;text-align:center;border-radius:3px;margin-right:15px;}
</style>
<!--头部-->
<div class="header fz16">
<!--    <div class="head-center"><h3>搜索</h3></div>-->
    <div class="head-center"><a href="<?php echo $root?>m/mSearchMx.php" class="col1">条件搜索</a></div>
</div>
<!--内容-->
<ul class="search-content">
	<?php echo $client?>
</ul>
<div class="send-letter-bg hide"></div>
<div class="send-letter bg2 of hide">
	<div class="pop-top of"><h5 class="fl">发信</h5><i class="pop-icon fr"></i></div>
    <form name="sendLetterForm">
    	<textarea name="sendLetter"></textarea>
	    <input type="hidden" name="TargetId" value="" />
        <a href="javascript:;" class="pop-re-btn fr col1 fz14">点击发信</a> 
    </form>
</div>
<!--底部-->
<?php echo warn().mFooter();?>
<script>
$(function(){
	//记录谁关注我
	$("[follow]").click(function(){
		var follow = $(this).attr('follow');
		var _this = $(this);
		$.ajax({
			url: "<?php echo "{$root}library/usData.php";?>",
			async:false,
			data: {follow:follow},
			type:"POST",
			dataType:"json",
			success: function(data){
				warn(data.warn);
				if(data.flag == 2){
					_this.find('span').text('取消关注');
				}
				if(data.warn == "取消成功"){
					_this.find('span').text('关注');
				}
			},
			error: function(){
				alert('服务器错误');	
			}
		});
	})
	//发信
	$("[data-letter]").click(function(){
		var TargetId = $(this).attr('data-letter');
		$("[name=TargetId]").val(TargetId);
	})
	$(".pop-re-btn").click(function(e) {
        $.ajax({
			url: "<?php echo "{$root}library/usData.php";?>",
			async:false,
			data: $("[name=sendLetterForm]").serialize(),
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
    });		
	function fn(){
		this.eject();
		this.Close();	
	}
	fn.prototype = {
		show:function(){
			$('.send-letter-bg').show();
			$('.send-letter').show();
		},
		hide:function(){
			$('.send-letter-bg').hide();
			$('.send-letter').hide();	
		},
		eject:function(){
			self = this;
			$('[data-letter]').click(function(){
				self.show();
			})	
		},
		Close:function(){
			self = this;
			$('.pop-icon').click(function(){
				self.hide();	
			})	
		}	
	}
	new fn();	
})
</script>