<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<div class="activity_content" id="activity-one">
                    <div class="activity_content01">
                    	<h1>【成都市】百合花漾秋恋-遇见奇妙的爱情</h1>
                        <div class="activity_content_body">
                        	<img src="<?php echo img("IXZ49933118lV");?>">
                        	<div class="activity_body_introduce">
                                <p>百合寓意浪漫，玫瑰代表爱情；当百合与玫瑰共同绽放，象征着百年好合的爱情；漫步于花海之中，将我们的爱意和浪漫一同绽放。百合寓意浪漫，玫瑰代表爱情；当百合与玫瑰共同绽放，象征着百年好合的爱情</p>
                                <div class="activity_time"><i class="activity_icon activity_icon01"></i><span>2016-09-24</span><span>14:00~17:00</span></div>
                                <div class="activity_place"><i class="activity_icon activity_icon02"></i><span>四川省成都市锦江区忠烈祠东街15号</span></div>
                                <div class="sign_up ">已报名<a href="javascript:;">193</a>人</div>
                            </div>
                        </div>
                    </div> 
               </div>
</body>
</html>

            	<a href="<?php echo root."user/user.php?type=basicData";?>" class="<?php echo MenuGet("type","basicData","current");?>" data-num='1'>基本资料</a>
                <a href="<?php echo root."user/user.php?type=myAlbum";?>" class="<?php echo MenuGet("type","myAlbum","current");?>" data-num='2'>我的相册</a>
                <a href="<?php echo root."user/user.php?type=InnerMonologue";?>" class="<?php echo MenuGet("type","InnerMonologue","current");?>" data-num='3'>内心独白</a>
                <a href="<?php echo root."user/user.php?type=spouseIntention";?>" class="<?php echo MenuGet("type","spouseIntention","current");?>" data-num='4'>择偶意向</a>

