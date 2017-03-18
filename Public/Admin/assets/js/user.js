var url = $('#oa_url').val();
//    省级下拉框
$('#num_id').change(function(){
    $('#num_id2').html('<option value="">请选择</option>');
    $('#num').html('<option value="">请选择</option>');
    $('#num_id4').html('<option value="">-选-择-学-校-</option>');
    $('#num_id5').html('<option value="">-选-择-班-级-</option>');
    var num_id = $('#num_id').val();
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/User/find_num",
        type:'POST',
        data:{num_id:num_id},
        cache:false,
        dataType:'json',
        success:function(data){
        if( data[0].success =="true" )
            {
                for($i=0;$i<data[0].data.length;$i++){
                    $('#num_id2').append("<option value="+data[0].data[$i].area_bh+">"+data[0].data[$i].area_name+"</option>");
                }
            } else {
            alert('网络异常,请稍后再试');
        }
        }
    })
})

//     市级下拉框
$('#num_id2').change(function(){
    $('#num').html('<option value="">请选择</option>');
    $('#num_id4').html('<option value="">-选-择-学-校-</option>');
    $('#num_id5').html('<option value="">-选-择-班-级-</option>');
    var num_id = $('#num_id2').val();
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/User/find_num2",
        type:'POST',
        data:{num_id:num_id},
        dataType:'json',
        success:function(data){
            if(data[0].success == 'true')
            {
                for($i=0;$i<data[0].data.length;$i++){
                    $('#num').append("<option value="+data[0].data[$i].area_bh+">"+data[0].data[$i].area_name+"</option>");
                }
            }
        }
    })

})


//     区级下拉框
$('#num').change(function(){
    $('#num_id4').html('<option value="">-选-择-学-校-</option>');
    $('#num_id5').html('<option value="">-选-择-班-级-</option>');
    var num_id = $('#num').val();
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/User/find_num4",
        type:'POST',
        data:{num_id:num_id},
        dataType:'json',
        success:function(data){
            if(data[0].success == 'true')
            {
                for($i=0;$i<data[0].data.length;$i++){
                    $('#num_id4').append("<option value="+data[0].data[$i].ocode+">"+data[0].data[$i].ocode_name+"</option>");
                }
            }
        }
    })

})

//  班级获取
$('#num_id4').change(function(){
    $('#num_id5').html('<option value="">-选-择-班-级-</option>');
    var num_id = $('#num_id4').val();
    var ocode = $('#num').val();
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/User/find_num5",
        type:'POST',
        data:{num_id:num_id,ocode:ocode},
        dataType:'json',
        success:function(data){
            if(data[0].success == 'true')
            {
                for($i=0;$i<data[0].data.length;$i++){
                    $('#num_id5').append("<option value="+data[0].data[$i].class_bh+">"+data[0].data[$i].class_name+"</option>");
                }
            }
        }
    })

})


//验证手机号码
$('#form-field-1').blur(function(){
    var iphone = $('#form-field-1').val();
    if(!(/^1[34578]\d{9}$/.test(iphone))){
        $('#tips').css('display','block');
        $('#add_user').css('display','none');
    } else {
        $('#tips').css('display','none');
        $('#add_user').css('display','block');
    }
})


//选中  全选/取消全选
$("#checked_id").click(function() {
    if (this.checked == true) {
        $(".userid").each(function() {
            this.checked = true;
        });
    } else {
        $(".userid").each(function() {
            this.checked = false;
        });
    }
});

//一键添转用户(学生)
$('#add_user1').click(function(){
    var url = $('#url').val();
    text = $("#user_id:checked").map(function(index,elem) {
        return $(elem).val();
    }).get().join(',');
    if(text.length == 0){
        alert('请选择需要转换的用户');
    } else {
        $.ajax({
            url:"http://"+url+"/index.php/User/stu_add",
            type:'POST',
            data:{id:text},
            dataType:'json',
            success:function(data){
                if(data[0].success == true)
                {
                    alert(data[0].msg);
                    window.location.reload();
                }else{
                    alert(data[0].msg);
                }
            }
        })
    }
});

//一键添加用户(教师)

$('#adduser_teacher').click(function(){
    var url = $('#url').val();
    text = $("#teacher_id1:checked").map(function(index,elem) {
        return $(elem).val();
    }).get().join(',');
    if(text.length == 0){
        alert('请选择需要转换的用户');
    } else {
        $.ajax({
            url:"http://"+url+"/index.php/User/adduser_teacher",
            type:'POST',
            data:{id:text},
            dataType:'json',
            success:function(data){
                if(data[0].success == true)
                {
                    alert(data[0].msg);
                    window.location.reload();
                }else{
                    alert(data[0].msg);
                }
            }
        })
    }
});

//添加区域

$('#area_button').click(function(){
    var area_name = $('#area_name').val();
    var area_bh = $('#area_bh').val();
    var url = $('#url').val();
    if(!area_name){
        alert("请输入地区名称");
        return false;
    }
    if(!isNaN(area_bh) && area_bh.length == 6){

    }else{
        alert("请输入正确的地区编号");
        return false;
    };
    $.ajax({
        url:"http://"+url+"/index.php/Area/area_insert",
        type:'POST',
        data:{area_name:area_name,area_bh:area_bh},
        dataType:'json',
        success:function(data){
            if(data[0].success == true)
                {
                    alert(data[0].msg);
                    window.location.reload();
                }else{
                    alert(data[0].msg);
                }
        }
    })
});

//修改区域
$('button[name=area_rec_id]').click(function(){
    var rec_id = $(this).attr('id');
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/Area/area_update",
        type:'POST',
        data:{rec_id:rec_id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true)
            {
                $('#area_update_name').val(data[0].list['area_name']);
                $('#area_update_bh').val(data[0].list['area_bh']);
                $('#area_update_id').val(data[0].list['rec_id'])
            }
        }
    })
});

//修改地区信息
$('#area_update_button').click(function(){
    var rec_id = $('#area_update_id').val();
    var area_name = $('#area_update_name').val();
    var area_bh = $('#area_update_bh').val();
    var url = $('#url').val();
    if(!area_name){
        alert("请输入地区名称");
        return false;
    }
    if(!isNaN(area_bh) && area_bh.length == 6){

    }else{
        alert("请输入正确的地区编号");
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/Area/area_edit",
        data:{rec_id:rec_id,area_name:area_name,area_bh:area_bh},
        type:'POST',
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            } else {
                alert(data[0].msg);
            }
        }
    })
});


//删除地区
$('button[name=area_del_id]').click(function(){
    var rec_id = $(this).attr('id');
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/Area/area_del",
        data:{rec_id:rec_id},
        dataType:'json',
        type:'POST',
        success:function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            } else {
                alert(data[0].msg);
            }
        }
    })
});

//添加学校
$('#school_button').click(function(){
    $('#lon').show();
    var url = $('#url').val();
    var area = $('#school').val();
    var school_name = $('#school_name').val();
    if(school_name == ""){
        alert('请填写学校名称');
        return false;
    }
    if(area == "请选择"){
        alert('请选择准确地区');
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/School/school_add",
        type:'POST',
        data:{area_bh:area,ocode_name:school_name},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                window.location.reload();
            } else {
                alert(data[0].msg);
            }
        }
    })

});



//    省级下拉框
$('#school_id').change(function(){
    $('#school_id2').html('<option value="">请选择</option>');
    $('#school').html('<option value="">请选择</option>');
    var school_id = $('#school_id').val();
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/User/find_num",
        type:'POST',
        data:{num_id:school_id},
        cache:false,
        dataType:'json',
        success:function(data){
            if( data[0].success =="true" )
            {
                for($i=0;$i<data[0].data.length;$i++){
                    $('#school_id2').append("<option value="+data[0].data[$i].area_bh+">"+data[0].data[$i].area_name+"</option>");
                }
            } else {
                alert('网络异常,请稍后再试');
            }
        }
    })
})
//     市级下拉框
$('#school_id2').change(function(){
    $('#school').html('<option value="">请选择</option>');
    var num_id = $('#school_id2').val();
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/User/find_num2",
        type:'POST',
        data:{num_id:num_id},
        dataType:'json',
        success:function(data){
            if(data[0].success == 'true')
            {
                for($i=0;$i<data[0].data.length;$i++){
                    $('#school').append("<option value="+data[0].data[$i].area_bh+">"+data[0].data[$i].area_name+"</option>");
                }
            }
        }
    })

});

