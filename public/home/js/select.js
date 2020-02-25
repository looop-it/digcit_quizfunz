var title = document.getElementById("title");
var content_div = document.querySelectorAll("#about-content>div");
//showIndex  代表展示板块的下标
title.showIndex = 0;
$(function(){
	title.addEventListener("click",function(event){
		//隐藏上一次的板块
		content_div[title.showIndex].style.display = "none";
		var title_a = document.querySelectorAll("#title a");
		//移除类名
		title_a[title.showIndex].classList.remove("active"); 
		if(event.target.id == "title_about"){
			title.showIndex = 0;
		}
		if(event.target.id == "title_contact"){
			//赛事
			title.showIndex = 1;
		}
		if(event.target.id == "title_hide"){
			//视频
			title.showIndex = 2;
		}
		if(event.target.id == "title_relief"){
			//视频
			title.showIndex = 3;
		}
		//切换showIndex，从而控制content_div的第几个进行显示和隐藏
		content_div[title.showIndex].style.display = "block";
		//添加类名
		title_a[title.showIndex].classList.add("active");
	});
})
