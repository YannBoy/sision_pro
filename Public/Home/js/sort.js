	$(function(){
		// 店铺详情悬浮事件
		$('.shop-score').hover(function(){
			$(this).attr('style','background:#f6f6f6;');
			$('.user-info').attr('style','background:#f6f6f6;');
			$('.shop-info').attr('style','display:block;');
		},function(){
			$(this).attr('style','background:#fff;');
			$('.user-info').attr('style','background:#fff');
			$('.shop-info').attr('style','display:none');
		});
		//全部商品
		$('.all').hover(function(){
			$(this).find('dl').attr('style','display:block;');
		},function(){
			$(this).find('dl').attr('style','display:none');
		});		

		//客服服务
		$('.custom_item').hover(function(){
			$(this).find('ol').show();
		},function(){
			$(this).find('ol').hide();
		});

		//店铺后台展开合并
		$('.box').find('h1').click(function(){
			var a = $(this).next().css('display');
			if (a == 'none') {
				$(this).css('color','#333')
				.next().slideDown();
			}else {
				$(this).css('color','#888')
				.next().slideUp();
			}
		});

		//店铺分类
		$('#addTr').click(function(){
			var index = $('.ass').find('tr').length;
			var newtr = $('#add').clone(true).attr('id', 'newtr'+index).appendTo($('.ass'))
				.css('display','block').attr('index', index);
			newtr.find('span').first().text(index);
			newtr.find('.cancel').attr('cancel',index);
		});
		$('.cancel').click(function(){
			var a = $(this).attr('cancel');
			$("#newtr"+a).remove();
		});

        /************* 评论选项卡 **************/
        $('.tabbar-list').find('li').click(function () {
            $(this).addClass('selected').siblings().removeClass('selected');
            var index = $(this).attr('index');
            $('#'+index).removeClass('hidden').addClass('show')
                .siblings().removeClass('show').addClass('hidden')
        });
		


        //收藏店铺悬停事件
		$('.coll').hover(
			function(){
				$(this).children().last().css('display','block');
			},
			function(){
				$(this).children().last().css('display','none');
			}
		);
		

		//用户注销
		$('.logut').click(function(){
            var url = location.href;
            $.ajax({
                url: logut,
                type:'post',
                data:{url:url},
                async:true,         
                dataType:"json",    //响应数据格式
                success:function(data){ //成功回调函数
                    if(data==1){
                        window.location.reload();
                    }else{
                        alert('注销失败');
                    }
                },
                error:function(){   //失败回调函数
                    alert("ajax请求失败!");
                }
            });
        });
	});
	