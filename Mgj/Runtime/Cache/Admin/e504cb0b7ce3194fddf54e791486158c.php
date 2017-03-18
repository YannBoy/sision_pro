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

				
    <!--<script src="https://img.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>-->
    <script src='/Public/Admin/js/jquery-1.8.3.min.js'></script>
    <!--<script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>-->
    <script src="/Public/Admin/assets/js/123.js"></script>
    <script src="https://img.hcharts.cn/highcharts/highcharts-more.js"></script>
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
                    <a href="#">成绩报表</a>
                </li>
                <li class="active">成绩分析</li>
            </ul><!-- .breadcrumb -->
        </div>
        <div class="page-content" >
            <div class="page-header" style="margin:0px">
                <h1>
                    成绩报表
                    <small>
                        <i class="icon-double-angle-right"></i>
                        成绩分析
                    </small>
                    <button type="button" class="btn btn-warning btn-xs pull-right" id="print">导出</button>
                </h1>

            </div><!-- /.page-header -->

            <a href="<?php echo U('ocode_rep',array('id'=>$_GET['id']));?>"><button class="btn btn-info btn-xs pull-right getSubInfo" style="margin-top:8px;margin-left: 250px;">返回</button></a>
            <!--<button type="button" class="pull-right btn-danger btn-xs tool" style="margin-top:8px;margin-left: 250px;">测量工具</button>-->
            <div style="width:770px;margin: 0 auto;height:40px;margin-bottom:10px;" class="sub-ul">
                <ul>
                    <?php if(is_array($subname)): $i = 0; $__LIST__ = $subname;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subname): $mod = ($i % 2 );++$i;?><a href="<?php echo U('subinfo',array('id'=>$_GET['id'],'subject'=>$subname['key']));?>"><li class="sub-no <?php echo ($subname["key"]); ?>"><?php echo ($subname["name"]); ?></li></a><?php endforeach; endif; else: echo "" ;endif; ?>

                </ul>

            </div>

            <!--startprint-->
            <div class="row" name="remove_tool">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="table-responsive">
                                        <div class="tool_border" style="border-top:1px solid black;width:700px;position: absolute;display: none;cursor: pointer;z-index: 1000000;"></div>
                                        <div class="rep_first">
                                            <div style="padding-bottom:10px;border:1px solid #999;border-bottom:0px;width:700px">
                                                <h2 class="center"><?php echo ($Exam["name"]); ?></h2>
                                                <div class="rep-header" style="border-top:1px solid #999;padding-top:10px">
                                                    <p>考试时间: <?php echo ($Exam["examtime"]); ?></p>
                                                    <p>监测科目: <?php echo ($chsub); ?></p>
                                                    <p>监测学校:
                                                        <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$schname): $mod = ($i % 2 );++$i; if($schname['schoolname'] != '总体情况'){?>
                                                            <?php echo $schname['schoolname'].'、' ?>
                                                            <?php } endforeach; endif; else: echo "" ;endif; ?>
                                                    </p>
                                                    <p>①.</p>
                                                    <p><?php echo ($chsub); ?>综合指数≥3.0的学校（按照指数从大到小排列）：<span class="classgood"></span></p>
                                                    <p><?php echo ($chsub); ?>总分综合指数<3.0的学校（按照指数从大到小排列）：<span class="classlow"></span></p>
                                                    <p>②.</p>
                                                    <p><?php echo ($chsub); ?>A率≥15%的学校（按照指数从大到小排列）：<span class="aclassgood"></span></p>
                                                    <p><?php echo ($chsub); ?>A率<15%的学校（按照指数从大到小排列）：<span class="aclasslow"></span></p>
                                                    <p>③.</p>
                                                    <p><?php echo ($chsub); ?>后30%≤30%的学校（按照指数从小到大排列 :<span class="bclassgood"></span></p>
                                                    <p><?php echo ($chsub); ?>后30%>30%的学校（按照指数从小到大排列）：<span class="bclasslow"></span></p>
                                                    <p>④.</p>
                                                    <p><?php echo ($chsub); ?>标准分平均分≥500的学校（按照指数从大到小排列 :<span class="allclassgood"></span></p>
                                                    <p><?php echo ($chsub); ?>总分标准分平均分<500的学校（按照指数从大到小排列）：<span class="allclasslow"></span></p>

                                                </div>
                                            </div>

                                            <div id="compolite" style="width:700px;height:390px;border:1px solid #999;padding:20px"></div>
                                            <div id="stand" style="width:700px;height:390px;border:1px solid #999;padding:20px"></div>
                                            <div id="container" style="width:700px;height:390px;border:1px solid #999;padding:20px"></div>
                                            <div id="someall" style="width:700px;height:520px;border:1px solid #999;padding:20px"></div>
                                            <div id="someall2" style="width:700px;height:520px;border:1px solid #999;padding:20px"></div>
                                            <div id="someall1" style="width:700px;height:520px;border:1px solid #999;padding:20px"></div>
                                            <div style="padding-bottom:20px;border:1px solid #999;width:700px">
                                                <h3 class="center">数据报告</h3>
                                                <table class="table-bordered rep-tabel">
                                                    <tr>
                                                        <th class="center" style="width:160px;">学校</th>
                                                        <th class="center">参考人数</th>
                                                        <th class="center">A</th>
                                                        <th class="center">B</th>
                                                        <th class="center">C</th>
                                                        <th class="center">D</th>
                                                        <th class="center">E</th>
                                                        <th class="center">综合指数</th>
                                                    </tr>
                                                    <tbody>
                                                    <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><tr>
                                                            <td class="center"><?php echo ($info["schoolname"]); ?></td>
                                                            <td class="center"><?php echo ($info["schNum"]); ?></td>
                                                            <td class="center"><?php echo ($info["A"]); ?>%</td>
                                                            <td class="center"><?php echo ($info["B"]); ?>%</td>
                                                            <td class="center"><?php echo ($info["C"]); ?>%</td>
                                                            <td class="center"><?php echo ($info["D"]); ?>%</td>
                                                            <td class="center"><?php echo ($info["E"]); ?>%</td>
                                                            <td class="center"><?php echo ($info["composite"]); ?></td>
                                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
 $sub = $_GET['subject'] ? $_GET['subject'] : 'total'; if($sub != 'total'){ ?>
                                            <div id="jian" style="width:700px;height:390px;border:1px solid #999;padding:20px"></div>
                                            <div id="zhon" style="width:700px;height:390px;border:1px solid #999;padding:20px"></div>
                                            <div id="nan" style="width:700px;height:390px;border:1px solid #999;padding:20px"></div>
                                            <div id="nan1" style="width:700px;height:390px;border:1px solid #999;padding:20px"></div>
                                            <div id="nan2" style="width:700px;height:390px;border:1px solid #999;padding:20px"></div>
                                            <div style="border:1px solid #999;width:700px;padding-bottom:20px">
                                                <h3 class="center">知识点</h3>
                                                <table class="table-bordered rep-tabel" >
                                                    <?php if(is_array($know)): $i = 0; $__LIST__ = $know;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$know): $mod = ($i % 2 );++$i;?><tr>
                                                            <td class="center">
                                                                <input type="checkbox" name="know_choclick" class="<?php echo ($know["know_keys"]); ?>" title="<?php echo ($know["know_name"]); ?>" abc="news<?php echo ($i); ?>">
                                                            </td>
                                                            <td class="center"><?php echo ($i); ?></td>
                                                            <td class="center"><?php echo ($know["know_name"]); ?></td>
                                                            <td style="padding-left:10px"><?php echo ($know["know_keys"]); ?></td>
                                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </table>
                                            </div>
                                            <?php }?>
                                            <div style="width:700px;padding-bottom:20px;" class="fracmodal">
                                            </div>
                                        </div>
                                    </div><!-- /.table-responsive -->
                                </div><!-- /span -->
                            </div><!-- /row -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->
    <!--endprint-->

    <input type="hidden" class="schName" value="<?php echo $_GET['ocode']?>">

    <!--<script src="/Public/Admin/assets/js/report.js"></script>-->
    <script>
        var url = $('#oa_url').val();
        $(document).ready(function () {
            var course_bh = "<?php echo $_GET['subject']?>";
            if(!course_bh)
            {
                course_bh = 'total';
            }
            $("."+course_bh).removeAttr('class');
            var id = "<?php echo $_GET['id']?>";
            $.ajax({
                url:"http://"+url+"/index.php/Comment/get_knowclickss",
                type:'POST',
                data:{know_id:id,sub:course_bh,tips:'sim1'},
                dataType:'json',
                success: function(data){
                    $('#jian').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '难度系数 0.8 ~ 1'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category'

                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: ''
                            },
                            plotLines: [{ // mark the weekend
                                color: 'red',
                                width: 2,
                                value: data.testnews[0],
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-40                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                }
                            }]

                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: ''
                        },

                        series: [{
                            name: '11',
                            data: data.infos,
                            dataLabels: {
                                enabled: true,
                                rotation:0,
                                color: '#FFFFFF',
                                align: 'center',
                                format: '{point.y:.3f}', // one decimal
                                y: 0, // 10 pixels down from the top
                                style: {
                                    fontSize: '8px',
                                    fontFamily: 'Verdana, sans-serif'
                                },
                                maxPointWidth: -1
                            }
                        }]
                    });
                    $('#jian').append("<div style='padding-left:260px;float:left'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;全区</div>");

                }
            });
            $.ajax({
                url:"http://"+url+"/index.php/Comment/get_knowclickss",
                type:'POST',
                data:{know_id:id,sub:course_bh,tips:'sim2'},
                dataType:'json',
                success: function(data){
                    if(data.testnews[1]==0)
                    {
                        $('#zhon').hide();
                    }
                    $('#zhon').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '难度系数 0.6 ~ 0.8'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category'

                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: ''
                            },
                            plotLines: [{ // mark the weekend
                                color: 'green',
                                width: 2,
                                value: data.tips,
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-40                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                }
                            },{ // mark the weekend
                                color: 'red',
                                width: 2,
                                value: data.testnews[1],
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-40                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                }
                            }]

                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: ''
                        },

                        series: [{
                            name: '11',
                            data: data.infos,
                            dataLabels: {
                                enabled: true,
                                rotation:0,
                                color: '#FFFFFF',
                                align: 'center',
                                format: '{point.y:.3f}', // one decimal
                                y: 0, // 10 pixels down from the top
                                style: {
                                    fontSize: '8px',
                                    fontFamily: 'Verdana, sans-serif'
                                },
                                maxPointWidth: -1
                            }
                        }]
                    });
                    $('#zhon').append("<div style='padding-left:260px;float:left'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;全区</div>");

                }
            });
            $.ajax({
                url:"http://"+url+"/index.php/Comment/get_knowclickss",
                type:'POST',
                data:{know_id:id,sub:course_bh,tips:'sim4'},
                dataType:'json',
                success: function(data){
                    if(data.testnews[3] == 0){
                        $('#nan1').hide();
                    }
                    $('#nan1').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '难度系数 0.2 ~ 0.4'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category'

                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: ''
                            },
                            plotLines: [{ // mark the weekend
                                color: 'green',
                                width: 2,
                                value: data.tips,
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-40                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                }
                            },{ // mark the weekend
                                color: 'red',
                                width: 2,
                                value: data.testnews[3],
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-40                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                }
                            }]

                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: ''
                        },

                        series: [{
                            name: '11',
                            data: data.infos,
                            dataLabels: {
                                enabled: true,
                                rotation:0,
                                color:'#ffffff',
                                align: 'center',
                                format: '{point.y:.3f}', // one decimal
                                y: 0, // 10 pixels down from the top
                                style: {
                                    fontSize: '8px',
                                    fontFamily: 'Verdana, sans-serif'
                                },
                                maxPointWidth: -1
                            }
                        }]
                    });
                    $('#nan1').append("<div style='padding-left:260px;float:left'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;全区</div>");

                }
            });
            $.ajax({
                url:"http://"+url+"/index.php/Comment/get_knowclickss",
                type:'POST',
                data:{know_id:id,sub:course_bh,tips:'sim5'},
                dataType:'json',
                success: function(data){
                    if(data.testnews[4] == 0){
                        $('#nan2').hide();
                    }
                    $('#nan2').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '难度系数 0 ~ 0.2'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category'

                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: ''
                            },
                            plotLines: [{ // mark the weekend
                                color: 'green',
                                width: 2,
                                value: data.tips,
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-40                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                }
                            },{ // mark the weekend
                                color: 'red',
                                width: 2,
                                value: data.testnews[4],
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-40                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                }
                            }]

                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: ''
                        },

                        series: [{
                            name: '11',
                            data: data.infos,
                            dataLabels: {
                                enabled: true,
                                rotation:0,
                                color:'#ffffff',
                                align: 'center',
                                format: '{point.y:.3f}', // one decimal
                                y: 0, // 10 pixels down from the top
                                style: {
                                    fontSize: '8px',
                                    fontFamily: 'Verdana, sans-serif'
                                },
                                maxPointWidth: -1
                            }
                        }]
                    });
                    $('#nan2').append("<div style='padding-left:260px;float:left'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;全区</div>");

                }
            });
            $.ajax({
                url:"http://"+url+"/index.php/Comment/get_knowclickss",
                type:'POST',
                data:{know_id:id,sub:course_bh,tips:'sim3'},
                dataType:'json',
                success: function(data){
                    $('#nan').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '难度系数 0.4 ~ 0.6'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category'

                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: ''
                            },
                            plotLines: [{ // mark the weekend
                                color: 'green',
                                width: 2,
                                value: data.tips,
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-40                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                }
                            },{ // mark the weekend
                                color: 'red',
                                width: 2,
                                value: data.testnews[2],
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-40                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                }
                            }]

                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: ''
                        },

                        series: [{
                            name: '11',
                            data: data.infos,
                            dataLabels: {
                                enabled: true,
                                rotation:0,
                                color: '#FFFFFF',
                                align: 'center',
                                format: '{point.y:.3f}', // one decimal
                                y: 0, // 10 pixels down from the top
                                style: {
                                    fontSize: '8px',
                                    fontFamily: 'Verdana, sans-serif'
                                },
                                maxPointWidth: -1
                            }
                        }]
                    });
                    $('#nan').append("<div style='padding-left:260px;float:left'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;全区</div>");

                }
            });


            $.ajax({
                url: "http://" + url + "/index.php/Comment/imgReport",
                type: 'POST',
                data: {id:id,sub:course_bh},
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
                        $('#container').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: data.title+'各段堆积图'
                            },
                            xAxis: {
                                categories: data.info.schoolname
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: ''
                                },
                                ceiling:400,
                                plotLines: [{
                                    color: 'red',           //线的颜色，定义为红色
                                    dashStyle: 'solid',     //默认值，这里定义为实线
                                    value: 85,               //定义在那个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
                                    width: 1 ,               //标示线的宽度，2px
                                    label:{
                                        text:'',     //标签的内容
                                        align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                        x:-40  ,                       //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                        y:4
                                    }
                                },
                                    {
                                        color: 'green',           //线的颜色，定义为红色
                                        dashStyle: 'solid',     //默认值，这里定义为实线
                                        value: 30,               //定义在那个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
                                        width: 1   ,           //标示线的宽度，2px
                                        label:{
                                            text:'',     //标签的内容
                                            align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                            x:-40  ,                       //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                            y:4
                                        }
                                    }
                                ]
                            },

                            tooltip: {
                                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                                shared: true
                            },
                            plotOptions: {
                                column: {
                                    stacking: 'percent',
                                    pointWidth:25,
                                    dataLabels: {
                                        enabled: true,
                                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                                        style: {
                                            textShadow: '0 0 2px black'
                                        }
                                    }
                                },
                                series: {
                                    allowPointSelect: false,//点击变色
                                    cursor: 'pointer',
                                    events: {
                                        click: function(e) {
                                            var class_name = e.point.category;
                                            window.open('http://'+url+'/index.php/Report/class_rep/id/'+id+'/ocode/'+class_name);
                                        },
                                        legendItemClick: function() {
                                            return false;
                                        }
                                    }
                                }
                            },
                            series: [{
                                name: 'A (15%)',
                                color: '#CC0000 ',
                                data: data.info.info.A,
                                dataLabels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }, {
                                name: 'B (25%)',
                                color: '#EE7700',
                                data: data.info.info.B,
                                dataLabels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }, {
                                name: 'C (30%)',
                                color: '#DDAA00',
                                data: data.info.info.C,
                                dataLabels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            },{
                                name: 'D (25%)',
                                color: '#88AA00',
                                data: data.info.info.D,
                                dataLabels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            },{
                                name: 'E (5%)',
                                color: '#00AA00',
                                data: data.info.info.E,
                                dataLabels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }]
                        });
                        $('#container').append("<div style='padding-left:240px;float:left'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;85%</div>");
                        $('#container').append("<div style='padding-left:80px;float:left'><p style='height: 10px;width:25px;border-bottom:2px solid green;float: left'></p>&nbsp;30%</div>");

                    }
                }
            });
            $.ajax({
                url: "http://" + url + "/index.php/Comment/composliteAll",
                type: 'POST',
                data: {id:id,subject:course_bh},
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
                        $('#compolite').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '各校'+data.title+'综合指数柱状图'
                            },
                            subtitle: {
                                text: ''
                            },
                            xAxis: {
                                type: 'category'

                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: ''
                                },
                                plotLines: [{ // mark the weekend
                                    color: 'red',
                                    width: 2,
                                    value: 3,
                                    dashStyle: 'solid',
                                    label:{
                                        text:'',     //标签的内容
                                        align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                        x:10                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                    }
                                },{ // mark the weekend
                                    color: 'red',
                                    width: 1,
                                    value: 2.5,
                                    dashStyle: 'solid',
                                    label:{
                                        text:'',     //标签的内容
                                        align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                        x:10                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                    }
                                }]

                            },
                            legend: {
                                enabled: false
                            },
                            tooltip: {
                                pointFormat: ''
                            },
                            series: [{
                                name: '11',
                                data: data.infos,
                                dataLabels: {
                                    enabled: true,
                                    rotation:0,
                                    color: '#FFFFFF',
                                    align: 'center',
                                    format: '{point.y:.3f}', // one decimal
                                    y: 0, // 10 pixels down from the top
                                    style: {
                                        fontSize: '7px'
                                    }
                                }
                            }]
                        });
                        $('.classgood').html(data.good);
                        $('.classlow').html(data.low);
                        $('#compolite').append("<div style='padding-left:260px'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;综合指数标准线</div>");

                    }
                }
            });
            $.ajax({
                url: "http://" + url + "/index.php/Comment/standardScore",
                type: 'POST',
                data: {id:id,subject:course_bh},
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
                        $('#stand').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: data.title+'平均分的标准分'
                            },
                            subtitle: {
                                text: ''
                            },
                            xAxis: {
                                type: 'category'

                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: ''
                                },
                                plotLines: [{ // mark the weekend
                                    color: 'red',
                                    width: 2,
                                    value: 500,
                                    dashStyle: 'solid',
                                    label:{
                                        text:'',     //标签的内容
                                        align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                        x:-40,                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                        y:10
                                    }
                                }]

                            },
                            legend: {
                                enabled: false
                            },
                            tooltip: {
                                pointFormat: ''
                            },
                            series: [{
                                name: '11',
                                data: data.infos,
                                dataLabels: {
                                    enabled: true,
                                    rotation:-90,
                                    color: '#FFFFFF',
                                    align: 'right',
                                    format: '{point.y:.1f}', // one decimal
                                    y: 10, // 10 pixels down from the top
                                    style: {
                                        fontSize: '10px',
                                        fontFamily: 'Verdana, sans-serif'
                                    }
                                }
                            }]
                        });
                        $('.allclassgood').html(data.good);
                        $('.allclasslow').html(data.low);
                        $('#stand').append("<div style='padding-left:260px'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;平均分标准分</div>");

                    }
                }
            });
            $.ajax({
                url: "http://" + url + "/index.php/Comment/getsomeinfo",
                type: 'POST',
                data: {id:id,subject:course_bh},
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
//                        $('#someall').highcharts({
//                            chart: {
//                                type: 'column'
//                            },
//                            title: {
//                                text: '各校前15%及后30%学生比率柱状图'
//                            },
//                            xAxis: {
//                                categories: data.schoolname
//                            },
//                            yAxis: {
//                                ceiling:400,
//                                title: {
//                                    text: ''
//                                },
//                                plotLines: [{
//                                    color: 'red',           //线的颜色，定义为红色
//                                    dashStyle: 'solid',     //默认值，这里定义为实线
//                                    value: data.infos.A[0],               //定义在那个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
//                                    width: 1,                //标示线的宽度，A2px
//                                    label:{
//                                        text:'',     //标签的内容
//                                        align:'left',                //标签的水平位置，水平居左,默认是水平居中center
//                                        x:-40  ,                       //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
//                                        y:4
//                                    }
//                                },
//                                    {
//                                        color: 'green',           //线的颜色，定义为红色
//                                        dashStyle: 'solid',     //默认值，这里定义为实线
//                                        value: data.infos.E[0],               //定义在那个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
//                                        width: 1 ,                //标示线的宽度，2px
//                                        label:{
//                                            text:'',     //标签的内容
//                                            align:'left',                //标签的水平位置，水平居左,默认是水平居中center
//                                            x:-40  ,                       //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
//                                            y:4
//                                        }            //标示线的宽度，2px
//                                    }
//                                ]
//                            },
//                            credits: {
//                                enabled: false
//                            },
//                            series: [{
//                                name: '前15%',
//                                data: data.infos['A'],
//                                color:'red',
//                                dataLabels: {
//                                    enabled: true,
//                                    rotation:-90,
//                                    color: '#FFFFFF',
//                                    align: 'right',
//                                    format: '{point.y:.0f}', // one decimal
//                                    y: 10, // 10 pixels down from the top
//                                    style: {
//                                        fontSize: '9px',
//                                        fontFamily: 'Verdana, sans-serif'
//                                    }
//                                }
//                            }, {
//                                name: '后30%',
//                                data: data.infos['E'],
//                                dataLabels: {
//                                    enabled: true,
//                                    rotation:-90,
//                                    color: '#FFFFFF',
//                                    align: 'center',
//                                    format: '{point.y:.2f}', // one decimal
//                                    y: 8, // 10 pixels down from the top
//                                    style: {
//                                        fontSize: '9px'
//                                    }
//                                }
//                            }]
//                        });
                        $('#someall').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '各校前15%学生比率柱状图'
                            },
                            subtitle: {
                                text: ''
                            },
                            xAxis: {
                                type: 'category'

                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: ''
                                },
                                plotLines: [{ // mark the weekend
                                    color: 'red',
                                    width: 2,
                                    value: data.arearate.A,
                                    dashStyle: 'solid',
                                    label:{
                                        text:'',     //标签的内容
                                        align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                        x:-40,                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                        y:10
                                    }
                                }]

                            },
                            legend: {
                                enabled: false
                            },
                            tooltip: {
                                pointFormat: ''
                            },
                            series: [{
                                name: '11',
                                data: data.infos['A'],
                                dataLabels: {
                                    enabled: true,
                                    rotation:0,
                                    color: '#FFFFFF',
                                    align: 'center',
                                    format: '{point.y:.1f}', // one decimal
                                    y: 0, // 10 pixels down from the top
                                    style: {
                                        fontSize: '8px',
                                        fontFamily: 'Verdana, sans-serif'
                                    }
                                }
                            }]
                        });
                        $('#someall2').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '各校前40%学生比率柱状图'
                            },
                            subtitle: {
                                text: ''
                            },
                            xAxis: {
                                type: 'category'

                            },
                            yAxis: {
                                min:10,
                                title: {
                                    text: ''
                                },
                                plotLines: [{ // mark the weekend
                                    color: 'red',
                                    width: 2,
                                    value: data.arearate.B,
                                    dashStyle: 'solid',
                                    label:{
                                        text:'',     //标签的内容
                                        align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                        x:-40,                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                        y:10
                                    }
                                }]

                            },
                            legend: {
                                enabled: false
                            },
                            tooltip: {
                                pointFormat: ''
                            },
                            series: [{
                                name: '11',
                                data: data.infos['B'],
                                dataLabels: {
                                    enabled: true,
                                    rotation:0,
                                    color: '#FFFFFF',
                                    align: 'center',
                                    format: '{point.y:.1f}', // one decimal
                                    y: 0, // 10 pixels down from the top
                                    style: {
                                        fontSize: '8px',
                                        fontFamily: 'Verdana, sans-serif'
                                    }
                                }
                            }]
                        });
                        $('#someall1').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '各校后30%学生比率柱状图'
                            },
                            subtitle: {
                                text: ''
                            },
                            xAxis: {
                                type: 'category'

                            },
                            yAxis: {
                                max: -20,
                                min:-100,
                                title: {
                                    text: ''
                                },
                                plotLines: [{ // mark the weekend
                                    color: 'red',
                                    width: 2,
                                    value: -data.arearate.E,
                                    dashStyle: 'solid',
                                    label:{
                                        text:'',     //标签的内容
                                        align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                        x:-40,                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
                                        y:10
                                    }
                                }]

                            },
                            legend: {
                                enabled: false
                            },
                            tooltip: {
                                pointFormat: ''
                            },
                            series: [{
                                name: '11',
                                data: data.infos['E'],
                                dataLabels: {
                                    enabled: true,
                                    rotation:0,
                                    color: '#FFFFFF',
                                    align: 'center',
                                    format: '{point.y:.1f}', // one decimal
                                    y: 0, // 10 pixels down from the top
                                    style: {
                                        fontSize: '8px',
                                        fontFamily: 'Verdana, sans-serif'
                                    }
                                }
                            }]
                        });

                        $('#someall').append("<div style='padding-left:260px;'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;前15%全区平均水平</div>");
                        $('#someall1').append("<div style='padding-left:260px;'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;后30%全区平均水平</div>");
                        $('#someall2').append("<div style='padding-left:260px;'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;前30%全区平均水平</div>");

                        $('.aclassgood').html(data.good);
                        $('.aclasslow').html(data.low);
                        $('.bclassgood').html(data.bgood);
                        $('.bclasslow').html(data.blow);
                    }
                }
            })

        });
        $('input[name=know_choclick]').click(function () {
            $('input[name=know_choclick]').removeAttr('checked');
            $(this).attr('checked','checked');
            var title = $(this).attr('title');
            var know_id = "<?php echo $_GET['id']?>";
            var sub = "<?php echo $_GET['subject']?>" ? "<?php echo $_GET['subject']?>" : 'chi';
            var subval = $(this).attr('class');
            var vals = $(this).attr('abc');
            $.ajax({
                url:"http://"+url+"/index.php/Comment/get_knowclick",
                type:'POST',
                data:{know_id:know_id,sub:sub,subval:subval},
                dataType:'json',
                success: function(data){
                    var div =  "<div id="+vals+" style='width:700px;height:390px;border:1px solid #999;padding:20px'></div>";

                    var tr = '';
                    for(var j=0;j<data.arr_name.length;j++) {
                        tr += "<th width='42px' style='border:1px solid #999;text-align:center'>"+data.arr_name[j]+"</th>";
                    };
                    $('.fracmodal').append(div);
                    $('.fracmodal').append("<table><tr><th width='50px' style='border:1px solid #999;text-align:center'></th>"+tr+"</tr>");

                    for (var i=0;i<data.title.length;i++)
                    {
                        var ps = '';
                        var psval = '';
                        ps = "<th width='50px' style='border:1px solid #999;text-align:center'>"+data.title[i]+"</th>";
                        for(var j=0;j<data.arr_name.length;j++)
                        {
                            psval += "<th width='42px' style='border:1px solid #999;text-align:center'>"+data.arr_info[j][i]+"</th>";
                        }
                        $('.fracmodal').append("<table><tr>"+ps+psval+"</table></tr>");
                    }
                    $("#"+vals).highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: title
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                rotation: -45,
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        },
                        yAxis:{
                            title: {
                                text: ''
                            },
                            plotLines: [{ // mark the weekend
                                color: 'red',
                                width: 1,
                                value: data.tips,
                                dashStyle: 'solid',
                                label:{
                                    text:'',     //标签的内容
                                    align:'left',                //标签的水平位置，水平居左,默认是水平居中center
                                    x:-50,
                                    y:3
                                }
                            }]
                        },

                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: 'Population in 2008: <b>{point.y:.1f} millions</b>'
                        },
                        series: [{
                            name: 'Population',
                            data: data.infos,
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                align: 'right',
                                format: '{point.y:.1f}', // one decimal
                                y: 10, // 10 pixels down from the top
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        }]
                    });
                    $("#"+vals).append("<div style='padding-left:280px'><p style='height: 10px;width:25px;border-bottom:2px solid red;float: left'></p>&nbsp;水平线</div>");

                }
            })
        });
        $("#print").click(function () {
            bdhtml=window.document.body.innerHTML;
            sprnstr="<!--startprint-->";
            eprnstr="<!--endprint-->";
            prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17);
            prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));
            window.document.body.innerHTML=prnhtml;
            window.print();
        })

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