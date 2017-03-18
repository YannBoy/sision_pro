<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge, Chrome=1" />
		<title><?php echo ($ocode_name); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="/Public/Admin/assets/js/uploadify/uploadify.css" rel="stylesheet" />
		<script src='/Public/Admin/js/jquery-1.8.3.min.js'></script>

		<script type="text/javascript" src="/Public/Admin/assets/js/uploadify/jquery.uploadify.min.js"></script>
		<!--<script language="JavaScript" src="/Public/Admin/assets/js/mydate.js"></script>-->

		<script language="JavaScript" src="/Public/Admin/assets/js/bootstrap-datetimepicker.js"></script>
		<link href="/Public/Admin/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
		<!-- basic styles -->
		<link href="/Public/Admin/assets/css/bootstrap.min.css" rel="stylesheet" />

		<link rel="stylesheet" href="/Public/Admin/assets/css/font-awesome.min.css" />
		<link rel="stylesheet" href="/Public/Admin/assets/css/admincss.css" />
		<!--[if IE 7]>
		<link rel="stylesheet" href="/Public/Admin/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->


		<!-- ace styles -->

		<link rel="stylesheet" href="/Public/Admin/assets/css/ace.min.css" />
		<link rel="stylesheet" href="/Public/Admin/assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/Public/Admin/assets/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="/Public/Admin/assets/css/ace-ie.min.css" />

		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="/Public/Admin/assets/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="/Public/Admin/assets/js/html5shiv.js"></script>
		<script src="/Public/Admin/assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<input type="hidden" class="nav_show" value="<?php echo ($nav_show); ?>">
	<input type="hidden" id="oa_url" value="<?php echo $_SERVER['HTTP_HOST'] ?>"/>
	<body <?php if($color == ''): ?>class='' <?php else: ?> class='<?php echo ($color); ?>'<?php endif; ?> >
		<?php echo W("Header/getHeader");?>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<?php echo ($ocode_name); ?>
							<a style="color: white" href="<?php echo U('Admin/Login/lyout');?>">
							<button class="btn btn-success btn-xs">
								<span>退出</span>
							</button>
							</a>

						</div>

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div>

                    <!--<ul>-->
                        <!--<?php foreach($data as $k=>$v ) { ?>-->
                        <!--<li><?php echo $k?></li>-->
                        <!--<ul>-->
                            <!--<?php foreach($v as $val ) { ?>-->
                            <!--<li><?php echo $val['nav_name']; echo $val['src']?></li>-->
                            <!--<?php }?>-->
                        <!--</ul>-->
                        <!--<?php }?>-->
                    <!--</ul>-->

					<ul class="nav nav-list">
						<li class="active">
							<a href="<?php echo U('Index/index');?>">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> 首页 </span>
							</a>
						</li>


						<!--<li>-->
							<!--<a href="<?php echo U('Office/oa_file');?>" class="dropdown-toggle" >-->
								<!--<i class="icon-inbox"></i>-->
								<!--<span class="menu-text"> 文件办理 </span>-->

							<!--</a>-->
						<!--</li>-->
						<!--<li>-->
							<!--<a href="<?php echo U('Office/email');?>" class="dropdown-toggle" >-->
								<!--<i class="icon-inbox"></i>-->
								<!--<span class="menu-text"> 内部邮件 </span>-->

							<!--</a>-->
						<!--</li>-->
						<!--<li>-->
							<!--<a href="<?php echo U('Office/notice');?>" class="dropdown-toggle" >-->
								<!--<i class="icon-inbox"></i>-->
								<!--<span class="menu-text"> 内部通知 </span>-->

							<!--</a>-->
						<!--</li>-->
						<!--<li>-->
							<!--<a href="<?php echo U('Office/resources');?>" class="dropdown-toggle" >-->
								<!--<i class="icon-download"></i>-->
								<!--<span class="menu-text"> 资源平台 </span>-->

							<!--</a>-->
						<!--</li>-->
						<!--<li>-->
							<!--<a href="<?php echo U('Office/do_message');?>" class="dropdown-toggle" >-->
								<!--<i class="icon-home"></i>-->
								<!--<span class="menu-text"> 短信平台 </span>-->

							<!--</a>-->
						<!--</li>-->


						<?php $i = 0;?>
                        <?php foreach($data_nav as $k=>$v ) { ?>
                        <li >

                            <a href="#" class="dropdown-toggle">
                                <i class="icon-comment"></i>
                                <span class="menu-text"> <?php echo $k?> </span>

                                <b class="arrow icon-angle-down"></b>
                            </a>

                            <ul class="submenu" name="nav_<?php echo $i ?>">
                                <?php foreach($v as $val ) { ?>
                                <li>
                                    <?php $src = $val['src']?>
                                    <a href="<?php echo U($src);?>">
                                        <i class="icon-double-angle-right"></i>
                                        <?php echo $val['nav_name'] ?>
                                    </a>
                                </li>

                                <?php }?>
                            </ul>
                        </li>
						<?php $i++ ?>
                        <?php }?>
                        <!-- <li class="open">
							<a href="#" class="dropdown-toggle" >
								<i class="icon-renren"></i>

								<span class="menu-text"> 快捷栏 </span>

								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu" style="overflow: hidden; display: block;">
								<?php if(is_array($usernav)): $i = 0; $__LIST__ = $usernav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$usernavs): $mod = ($i % 2 );++$i;?><li>
									<a href="<?php echo U($usernavs['src']);?>">
										<i class="icon-double-angle-right"></i>
										<?php echo ($usernavs["nav_name"]); ?>
									</a>
								</li><?php endforeach; endif; else: echo "" ;endif; ?>

							</ul>
						</li> -->
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

				
    <div class="main-content">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="icon-home home-icon"></i>
                    <a href="#">主页</a>
                </li>

                <li>
                    <a href="#">用户管理</a>
                </li>
                <li class="active">学生信息修改</li>
            </ul><!-- .breadcrumb -->

            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." name="username" class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <input type="submit" class="btn btn-primary btn-xs" value="搜索" style="border-radius:3px; height:28px; margin-top:-4px; padding-right:24px;">
                        <i class="icon-search nav-search-icon"></i>
                    </span>
                </form>
            </div><!-- #nav-search -->
        </div>

        <div class="page-content">
            <div class="page-header">
                <h1>
                    用户管理
                    <small>
                        <i class="icon-double-angle-right"></i>
                        学生信息修改
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <form action="/index.php/User/update" method="post" enctype="multipart/form-data">
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:right;">姓名：</td>
                                            <td>
                                            <input type="hidden" name="rec_id" value="<?php echo ($list["rec_id"]); ?>" />
                                                <input type="text" name="stu_name" value="<?php echo ($list["stu_name"]); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:right;">学籍号：</td>
                                            <td>
                                                <input type="text" name="stu_rollbh" value="<?php echo ($list["stu_rollbh"]); ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:right;">手机号：</td>
                                            <td >
                                                <span class='school_tel'><?php echo ($list["stu_mobile"]); ?></span>  <button type='button' class="btn btn-info btn-xs edit_user_tel">修改</button>
                                            </td>
                                        </tr>
                                        <input type="hidden" id="url" value="<?php echo $_SERVER['HTTP_HOST'] ?>"/>
                                        <tr>
                                            <td style="text-align:right;">地区：</td>
                                            <td>
                                                <select name="num1" id="num_id">

                                                    <option value="<?php echo ($num["1"]["area_bh"]); ?>">
                                                        <?php
 if($num['1']['area_name']){ echo $num['1']['area_name']; } else { echo '请选择'; } ?>
                                                    </option>
                                                    <?php if(is_array($area)): $i = 0; $__LIST__ = $area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["area_bh"]); ?>"><?php echo ($vo["area_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </select>
                                                <select name="num2" id="num_id2">
                                                    <option value="<?php echo ($num["2"]["area_bh"]); ?>"><?php
 if($num['2']['area_name']){ echo $num['2']['area_name']; } else { echo '请选择'; } ?></option>
                                                </select>
                                                <select name="num3" id="num">
                                                    <option value="<?php echo ($num["3"]["area_bh"]); ?>"><?php
 if($num['3']['area_name']){ echo $num['3']['area_name']; } else { echo '请选择'; } ?></option>
                                                </select>
                                                <select name="school_num" id="num_id4">
                                                    <option value="<?php echo ($num["4"]["ocode"]); ?>">
                                                        <?php
 if($num['4']['ocode_name']){ echo $num['4']['ocode_name']; } else { echo '-选-择-学-校-'; } ?></option>
                                                </select>
                                                <select name="class_num" id="num_id5">
                                                    <option value="<?php echo ($num["5"]["class_bh"]); ?>">
                                                        <?php
 if($num['5']['class_name']){ echo $num['5']['class_name']; } else { echo '-选-择-班-级-'; } ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:right;">性别 : </td>
                                            <td>
                                                <input type="radio" name="stu_sex" value="0" <?php if($list['stu_sex'] == 0) echo 'checked'; ?>/>女
                                                <input type="radio" name="stu_sex" value="1" <?php if($list['stu_sex'] == 1) echo 'checked'; ?>/>男
                                            </td>
                                        </tr>
                                        <input type='hidden' value='<?php echo $_GET['id']?>' class='user_edit_id'>
                                        <tr>
                                            <td style="text-align:right;">个人简介</td>
                                            <td><textarea class="form-control" rows="3" name="stu_note" value="" id="form-field-1" placeholder="关于个人的描述" class="col-xs-10 col-sm-5" /><?php echo ($list['stu_note']); ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:right;"><input type="submit" class="btn no-border" value="提交"></td>
                                            <td>
                                                <input class="btn no-border" type="reset" value="重置">
                                                <a href='<?php echo U(index);?>'><div class="btn no-border">返回上一页</div></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- <input type="hidden" name="id" value="<?php echo ($user['id']); ?>"> -->
                                </form>
                            </div><!-- /.table-responsive -->
                        </div><!-- /span -->
                    </div><!-- /row -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->

        <div class="modal fade" id="edit_user_tel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">修改联系方式</h4>
      </div>
      <div class="modal-body">
        <br>
        <p>    <input type="tel" class='form-control model_tel'>  </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-xs " id='edit_tel_true'>确定修改</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


    </div>
    <!-- /.main-content -->
    <script src="/Public/Admin/js/jquery-1.8.3.min.js"></script>
        <script>
        
            $('.edit_user_tel').click(function(){
                
                var tel = $('.school_tel').html();
                
                $('#edit_user_tel').modal('show');
                $('.model_tel').val(tel);
            });
            
            $('#edit_tel_true').click(function(){
                var url = $('#oa_url').val();
                var id  = $('.user_edit_id').val();
                var tel = $('.model_tel').val();
                $.ajax({
                url:"http://"+url+"/index.php/User/edit_user_tel",
                type:'POST',
                data:{id:id,tel:tel},
                dataType:'json',
                success:function(data){
                    if(data.info == '没有权限'){
                        alert('没有权限');
                    }
                    if( data[0].success ==true)
                    {
                      $('#edit_user_tel').modal('hide');
                      $('.school_tel').html(tel);
                    } 
                    else
                    {
                        alert('网络异常,请稍后再试');
                    }
                }
                })
            });

        
    
    </script>

    


                <div  id="yes" >
                    <img src="/Public/Admin/images/yes.png" alt="" width="50px" height="50px" style="float:left"/>
                    <div id="yes_tips">12312312313</div>
                </div>
				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="icon-cog bigger-150"></i>
					</div>

					<div class="ace-settings-box" id="ace-settings-box">
						<div>
							<div class="pull-left">
								<select id="skin-colorpicker" class="hide">
									<option data-skin="default" value="#438EB9" class="background">#438EB9</option>
									<option data-skin="skin-1" value="#222A2D" class="background">#222A2D</option>
									<option data-skin="skin-2" value="#C6487E" class="background">#C6487E</option>
									<option data-skin="skin-3" value="#D0D0D0" class="background">#D0D0D0</option>
								</select>
							</div>
							<span>&nbsp; 选择皮肤</span>
						</div>
					</div>
				</div><!-- /#ace-settings-container -->
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>

            <input type="hidden" id="url_src" value="<?php echo $_SERVER['HTTP_HOST'] ?>"/>
		</div>


        <!--<script src='/Public/Admin/assets/js/jquery-2.0.3.min.js'></script>-->
        <script>
