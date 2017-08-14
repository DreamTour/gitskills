
function getFileUrl(sourceId){
	var url;
	if(navigator.userAgent.indexOf("MSIE")>=1) { // IE
		url = document.getElementById(sourceId).value;
	}else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
		url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
	}else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
		url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
	}else{
		url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
	}
	return url;
}


Array.prototype.unique = function(){
	var res = [];
	var json = {};
	for(var i = 0; i < this.length; i++){
		if(!json[this[i]]){
			res.push(this[i]);
			json[this[i]] = 1;
		}
	}
	return res;
}
var arr = [112,112,34,'你好',112,112,34,'你好','str','str1'];
alert(arr.unique());





var xmlhttp = null;
var data = null;
if (window.XMLHttpRequest) {
	xmlhttp = new XMLHttpRequest();
} else {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
if (xmlhttp != null) {
	xmlhttp.onreadystatechange = state_Change;
	xmlhttp.responseType = 'json';
	xmlhttp.open("POST", "<?php echo "{$root}control/ku/addata.php?type=planDateEnd";?>", true);
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	data = {planDate:val,planId:'<?php echo $id;?>'};
	if( typeof data === 'object' ){
		var convertResult = "" ;
		for(var c in data){
			convertResult+= c + "=" + data[c] + "&";
		}
		convertResult=convertResult.substring(0,convertResult.length-1);
	}else{
		convertResult = data;
	}
	xmlhttp.send(convertResult);
} else {
	alert("You browser does not support XMLHTTP.");
}
function state_Change() {
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status = 200) {
			if (xmlhttp.response.warn == 2) {
				if (xmlhttp.response.href) {
					window.location.href = xmlhttp.response.href;
				} else {
					window.location.reload();
				}
			} else {
				warn(xmlhttp.response.warn);
			}
		} else {
			alert("Problem retrieving XML data");
		}
	}
}



function ajax(){
	var ajaxData = {
		type:arguments[0].type || "GET",
		url:arguments[0].url || "",
		async:arguments[0].async || "true",
		data:arguments[0].data || null,
		dataType:arguments[0].dataType || "text",
		contentType:arguments[0].contentType || "application/x-www-form-urlencoded",
		beforeSend:arguments[0].beforeSend || function(){},
		success:arguments[0].success || function(){},
		error:arguments[0].error || function(){}
	}
	ajaxData.beforeSend()
	var xhr = createxmlHttpRequest();
	xhr.responseType=ajaxData.dataType;
	xhr.open(ajaxData.type,ajaxData.url,ajaxData.async);
	xhr.setRequestHeader("Content-Type",ajaxData.contentType);
	xhr.send(convertData(ajaxData.data));
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if(xhr.status == 200){
				ajaxData.success(xhr.response)
			}else{
				ajaxData.error()
			}
		}
	}
}

function createxmlHttpRequest() {
	if (window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	} else if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	}
}

function convertData(data){
	if( typeof data === 'object' ){
		var convertResult = "" ;
		for(var c in data){
			convertResult+= c + "=" + data[c] + "&";
		}
		convertResult=convertResult.substring(0,convertResult.length-1)
		return convertResult;
	}else{
		return data;
	}
}
/**
 * 获取id
 * @param id 元素id
 * @author He Hui
 * */
function getId(id) {
	return document.getElementById(id);
}

/**
 * 写cookies
 * @param name 名字
 * @param value 值
 * @author He Hui
 * */
function setCookie(name,value)
{
	var Days = 30;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

/**
 * 读取cookies
 * @param name 名字
 * @author He Hui
 * */
function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg)) return unescape(arr[2]);
	else return null;
}
/**
 * 删除cookies
 * @param name 名字
 * @author He Hui
 * */
function delCookie(name)
{
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval=getCookie(name);
	if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

/**
 * 乘法函数
 * @param arg1 乘数
 * @param arg2 被乘数
 * @returns {number} 整数
 * @author He Hui
 */
function accMul(arg1,arg2) {
	var m=0,s1=arg1.toString(),s2=arg2.toString();
	try{m+=s1.split(".")[1].length}catch(e){}
	try{m+=s2.split(".")[1].length}catch(e){}
	return  Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m)
}

/**
 * 计算时间
 * @author He Hui
 * */
