"use strict";
/**
* @author Hui He
*/
//banner图 
var conBox, child, timer, pagetion, prev, next, index = 0;

function sliderWrap(param) {
	param = param || {};
	wrapper = document.getElementById(param.slideCell);
	if (!wrapper) return;
	conBox = document.getElementById(param.mainCell);
	pagetion = document.getElementById(param.titCell);
	prev = document.getElementById(param.prev);
	next = document.getElementById(param.next);
	child = childNodes(conBox);
	
	// 初始化conBox的css
	addStyle(conBox, {
		position: "relative",
		zIndex: "5"
	});
	// 初始化child的css
	for (var i = 0; i < child.length; i++) {
		addStyle(child[i], {
			width: (child[0].clientWidth) + "px",
			position: "absolute",
			zIndex: "5",
			display: "block",
			opacity: "0"
		});
		// 添加排序号
		pagetion.innerHTML += "<li>" + (i) + "</li>"
	}
	
	// 初始化第0个child
	addStyle(child[0], {
		zIndex: "10",
		opacity: "1"
	});
	
	// 初始化第0个pagetionChild的className
	pagetionChild = childNodes(pagetion);
	pagetionChild[0].className = "current"
	
	// 设置鼠标移入与移出
	conBox.onmouseover = function() {
		clearInterval(timer)
	}
	conBox.onmouseout = function() {
		onInterval()
	}
	
	// 检测window是否支持window.addEventListener
	if (window.addEventListener) {
		window.addEventListener('resize', function() {
			onWindowResize()
		}, false)
	}else{
		window.onresize = function(){
			onWindowResize()
		}
	}
	
	// 调用函数
	onWindowResize();
	onInterval();
	onDoPage();
	onPage()
}

// 点击按钮执行上翻页与下翻页
function onDoPage() {
	if (prev || next) {
		prev.onclick = function() {
			index--;
			if (index < 0) {// 判断点击是否小于最小值
				index = child.length - 1
			}
			clearInterval(timer);
			onDoPlay(index);
			onInterval()
		};
		next.onclick = function() {
			index++;
			if (index >= child.length) {// 判断点击是否大于最大值
				index = 0
			}
			clearInterval(timer);
			onDoPlay(index);
			onInterval()
		}
	}
}

// 点击排序号执行翻页
function onPage() {
	pagetionChild = childNodes(pagetion);
	for (var i = 0; i < pagetionChild.length; i++) {
		pagetionChild[i].index = i;
		pagetionChild[i].onclick = function(event) {
			clearInterval(timer);
			index = this.index; // index 同步当前的index
			onDoPlay(index);// 传递当前的index
			onInterval()
		}
	}
}
// 定时器自动执行运动
function onInterval() {
	timer = setInterval(function() {
		index++;
		if (index >= child.length) {// 判断点击是否大于最大值
			index = 0
		}
		onDoPlay(index)
	}, 2000)
}

