<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
        
<title>快捷方法<?php echo (ACTION_NAME); ?></title>
<meta name="keywords" content="" />
<meta name="description" content=""/>

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->
		<link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/Public/bootstrap/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="/Public/bootstrap/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->
		<!--link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" /-->

		<!-- ace styles -->
		<link rel="stylesheet" href="/Public/bootstrap/css/ace.min.css" />
		<link rel="stylesheet" href="/Public/bootstrap/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/Public/bootstrap/css/ace-skins.min.css" />
        
        <link rel="stylesheet" href="/Public/artDialog6/css/ui-dialog.css">

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="/Public/bootstrap/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="/Public/bootstrap/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="/Public/bootstrap/js/html5shiv.js"></script>
		<script src="/Public/bootstrap/js/respond.min.js"></script>
		<![endif]-->
        
        

	</head>

	<body class="navbar-fixed breadcrumbs-fixed">
		<div class="navbar navbar-default navbar-fixed-top" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>
							<?php echo (C("system-title")); ?>
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->
				
                				
                
			</div><!-- /.container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

								
                <div class="sidebar sidebar-fixed" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<button class="btn btn-success" onclick="location.href='/index.php/Admin/Index/action1';">
								<i class="icon-signal"></i>
							</button>

							<button class="btn btn-info" onclick="location.href='/index.php/Admin/Index/action2';">
								<i class="icon-pencil"></i>
							</button>

							<button class="btn btn-warning" onclick="location.href='/index.php/Admin/Index/action3';">
								<i class="icon-group"></i>
							</button>

							<button class="btn btn-danger" onclick="location.href='/index.php/Admin/Index/action4';">
								<i class="icon-cogs"></i>
							</button>
						</div>

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->

					<ul class="nav nav-list">
						<li class="active">
							<a href="/index.php/Admin/Index">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> 控制台 </span>
							</a>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-text-width"></i>
								<span class="menu-text"> 教学内容 </span>
                                
                                <b class="arrow icon-angle-down"></b>
							</a>
                            
                            <ul class="submenu">
								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>
										管理知识点
                                        <b class="arrow icon-angle-down"></b>
									</a>
                                    
                                    <ul class="submenu">
										<li>
											<a href="/index.php/Admin/Edu">
												<i class="icon-leaf"></i>
												教学专区
											</a>
										</li>

										<li>
											<a href="#" class="dropdown-toggle">
												<i class="icon-pencil"></i>

												内容维护
												<b class="arrow icon-angle-down"></b>
											</a>

											<ul class="submenu">

												<li>
													<a href="/index.php/Admin/Question">
														<i class="icon-eye-open"></i>
														管理知识点
													</a>
												</li>
												<li>
													<a href="/index.php/Admin/Question/form">
														<i class="icon-plus"></i>
														添加知识点
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>

								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>
										管理试题
                                        <b class="arrow icon-angle-down"></b>
									</a>
                                    
                                    <ul class="submenu">
										<li>
											<a href="/index.php/Admin/Question">
												<i class="icon-cog"></i>
												教学配置
											</a>
										</li>
										<li>
											<a href="/index.php/Admin/Question/chart">
												<i class="icon-bar-chart"></i>
												统计报表
											</a>
										</li>

										<li>
											<a href="#" class="dropdown-toggle">
												<i class="icon-asterisk"></i>

												客观题
												<b class="arrow icon-angle-down"></b>
											</a>

											<ul class="submenu">

												<li>
													<a href="/index.php/Admin/Question/objective">
														<i class="icon-folder-close-alt"></i>
														管理/查询
													</a>
												</li>
												<li>
													<a href="/index.php/Admin/Question/objective_form">
														<i class="icon-plus"></i>
														添加/试题
													</a>
												</li>
											</ul>
										</li>
                                        
                                        <li>
											<a href="#" class="dropdown-toggle">
												<i class="icon-book"></i>

												资料题
												<b class="arrow icon-angle-down"></b>
											</a>

											<ul class="submenu">

												<li>
													<a href="/index.php/Admin/Question/material">
														<i class="icon-folder-close-alt"></i>
														管理/材料
													</a>
												</li>
                                                <li>
													<a href="/index.php/Admin/Question/objective/serach/1/class/1000">
														<i class="icon-check"></i>
														资料/子题
													</a>
												</li>
												<li>
													<a href="/index.php/Admin/Question/material_form">
														<i class="icon-plus"></i>
														添加/试题
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>

								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>
										管理试卷
                                        <b class="arrow icon-angle-down"></b>
									</a>
                                    
                                    <ul class="submenu">
										<li>
											<a href="/index.php/Admin/Edu">
												<i class="icon-leaf"></i>
												教学专区
											</a>
										</li>

										<li>
											<a href="#" class="dropdown-toggle">
												<i class="icon-pencil"></i>

												内容维护
												<b class="arrow icon-angle-down"></b>
											</a>

											<ul class="submenu">

												<li>
													<a href="#">
														<i class="icon-eye-open"></i>
														管理知识点
													</a>
												</li>
												<li>
													<a href="#">
														<i class="icon-plus"></i>
														添加知识点
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
                             </ul>    
						</li>

						<!--li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-desktop"></i>
								<span class="menu-text"> 内容采集 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="/index.php/Admin/GrabCls">
										<i class="icon-double-angle-right"></i>
										知识分类
									</a>
								</li>

								<li>
									<a href="buttons.html">
										<i class="icon-double-angle-right"></i>
										试卷列表
									</a>
								</li>

								<li>
									<a href="treeview.html">
										<i class="icon-double-angle-right"></i>
										树菜单
									</a>
								</li>

								<li>
									<a href="jquery-ui.html">
										<i class="icon-double-angle-right"></i>
										jQuery UI
									</a>
								</li>

								<li>
									<a href="nestable-list.html">
										<i class="icon-double-angle-right"></i>
										可拖拽列表
									</a>
								</li>

								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>

										三级菜单
										<b class="arrow icon-angle-down"></b>
									</a>

									<ul class="submenu">
										<li>
											<a href="#">
												<i class="icon-leaf"></i>
												第一级
											</a>
										</li>

										<li>
											<a href="#" class="dropdown-toggle">
												<i class="icon-pencil"></i>

												第四级
												<b class="arrow icon-angle-down"></b>
											</a>

											<ul class="submenu">
												<li>
													<a href="#">
														<i class="icon-plus"></i>
														添加产品
													</a>
												</li>

												<li>
													<a href="#">
														<i class="icon-eye-open"></i>
														查看商品
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 表格 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="tables.html">
										<i class="icon-double-angle-right"></i>
										简单 &amp; 动态
									</a>
								</li>

								<li>
									<a href="jqgrid.html">
										<i class="icon-double-angle-right"></i>
										jqGrid plugin
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-edit"></i>
								<span class="menu-text"> 表单 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="form-elements.html">
										<i class="icon-double-angle-right"></i>
										表单组件
									</a>
								</li>

								<li>
									<a href="form-wizard.html">
										<i class="icon-double-angle-right"></i>
										向导提示 &amp; 验证
									</a>
								</li>

								<li>
									<a href="wysiwyg.html">
										<i class="icon-double-angle-right"></i>
										编辑器
									</a>
								</li>

								<li>
									<a href="dropzone.html">
										<i class="icon-double-angle-right"></i>
										文件上传
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="widgets.html">
								<i class="icon-list-alt"></i>
								<span class="menu-text"> 插件 </span>
							</a>
						</li>

						<li>
							<a href="calendar.html">
								<i class="icon-calendar"></i>

								<span class="menu-text">
									日历
									<span class="badge badge-transparent tooltip-error" title="2&nbsp;Important&nbsp;Events">
										<i class="icon-warning-sign red bigger-130"></i>
									</span>
								</span>
							</a>
						</li>

						<li>
							<a href="gallery.html">
								<i class="icon-picture"></i>
								<span class="menu-text"> 相册 </span>
							</a>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-tag"></i>
								<span class="menu-text"> 更多页面 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="profile.html">
										<i class="icon-double-angle-right"></i>
										用户信息
									</a>
								</li>

								<li>
									<a href="inbox.html">
										<i class="icon-double-angle-right"></i>
										收件箱
									</a>
								</li>

								<li>
									<a href="pricing.html">
										<i class="icon-double-angle-right"></i>
										售价单
									</a>
								</li>

								<li>
									<a href="invoice.html">
										<i class="icon-double-angle-right"></i>
										购物车
									</a>
								</li>

								<li>
									<a href="timeline.html">
										<i class="icon-double-angle-right"></i>
										时间轴
									</a>
								</li>

								<li>
									<a href="login.html">
										<i class="icon-double-angle-right"></i>
										登录 &amp; 注册
									</a>
								</li>
							</ul>
						</li>

						<li class="active open">
							<a href="#" class="dropdown-toggle">
								<i class="icon-file-alt"></i>

								<span class="menu-text">
									其他页面
									<span class="badge badge-primary ">5</span>
								</span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="faq.html">
										<i class="icon-double-angle-right"></i>
										帮助
									</a>
								</li>

								<li>
									<a href="error-404.html">
										<i class="icon-double-angle-right"></i>
										404错误页面
									</a>
								</li>

								<li>
									<a href="error-500.html">
										<i class="icon-double-angle-right"></i>
										500错误页面
									</a>
								</li>

								<li>
									<a href="grid.html">
										<i class="icon-double-angle-right"></i>
										网格
									</a>
								</li>

								<li class="active">
									<a href="blank.html">
										<i class="icon-double-angle-right"></i>
										空白页面
									</a>
								</li>
							</ul>
						</li-->
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>
                

				<div class="main-content">
					<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="javascript:void(0);">控制台</a>
							</li>
                            
							
