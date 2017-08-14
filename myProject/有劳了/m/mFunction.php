<?php
require_once dirname(__FILE__)."/OpenFunction.php";
/*******************网站头部******************************/
function mHeader(){
	$root = $GLOBALS['root'];
	if($GLOBALS['KehuFinger'] == 2) {
		$login = "<a href='{$root}m/mSeller/mSeLogin.php'>企业登录</a>丨<a href='{$root}m/mUser/mUsLogin.php'>个人登录</a>";
	} else{
		$login = "<a id='outLogin' href='{$root}m/mindex.php?delete=client'>退出登录</a>";
	}
	$mHeader = "
		<header id='top'>
		<div class='index-top clearfix'>
			<a href='{$root}m/mindex.php'><img src='".img('oqX58150379Bb')."' class='fl'></a>
			<div class='fr login-box'>{$login}</div>
		</div>
		</header>
		<ul class='position-nav'>
			<li><a href='{$root}m/mindex.php'>首页</a></li>
			<li><a href='{$root}m/mJob.php' class='".menu("m/mJob.php","current")."'>优职</a></li>
			<li><a href='{$root}m/mTalent.php' class='".menu("m/mTalent.php","current")."'>优才</a></li>
			<li><a href='{$root}m/mPartTimeJob.php' class='".menu("m/mPartTimeJob.php","current")."'>学生兼职</a></li>
			<li><a href='{$root}m/mNews.php' class='".menu("m/mNews.php","current")."'>资讯</a></li>
		</ul>
	";	
	return $mHeader;
}
function mFooter(){
	$root = $GLOBALS['root'];
	$kehu = $GLOBALS['kehu'];
	//判断个人中心应该跳转的连接
	if ( $kehu['type'] == "个人" ) {
		$myUrl = root."m/mUser/mUser.php"; 
		$mUsIssue =  root."m/mUser/mUsIssue.php";
		$mSeCollect = root."m/mSeller/mSeCollect.php";
	}
	else if ( $kehu['type'] == "企业" ) {
		$myUrl = root."m/mSeller/mSeller.php";
		$mUsIssue =  root."m/mUser/mUsIssue.php";
		$mSeCollect = root."m/mSeller/mSeCollect.php";
	}else{
		$myUrl = "javascrit:;";
		$mUsIssue =  "javascrit:;";
		$mSeCollect = "javascrit:;";
		$js = "
		<script>
		$(function() {
			$('.myClick').click(function() {
				warn('请在网站右上角选择登陆');	
			})
		})
		</script>
		";
	}
	$mFooter = "
		<div class='index-footer fz14'>
			<a href='{$root}m/mindex.php' class='bottom-nav ".menu("m/mindex.php","current")."'>
				<i class='index-icon index-icon1 ".menu("m/mindex.php","index-icon6")."'></i><p>首页</p>
			</a>
			<a href='{$mUsIssue}' class='bottom-nav myClick ".menu($mUsIssue,"current")."'>
				<i class='index-icon index-icon2 ".menu($mUsIssue,"index-icon7")."'></i><p>发布</p>
			</a>
			<a href='{$myUrl}' class='bottom-nav myClick ".menu($myUrl,"current")."'>
				<i class='index-icon index-icon3 ".menu($myUrl,"index-icon8")."'></i><p>我的</p>
			</a>
			<a href='{$mSeCollect}' class='bottom-nav myClick ".menu($mSeCollect,"current")."'>
				<i class='index-icon index-icon4 ".menu($mSeCollect,"index-icon9")."'></i><p>收藏</p>
			</a>
			<a href='javascript:;' class='bottom-nav' id='attentionBtn'>
				<i class='index-icon index-icon5'></i><p>关注</p>
			</a>
		</div>
		<div id='attentionPopup'><img src='".img("EUL61841061Oa")."' id='attention'></div>
		</body>
		</html>	
		<script>
		window.onload=function(){
			var attentionBtn=document.getElementById('attentionBtn'),
				attentionPopup=document.getElementById('attentionPopup');
				attentionBtn.onclick=function(event){
					attentionPopup.style.display='block';
					event.stopPropagation(); 
				};
				document.onclick=function(){
					attentionPopup.style.display='none';
				};
		}
		</script>
	".$js;
	return $mFooter;
}
function mFormSubmit() {
	$root = $GLOBALS['root'];
	$mFormSubmit = "
		<script>
$(document).ready(function(){
	var Form = document.searchForm;
	//点击搜索图标提交表单
	$('#searchBtn').click(function(){
		$.post('{$root}library/mData.php',$('[name=searchForm]').serialize(),function(data){
			$('.po-content').html(data.html);
		},'json');	
	});
	$('#searchBtn').keypress(function(e){
		if(e.keyCode === 13) {
			alert(1);
		}
	})
	//当劳务主体发生改变的时候提交搜索表单
	Form.searchSubject.onchange = function(){
		$.post('{$root}library/mData.php',$('[name=searchForm]').serialize(),function(data){
			$('.po-content').html(data.html);
		},'json');	
	}
	
	//根据省份获取下属城市下拉菜单
	Form.province.onchange = function(){
		Form.area.innerHTML = \"<option value=''>--区县--</option>\";
		$.post('{$root}library/OpenData.php',{ProvincePostCity:this.value},function(data){
			Form.city.innerHTML = data.city;
		},'json');
		//当省份发生改变的时候提交搜索表单
		$.post('{$root}library/mData.php',$('[name=searchForm]').serialize(),function(data){
			$('.po-content').html(data.html);
		},'json');	
	}
	
	//根据省份和城市获取下属区域下拉菜单
	Form.city.onchange = function(){
		$.post('{$root}library/OpenData.php',{ProvincePostArea:Form.province.value,CityPostArea:this.value},function(data){
			Form.area.innerHTML = data.area;
		},'json');
		//当城市发生改变的时候提交搜索表单
		$.post('{$root}library/mData.php',$('[name=searchForm]').serialize(),function(data){
			$('.po-content').html(data.html);
		},'json');	
	}
	
	//当区县发生改变的时候提交搜索表单
	Form.area.onchange = function(){
		$.post('{$root}library/mData.php',$('[name=searchForm]').serialize(),function(data){
			$('.po-content').html(data.html);
		},'json');	
	}
	
	//搜索根据主项目返回子项目
	Form.searchColumn.onchange = function(){
		$.post('{$root}library/PcData.php',{searchColumnTwoChild:this.value},function(data){
			Form.searchColumnChild.innerHTML = data.ColumnChild;
		},'json');
		//当劳务主项目发生改变的时候提交搜索表单
		$.post('{$root}library/mData.php',$('[name=searchForm]').serialize(),function(data){
			$('.po-content').html(data.html);
		},'json');		
	}
	
	//当劳务子项目发生改变的时候提交搜索表单
	Form.searchColumnChild.onchange = function(){
		$.post('{$root}library/mData.php',$('[name=searchForm]').serialize(),function(data){
			$('.po-content').html(data.html);
		},'json');	
	}
});
</script>  
	";
	return $mFormSubmit;	
}
?>