/*-----------------编辑用户择偶意向---------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['spouseAge']) and isset($_POST['area'])){
	//赋值
	$spAge = $_POST['spouseAge'];//年龄
	$spHeight = $_POST['spouseHeight'];//身高
	$spDegree = $_POST['spouseDegree'];//学历
	$spNation = $_POST['spouseNation'];//民族
	$spOccupation = $_POST['userOccupation'];//职业
	$spMarry = $_POST['spouseMarry'];//婚姻状况
	$spRegionId = $_POST['area'];//所在区县ID号
	$spSalary = $_POST['spouseSalary'];//月收入
	$spBuyHouse = $_POST['spouseBuyHouse'];//购房情况
	$spBuyCar = $_POST['spouseBuyCar'];//购车情况
	//判断
	if(empty($spAge)){
	    $json['warn'] = "昵称不能为空";
	}else{
		$bool = mysql_query(" update kehu set 
		NickName = '$usNickName',
		sex = '$usSex',
		khtel = '$usTel',
		UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool){
		    $_SESSION['warn'] = "择偶意向更新成功";
			$json['warn'] = 2;
		}else{
			$json['warn'] = "择偶意向更新失败";
		}
	}
}

$ThisUrl = root."user/user.php";
if(isset($_GET['type'])){
	if($_GET['type'] == "basicData"){
		$and = " and classify = '基本资料' ";	
		$ThisUrl .= "?type=basicData";
	}elseif($_GET['type'] == "myAlbum"){
		$and = " and classify = '我的相册' ";	
		$ThisUrl .= "?type=myAlbum";
	}elseif($_GET['type'] == "InnerMonologue"){
		$and = " and classify = '内心独白' ";	
		$ThisUrl .= "?type=InnerMonologue";
	}elseif($_GET['type'] == "spouseIntention"){
		$and = " and classify = '择偶意向' ";	
		$ThisUrl .= "?type=spouseIntention";
	}else{
		$and = " and classify = '基本资料' ";	
		$ThisUrl .= "?type=basicData";
	} 
}else{
	header("location:{$ThisUrl}?type=basicData");
	exit(0);
}


onClick="window.post.file.click()"

<div class="content01_box">
                    	<div class="content01">
                            <a class="photo" href='http://www.yumukeji.com/project/xiangyuepanzhou/SearchMx.php'>
                            	<img src="<?php echo img("enR49861171VT");?>">
                            </a>
                            <h2>时光不老</h2>
                            <div class="content_text">
                                <span>28岁</span><span>上海</span><span>闽行区</span>
                            </div>
                            <a class="say_hi" href="javascript:;">打招呼</a>
                            <a class="give_gift" href="javascript:;">送礼物</a>
                        </div>
                    </div>

<div class="letter_body_content">
            		<a href="vip.html" class="letter_img"><img src="<?php echo img("ZTW50023270LV");?>"></a>
                    <div class="letter_content_text">
                        <h1 class="letter_text_title"><a href="vip.html">会飞的鱼</a></h1>
                        <p style="margin: 10px 0;font-size: 14px;">30岁，未婚，来自重庆</p>
                        <p>10月21日 21:15</p>
                    </div>
                    <div class="letter_rt">
                   <span style="color:#F00">2封未读</span>
                    <s></s>
                    <span style="margin-right:10px; color:#888;">共15封</span>
                    <a href="javascript:;" class="read_btn" data-id="read">阅读信件</a>
                    </div>
                </div>
                
                
                <div class="letter_body_content">
            		<a href='http://www.yumukeji.com/project/xiangyuepanzhou/SearchMx.php'><img src="<?php echo img("ZTW50023270LV");?>"></a>
                    <div class="letter_content_text">
                        <h1 class="letter_text_title"><a href='http://www.yumukeji.com/project/xiangyuepanzhou/SearchMx.php'>会飞的鱼</a></h1>
                        <p>刚注册，还不是很会操作，露个头，找女友，有没有就在附近的？刚注册，还不是很会操作，露个头，找女友，有没有就在附近的？刚注册，还不是很会操作，露个头，找女友，有没有就在附近的？，找女友，有没有就在附附近的附刚注册，还不是很会操作，露个头，找女友，有没有就在附近的？刚注册，还不是很会操作，露个头，找女友，有没有就在附近的？刚注册，还不是很会操作，露个头，找女友，有没有就在附近的？刚注册，还不是很会操作，露个头，还不是很会操作，露个头，找女友，有没有就在附近的？</p>
                        <a href="javascript:;"><i class="letter_icon letter_icon1"></i></a>
                        <a href="javascript:;"><i class="letter_icon letter_icon2"></i></a>
                    </div>
                </div>
                
                
                <div class="news_content1">
                <div class="news_left">
                    <a href="vip.html"><img src="<?php echo img("ndu50462601Eq");?>"></a>
                    <p>小儿郎</p>
                </div>
                <div class="news_right">
                    <i id="news_btn" class="news_btn2"></i>
                    <a href='http://www.yumukeji.com/project/xiangyuepanzhou/MessageMx.php'><h1>盘州好耍的来咯</h1></a>
                    <span class="browse">浏览量：115</span>
                    <a href='http://www.yumukeji.com/project/xiangyuepanzhou/MessageMx.php'><p>看过来看过来，盘州旅游胜地，下面一一为大家介绍。看过来看过来，盘州旅游胜地，下面一一为大家介绍。看过来看过来，盘州旅游胜地，下面一一为大家介绍。看过来看过来，盘州旅游胜地，下面一一为大家介绍。看过来看过来，盘州旅游胜地，下面一一为大家介绍。看过来看过来，盘州旅游胜地，下面一一为大家介绍。</p></a>
                    <span>发布时间：3小时前</span>
                </div>
            </div>
            
            <script>
		for(var i = 1;i<=20;i++){
			if(i==1){
				document.write(\"<div class='gift_content1'><img src='".img("Ccw50625285Fi")."'><i class='gift_current' data-flow='yes'></i></div>\");			
			}else{
				document.write(\"<div class='gift_content1'><img src='".img("Ccw50625285Fi")."'><i></i></div>\");
			}
		}
		</script>