//修改学校信息弹框
$('button[name=school_rec_id]').click(function(){
    var rec_id = $(this).attr('id');
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/School/school_find",
        type:'POST',
        data:{rec_id:rec_id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#name1').html("<option value="+data[0].list1.area_bh+">"+data[0].list1['area_name']+"</option>");
                $('#name2').html("<option value="+data[0].list2.area_bh+">"+data[0].list2['area_name']+"</option>");
                $('#name3').html("<option value="+data[0].list3.area_bh+">"+data[0].list3['area_name']+"</option>");
                $('#school_update_name').val(data[0].school_name);
                $('#school_update_id').val(rec_id);
            } else {
                alert('网络异常');
            }
        }
    })
});


//学校信息修改
$('#school_update_button').click(function(){
    var ocode_name = $('#school_update_name').val();
    var area_bh = $('#num').val();
    var url = $('#url').val();
    var rec_id = $('#school_update_id').val();
    if(ocode_name == ""){
        alert('请填写学校名称');
        return false;
    }
    if(area_bh == ""){
        alert('请选择准确地区');
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/School/school_update",
        type:"POST",
        data:{rec_id:rec_id,ocode_name:ocode_name,area_bh:area_bh},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            } else {
                alert(data[0].msg);
            }
        }

    })

})

//学校信息删除
$('button[name=school_del_id]').click(function(){
    var rec_id = $(this).attr('id');
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/School/school_del",
        type:'POST',
        data:{rec_id:rec_id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            } else {
                alert(data[0].msg);
            }
        }
    })
});



//  获取学校所拥有班级
$('button[name=find_class]').click(function(){
    $('#class_name').html("<center><h3>已存在班级</h></center>");
    var url = $('#url').val();
    var ocode = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/School/find_class",
        type:'POST',
        data:{ocode:ocode},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                for($i=0;$i<data[0].data.length;$i++){
                    //alert(data[0].data['1'].class_name)
                    $('#class_name').append("<button class='btn btn-info btn-sm' id='class_button' value="+data[0].data[$i].class_bh+">"+data[0].data[$i].class_name+"</button>");
                }
            }else{
                alert(data[0].msg);
            }
        }
    })
});

//删除学生
$('div[name=stu_del]').click(function(){
    var id = $(this).attr('id');
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/User/stu_del",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else {
                alert(data[0].msg);
            }
        }
    })
});

//删除教师
$('a[name=tea_del]').click(function(){
    var id = $(this).attr('id');
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/User/tea_del",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else {
                alert(data[0].msg);
            }
        }
    })
});



//添加用户新的权限区域
$('input[name=but_quanxian]').click(function(){
    var rec_id = $(this).attr('id');
    var url = $('#url').val();
    if(confirm("删除该地区权限?")) {
        $('#lon').show();
        $.ajax({
            url:"http://"+url+"/index.php/User/user_quanxian",
            type:'POST',
            data:{rec_id:rec_id},
            dataType:'json',
            success:function(data){
                if(data[0].success == true){
                    $('#lon').hide(600,function(){
                        window.location.reload();
                    });
                }else{
                    alert(data[0].msg);
                }
            }
        })
    }
})

//用户添加区域权限
$('#user_add_quanxian').click(function(){
    var userid = $('input[name=id]').val();
    var ocode_nj = $('#num_id5').val();
    var ocode = $('#num_id4').val();
    var area = $('#num').val();
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/User/user_add_quanxian",
        type:'POST',
        data:{userid:userid,area:area,ocode_nj:ocode_nj,ocode:ocode},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});



$('button[name=school_nav_add]').click(function(){
    $('#long').show();
    var navigat_flag = $('#navigat_flag').val();
    var const_name = $('#const_name').val();
    var order_num = $('#order_num').val();
    var url = $('#url').val();
    var pid = $('#pid').val();

    $.ajax({
        url:"http://"+url+"/index.php/Info/school_nav_add",
        type:'POST',
        data:{navigat_flag:navigat_flag,const_name:const_name,order_num:order_num,pid:pid},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#long').hide(600,function(){
                    window.location.reload();
                });
            } else {
                alert(data[0].msg);
            }
        }

    })
});

//修改导航状态
$('button[name=nav_display]').click(function(){
    var id = $(this).attr('id');
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/Info/edit_display/",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
          if(data[0].success == true){
              $('#'+data[0].data).html(data['0'].msg);
          }else {
              alert(data[0].msg);
          }
        }
    })
});

//学校导航删除
$('button[name=school_nav_del]').click(function(){
    var id = $(this).attr('id');
    var url = $('#url').val();
    $('#lon').show();
    $.ajax({
        url:"http://"+url+"/index.php/Info/school_nav_del",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon').hide(600,function(){
                    window.location.reload();
                });
            }else{
                alert(data[0].msg);
            }

        }
    })
});


//导航修改获取弹框内容
$('button[name=school_btn_get]').click(function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Info/school_btn_get",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#const_name2').val(data[0].data['const_name']);
                $('#order_num2').val(data[0].data['order_num']);
                $('#id').val(data[0].data['id']);
            }else{
                alert(data[0].msg);
            }
        }
    })
});


//修改学校导航信息
$('button[name=school_btn_edit]').click(function(){
    $('#lon_g').show();
    var url = $('#url').val();
    var const_name =  $('#const_name2').val();
    var order_num = $('#order_num2').val();
    var id = $('#id').val();
    $.ajax({
        url:"http://"+url+"/index.php/Info/school_btn_edit",
        type:'POST',
        data:{id:id,order_num:order_num,const_name:const_name},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon_g').hide(600,function(){
                    window.location.reload();
                });
            }else{
                alert(data[0].msg);
            }
        }
    })
});


// 获取导航二级
$('#school_get_nav').change(function(){
    $('#school_nav_2').html('<option value="">请选择</option>');
    var id = $(this).val();
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/school_get_nav",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                for($i=0;$i<data[0].data.length;$i++){
                    $('#school_nav_2').append("<option value="+data[0].data[$i].id+">"+data[0].data[$i].const_name+"</option>");
                }
            }else{

            }
        }
    })
});


$('button[name=get_content_info]').click(function(){
    var url = $('#url').val();
    var id  = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_content_info",
        type:'GET',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#content_info').html(data[0].data['content_info']);
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('button[name=school_news_del]').click(function(){
    $('#lon').show();
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Info/school_news_del",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon').hide(600,function(){
                    window.location.reload();
                });
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('button[name=school_gooduser_del]').click(function(){
    $('#lon').show();
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/school_gooduser_del",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon').hide(600,function(){
                    window.location.reload();
                });
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('button[name=get_miencontent_info]').click(function(){
    var url = $('#url').val();
    var id  = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_miencontent_info",
        type:'GET',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#content_info').html(data[0].data['content_info']);
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('button[name=school_mien_del]').click(function(){
    $('#lon').show();
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Info/school_mien_del",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon').hide(600,function(){
                    window.location.reload();
                });
            }else{
                alert(data[0].msg);
            }
        }
    })
});


//修改图片显示状态
$('button[name=pic_show]').click(function(){
    var id = $(this).attr('id');
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/eidt_pic_show",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#'+data[0].data).html(data['0'].msg);
            }else {
                alert(data[0].msg);
            }
        }
    })
});

//删除图片
$('button[name=pic_del]').click(function(){
    $('#lon').show();
    var id = $(this).attr('title');
    var url = $('#url').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/pic_del",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon').hide(600,function(){
                    window.location.reload();
                });
            }else {
                alert(data[0].msg);
            }
        }
    })
});


