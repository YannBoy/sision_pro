/**
 * Created by Administrator on 2015/12/17.
 */

$(function ()
{
    //  省市联动
    $('#sheng').change(function ()
    {
        var adr = $(this).val();
        $.get(urlForAdress, {upid: adr}, function (msg)
        {
            var str = '';
            $.each(msg, function (i, v)
            {
                str += '<option value="' + v.id + '">' + v.name + '</option>';
            });
            $('#shi').empty().append(str);
        }, 'json');
    });

    //  市县联动
    $('#shi').change(function ()
    {
        var adr = $(this).val();
        $.get(urlForAdress, {upid: adr}, function (msg)
        {
            var str = '';
            $.each(msg, function (i, v)
            {
                str += '<option value="' + v.id + '">' + v.name + '</option>';
            });
            $('#xian').empty().append(str);
        }, 'json');
    });

    //  邮政编码验证
    var postal = false;
    $('#postal').blur(function ()
    {
        postal = false;
        var reg = /^\d{6}$/;
        var str = $(this).val();
        var res = reg.test(str);
        if (checkEmpty(res, $(this)))
        {
            postal = true;
        }
    });

    //  收货人姓名
    var username = false;
    $('#username').blur(function ()
    {
        username = false;
        var name = $(this).val(), res;
        if (name == '')
        {
            res = false;
        } else
        {
            res = true;
        }

        if (checkEmpty(res, $(this)))
        {
            username = true;
        }
    });
    var address = false;
    $('#address').blur(function ()
    {
        address = false;
        var addr = $(this).val(), res;

        if (addr == '')
        {
            res = false;
        } else
        {
            res = true;
        }

        if (checkEmpty(res, $(this)))
        {
            address = true;
        }
    });

    //  手机号
    var phone = false;
    $('#phone').blur(function ()
    {
        phone = false;
        var reg = /^1\d{10}$/;
        var str = $(this).val();
        var res = reg.test(str);
        if (checkEmpty(res, $(this)))
        {
            phone = true;
        }
    });

    //
    function checkEmpty(res, obj)
    {
        if (res)
        {   //  成功
            obj.parent().parent().removeClass('has-error');
            obj.siblings().remove();
            return true;
        } else
        {
            obj.parent().append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>')
                .parent().addClass('has-error');
            return false;
        }
    }

    //  地址提交
    $('#make_adr_form').click(function ()
    {
        $('#phone, #username, #address, #postal').trigger('blur');
        if (phone && address && username && postal)
        {
            $.post(urlAddAdress, {adrInfo: $('#adr_form').serializeArray()}, function (msg)
            {
                if (msg)
                {
                    $('.adr_form').removeClass('show').addClass('hidden');
                    location.href = location.href;
                }
            }, 'json');
        }

        return false;
    });

    /**************** 地址 ******************/
    var adrList = $('.adr-list');
    $('#adrid').val(adrList.first().attr('data-id'));

    //  地址选择
    adrList.click(function ()
    {
        //  判断被点击的地址是否已经被选中了
        if ($(this).hasClass('adr-checked'))
        {
            return;
        } else
        {
            //  没有选中时  给予选中的样式
            $(this).addClass('adr-checked').parent().siblings().find('.adr-list')
                .removeClass('adr-checked');
            var adrid = $(this).attr('data-id');
            $('#adrid').val(adrid);
        }
    });

    //  显示填写新地址的表单
    $('#make_adr_btn').click(function ()
    {
        $('.adr_form').removeClass('hidden').addClass('show');
    });

    //  取消填写新地址
    $('#cancel_make_adr').click(function ()
    {
        $('.adr_form').removeClass('show').addClass('hidden');
    });

    /************** 总价格显示 ***************/
    var total_price = 0;
    $('.price').text(function (i, v)
    {
        total_price += parseInt(v);
    });
    $('.total_price').find('span').text(total_price);
    //  设置隐藏域
    $('#price_hidden').val(total_price);

    /************** 提交 *************/
    $('#goodsForm').submit(function ()
    {
        var data = $(this).serialize();
        $.ajax({
            type: "POST",
            url: subUrl,
            data: data,
            async: false,
            success: function(msg){
                if (msg)
                {
                    $('#orderid').val(msg);
                    return true;
                }else {
                    return false;
                }
            }
        });
    });
});