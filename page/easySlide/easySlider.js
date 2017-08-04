/*!
 * easySlide plug-ins
 * Date: 2017-1-3
 */
!(function(){var fizzSlider=function(options){this.init(options)};fizzSlider.fn=fizzSlider.prototype={timer:null,count:0,init:function(options){if(typeof options==="undefined")return;options=options||{};this.autoplay=options.autoplay;this.domMainCell=options.mainCell;this.domTitleCell=options.titleCell;this.domPrevButton=options.prev;this.domNextButton=options.next;this.curClass=options.active||"on";this.speedDaly=options.speed;this.type=options.type;this.domTitleCellChild;this.domMainCellChild=this.domMainCell.getElementsByTagName("li");this.length=this.domMainCellChild.length;this.handle()},handle:function(){var use=this;if(!use.domTitleCellChild){for(var i=0;i<use.length;i++){use.domTitleCell.innerHTML+="<li>"+i+"</li>"}};use.domTitleCellChild=use.domTitleCell.getElementsByTagName('li');use.domTitleCellChild[0].className=use.curClass;var interval=function(){use.timer=window.setInterval(function(){use.count++;if(use.count>=use.length){use.count=0};use.useType(use.type,use.count)},use.speedDaly)};use.useCSS(use.domMainCell,{position:"relative",zIndex:100});if(typeof use.type=="string"&&use.type=="fade"){for(var i=0;i<use.length;i++){use.useCSS(use.domMainCellChild[i],{width:use.domMainCellChild[0].clientWidth+"px",height:use.domMainCellChild[0].clientHeight+"px",position:"absolute",zIndex:5,left:0,top:0,float:"none",opacity:0})};use.useCSS(use.domMainCellChild[0],{zIndex:6,opacity:1})}else{for(var s=0;s<use.length;s++){use.useCSS(use.domMainCellChild[s],{width:use.domMainCellChild[0].clientWidth+"px",height:use.domMainCellChild[0].clientHeight+"px",position:"relative",zIndex:5,float:"left"})};use.useCSS(use.domMainCell,{width:use.length*use.domMainCellChild[0].clientWidth+"px",})};use.domMainCell.onmouseover=function(){window.clearInterval(use.timer)};use.domMainCell.onmouseout=function(){if(use.autoplay){interval()}};if(use.domNextButton){use.domNextButton.onclick=function(){window.clearInterval(use.timer);use.count++;if(use.count>=use.length){use.count=0};use.useType(use.type,use.count);if(use.autoplay){interval()}}};if(use.domPrevButton){use.domPrevButton.onclick=function(){window.clearInterval(use.timer);use.count--;if(use.count<=-1){use.count=(use.length-1)};use.useType(use.type,use.count);if(use.autoplay){interval()}}};for(var j=0;j<use.length;j++){use.domTitleCellChild[j].index=j;use.domTitleCellChild[j].onclick=function(){window.clearInterval(use.timer);use.count=this.index;use.useType(use.type,this.index);if(use.autoplay){interval()}}};if(use.autoplay){interval()}},useType:function(type,id){var use=this;if(typeof type=="string"&&type!=""){switch(type){case"fade"||"FADE":if(id>-1){for(var s=0;s<use.length;s++){use.useCSS(use.domMainCellChild[s],{zIndex:5});use.domTitleCellChild[s].className="";use.animate(use.domMainCellChild[s],{opacity:0},30,5)};use.domTitleCellChild[id].className=use.curClass;use.useCSS(use.domMainCellChild[id],{zIndex:6});use.animate(use.domMainCellChild[id],{opacity:100},30,5)};break;case"move"||"MOVE":for(var d=0;d<use.length;d++){use.domTitleCellChild[d].className=""};use.domTitleCellChild[id].className=use.curClass;use.animate(use.domMainCell,{marginLeft:-id*use.domMainCellChild[0].clientWidth},30,2);break;default:console.log("Not Find It!");break}}},useCSS:function(apply,cssList){if(!apply||!cssList||typeof cssList!="object"){return}else{var cssName=[],cssData=[];for(name in cssList){cssName.push(name);cssData.push(cssList[name])};for(var i=0;i<cssName.length;i++){apply.style[cssName[i]]=cssData[i]}}},animate:function(apply,json,transition,duration){var TIMER=null;var OPACITY="opacity";var OPACITY_NUM=100;var CSS_GET=function(obj,name){return obj.currentStyle?obj.currentStyle[name]:getComputedStyle(obj,false)[name]};window.clearInterval(apply.TIMER);apply.TIMER=window.setInterval(function(){for(var transAttr in json){var setSpeed=0;var setAttr=parseInt(CSS_GET(apply,transAttr));if(transAttr==OPACITY){setAttr=Math.round(parseFloat(CSS_GET(apply,transAttr))*OPACITY_NUM)}else{setAttr=parseInt(CSS_GET(apply,transAttr))};setSpeed=((json[transAttr]-setAttr)/transition);if(setSpeed>0){setSpeed=Math.ceil(setSpeed)}else{setSpeed=Math.floor(setSpeed)};if(transAttr==OPACITY){apply.style.filter="alpha(opacity:"+(setAttr+setSpeed)+")";apply.style.opacity=((setAttr+setSpeed)/OPACITY_NUM)}else{apply.style[transAttr]=(setAttr+setSpeed)+"px"}}},duration)}};window.easySlider=function(options){new fizzSlider(options)}})(window);