//学校教师分组
$('button[name=sch_group_add]').click(function(){
    var name = $('#name').val();
    var id = $('#id').val();
    var url = $('#url').val();
    if (name == ''){
        alert('请填写分组名称');
        return false;
    }
    $('#lon_g').show();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/sch_group_add",
        type:'POST',
        data:{name:name,id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon_g').hide(600,function(){
                    window.location.reload();
                });
            } else{
                alert(data[0].msg);
            }
        }
    })
});


//学校分组删除
$('button[name=group_del]').click(function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $('#lon').show();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/group_del",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon').hide(600,function(){
                    window.location.reload();
                });
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('button[name=get_sch_info]').click(function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_sch_info",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#get_name').val(data[0].data['name']);
                $('#get_id').val(data[0].data['id']);
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('button[name=sch_group_edit]').click(function(){
    var name = $('#get_name').val();
    var id = $('#get_id').val();
    var url = $('#url').val();
    if (name == ''){
        alert('请填写分组名称');
        return false;
    }
    $('#lo').show();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/sch_group_edit",
        type:'POST',
        data:{id:id,name:name},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lo').hide(600,function(){
                    window.location.reload();
                });
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('button[name=sch_teacher_add]').click(function(){
    var name = $('#name').val();
    var gid = $('#id').val();
    var url = $('#url').val();
    var tel = $('#tel').val();
    if (name == ''){
        alert('请填写组员名称');
        return false;
    }
    if (tel == '' || tel.length != 11){
        alert('请填写正确的联系方式');
        return false;
    }
    $('#lon_g').show();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/sch_teacher_add",
        type:'POST',
        data:{name:name,gid:gid,tel:tel},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon_g').hide(600,function(){
                    window.location.reload();
                });
            } else{
                alert(data[0].msg);
                $('#lon_g').hide();
            }
        }
    })
});