function totalTimer() {
	var date = new Date();
	var currentTime = date.getTime();
	//相差时间
	var differ = currentTime - getCookie('beginTime');
	//计算出相差天数
	days = Math.floor(differ/(24*3600*1000));
	//计算出小时数
	var remainHours = differ%(24*3600*1000);    //计算天数后剩余的毫秒数
	hours = Math.floor(remainHours/(3600*1000));
	//计算相差分钟数
	var remainMinutes = remainHours%(3600*1000);        //计算小时数后剩余的毫秒数
	minutes = Math.floor(remainMinutes/(60*1000));
	//计算相差秒数
	var leaveSeconds = remainMinutes%(60*1000);      //计算分钟数后剩余的毫秒数
	seconds = Math.round(leaveSeconds/1000);
	if (days.toString().length < 2) days = '0' +　days;
	if (hours.toString().length < 2) hours = '0' +　hours;
	if (minutes.toString().length < 2) minutes = '0' + minutes;
	if (seconds.toString().length < 2) seconds = '0' + seconds;
	var timerContent = getId('timerContent');
	timerContent.innerHTML = days+":"+hours+":"+minutes+":"+seconds;
}


//点击出现弹出层显示对应的设备二维码
// 获得父元素DIV, 添加监听器...
document.getElementById("deviceList-box").addEventListener("click",function(e) {
	var e = e || event;
	e.stopPropagation();
	// e.target是被点击的元素
	if(e.target && e.target.nodeName == "IMG") {
		// 获得CSS类名
		var classes = e.target.className.split(" ");
		// 搜索匹配!
		if(classes) {
			// For every CSS class the element has...
			for(var x = 0; x < classes.length; x++) {
				// If it has the CSS class we want...
				if(classes[x] == "qr-code") {
					// Bingo! Now do something here....
					document.querySelector('.qr-code-shade').style.display = 'block';
					var src = e.target.getAttribute('src');
					document.querySelector('.shade-img').setAttribute('src', src);
				}
			}
		}

	}
});
document.onclick = function() {
	document.querySelector('.qr-code-shade').style.display = 'none';
}

/**
 * 动态加载数据利用父级来获取子元素
 * @author Hui He
 * @param parentID 父级元素
 * @param coverID 遮罩层
 * @param eventName 事件名称
 * @param labelID 标签名称
 * @param classID 样式名称
 * @param qrCodeID 二维码
 */
function entrust(parentID, coverID, eventName, labelID, classID, qrCodeID) {
	var parent = document.getElementById(parentID);
	var cover = document.querySelector(coverID);
	// 获得父元素DIV, 添加监听器...
	parent.addEventListener(eventName, function(e) {
		var e = e || window.event;
		e.stopPropagation();
		// e.target是被点击的元素
		if (e.target && e.target.nodeName == labelID) {
			var classes = e.target.className.split(' ');
			if (classes) {
				// For every CSS class the element has...
				for (var i=0;i<classes.length;i++) {
					// If it has the CSS class we want...
					if (classes[i] == classID) {
						// Bingo! Now do something here....
						cover.style.display = 'block';
						var src = e.target.getAttribute('src');
						var qrCode = document.querySelector(qrCodeID);
						qrCode.setAttribute('src', src);
					}
				}
			}
		}
	})
	document.onclick = function() {
		cover.style.display = 'none';
	}
}

