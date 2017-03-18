$(function(){
    //定义验证码
    var ccode;
    var checkPhone;

    //a链接发送手机号
    $("#get_tel_code").click(function(){
    	checkPhone = 0;
    	
        //正则判断
        var phone = $("#tel_box").val();
        if(phone == ''){
            return false;
        }
        var reg = /^1\d{10}$/;
        var res = reg.test(phone);
        if(!res){
            $("#tel_box").attr("style","border: 1px solid red");
            $('#tel_span').html('<span id="tel_span" style="color:red;">电话号码格式不对</span>');
            checkPhone = 0;
            return false;
        }else{
        	checkPhone = 1;
            $("#tel_box").attr("style","border: 1px solid #cfcfcf");

            // 如果手机号有值,发送Ajax
            $.post('codeMessage',{phone:phone},function(code){

            	if (code == 0) {
					
            		$('#tel_span').html('<span id="tel_span" style="color:red;">电话号码不存在</span>');
            		
				} else {
					$('#tel_span').html('<span id="tel_span" style="color:green;">电话号码格式匹配</span>');
					//将返回的验证码输入在文本框中
	                $('.code_box').val(code);
	                ccode = code;
				}
            }, 'json');
        }
    });

    //单击下一步时,进行验证

    $("#btn_sub_form").click(function(){
        //判断手机号是否为空的情况下是不能提交的
        var phone = $('#tel_box').val();
        if(!phone){
            $('#tel_span').html('<span id="tel_span" style="color:red;">电话号码不能为空</span>');
            return false;
        }else{
            $('#tel_span').html('<span id="tel_span" style="color:green;">电话号码格式匹配</span>');
        }
        
        if (checkPhone == 0) {
        	$('#tel_span').html('<span id="tel_span" style="color:red;">电话号码格式不对</span>');
			return false;
		}

        //判断如果没有验证码的情况
        var pcode = $(".code_box").val();
        if(!pcode){
            $("#error_phone").attr("style","display:block;");
            return false;
        }else{
            $("#error_phone").attr("style","display:none;");

        }

        //判断Ajax传的验证码与输入的是否相等
        if(ccode == pcode){
            return true;
        }else{
            return false;
        }


    });
})