<li class="active"><?php echo (ACTION_NAME); ?></li>

						</ul><!-- .breadcrumb -->

												
					</div>

					<div class="page-content">
                    	
    <div class="row">
    	<div class="col-xs-12" style="height:600px;">/index.php/Admin/Index/action4</div>
    	<!-- /.col -->
    </div><!-- /.row -->

					</div><!-- /.page-content -->
				</div><!-- /.main-content -->

								
                
			</div><!-- /.main-container-inner -->

			<a href="javascript:void(0);" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script-->
		<!-- <![endif]-->

		<!--[if IE]>
        <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script-->
        <![endif]-->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='/Public/bootstrap/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
		<!-- <![endif]-->

		<!--[if IE]>
        <script type="text/javascript">
         window.jQuery || document.write("<script src='/Public/bootstrap/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>
        <![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/Public/bootstrap/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="/Public/bootstrap/js/bootstrap.min.js"></script>
		<script src="/Public/bootstrap/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="/Public/artDialog6/dist/dialog-min.js"></script>

		<!-- ace scripts -->
		<script src="/Public/bootstrap/js/ace-elements.min.js"></script>
		<script src="/Public/bootstrap/js/ace.min.js"></script>
        
        <!-- common functions -->
        <script src="/Public/js/common.js"></script>
        
        <script language="javascript">
        
/**
 * 全局公用 请求函数
 *
 * @param  string    action    请求地址
 * @param  string    data      发送的数据
 * @param  function  success   成功,回调函数
 * @param  function  success   失败,回调函数
 * @param  json      params    更多配置参数 
 */
function ajaxSend(action, data, success, error, params){
	
	var config = {url: action, dataType:'json',type: "POST",data:data,success:success,error:error,cache:false};
	for(var x in params){config[x] = param[x];}
	$.ajax(config);
}
        
        </script>
        



</body>
</html>