//倒计时函数
function formatDate(config){
	this.second = config.second;
	this.state = config.state;
	this.timer = null;
}
formatDate.prototype.hexText = function(number){
	if (number !== undefined)
	{
			var hex = "";
			if (number < 10 || number == 0)
			{
					hex += 0
			}
			return hex += number
	}
}
formatDate.prototype.format = function(number){
	var useing = this;
	if (number !== undefined)
	{
		  return {
		  _getDay:useing.hexText(parseInt((number / (24 * 60 * 60)))),
		  _getHour:useing.hexText(parseInt(number / 3600)),
		  _getMin:useing.hexText(parseInt((number / 60) % 60)),
		  _getSecond:useing.hexText(parseInt((number % 60)))
																				};
	}
}
formatDate.prototype.timtout = function(callback){
	 if (callback !== undefined && typeof callback == "function"){
		var useing = this;
		if (this.state)
                {
                        this.timer = setInterval(function(){					
							useing.second --;
							if(useing.second === -1 || useing.second <= 0){
								useing.second = 0;
								clearInterval(useing.timer)
							}
							callback(useing.format(useing.second))	
						},1000)
                }
                else
                {
                        callback(useing.format(useing.second));
                } 
	 }
}
//页面加载完
$(document).ready(function(e) {   
	var countsp = document.querySelector(".countsp");
	var nodeList = countsp.children;
	//调用		
	var DateNow = new formatDate({
		second:<?php echo $CountDown;?>,
		state:true	
	});
	DateNow.timtout(function(data){
		nodeList[0].innerHTML = data._getHour;
		nodeList[1].innerHTML = data._getMin;
		nodeList[2].innerHTML = data._getSecond;
		var CountDownTitle = document.getElementById("CountDownTitle").innerHTML;
		if(data._getHour == '00' && data._getMin == '00' && data._getSecond == '00' && CountDownTitle == "拍卖开始还有"){
			$.post("url",{CountDown:"yes"},function(data){
				//再调用一次
				DateNow.second = data.time;
				DateNow.timtout(function(data){
					nodeList[0].innerHTML = data._getHour;
					nodeList[1].innerHTML = data._getMin;
					nodeList[2].innerHTML = data._getSecond;	
				});
				document.getElementById("CountDownTitle").innerHTML = data.title;	
				
			},"json");
		}else if(data._getHour == '00' && data._getMin == '00' && data._getSecond == '00' && CountDownTitle == "拍卖结束还有"){
			$.post("url",{CountDown:"yes"},function(data){
				document.getElementById("CountDownTitle").innerHTML = data.title;	
			},"json");	
		}					
					
	});
});
//拍卖倒计时
function formatDate(config, callback)
{
        config = config ||{};
        var second = parseInt(Math.floor(config.second));
        var timer = null;
        var hexText = function (number)
        {
                if (number !== undefined)
                {
                        var hex = "";
                        if (number < 10 || number == 0)
                        {
                                hex += 0
                        }
                        return hex += number
                }
        }
        var format = function (number)
        {
                if (number !== undefined)
                {
                      return  {
                      _getDay:hexText(parseInt((number / (24 * 60 * 60)))),
                      _getHour:hexText(parseInt((number / 3600) % 24)),
                      _getMin:hexText(parseInt((number / 60) % 60)),
                      _getSecond:hexText(parseInt((number % 60)))
																							};
                }
        }
        if (callback !== undefined && typeof callback == "function")
        {
                if (config.state)
                {
                        timer = setInterval(function(){					
							second --;
							if(second === -1 || second <= 0){
								second = 0;
								clearInterval(timer)
							}
							callback(format(second))	
						},1000)
                }
                else
                {
                        callback(format(second));
                }
        }
};
$(document).ready(function(e) {
    
	var countsp = document.querySelector(".countsp");
	var nodeList = countsp.children;
	
	formatDate({
		second:countsp.getAttribute("data-timeout"),
		state:true
	},function(data){
		
		nodeList[0].innerHTML = data._getHour;
		nodeList[1].innerHTML = data._getMin;
		nodeList[2].innerHTML = data._getSecond;
				
	})
	
	
});
//cooike 存储 
var cookieFnc = {
    getCookie:function(name){//读取cookie
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");

        if(arr=document.cookie.match(reg))

            return unescape(arr[2]);
        else
            return null;
    },
    delCookie:function(name){//删除cookie
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=getCookie(name);
        if(cval!=null)
            document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    },
    getsec:function (str) { //cookie时间转时间戳，d3 表示 3天  h3表示3小时，s3表示3秒；
        var str1=str.substring(1,str.length)*1;
        var str2=str.substring(0,1);
        if (str2=="s")
        {
            return str1*1000;
        }
        else if (str2=="h")
        {
            return str1*60*60*1000;
        }
        else if (str2=="d")
        {
            return str1*24*60*60*1000;
        }
    },
    setCookie:function(name,value,time)//添加cookie
    {
        var strsec = cookieFnc.getsec(time);
        var exp = new Date();
        exp.setTime(exp.getTime() + strsec*1);
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
    }
}


	$(function(){
		$('#show-my-gift').click(function(){
			MG.show();
		});
	});
	//文件上传
	(function(){
		var M={
			getId:function(id){
				return document.getElementById(id);
			},
			init:function(){
				var label = M.getId('upload-label');
				label.onclick= function(){
					M.getId('upload').click();
				}
			}
		}
		M.init();
	})()
	//选修卡切换
	$(function(){
		$("#tabBtn>a").click(function(){
			$(this).addClass('current').siblings().removeClass('current');
			var num =$(this).attr("data-num");
			$(".switch_tab").hide();
			$("[data-show-num = "+num+"]").fadeIn(300);
		});
	});
	
	/*banner切换*/
