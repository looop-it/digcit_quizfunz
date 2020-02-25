$(function(){
	var mySwiper3 = new Swiper('#swiper-container3', {
		pagination: '#swiper-container3 .pagination',
		paginationClickable :true,
        loop:true,
       //speed: 1500,
		//autoplay : 1500,
        mode: 'horizontal',
        freeMode:false,
        touchRatio:1,
        longSwipesRatio:0.1,
        threshold:50,
        observer: true,//修改swiper自己或子元素时，自动初始化swiper
        observeParents: true,//修改swiper的父元素时，自动初始化swiper
        autoplayDisableOnInteraction : false
	})
	$('.swiper-button-prev').on('click', function (e) {
		e.preventDefault()
		mySwiper3.swipePrev()
	})
	$('.swiper-button-next').on('click', function (e) {
		e.preventDefault()
		mySwiper3.swipeNext()
	})
	
	
})