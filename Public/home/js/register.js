$(function () {
	$("[data-toggle='popover']").popover();
	$("label:nth-child(5) i").bind("click", function () {
		var str = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789";
		var n = 4,
			s = "",
			Code = [];
		for (var i = 0; i < n; i++) {
			var rand = Math.floor(Math.random() * str.length);
			s += str.charAt(rand);
		}
		console.log(s)
		Code.push(s);
		localStorage.setItem("Code", JSON.stringify(s));
		var Code = localStorage.getItem("Code"),
			Code_Json = JSON.parse(Code);
		console.log(Code_Json);
		$(this).text(Code_Json)
	});
})

var checkUserName = function (v) {
	if (v == "") {
		$("#userNameTip").popover("show");
	} else if (localStorage.getItem("newlocaInfor") != null && localStorage.getItem("newlocaInfor") != undefined) {
		var useInfor = localStorage.getItem("newlocaInfor"),
			useInforJson = JSON.parse(useInfor);
		for (var i = 0; i < useInforJson.length; i++) {
			if (v == useInforJson[i].user) {
				$("#resgisterNameTip").popover("show")
			} else {
				$("#resgisterNameTip").popover("hide")
			}
		}
	} else {
		$("#userNameTip").popover("hide");
	}
}

var checkpassword = function (v) {
	if (v == "") {
		$("#passwordTip").popover("show");
	} else {
		$("#passwordTip").popover("hide");
	}
}

var cofirmPass = function (v) {
	var old_v = document.getElementById("password").value
	if (old_v != v) {
		$("#com_passTip").popover("show");
	} else {
		$("#com_passTip").popover("hide");
	}
}

var checkPhone = function (v) {
	if (v == "") {
		$("#phoneTip").popover("show");
	} else {
		$("#phoneTip").popover("hide");
		var reg = /^1(3|4|5|7|8)\d{9}$/;;
		if (reg.test(v)) {
			$("#phoneFalseTip").popover("hide");
		} else {
			$("#phoneFalseTip").popover("show");
		}
	}
}

var checkCode = function (v) {
	var right = $("label:nth-child(5) i").text()
	if (v == "") {
		$("#codeTip").popover("show");
	} else {
		$("#codeTip").popover("hide");
		if (v != right) {
			$("#code_checkTip").popover("show")
		} else {
			$("#code_checkTip").popover("hide")
		}
	}
}
var checkPcode = function (v) {
	if (v == "") {
		$("#p_codeTip").popover("show");
	} else {
		$("#p_codeTip").popover("hide")
	}
}

var checkRerister = function () {
	var userName = document.getElementById("userName").value;
	var phone = document.getElementById("phone").value;
	var password = document.getElementById("password").value;
	var com_pass = document.getElementById("com_pass").value;
	var code = document.getElementById("code").value;
	var code_right = document.getElementById("code_right").innerHTML;
	var pcode = document.getElementById("p_code").value;
	var check = document.getElementById("IsautoCheck").checked;
	if (userName == "" || phone == "" || password == "" || com_pass == "" || password != com_pass || code == "" || pcode ==
		"" || check != true || code != code_right) {
		alert("请输入完整资料")
		return false;
	} else {
		var userLocal = localStorage.getItem("newlocaInfor"),
			len,
			userLocal_Json = JSON.parse(userLocal);
		if (userLocal_Json != null) {
			len = userLocal_Json.length;
			for (var i = 0; i < len; i++) {
				newlocalist.push(userLocal_Json[i])
			}
			for (i = 0; i < newlocalist.length; i++) {
				if (userName == newlocalist[i].user) {
					alert("该用户已被注册");
					return false
				}
			}
			localStorage.setItem("newlocaInfor", JSON.stringify(newlocalist));
		}
		localDate(userName, com_pass)
		return true;
	}
}
var newlocalist = [];
var localDate = function (nuserName, ncom_pass) {
	var Infor = {
		user: nuserName,
		password: ncom_pass
	}
	newlocalist.push(Infor);
	localStorage.setItem("newlocaInfor", JSON.stringify(newlocalist));
}
