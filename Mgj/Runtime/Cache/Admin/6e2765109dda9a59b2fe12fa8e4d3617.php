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
										<a href="<?php echo U('Rule/add');?>">
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

				
    <link rel="stylesheet" href="/Public/Admin/css/fullcalendar_opt/css/fullcalendar.css">
    <link rel="stylesheet" href="/Public/Admin/css/fullcalendar_opt/css/fancybox.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/fullcalendar_opt/css/jquery-ui.css">
    <script src='/Public/Admin/css/fullcalendar_opt/js/jquery.fancybox-1.3.1.pack.js'></script>
    <script src='/Public/Admin/css/fullcalendar_opt/js/fullcalendar.min.js'></script>
    <script src='/Public/Admin/css/fullcalendar_opt/js/jquery.form.min.js'></script>
    <script src='/Public/Admin/assets/js/My97DatePicker/4.72/WdatePicker.js'></script>

     
    
    <div class="main-content">
    <div class="breadcrumbs" id="breadcrumbs">
                        <script type="text/javascript">
                            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                        </script>

                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home home-icon"></i>
                                <a href="#">首页</a>
                            </li>
                            <li class="active">控制台</li>
                            <li class="active">欢迎您:<?php echo ($managerInfo["relname"]); ?>.</li>
                        </ul><!-- .breadcrumb -->
    </div>
    <div style="padding: 5px;padding-left: 20px">
        <div class="admin_content">
            <div class="user_self_info" >

                <?php if($file_count == 0): else: ?>
                <div class="alert alert-danger" role="alert" style="height:20px;line-height:2px">

                        <a href="<?php echo U('Office/oa_file');?>" class="alert-link">有<?php echo ($file_count); ?>条文件办理需要处理!&nbsp;</a>
                </div><?php endif; ?>


                <?php if($notice_count == 0): else: ?>
                <div class="alert alert-info" style="height:20px;line-height:2px">

                        <a href="<?php echo U('Office/notice');?>" class="alert-link">有<?php echo ($notice_count); ?>条通知待查看!&nbsp;</a>
                </div><?php endif; ?>

                <?php if($email_count == 0): else: ?>
                <div class="alert alert-warning" style="height:20px;line-height:2px">

                        <a href="<?php echo U('Office/email');?>" class="alert-link">有<?php echo ($email_count); ?>条邮件待查看!</a>
                </div><?php endif; ?>


                <button class="btn btn-link btn-xs">个人日程</button>
                <div id="calendar"></div>
            </div>

               
                
            </div>
             
        </div>

        

        <div class="index_info" >
            <div class="info_nav">
                <div class="info_font">
                    <div class="info_img"></div>
                    <div class="info_font_info">工作计划 </div>
                </div>
                <div class="info_close"></div>
                <span  ><div class="glyphicon glyphicon-plus pull-right set_news" style="margin-top:10px;margin-right:10px;cursor:pointer" >编辑</div></span>
            </div>
           
                <div style="width:200px;float:left">
            <input  type="text" style="width:80px;height: 20px;float: left;" id="chose_ftime" class="form-control input-sm" onClick="WdatePicker()" value="<?php echo ($weektime["first"]); ?>"/> ~
            <input  type="text" style="width:80px;height: 20px;float:right;margin-right: 25px;" id="chose_ltime" class="form-control input-sm" onClick="WdatePicker()" value="<?php echo ($weektime["footer"]); ?>"/>
            </div>
            <button class='btn btn-info btn-xs pull-left' style="margin-right:35px" id="chose_time">查询</button>
            
            
            <?php if(is_array($plan)): $i = 0; $__LIST__ = $plan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$plan): $mod = ($i % 2 );++$i;?><div class="news_info" name='plan_<?php echo ($plan["id"]); ?>'>
               <?php echo ($plan["group_name"]); ?>
                <div class="new_font">
                    <?php echo str_replace("\n",'<br>',$plan['content']);?>
                </div>


            </div><?php endforeach; endif; else: echo "" ;endif; ?>


        </div>
        <div id="new_info_div">
            <div class="sch_new_info_list">
                <div class="sch_new_info_nav">
                    <div class="info_font">
                        <div class="info_img"></div>
                        <div class="info_font_info">行政动态 </div>
                    </div>
                    <div class="info_close"></div>
                    <span  ><div class="glyphicon glyphicon-plus pull-right sch_new_add" style="margin-top:10px;margin-right:10px;cursor:pointer" >编辑</div></span>
                </div>
                <div class="sch_new_over">
                <?php if(is_array($sch_info)): $i = 0; $__LIST__ = $sch_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sch_info): $mod = ($i % 2 );++$i;?><div class="sch_news_info" name='sch_info_<?php echo ($plan["id"]); ?>'>
                        <div class="sch_font">
                            <div class="new_img"></div><?php echo ($sch_info["title"]); ?>    &nbsp;   【<?php echo ($sch_info["starttime"]); ?>】
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>

            <div class="sch_new_info_list1">
                <div class="sch_new_info_nav">
                    <div class="info_font">
                        <div class="info_img"></div>
                        <div class="info_font_info">工作反馈 </div>
                    </div>
                    <div class="info_close"></div>
                    <span  ><div class="glyphicon glyphicon-plus pull-right sch_file_add" style="margin-top:10px;margin-right:10px;cursor:pointer" >上传文件</div></span>
                </div>
                <div class="sch_file_over">

                <?php if(is_array($files)): $i = 0; $__LIST__ = $files;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$files): $mod = ($i % 2 );++$i;?><div class="sch_file_info" style="height:40px">
                        <div class="mkdir_sty" >
                            <img src="/Public/Admin/images/folder.png" alt=""><span style="cursor: pointer" title="点击查看" class="get_mkdir"><?php echo ($files); ?></span>
                            <button type="button" class="btn btn-warning btn-xs delSchFile pull-right" style="margin-top:6px" name="<?php echo ($files); ?>">删除</button>
                            <div style="margin-bottom:10px;">
                            </div>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <button type="button" class="btn btn-info btn-xs pull-right mkdir_file" style="margin-right:150px">创建新文件夹</button>
            </div>
        </div>

    </div>
