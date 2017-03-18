


//查看学校之间作比较信息
$('button[name=ocode_select]').click(function(){
    var course_bh = $('select[name=course_bh]').val();
    text = $(".ocode:checked").map(function(index,elem) {
        return $(elem).val();
    }).get().join(',');
    if(text.length == 0){
        alert('请选择要查看的学校');
    }else{
        $.ajax({
            url:"http://"+url+"/project/index.php/Admin/Reprot/ocode_compare",
            type:'GET',
            data:{ocode:text,course_bh:course_bh},
            dataType:'json',
            success:function(data){
                if(data.success == true){
                    $('#container').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Stacked column chart'
                        },
                        xAxis: {
                            categories: '111'
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
                            data: data.all_a,
                            color: '#ff0000'
                        }, {
                            name: 'B',
                            data: data.all_b
                        }, {
                            name: 'C',
                            data: data.all_c
                        }, {
                            name: 'F',
                            data: data.all_d
                        }, {
                            name: 'E',
                            data: data.all_e
                        }]
                    });
                }
            }
        })
    }
});


