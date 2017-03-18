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

				
    <div class="main-content">
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
                    <a href="#">报表统计</a>
                </li>
            </ul><!-- .breadcrumb -->
            <div class="nav-search" id="nav-search">
                <form action="" method="get">

                    <span class="input-icon">
                <input type="text" placeholder="考试名称"  class="nav-search-input proname" id="nav-search-input" autocomplete="off"/>
                <span class="prosearch"><input type="submit" class="btn btn-primary btn-xs prosearchb"  value="搜索" ></span>

                <i class="icon-search nav-search-icon"></i>
            </span>
                </form>
            </div>

        </div>

        <div class="page-content">
            <div class="page-header">
                <h1>
                    报表统计
                    <small>
                        <i class="icon-double-angle-right"></i>
                        考试列表
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="table-responsive">
                                        <form action="" method="post">
                                            <table id="sample-table-1" class="table table-striped table-bordered table-hover" style="text-align:center;">
                                                <thead>
                                                <tr>
                                                    <th class="center">考试名称</th>
                                                    <th class="center">创建人</th>
                                                    <th class="center">考试时间</th>
                                                    <th class="center">创建时间</th>
                                                    <th class="center">操作</th>
                                                </thead>
                                                <tbody>
                                                <?php if(is_array($exam)): $i = 0; $__LIST__ = $exam;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                                        <th class="center"><?php echo ($vo["name"]); ?>
                                                            <?php if($vo["state"] == 0): ?><span style="color:green">(单校)</span>
                                                                <?php else: ?>
                                                                <span style="color:deepskyblue">(联考)</span><?php endif; ?>
                                                        </th>
                                                        <th class="center"><?php echo ($vo["username"]); ?></th>
                                                        <th class="center"><?php echo ($vo["examtime"]); ?></th>
                                                        <th class="center"><?php echo ($vo["regtime"]); ?></th>
                                                        <th class="center">
                                                            <?php if($vo["pid"] == 0): ?><a href="<?php echo U('Api/localexcel',array('id'=>$vo[id],'state'=>$vo[state],'name'=>$vo[name],'schoolname'=>'尤溪镇中学'));?>" >下载</a>
                                                                <a href="<?php echo U('Report/call_info',array('id'=>$vo[id],'state'=>$vo[state]));?>" >数据报表</a>
                                                                <a href="<?php echo U('Report/subinfo',array('id'=>$vo[id],'state'=>$vo[state]));?>">图文报表</a>
                                                                <?php else: ?>
                                                                <a href="<?php echo U('Api/localexcel',array('id'=>$vo[pid],'state'=>$vo[state],'name'=>$vo[name],'schoolname'=>$vo[schoolname]));?>" >下载</a>
                                                                <a href="<?php echo U('Report/call_info',array('id'=>$vo[pid],'state'=>$vo[state],'schoolname'=>$vo[schoolname]));?>" >数据报表</a>
                                                                <a href="<?php echo U('Report/class_rep',array('id'=>$vo[pid],'state'=>$vo[state],'ocode'=>$vo[schoolname]));?>">图文报表</a><?php endif; ?>


                                                        </th>
                                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                                </tbody>
                                                <tr>
                                                    <td colspan="10" id="pages"><div class="row"><div class="col-md-5"></div><?php echo ($page); ?></td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div><!-- /.table-responsive -->
                                    <ul class="pages">
                                    </ul>
                                </div><!-- /span -->
                            </div><!-- /row -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->
    <input type="hidden" value="<?php echo ($state); ?>" class="apistate">
    <script>
        var url = $('#oa_url').val();
        //        $(document).ready(function () {
        //            if($('.state').val() == 1 ){
        //                return false;
        //            }
        //            var state = $('.apistate').val();
        //            var schoolname = $('.rep_schname').html();
        //            $('.pages').html('');
        //            $('.table-responsive table tbody').html('');
        //            $.ajax({
        //                url:"http://"+url+"/index.php/Api/getManyExam",
        //                type:'POST',
        //                data:{schoolname:schoolname,state:state},
        //                dataType:'json',
        //                success: function(data){
        //                    $(data.data).each(function () {
        //                        if(this.state == 0){
        //                            var state = '单校';
        //                        }else{
        //                            var state = '联考';
        //                        }
        //                        tr = "<tr><th class='center'>"+this.name+" <span style='color:lightseagreen'>("+state+")</span></th> <th class='center'>"+this.username+
        //                                "</th><th class='center'>"+this.examtime+"</th> <th class='center'>"+this.regtime+"</th>" +
        //                                "<th class='center'><a href='http://localhost:8080/index.php/Api/exportexcel?id="+this.id+"&state="+this.state+"&name="+this.name+"'>下载excel</a>&nbsp;&nbsp;<a href='javascript:;' class='getApiinfo' abc="+this.id+">查看</a>" +
        //                                "</th></tr>";
        //                        $('.table-responsive table tbody').append(tr);
        //                    });
        //                    for(var i =1;i<=data.p;i++)
        //                    {
        //                        var li = "<li>"+i+"</li>";
        //                        $('.pages').append(li);
        //                    }
        //                }
        //            })
        //        });
        //        $(document).on('click','.pages li',function () {
        //            $('.pages li').css('border','1px solid lightgoldenrodyellow');
        //            $(this).css('border','2px solid #c09853');
        //            var p = $(this).html();
        //            var schoolname = $('.rep_schname').html();
        //            $('.table-responsive table tbody').html('');
        //            $.ajax({
        //                url:"http://"+url+"/index.php/Api/getManyExam?p="+p,
        //                type:'POST',
        //                data:{schoolname:schoolname},
        //                dataType:'json',
        //                success: function(data){
        //                    $(data.data).each(function () {
        //                        tr = "<tr><th class='center'>"+this.name+" <span style='color:green'>(联考)</span></th> <th class='center'>"+this.username+
        //                                "</th><th class='center'>"+this.examtime+"</th> <th class='center'>"+this.regtime+"</th>" +
        //                                "<th class='center'><a href='http://localhost:8080/index.php/Api/exportexcel?id="+this.id+"&state="+this.state+"&name="+this.name+"'>下载excel</a>&nbsp;&nbsp;<a href='http://"+url+"/index.php/Api/getSchinfo?id="+this.id+"&state="+this.state+"'>查看</a>" +
        //                                "</th></tr>";
        //                        $('.table-responsive table tbody').append(tr);
        //                    });
        //
        //                }
        //            })
        //        });
        //        $(document).on('click','.prosearchb',function () {
        //            var state = $('.state').val();
        //            if($('.state').val() == 1){
        //                return false;
        //            }
        //            var schoolname = $('.rep_schname').html();
        //            $('.pages').html('');
        //            $('.table-responsive table tbody').html('');
        //            $.ajax({
        //                url:"http://"+url+"/index.php/Api/getManyExam",
        //                type:'POST',
        //                data:{schoolname:schoolname,name:$('.proname').val()},
        //                dataType:'json',
        //                success: function(data){
        //                    $(data.data).each(function () {
        //                        if(this.state == 0){
        //                            var state = '单校';
        //                        }else{
        //                            var state = '联考';
        //                        }
        //                        tr = "<tr><th class='center'>"+this.name+" <span style='color:green'>("+state+")</span></th> <th class='center'>"+this.username+
        //                                "</th><th class='center'>"+this.examtime+"</th> <th class='center'>"+this.regtime+"</th>" +
        //                                "<th class='center'><a href='http://localhost:8080/index.php/Api/exportexcel?id="+this.id+"&state="+this.state+"&name="+this.name+"' class='updateExcel' >下载excel</a><a href='javascript:;' class='getApiinfo' abc="+this.id+">查看</a>" +
        //                                "</th></tr>";
        //                        $('.table-responsive table tbody').append(tr);
        //                    });
        //                    for(var i =1;i<=data.p;i++)
        //                    {
        //                        var li = "<li>"+i+"</li>";
        //                        $('.pages').append(li);
        //                    }
        //                }
        //            })
        //        });

        //        $('.state').change(function () {
        //            if($(this).val() == 0)
        //            {
        //                button = "<input type='button' class='btn btn-primary btn-xs prosearchb'  value='搜索' >";
        //            }
        //            else
        //            {
        //                button = "<input type='submit' class='btn btn-primary btn-xs setpro' value='搜索' >";
        //            }
        //            $('.prosearch').html(button)
        //        })

        //        $(document).on('click','.getApiinfo',function () {
        //            var id = $(this).attr('abc');
        //            window.location.href="http://"+url+"/index.php/Api/manyExamInfo?id="+id+"&state=1";
        //        });



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