</div><!-- /.main-content -->

    <input type="hidden" id="url" value="<?php echo $_SERVER['HTTP_HOST'] ?>"/>
    <div class="modal fade" id="model">
        <div class="modal-dialog" style="width:930px">
            <div class="modal-content" style="height:500px">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <button type="button" class="btn btn-primary btn-xs pull-right refresh" style="margin-right: 20px;margin-top:5px">刷新</button>
                    <h4 class="modal-title">计划任务</h4>
                </div>
                <div class="modal-body" style="height:380px;overflow: scroll">
                    <table class="table table-bordered" style="width:860px;margin:0 auto" >

                        <tr class="">
                            <th class="col-lg-7 center">计划内容</th>
                            <th class="col-lg-2 center">时间</th>
                            <th class="col-lg-1 center">状态</th>
                            <th class="col-lg-2 center">操作</th>
                        </tr>

                        <tbody class="tbody">
                        </tbody>
                    </table>
                    <!--<button type="button" class="btn btn-default btn-sm pull-right" data-dismiss="modal">关闭</button>-->
                    <input type="hidden" name="hidden_type" />
                </div>
                <button type="button" class="btn btn-primary btn-sm pull-right" name="add_news" style="margin-right:30px">添加新计划</button>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade bs-example-modal-sm" id="add_news">
        <div class="modal-dialog modal-sm" style="width:565px;margin-top:50px">
            <div class="modal-content" style="border:1px solid #ccc">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">创建计划</h5>
                </div>
                <div class="modal-body" style="height:300px">
                    指定部门:
                    <select name="" id="group_plan">
                       <?php if(is_array($groups)): $i = 0; $__LIST__ = $groups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$groups): $mod = ($i % 2 );++$i;?><option value="<?php echo ($groups["id"]); ?>"><?php echo ($groups["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <br>
                    <div>
                        时间: <br/> <input  type="text" style="width:150px" id="plan_start_time" class="form-control input-sm" onClick="WdatePicker()" value="<?php echo date('Y-m-d')?>"/>
                        
                    </div>
                    计划说明: <br/>
                    <textarea name="content" id="" cols="60" rows="8" style="resize:none;"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-xs" name="send_plan">发布</button>
                </div>

            </div>
        </div>
    </div>

    <!--<div>-->
        <!--<button class="btn btn-primary btn-xs btn1" onclick="$(this).css('border','4px solid #666');$('.btn2').css('border','')" style="margin-top:5px;margin-right:5px">个人</button>-->
        <!--<button class="btn btn-primary btn-xs btn2" onclick="$(this).css('border','4px solid #666');$('.btn1').css('border','')" style="margin-top:5px">群组</button>-->
        <!--<select name="choice" id="" style="margin-top: 5px;margin-left:30px">-->
            <!--<option value="">请选择</option>-->
        <!--</select>-->
    <!--</div>-->
    <!--<div class="plan_people" style="width:400px;height:100px;border:1px solid #eee;margin-top:5px">-->

    <!--</div>-->

    <!--#############    modal     ###########-->
    <div class="modal fade" id="sch_add_new_modal">
        <div class="modal-dialog" style="width:800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">行政动态</h4>
                </div>
                <div class="modal-body" style="height:350px;overflow: auto">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="center col-lg-1">序号</th>
                                <th class="center">内容</th>
                                <th class="center col-lg-3">时间</th>
                                <th class="center col-lg-2">发布人</th>
                                <th class="center col-lg-2"> 操作</th>
                            </tr>
                        </thead>

                            <tbody>
                            <?php if(is_array($sch_info_admin)): $i = 0; $__LIST__ = $sch_info_admin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sch_info_admin): $mod = ($i % 2 );++$i;?><tr class="sch_list_<?php echo ($sch_info_admin["id"]); ?>">
                                <th class="center col-lg-1"><?php echo ($i); ?></th>
                                <th class="center"><?php echo ($sch_info_admin["title"]); ?></th>
                                <th class="center col-lg-3"><?php echo ($sch_info_admin["starttime"]); ?></th>
                                <th class="center col-lg-2"><?php echo ($sch_info_admin["uname"]); ?></th>
                                <th class="center col-lg-2">
                                    <span class="sch_info_set_state" title="<?php echo ($sch_info_admin["state"]); ?>" style="cursor: pointer" id="state_<?php echo ($sch_info_admin["id"]); ?>"> <?php if($sch_info_admin['state'] == 1): ?>显示<?php else: ?> 隐藏<?php endif; ?>
                                    </span>  <span id="<?php echo ($sch_info_admin["id"]); ?>" style="cursor: pointer" class="sch_info_delete">删除</span>
                                     <span class="edit_sch_modal" style="cursor: pointer;" time="<?php echo ($sch_info_admin["starttime"]); ?>" name="<?php echo ($sch_info_admin["title"]); ?>" title="<?php echo ($sch_info_admin["id"]); ?>">修改</span>

                                </th>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary btn-sm sch_new_add_modal">发布新动态</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="sch_modal_add_new">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">新建动态</h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label>内容:</label>

                            <textarea name="" id="" cols="60" rows="4" class="sch_new_name" style="resize: none;">

                            </textarea>
                        </div>
                        <div class="form-group">
                            <div>
                                开始时间:<input  type="text" style="width:120px" class="form-control input-sm sch_new_starttime" onClick="WdatePicker()" value="<?php echo date('Y-m-d')?>"/>

                            </div>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="sch_new_state" checked value="1"> 是否显示
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary btn-sm sch_new_add_my">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" id="sch_file_modal">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">日常文件</h4>
                </div>

                <div class="modal-body" style="height:120px">
                    上传到:<select name="sel_files" id="sel_files">
                    <?php if(is_array($sel_files)): $i = 0; $__LIST__ = $sel_files;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$file): $mod = ($i % 2 );++$i;?><option value="<?php echo ($file); ?>"><?php echo ($file); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select> 文件夹
                    <div style="margin-top:20px">
                        <span id="btn_upload"></span>

                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <input type="hidden" id="type" value="<?php echo $_GET['type']?>">

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="self_plan_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">编辑事件</h4>
                </div>
                <div class="modal-body" style="height:130px;padding-left:30px">
                    <div style="line-height:26px;">
                    日程内容: <input type="text" style="float:right;margin-right:100px;width:358px;" class="form-control input-sm sel_title" placeholder="记录你将要做的一件事...">
                    </div>

                    <div style="float:left;margin-top:10px;">
                        <label style="line-height: 30px">开始时间:</label>
                        <div style="float:right;width:450px;margin-left:10px;">
                            <input  type="text" style="float:left;width:90px" class="form-control input-sm sel_starttime" onClick="WdatePicker()" />
                            <span id="sel_start" style="display:none">
                                        <select name="s_hour">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09" selected>09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12" >12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                    </select>:
                                    <select name="s_minute">
                                        <option value="00" selected>00</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>
                                    </span>
                            <div class="endTime_div" style="float:right;display: none">
                                <label for="" style="line-height: 30px">截止时间:</label>
                                <div style="float:right">
                                    <input type="text" style="width:80px;margin-left:5px;float:left" class="form-control input-sm sel_endtime" onClick="WdatePicker()" value=""/>
                                    <div style="float:right;width:103px">
                                    <div id="sel_end" style="display:none;">
                                        <select name="e_hour">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17" selected>17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                    </select>:
                                    <select name="e_minute">
                                        <option value="00" selected>00</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div style="width:300px;padding-top:10px;float:left">
                        <input type="checkbox" name="" value="1" class="allday" checked>全天 &nbsp; <input type="checkbox" name="enddate" value="1" class="self_end_state">结束时间 &nbsp;
                        <!--<input type="checkbox"   id="public_plan"  class="public_chose">公共任务-->
                    </div>
                </div>
                <div style="margin-left:30px;display: none" id="public_peo">

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">放弃</button>
                    <button type="button" class="btn btn-primary btn-sm sel_add">保存</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="mkdir_file_modal">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">创建文件夹</h4>
                </div>

                <div class="modal-body" >
                    <div style="line-height:26px;">
                        文件夹名: <input type="text" style="float:right;margin-right:100px;width:358px;" class="form-control input-sm mkdir_file_name" placeholder="文件夹名...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-xs mkdir_file_true">创建</button>
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">关闭</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="get_file_modal">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title mkdir_title"></h4>
                </div>

                <div class="modal-body" style="height:300px;width:550px;overflow: auto;margin:0 auto">
                    <table class="table table-striped">
                        <thear>
                            <tr>
                                <th>文件名</th>
                                <th>发布时间</th>
                                <th>发布人</th>
                                <th>操作</th>
                            </tr>
                        </thear>
                        <tbody class="mkdir_table">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">关闭</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade bs-example-modal-sm" id="get_add_news">
        <div class="modal-dialog modal-sm" style="width:565px;margin-top:50px">
            <div class="modal-content" style="border:1px solid #ccc">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">修改计划</h5>
                </div>
                <input type="hidden" class="get_news_id">
                <div class="modal-body" style="height:180px">
                    计划内容: <br/>
                    <textarea class="get_news_content" id="" cols="50" rows="7" style="resize:none;"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-xs" name="edit_news_cntent">修改</button>
                </div>

            </div>
        </div>
    </div>