$(function(){
	banner({
		sortItem:'.sort-item',
		listItem:'.list-item',	
	})	
})
var banner = function(a) {
		var a = a || {};
		var timer = null;
		var count = 0;
		var sorts = jQuery(a.sortItem);
		var lists = jQuery(a.listItem);
		var sortItem = sorts.find('li');
		var listItem = lists.find('li');
		var length = listItem.length;
		for (var i = 0; i < length; i++) {
			sorts.append('<li></li>')
		}
		sorts.find('li:first').addClass('cur').siblings().removeClass('cur');
		lists.width(sorts.width() * length);
		var w = window;
		lists.find('li').width(w.innerWidth);
		lists.find('img').width(w.innerWidth);
		lists.width(w.innerWidth * length);
		var resize = function() {
				var w = window;
				lists.find('li').width(w.innerWidth);
				lists.find('img').width(w.innerWidth);
				lists.width(w.innerWidth * length)
			}
		window.addEventListener('resize', resize, false);
		var setMove = function(index) {
				lists.animate({
					marginLeft: -index * sorts.width()
				}, 600)
			}
		var interval = function() {
				timer = setInterval(function() {
					count++;
					if (count == length) {
						count = 0
					}
					sorts.find('li').eq(count).addClass('cur').siblings().removeClass('cur');
					setMove(count)
				}, 2500)
			}
		$('.sort-item li').click(function() {
			clearInterval(timer);
			var index = $(this).index();
			sorts.find('li').eq(index).addClass('cur').siblings().removeClass('cur');
			count = index;
			setMove(index);
			interval()
		});
		lists.hover(function() {
			clearInterval(timer)
		}, function() {
			interval()
		});
		interval()
}
//会员详情banner	
var swiper = function(){
	var cont = 0,
		getElement = function(s){
			if(!s)return;return document.getElementById(s);
		},
		getStyle = function(obj, attr)  
		{  
			if(obj.currentStyle)  
			{  
				return obj.currentStyle[attr];  
			}  
			else  
			{  
				return getComputedStyle(obj,false)[attr];  
			}  
		},
		imageBig = getElement('image-big'),
		imageList = getElement('image-list'),
		imageListChild = imageList.getElementsByTagName('li'),
		length = imageListChild.length,
		prevBtn = getElement('prev'),
		nextBtn = getElement('next'),
		objWidth = getStyle(imageListChild[0],'width'),
		objHeight = getStyle(imageListChild[0],'height'),
		objMargin = getStyle(imageListChild[0],'margin-right'),
		handleWidth = parseInt(objWidth.replace(/px/,''));
		handleHeight = parseInt(objHeight.replace(/px/,''));
		handleMargin = parseInt(objMargin.replace(/px/,''));
		init = function(){
			
			//设置宽度
			imageList.style.width = (handleWidth + handleMargin) * length+'px';
			if(!nextBtn){
				return;	
			}else{
				nextBtn.onclick = function(){
					cont ++;
					if(cont >= length){
						cont = length;	
					}
					move(cont);
				}
			};
			if(!prevBtn){
				return;	
			}else{
				prevBtn.onclick = function(){
					cont --;
					if(cont <= 0){
						cont = 0;	
					}
					move(cont);
				}
			};
		},
		move = function(lengths){
			if(lengths >= length){
				return;
			}else{
				imageList.style.marginLeft = - (handleWidth + handleMargin) * lengths+'px';	
			}
		},
		selectImage = function(){
			
			var src = '';
			
			for(var i =0;i<length;i++){
				imageListChild[i].onclick = function(){
					var thisImage = this.getElementsByTagName('img')[0].src;
					imageBig.getElementsByTagName('img')[0].src = thisImage
				}
			}
				
		};
		selectImage();
		init();
}

//滚动
$(function() {
		var timer = null;
		var myScrollDiv = $('#myScroll');
		var myScrollUl = $('#myScroll').find('ul');
		var myScrollHeight = myScrollUl.find('li').height() + parseInt(myScrollUl.find('li').css('margin-top')) + 
		parseInt(myScrollUl.find('li').css('margin-bottom')) + parseInt(myScrollUl.find('li').css('padding-top')) +
		parseInt(myScrollUl.find('li').css('padding-bottom'));
		var scroll = function () {
			myScrollUl.finish().animate({'marginTop': myScrollHeight + 'px'},500,function() {
				var myScrollLast = 	myScrollUl.find('li:last');
				myScrollUl.css({'marginTop': 0});
				myScrollLast.css({'opacity': 0});
				myScrollLast.prependTo(myScrollUl);
				myScrollLast.animate({'opacity': 1},500);
			})	
		}
		var autoScroll = function() {
			clearInterval(timer);
			timer = setInterval(function() {
				scroll();
			},3000);	
		}
		autoScroll();
		myScrollDiv.hover(function() {
			clearInterval(timer);	
		},function() {
			autoScroll();	
		})
	})
	
$(function() {
	$(document).keydown(function(e) {
		if(!e) e = window.event;
		if(e.keyCode || e.which == 13) {
			$('.register .free_reg').click();	
		}	
	})	
})	

//块显示
$(function() {
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
		$('.publish_btn').click(function() {
			LG.show();	
		})
		$('#close-let').click(function(){
			LG.hide();
		});
	}
}
LG.hide();
LG.sent_gift();
})

