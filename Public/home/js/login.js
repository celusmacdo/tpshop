$(function(){
	$(".login ul.way li").each(function(index,element){
		$(this).click(function(){
			$(this).addClass("on");
			$(this).siblings().removeClass("on");
			$(".login .text li").hide().eq(index).show();
		})
	});
})


var checkUser = function(v){
	if(v==""){
		$("#userNameTip").text("*请输入用户名！").show();
	}else if(localStorage.getItem("newlocaInfor")!= null && localStorage.getItem("newlocaInfor")!= undefined){
			var useInfor = localStorage.getItem("newlocaInfor"),
			useInforJson = JSON.parse(useInfor);
			for(var i=0;i<useInforJson.length;i++){
				if(v!=useInforJson[i].user){
					$("#userNameTip").text("*输入用户名有误!").show();
				}else if(localStorage.getItem("userlogininfor") != null && localStorage.getItem("userlogininfor") != undefined){{
						$("#userNameTip").hide()
					}
				}
			}
	}else if(localStorage.getItem("newlocaInfor") == null && localStorage.getItem("newlocaInfor") == undefined){
				if(v!=""){
					$("#userNameTip").text("*该账号还没注册！").show()
				}else{
					$("#userNameTip").text("*请输入用户名！").show()
				}
	}
		
	
};
var checkPassword = function(v){
	if(v==""){
		$("#passwordTip").show();
	}else{
		if(localStorage.getItem("newlocaInfor") !=null && localStorage.getItem("newlocaInfor")!=undefined){
			var useInfor = localStorage.getItem("newlocaInfor"),
			useInforJson = JSON.parse(useInfor);
			var username = $("#userName").val();
			for(var i=0;i<useInforJson.length;i++){
				if(username == useInforJson[i].user ){
					var usernum = i
				}
			};
			for(var i=0;i<useInforJson.length;i++){
				if(v!=useInforJson[usernum].password){
					$("#passwordTip").text("*输入密码有误!").show();
				}else{
					$("#passwordTip").hide();
				}
			}
		}
	}
}


var checkAutoLogin = function(){
	var u_name = document.getElementById("userName").value;
	var p_pass = document.getElementById("password").value;
	if(u_name=="" ||p_pass==""){
		alert("请输入账号信息")
		return false;
	}else if(localStorage.getItem("newlocaInfor") != null && localStorage.getItem("newlocaInfor") != undefined){
			var loginInfor = localStorage.getItem("newlocaInfor");
			var newUserInfor = JSON.parse(loginInfor);
			for(var i=0;i<newUserInfor.length;i++){
				if(u_name!=newUserInfor[i].user){
					alert("该用户不存在！")
					return false
				}else if(localStorage.getItem("Use") != null && localStorage.getItem("Use") != undefined){
						var old_user = localStorage.getItem("Use")
							old_userJson = JSON.parse(old_user);
					var v =  $("#userName").val()
						if(v==old_userJson.userName){
							alert("该用户已登录！")
						return false;
						}				
				}
			}
			var IsautoCheck =document.getElementById("IsautoCheck").checked;
			setStroage(u_name,p_pass,IsautoCheck);
			setuserStroge(u_name);
	}else if(localStorage.getItem("newlocaInfor")==null && localStorage.getItem("newlocaInfor")==undefined){
		alert("该账号还没注册，请注册账号！");
		return false;
	}
}

var setStroage =function(userName,password,IsAutoCheck){
		if(IsAutoCheck){
			var userlogininfor ={
			userName:userName,
			password:password,
			IsAutoCheck:IsAutoCheck
			}
		}else{
			var userlogininfor ={
			userName:userName,
			password:password,
			IsAutoCheck:false
			}
		}
		localStorage.setItem("userlogininfor",JSON.stringify(userlogininfor));
}
var setuserStroge =function(userName){
	var user ={
		user:userName
	}
	localStorage.setItem("Use",JSON.stringify(user))
}

var loadstroage = function(){
	var obj = localStorage.getItem("userlogininfor");
	var userinfor = JSON.parse(obj);
	if(userinfor){
		document.getElementById("userName").value=userinfor.userName;
		document.getElementById("password").value=userinfor.password;
		document.getElementById("IsautoCheck").checked=userinfor.IsAutoCheck
	}
}