<div class="modal fade" id="sch_modal_edit_new">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">修改动态</h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label>内容:</label>

                            <textarea name="" id="" cols="60" rows="4" class="sch_edit_new_name" style="resize: none;">

                            </textarea>
                            <input type="hidden" class="sch_edit_id"> <br><br>
                            <label>时间:</label>
                            <input type='text' class='user_edit_time' onClick="WdatePicker()">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary btn-sm sch_new_edit_my">修改</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="self_plan_edit" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close btn-xs" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">编辑事件</h4>
                </div>
                <div class="modal-body" style="height:130px;padding-left:30px">
                    <div style="line-height:26px;">
                        日程内容: <input type="text" style="float:right;margin-right:100px;width:358px;" class="form-control input-sm sel_edit_title" placeholder="记录你将要做的一件事...">
                    </div>

                    <div style="float:left;margin-top:10px;">
                        <label style="line-height: 30px">开始时间:</label>
                        <div style="float:right;width:450px;margin-left:10px;">
                            <input  type="text" style="float:left;width:90px" class="form-control input-sm sel_edit_starttime" onClick="WdatePicker()" />
                            <span id="sel_edit_start" >
                                        <select name="s_edit_hour">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09" selected>09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12" >12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                    </select>:
                                    <select name="s_edit_minute">
                                        <option value="00" selected>00</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>
                                    </span>
                            <div class="endTime_div" style="float:right;">
                                <label for="" style="line-height: 30px">截止时间:</label>
                                <div style="float:right">
                                    <input type="text" style="width:80px;margin-left:5px;float:left" class="form-control input-sm sel_edit_endtime" onClick="WdatePicker()" value=""/>
                                    <div style="float:right;width:105px">
                                        <div id="sel_edit_end">
                                            <select name="e_edit_hour">
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17" selected>17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                            </select>:
                                            <select name="e_edit_minute">
                                                <option value="00" selected>00</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div style="width:300px;padding-top:10px;float:left">
                        <input type="checkbox" name="" value="1" class="allday_edit">全天 &nbsp; <input type="checkbox" name="enddate" value="1" class="self_edit_end_state">结束时间
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="pull-left btn btn-danger btn-sm sel_delete">删除</button>
                    <button type="button" class="btn btn-primary btn-sm sel_save sel_save_color">完成</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>

                </div>

            </div>
        </div>
    </div>
       

    <script>
        var url = $('#url').val();

        var calendar = $('#calendar').fullCalendar({
            isRTL: false,
            firstDay: 0,
            dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
            dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
            buttonText: {
                prev: "<span class='fc-text-arrow'>&lsaquo;</span>",
                next: "<span class='fc-text-arrow'>&rsaquo;</span>",
                prevYear: "<span class='fc-text-arrow'>&laquo;</span>",
                nextYear: "<span class='fc-text-arrow'>&raquo;</span>",
                today: '返回今天',
                month: '月',
                week: '周',
                day: '日'
            },
            events: 'http://'+url+'/index.php/Comment/get_myself_plan' ,   //事件数据
            dayClick: function(date, allDay, jsEvent, view) {
                var selDate =$.fullCalendar.formatDate(date,'yyyy-MM-dd');//格式化日期
                $('.sel_starttime').val(selDate);
                // 此处可以进行弹窗、后台通信等处理
                // 本例仅在日历中添加一个新日程
                $('#self_plan_modal').modal('show');

            },
            eventClick : function(event, jsEvent, view) {

                var selDate =$.fullCalendar.formatDate(event.start,'yyyy-MM-dd');
                var endDate =$.fullCalendar.formatDate(event.end,'yyyy-MM-dd');

                var s_hour =$.fullCalendar.formatDate(event.start,'HH');
                var s_min = $.fullCalendar.formatDate(event.start,'mm');
                var e_hour = $.fullCalendar.formatDate(event.end,'HH');
                var e_min = $.fullCalendar.formatDate(event.end,'mm');

                // 此处可添加修改日程的代码
                $('#self_plan_edit').modal('show');
                $('.sel_edit_title').val(event.title);
                $('.sel_edit_starttime').val(selDate);
                $('.sel_edit_endtime').val(endDate);
                $('.sel_delete').val(event.id);
                $('.sel_save_color').val(event.id);
                $('select[name=s_edit_hour]').val(s_hour);
                $('select[name=s_edit_minute]').val(s_min);
                $('select[name=e_edit_hour]').val(e_hour);
                $('select[name=e_edit_minute]').val(e_min);
                endDate ? $('.endTime_div').show() : $('.endTime_div').hide();
                if(event.color == 'green'){
                    $('.sel_save_color').hide();
                    $('.sel_delete').hide();
                }else{
                    $('.sel_save_color').show();
                    $('.sel_delete').show();
                }
                if(event.allDay){
                    $('.allday_edit').attr('checked',true);
                }else{
                    $('.allday_edit').attr('checked',false);
                }
            },
//            eventMouseover : function( event ) {
//                //do something here...
//                console.log('鼠标经过 ...');
//                console.log('eventMouseover被执行，选中Event的title属性值为：', event.title);
//                // ...
//            },
            editable : true,
            dragOpacity: 0.5,

            eventDrop : function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view ) {
                if(event.color == 'green'){
                    alert('已完成日程不允许改变时间');
                    window.location.reload();
                }
                else
                {
                    var startdate =$.fullCalendar.formatDate(event.start,'yyyy-MM-dd HH:mm:ss');
                    var enddate =$.fullCalendar.formatDate(event.end,'yyyy-MM-dd HH:mm:ss');
                    var id = event.id;
                    $.ajax({
                        url:"http://"+url+"/index.php/Comment/sel_save_date",
                        type:'POST',
                        data:{id:id,startdate:startdate,enddate:enddate},
                        dataType:'json',
                        success: function(data){
                            if(data[0].success == false){
                                alert('网络繁忙');
                                window.location.reload();
                            }
                        }
                    })

                }
                // 拖动某个日程到新位置时，日程时间改变，此处可做相关处理
            },

        });

    </script>
    <script>
        $('.content_close1').click(function(){
            $('.index_content').slideUp();
        });
        $('.content_close2').click(function(){
            $('.index_content1').slideUp();
        });
        $('.content_close3').click(function(){
            $('.index_content2').slideUp();
        });
        var url = $('#url').val();
        $('.refresh').click(function(){
            $('.tbody').html('');
            $.ajax({
                url:"http://"+url+"/index.php/office/set_news",
                type:'POST',
                data:{},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        for($i=0;$i<data[0].data.length;$i++){
                            if(data[0].data[$i].state == '1'){
                                var state = '显示';
                            }else{
                                var state = '隐藏';
                            }
                              tr = " <tr class='news_"+data[0].data[$i].id+"'> <td class='center col-lg-5'>"+data[0].data[$i].content+"</td> <td class='center col-lg-3'>"+data[0].data[$i].start_time+"</td> <td class=plan"+data[0].data[$i].id+" style='cursor: pointer' name='plan_edit_state'  title="+data[0].data[$i].id+" >"+state+"</td> <td class='center col-lg-4 '  > <span name="+data[0].data[$i].id+" class='edit_news' style='cursor: pointer'>修改</span> <br> <span name="+data[0].data[$i].id+" class='del_news' style='cursor: pointer'>删除</span></td> </tr>";


                            $('.tbody').append(tr);
                        }
                    }
                }
            })
        });
        $('.set_news').click(function(){
            $('.tbody').html('');
            $.ajax({
                url:"http://"+url+"/index.php/office/set_news",
                type:'POST',
                data:{},
                dataType:'json',
                success: function(data){
                    if(data.info == '没有权限'){
                        alert('没有权限');
                    }else{
                        $('#model').modal('show');
                        for($i=0;$i<data[0].data.length;$i++){
                            if(data[0].data[$i].state == '1'){
                                var state = '显示';
                            }else{
                                var state = '隐藏';
                            }
                             tr = " <tr class='news_"+data[0].data[$i].id+"'> <td class='center col-lg-5'>"+data[0].data[$i].content+"</td> <td class='center col-lg-3'>"+data[0].data[$i].start_time+"</td> <td class=plan"+data[0].data[$i].id+" style='cursor: pointer' name='plan_edit_state'  title="+data[0].data[$i].id+" >"+state+"</td> <td class='center col-lg-4 '  > <span name="+data[0].data[$i].id+" class='edit_news' style='cursor: pointer'>修改</span> <br> <span name="+data[0].data[$i].id+" class='del_news' style='cursor: pointer'>删除</span></td> </tr>";


                            $('.tbody').append(tr);
                        }
                    }
                }
            })
        });
        $('button[name=add_news]').click(function(){
            $('#add_news').modal('show');
        });

        $('#start_time').datetimepicker({minView: "month", format: "yyyy-mm-dd", language: 'zh-CN', autoclose:true});
        $('#end_time').datetimepicker({minView: "month", format: "yyyy-mm-dd", language: 'zh-CN', autoclose:true});

        $('.btn1').click(function(){
            $('select[name=choice]').html("<option value=''>请选择</option>");
            $.ajax({
                url:"http://"+url+"/index.php/Comment/get_news_people",
                type:'POST',
                data:{type:'1'},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        for($i=0;$i<data[0].data.length;$i++){
                            tr = "<option  value="+data[0].data[$i].id+','+data[0].data[$i].pid+">"+data[0].data[$i].name+"</option>";
                            $('select[name=choice]').append(tr);
                        }

                    }

                }
            })
        });
        $('.btn2').click(function(){
            $('select[name=choice]').html("<option value=''>请选择</option>");
            $.ajax({
                url:"http://"+url+"/index.php/Comment/get_news_people",
                type:'POST',
                data:{type:'2'},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        for($i=0;$i<data[0].data.length;$i++){
                            tr = "<option  value="+data[0].data[$i].id+','+data[0].data[$i].pid+">"+data[0].data[$i].name+"</option>";
                            $('select[name=choice]').append(tr);
                        }

                    }

                }
            })
        });
        $('select[name=choice]').change(function(){
            var id = $(this).val();
            $('.plan_people').html('');
            $('input[name=hidden_type]').val('');
            $.ajax({
                url:"http://"+url+"/index.php/Comment/choice",
                type:'POST',
                data:{id:id},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        for($i=0;$i<data[0].data.length;$i++){

                            tr = "<input type='checkbox' id="+data[0].data[$i].id+" class='choice_people' value="+data[0].data[$i].name+"  /> <label style='cursor:pointer' for="+data[0].data[$i].id+">"+data[0].data[$i].name+"</label> &nbsp;";
                            $('.plan_people').append(tr);
                        }
                        $('input[name=hidden_type]').val(data[0].type);
                    }

                }
            })
        })

        $('button[name=send_plan]').click(function(){
            var conetnt = $('textarea[name=content]').val();
            if(conetnt.length == 0){
                alert('计划内容不能为空');
                return false;
            }
            var start_time = $('#plan_start_time').val();
            
            var group_id = $('#group_plan').val();
            $.ajax({
                url:"http://"+url+"/index.php/Comment/add_news_people",
                type:'POST',
                data:{content:conetnt,start_time:start_time,group_id:group_id},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        alert('发布计划成功');
                        $('#add_news').modal('hide');
                    }

                }
            })
        })

        $('.plan_success').click(function(){
            var id = $(this).attr('name');
            $.ajax({
                url:"http://"+url+"/index.php/Comment/plan_success",
                type:'POST',
                data:{id:id},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        $("div[name=plan_"+id+"]").slideUp();
                    }
                }
            })

        })

        $(document).on('click','.del_news',function () {
            var id = $(this).attr('name');
            $.ajax({
                url:"http://"+url+"/index.php/Comment/del_news",
                type:'POST',
                data:{id:id},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        $(".news_"+id+"").slideUp();
                    }
                }
            })
        });
        $('.self_end_state').click(function () {
            if(this.checked == true){
                $('.endTime_div').show();
            }else{
                $('.endTime_div').hide();


            }
        });
        $('.self_edit_end_state').click(function () {
            if(this.checked == true){
                $('.endTime_div').show();
            }else{
                $('.endTime_div').hide();


            }
        });
        $('.allday').click(function () {
            if(this.checked == true){
                $('#sel_start').hide();
                $('#sel_end').hide();
                $('select[name=e_hour]').val('');
                $('select[name=e_minute]').val('');

            }else{
                $('#sel_start').show();
                $('#sel_end').show();
            }

        });
        $('.allday_edit').click(function () {
            if(this.checked == true){
                $('#sel_edit_start').hide();
                $('#sel_edit_end').hide();
                $('select[name=e_edit_hour]').val('');
                $('select[name=e_edit_minute]').val('');

            }else{
                $('#sel_edit_start').show();
                $('#sel_edit_end').show();
            }

        });
        $('.sel_add').click(function () {
            var title = $('.sel_title').val();
            if(title == ''){
                alert('请输入日程内容');
                return false;
            }
            var allday = $('.allday:checked').val();
            var starttime = $('.sel_starttime').val();
            var endtime = $('.sel_endtime').val();
            var s_hour = $('select[name=s_hour]').val();
            var s_minute = $('select[name=s_minute]').val();
            var e_hour = $('select[name=e_hour]').val();
            var e_minute = $('select[name=e_minute]').val();
            var enddate = $('.self_end_state:checked').val();
            
            $.ajax({
                url:"http://"+url+"/index.php/Comment/add_self_plan",
                type:'POST',
                data:{title:title,allday:allday,starttime:starttime,endtime:endtime,s_hour:s_hour,s_minute:s_minute,e_hour:e_hour,e_minute:e_minute,enddate:enddate},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        window.location.reload();
                    }
                    else
                    {
                        alert('网络繁忙,稍后再试');
                    }
                }
            })
        });
        //$('.fc-event-inner').tooltip('1111')

        $('.sel_delete').click(function () {
            var id = $(this).val();
            $.ajax({
                url:"http://"+url+"/index.php/Comment/sel_delete",
                type:'POST',
                data:{id:id},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        window.location.reload();
                    }
                    else
                    {
                        alert('网络繁忙,稍后再试');
                    }
                }
            })
        });
        $('.sel_save_color').click(function () {
            var id = $(this).val();
            $.ajax({
                url:"http://"+url+"/index.php/Comment/sel_save_color",
                type:'POST',
                data:{id:id},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        window.location.reload();
                    }
                    else
                    {
                        alert('网络繁忙,稍后再试');
                    }
                }
            })
        });
        
        $('.sch_new_add').click(function () {
            $.ajax({
                url:"http://"+url+"/index.php/Office/sch_set",
                type:'POST',
                data:{},
                dataType:'json',
                success: function(data){
                    if(data.info == '没有权限'){
                        alert('没有权限');
                    }
                    if(data[0].success == true){
                        $('#sch_add_new_modal').modal('show');
                    }
                }
            });
        });
        $('.sch_new_add_modal').click(function () {
            $('#sch_modal_add_new').modal('show');
        });
        $('.sch_new_add_my').click(function () {
            var title = $('.sch_new_name').val();
            if(title.length == 0){
                alert('内容不能为空!');
                return false;
            }
            var starttime = $('.sch_new_starttime').val();
           
            var state = $('input[name=sch_new_state]:checked').val();

            
            $.ajax({
                url:"http://"+url+"/index.php/Office/sch_add_admin_info",
                type:'POST',
                data:{title:title,startTime:starttime,state:state},
                dataType:'json',
                success: function(data){
                    if(data.info == '没有权限'){
                        alert('没有权限');
                    }
                    if(data[0].success == true){
                        window.location.reload();
                    }
                    else
                    {
                        alert('网络繁忙,稍后再试');
                    }
                }
            })
        });
        
        
        $('.sch_info_set_state').click(function () {
            var id = $(this).attr('id');
            var state = $(this).attr('title');
            $.ajax({
                url:"http://"+url+"/index.php/Comment/sch_update_state",
                type:'POST',
                data:{state:state,id:id},
                dataType:'json',
                success: function(data){
                    if(data.info == '没有权限'){
                        alert('没有权限');
                    }
                    if(data[0].success == true){
                        $("#"+id).html(data[0].msg);
                        $("#"+id).attr('title',data[0].data);
                    }
                    else
                    {
                        alert('网络繁忙,稍后再试');
                    }
                }
            })
        });
        
        $('.sch_info_delete').click(function () {
            var id = $(this).attr('id');
            $.ajax({
                url:"http://"+url+"/index.php/Comment/sch_delete_list",
                type:'POST',
                data:{id:id},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        $(".sch_list_"+id).hide();
                    }
                    else
                    {
                        alert('网络繁忙,稍后再试');
                    }
                }
            })
        });

        $('.sch_file_add').click(function () {
            $.ajax({
                url:"http://"+url+"/index.php/Office/sch_file",
                type:'POST',
                data:{},
                dataType:'json',
                success: function(data){
                    if(data.info == '没有权限'){
                        alert('没有权限');
                        return false;
                    }
                    if(data[0].success == true){
                        $('#sch_file_modal').modal('show');
                    }
                }
            });

        });

        $(function () {
            var url = $('#url').val();

            $('#btn_upload').uploadify({
                'uploader': "http://"+url+"/index.php/Comment/sch_file_add",           // 服务器处理地址
                swf: '/Public/Admin/assets/js/uploadify/uploadify.swf',
                buttonText: "选择文件",                  //按钮文字
                height: 34,                             //按钮高度
                width: 100,                              //按钮宽度
                fileTypeExts: "*.*",           //允许的文件类型
                fileTypeDesc: "请选择图片文件",           //文件说明
                multi: false,
                onUploadSuccess: function (file, data, response) {   //一个文件上传成功后的响应事件处理
//                    alert('上传成功');
//                    window.location.reload();
                    var name = $('#sel_files').val();
                    $.ajax({
                        url:"http://"+url+"/index.php/Comment/add_mkdir_list",
                        type:'POST',
                        data:{name:name,title:file.name},
                        dataType:'json',
                        success: function(data){
                            if(data[0].success == true){
                                alert('上传成功');
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });

        $('.public_chose').click(function () {
            if(this.checked == true){
                $('#public_peo').css('display','block');
            }else{
                $('#public_peo').css('display','none');
            }
        });
        $('.mkdir_file').click(function () {
            $.ajax({
                url:"http://"+url+"/index.php/Office/sch_file",
                type:'POST',
                data:{},
                dataType:'json',
                success: function(data){
                    if(data.info == '没有权限'){
                        alert('没有权限');
                        return false;
                    }
                    if(data[0].success == true){
                        $('#mkdir_file_modal').modal('show');
                    }
                }
            });
        });
        $('.mkdir_file_true').click(function () {
            var name = $('.mkdir_file_name').val();
            $.ajax({
                url:"http://"+url+"/index.php/Comment/mkdir_file",
                type:'POST',
                data:{name:name},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        window.location.reload();
                    }else{
                        alert('该文件夹已存在');
                    }
                }
            });
        });

        $('.get_mkdir').click(function () {
            var title = $(this).html();
            $('.mkdir_title').html(title);
            $('.mkdir_table').html('');
            $.ajax({
                url:"http://"+url+"/index.php/Comment/get_mkdir",
                type:'POST',
                data:{title:title},
                dataType:'json',
                success: function(data){

                    $('#get_file_modal').modal('show');
                    if(data[0].success == true){

                        for(var i=0;i<data[0].data.length;i++){

                            var title =encodeURI(data[0].data[i].title);

                            //var title = data[0].data[i].title;
                            tr = "<tr><td>"+data[0].data[i].title+"</td><td>"+data[0].data[i].time+"</td><td>"+data[0].data[i].uname+"</td> <td><a target='_blank' href='http://ow365.cn/?i=11756&furl=http://jys.fyedu.org/Public/Uploads/sch_file/"+data[0].data[i].reg+"/"+title+"'>查看</a> <a href='javascript:;' class='delWorkFile' title="+data[0].data[i].id+" >删除</a></td>    </tr>"
                            $('.mkdir_table').append(tr);
                        }
                    }
                }
            });

        });
        $(document).on('click','td[name=plan_edit_state]',function () {
            var id = $(this).attr('title');
            var state = $(this).html();
            $.ajax({
                url:"http://"+url+"/index.php/Comment/plan_edit_state",
                type:'POST',
                data:{id:id,state:state},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        $(".plan"+id).html(data[0].data);
                    }
                }
            })
        });

        $(document).on('click','.edit_news',function () {
            var id  = $(this).attr('name');
            $.ajax({
                url:"http://"+url+"/index.php/Comment/getHavenews",
                type:'POST',
                data:{id:id},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        $('#get_add_news').modal('show');
                        $('.get_news_content').html(data[0].data.content);
                        $('.get_news_id').val(data[0].data.id);
                    }
                }
            })
        });
        $('button[name=edit_news_cntent]').click(function () {
            var id = $('.get_news_id').val();
            var content = $('.get_news_content').val();
            $.ajax({
                url:"http://"+url+"/index.php/Comment/edit_news_true",
                type:'POST',
                data:{id:id,content:content},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        window.location.reload();
                    }else{
                        alert('网络繁忙,稍后再试');
                    }
                }
            })
        });


         $('.edit_sch_modal').click(function () {
            $('#sch_modal_edit_new').modal('show');
            var id = $(this).attr('title');
            var title = $(this).attr('name');
            var time = $(this).attr('time');
            $('.user_edit_time').val(time);
            $('.sch_edit_new_name').val(title);
            $('.sch_edit_id').val(id);
        });


        $('.sch_new_edit_my').click(function () {
            var id = $('.sch_edit_id').val();
            var title = $('.sch_edit_new_name').val();
            var starttime = $('.user_edit_time').val();
            $.ajax({
                url:"http://"+url+"/index.php/Comment/sch_edit_con",
                type:'POST',
                data:{id:id,title:title,startTime:starttime},
                dataType:'json',
                success: function(data){
                    if(data[0].success == true){
                        window.location.reload();
                    }else{
                        alert('网络繁忙,稍后再试');
                    }
                }
            })
        });
        $('#chose_time').click(function(){
            var ftime = $('#chose_ftime').val();
            var ltime = $('#chose_ltime').val();
            location.href='http://'+url+'/index.php/Index/index.html?first='+ftime+'&footer='+ltime;
        });
        $('.delSchFile').click(function () {
            var name = $(this).attr('name');
            $.ajax({
                url:"http://"+url+"/index.php/Office/delSchFile",
                type:'POST',
                data:{name:name},
                dataType:'json',
                success:function (data) {
                    if(data[0].success == true)
                    {
                        window.location.reload();
                    }else{
                        alert('网络繁忙,稍后再试');
                    }
                }
            })
        });
        $(document).on('click','.delWorkFile',function () {
            var title = $(this).attr('title');
            $.ajax({
                url:"http://"+url+"/index.php/Office/delWorkFile",
                type:'POST',
                data:{id:title},
                dataType:'json',
                success:function (data) {
                    if(data[0].success == true)
                    {
                        window.location.reload();
                    }else{
                        alert('网络繁忙,稍后再试');
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