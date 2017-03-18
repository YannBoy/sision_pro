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


						<?php if($user_sup == 1): ?><li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-comment"></i>
								<span class="menu-text">地区</span>
								<b class="arrow icon-angle-down"></b>
							</a>
								<ul class="submenu">
									<li>
										<a href="<?php echo U('Area/index');?>">
											<i class="icon-double-angle-right"></i>地区列表
										</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#" class="dropdown-toggle">
									<i class="icon-comment"></i>
									<span class="menu-text">学校管理</span>
									<b class="arrow icon-angle-down"></b>
								</a>
								<ul class="submenu">
									<li>
										<a href="<?php echo U('School/index');?>">
											<i class="icon-double-angle-right"></i>学校列表
										</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#" class="dropdown-toggle">
									<i class="icon-comment"></i>
									<span class="menu-text">权限管理</span>
									<b class="arrow icon-angle-down"></b>
								</a>
								<ul class="submenu">
									<li>
										<a href="<?php echo U('Rule/index');?>">
											<i class="icon-double-angle-right"></i>规则列表
										</a>
									</li>
									<li>
										<a href="<?php echo U('Area/add');?>">
											<i class="icon-double-angle-right"></i>规则添加
										</a>
									</li>
								</ul>
							</li><?php endif; ?>


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

				
    <style>
        #pages a,#pages span{

            float: left;
            color: #337AB7;
            padding: 6px 12px;
            margin-left: -1px;
            position: relative;
            line-height: 1.42857;
            text-decoration: none;
            background-color: #FFF;
            border: 1px solid #DDD;
        }

        #pages span{
            color: #fff;
            z-index: 2;
            cursor:pointer;
            border-color: #337ab7;
            background-color: #337ab7;
        }
    </style>
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
                    <a href="#">OA管理</a>
                </li>
                <li class="active">文件办理</li>
            </ul><!-- .breadcrumb -->

            <div class="nav-search" id="nav-search">
                <form class="form-search" action="<?php echo U('Admin/Office/oa_file');?>" method="get">
                    <span>
                        <label>
                            <select name="num" aria-controls="dataTables-example" class="form-control input-sm">
                                
                                <option value="10" <?php if($num == 10): ?>selected<?php endif; ?>>10</option>
                                <option value="20" <?php if($num == 20): ?>selected<?php endif; ?>>20</option>
                                <option value="30" <?php if($num == 30): ?>selected<?php endif; ?>>30</option>
                                <option value="50" <?php if($num == 50): ?>selected<?php endif; ?>>50</option>
                            </select>
                        </label>
                    </span>
                    <span class="input-icon">

                        <input type="submit" class="btn btn-primary btn-xs" value="排序" style="border-radius:3px; height:28px; margin-top:-4px; padding-right:24px;">
                    </span>
                </form>
            </div><!-- #nav-search -->

        </div>

        <div class="page-content">
            <!--<div class="page-header">-->
                <!--<h1>-->
                    <!--OA管理-->
                    <!--<small>-->
                        <!--<i class="icon-double-angle-right"></i>-->
                        <!--文件办理-->
                    <!--</small>-->
                <!--</h1>-->
            <!--</div>&lt;!&ndash; /.page-header &ndash;&gt;-->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <div class="row">

                        <div class="col-xs-12">
                            <div style="margin-bottom:5px;">
                                <a href="<?php echo U('Office/all_file');?>"><button type="button" class="btn btn-info btn-xs">浏览全部</button></a>
                            </div>
                            <div class="table-responsive">

                                <table id="sample-table-1" class="table table-striped table-bordered table-hover" style="text-align:center;">
                                    <thead>
                                    <tr>
                                        <th class="center">类型</th>
                                        <th class="center col-lg-4">标题</th>
                                        <th class="center">日期</th>
                                        <th class="center">点击量</th>
                                        <th class="center">状态</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($file)): $i = 0; $__LIST__ = $file;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td class="center">
                                                <?php
 if($vo['state'] == 0){ echo '上级文件'; }else{ echo '本校文件'; } ?>
                                            </td>
                                            <td  data-toggle="modal" data-target="#myModal" style="cursor:pointer" class="get_file_info" id="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></td>
                                            <td class="center"><?php echo ($vo["regtime"]); ?></td>
                                            <td class="center"><?php echo ($vo["allnum"]); ?></td>
                                            <td class="center">
                                                <?php if($vo['do_state'] == 0 ): ?><p style="color:green">已办</p>
                                                    <?php elseif($vo['do_state'] == 1): ?> <p style="color:red">待办</p><?php endif; ?>
                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    <tr>
                                        <td colspan="5" id="pages"><div class="row"><div class="col-md-5"></div><?php echo ($page); ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" id="id" value="<?php echo ($id); ?>"/>
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm1">发布新文件</button>
                            </div><!-- /.table-responsive -->
                        </div><!-- /span -->
                    </div><!-- /row -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->

    <div style="float:right;display:block;position: absolute;left: 50%;top: 250px;display:none" id="lon" >
        <center><img src="/Public/Admin/images/lon.gif" alt="" width="60px" height="60px"  /></center>
    </div>
    <!--  弹出框-->
    <div class="modal fade bs-example-modal-sm1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="padding:25px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>新文件</h3>
                <div style="float:right;display:block;position: absolute;left: 250px;top: 150px;display:none" id="lon_g" >
                    <center><img src="/Public/Admin/images/lon.gif" alt="" width="60px" height="60px"  /></center>
                </div>
                <br/>
                <div class="form-group">
                    <label>名称</label>
                    <input type="text" class="form-control" id="title" placeholder="文件名称"> <br/>
                    <label for="">字号</label> <br/>
                    <input type="text" id="num1" style="width:200px"/>
                    [<input type="text" id="num2" style="width:60px"/>]
                    <input type="text" id="num3" style="width:60px"/>号
                    <input type="hidden" id="url" value="<?php echo $_SERVER['HTTP_HOST'] ?>"/>
                    <br/><br/>
                    <label for="">类型</label><br/>
                    <input type="radio" name="state" value="0" checked/> 上级文件
                    <input type="radio" name="state" value="1" /> 本校文件
                    <br/><br/>
                    <label for="">发布日期</label>
                    <input size="20" type="text" id="regtime"  readonly class="form_datetime" value="<?php echo $rq;?>">

                </div>
                <button type="button" class="btn btn-primary" name="sch_oafile_add">确定</button>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class='oa_modals'>
        <div class="modal-dialog" role="document" style="width:820px;height:650px;">
            <div class="modal-content" style="height:680px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">文件签约</h4>
                    <input type="hidden" class="hidden_id" />
                </div>
                <div class="modal-body" >
                    <div id="head">
                        <ul>
                            <li id="L1" onclick="Tab(1)"><a href="#">文件正文</a></li>
                            <li id="L2" onclick="Tab(2)"><a href="#">签约流转</a></li>
                        </ul>
                    </div>
                    <div id="d1" >
                        <div class="d1_hear">
                            <h3>转发: <span class="d1hear_1"></span></h3>
                            类型: <span class="d1_1"> </span>   &nbsp;&nbsp;&nbsp;  字号: <span class="d1_2"> </span>  &nbsp;&nbsp;&nbsp;  发布日期: <span class="d1_3"> </span>  &nbsp;&nbsp;&nbsp; 阅读: <span class="d1_4"></span>
                        </div>
                        <div style="border-top:1px dashed #999999;height: 1px;overflow:hidden;margin-bottom: 10px;"></div>
                        <div class="d1_content" style="width:760px;height:300px;overflow:auto;" >


                        </div>
                        <div class="d1_file">
                            <h5>附件:</h5> <br/>
                            <span class="file_src">
                            </span>
                        </div>

                        <input type="hidden" value="/Public" class="public"/>
                    </div>
                    <div id="d2" style="width:760px;height:410px;overflow:auto;">
                        <table class="table table-bordered" name="people_table">
                            <tr>
                                <th class="center col-lg-2">姓名</th>
                                <th class="center col-lg-3">办理时间</th>
                                <th class="center col-lg-6">办理描述</th>
                                <th class="center col-lg-1">操作</th>
                            </tr>

                        </table>
                    </div>
            </div>
        </div>
    </div>

        <div class="" style="position:absolute;left:35%;top:50px;display:none" id="get_teachers">
            <div class="modal-dialog modal-sm">
            
                <div class="modal-content" style="padding-top:25px;padding-left:25px;height:470px">
                    <h3>选择教师</h3>

                    <div>
                        <select name="get_teacher_group">
                            <option value="">请选择</option>
                            <?php if(is_array($teacher)): $i = 0; $__LIST__ = $teacher;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$teacher): $mod = ($i % 2 );++$i;?><option value="<?php echo ($teacher["id"]); ?>"><?php echo ($teacher["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <select name="get_teacher_group1" id="">
                            <option value="">请选择</option>
                        </select>
                    </div>
                    <div class="get_teacher_group" style="overflow: auto">

                    </div>
                    <div style="float:left;margin-top:20px">
                        <button class="teacher_all">全选</button>
                    </div>
                    <div class="get_teacher_group1" style="overflow: auto">

                    </div>
                    <div style="float:left;margin-top:20px">
                        <button class="teacher_null">清空</button>
                    </div>
                   
                </div>
                <div class="modal-footer">
                     <button class="btn btn-info btn-xs" name="share_people" >确定</button>
                    <button class="btn btn-danger btn-xs oa_file_button_none">关闭</button>
                </div>


            </div>
        </div>





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