//选项卡切换
window.onload = function() {
	var hotelTabWrap = document.getElementById("hotelTabWrap");
	var liTitle = hotelTabWrap.getElementsByClassName("hotel_header_list");
	var divContent = hotelTabWrap.getElementsByClassName("hotelTab");
	divContent[1].style.display = "none";
	for(var i=0;i<liTitle.length;i++){
		liTitle[i].index = i;
		liTitle[i].onclick = function() {
			for(var i=0;i<divContent.length;i++){
				liTitle[i].className = "fl hotel_header_list";
				divContent[i].style.display = "none";
			}	
			this.className = "fl hotel_header_list hotel_current";
			divContent[this.index].style.display = "block";	
		}	
	} 	
}

//列表切换效果和复选框计数
$(function() {
		//列表切换效1
		$(".bigList_title").click(function() {
			$(this).next().toggle();
			$(this).find('i:first').toggleClass('bigList_arrow_right');
		})
		$(".middleList_title").click(function() {
			$(this).next().toggle();
			$(this).find('i:first').toggleClass('middleList_arrow_right');
		})
		//复选框计数
		var bCount = 0;
		var sCount = 0;
		$(".middleList_num").html(0);
		$(".bigList_num").html(0);
		$('input[type="checkbox"]').change(function(){
			sCount = $(this).parent().parent().find('input:checkbox:checked').length;
			bCount = $(this).parent().parent().parent().parent().find('input:checkbox:checked').length;
			$(this).parent().parent().parent().parent().parent().find(".bigList_num").html(bCount);
			$(this).parent().parent().parent().find(".middleList_num").html(sCount);
			if($(this).is(':checked')){
				sCount++;
				bCount++;
			}else{
				sCount--;
				bCount--;
			}
		})
	})
//列表切换效果2
		var bTitle = $(".bigList_title");
		var mTitle = $(".middleList_title");
		bTitle.next().hide();
		bTitle.find('i:first').addClass('bigList_arrow_right');
		mTitle.next().hide();
		mTitle.find('i:first').addClass('middleList_arrow_right');
		bTitle.eq(0).next().show();
		bTitle.eq(0).find('i:first').removeClass('bigList_arrow_right');
		mTitle.eq(0).next().show();
		mTitle.eq(0).find('i:first').removeClass('middleList_arrow_right');
		bTitle.click(function() {
			bTitle.next().hide();
			$(this).next().show();
			if($(this).is(':visible')){
				bTitle.find('i:first').addClass('bigList_arrow_right');
				$(this).find('i:first').removeClass('bigList_arrow_right');	
			}
		})
		mTitle.click(function() {
			mTitle.next().hide();
			$(this).next().show();
			if($(this).is(':visible')){
				mTitle.find('i:first').addClass('middleList_arrow_right');
				$(this).find('i:first').removeClass('middleList_arrow_right');	
			}
		})
		//替换铭感词
		var keywords = ['壹','贰','叁','肆','伍','陆','柒','捌','玖','拾'];
		function filterWords(obj){  
			//获取文本输入框中的内容  
			var value = $(obj).html();  
			//遍历敏感词数组  
			for(var i=0;i<keywords.length;i++){  
				//全局替换  
				var reg = new RegExp(keywords[i],"g");  
				//判断内容中是否包括敏感词  
				if(value.indexOf(keywords[i])!=-1){  
					var result = value.replace(reg,"**");  
					value = result;  
					$(obj).val(result);  
				}  
			}  
		}
		filterWords('[name=InnerMonologueSummary]');

