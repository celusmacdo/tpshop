$(function() {
		var index = 0;
		var timer = null;
		$(".btn li").click(function() {
			index = $(this).index();
			change(index);
		});

		function change(idx) {
			$(".btn li").eq(idx).addClass("on").siblings().removeClass();
			$(".container_all li").eq(idx).show().siblings().hide();
		};
		//				自己动
		function auto() {
			timer = setInterval(function() {
				if(index < $(".btn li").length - 1) {
					index++;
				} else {
					index = 0;
				}
				change(index);
			}, 2000)
		};
		auto();
		$(".banner").hover(function() {
			clearInterval(timer);
		}, function() {
			auto();
		})
	})
	//$(function() {
	//	var index1 = 0;
	//	var timer1 = null;
	//	//回调函数
	//	$(".pro_btn li").click(function() {
	//			index1 = $(this).index();
	//			change1(index1);
	//		})
	//		//				封装函数
	//	function change1(idx) {
	//		$(".pro_btn li").eq(idx).addClass("on").siblings().removeClass();
	//		$(".pro_bot li").eq(idx).show().siblings().hide();
	//	}
	//	auto1();
	//
	//	function auto1() {
	//		timer1 = setInterval(function() {
	//
	//			if(index1 < $(".pro_bot li").length - 1) {
	//				index1++;
	//			} else {
	//				index1 = 0;
	//			}
	//			change1(index1);
	//		}, 1500)
	//	}
	//	$(".pro_mid").hover(function() {
	//		clearInterval(timer1);
	//	}, function() {
	//		auto1();
	//	})
	//})

$(document).ready(function() {
	$(".sidebar p:first-child").hover(function() {
		$(".sidebar>img").css("display", "block");
	}, function() {
		$(".sidebar>img").css("display", "none");
	});

	$(".sidebar p:first-child+p+p+p").hover(function() {
			$(".sidebar>div").css("display", "block");
		},
		function() {
			$(".sidebar>div").css("display", "none");
		});

	$(".sidebar>div").hover(function() {
			$(".sidebar>div").css("display", "block");
		},
		function() {
			$(".sidebar>div").css("display", "none");
		});
})
$(function(){
	var num = localStorage.getItem("购物车");
	if(num == null){
		num=0;
	}
	$(".shop_carts a:eq(1)").html(num);
	
})
$(function(){
	arr();
})
var arr = function() {
	var s = localStorage.getItem("数量");
	var num = 0
	for(var i = 1; i <= s; i++) {
		var value = localStorage.getItem(i);
		if(value != null) {
			num++;
//			$("tbody").append("<tr><td><input type='checkbox' name='check' id='id" + i + "' class='chk add' /><label for='id" + i + "'></label></td><td class='pro'><a href='pro_details.html'><img src='img/shopcarts.png' /></a><p><a href='pro_details.html'>麦斯威尔经典愿望速溶黑咖啡，三合一 特浓咖啡</a><span>包装：盒装  重量：1.52kg</span></p></td><td class='pri'><p>￥29.00</p><p>￥49.00</p></td><td class='num'><div class='input-bth'><span class='prd_subnum'>-</span><input type='text' value='1' class='prd_num' id='txt'/><span class='prd_addnum'>+</span></div></td><td class='amount'><span>￥29.00</span></td><td><a href='##'>收藏</a><a href='##' class='cel'>删除</a></td></tr>")
//			$(".input-bth>input").eq(i - 1).val(value);

		}
	}
	$(".num").html(num);

}



