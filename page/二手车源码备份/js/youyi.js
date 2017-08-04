//首页轮播图
	function pageHeight(){
		var swiperH=$('.swiper .swiper-slide:first img').height();
		$('.swiper,.swiper .swiper-wrapper, .swiper .swiper-slide').css({'height':swiperH});
	}
	
	$(window).load(function(){
		pageHeight();
	});
//点击切换大图
	$(document).ready(function(){
		if($('.swiper-1').length>0){
				var swiperFree = $('.swiper-1').swiper({
					pagination : '.pag-1',
					freeModeFluid: true,
					autoPlay:3000,
					slidesPerSlide :1
				})
				//Clickable pagination
				$('.pag-1 .swiper-pagination-switch').click(function(){
					swiperFree.swipeTo($(this).index());
				})
			};
			
		if($('.swiper-2').length>0){
				var swiperFree = $('.swiper-2').swiper({
					pagination : '.pag-2',
					freeModeFluid: true,
					autoPlay:3000,
					slidesPerSlide :1
				})
				//Clickable pagination
				$('.pag-2 .swiper-pagination-switch').click(function(){
					swiperFree.swipeTo($(this).index());
				})
			}
	});
//以上为首页轮播图

/* 首页菜单选项 */
$(function(){
	$('.menu-a1').click(function(){
		$('.menu-a1').removeClass('menu-a1h');
		$('.menua').removeClass('menuah');
		$(this).addClass('menu-a1h');
		$('.menu-cont1').show();
		$('.menu-cont2').hide();
		$('.menu-cont3').hide();
		$('.menu-cont4').hide();
		$('.menu-on').hide();
		$('.mack').show();
	});
	$('.menu-a2').click(function(){
		$('.menu-a1').removeClass('menu-a1h');
		$('.menua').removeClass('menuah');
		$(this).addClass('menuah');
		$('.menu-cont2').show();
		$('.menu-cont1').hide();
		$('.menu-cont3').hide();
		$('.menu-cont4').hide();
		$('.menu-on').hide();
		$('.mack').show();
	});
	$('.menu-a3').click(function(){
		$('.menu-a1').removeClass('menu-a1h');
		$('.menua').removeClass('menuah');
		$(this).addClass('menuah');
		$('.menu-cont3').show();
		$('.menu-cont2').hide();
		$('.menu-cont1').hide();
		$('.menu-cont4').hide();
		$('.menu-on').hide();
		$('.mack').show();
	});
	$('.menu-a4').click(function(){
		$('.menu-a1').removeClass('menu-a1h');
		$('.menua').removeClass('menuah');
		$(this).addClass('menuah');
		$('.menu-cont4').show();
		$('.menu-cont2').hide();
		$('.menu-cont3').hide();
		$('.menu-cont1').hide();
		$('.menu-on').hide();
		$('.mack').show();
	});
	$('.menu-cont4 a:eq(0)').click(function(){
		$('.menu-on:eq(0)').show();
		$('.menu-cont4').hide();
	});
	$('.menu-cont4 a:eq(1)').click(function(){
		$('.menu-on:eq(1)').show();
		$('.menu-cont4').hide();
	});
	$('.menu-cont4 a:eq(2)').click(function(){
		$('.menu-on:eq(2)').show();
		$('.menu-cont4').hide();
	});
	$('.menu-cont4 a:eq(3)').click(function(){
		$('.menu-on:eq(3)').show();
		$('.menu-cont4').hide();
	});
	$('.menu-cont4 a:eq(4)').click(function(){
		$('.menu-on:eq(4)').show();
		$('.menu-cont4').hide();
	});
	$('.menu-cont4 a:eq(5)').click(function(){
		$('.menu-on:eq(5)').show();
		$('.menu-cont4').hide();
	});
	$('.menu-cont4 a:eq(6)').click(function(){
		$('.menu-on:eq(6)').show();
		$('.menu-cont4').hide();
	});
	$('.mack').click(function(){
		$('.menu-cont1').hide();
		$('.menu-cont2').hide();
		$('.menu-cont3').hide();
		$('.menu-cont4').hide();
		$('.menu-on').hide();
		$('.menu-a1').removeClass('menu-a1h');
		$('.menua').removeClass('menuah');
		$('.mack').hide();
	});
	
})


