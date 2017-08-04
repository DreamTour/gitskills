var mPlayer = function(e) {
		e = e || {};
		var elm = function(s) {
				if (!s) return;
				return document.getElementById(s.replace(/#/, ''))
			},
			elmc = function(obj, s) {
				if (!s) return;
				return obj.getElementsByClassName(s)[0]
			},
			//播放器容器
			mp_container = elm(e.container),
			//HTML5(video)播放器
			mp_video = elmc(mp_container,'media-plugin')||elmc(mp_container,e.video),
			//控制条
			mp_control = elmc(mp_container,'media-play-cotrolbar')||elmc(mp_container,e.controlbar),
			//视频文件
			mp_source = e.source,
			//重复播放
			mp_replay = e.replay||false,
			//播放器宽度
			mp_width = e.width,
			//播放器标题
			mp_title = e.title,
			//播放器是否自动播放
			mp_autoplay = e.autoplay||false,
			//播放器是否键盘控制
			mp_keyEnabled = e.keyEnabled,
			//播放器标题对象对象
			mp_tit = elmc(mp_container,'media-play-title')|| elmc(mp_container,e.videoTitle),
			//播放器遮罩层对象			
			mp_mask = elmc(mp_container,'media-play-mask')|| elmc(mp_container,e.videoMask),
			//播放器遮罩层按钮对象
			mp_maskBtn = elmc(mp_container,'media-play-maskBtn')|| elmc(mp_container,e.videoMaskBtn),
			//播放器播放按钮对象
			mp_button = elmc(mp_control, 'media-play-button'),
			//播放器当前时间对象
			mp_currentTime = elmc(mp_control, 'media-play-currentTime'),
			//播放器视频总时间对象
			mp_durationTime = elmc(mp_control, 'media-play-durationTime'),
			//播放器进度条
			mp_progressBar = elmc(mp_control, 'media-play-progressBar'),
			//播放器进度条轨道
			mp_progressTrack = elmc(mp_control, 'media-play-progressTrack'),
			//播放器音量条
			mp_volumeBar = elmc(mp_control, 'media-play-volumeBar'),
			//播放器音量条点击按钮
			mp_volumeBtn = elmc(mp_control, 'media-play-volumeBtn'),
			//播放器音量条按钮
			mp_volumeTrack = elmc(mp_control, 'media-play-volumeTrack'),
			//播放器全屏按钮
			mp_fullScreen = elmc(mp_control, 'media-play-fullScreen');
		var init = function() {
				mp_currentTime.innerHTML = '00:00';
				mp_durationTime.innerHTML = '00:00';
				//初始化播放器宽度
				mp_video.style.cssText = 'width:100%;height:100%';
				//初始化播放器父级容器
				mp_container.style.width = mp_width + 'px';
				//检测视频名称
				if (!mp_title) {
					mp_tit.innerHTML = 'undefined'
				} else {
					mp_tit.innerHTML = mp_title
				};
				var erro = document.createElement('div');
				erro.className = 'media-play-erro';
				erro.innerHTML = '( ⊙ o ⊙ )啊！..视频无法播放了'
				//检测视频
				if (!mp_source) {
					mp_mask.innerHTML = '';
					mp_mask.appendChild(erro);
					return;
				};
				//判断是否自动播放
				if(mp_autoplay){
					mp_video.setAttribute('autoplay',true);
					addClass(mp_button, 'play-state-start');
					mp_mask.style.display = 'none';
				}
				var heights = mp_volumeTrack.offsetHeight;
				var volumeInner = elmc(mp_control, 'media-play-volumeInner');
				var bool = true;
				var source = document.createElement('source');
				source.src = mp_source;
				source.setAttribute('data-type','mp4/mkv');
				mp_volumeTrack.style.height = 35 + '%';
				//初始化播放器音量
				mp_video.volume = 0.3;
				//添加视频源
				mp_video.appendChild(source);
				//播放器初始化加载事件
				mp_video.onloadedmetadata = function() {
					//给mp_currentTime 设置属性，播放器播放时间
					mp_currentTime.setAttribute('media-player-currentTime', 0);
					//给mp_currentTime 添加当前播放器播放时间
					mp_durationTime.setAttribute('media-player-durationTime', this.duration);
					//给mp_durationTime 添加播放器视频总时间
					mp_durationTime.innerHTML = formatTime(this.duration);
					//给mp_currentTime 添加播放器视频当前播放时间
					mp_currentTime.innerHTML = formatTime(0)
				};
				//点击播放
				mp_button.onclick = function() {
					playStart(this)
				};
				//居中按钮点击播放
				mp_maskBtn.onclick = function() {
					mp_video.play();
					mp_mask.style.display = 'none';
					addClass(mp_button, 'play-state-start')
				};
				mp_video.onclick = function() {
					mp_video.pause();
					removeClass(mp_button, 'play-state-start');
					mp_mask.style.display = 'block'
				};
				//打开音量调节
				mp_volumeBtn.onclick = function() {
					Bubble(e);//阻止冒泡
					if (bool) {
						volumeInner.style.display = 'block';
						bool = false
					} else {
						volumeInner.style.display = 'none';
						bool = true
					};
					document.onclick = function(e) {
						volumeInner.style.display = 'none';
						bool = true
					}
				};
				//调用 按键控制函数
				if(mp_keyEnabled){
					keyDown();
				}
				//调用 播放状态控制函数
				playState();
				//调用 音量调节函数
				progressVolume();
				//调用 视频进度条调节函数
				progress();
				//调用 点击进行视频全屏函数
				clickfullscreen()
			};
		/*
		**function Name//playStart(播放控制/开始/暂停)
		**@param 1.obj 传递控制按钮状态
		*/	
		var playStart = function(obj) {
				//判断播放器播放状态
				if (mp_video.paused) {
					//播放器-播放
					mp_video.play();
					addClass(obj, 'play-state-start');
					mp_mask.style.display = 'none'
				} else {
					//播放器-暂停
					mp_video.pause();
					removeClass(obj, 'play-state-start');
					mp_mask.style.display = 'block'
				}
			};
		/*
		**function Name//playState(播放状态)
		*/	
		var playState = function() {
				//播放器播放状态事件
				mp_video.ontimeupdate = function() {
					//给mp_currentTime 设置属性，播放器播放时间
					mp_currentTime.setAttribute('media-player-currentTime', this.currentTime);
					//给mp_currentTime 添加当前播放器播放时间
					mp_currentTime.innerHTML = formatTime(this.currentTime);
					//计算播放器当前播放时间 转换百分比赋值播放器进度条
					mp_progressTrack.style.width = 100 * this.currentTime / this.duration + '%';
					//判断视频是否播放完
					if (this.currentTime >= this.duration) {
						//删除播放按钮状态
						removeClass(mp_button, 'play-state-start');
						//删除播放全屏状态
						removeClass(mp_fullScreen, 'play-full-Screen');
						//删除播放进度条值
						mp_progressTrack.style.width = 0;
						//删除播放器当前播放时间
						mp_currentTime.innerHTML = formatTime(0);
						//播放器视频当前时间清零
						this.currentTime = 0;
						//播放器视频总时间清零
						this.duration = 0;
						//显示播放器遮罩层
						mp_mask.style.display = 'block';
						//退出全屏
						exitfullscreen();
						//判断视频播放完后，是否自动播放下一次
						if (mp_replay) {
							//继续播放
							mp_video.play();
							addClass(mp_button, 'play-state-start');
							mp_mask.style.display = 'none'
						} else {
							//停止播放
							mp_video.pause()
						}
					}
				}
			};
		//function Name//keyDown播放器按键控制	
		var keyDown = function(e) {
				document.onkeydown = function(e) {
					Bubble(e);//清除冒泡
					//如果keycode等于32(空格键)
					if (e.keyCode == 32) {
						//检测播放状态
						if (mp_video.paused) {
							//播放
							mp_video.play();
							addClass(mp_button, 'play-state-start');
							//隐藏播放器遮罩层
							mp_mask.style.display = 'none'
						} else {
							//暂停
							mp_video.pause();
							removeClass(mp_button, 'play-state-start');
							//显示播放器遮罩层
							mp_mask.style.display = 'block'
						}
					};
					//如果keycode等于27(Esc)
					if (e.keyCode == 27) {
						//退出全屏
						exitfullscreen()
					}
				}
			};
		//function Name//progress播放器进度条控制	
		var progress = function() {
				mp_progressBar.onclick = function(e) {
					var e = e || window.event;
					//计算event坐标值
					var and = (e.clientX - findPosX(this)) / this.clientWidth;
					//赋值播放器当前播放时间
					mp_video.currentTime = (mp_video.duration * and / 100) * 100
				}
			};
		//function Name//progressVolume播放器音量控制	
		var progressVolume = function() {
				mp_volumeBar.onclick = function(e) {
					//清除冒泡
					Bubble(e);
					var e = e || window.event;
					//计算event坐标值
					var and = (this.clientHeight + findPosY(this) - e.clientY) / this.clientHeight;
					//赋值播放器音量
					mp_video.volume = and;
					mp_volumeTrack.style.height = and * 100 + '%'
				}
			};
		//function Name//clickfullscreen播放器全屏控制	
		var clickfullscreen = function() {
				mp_fullScreen.onclick = function() {
					//判断当前播放器是否处于全屏状态
					if (this.className.match(new RegExp('play-full-Screen'))) {
						removeClass(this, 'play-full-Screen');
						removeClass(mp_control, 'media-play-cotrolbar-fill');
						//退出全屏
						exitfullscreen()
					} else {
						addClass(this, 'play-full-Screen');
						addClass(mp_control, 'media-play-cotrolbar-fill');
						//开启全屏
						fullscreen()
					}
				}
			};
		//function Name//fullscreen全屏	
		var fullscreen = function() {
				if (mp_video.requestFullscreen) {
					mp_video.requestFullscreen()
				} else if (mp_video.mozRequestFullScreen) {
					mp_video.mozRequestFullScreen()
				} else if (mp_video.webkitRequestFullScreen) {
					mp_video.webkitRequestFullScreen()
				}
			};
		//function Name//exitfullscreen退出全屏			
		var exitfullscreen = function() {
				if (document.exitFullscreen) {
					document.exitFullscreen()
				} else if (document.mozExitFullScreen) {
					document.mozExitFullScreen()
				} else if (document.webkitExitFullscreen) {
					document.webkitExitFullscreen()
				}
			};
		//function Name//Bubble清除冒泡			
		var Bubble = function(e) {
				if (e && e.stopPropagation) {
					e.stopPropagation()
				} else {
					window.event.cancelBubble = true
				}
			};	
		//function Name//findPosY获取对象绝对Y坐标值
		var findPosY = function(obj) {
				var curTop = 0;
				if (obj.offsetParent) {
					while (obj.offsetParent) {
						curTop += obj.offsetTop;
						obj = obj.offsetParent
					}
				} else if (obj.y) curTop += obj.y;
				return curTop
			};
		//function Name//findPosX获取对象绝对X坐标值
		var findPosX = function(obj) {
				var curLeft = 0;
				if (obj.offsetParent) {
					while (obj.offsetParent) {
						curLeft += obj.offsetLeft;
						obj = obj.offsetParent
					}
				} else if (obj.x) curLeft += obj.x;
				return curLeft
			};
		/*
		**function Name//zeor数值补位			
		**@param 1.num 数值
		*/
		var zeor = function(num) {
				var time = '';
				if (num < 10 || num == 0) {
					time += 0
				}
				time += num;
				return time
			};
		/*
		**function Name//formatTime数值转换时间			
		**@param 1.num 数值
		*/
		var formatTime = function(number) {
				var number = parseInt(number),
					andTime = '',
					day = 0,
					hour = 0,
					minute = 0,
					second = 0;
				if (number != -1) {
					hour = Math.floor(number / 3600);
					minute = Math.floor(number / 60) % 60;
					second = Math.floor(number % 60);
					day = (hour / 24);
					andTime += zeor(minute) + ':';
					andTime += zeor(second)
				}
				return andTime
			};
		/*
		**function Name//getStyle获取对象css				
		**@param 1.el 当前对象
		**@param 2.attr 属性名称
		*/
		var getStyle = function(el, attr) {
				return el.currentStyle ? el.currentStyle[attr] : getComputedStyle(el, !1)[attr]
			};
		/*
		**function Name//addClass添加对象class
		**@param 1.obj 当前对象
		**@param 2.className class
		*/	
		var addClass = function(obj, className) {
				if (!obj || !className || (obj.className && obj.className.search(new RegExp("\\b" + className + "\\b")) != -1)) return;
				obj.className += (obj.className ? " " : "") + className
			};
		/*
		**function Name//removeClass删除对象class
		**@param 1.obj 当前对象
		**@param 2.className class
		*/	
		var removeClass = function(obj, className) {
				if (!obj || !className || (obj.className && obj.className.search(new RegExp("\\b" + className + "\\b")) == -1)) return;
				obj.className = obj.className.replace(new RegExp("\\s*\\b" + className + "\\b", "g"), "")
			};
		init()
	}