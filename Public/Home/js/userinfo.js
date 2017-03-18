$(function(){
	//所在地的验证(添加地址)
	$('#sheng').change(function(){

		var a = $(this).val();
		var url = 'infoAjax';
		var str = '';

		$.get(url, {id: a}, function(msg){
			//	显示 市
			$.each(msg, function(i, v){

				str += '<option value="'+v['id']+'">'+v['name']+'</option>';
			});
			$('#shi').empty().append(str);

		}, 'json');
	});

	//城市级联区的验证
	$('#shi').change(function(){
		var a = $(this).val();
		var url = 'addressAjax';
		var str = '';
		//发送ajax
		$.post(url,{id:a},function(msg){
			//显示县区
			//遍历
			str = '<option value="">--请选择--</option>';
			$.each(msg,function(i, v){
				str += '<option value="'+v['id']+'">'+v['name']+'</option>'
			});
			$('#xian').empty().append(str);

		},'json');
	});

	/**********************************************************************************/
	/**********************************************************************************/

	//所在地的验证(退货地址)
	$('#t_sheng').change(function(){

		var a = $(this).val();
		var url = 'infoAjax';
		var str = '';

		$.get(url, {id: a}, function(msg){
			//	显示 市
			$.each(msg, function(i, v){

				str += '<option value="'+v['id']+'">'+v['name']+'</option>';
			});
			$('#t_shi').empty().append(str);

		}, 'json');
	});

	//城市级联区的验证
	$('#t_shi').change(function(){
		var a = $(this).val();
		var url = 'addressAjax';
		var str = '';
		//发送ajax
		$.post(url,{id:a},function(msg){
			//显示县区
			//遍历
			str = '<option value="">--请选择--</option>'
			$.each(msg,function(i, v){
				str += '<option value="'+v['id']+'">'+v['name']+'</option>'
			});
			$('#t_xian').empty().append(str);

		},'json');
	});


	/**********************************************************************************/
	/**********************************************************************************/
	/**********************************************************************************/

	/**

	对用户名做验证

	**/

	$('#unick').blur(function(){
		// console.log('aaa');
		var url = 'getNickname';
		var v = $(this).val();
		var that = $(this);
		$.post(url ,{nickname:v}, function(aa){
			if(aa == 3){
				alert('您的用户名已经存在,请重新输入');
				that.val('');
			}
		})
	});

	//个人标签的聚焦事件(显示标签div)
	$('#user_style').focus(function(){

		var d_tag = $(this).val();
		if(d_tag == '多个标签之间请用逗号隔开'){
			$('#user_style').val('');

		}
		$(this).siblings(".fashion_list").css('background', 'white').fadeIn('fast');

	});

	//点击a链接,input中获取a链接的值
	// $('.fashion_list').children().click(function(){
	$('.tag a').click(function(){

		var t = $(this).text();

		$('#user_style').val(function(i, v){

			return v+' '+t;

		}).next().fadeOut();


	});

	/**********************************************************************************/
	/**********************************************************************************/
	/**********************************************************************************/

	/**

	地址管理

	**/

	//添加新地址(显示地址填写框)
	$(".saddspan").click(function(){
		$(".saddress_pop").attr('style','display:block');
	});

	//点击取消(隐藏地址填写框)
	$(".scancel_btn").click(function(){
		$(".saddress_pop").attr('style','display:none');
	});

	/**

		创建新地址验证

	**/

	//输入框验证
	var postcode = false;
	$(".spostcode").blur(function(){
		postcode = false;
		var str = $(this).val();
		var reg = /^\d{6}$/;
		var res = reg.test(str);
		if(res){
			$(".spostcode").attr('style','border:1px solid green');
			return true;
		}else{
			$(".spostcode").attr('style','border:1px solid red');
			return false;
		}
	});

	//街道
	var dizhi = false;
	$(".saddress").blur(function(){
		dizhi = false;
		var str = $(this).val();
		if(str){
			$(".saddress").attr('style','border:1px solid green');
			return true;
		}else{
			$(".saddress").attr('style','border:1px solid red');
			return false;
		}
	});

	//姓名
	var name = false;
	$(".sname").blur(function(){
		name = false;
		var str = $(this).val();
		if(str){
			$(".sname").attr('style','border:1px solid green');
			return true;
		}else{
			$(".sname").attr('style','border:1px solid red');
			return false;
		}
	});

	//手机
	var phone = false;
	$(".sphone").blur(function(){
		phone = false;
		var str = $(this).val();
		var reg = /^1\d{10}$/;
		var res = reg.test(str);
		if(res){
			$(".sphone").attr('style','border:1px solid green');
			return true;
		}else{
			$(".sphone").attr('style','border:1px solid red');
			return false;
		}
	});

	/**

	点击确认按钮,显示添加地址,隐藏添加地址框

	**/
	$(".sconfirm_btn").click(function(){

		$('.spostcode, .saddress, .sname, .sphone').trigger('blur');
		var dizhi = $(".vm").val();
		var postcode = $(".spostcode").val();
		//获取街道的值
		var address = $(".saddress").val();
		var name = $(".sname").val();
		var phone = $(".sphone").val();
		if(dizhi && postcode && address && name && phone){
			return true;
			$(".saddress_pop").attr('style','display:none');
			$(".saddr_section").attr('style','display:block');

		}
		return false;


	});


	/**

	默认,修改,删除

	**/

	//修改默认
	$(".s_default").click(function(){

		// var did = null;
		// var I = null;

		// $('.sdefault').attr('checked', function(i, v){
		// 	if(v){
		// 		did = $(this).val();
		// 		I = i;
		// 	}
		// });
		var url = "defaultress";
		var zhi = $(this).attr('index');
		// console.log(zhi);return;
		var id = $('#adr'+zhi).val();
		var t = $(this);
		$.get(url,{id:id},function(msg){
			if(msg){

				t.parents('.default').siblings().find('input').each(function(){
					this.checked = false;
				})
				t.parents('.default').find('input').each(function(){
					this.checked = true;
				})
				//之前被选中的checked更改
				// $('.sdefault:eq('+I+')').attr('checked',false);
				//点击的checked改为true
				// $('#adr'+id).attr('checked',true);
			}
		})
	});

	//修改地址
	$(".s_edit").click(function(){
		//获取点击的id值
		var id = $(this).attr('index');
		// var name = $(this).parent().siblings().eq(0);
		//获取姓名
		var na = $(this).parent().siblings().first();
		var name = na.text();
		//获取地址(省,市,区,街道)
		var she = $(this).parent().siblings().eq(1).children("span").first();
		var si = $(this).parent().siblings().eq(1).children("span").eq(1);
		var xa = $(this).parent().siblings().eq(1).children("span").eq(2);
		var adr = $(this).parent().siblings().eq(1).children("span").last();

		var sheng = she.text();
		var shi = si.text();
		var xian = xa.text();
		var adress = adr.text();
		//获取邮编
		var yb = $(this).parent().siblings().eq(2);
		var postcode = yb.text();
		//获取电话
		var tel = $(this).parent().siblings().last();
		var phone = tel.text();

		//将行内的数据放入隐藏框中
		$(".id").val(id);
		$(".sname").val(name);
		$("#sheng").children().first().text(sheng);
		$("#shi").children().first().text(shi);
		$("#xian").children().first().text(xian);
		$(".saddress").val(adress);
		$(".spostcode").val(postcode);
		$(".sphone").val(phone);

		//弹出地址填写框
		$(".saddress_pop").attr('style','display:block');

	});


	/**

		删除地址

	**/

	// $(".s_del").click(function(){
	// 	var url = 'delress';
	// 	var id = $(this).attr('index');
	// 	$.get(url,{id:id},function(msg){
	// 		if(msg){
	// 			//在不刷新的情况下,移除地址框
	// 			$('.s_del:eq('+id+')').parent().parent().parent().remove();
	// 		}
	// 	})
	// })


	/**********************************************************************************/
	/**********************************************************************************/
	/**********************************************************************************/

	/**

	退货新地址

	**/

	//添加新地址(显示地址输入框)
	$(".taddspan").click(function(){

		$(".taddress_pop").attr('style','display:block');
	});

	//点击取消(隐藏地址填写框)
	$(".tcancel_btn").click(function(){
		$(".taddress_pop").attr('style','display:none');
	});


	/**

		提交验证

	**/

	// 输入框验证
	var postcode = false;
	$(".tpostcode").blur(function(){
		postcode = false;
		var str = $(this).val();
		var reg = /^\d{6}$/;
		var res = reg.test(str);
		if(res){
			$(".tpostcode").attr('style','border:1px solid green');
			return true;
		}else{
			$(".tpostcode").attr('style','border:1px solid red');
			return false;
		}
	});

	//街道
	var dizhi = false;
	$(".taddress").blur(function(){
		dizhi = false;
		var str = $(this).val();
		if(str){
			$(".taddress").attr('style','border:1px solid green');
			return true;
		}else{
			$(".taddress").attr('style','border:1px solid red');
			return false;
		}
	});

	//姓名
	var name = false;
	$("#tname").blur(function(){
		name = false;
		var str = $(this).val();
		if(str){
			$("#tname").attr('style','border:1px solid green');
			return true;
		}else{
			$("#tname").attr('style','border:1px solid red');
			return false;
		}
	});

	//手机
	var phone = false;
	$(".tphone").blur(function(){
		phone = false;
		var str = $(this).val();
		var reg = /^1\d{10}$/;
		var res = reg.test(str);
		if(res){
			$(".tphone").attr('style','border:1px solid green');
			return true;
		}else{
			$(".tphone").attr('style','border:1px solid red');
			return false;
		}
	});

	/**

	点击确认按钮,显示添加地址,隐藏添加地址框

	**/
	$(".tconfirm_btn").click(function(){

		$('.tpostcode, .taddress, #tname, .tphone').trigger('blur');
		var dizhi = $(".tvm").val();
		var postcode = $(".tpostcode").val();
		//获取街道的值
		var address = $(".taddress").val();
		var name = $("#tname").val();
		var phone = $(".tphone").val();


		if(dizhi && postcode && address && name && phone){
			$(".taddress_pop").attr('style','display:none');
			$(".taddr_section").attr('style','display:block');

		}else{
			return false;
		}

	});


	/**

	默认,修改,删除(退货地址)

	**/

	//修改默认
	$(".t_default").click(function(){

		var url = "tdefaultress";
		//获取当前的索引值
		var zhi = $(this).attr('index');
		//点击默认对应的行内数据id
		var id = $('#adr'+zhi).val();
		var that = $(this);
		$.get(url,{id:id},function(msg){
			if(msg){
				that.parents('.default').siblings().find('input').each(function(){
					this.checked = false;
				})
				that.parents('.default').find('input').each(function(){
					this.checked = true;
				})
			}
		})
	});

	//修改退货地址
	$(".t_edit").click(function(){
		//获取点击的id值
		var id = $(this).attr('index');
		//获取姓名
		var na = $(this).parent().siblings().first();
		var name = na.text();
		//获取地址(省,市,区,街道)
		var she = $(this).parent().siblings().eq(1).children("span").first();
		var si = $(this).parent().siblings().eq(1).children("span").eq(1);
		var xa = $(this).parent().siblings().eq(1).children("span").eq(2);
		var adr = $(this).parent().siblings().eq(1).children("span").last();

		var sheng = she.text();
		var shi = si.text();
		var xian = xa.text();
		var adress = adr.text();
		//获取邮编
		var yb = $(this).parent().siblings().eq(2);
		var postcode = yb.text();
		//获取电话
		var tel = $(this).parent().siblings().last();
		var phone = tel.text();

		//将行内的数据放入隐藏框中
		$(".tid").val(id);
		$("#tname").val(name);
		$("#t_sheng").children().first().text(sheng);
		$("#t_shi").children().first().text(shi);
		$("#t_xian").children().first().text(xian);
		$(".taddress").val(adress);
		$(".tpostcode").val(postcode);
		$(".tphone").val(phone);

		//弹出地址填写框
		$(".taddress_pop").attr('style','display:block');

	});


	/**

		删除地址

	**/

	// $(".t_del").click(function(){
	// 	var url = 'delress';
	// 	var id = $(this).attr('index');
	// 	$.get(url,{id:id},function(msg){
	// 		if(msg){
	// 			//在不刷新的情况下,移除地址框
	// 			$('.t_del:eq('+id+')').parent().parent().parent().remove();
	// 		}
	// 	})
	// })



});