/**
 * Created by Administrator on 2015/12/13.
 */
$(function ()
{
    var winH = $(window).height();
    var winW = $(window).width();
    var rightCart = $('#rightCart');
    rightCart.height(function(){
        return winH;
    }).css('left', function () {
        return parseInt(winW) - 25;
    }).css('display', 'block');

    rightCart.find('.list-group-item').height(function(){
        return winH/5;
    });

    $('.showCart').click(function () {
        var position = rightCart.position().left;
        var url = $(this).attr('data-url');

        //  ajax 请求购物车商品
        $.get(url, {}, function(msg){
            $('#CartInfo').empty().append(msg);

        },'html');

        if (position == winW - 300) {
        	a = winW - 25;
        } else {
            //  ajax 请求购物车商品
            $.get(url, {}, function(msg){
                $('#CartInfo').empty().append(msg);

            },'html');
            a = winW -300;
        }
        rightCart.animate({
            left: a
        }, '500');
    });


    /*
        首页搜索框
     */
    $('#search_menu').mouseover(function ()
    {
        $('.s-menu').stop().fadeIn();
    }).mouseout(function ()
    {
        $('.s-menu').stop().fadeOut();
    });

    /*             点击更换商品和店铺                    */
    $('#s-menu a').click(function () {
        console.log($(this).text());
        $('#s-menu').prev().html($(this).text() + ' <span class="caret"></span>');
    });

    $('#t-search-menu').mouseover(function ()
    {
        $('.s-menu').stop().fadeIn();
    }).mouseout(function ()
    {
        $('.s-menu').stop().fadeOut();
    });

    $('#t-menu a').click(function () {
        console.log($(this).text());
        $('#t-menu').prev().html($(this).text() + ' <span class="caret"></span>');
    });


    /**
     * 轮播左侧列表导航
     *
     */

    $('.left_list').mouseover(function () {
        $('.left_detail_box').stop().fadeIn(300);
    }).mouseout(function () {
        $('.left_detail_box').stop().fadeOut(300);
    });

    $('.add').mouseover(function () {
        var index = $(this).attr('data-index');

        $('.left_detail').css('display', function (i) {
            if (i == index) {
            	return 'block';
            }else {
                return 'none';
            }
        });
    });

    /**
     * 返回顶部
     *
     */
    $('#toTop').click(function () {
        clearInterval(timer);
        var timer = setInterval(function () {
            //  获取现在的值
            var h = $(window).scrollTop();
            //  设置速度
            var speed = h/6;
            //  设置值
            $(window).scrollTop(h - speed);
            if (h == 0) {
                clearInterval(timer);
            }
        }, 30);
    });
    $(window).scroll(function () {

        //var toTop = $('#toTop');
        //if ($(window).scrollTop() >= 600) {
        //    toTop.stop().fadeIn();
        //} else {
        //    toTop.stop().fadeOut();
        //}

        /**
         *      #fixed-top 页面向下滚动时 显示
         */
        var topSearch = $('#fixed-top');
        if ($(window).scrollTop() >= 300) {
            topSearch.stop().fadeIn('fast');
        } else {
            topSearch.stop().fadeOut('fast');
        }
    });
});