/*
            $('#test a').click(function () {
                var url = $(this).attr('data');
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(msg){
                        $('#main').empty().append(msg);
                    }
                });
            }); */

        </script>


		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/Public/Admin/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
		</script>
		<script src="/Public/Admin/assets/js/bootstrap.min.js"></script>
		<script src="/Public/Admin/assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="/Public/Admin/assets/js/excanvas.min.js"></script>
		<![endif]-->

		<script src="/Public/Admin/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="/Public/Admin/assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="/Public/Admin/assets/js/jquery.slimscroll.min.js"></script>
		<script src="/Public/Admin/assets/js/jquery.easy-pie-chart.min.js"></script>
		<script src="/Public/Admin/assets/js/jquery.sparkline.min.js"></script>
		<script src="/Public/Admin/assets/js/flot/jquery.flot.min.js"></script>
		<script src="/Public/Admin/assets/js/flot/jquery.flot.pie.min.js"></script>
		<script src="/Public/Admin/assets/js/flot/jquery.flot.resize.min.js"></script>

		<!--&lt;!&ndash; ace scripts &ndash;&gt;-->

		<script src="/Public/Admin/assets/js/ace-elements.min.js"></script>
		<script src="/Public/Admin/assets/js/ace.min.js"></script>
	<script src="/Public/Admin/assets/js/user.js"></script>
		

		

		<script type="text/javascript">
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
						size: size
					});
				})

				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
				});

			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne",
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);

			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);



			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;

			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}

			 });
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}

				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}

				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}


				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});


				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();

					var off2 = $source.offset();
					var w2 = $source.width();

					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}


				$('.dialogs,.comments').slimScroll({
					height: '300px'
			    });


				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				});

				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			})

            $(document).on("click",".colorpick-btn",function(){
//            $('.colorpick-btn').click(function(){
                var color = $(this).attr('data-color');
                if(color == '#438EB9')
                {
                    var  body_color = '';
                }
                else if(color == '#222A2D')
                {
                    var body_color = 'skin-1';
                }
                else if(color == '#C6487E')
                {
                    var body_color = 'skin-2';
                }
                else
                {
                    var body_color = 'skin-3';
                }
                var url = $('#url_src').val();
                $.ajax({
                    url:"http://"+url+"/index.php/Comment/set_body_color",
                    type:'POST',
                    data:{color:body_color},
                    dataType:'json',
                    success: function(data){

                    }
                })


            })
		</script>
	</body>
</html>