// 运动执行
function onDoPlay(index) {
	pagetionChild = childNodes(pagetion);
	
	for (var i = 0; i < child.length; i++) {// 当每次执行onDoPlay函数的时候 都清除child之前所有的默认属性
		Animation(child[i], {
			opacity: "0"
		}, 40, 10);
		addStyle(child[i], {
			zIndex: "5"
		});
		pagetionChild[i].className = ""
	}
	pagetionChild[index].className = "current";
	Animation(child[index], {// 执行当前第index个child
		opacity: "100"
	}, 40, 10);
	addStyle(child[index], {
		zIndex: "10"
	})
}
// 设置css
function addStyle(obj, Text) {
	if (typeof obj == "undefined" || typeof Text == "undefined") return;
	if (typeof Text === "object") {// 检测类型
		for (read in Text) {
			obj.style[read] = Text[read]
		}
	} else if (typeof Text === "string") {
		var clipText = Text.split(";");
		for (var read = 0; read < clipText.length; read++) {
			var clipText_2 = clipText[read].split(":");
			obj.style[clipText_2[0]] = clipText_2[1]
		}
	}
}
// 读取子元素
function childNodes(parent) {
	var node = parent.childNodes;
	var index = node.length;
	var addArray = [];
	for (var i = 0; i < index; i++) {
		if (node[i].nodeName != "#text") {
			addArray.push(node[i])
		}
	}
	if ( !! addArray) {
		return addArray
	}
}
// 设置窗口缩放
function onWindowResize() {
	var windowInnerWidth = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth;
	var windowInnerHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight;
	if (windowInnerWidth <= 500) {// 判断窗口最小值
		for (var i = 0; i < child.length; i++) {
			addStyle(child[i], {
				width: 500 + "px"
			})
		}
		return
	}
	for (var i = 0; i < child.length; i++) {
		addStyle(child[i], {
			width: windowInnerWidth + "px"
		})
	}
	addStyle(conBox, {
		height: child[0].clientHeight + "px"
	})
}
// 动画函数
function Animation(apply, json, transition, duration) {
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
//弹出层
(function(w,d){
	var dialog={
		showDialog:function(mes){
			var a=[];
			a.push('<div class="dialog-title">提示信息</div>');
			a.push('<div class="dialog-content">'+mes+'</div>');
			a.push('<div class="dialog-bottom"><a href="javascript:;" class="sure" id="sure">确&nbsp;定</a></div>');
			var db = d.createElement('div');
				db.className='dia-ba';
				db.id = 'back';
			var dw = d.createElement('div');
			    dw.className='dialog';
				dw.id = 'wind';
				dw.innerHTML = a.join('');
			d.body.appendChild(db);
			d.body.appendChild(dw);
			return d.getElementById("sure").onclick=function(){
				dialog.closeDialog();
			};
		},
		closeDialog:function(){
			var _bg_dialog = d.getElementById('wind');
			var _dialog = d.getElementById('back');
			d.body.removeChild(_bg_dialog);
			d.body.removeChild(_dialog);
		},
	}
	w.dialog=dialog||{};
})(window,document);
//轮播图
(function(){
window.banner = function(a) {
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
})();
(function(w,d){
	var dialog={
		showDialog:function(mes){
			var a=[];
			a.push('<div class="dialog-title">提示信息</div>');
			a.push('<div class="dialog-content">'+mes+'</div>');
			a.push('<div class="dialog-bottom"><a href="javascript:;" class="sure" id="sure">确&nbsp;定</a></div>');
			var db = d.createElement('div');
				db.className='dia-ba';
				db.id = 'back';
			var dw = d.createElement('div');
			    dw.className='dialog';
				dw.id = 'wind';
				dw.innerHTML = a.join('');
			d.body.appendChild(db);
			d.body.appendChild(dw);
			return d.getElementById("sure").onclick=function(){
				dialog.closeDialog();
			};
		},
		closeDialog:function(){
			var _bg_dialog = d.getElementById('wind');
			var _dialog = d.getElementById('back');
			d.body.removeChild(_bg_dialog);
			d.body.removeChild(_dialog);
		},
	}
	w.dialog=dialog||{};
})(window,document);
(function(w,d){
	var M={
		getById:function(id){
			return d.getElementById(id);
		},
		show:function(a,b){
			M.getById(a).style.display='block';
			M.getById(b).style.display='block';
		},
		hide:function(a,b){
			M.getById(a).style.display='none';
			M.getById(b).style.display='none';
		}
	}
	w.M=M||{};
})(window,document);
/*------------异步提交函数----------------------------------------------*/
function Sub(form,url){
	$.post(url,$("[name="+form+"]").serialize(),function(data){
		if(data.warn == 2){
			if(data.href){//如果异步返回的json参数中定义了重定向url，则跳转到本url
				window.location.href = data.href;
			}else{
				window.location.reload();
			}
		}else{
			warn(data.warn);
		}
	},"json");
}

//提示函数
function warn(mes){
	dialog.showDialog(mes);
}
//显示弹出层函数
function xian(a,b){
	M.show(a,b);
}
//隐藏弹出层函数
function cang(a,b){
	M.hide(a,b);
}
$(function(){
	banner({sortItem:'.sort-item',listItem:'.list-item'});
});
