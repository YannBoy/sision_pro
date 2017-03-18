$(function ()
{
    var aNum = $('.skin').children().length;
    $('#toCart').click(function ()
    {
        var gid = $(this).attr('gid');
        var u = $(this).attr('data');

        getAttr(gid, function (param)
        {
            $.post(u, param, function (msg)
            {
                if (msg)
                {
                    alert('添加成功');
                    $('.numCircle').text(function(i, v){
                        return parseInt(v)+msg;
                    });
                }
            }, 'json');
        });
    });

    $('#js-pic-thumb').find('img').mouseover(function ()
    {
        $('#dtp').attr('src', $(this).attr('src'));
        $('#fdj').find('img').attr('src', $(this).attr('src'));
    });

    //$('#dtp').mousemove(function (e)
    //{
    //    var x = e.pageX - $(this).offset().left;
    //    var y = e.pageY - $(this).offset().top;
    //
    //    $('#fdj').scrollTop(0.7 * y).scrollLeft(0.7 * x).fadeIn('fast');
    //
    //}).mouseout(function ()
    //{
    //    $('#fdj').fadeOut('fast')
    //});

    /**
     颜色尺码选择
     */
    $('.item-size-types').find('button').click(function ()
    {
        if ($(this).hasClass('item-size-type-choose'))
        {
            $(this).removeClass('item-size-type-choose');
            $('#toCart').attr('disabled', true);
        } else
        {
            $(this).addClass('item-size-type-choose').parent().siblings().find('button')
                .removeClass('item-size-type-choose');
            var c = $('.item-size-type-choose').length;
            if (c == aNum)
            {
                //  发 ajax 查库存
                var gid = $('#toCart').attr('gid');
                getAttr(gid, function (param)
                {
                    $.post(url, param, function (msg)
                    {
                        console.log(msg);
                        //return;
                        //  返回库存结果
                        $('#item-stock-reserve').find('span').text(msg['stock']);

                        if (msg == '0')
                        {
                            $('#item-stock-reserve').find('span').text(msg);
                            $('#toCart').attr('disabled', true);
                        } else
                        {
                            $('#J_NowPrice').text(msg['price']);
                            $('#toCart').attr('disabled', false);
                        }
                    }, 'json');
                });
            } else
            {
                $('#toCart').attr('disabled', true);
            }
        }
    });

    /*************** 获取选择的商品的属性参数 ******************/
    var getAttr = function (gid, fn)
    {
        var param = '';
        //  获取属性名 id 属性值 id
        param += 'gid=' + gid;

        var attr = [];
        var choose = $('.item-size-type-choose');
        if (choose.length == 0)
        {
            return;
        }
        choose.each(function (i)
        {
            var attrN = $(this).attr('attr-n');
            var attrV = $(this).attr('attr-v');
            param += '&' + attrN + '=' + attrV;
        });

        //  获取商品数量
        var num = $('#item-stock-num').text();
        param += '&num=' + num;

        if (fn)
        {
            fn(param);
        }
    };

    /**
     购买数量 点击增加和减少
     */
    $('#numUp').click(function ()
    {
        $('#item-stock-num').text(function (i, val)
        {
            var totle = $('#item-stock-reserve').find('span').text();
            if (val == totle)
            {
                return val;
            } else
            {
                return parseInt(val) + 1;
            }
        });
    });
    $('#numDown').click(function ()
    {
        $('#item-stock-num').text(function (i, val)
        {
            if (val == '1')
            {
                return val;
            } else
            {
                return parseInt(val) - 1
            }
        });
    });

    /**************** ajax请求评论 ****************/
    $('#comments #pages').on("click", 'a', function () {
        var url = $(this).attr('href');

        $.get(url, {}, function(msg){
            $('#comments').empty().append(msg);
        }, 'html');
        return false;
    });
});

