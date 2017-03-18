/**
 * Created by Administrator on 2015/12/20.
 */
$(function () {
    $("input[type=checkbox]").attr('checked', false);

    /**** 全选按钮 ****/
//  s_all => select_all
    var a = [];
    $("#s_all").click(function ()
    {
        a.length = 0;
        $('.check').prop('checked', function (i, v)
        {
            if (!v)
            {
                //  计算总价
                a.push($(this).attr('name'));
                $('#xj'+i).addClass('cs');
            }
            return true;
        });
        getTotalPrice();
    });

    /****** 取消选择 ********/
    $('#s_no').click(function ()
    {
        a.length = 0;
        $('.check').prop('checked', function (i, v)
        {
            $('#xj'+i).removeClass('cs');
            return false;
        });
        getTotalPrice();
    });

//  单个商品点击时计算总价格
    $('.check').click(function ()
    {
        var d = $(this).attr('name');
        var e = $.inArray(d, a);
        var index = $(this).attr('index');

        if (e == -1)
        {
            a.push($(this).attr('name'));
            $('#xj'+index).addClass('cs');
        } else
        {
            a.splice(e, 1);
            $('#xj'+index).removeClass('cs');
        }
        getTotalPrice();
    });

//  总计中的 商品个数
    $('.total_num').find('span').text(function ()
    {
        return $('tbody').length;
    });

//  总计中的 总价格
    var p = 0;
    var getTotalPrice = function ()
    {
        p = 0;
        $.each(a, function (i)
        {
            var b = $('#' + a[i]).find('.price').text();
            p += parseInt(b);
        });
        $('.total_price').find('span').text(p);
        if (p == 0)
        {
            $('button[type=submit]').attr('disabled', true).removeClass('btn-success').addClass('btn-default');
        } else
        {
            $('button[type=submit]').attr('disabled', false).removeClass('btn-default').addClass('btn-success');
        }
    };

    /******** 商品数量增减 *************/
//  增
    $('.addNum').click(function ()
    {
        var index = $(this).attr('index');
        $(this).prev().val(function (i, v)
        {
            var n = parseInt(v);
            if (n >= 100)
            {
                return 100;
            }
            $('#xj'+index).text(function (i, v)
            {
                //  获取数量
                var a = $('#gNum'+index).val();
                //  获取单价
                var b = $('#single-price'+index).text();
                var tP = (parseInt(a)+1)*parseInt(b);
                $('#hxj'+index).val(tP);
                return tP;
            });
            getTotalPrice();
            return parseInt(v) + 1;
        });
    });
//  减
    $('.cutNum').click(function ()
    {
        var index = $(this).attr('index');
        $(this).next().val(function (i, v)
        {
            var n = parseInt(v);
            if (n == 0)
            {
                return 0;
            }
            $('#xj'+index).text(function (i, v)
            {
                //  获取数量
                var a = $('#gNum'+index).val();
                //  获取单价
                var b = $('#single-price'+index).text();
                var tP = parseInt(a-1)*parseInt(b);
                $('#hxj'+index).val(tP);
                return tP;
            });
            getTotalPrice();
            return parseInt(v) - 1;
        });
    });

    /******** 删除购物车中的商品 ********/
    $('.delCart').click(function(){

        var sku = $(this).attr('data-sku');
        var gid = $('#'+sku).attr('goodsid');

        $.get(delCartUrl, {skuid: sku, gid: gid}, function(msg){
            if (msg) {
                $('#'+sku).animate({
                    height: 0
                }, '500', function(){
                    $(this).remove();
                    p = 0;
                    $('.cs').text(function (i, v)
                    {
                    	p = parseInt(v);
                    });

                    $('.total_price').find('span').text(p);
                    if (p == 0)
                    {
                        $('button[type=submit]').attr('disabled', true).removeClass('btn-success').addClass('btn-default');
                    } else
                    {
                        $('button[type=submit]').attr('disabled', false).removeClass('btn-default').addClass('btn-success');
                    }
                });
            }
        }, 'json');
    });

    /************ 确认按钮 ***********/
    $('button[type=submit]').click(function () {
        //console.log($('#CartForm').serialize());
        $.post('toS', $('#CartForm').serialize(), function(msg){
            if (msg)
            {
                var url = $('#CartForm').attr('action');
                location.href = url;
            }
        }, 'html');
        return false;
    });
});
