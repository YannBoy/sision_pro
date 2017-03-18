<?php if (!defined('THINK_PATH')) exit();?>﻿<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="/Public/Admin/assets/css/admincss.css" />
    <link href="/Public/Admin/assets/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="log-body">
    <div class="log-modal">
        <div class="log-modal-inside">
            <div class="lon-input">
                <p>
                    <span>用户名</span> <input type="text" id="username">
                </p>
                <p>
                    <span>密&nbsp;&nbsp;&nbsp;码</span> <input type="password" id="password">
                </p>
                <p>
                    <span>验证码</span> <input type="text" style="width: 100px" id="checkCode">
                    <img id="verifyCode" class="verifyCode" width="65px" height="36px" style="float:right;margin-right: 45px" src="<?php echo U('Admin/Manager/verify');?>">
                </p>

                <button type="button" class="btn btn-info log_btn do_logn">&nbsp;登&nbsp;&nbsp;录&nbsp;</button>
            </div>
            <div class="forget_pwd">
                <a href="javascript:;" class="forget_modal" >忘记密码?</a>
            </div>
        </div>
    </div>

    <input type="hidden" id="url_src" value="<?php echo $_SERVER['HTTP_HOST'] ?>"/>
    <div class="modal fade" id="chose_school">
        <div class="modal-dialog" style="width: 345px">
            <div class="modal-content" style="width: 345px">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:black">选择登入门户</h4>
                </div>
                <div class="modal-body">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="bakepwd">
        <div class="modal-dialog">
            <div class="modal-content" style='width:400px;margin:0 auto'>
                <div class="modal-header">

                    <h4 class="modal-title" style="color:black">找回密码</h4>
                </div>
                <div class="modal-body" style="padding-left: 50px">
                    <input type='text' name='baketel' class='form-control baketel' style='color:#333;width:300px' placeholder='手机号码'>
                    <div style='margin-top:10px'>
                        <input type='text' name='bakevcode' class='form-control bakevcode' style='width:160px;color:#333' placeholder='验证码' value="" >
                        <div class='pull-right' style='margin-top:-35px;margin-right:50px'>
                            <button class='btn btn-info bakegetcode' >获取验证码</button>
                        </div>

                    </div>
                    <input type='password' name='setnewpass' class='form-control setnewpass' placeholder='新密码' style='margin-top:10px;color:#333;width:300px' >
                </div>
                <div class="modal-footer" style="padding: 10px;padding-right: 15px">
                    <button class='btn btn-info btn-sm backsavepwd'>确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</body>
<script src="/Public/Admin/js/jquery-1.11.3.min.js"></script>
<script src="/Public/Admin/js/scripts.js"></script>
<script src="/Public/Admin/assets/js/bootstrap.min.js"></script>
<script>
    $('.forget_modal').click(function () {
        $('#bakepwd').modal('show');
        $('.bakevcode').val('');
        $('.setnewpass').val('');
    })

    var url = $('#url_src').val();
    $('.do_logn').click(function(){
        $('.modal-body').html('');
        var username = $('#username').val();
        var password = $('#password').val();
        var checkCode = $('#checkCode').val();
        $.ajax({
            url:"checkLogin",
            type:'POST',
            data:{username:username,password:password,checkCode:checkCode},
            dataType:'json',
            success:function(data){
                if(data[0].success == true){
                    if(data[0].type == '1'){
                        $('#chose_school').modal('show');
                        for($i=0;$i<data[0].ocode.length;$i++){
                            button = "<button style='width:300px;margin-bottom:5px;' class='btn btn-info btn-sm chose_ocode' name="+data[0].ocode[$i].class_bh+","+data[0].ocode[$i].biaoji+" >"+data[0].ocode[$i].class_name+"</button>";
                            $('.modal-body').append(button);
                        }

                    }else if(data[0].type == '0'){
                        location.href="http://"+url+"/index.php/Index/index.html";
                    }

                }else {
                    alert(data[0].msg);
                    window.location.reload();
                }
            }
        })
    });

    $(document).on("click",".chose_ocode",function(){
        var class_bh = $(this).attr('name');
        var class_name = $(this).val();
        $.ajax({
            url:"chose_ocode",
            type:'POST',
            data:{class_bh:class_bh,class_name:class_name},
            dataType:'json',
            success:function(data){
                if(data[0].success == true){
                    location.href="http://"+url+"/index.php/Index/index.html";
                }else {
                    alert(data[0].msg);

                }
            }
        })
    });


    $('.bakegetcode').click(function(){

        var tel = $('.baketel').val();
        if(tel.length == 0){
            alert('请填写手机号码');
            return false;
        }
        $('.bakegetcode').addClass('disabled');
        setTimeout(
                function(){

                    $('.bakegetcode').html('已发送,请等待');
                },2000);
        $.ajax({
            url:"http://"+url+"/index.php/Comment/bakegetcode",
            type:'POST',
            data:{tel:tel},
            dataType:'json',
            success:function(data){
                if(data[0].success == true){
                    $('.bakegetcode').html('正在发送...');
                    setTimeout(
                            function(){
                                $('.bakegetcode').html('重新获取验证码');
                                $('.bakegetcode').removeClass('disabled');

                            },6000);
                }else {
                    alert(data[0].msg);

                }
            }
        })

    });
    $('.backsavepwd').click(function(){
        var tel = $('.baketel').val();
        if(tel.length == 0){
            alert('请填写手机号码');
            return false;
        }
        var code = $('.bakevcode').val();
        if(code.length == 0){
            alert('请填写验证码');
            return false;
        }
        var pwd = $('.setnewpass').val();
        if(pwd.length == 0){
            alert('密码不能为空');
            return false;
        }else if(pwd.length <6){
            alert('密码不能低于6位数');
            return false;
        }
        $.ajax({
            url:"http://"+url+"/index.php/Comment/bakeUpdatePwd",
            type:'POST',
            data:{tel:tel,code:code,pwd:pwd},
            dataType:'json',
            success:function(data){
                if(data[0].success == true){
                    alert('修改成功');
                    $('#bakepwd').modal('hide');
                }else {
                    alert(data[0].msg);

                }
            }
        })
    });
</script>
</html>