$('button[name=get_teacher_info]').click(function(){
    var id = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_teacher_info",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#get_name').val(data[0].data['name']);
                $('#get_tel').val(data[0].data['tel'])
                $('#get_id').val(data[0].data['id']);
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('button[name=sch_teacher_edit]').click(function(){
    var name = $('#get_name').val();
    var id = $('#get_id').val();
    var tel = $('#get_tel').val();
    var url = $('#url').val();
    if (name == ''){
        alert('请填写组员名称');
        return false;
    }
    if(tel.length != '11'){
        alert('请填写正确的联系方式');
        return false;
    }
    $('#lo').show();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/sch_teacher_edit",
        type:'POST',
        data:{id:id,name:name,tel:tel},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lo').hide(600,function(){
                    window.location.reload();
                });
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('button[name=school_teacher_del]').click(function(){

    var id = $(this).attr('id');
    $('#lon').show();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/school_teacher_del",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('#lon').hide(600,function(){
                    window.location.reload();
                });
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('button[name=sch_oafile_add]').click(function(){
    var url = $('#url').val();
    var title = $('#title').val();
    if(title.length < 2){
        alert('名称长度不能低于2位');
        return false;
    }
    var num1 = $('#num1').val();
    if(!/^[\u4e00-\u9fa5]+$/.test(num1)){
        alert('请输入汉字');
        return false;
    }
    var num2 = $('#num2').val();
    if(num2 < 1900 || isNaN(num2)){
        alert('字号格式错误,至少1900');
        return false;
    }
    var num3 = $('#num3').val();
    if(num3 < 1 || isNaN(num3)){
        alert('字号格式错误,至少为1');
        return false;
    }
    var regtime = $('#regtime').val();
    if(regtime == ''){
        alert('发布日期必须选择');
        return false;
    }
    var state = $('input[name=state]:checked').val();
    $.ajax({
        url:"http://"+url+"/index.php/Office/sch_oafile_add",
        type:'POST',
        data:{title:title,num1:num1,num2:num2,num3:num3,regtime:regtime,state:state},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                location.href='http://'+url+'/index.php/Office/sch_oafile_write/id/'+data[0].data+'.html';
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('select[name= get_teacher_group]').change(function(){
    var url = $('#url').val();
    var id = $(this).val();
    $('select[name= get_teacher_group1]').html('<option value="">请选择</option>');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_teacher_group",
        type:'POST',
        data:{pid:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                for($i=0;$i<data[0].data.length;$i++){
                    $('select[name= get_teacher_group1]').append("<option value="+data[0].data[$i].id+">"+data[0].data[$i].name+"</option>");
                }
            }else{

            }
        }
    })
});

$('select[name= get_teacher_group1]').change(function(){
    $('.get_teacher_group').html('');
    var url = $('#url').val();
    var id = $(this).val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_teacher_group1",
        type:'POST',
        data:{pid:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                for($i=0;$i<data[0].data.length;$i++) {
                    var id = data[0].data[$i].tel;
                    $('.get_teacher_group').append
                    ('<button type="button" name="teacher_btn" class="teacher_btn" value='+data[0].data[$i].name+' id='+data[0].data[$i].tel+ '>' +data[0].data[$i].name+'</button>');
                    for($j=0;$j<$('.get_teacher_group1').children().length;$j++){
                        if($('.teacher_btn1:eq('+$j+')').val() == data[0].data[$i].name){
                            $('#'+id).css('color','red');
                        }
                    }
                }
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$(document).on("dblclick","button[name=teacher_btn]",function(){
    var name = $(this).val();
    for($i=0;$i<$('.get_teacher_group1').children().length;$i++){
        if($('.teacher_btn1:eq('+$i+')').val() == name){
            return false;
        }
    }
    $(this).css('color','red');
    var tel = $(this).attr('id');
    $('.get_teacher_group1').append('<button type="button" class="teacher_btn1" value='+name+' id='+tel+ '>' +name+'</button>');
});

$(document).on("dblclick",".teacher_btn1",function(){
    $(this).remove();
    var name = $(this).val();
    var tel = $(this).attr('id');
    for($i=0;$i<$('.get_teacher_group').children().length;$i++){
        var id = $('.teacher_btn:eq('+$i+')').attr('id');
        if($('.teacher_btn:eq('+$i+')').val() == name){
            $('.get_teacher_group #'+id).css('color','black');
        }
    }
});

//全选
$('.teacher_all').click(function(){
    for($i=0;$i<$('.get_teacher_group').children().length;$i++){
        var rgb = $('.teacher_btn:eq('+$i+')').css('color');
        var name = $('.teacher_btn:eq('+$i+')').val();
        var tel = $('.teacher_btn:eq('+$i+')').attr('id');
        rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        function hex(x) {return ("0" + parseInt(x).toString(16)).slice(-2);}
        rgb= "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
        if(rgb == '#000000'){
            $('.get_teacher_group1').append('<button type="button" class="teacher_btn1" value='+name+' id='+tel+ '>' +name+'</button>');
            $('.teacher_btn:eq('+$i+')').css('color','red');
        }
    }
});

//清空
$('.teacher_null').click(function(){
    $('.get_teacher_group1').html('');
    $('.teacher_btn').css('color','black');
});

//确定添加
$('button[name=teacher_all_add]').click(function(){
    $('.teacher_all_name').html('');
    for($i=0;$i<$('.get_teacher_group1').children().length;$i++){
        var name = $('.teacher_btn1:eq('+$i+')').val();
        var tel = $('.teacher_btn1:eq('+$i+')').attr('id');
        $('.teacher_all_name').append('<button type="button" name="teacher_name" class="btn btn-info btn-xs" value='+name+' id='+tel+ '>' +name+'</button>&nbsp;&nbsp;');
    }
    $('#no_model').modal('hide');

});

//全体员工
$('button[name=all_teacher]').click(function(){
    $('.teacher_all_name').html('');
    $('.teacher_all_name').html('<button name="teacher_name" class="btn btn-info btn-xs" value="0">全体教师</button>');
});

//确定保存
$('#school_file_add').click(function(){
    var url = $('#url').val();
    var tel = new Array();
    for($i = 0 ;$i< $('button[name=teacher_name]').length; $i++){
        tel[$i] = $('button[name=teacher_name]:eq('+$i+')').attr('id');
    }
    var name = new Array();
    for($i = 0 ;$i< $('button[name=teacher_name]').length; $i++){
        name[$i] = $('button[name=teacher_name]:eq('+$i+')').val();
    }

    var title = $('#title').val();
    if(title.length < 2){
        alert('名称长度不能低于2位');
        return false;
    }
    var num1 = $('#num1').val();
    if(!/^[\u4e00-\u9fa5]+$/.test(num1)){
        alert('请输入汉字');
        return false;
    }
    var num2 = $('#num2').val();
    if(num2 < 1900 || isNaN(num2)){
        alert('字号格式错误,至少1900');
        return false;
    }
    var num3 = $('#num3').val();
    if(num3 < 1 || isNaN(num3)){
        alert('字号格式错误,至少为1');
        return false;
    }
    var regtime = $('#regtime').val();
    if(regtime == ''){
        alert('发布日期必须选择');
        return false;
    }
    var content = UE.getEditor('container').getContent();
    var state = $('input[name=state]:checked').val();
    var tel_state = $('input[name=tel_state]:checked').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/sch_oafile_edit",
        type:'POST',
        data:{id:$('#id').val(),title:title,num1:num1,num2:num2,num3:num3,regtime:regtime,state:state,tel:tel,name:name,content:content,tel_state:tel_state},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                location.href='http://'+url+'/index.php/Office/oa_file.html';
            }else{
                alert(data[0].msg);
            }
        }
    })
}); 


function Tab(num)
{
    var i;
    for(i=1;i<=2;i++)
    {
        if(i==num)
            document.getElementById("d"+i).style.display="block";
        else
            document.getElementById("d"+i).style.display="none";
    }
}
$('#L1').click(function(){
    $('#L2').css('background','#fff');
    $(this).css('background','#DD5302');
});

$('.oa_file_button_none').click(function(){

    $('#get_teachers').css('display','none');
})
$(document).on("click","button[name=get_oa_teacher]",function(){
   
    $('#get_teachers').css('display','block');
});
$('#L2').click(function() {
    $('#L1').css('background', '#fff');
    $(this).css('background', '#DD5302');
    $('table[name=people_table]').html("<tr> <th class='center col-lg-2'>姓名</th> <th class='center col-lg-3'>办理时间</th> <th class='center col-lg-6'>办理描述</th> <th class='center col-lg-1'>操作</th> </tr>");
    var url = $('#url').val();
    var id = $('.hidden_id').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_share_people",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success : function(data){
            if(data[0].success == true){
                for($i=0;$i<data[0].data.length;$i++){
                    if(data[0].data[$i].level == '0'){
                        time = data[0].data[$i].dotime;
                        if(time == null){
                            time = '';
                        }
                        desc = data[0].data[$i].describe;
                        if(desc == null){
                            desc = '';
                        }
                        if(data[0].data[$i].tel == data[0].uname){
                            tr = "<tr> <td>·"+data[0].data[$i].name+"</td>  <td>"+time+"</td>  <td><input type='text' class='desc_input' value="+desc+"></td>  <td> <button type='button' class='btn btn-info btn-xs'  name='get_oa_teacher'> 转</button> </td> </tr>";
                        }else{
                            tr = "<tr> <td>·"+data[0].data[$i].name+"</td>  <td>"+time+"</td>  <td>"+desc+"</td>  <td></td> </tr>";

                        }

                    }else if(data[0].data[$i].level == '1'){
                        time = data[0].data[$i].dotime;
                        if(time == null){
                            time = '';
                        }
                        desc = data[0].data[$i].describe;
                        if(desc == null){
                            desc = '';
                        }
                        if(data[0].data[$i].tel == data[0].uname){
                            tr = "<tr> <td>&nbsp;&nbsp·"+data[0].data[$i].name+"</td>  <td>"+time+"</td>  <td><input type='text' class='desc_input' value="+desc+"></td>  <td> <button type='button' class='btn btn-info btn-xs'  name='get_oa_teacher'> 转</button> </td> </tr>";
                        }else{
                            tr = "<tr> <td>&nbsp;&nbsp;·"+data[0].data[$i].name+"</td>  <td>"+time+"</td>  <td>"+desc+"</td>  <td></td> </tr>";
                        }

                    }else if(data[0].data[$i].level == '2'){
                        time = data[0].data[$i].dotime;
                        if(time == null){
                            time = '';
                        }
                        desc = data[0].data[$i].describe;
                        if(desc == null){
                            desc = '';
                        }
                        if(data[0].data[$i].tel == data[0].uname){
                            tr = "<tr> <td>&nbsp;&nbsp;&nbsp;&nbsp;·"+data[0].data[$i].name+"</td>  <td>"+time+"</td>  <td><input type='text' class='desc_input' value="+desc+"></td>  <td> <button type='button' class='btn btn-info btn-xs'  name='get_oa_teacher'> 转</button> </td> </tr>";
                        }else {
                            tr = "<tr> <td>&nbsp;&nbsp;&nbsp;&nbsp;·"+data[0].data[$i].name+"</td>  <td>"+time+"</td>  <td>"+desc+"</td>  <td></td> </tr>";

                        }

                    }else if(data[0].data[$i].level == '3') {
                        time = data[0].data[$i].dotime;
                        if(time == null){
                            time = '';
                        }
                        desc = data[0].data[$i].describe;
                        if(desc == null){
                            desc = '';
                        }
                        if(data[0].data[$i].tel == data[0].name){
                            tr = "<tr> <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·"+data[0].data[$i].name+"</td>  <td>"+time+"</td>  <td><input type='text' class='desc_input' value="+desc+"></td>  <td> <button type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='.bs-example-modal-sm' name='get_oa_teacher'> 转</button> </td> </tr>";
                        }else{
                            tr = "<tr> <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·"+data[0].data[$i].name+"</td>  <td>"+time+"</td>  <td>"+desc+"</td>  <td></td> </tr>";

                        }

                    }

                    $('table[name=people_table]').append(tr);
                }
            }else{
                alert('111');
            }
        }

    })



});

$('.get_file_info').click(function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $('.file_src').html('');
    document.getElementById("d1").style.display="block";
    document.getElementById("d2").style.display="none";
    $('#L2').css('background','#fff');
    $('#L1').css('background','#DD5302');
    $.ajax({
        url:'http://'+url+'/index.php/Comment/get_file_info',
        type:'GET',
        data:{id:id},
        dataType:'json',
        success:function(data){
            if(data[0].success == true){
                $('.d1hear_1').html(data[0].data.title);
                if(data[0].data.state == 0){
                    var state = '上级文件';
                } else {
                    var state = '本校文件';
                }
                $('.d1_1').html(state);
                $('.hidden_id').val(data[0].data.id);
                $('.d1_2').html(data[0].data.num1+'['+data[0].data.num2+']'+data[0].data.num3+'号');
                $('.d1_3').html(data[0].data.regtime);
                $('.d1_4').html(data[0].data.allnum);
                $('.d1_content').html(data[0].data.content);
                if(data[0].data.old == '1'){
                    for(var i = 0;i<data[0].src.length;i++){
                        $('.file_src').append("<a href="+data[0].src[i].path+"> "+data[0].src[i].name+"</a> </br>");
                    }
                }else{
                    for($j=0;$j<data[0].src.length;$j++){
                        $('.file_src').append("<a href= "+$('.public').val()+"/Uploads/img/"+data[0].src[$j].src+"/"+data[0].src[$j].srcname+">"+data[0].src[$j].name+"</a> </br> " );
                    }
                }

            }
        }
    })
});

