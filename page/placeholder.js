// JavaScript Document
var placeHolder = function() {
	var all = document.getElementsByTagName('*'),
	length = all.length,
	domElm = [],
	dataVal = child = input = nextElm = '',
	ZINDEX = 1000,
	PELATIVE = 'relative',
	ABSOLUTE = 'absolute',
	DARKGREY = 'darkgrey';
	var next = function(obj) {
		var n = obj.nextSibling;
		while (n && n.nodeType != 1) {
			n = n.nextSibling
		}
		return n
	};
	for (var i = 0; i < length; i++) {
		if (all[i].className.toLowerCase() == 'input-wrap') {
			domElm.push(all[i])
		}
	};
	if (domElm.length == 0) {
		return
	} else {
		for (var ii = 0; ii < domElm.length; ii++) {
			dataVal = domElm[ii].getAttribute('data-placeHolder');
			if (dataVal != null) {
				child = document.createElement('div');
				input = domElm[ii].getElementsByTagName('input')[0];
				domElm[ii].appendChild(child);
				child.className = 'input-pseudo';
				child.style.zIndex = ZINDEX;
				input.style.zIndex = ZINDEX + 1;
				domElm[ii].style.position = PELATIVE;
				child.style.position = ABSOLUTE;
				input.style.position = PELATIVE;
				child.style.color = DARKGREY;
				child.style.top = 0;
				child.style.left = 'auto';
				child.style.bottom = 0;
				child.style.height = 20 + 'px';
				child.style.lineHeight = 20 + 'px';
				child.style.margin = 'auto';
				child.innerHTML = dataVal.replace(/(^\s*)|(\s*$)/g, '');
				if (input.value != '') {
					child.style.display = 'none'
				};
				input.onkeydown = function(e) {
					nextElm = next(this);
					nextElm.style.display = 'none';
					if (e.keyCode == 8 && this.value == '' || e.keyCode == 17 || e.keyCode == 18 || e.keyCode == 91 || e.keyCode == 46 || e.keyCode == 27 || e.keyCode == 144 || e.keyCode == 33 || e.keyCode == 34 || e.keyCode == 36 || e.keyCode == 35 || e.keyCode == 45 || e.keyCode == 46 || e.keyCode == 112 || e.keyCode == 113 || e.keyCode == 114 || e.keyCode == 115 || e.keyCode == 116 || e.keyCode == 117 || e.keyCode == 118 || e.keyCode == 119 || e.keyCode == 120 || e.keyCode == 121 || e.keyCode == 122 || e.keyCode == 145 || e.keyCode == 19 || e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40 || e.keyCode == 13 || e.keyCode == 93) {
						nextElm.style.display = 'block'
					} else if (e.keyCode == 16 && this.value == '') {
						nextElm.style.display = 'block';
						e.preventDefault()
					} else if (e.keyCode == 20 && this.value == '') {
						nextElm.style.display = 'block';
						e.preventDefault()
					}
				};
				input.onkeyup = function(e) {
					nextElm = next(this);
					if (this.value != '') {
						nextElm.style.display = 'none'
					} else {
						nextElm.style.display = 'block'
					}
				};
				input.onblur = function(e) {
					nextElm = next(this);
					if (this.value != '') {
						nextElm.style.display = 'none'
					} else {
						nextElm.style.display = 'block'
					}
				};
				input.onfocus = function(e) {
					nextElm = next(this);
					if (this.value != '') {
						nextElm.style.display = 'none'
					} else {
						nextElm.style.display = 'block'
					}
				}
			}
		}
	}
};

//min
/*
**
var placeHolder=function(){for(var b=document.getElementsByTagName("*"),f=b.length,d=[],c=child=input=nextElm="",e=function(a){for(a=a.nextSibling;a&&1!=a.nodeType;)a=a.nextSibling;return a},c=0;c<f;c++)"input-wrap"==b[c].className.toLowerCase()&&d.push(b[c]);if(0!=d.length)for(b=0;b<d.length;b++)c=d[b].getAttribute("data-placeHolder"),null!=c&&(child=document.createElement("div"),input=d[b].getElementsByTagName("input")[0],d[b].appendChild(child),child.className="input-pseudo",child.style.zIndex=
1E3,input.style.zIndex=1001,d[b].style.position="relative",child.style.position="absolute",input.style.position="relative",child.style.color="darkgrey",child.style.top=0,child.style.left="auto",child.style.bottom=0,child.style.height="20px",child.style.lineHeight="20px",child.style.margin="auto",child.innerHTML=c.replace(/(^\s*)|(\s*$)/g,""),""!=input.value&&(child.style.display="none"),input.onkeydown=function(a){nextElm=e(this);nextElm.style.display="none";8==a.keyCode&&""==this.value||17==a.keyCode||
18==a.keyCode||91==a.keyCode||46==a.keyCode||27==a.keyCode||144==a.keyCode||33==a.keyCode||34==a.keyCode||36==a.keyCode||35==a.keyCode||45==a.keyCode||46==a.keyCode||112==a.keyCode||113==a.keyCode||114==a.keyCode||115==a.keyCode||116==a.keyCode||117==a.keyCode||118==a.keyCode||119==a.keyCode||120==a.keyCode||121==a.keyCode||122==a.keyCode||145==a.keyCode||19==a.keyCode||37==a.keyCode||38==a.keyCode||39==a.keyCode||40==a.keyCode||13==a.keyCode||93==a.keyCode?nextElm.style.display="block":16==a.keyCode&&
""==this.value?(nextElm.style.display="block",a.preventDefault()):20==a.keyCode&&""==this.value&&(nextElm.style.display="block",a.preventDefault())},input.onkeyup=function(a){nextElm=e(this);nextElm.style.display=""!=this.value?"none":"block"},input.onblur=function(a){nextElm=e(this);nextElm.style.display=""!=this.value?"none":"block"},input.onfocus=function(a){nextElm=e(this);nextElm.style.display=""!=this.value?"none":"block"})};
**
*/