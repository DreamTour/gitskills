/**
* @author Hui He
*/
/* Copyright (c) 2010-2013 Marcus Westin cookie tore.js	 */
"use strict";(function(e,t){typeof define=="function"&&define.amd?define([],t):typeof exports=="object"?module.exports=t():e.store=t()})(this,function(){function o(){try{return r in t&&t[r]}catch(e){return!1}}var e={},t=typeof window!="undefined"?window:global,n=t.document,r="localStorage",i="script",s;e.disabled=!1,e.version="1.3.20",e.set=function(e,t){},e.get=function(e,t){},e.has=function(t){return e.get(t)!==undefined},e.remove=function(e){},e.clear=function(){},e.transact=function(t,n,r){r==null&&(r=n,n=null),n==null&&(n={});var i=e.get(t,n);r(i),e.set(t,i)},e.getAll=function(){},e.forEach=function(){},e.serialize=function(e){return JSON.stringify(e)},e.deserialize=function(e){if(typeof e!="string")return undefined;try{return JSON.parse(e)}catch(t){return e||undefined}};if(o())s=t[r],e.set=function(t,n){return n===undefined?e.remove(t):(s.setItem(t,e.serialize(n)),n)},e.get=function(t,n){var r=e.deserialize(s.getItem(t));return r===undefined?n:r},e.remove=function(e){s.removeItem(e)},e.clear=function(){s.clear()},e.getAll=function(){var t={};return e.forEach(function(e,n){t[e]=n}),t},e.forEach=function(t){for(var n=0;n<s.length;n++){var r=s.key(n);t(r,e.get(r))}};else if(n&&n.documentElement.addBehavior){var u,a;try{a=new ActiveXObject("htmlfile"),a.open(),a.write("<"+i+">document.w=window</"+i+'><iframe src="/favicon.ico"></iframe>'),a.close(),u=a.w.frames[0].document,s=u.createElement("div")}catch(f){s=n.createElement("div"),u=n.body}var l=function(t){return function(){var n=Array.prototype.slice.call(arguments,0);n.unshift(s),u.appendChild(s),s.addBehavior("#default#userData"),s.load(r);var i=t.apply(e,n);return u.removeChild(s),i}},c=new RegExp("[!\"#$%&'()*+,/\\\\:;<=>?@[\\]^`{|}~]","g"),h=function(e){return e.replace(/^d/,"___$&").replace(c,"___")};e.set=l(function(t,n,i){return n=h(n),i===undefined?e.remove(n):(t.setAttribute(n,e.serialize(i)),t.save(r),i)}),e.get=l(function(t,n,r){n=h(n);var i=e.deserialize(t.getAttribute(n));return i===undefined?r:i}),e.remove=l(function(e,t){t=h(t),e.removeAttribute(t),e.save(r)}),e.clear=l(function(e){var t=e.XMLDocument.documentElement.attributes;e.load(r);for(var n=t.length-1;n>=0;n--)e.removeAttribute(t[n].name);e.save(r)}),e.getAll=function(t){var n={};return e.forEach(function(e,t){n[e]=t}),n},e.forEach=l(function(t,n){var r=t.XMLDocument.documentElement.attributes;for(var i=0,s;s=r[i];++i)n(s.name,e.deserialize(t.getAttribute(s.name)))})}try{var p="__storejs__";e.set(p,p),e.get(p)!=p&&(e.disabled=!0),e.remove(p)}catch(f){e.disabled=!0}return e.enabled=!e.disabled,e});
/*!
 * easySlide plug-ins
 * Date: 2017-1-3
 */
