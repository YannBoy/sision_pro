/**
 * Created by Administrator on 2015/12/22.
 */
$(function () {
    $('#btn-sub').click(function ()
    {
        var url = $(this).attr('url');
        if (payMethod == '') {
            $('#stantard-dialogBox').dialogBox({
                hasClose: true,
                time: 3000,
                width: 260,
                title: '<h3>请选择支付方式</h3>'

            });
            return;
        }
        $('#type-dialogBox').dialogBox({
            width: 400,
            height: 280,
            hasClose: true,
            hasMask: true,
            hasBtn: true,
            effect: 'flip-horizontal',
            confirmValue: '确定',
            confirm: function(){
                setTimeout(function(){

                    var ordernum = $('#ordernum').text();
                    window.open('http://www.mg.com/index.php/Home/Order/payAction?ordernum='+ordernum);
                }, 450);
            },
            cancelValue: '算了',
            title: '支付吧',
            content: '<h3>用'+payMethod+'支付</h3>'
        });
    });

    /*************** 获取选择的支付方式 ****************/
    var payMethod = '';
    $('.thumbnail').click(function () {
        payMethod = $(this).attr('index');
    });
});
