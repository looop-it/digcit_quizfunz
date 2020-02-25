$("#mobile-nav-taggle").click(function() {
	var mobileMenu = $("#mobile-menu");
	if(mobileMenu.hasClass("show-nav")) {
		mobileMenu.addClass("hide-nav").removeClass("show-nav");
	} else {
		mobileMenu.addClass("show-nav").removeClass("hide-nav");
	}
})

 $(".left-top-btn").click(function() {
	var mobileMenu = $("#mobile-menu");
	if(mobileMenu.hasClass("show-nav")) {
		mobileMenu.addClass("hide-nav").removeClass("show-nav");
	} else {
		mobileMenu.addClass("show-nav").removeClass("hide-nav");
	}
})
$("#tach").on("touchstart",function(){
	var mobileMenu = $("#mobile-menu");
	if(mobileMenu.hasClass("show-nav")) {
		mobileMenu.addClass("hide-nav").removeClass("show-nav");
	} else {
		mobileMenu.addClass("show-nav").removeClass("hide-nav");
	}
	return false;
})
$(function(){
	$(".title").click(function(){
		//danq 
		var nowNode = $(this) ;
		var classNaStr = nowNode.parent().attr("class");
		if(classNaStr=='active'){
			nowNode.next().slideUp();
			nowNode.parent().removeClass("active");
			nowNode.find("i").first().addClass("icon-weibiaoti509").removeClass("icon-shouqi");
		}else{
			//alert("展開");
			nowNode.parent().toggleClass("active");
			$(this).next(".option").stop(true,false).slideToggle();
			$(this).parent().parent().find('>li').each(function(){
				var thisNode = $(this);
				if(nowNode.parent().index() !== thisNode.index()){
					thisNode.removeClass("active");
					thisNode.find(".option").first().slideUp();
					thisNode.find("i").first().addClass("icon-weibiaoti509").removeClass("icon-shouqi");
				}
			})
			if ($(this).find("i").hasClass("icon-weibiaoti509")) {
				$(this).find("i").addClass("icon-shouqi").removeClass("icon-weibiaoti509");
				return ;
			}
		}		
	});
})

$(function(){
	var mySwiper3 = new Swiper('#swiper-container2', {
		pagination: '#swiper-container2 .pagination',
		paginationClickable :true,
		loop:true,
		speed: 2000,
		autoplay : 2000,
		mode: 'vertical',
		freeMode:false,
		touchRatio:1,
		longSwipesRatio:0.1,
		grabCursor: true,
		threshold:50,
		observer: true,//修改swiper自己或子元素时，自动初始化swiper
		observeParents: true,//修改swiper的父元素时，自动初始化swiper
		autoplayDisableOnInteraction : false
	})
	$("#swiper-container2").mouseenter(function(e) {
		e.preventDefault()
		mySwiper3.stopAutoplay();
	}).mouseleave(function(e) {
		e.preventDefault()
		mySwiper3.startAutoplay();
	});
}) 