!function(){var k=function(a){this.init(a)};k.fn=k.prototype={timer:null,count:0,init:function(a){"undefined"!==typeof a&&(a=a||{},this.autoplay=a.autoplay,this.domMainCell=a.mainCell,this.domTitleCell=a.titleCell,this.domPrevButton=a.prev,this.domNextButton=a.next,this.curClass=a.active||"on",this.speedDaly=a.speed,this.type=a.type,this.domTitleCellChild,this.domMainCellChild=this.domMainCell.getElementsByTagName("li"),this.length=this.domMainCellChild.length,this.handle())},handle:function(){var a=this;if(!a.domTitleCellChild)for(var b=0;b<a.length;b++)a.domTitleCell.innerHTML+="<li>"+b+"</li>";a.domTitleCellChild=a.domTitleCell.getElementsByTagName("li");a.domTitleCellChild[0].className=a.curClass;var c=function(){a.timer=window.setInterval(function(){a.count++;a.count>=a.length&&(a.count=0);a.useType(a.type,a.count)},a.speedDaly)};a.useCSS(a.domMainCell,{position:"relative",zIndex:100});if("string"==typeof a.type&&"fade"==a.type){for(b=0;b<a.length;b++)a.useCSS(a.domMainCellChild[b],{width:a.domMainCellChild[0].clientWidth+"px",height:a.domMainCellChild[0].clientHeight+"px",position:"absolute",zIndex:5,left:0,top:0,float:"none",opacity:0});a.useCSS(a.domMainCellChild[0],{zIndex:6,opacity:1})}else{for(b=0;b<a.length;b++)a.useCSS(a.domMainCellChild[b],{width:a.domMainCellChild[0].clientWidth+"px",height:a.domMainCellChild[0].clientHeight+"px",position:"relative",zIndex:5,float:"left"});a.useCSS(a.domMainCell,{width:a.length*a.domMainCellChild[0].clientWidth+"px"})}a.domMainCell.onmouseover=function(){window.clearInterval(a.timer)};a.domMainCell.onmouseout=function(){a.autoplay&&c()};a.domNextButton&&(a.domNextButton.onclick=function(){window.clearInterval(a.timer);a.count++;a.count>=a.length&&(a.count=0);a.useType(a.type,a.count);a.autoplay&&c()});a.domPrevButton&&(a.domPrevButton.onclick=function(){window.clearInterval(a.timer);a.count--;-1>=a.count&&(a.count=a.length-1);a.useType(a.type,a.count);a.autoplay&&c()});for(b=0;b<a.length;b++)a.domTitleCellChild[b].index=b,a.domTitleCellChild[b].onclick=function(){window.clearInterval(a.timer);a.count=this.index;a.useType(a.type,this.index);a.autoplay&&c()};a.autoplay&&c()},useType:function(a,b){if("string"==typeof a&&""!=a)switch(a){case"fade":if(-1<b){for(var c=0;c<this.length;c++)this.useCSS(this.domMainCellChild[c],{zIndex:5}),this.domTitleCellChild[c].className="",this.animate(this.domMainCellChild[c],{opacity:0},30,5);this.domTitleCellChild[b].className=this.curClass;this.useCSS(this.domMainCellChild[b],{zIndex:6});this.animate(this.domMainCellChild[b],{opacity:100},30,5)}break;case"move":for(c=0;c<this.length;c++)this.domTitleCellChild[c].className="";this.domTitleCellChild[b].className=this.curClass;this.animate(this.domMainCell,{marginLeft:-b*this.domMainCellChild[0].clientWidth},30,2);break;default:console.log("Not Find It!")}},useCSS:function(a,b){if(a&&b&&"object"==typeof b){var c=[],h=[];for(name in b)c.push(name),h.push(b[name]);for(var d=0;d<c.length;d++)a.style[c[d]]=h[d]}},animate:function(a,b,c,h){var d=function(a,b){return a.currentStyle?a.currentStyle[b]:getComputedStyle(a,!1)[b]};window.clearInterval(a.TIMER);a.TIMER=window.setInterval(function(){for(var f in b){var e=0,g=parseInt(d(a,f)),g="opacity"==f?Math.round(100*parseFloat(d(a,f))):parseInt(d(a,f)),e=(b[f]-g)/c,e=0<e?Math.ceil(e):Math.floor(e);"opacity"==f?(a.style.filter="alpha(opacity:"+(g+e)+")",a.style.opacity=(g+e)/100):a.style[f]=g+e+"px"}},h)}};window.easySlider=function(a){new k(a)}}(window);
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