$('button[name=share_people]').click(function(){
    var url = $('#url').val();
    var name = new Array();
    var tel = new Array();
    for($i=0;$i<$('.get_teacher_group1').children().length;$i++){
        name[$i] = $('.teacher_btn1:eq('+$i+')').val();
        tel[$i] = $('.teacher_btn1:eq('+$i+')').attr('id');
    }
    $.ajax({
        url:"http://"+url+"/index.php/Comment/share_people",
        type:'POST',
        data:{name:name,tel:tel,id:$('.hidden_id').val()},
        dataType:'json',
        success : function(data){
            if(data[0].success == true){
                window.location.reload();
                alert('转发成功');
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$(document).on("blur",".desc_input",function(){
    var url = $('#url').val();
    var describe = $(this).val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/edit_describe",
        type:'POST',
        data:{describe:describe,id:$('.hidden_id').val()},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
            }else{
                alert(data[0].msg);
            }
        }
    })

});

$(document).on("click","button[name=file_tijiao]",function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/file_tijiao",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                $('input[name=file_name]').val(data[0].data.title);
                $('input[name=file_id]').val(data[0].data.id);
            }else{
                alert(data[0].msg);
            }
        }
    })

});

$('button[name=file_up]').click(function(){
    var url = $('#url').val();
    var id = $('input[name=file_id]').val();
    var type = $('select[name=type]').val();
    var grade = $('select[name=grade]').val();
    var title = $('input[name=file_name]').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/file_up",
        type:'POST',
        data:{id:id,type:type,subject:$('select[name=subject]').val(),title:title,unit:$('select[name=unit]').val(),chapter:$('select[name=chapter]').val(),section:$('select[name=section]').val(),grade:grade},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

//添加新通知
$('input[name=notice]').click(function(){
    var url = $('#url').val();
    //var title = $('input[name=notice_name]').val();
    //if(title === null || title === undefined || title == ''){
    //    alert('请填写标题名称');
    //    return false;
    //};
    $.ajax({
        url:"http://"+url+"/index.php/Comment/notice_new",
        type:'POST',
        data:{},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                location.href='http://'+url+'/index.php/Office/write_notice/id/'+data[0].data+'.html';
            }else{
                alert(data[0].msg);
            }
        }
    })
});
$('.email_add_f').click(function(){
    var url = $('#url').val();
    //var title = $('input[name=notice_name]').val();
    //if(title === null || title === undefined || title == ''){
    //    alert('请填写标题名称');
    //    return false;
    //};
    $.ajax({
        url:"http://"+url+"/index.php/Comment/email_new",
        type:'POST',
        data:{},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                location.href='http://'+url+'/index.php/Office/write_email/id/'+data[0].data+'.html';
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('button[name=notice_add]').click(function(){
    var url = $('#url').val();
    var id = $('#id').val();
    var tel = new Array();
    for($i = 0 ;$i< $('button[name=teacher_name]').length; $i++){
        tel[$i] = $('button[name=teacher_name]:eq('+$i+')').attr('id');
    }
    var name = new Array();
    for($i = 0 ;$i< $('button[name=teacher_name]').length; $i++){
        name[$i] = $('button[name=teacher_name]:eq('+$i+')').val();
    }
    var content = UE.getEditor('container').getContent();
    var regtime = $('#regtime').val();
    if(regtime == ''){
        alert('发布日期必须选择');
        return false;
    }
    var title = $('#title').val();
    if(title === null || title === undefined || title == ''){
        alert('请填写标题名称');
        return false;
    };
    var tel_state = $('input[name=tel_state]:checked').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/notice_add",
        type:'POST',
        data:{id:id,tel:tel,name:name,content:content,regtime:regtime,title:title,tel_state:tel_state},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert('保存成功');
                location.href='http://'+url+'/index.php/Office/notice';
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('.get_notice_id').click(function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $('.file_get').html('');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_notice_info",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                $('#title_get').html(data[0].notice['title']);
                $('.content_get').html(data[0].notice['content']);
                if(data[0].old == '1'){
                    for($i = 0;$i<data[0].file.length;$i++){
                        a = "<a href="+data[0].file[$i].path+">"+data[0].file[$i].name+"</a> </br>";
                        $('.file_get').append(a);
                    }
                }else{
                    for($i=0;$i<data[0].file.length;$i++){
                        a = "<a href= "+$('.public').val()+"/Uploads/img/"+data[0].file[$i].imgtime+"/"+data[0].file[$i].srcname+">"+data[0].file[$i].name+"</a> </br> "
                        $('.file_get').append(a);
                    }
                }
            }
        }
    })
});

$('button[name=make_notice_id1]').click(function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url: "http://" + url + "/index.php/Comment/del_notice",
        type: 'POST',
        data: {id: id},
        dataType: 'json',
        success: function (data) {
            if (data[0].success = true) {
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$(document).on("click","button[name=file_shachu]",function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url: "http://" + url + "/index.php/Comment/file_shachu",
        type: 'POST',
        data: {id: id},
        dataType: 'json',
        success: function (data) {
            if (data[0].success = true) {
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$(document).on("click","button[name=oa_file_del]",function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    var table = $(this).attr('title');
    $.ajax({
        url: "http://" + url + "/index.php/Comment/oa_file_del",
        type: 'POST',
        data: {id: id,table:table},
        dataType: 'json',
        success: function (data) {
            if (data[0].success = true) {
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('#get_all_teacher').click(function(){
    $('.get_teacher_group1').html('<button type="button" class="teacher_btn1" value="0" id="0"> 全体教师</button>');
});


$('button[name=add_message]').click(function(){
    var url = $('#url').val();
    var name = new Array();
    var tel = new Array();
    for($i=0;$i<$('.get_teacher_group1').children().length;$i++){
        name[$i] = $('.teacher_btn1:eq('+$i+')').val();
        tel[$i] = $('.teacher_btn1:eq('+$i+')').attr('id');
    }
    var content = $('.content').val();
    var regtime = $('#regtime').val();
    if(regtime == ''){
        alert('请选择发送时间');
        return false;
    }
    $.ajax({
        url: "http://" + url + "/index.php/Comment/add_message",
        type: 'POST',
        data: {name: name,tel:tel,regtime:regtime,content:content},
        dataType: 'json',
        success: function (data) {
            if (data[0].success = true) {
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

//发布邮件
$('button[name=email]').click(function(){
    var url = $('#url').val();
    var title = $('input[name=notice_name]').val();
    if(title === null || title === undefined || title == ''){
        alert('请填写标题名称');
        return false;
    };
    $.ajax({
        url:"http://"+url+"/index.php/Comment/email_new",
        type:'POST',
        data:{title:title},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                location.href='http://'+url+'/index.php/Office/write_email/id/'+data[0].data+'.html';
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('button[name=email_add]').click(function(){
    var url = $('#url').val();
    var id = $('#id').val();
    var tel = new Array();
    for($i = 0 ;$i< $('button[name=teacher_name]').length; $i++){
        tel[$i] = $('button[name=teacher_name]:eq('+$i+')').attr('id');
    }
    var name = new Array();
    for($i = 0 ;$i< $('button[name=teacher_name]').length; $i++){
        name[$i] = $('button[name=teacher_name]:eq('+$i+')').val();
    }
    var content = UE.getEditor('container').getContent();
    var regtime = $('#regtime').val();
    if(regtime == ''){
        alert('发布日期必须选择');
        return false;
    }
    var title = $('#title').val();
    if(title === null || title === undefined || title == ''){
        alert('请填写标题名称');
        return false;
    };
    var tel_state = $('input[name=tel_state]:checked').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/email_add",
        type:'POST',
        data:{id:id,tel:tel,name:name,content:content,regtime:regtime,title:title,tel_state:tel_state},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert('保存成功');
                window.history.go(-1);
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$(document).on("click","button[name=email_file_del]",function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url: "http://" + url + "/index.php/Comment/email_file_del",
        type: 'POST',
        data: {id: id},
        dataType: 'json',
        success: function (data) {
            if (data[0].success = true) {
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});




$('.get_email_id').click(function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $('.file_get').html('');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_email_info",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                $('#title_get').html(data[0].notice['title']);
                $('.content_get').html(data[0].notice['content']);
                if(data[0].old == '1'){
                    for(var i = 0;i<data[0].file.length;i++){
                        a = "<a href="+data[0].file[i].path+">"+data[0].file[i].name+"</a></br>"
                        $('.file_get').append(a);
                    }
                }else{
                    for($i=0;$i<data[0].file.length;$i++){
                        a = "<a href= "+$('.public').val()+"/Uploads/img/"+data[0].file[$i].imgtime+"/"+data[0].file[$i].srcname+">"+data[0].file[$i].name+"</a> </br> "
                        $('.file_get').append(a);
                    }
                }
            }
        }
    })
});



//添加学校
$('#class_button').click(function(){
    var url = $('#url').val();
    var class_name = $('input[name=class_name]').val();
    if(class_name.length == 0){
        alert('班级名称不能为空');
        return false;
    }
    var class_inyear = $('select[name=class_inyear]').val();
    var class_type_bh = $('select[name=class_type_bh]').val();
    var ocode = $('.add_ocode').val();
    $.ajax({
        url: "http://" + url + "/index.php/School/add_class",
        type: 'POST',
        data: {class_name:class_name,class_inyear:class_inyear,class_type_bh:class_type_bh,ocode:ocode},
        dataType: 'json',
        success: function (data) {
            if(data['info'] == '没有权限'){
                alert(data['info']);
            }
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('button[name=class_find_update]').click(function(){
    var url = $('#url').val();
    var rec_id = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/class_find_update",
        type:'POST',
        data:{rec_id:rec_id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                $('input[name=class_name1]').val(data[0].data.class_name);
                $('input[name=rec_id]').val(data[0].data.rec_id);
                $('select[name=class_type_bh1]').val(data[0].data.class_type_bh);
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('#class_update_button').click(function(){
    var url = $('#url').val();
    var id = $('input[name=rec_id]').val();
    var class_name = $('input[name=class_name1]').val();
    var class_type_bh = $('select[name=class_type_bh1]').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/class_update_button",
        type:'POST',
        data:{rec_id:id,class_name:class_name,class_type_bh:class_type_bh},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('button[name=class_del_id]').click(function(){
    var url = $('#url').val();
    var id = $(this).attr('id');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/class_del_id",
        type:'POST',
        data:{rec_id:id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});


function Tab1(num)
{
    var i;
    for(i=3;i<=4;i++)
    {
        if(i==num)
            document.getElementById("l"+i).style.display="block";
        else
            document.getElementById("l"+i).style.display="none";
    }
}
// $('#Q1').click(function(){
//     $('#Q2').css('background','#fff');
//     $('#Q3').css('background','#fff');
//     $('#Q4').css('background','#fff');
//     $(this).css('background','#DD5302');
// });
// $('#Q2').click(function() {
//     $('#Q1').css('background', '#fff');
//     $('#Q3').css('background','#fff');
//     $('#Q4').css('background','#fff');
//     $(this).css('background', '#DD5302');

// })
$('#Q3').click(function() {
    // $('#Q1').css('background', '#fff');
    // $('#Q2').css('background','#fff');
    $('#Q4').css('background','#fff');
    $(this).css('background', '#DD5302');

});
$('#Q4').click(function() {
    // $('#Q1').css('background', '#fff');
    // $('#Q2').css('background','#fff');
    $('#Q3').css('background','#fff');
    $(this).css('background', '#DD5302');

});

$('.content').bind('input propertychange', function() {
    var num = $(this).val().length;
    var all_num = 230-num;
    if(all_num <= 0){
        all_num = 0;
    }
    $('.num').html(all_num);
});
$('.content1').bind('input propertychange', function() {
    var num = $(this).val().length;
    var all_num = 230-num;
    if(all_num <= 0){
        all_num = 0;
    }
    $('.num1').html(all_num);
});
$('.content2').bind('input propertychange', function() {
    var num = $(this).val().length;
    var all_num = 230-num;
    if(all_num <= 0){
        all_num = 0;
    }
    $('.num2').html(all_num);
});

$('.content3').bind('input propertychange', function() {
    var num = $(this).val().length;
    var all_num = 230-num;
    if(all_num <= 0){
        all_num = 0;
    }
    $('.num3').html(all_num);
});

$('select[name=classinfo]').change(function(){
    var url = $('#url').val();
    var class_bh  = $(this).val();
    var ocode_id = $('.ocode_id').val();
    //$('.mess_peo').html('');
    for(var i =0;i<$('.true_peo').length;i++){
        var chk = $('.true_peo').eq(i).attr('checked');
        var id = $('.true_peo').eq(i).attr('id');

        if(chk != 'checked'){
            $('.true_peo').eq(i).remove();
            var cl = "tip_"+id;
            $("."+cl).remove();
            //$(".tip_"+id).eq(i).html('');
        }

    }
    $.ajax({
        url:"http://"+url+"/index.php/Comment/classinfo?ocode_id="+ocode_id,
        type:'POST',
        data:{class_bh:class_bh},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                for($i=0;$i<data[0].data.length;$i++){
                    if(data[0].data[$i].vidflag == 0){
                       //$('#num_id2').append("<option value="+data[0].data[$i].area_bh+">"+data[0].data[$i].area_name+"</option>");
                      tr = "<input type='checkbox' id="+data[0].data[$i].rec_id+" class='true_peo'/> <label style='cursor:pointer' class=tip_"+data[0].data[$i].rec_id+" for="+data[0].data[$i].rec_id+">"+data[0].data[$i].stu_name+"</label> ";

                    }else{
                       tr = "<input type='checkbox' id="+data[0].data[$i].rec_id+" disabled='disabled'/> <label for="+data[0].data[$i].rec_id+" style='color:red'>"+data[0].data[$i].stu_name+"</label>&nbsp;";

                    }
                    $('.mess_peo').append(tr);
                }
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('.message_all').click(function(){
    var num = $('.true_peo');

    for($i=0;$i<num.length;$i++){
        if(num[$i].checked === false){
            num[$i].checked = true;
        }
    }
});
$('.message_allno').click(function(){
    var num = $('.true_peo');

    for($i=0;$i<num.length;$i++){
        if(num[$i].checked === true){
            num[$i].checked = false;
        }
    }
});

$('.one_send').click(function(){
    var url = $('#url').val();
    var regtime = $('#regtime').val();
    var identity = $('select[name=identity]').val();
    var content = $('.content').val();
    var id = new Array();
    for($i=0;$i<$('.mess_peo').children().length;$i++){
        id[$i] = $('.true_peo:checked:eq('+$i+')').attr('id');
    }
    if(id.length == 0){
        alert('请选择收信人');
        return false;
    }
    if(regtime == ''){
        alert('请选择发送时间');
        return false;
    }
    if(content.length == 0){
        alert('短信内容不能为空');
        return false;
    }
    if(content.length >= 230){
        alert('短信字数超出限额');
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/Office/one_send",
        type:'POST',
        data:{regtime:regtime,identity:identity,content:content,id:id},
        dataType:'json',
        success: function(data){
            if(data.info == '没有权限'){
                alert('没有权限');
                return false;
            }
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('select[name=classinfo1]').change(function(){
    var url = $('#url').val();
    var class_inyear  = $(this).val();
    var ocode = $('.ocode_id').val();

    $.ajax({
        url:"http://"+url+"/index.php/Comment/classinfo1?ocode_id="+ocode,
        type:'POST',
        data:{class_inyear:class_inyear},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                for($i=0;$i<data[0].data.length;$i++){
                        //$('#num_id2').append("<option value="+data[0].data[$i].area_bh+">"+data[0].data[$i].area_name+"</option>");
                        tr = "<input type='checkbox'  id="+data[0].data[$i].rec_id+" class='true_peo1'/> <label style='cursor:pointer' class=tip1_"+data[0].data[$i].rec_id+"  for="+data[0].data[$i].rec_id+">"+data[0].data[$i].class_name+"</label> &nbsp;";

                    $('.mess_peo1').append(tr);
                }
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('.message_all1').click(function(){
    var num = $('.true_peo1');

    for($i=0;$i<num.length;$i++){
        if(num[$i].checked === false){
            num[$i].checked = true;
        }
    }
});
$('.message_allno1').click(function(){
    var num = $('.true_peo1');

    for($i=0;$i<num.length;$i++){
        if(num[$i].checked === true){
            num[$i].checked = false;
        }
    }
});

//发班级
$('.all_send').click(function(){
    var url = $('#url').val();
    var regtime = $('#regtime1').val();
    var identity = $('select[name=identity1]').val();
    var content = $('.content1').val();
    var id = new Array();
    for($i=0;$i<$('.mess_peo1').children().length;$i++){
        id[$i] = $('.true_peo1:checked:eq('+$i+')').attr('id');
    }
    if(id.length == 0){
        alert('请选择收信人');
        return false;
    }
    if(regtime == ''){
        alert('请选择发送时间');
        return false;
    }
    if(content.length == 0){
        alert('短信内容不能为空');
        return false;
    }
    if(content.length >= 230){
        alert('短信字数超出限额');
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/Office/all_send",
        type:'POST',
        data:{regtime:regtime,identity:identity,content:content,id:id},
        dataType:'json',
        success: function(data){
            if(data.info == '没有权限'){
                alert('没有权限');
            }
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('.clear_peo').change(function(){
    $('.mess_peo2').html('');
});

$('.get_group_teacher').change(function(){
    var url = $('#url').val();
    var gid = $(this).val();

    for(var i =0;i<$('.true_peo2').length;i++){
        var chk = $('.true_peo2').eq(i).attr('checked');
        var id = $('.true_peo2').eq(i).attr('id');

        if(chk != 'checked'){
            $('.true_peo2').eq(i).remove();
            var cl = "tip2_"+id;
            $("."+cl).remove();
            //$(".tip_"+id).eq(i).html('');
        }

    }
    $.ajax({
        url:"http://"+url+"/index.php/Comment/get_group_teacher",
        type:'POST',
        data:{gid:gid},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                for($i=0;$i<data[0].data.length;$i++){
                    //$('#num_id2').append("<option value="+data[0].data[$i].area_bh+">"+data[0].data[$i].area_name+"</option>");
                    tr = "<p style='margin-right: 10px'><input type='checkbox' id="+data[0].data[$i].tel+" class='true_peo2' value="+data[0].data[$i].name+"  /> <label style='cursor:pointer;' class=tip2_"+data[0].data[$i].tel+"  for="+data[0].data[$i].tel+">"+data[0].data[$i].name+"</label></p>";

                    $('.mess_peo2').append(tr);
                }
            }else{

            }
        }
    })
});

$('.message_all2').click(function(){
    var num = $('.true_peo2');

    for($i=0;$i<num.length;$i++){
        if(num[$i].checked === false){
            num[$i].checked = true;
        }
    }
});
$('.message_allno2').click(function(){
    var num = $('.true_peo3');

    for($i=0;$i<num.length;$i++){
        if(num[$i].checked === true){
            num[$i].checked = false;
        }
    }
});

$('.message_all3').click(function(){
    var num = $('.true_peo3');

    for($i=0;$i<num.length;$i++){
        if(num[$i].checked === false){
            num[$i].checked = true;
        }
    }
});
$('.message_allno3').click(function(){
    var num = $('.true_peo3');

    for($i=0;$i<num.length;$i++){
        if(num[$i].checked === true){
            num[$i].checked = false;
        }
    }
});

//$(document).on("click",".all_send2",function(){
$('.all_send2').click(function(){
    var url = $('#url').val();
    var regtime = $('#regtime2').val();
    var identity = $('select[name=identity2]').val();
    var content = $('.content2').val();
    var tel = new Array();
    var name = new Array();
    for($i=0;$i<$('.true_peo2').length;$i++){
        if($('.true_peo2:eq('+$i+')').attr('checked') == 'checked'){
            tel[$i] = $('.true_peo2:eq('+$i+'):checked').attr('id');
            name[$i] = $('.true_peo2:eq('+$i+'):checked').val();
        }

    }
    if(tel.length == 0){
        alert('请选择收信人');
        return false;
    }
    if(regtime == ''){
        alert('请选择发送时间');
        return false;
    }
    if(content.length == 0){
        alert('短信内容不能为空');
        return false;
    }
    if(content.length >= 230){
        alert('短信字数超出限额');
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/Comment/all_send2",
        type:'POST',
        data:{regtime:regtime,identity:identity,content:content,tel:tel,name:name},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('.add_group').click(function(){
    var name = $('.name').val();
    if(name.length == 0){
        alert('分组名不能为空');
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/Public/add_group",
        type:'POST',
        data:{name:name},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('.del_group').click(function(){
    var id = $(this).attr('name');
    $.ajax({
        url:"http://"+url+"/index.php/Public/del_group",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('.add_my_peo').click(function(){
    var gid = $('input[name=sch_group_id]').val();
    var name = $('.my_name').val();
    if(name.length == 0){
        alert('姓名不能为空');
        return false;
    }
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    var tel = $('.my_tel').val();
    if(!myreg.test(tel))
    {
        alert('请输入有效的手机号码！');
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/Public/add_my_peo",
        type:'POST',
        data:{gid:gid,name:name,tel:tel},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('.del_my_friend').click(function(){
    var id = $(this).attr('name');
    $.ajax({
        url:"http://"+url+"/index.php/Public/del_my_friend",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('.edit_my_friend').click(function(){
    $('#model').modal('show');
    var id = $(this).attr('name');
    $.ajax({
        url:"http://"+url+"/index.php/Public/edit_my_friend",
        type:'POST',
        data:{id:id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                $('.my_name_val').val(data[0].data.name);
                $('.my_tel_val').val(data[0].data.tel);
                $('.my_id_val').val(data[0].data.id);
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('.edit_my_peo').click(function(){
    var name = $('.my_name_val').val();
    var id = $('.my_id_val').val();
    if(name.length == 0){
        alert('姓名不能为空');
        return false;
    }
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    var tel = $('.my_tel_val').val();
    if(!myreg.test(tel))
    {
        alert('请输入有效的手机号码！');
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/Public/edit_my_peo",
        type:'POST',
        data:{name:name,tel:tel,id:id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('select[name=get_friend_group]').change(function(){
    $('.mess_peo3').html('');
    var gid = $(this).val();
    $.ajax({
        url:"http://"+url+"/index.php/Public/get_friend_group",
        type:'POST',
        data:{gid:gid},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                for($i=0;$i<data[0].data.length;$i++){
                    //$('#num_id2').append("<option value="+data[0].data[$i].area_bh+">"+data[0].data[$i].area_name+"</option>");
                    tr = "<p style='margin-right: 10px'><input type='checkbox' id="+data[0].data[$i].id+" class='true_peo3' value="+data[0].data[$i].name+"  /> <label style='cursor:pointer' for="+data[0].data[$i].id+">"+data[0].data[$i].name+"</label></p>";

                    $('.mess_peo3').append(tr);
                }
            }else{
                alert(data[0].msg);
            }
        }
    })
});


$('.all_send3').click(function(){
    var regtime = $('#regtime3').val();
    var identity = $('select[name=identity3]').val();
    var content = $('.content3').val();
    var id = new Array();
    for($i=0;$i<$('.true_peo3').length;$i++){
        if($('.true_peo3:eq('+$i+')').attr('checked') == 'checked'){
            id[$i] = $('.true_peo3:eq('+$i+'):checked').attr('id');
        }

    }
    if(id.length == 0){
        alert('请选择收信人');
        return false;
    }
    if(regtime == ''){
        alert('请选择发送时间');
        return false;
    }
    if(content.length == 0){
        alert('短信内容不能为空');
        return false;
    }
    if(content.length >= 230){
        alert('短信字数超出限额');
        return false;
    }
    $.ajax({
        url:"http://"+url+"/index.php/Comment/all_send3",
        type:'POST',
        data:{regtime:regtime,identity:identity,content:content,id:id},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                alert(data[0].msg);
                window.location.reload();
            }else{
                alert(data[0].msg);
            }
        }
    })
});

$('input[name=reprot_btn1]').click(function(){
    var class_bh = $(this).attr('id');
    var course_bh = $('select[name=course_bh]').val()
    $.ajax({
        url:"http://"+url+"/index.php/Reprot/find_reprot",
        type:'GET',
        data:{class_bh:class_bh,course_bh:course_bh},
        dataType:'json',
        success:function(data){
            if(data.success == true) {
                    $('#container1').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Stacked column chart'
                        },
                        xAxis: {
                            categories: data.ocode
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Total fruit consumption'
                            },
                            plotLines: [{
                                color: 'red',           //线的颜色，定义为红色
                                dashStyle: 'solid',     //默认值，这里定义为实线
                                value: 85,               //定义在那个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
                                width: 2                //标示线的宽度，2px
                            },
                                {
                                    color: 'green',           //线的颜色，定义为红色
                                    dashStyle: 'solid',     //默认值，这里定义为实线
                                    value: 15,               //定义在那个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
                                    width: 2                //标示线的宽度，2px
                                }
                            ]
                        },
                        tooltip: {
                            pointFormat: '<span style="color:#ffffff">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                            shared: true
                        },
                        plotOptions: {
                            column: {
                                stacking: 'percent',
                                pointWidth: 30
                            }
                        },
                        series: [{
                            name: 'A',
                            data: [data.all_a],
                            color: '#ff0000'

                        }, {
                            name: 'B',
                            data: [data.all_b]
                        }, {
                            name: 'C',
                            data: [data.all_c]
                        }, {
                            name: 'F',
                            data: [data.all_d]
                        }, {
                            name: 'E',
                            data: [data.all_e]
                        }]
                    });
            }
        }
    })
});


$('.other_ocode1').change(function () {
    var ocode = $(this).val();
    $.ajax({
        url:"http://"+url+"/index.php/Office/do_message",
        type:'POST',
        data:{ocode:ocode},
        dataType:'json',
        success: function(data){

        }
    })
    window.location.href="http://"+url+"/index.php/Office/do_message?ocode="+ocode;

});

// $().ready(function(){

//     var nav_name = $('.nav_show').val();
//     if(nav_name == 'Center'){
//         $('ul[name=nav_0]').css('display','block');
//         $('ul[name=nav_0]').css('overflow','hidden');

//     }
//     if(nav_name == 'User'){
//         $('ul[name=nav_1]').css('display','block');
//         $('ul[name=nav_1]').css('overflow','hidden');

//     }
//     if(nav_name == 'School'){
//         $('ul[name=nav_2]').css('display','block');
//         $('ul[name=nav_2]').css('overflow','hidden');
//     }
//     if(nav_name == 'Rule'){
//         $('ul[name=nav_3]').css('display','block');
//         $('ul[name=nav_3]').css('overflow','hidden');
//     }
//     if(nav_name == 'Group'){
//         $('ul[name=nav_4]').css('display','block');
//         $('ul[name=nav_4]').css('overflow','hidden');
//     }
//     if(nav_name == 'Area'){
//         $('ul[name=nav_5]').css('display','block');
//         $('ul[name=nav_5]').css('overflow','hidden');
//     }
//     if(nav_name == 'Info'){
//         $('ul[name=nav_6]').css('display','block');
//         $('ul[name=nav_6]').css('overflow','hidden');
//     }
//     if(nav_name == 'Office'){
//         $('ul[name=nav_7]').css('display','block');
//         $('ul[name=nav_7]').css('overflow','hidden');
//     }
//     if(nav_name == 'Report'){
//         $('ul[name=nav_8]').css('display','block');
//         $('ul[name=nav_8]').css('overflow','hidden');
//     }

// });



function chose_a() {
    var id = $(this).attr('class');
    if(id == 'btn btn-default btn-xs'){
        $(this).attr('class','btn btn-danger btn-xs');
        return false;
    }else{
        $(this).attr('class','btn btn-default btn-xs');
        return true;
    }
}

$('#chose_b').click(function(){
    var id = $(this).attr('class');
    if(id == 'btn btn-default btn-xs'){
        $(this).attr('class','btn btn-danger btn-xs');
    }else{
        $(this).attr('class','btn btn-default btn-xs');
    }
});
$('#chose_c').click(function(){
    var id = $(this).attr('class');
    if(id == 'btn btn-default btn-xs'){
        $(this).attr('class','btn btn-danger btn-xs');
    }else{
        $(this).attr('class','btn btn-default btn-xs');
    }
});
$('#chose_d').click(function(){
    var id = $(this).attr('class');
    if(id == 'btn btn-default btn-xs'){
        $(this).attr('class','btn btn-danger btn-xs');
    }else{
        $(this).attr('class','btn btn-default btn-xs');
    }
});
$('#chose_e').click(function(){
    var id = $(this).attr('class');
    if(id == 'btn btn-default btn-xs'){
        $(this).attr('class','btn btn-danger btn-xs');
    }else{
        $(this).attr('class','btn btn-default btn-xs');
    }
});


$('.info_teacher').click(function () {
    var gid = $('.gid').val();
    $('.info_all_teacher').html('');
    $.ajax({
        url:"http://"+url+"/index.php/Comment/info_get_teacher",
        type:'POST',
        data:{gid:gid},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                for (var i = 0;i<data[0].data.length;i++){
                    if(data[0].data[i].state == 1){
                        p = "<p class='info_p' style='color:red;' id="+data[0].data[i].tea_mobile+">"+data[0].data[i].tea_name+"</p>";
                    }else{
                        p = "<p class='info_p' id="+data[0].data[i].tea_mobile+">"+data[0].data[i].tea_name+"</p>";
                    }

                    $('.info_all_teacher').append(p);
                }
            }
        }
    })
});

$(document).on('click','.info_p',function(){
    rgb = $(this).css('color');
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {return ("0" + parseInt(x).toString(16)).slice(-2);}
    rgb= "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    if(rgb != '#ff0000'){
        $(this).css('color','red');
        p = "<p class='info_chose_p' id='chose_"+$(this).attr('id')+"'>"+$(this).html()+"</p>";
        $('.info_chose_teacher').append(p);
    }

});
$(document).on('click','.info_chose_p',function(){
    $(this).remove();
    var id = $(this).attr('id');
    var ids = id.substring(6);
    $('#'+ids).css('color','#393939');
});


$('.info_clear').click(function(){

    for(var i = 0;i<$('.info_chose_teacher').children().length;i++){
        var id =$('.info_chose_p:eq('+i+')').attr('id');
        var ids = id.substring(6);
        $('#'+ids).css('color','#393939');
    }
    $('.info_chose_teacher').html('');
});

//一键添加
$('button[name=info_teacher_add]').click(function () {
    var tel =new Array();
    var name = new Array();
    for(var i = 0;i<$('.info_chose_teacher').children().length;i++){
        var id =$('.info_chose_p:eq('+i+')').attr('id');
        tel[i] = id.substring(6);
        var tea_name = $('.info_chose_p:eq('+i+')').html();
        name[i] = tea_name;
    }
    var gid  = $('.gid').val();
    $.ajax({
        url:"http://"+url+"/index.php/Comment/add_info_teac",
        type:'POST',
        data:{gid:gid,tel:tel,name:name},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){
                window.location.reload();
            }
        }
    })
});

$('.uploadExcel').click(function(){
    $('#uploadModal').modal('show');
});

$('.btn-testemail').click(function () {
    $.ajax({
        url:"http://"+url+"/index.php/Comment/testemail",
        type:'POST',
        data:{},
        dataType:'json',
        success: function(data){
            if(data[0].success == true){

            }
        }
    })
});