//pc点击查看图片
(function() {
	photoAlbum = function(imageList, setting) {
		//imageList 目标图片容器
		//setting 自定义设置参数
		this.init(imageList, setting)
	};
	photoAlbum.fn = photoAlbum.prototype = {
		init: function(imageList, setting) {//初始化配置基本参数
			this.targetElement = $(imageList.target)[0],this.photoImageList = this.targetElement.getAttribute("data-imagelist").split("||"),this.photoImageName = this.targetElement.getAttribute("data-imagename"),this.photoAlbum = $(setting.container)[0],this.photoContainer = $(setting.photoContainer)[0],this.photoCtrlL = $(setting.prevButton)[0],this.photoCtrlR = $(setting.nextButton)[0],this.photoInfoBar = $(setting.photoToolbar)[0],this.photoShadow = $(setting.photoImage)[0],this.navContainer = $(setting.photoImageList)[0],this.currentCount = $(setting.curImgNum)[0],this.countAll = $(setting.allImgNum)[0],this.photoName = $(setting.photoName)[0],this.currentClass = setting.activeClass || "active-show";
			this.photoAuto();
			this.photoAlbumResize();
			this.photoAlbumCreat();
			this.photoAlbumControl()
		},
		setCSS: function(applyObj, style) {
			if (typeof style == 'object') {//css函数
				var cssName = [],cssData = [];
				for (name in style) {cssName.push(name);cssData.push(style[name])};
				for (var i = 0; i < cssName.length; i++) {applyObj.style[cssName[i]] = cssData[i]}
			}
		},
		photoAlbumResize: function() {
			var adjustWidth = adjustHeight = domElmWidth = domElmHeight = calcWidth = calcHeight = 0;
			if (this.photoInfoBar && this.photoCtrlL) {//处理窗口缩放问题
				adjustWidth = this.photoInfoBar.clientHeight;
				adjustHeight = this.photoCtrlL.clientWidth;
				domElmWidth = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth;
				domElmHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight;
				calcWidth = (domElmWidth - ((adjustHeight * 2.5)));
				calcHeight = (domElmHeight - ((adjustWidth * 2.5)));
				this.setCSS(this.photoContainer, {height: calcHeight + 'px',width: calcWidth + 'px',position:'fixed',top: (adjustWidth * 1.25) + 'px',left: (adjustHeight * 1.25) + 'px'});
				this.setCSS(this.photoAlbum, {width: domElmWidth + 'px',height: domElmHeight + 'px',top: 0,left: 0,zIndex: 100005})
			}
		},
		photoAlbumCreat: function() {
			var thumbnailLength, thumbnailWraper = this.navContainer,thumbnailImageLIst = this.photoImageList,photoShadow = this.photoContainer,countAll = this.countAll,currentCount = this.currentCount;
			if (thumbnailImageLIst && thumbnailWraper) {
				thumbnailLength = thumbnailImageLIst.length;
				thumbnailWraper.innerHTML = "";
				for (var i = 0; i < thumbnailLength; i++) {//根据imageList添加相册缩略图
					thumbnailWraper.innerHTML += "<li data-index=" + i + "><div class=box-shadow></div><img src=" + thumbnailImageLIst[i] + "></li>"
				};
				countAll.innerHTML = thumbnailLength;
				currentCount.innerHTML = 1
			};
			thumbnailWraper.getElementsByTagName('li')[0].className = this.currentClass;
			this.photoName.innerHTML = this.photoImageName;//添加相册名称
			this.photoShadow.innerHTML = "<img alt='undefined' class='shadow-image' src=" + thumbnailImageLIst[0] + ">";//添加第一张图片到photoShadow
		},
		photoAlbumControl: function() {
			var ctrlButtonLeft, ctrlButtonRight, thumbnailImageLIst, thumbnailChild, thumbnailLength, calcCount = 0,index, picture, pictureURL, applyObj = this;
			if (this.photoCtrlL && this.photoCtrlR && this.navContainer && this.photoContainer) {
				picture = this.photoContainer.getElementsByTagName('img')[0], ctrlButtonLeft = this.photoCtrlL, ctrlButtonRight = this.photoCtrlR, thumbnailImageLIst = this.navContainer, thumbnailChild = thumbnailImageLIst.getElementsByTagName('li'), thumbnailLength = thumbnailChild.length;
				ctrlButtonLeft.onclick = function() {//点击按钮，实现上一张操作
					calcCount--;
					if (calcCount >= thumbnailLength || calcCount <= -1) {
						calcCount = thumbnailLength - 1
					};
					for (var i = 0; i < thumbnailLength; i += 1) {
						thumbnailChild[i].className = ""
					};
					applyObj.photoShadow.innerHTML = "";
					thumbnailChild[calcCount].className = applyObj.currentClass;
					applyObj.currentCount.innerHTML = (parseInt(calcCount) + 1);
					applyObj.photoShadow.innerHTML = "<img alt='undefined' class='shadow-image' style='opacity:0' src=" + thumbnailChild[calcCount].getElementsByTagName('img')[0].src + ">";
					$('.shadow-image').animate({opacity: 1}, 320)
				};
				ctrlButtonRight.onclick = function() {//点击按钮，实现下一张操作
					calcCount++;
					if (calcCount >= thumbnailLength || calcCount <= 0) {
						calcCount = 0
					}
					for (var i = 0; i < thumbnailLength; i += 1) {
						thumbnailChild[i].className = ""
					};
					applyObj.photoShadow.innerHTML = "";
					thumbnailChild[calcCount].className = applyObj.currentClass;
					applyObj.currentCount.innerHTML = (parseInt(calcCount) + 1);
					applyObj.photoShadow.innerHTML = "<img alt='undefined' class='shadow-image' style='opacity:0' src=" + thumbnailChild[calcCount].getElementsByTagName('img')[0].src + ">";
					$('.shadow-image').animate({opacity: 1}, 320)
				};
				for (var i = 0; i < thumbnailLength; i++) {//点击缩略图，实现全局操作
					thumbnailChild[i].onclick = function() {
						calcCount = this.getAttribute('data-index');
						for (var i = 0; i < thumbnailLength; i++) {
							thumbnailChild[i].className = ""
						};
						applyObj.photoShadow.innerHTML = "";
						thumbnailChild[calcCount].className = applyObj.currentClass;
						applyObj.currentCount.innerHTML = (parseInt(calcCount) + 1);
						applyObj.photoShadow.innerHTML = "<img alt='undefined' class='shadow-image' style='opacity:0' src=" + thumbnailChild[calcCount].getElementsByTagName('img')[0].src + ">";
						$('.shadow-image').animate({opacity: 1}, 320)
					}
				}
			}
		},
		photoAuto: function() {
			var applyObj = this;//缩放事件
			window.onresize = function() {applyObj.photoAlbumResize()}
		},
	}
})($);

