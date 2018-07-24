$(function() {
	var initVal = {
		total: 0, //总价
		number: 0, //商品数量
		deduction: 0, //折扣价
		coupon: 0, //优惠券
		amount: 0 //总金额
	}
	var price, num;
	var cont = function() {
		var len1 = $(".table input[type=checkbox]").length;
		var len2 = $(".table input[type=checkbox]:checked").length;
		return len1 - len2;
	}
	var total = function() {
		var check = $(".table input[type=checkbox]:checked");
		var a = 0;
		initVal.amount = 0;
		initVal.total = 0;
		for(var t = 0; t < $('tbody>tr').length; t++) {

			if($('tbody>tr').eq(t).find('input').prop("checked")) {
				price = $('tbody>tr').eq(t).find('.pri>p:first-child').html()
				price = parseInt(price.replace(/￥/i, ""));
				num = $('tbody>tr').eq(t).find(".prd_num").val()
				initVal.amount = parseInt(price) * parseInt(num)
				$(".amount").eq(t).html("￥" + initVal.amount.toFixed(2));
				initVal.total += initVal.amount;
				console.log($('tbody>tr').eq(t).find(".num"))
			}
		}
		$(".totalamount").html("￥" + initVal.total.toFixed(2));
	}
	$(" table input[type=checkbox]").bind("click", function() {
		total();
	})
	$(".cel").click(function() {

		if(confirm("亲，您确定要狠心删除这些商品吗?")) {
			$(this).parents("tr").remove();
			var id = $(this).parent().parent().children().find("input[type=checkbox]").attr("id");
			var text = parseInt(id.replace(/id/i, ""));
			localStorage.removeItem(text);
			//			localStorage.clear()
			if($(".content>table>tbody>tr").length==0){
				$(".content>form").remove();
			}
		}
		total();
		arr();
	})
	
	$(".prd_addnum").click(function() {
		var num = parseInt($(this).siblings(".prd_num").val());
		++num;
		if(num > 99) {
			num = 99;
		}

		$(this).siblings(".prd_num").val(num);
		total();
	})
	$(".prd_subnum").click(function() {
		var num = parseInt($(this).siblings(".prd_num").val());
		--num;
		if(num < 1) {
			num = 1;
		}
		$(this).siblings(".prd_num").val(num);
		total();
	})
	$(".prd_num").change(function() {
		var numA = $(this).val();
		if(isNaN(numA)) {
			numA = 1;
		} else if(numA > 99) {
			numA = 99;
		} else if(numA < 1) {
			numA = 1;
		}
		numA = Math.round(numA);
		$(this).val(numA);

		total();
	})
	$("#all").click(function() {
		total();
	})
})





//
//
//var index = 0;
//	$(".dels").click(function() {
//		if(confirm("亲，确认删除这些产品么？")) {
//			for(var t = 0; t < $('tbody>tr').length; t++) {
//				if($('tbody>tr').eq(t).find('input[type=checkbox]').attr("checked")) {
//					var id = $('tbody>tr').eq(t).find("input[type=checkbox]").attr("id");
//					var num = parseInt(id.replace(/id/i, ""));
//					localStorage.removeItem(num);
//					$('tbody>tr').eq(t).remove();
//					t--;
//				}
//			}
//		}
//		var len = $("tbody tr").length;
//		localStorage.setItem("个数", len);
//		two();
//	})