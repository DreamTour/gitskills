"use strict";
/**
* @author Hui He
*/
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