//轮播图
!(function() {
	var fizzSlider = function(options) {
			this.init(options)
		};
	fizzSlider.fn = fizzSlider.prototype = {
		timer: null,
		count: 0,
		init: function(options) {
			if (typeof options === "undefined") return;
			options = options || {};
			this.autoplay = options.autoplay;
			this.domMainCell = options.mainCell;
			this.domTitleCell = options.titleCell;
			this.domPrevButton = options.prev;
			this.domNextButton = options.next;
			this.curClass = options.active || "on";
			this.speedDaly = options.speed;
			this.type = options.type;
			this.domTitleCellChild;
			this.domMainCellChild = this.domMainCell.getElementsByTagName("li");
			this.length = this.domMainCellChild.length;
			this.handle()
		},
		handle: function() {
			var use = this;
			if (!use.domTitleCellChild) {
				for (var i = 0; i < use.length; i++) {
					use.domTitleCell.innerHTML += "<li>" + i + "</li>"
				}
			};
			use.domTitleCellChild = use.domTitleCell.getElementsByTagName('li');
			use.domTitleCellChild[0].className = use.curClass;
			var interval = function() {
					use.timer = window.setInterval(function() {
						use.count++;
						if (use.count >= use.length) {
							use.count = 0
						};
						use.useType(use.type, use.count)
					}, use.speedDaly)
				};
			use.useCSS(use.domMainCell, {
				position: "relative",
				zIndex: 100
			});
			if (typeof use.type == "string" && use.type == "fade") {
				for (var i = 0; i < use.length; i++) {
					use.useCSS(use.domMainCellChild[i], {
						width: use.domMainCellChild[0].clientWidth + "px",
						height: use.domMainCellChild[0].clientHeight + "px",
						position: "absolute",
						zIndex: 5,
						left: 0,
						top: 0,
						float: "none",
						opacity: 0
					})
				};
				use.useCSS(use.domMainCellChild[0], {
					zIndex: 6,
					opacity: 1
				})
			} else {
				for (var s = 0; s < use.length; s++) {
					use.useCSS(use.domMainCellChild[s], {
						width: use.domMainCellChild[0].clientWidth + "px",
						height: use.domMainCellChild[0].clientHeight + "px",
						position: "relative",
						zIndex: 5,
						float: "left"
					})
				};
				use.useCSS(use.domMainCell, {
					width: use.length * use.domMainCellChild[0].clientWidth + "px",
				})
			};
			use.domMainCell.onmouseover = function() {
				window.clearInterval(use.timer)
			};
			use.domMainCell.onmouseout = function() {
				if (use.autoplay) {
					interval()
				}
			};
			if (use.domNextButton) {
				use.domNextButton.onclick = function() {
					window.clearInterval(use.timer);
					use.count++;
					if (use.count >= use.length) {
						use.count = 0
					};
					use.useType(use.type, use.count);
					if (use.autoplay) {
						interval()
					}
				}
			};
			if (use.domPrevButton) {
				use.domPrevButton.onclick = function() {
					window.clearInterval(use.timer);
					use.count--;
					if (use.count <= -1) {
						use.count = (use.length - 1)
					};
					use.useType(use.type, use.count);
					if (use.autoplay) {
						interval()
					}
				}
			};
			for (var j = 0; j < use.length; j++) {
				use.domTitleCellChild[j].index = j;
				use.domTitleCellChild[j].onclick = function() {
					window.clearInterval(use.timer);
					use.count = this.index;
					use.useType(use.type, this.index);
					if (use.autoplay) {
						interval()
					}
				}
			};
			if (use.autoplay) {
				interval()
			}
		},
		useType: function(type, id) {
			var use = this;
			if (typeof type == "string" && type != "") {
				switch (type) {
				case "fade" || "FADE":
					if (id > -1) {
						for (var s = 0; s < use.length; s++) {
							use.useCSS(use.domMainCellChild[s], {
								zIndex: 5
							});
							use.domTitleCellChild[s].className = "";
							use.animate(use.domMainCellChild[s], {
								opacity: 0
							}, 30, 5)
						};
						use.domTitleCellChild[id].className = use.curClass;
						use.useCSS(use.domMainCellChild[id], {
							zIndex: 6
						});
						use.animate(use.domMainCellChild[id], {
							opacity: 100
						}, 30, 5)
					};
					break;
				case "move" || "MOVE":
					for (var d = 0; d < use.length; d++) {
						use.domTitleCellChild[d].className = ""
					};
					use.domTitleCellChild[id].className = use.curClass;
					use.animate(use.domMainCell, {
						marginLeft: -id * use.domMainCellChild[0].clientWidth
					}, 30, 2);
					break;
				default:
					console.log("Not Find It!");
					break
				}
			}
		},
		useCSS: function(apply, cssList) {
			if (!apply || !cssList || typeof cssList != "object") {
				return
			} else {
				var cssName = [],
					cssData = [];
				for (name in cssList) {
					cssName.push(name);
					cssData.push(cssList[name])
				};
				for (var i = 0; i < cssName.length; i++) {
					apply.style[cssName[i]] = cssData[i]
				}
			}
		},
		animate: function(apply, json, transition, duration) {
			var TIMER = null;
			var OPACITY = "opacity";
			var OPACITY_NUM = 100;
			var CSS_GET = function(obj, name) {
					return obj.currentStyle ? obj.currentStyle[name] : getComputedStyle(obj, false)[name]
				};
			window.clearInterval(apply.TIMER);
			apply.TIMER = window.setInterval(function() {
				for (var transAttr in json) {
					var setSpeed = 0;
					var setAttr = parseInt(CSS_GET(apply, transAttr));
					if (transAttr == OPACITY) {
						setAttr = Math.round(parseFloat(CSS_GET(apply, transAttr)) * OPACITY_NUM)
					} else {
						setAttr = parseInt(CSS_GET(apply, transAttr))
					};
					setSpeed = ((json[transAttr] - setAttr) / transition);
					if (setSpeed > 0) {
						setSpeed = Math.ceil(setSpeed)
					} else {
						setSpeed = Math.floor(setSpeed)
					};
					if (transAttr == OPACITY) {
						apply.style.filter = "alpha(opacity:" + (setAttr + setSpeed) + ")";
						apply.style.opacity = ((setAttr + setSpeed) / OPACITY_NUM)
					} else {
						apply.style[transAttr] = (setAttr + setSpeed) + "px"
					}
				}
			}, duration)
		}
	};
	window.easySlider = function(options) {
		new fizzSlider(options)
	}
})(window);

