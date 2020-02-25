//闭包为了防止变量污染
(function(){
	//函数嵌套函数
	function Carousel(options){
		if(options.element_id == undefined){
			console.warn("没有传入轮播图的id");
			return;
		}
		//配置
		this.options = {
			element_id : options.element_id,			//id，必填
			left_right : options.left_right || true,	//是否需要按钮，默认为true，选填
			speed : (options.speed || 800) + "ms",		//过渡速度，选填，默认800ms
			control : options.control || false,			//控制的小圆点
		};
		//初始化
		this.init();
		//点击开关
		this.flag = true;
		//无缝轮播
		this.transitionEnd();
		//获取按钮
		var btn_right = this.lunbo.getElementsByClassName("btn_right")[0];
		var btn_left = this.lunbo.getElementsByClassName("btn_left")[0];
		//是否需要左右按钮
		if(options.left_right == true){
			this.move(btn_left,-1);
			this.move(btn_right,1);
		}else{
			btn_right.style.display = "none";
			btn_left.style.display = "none";
		}
		//判断是否需要小圆点控制
		if(options.control == true){
			this.controlCreate();
		}
	}
	//初始化方法
	Carousel.prototype.init = function(){
		//最大的轮播图容器
		this.lunbo = document.getElementById(this.options.element_id);
		//图片的ul
		this.lunbo_ul = this.lunbo.getElementsByTagName("ul")[0];
		//所有图片对应的li
		this.lunbo_li = this.lunbo_ul.getElementsByTagName("li");
		//克隆
		var frist_clone = this.lunbo_li[0].cloneNode(true);
		var last_clone = this.lunbo_li[this.lunbo_li.length-1].cloneNode(true);
		//添加到容器里
		this.lunbo_ul.appendChild(frist_clone);
		this.lunbo_ul.insertBefore(last_clone,this.lunbo_li[0]);
		//获取一张图的宽度
		this.width = this.lunbo_li[0].offsetWidth;
		//ul偏移
		this.lunbo_ul.style.marginLeft = -1* this.width + "px";
		//设置index
		this.index = 1;
	}
	//点击移动轮播的方法
	/* 参数 	btn		按钮
	        参数 	i		index的偏移量
	 * */
	Carousel.prototype.move = function(btn,i){
		var that = this;		//保存this的指向
		btn.addEventListener("click",function(){
			if(that.flag == true){
				that.flag = false;		//关闭开关
				that.index += i;
				that.lunbo_ul.style.transition = "all "+ that.options.speed +" linear";
				that.lunbo_ul.style.marginLeft = -1 * that.index * that.width + "px";
			}
		})
	}
	//无缝的方法
	Carousel.prototype.transitionEnd = function(){
		var that = this;
		this.lunbo_ul.addEventListener("transitionend",function(){
			that.flag = true;		//过渡结束，重新打开开关
			if(that.index >= that.lunbo_li.length -1){
				//最后一张
				that.index = 1;
				that.lunbo_ul.style.transition = "none";
				that.lunbo_ul.style.marginLeft = -1 * that.width + "px";
			}
			if(that.index <= 0){
				//最后一张
				that.index = that.lunbo_li.length -2;
				that.lunbo_ul.style.transition = "none";
				that.lunbo_ul.style.marginLeft = -1 * that.index * that.width + "px";
			}
			//过渡结束之后再改变圆点的点击激活
			if(that.options.control == true){
				//圆点的点击激活
				var ol = that.lunbo.getElementsByTagName("ol")[0];
				var ol_li = ol.getElementsByTagName("li");
				for(let j=0;j<ol_li.length;j++){
					ol_li[j].classList.remove("active");
				}
				ol_li[that.index-1].classList.add("active");
			}
		});
	}
	//创建圆点并添加事件
	Carousel.prototype.controlCreate = function(){
		var that = this;
		var ol = document.createElement("ol");
		for(let k=1;k<this.lunbo_li.length-1;k++){
			var li = document.createElement("li");
			if(k == 1){
				li.classList.add("active");
			}
			li.addEventListener("click",function(){
				if(that.flag == true){
					that.flag = false;		//关闭开关
					that.index = k;			//直接给index赋值
					that.lunbo_ul.style.transition = "all "+ that.options.speed +" linear";
					that.lunbo_ul.style.marginLeft = -1 * that.index * that.width + "px";
//					console.log(that.index);
					//圆点的点击激活
//					var ol_li = ol.getElementsByTagName("li");
//					for(let j=0;j<ol_li.length;j++){
//						ol_li[j].classList.remove("active");
//					}
//					ol_li[k-1].classList.add("active");
				}
			});
			//将li添加到ol
			ol.appendChild(li);
		}
		//添加到轮播里面
		this.lunbo.appendChild(ol);
	}
	//将构造函数挂载在window上
	window.Carousel = Carousel;
})();
