/**
* @author Hui He
*/
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