//addDelete添加删除列表
	function addDelete(obj){
		this.addBtn = $(obj.addBtnSelector);
		this.target = $(obj.targetSelector);
		this.deleteBtn = obj.deleteBtnSelector;
		this.addList();
		this.deleteList();
	}
	addDelete.prototype = {
		addList:function(){
			var self = this;
			this.addBtn.click(function(){
				self.target.after('<div class="pe-info-compress clearfix"><h2 class="fl">招聘平面设计师</h2><div class="fr"><a href="javascript:;" class="pe-edit-btn">编辑</a><a href="javascript:;" class="pe-delete-btn">删除</a><a href="javascript:;" class="pe-preview-btn">预览</a></div></div>');	
				
				$('.pe-info-compress').first().css({'display':'none'}).fadeIn(1000);
			})
		},
		deleteList:function(){
			$(document).on('click',this.deleteBtn,function(e){
				var tar = $(this).parents('.pe-info-compress');
				tar.fadeOut(function(){
					tar.remove();
				})
			});

		}	
	}
	new addDelete({
		addBtnSelector:'[name=supplyForm] .peSave-btn',	
		targetSelector: '#supply',
		deleteBtnSelector:'.pe-delete-btn'
	});
	new addDelete({
		addBtnSelector:'[name=demandForm] .peSave-btn',	
		targetSelector: '#demand',
		deleteBtnSelector:'.pe-delete-btn'
	});
	
	//Anchor锚点跳转
	function Anchor(object){
		this.btn = $(object.btn);
		this.target = $(object.target);
		this.Scroll();	
	}
	Anchor.prototype={
		Scroll:function(){
			var self = this;
			this.btn.bind('click',function(){
				$("html,body").animate({scrollTop:self.target.offset().top},300)	
			})
		}	
	}
	new Anchor({
		btn:".userAnchor",
		target:"#userAnchor"	
	})
	new Anchor({
		btn:".supplyAnchor",
		target:"#supplyAnchor"	
	})
	new Anchor({
		btn:".demandAnchor",
		target:"#demandAnchor"	
	})