$(function(){
	//密码正则验证变量
	var zz = false;
	//重复密码的匹配
	var pp = false;

	//验证密码是否符合(失焦事件)
	$("input[name=password]").blur(function(){
		zz = false;
		var str = $(this).val();
		var reg = /^\w{6,18}$/;
		var res = reg.test(str);
		if(!res){
			$(".tel_span").html('<span style="color:red;" id="tel_span" class="tel_span">您输入的密码格式不正确</span>');
			zz = false;
		}else{
			$(".tel_span").html('<span id="tel_span" class="tel_span">密码级别中等</span>');
			zz = true;
		}
	});


	//验证重复密码是否符合(失焦事件)
	$("input[name=repassword]").blur(function(){
		pp = false;
		var str = $(this).val();
		var str1 = $("input[name=password]").val();
		if(str == str1){
			$(".pwd_span").html('<span id="tel_span" class="pwd_span">密码级别中等</span>');
			pp = true;
		}else{
			$(".pwd_span").html('<span style="color:red;" id="tel_span" class="pwd_span">两次密码不一样</span>');
			pp = false;
		}
	});

	//单击下一步,验证所有输入框(判断密码框的值是否正确)
	$("#btn_sub_form").click(function(){

		//判断密码与重复密码是否为空
		var v1 = $("input[name=password]").val();
		var v2 = $("input[name=repassword]").val();
		if(v1 && v2){
			//再次验证
			if(zz && pp){
				return true;
			}else{
				return false;
			}

		}else{
			return false;
		}
	});

	//(返回的jquery对象)
	// var res1 = $("input[name=password]").trigger("blur");
	// var res2 = $("input[name=repassword]").trigger("blur");

})