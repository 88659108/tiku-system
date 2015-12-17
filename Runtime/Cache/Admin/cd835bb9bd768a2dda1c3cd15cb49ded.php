<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
        
<title>知识点管理</title>
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
                            
							
<li class="active">教学专区</li>

						</ul><!-- .breadcrumb -->

												
					</div>

					<div class="page-content">
                    	
    <div class="row">
    	<div class="col-xs-12">
        
        
<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<div class="lighter row">
                                                	<div class="col-sm-2">
                                                    <select class="form-control js-select-block" data-placeholder="选择一个父级知识点...">
																<option value="0">一级根知识点</option>
																<?php if(is_array($form_list)): $i = 0; $__LIST__ = $form_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cls): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cls["id"]); ?>"><?php echo ($cls["title"]); ?></option>
                                                                    <?php if(is_array($cls['list'])): $i = 0; $__LIST__ = $cls['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clss): $mod = ($i % 2 );++$i;?><option value="<?php echo ($clss["id"]); ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($clss["title"]); ?></option>
                                                                		<?php if(is_array($clss['list'])): $i = 0; $__LIST__ = $clss['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clsss): $mod = ($i % 2 );++$i;?><option value="<?php echo ($clsss["id"]); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($clsss["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
															</select>

                                                    
                                                    </div>
                                                    <div class="input-group col-sm-8">
																	<input type="text" data-rel="tooltip" data-placement="top" class="form-control js-search-query tooltip-error" placeholder=" 知识点,知识点,知识点名称" data-original-title="空格 或 ','号 隔开可以添加多个">
																	<span class="input-group-btn">
																		<button type="button" class="btn btn-danger btn-sm js-btn-insert-block">
																			添加知识点
																			<i class="icon-gift icon-on-right bigger-110"></i>
																		</button>
                                                                        <button class="btn btn-success btn-sm js-btn-list-class" type="button">
																			批量更新类别
																			<i class="icon-bell-alt icon-on-right bigger-110"></i>
																		</button>
                                                                        <button class="btn btn-purple btn-sm js-btn-list-rank" type="button">
																			批量更新排序
																			<i class="icon-bell-alt icon-on-right bigger-110"></i>
																		</button>
                                                                        <button class="btn btn-grey btn-sm js-btn-list-delete" type="button">
																			批量删除类别
																			<i class="icon-bell-alt icon-on-right bigger-110"></i>
																		</button>
                                                                        <button class="btn btn-primary btn-sm js-btn-info-block" style="display:none;" type="button">
																			<span>更新《....》</span>
																			<i class="icon-bell-alt icon-on-right bigger-110"></i>
																		</button>
																	</span>
																</div>
                                                                
                                                                <div class="col-sm-2 js-msg-box"></div>
                                                    
                                                    
												</div>
                                                
											</div></div>  
        
        
        
        
        
        
        
   
<?php if(is_array($cls_list)): $i = 0; $__LIST__ = $cls_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cls): $mod = ($i % 2 );++$i;?><br /> 
<div class="widget-box transparent js-class-row-box" dataid="<?php echo ($cls["id"]); ?>">
											<div class="widget-header widget-header-flat">
												<h2 class="lighter">
													<i class="icon-gift primary"></i> <span class="js-class-block-<?php echo ($cls["id"]); ?>"><?php echo ($cls["id"]); ?> <?php echo ($cls["title"]); ?>(<?php echo (get_question_count($cls["id"],1)); ?>)</span>
												</h2>

												<div class="widget-toolbar">
													<a href="#!" data-action="collapse">
														<i class="icon-chevron-up"></i>
													</a>
												</div>
                                                
                                                
<div class="widget-toolbar no-border">
<div class="action-buttons" style="display:none;">
                                                                        
																		<a href="#" class="blue">
																			<i class="icon-pencil bigger-130 js-btn-class-edit" dataid="<?php echo ($cls["id"]); ?>" topid="<?php echo ($cls["topid"]); ?>"></i>
																		</a>

																		<span class="vbar"></span>

																		<a href="#!" class="red js-btn-class-max-delete" dataid="<?php echo ($cls["id"]); ?>">
																			<i class="icon-trash bigger-130"></i>
																		</a>

																		<span class="vbar"></span>

																		<a href="#!" class="green">
																			<i class="icon-flag bigger-130"></i>
																		</a>
</div>
</div>  
                                                
                                                
                                                
											</div>

											<div class="widget-body">
                                            <div class="widget-body-inner" style="display: block;">
												<div class="widget-main no-padding">
													
                                                    
                                                    
                                                    
<?php if(is_array($cls['list'])): $i = 0; $__LIST__ = $cls['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clss): $mod = ($i % 2 );++$i;?><br /> 
<div class="widget-box transparent collapsed js-class-row-box" dataid="<?php echo ($clss["id"]); ?>">   
<div class="widget-header widget-header-flat">
												<h3 class="lighter text-danger">
													<i class="icon-bell-alt orange"></i> <span class="js-class-block-<?php echo ($clss["id"]); ?>"><?php echo ($clss["id"]); ?> <?php echo ($clss["title"]); ?>(<?php echo (get_question_count($clss["id"],2)); ?>)</span>
												</h3>
                                                <div class="widget-toolbar">
                                                	<a href="#!" data-action="collapse">
                                                		<i class="icon-chevron-down"></i>
                                               		</a>
												</div>
<div class="widget-toolbar no-border">
<div class="action-buttons" style="display:none;">
                                                                        
																		<a href="#" class="blue">
																			<i class="icon-pencil bigger-130 js-btn-class-edit" dataid="<?php echo ($clss["id"]); ?>" topid="<?php echo ($clss["topid"]); ?>"></i>
																		</a>

																		<span class="vbar"></span>

																		<a href="#!" class="red js-btn-class-max-delete" dataid="<?php echo ($clss["id"]); ?>">
																			<i class="icon-trash bigger-130"></i>
																		</a>

																		<span class="vbar"></span>

																		<a href="#!" class="green">
																			<i class="icon-flag bigger-130"></i>
																		</a>
</div>
</div>
                                                    
                                                    
												
											</div>
<div class="widget-body">
                                            <div class="widget-body-inner" style="display: none;">
												<div class="widget-main no-padding">                                         
<table class="table table-striped table-hover table-bordered">
	<thead>
													<tr>
														<th class="center" style="width:40px;">
															<label>
																<input type="checkbox" class="ace js-checkbox-all">
																<span class="lbl"></span>
															</label>
														</th>
														<th style="width:240px;" class="text-danger">
                                                        名称</th>
                                                        <th class="text-danger">
														教学课件
                                                        </th>
														<th class="text-danger">示例试题</th>
														<th class="text-danger">课后作业</th>
														<th class="text-danger">评测卷</th>
														<th class="text-danger">试题咨询</th>
														<th class="text-danger">错题讨论区</th>
														<th class="text-danger">智能分析</th>
														<th class="text-danger" style="width:60px;">开关</th>
														<th class="text-danger" style="width:100px;">Action</th>
                                                        <th class="text-danger" style="width:70px;">
                                                        排序</th>
													</tr>
												</thead>											

												<tbody>
                                                <?php if(is_array($clss['list'])): $i = 0; $__LIST__ = $clss['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clsss): $mod = ($i % 2 );++$i;?><tr class="js-class-row-box" dataid="<?php echo ($clsss["id"]); ?>">
														<td class="center">
															<label>
																<input type="checkbox" class="ace js-checkbox-li" dataid="<?php echo ($clsss["id"]); ?>">
																<span class="lbl"></span>
															</label>
														</td>

														<td><h4 class="js-class-block-<?php echo ($clsss["id"]); ?>"><?php echo ($clsss["id"]); ?> <?php echo ($clsss["title"]); ?>(<?php echo (get_question_count($clsss["id"],3)); ?>)</h4></td>
                                          
														<td><button class="btn btn-app radius-5 btn-sm"><i class="icon-desktop"></i></button></td>
														<td><button class="btn btn-app radius-5 btn-sm"><i class="icon-leaf"></i><span class="badge badge-success">+3</span></button></td>
														<td><button class="btn btn-success btn-app radius-5 btn-sm"><i class="icon-book"></i><span class="badge badge-success">+3</span></button></td>

														<td><button class="btn btn btn-success btn-app radius-5 btn-sm"><i class="icon-list"></i><span class="badge badge-success">+3</span></button></td>
														<td><button class="btn btn-pink btn-app radius-5 btn-sm"><i class="icon-group"></i><span class="badge badge-warning">+3</span></button></td>
                                                        <td><button class="btn btn-pink btn-app radius-5 btn-sm"><i class="icon-comments"></i><span class="badge badge-warning">+3</span></button></td>
                                                        <td><button class="btn btn-info btn-app radius-5 btn-sm"><i class="icon-bar-chart"></i></button></td>
                                                        <td><br />
                                                        <label>
                                                            <input <?php if(($clsss["status"]) == "1"): ?>checked="checked"<?php endif; ?> dataid="<?php echo ($clsss["id"]); ?>" class="ace ace-switch js-btn-class-switch" type="checkbox" />
                                                            <span class="lbl"></span>
                                                        </label>
                                                        </td>
														<td><br />
                                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-info tooltip-info js-btn-class-refresh" data-rel="tooltip" title="" data-original-title="更新">
																	<i class="icon-refresh bigger-120"></i>
																</button>
                                                                
                                                               
																
															</div>

															<div class="visible-xs visible-sm hidden-md">
																<div class="inline position-relative">
																	<button class="btn btn-minier dropdown-toggle" data-toggle="dropdown">
																		<i class="icon-cog bigger-110"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                                    <li>
																			<a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="修改">
                                                                            	
																				<span class="text-success js-btn-class-edit" dataid="<?php echo ($clsss["id"]); ?>" topid="<?php echo ($clsss["topid"]); ?>">
																					<i class="icon-edit bigger-120"></i>
                                                                                    修改
																				</span>
																			</a>
																		</li>
																		<li>
																			<a href="#!" dataid="<?php echo ($clsss["id"]); ?>" class="tooltip-error js-btn-class-delete" data-rel="tooltip" title="" data-original-title="彻底删除">
                                                                            	
																				<span class="red">
																					<i class="icon-trash bigger-120"></i>
                                                                                    删除
																				</span>
																			</a>
																		</li>
																	</ul>
																</div>
															</div>
														</td>
														<td><br />
														<input type="text" value="<?php echo ($clsss["rank"]); ?>" class="input-mini cls-spinner" dataid="<?php echo ($clsss["id"]); ?>" />
 														</td>  
													</tr>
                                                    
                                                    <tr>
                                                    <td></td>
                                                    <td align="right"><h4>》 考点标签：</h4></td>
                                                    <td colspan="10"> 
                                                    <?php if(is_array($clsss['list'])): foreach($clsss['list'] as $key=>$clssss): ?><label><input type="checkbox"><?php echo ($clssss["id"]); ?> <?php echo ($clssss["title"]); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;<?php endforeach; endif; ?>
                                                    </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td colspan="12"></td>
                                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
													

												</tbody>
											</table>   
</div>   </div></div></div><?php endforeach; endif; else: echo "" ;endif; ?>     
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
												</div><!-- /widget-main -->
											</div></div><!-- /widget-body -->
										</div> <br /><?php endforeach; endif; else: echo "" ;endif; ?>
        
        
        
        
        
        
        
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        </div>
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
        
<script type="text/javascript" src="/Public/bootstrap/js/fuelux/fuelux.spinner.min.js"></script>



<script language="javascript">


$('.cls-spinner').ace_spinner({value:0,min:0,step:1, btn_up_class:'btn-info', btn_down_class:'btn-info'})
				.on('change', function(){
					var dataid	= $(this).attr('dataid');
					var obj	= $(".js-btn-class-switch[dataid='"+dataid+"']");
						obj.attr('rank', this.value);
				});

$('[data-rel=tooltip]').tooltip();

				
				
$('.widget-header').hover(

	function(){
		$(this).find('.action-buttons').show();
	}, 
	function(){
		$(this).find('.action-buttons').hide();
});				



//添加知识点
$('.js-btn-insert-block').click(function(){
	
	var block	= $('.js-select-block');
	var topid	= block.find('option:selected').val();
	
	var input	= $('.js-search-query');
	var text	= input.val();
	
	var msgobj	= $('.js-msg-box');
	var btn		= $(this);
		btn.addClass('disabled');
		msgobj.html('<i class="icon-spinner icon-spin orange bigger-125"></i> <span class="text-muted"> 正在努力保存中..</span>');
	$.ajax({
		url:'Edu/insertblock',
		type:'POST',
		data:'topid=' + topid + '&text=' + text,
		dataType:'json',
		success:function(json){
			btn.removeClass('disabled');
			
			if(json.status == 1){
				input.val('');
				msgobj.html('<i class="icon-ok bigger-110 green"></i> <span class="text-success"> 成功添加知识点..</span>');
				return;	
			}
			
			msgobj.show();
			setTimeout(function(){ msgobj.hide(); }, 3000);
			if(json.status == -1){
				msgobj.html('<i class="icon-warning-sign orange bigger-125"></i> <span class="text-warning"> '+ json.msg +'</span>');
				return;	
			}
			
			msgobj.html('<i class="icon-warning-sign orange bigger-125"></i> <span class="text-warning"> 喵了个咪,发生错误..</span>');
		}
	});
	
});

//编辑单个知识点
$('.js-btn-info-block').click(function(){
	
	var dataid	= $(this).attr('dataid');
	if(!dataid) return false;	
	
	var block	= $('.js-select-block');
	var topid	= block.find('option:selected').val();
	
	var input	= $('.js-search-query');
	var text	= input.val();
	
	var msgobj	= $('.js-msg-box');
	var btn		= $(this);
		btn.addClass('disabled');
		msgobj.html('<i class="icon-spinner icon-spin orange bigger-125"></i> <span class="text-muted"> 正在努力更新中..</span>');
		
	$.ajax({
		url:'Edu/updateblock',
		type:'POST',
		data:'topid=' + topid + '&text=' + text + '&dataid=' + dataid,
		dataType:'json',
		success:function(json){
			
			if(json.status == 1){
				input.val('');
				setTimeout(function(){ btn.hide(); }, 3000);
				$('.js-class-block-' + dataid).text(text);
				msgobj.html('<i class="icon-ok bigger-110 green"></i> <span class="text-success"> 成功更新知识点《'+text+'》..</span>');
				return;	
			}
			
			btn.removeClass('disabled');
			msgobj.show();
			setTimeout(function(){ msgobj.hide(); }, 3000);
			if(json.status == -1){
				msgobj.html('<i class="icon-warning-sign orange bigger-125"></i> <span class="text-warning"> '+ json.msg +'</span>');
				return;	
			}
			
			msgobj.html('<i class="icon-warning-sign orange bigger-125"></i> <span class="text-warning"> 喵了个咪,发生错误..</span>');
		}
	});	
});


//将知识点设置到编辑状态
$('.js-btn-class-edit').click(function(){
	
	var dataid	= $(this).attr('dataid');
	var topid	= $(this).attr('topid');
	
	var block	= $('.js-select-block');
		block.val(topid);
	
	var text	= $('.js-class-block-' + dataid).text();
	var input	= $('.js-search-query');
		input.val(text);
		
	var btn		= $('.js-btn-info-block');
		btn.find('span').html('更新《'+text+'》');
		btn.attr('dataid', dataid).show();	
		
});


//批量更新排序
$('.js-btn-list-rank').click(function(){
	
	var list	= $('.js-btn-class-switch[rank]');
	if(list.size() == 0){
		var msgobj	= $('.js-msg-box');
			msgobj.show();
		setTimeout(function(){ msgobj.hide(); }, 3000);
		msgobj.html('<i class="icon-warning-sign orange bigger-125"></i> <span class="text-warning"> 排序不需要更新..</span>');
	}
	
	//批量排序
	list.each(function(index, element) {
        var dataid	= $(this).attr('dataid');
		var rank	= $(this).attr('rank');
		var status	= ($(this).prop("checked")) ? 1 : 0;
		
		var btnobj	= $(this);
		$.ajax({
		url:'Edu/updateblocks',
		type:'POST',
		data:'status=' + status + '&rank=' + rank + '&dataid=' + dataid + '&mode=rank',
		dataType:'json',
		success:function(json){
			
			var obj = $('.js-class-block-' + dataid).parent('td');
			setTimeout(function(){ obj.find('.js-class-msg').remove();  }, 3000);
			
			if(json.status == 1){
				btnobj.removeAttr('rank');
				obj.append('<span class="js-class-msg"><i class="icon-ok bigger-110 green"></i></span>');
				return;
			}
			
			if(json.status == -1){
				obj.append('<span class="js-class-msg"><i class="text-warning bigger-110 orange"></i></span>');
				return;
			}
			
			obj.append('<span class="js-class-msg"><i class="icon-remove bigger-110 red"></i></span>');
		}});
    });
	
});


//批量更新分类
$('.js-btn-list-class').click(function(){
	
	//批量转分类
	var list	= $('.js-checkbox-li:checked');
	if(list.size() == 0){
		var msgobj	= $('.js-msg-box');
			msgobj.show();
		setTimeout(function(){ msgobj.hide(); }, 3000);
		msgobj.html('<i class="icon-warning-sign orange bigger-125"></i> <span class="text-warning"> 没有选择知识点..</span>');
	}
	
	var block	= $('.js-select-block');
	var topid	= block.find('option:selected').val();
	list.each(function(index, element) {
        var dataid	= $(this).attr('dataid');
		
		var btnobj	= $(this);
		$.ajax({
		url:'Edu/updateblocks',
		type:'POST',
		data:'topid=' + topid + '&dataid=' + dataid + '&mode=class',
		dataType:'json',
		success:function(json){
			
			var obj = $('.js-class-block-' + dataid).parent('td');
			setTimeout(function(){ obj.find('.js-class-msg').empty();  }, 3000);
			
			if(json.status == 1){
				btnobj.prop('checked', false);
				obj.append('<span class="js-class-msg"><i class="icon-circle green"></i></span>');
				return;
			}
			
			if(json.status == -1){
				obj.append('<span class="js-class-msg"><i class="text-warning bigger-110 orange"></i></span>');
				return;
			}
			
			obj.append('<span class="js-class-msg"><i class="icon-remove bigger-110 red"></i></span>');
			
		}});
    });	
	
});


//批量删除分类
$('.js-btn-list-delete').click(function(){
	
	var msgobj	= $('.js-msg-box');
	var list	= $('.js-checkbox-li:checked');
	if(list.size() == 0){
		msgobj.show();
		setTimeout(function(){ msgobj.hide(); }, 3000);
		msgobj.html('<i class="icon-warning-sign orange bigger-125"></i> <span class="text-warning"> 没有选择知识点..</span>');
	}
	
	var ids	= [];
	list.each(function(index, element) {
        ids.push($(this).attr('dataid'));
	});
	
	delete_all_blocks(ids);
});


//根据数组ids删除知识点
function delete_all_blocks(ids){

	var msgobj	= $('.js-msg-box');
	$.ajax({
		url:'Edu/deleteblocks',
		type:'POST',
		data:'ids=' + ids.join(','),
		dataType:'json',
		success:function(json){
			
			msgobj.show();
			setTimeout(function(){ msgobj.hide(); }, 3000);
			
			if(json.status == 1){
				
				//删除节点
				for(var i = 0 in ids){
					$('.js-class-row-box[dataid='+ids[i]+']').remove();
				}
				
				msgobj.html('<i class="icon-ok bigger-110 green"></i> <span class="text-success"> 成功删除知识点..</span>');
				return;
			}
			
			if(json.status == -1){
				msgobj.html('<i class="icon-warning-sign orange bigger-125"></i> <span class="text-warning"> 没有选择知识点..</span>');
				return;
			}
			
			msgobj.html('<i class="icon-warning-sign orange bigger-125"></i> <span class="text-warning"> 喵了个咪,发生错误..</span>');
			
	}});
}

//删除单个知识点
$('.js-btn-class-delete').click(function(){
	
	var dataid	= $(this).attr('dataid');
	$('.js-checkbox-li[dataid='+dataid+']').prop('checked', true);
	$('.js-btn-list-delete').click();
});


$('.js-btn-class-refresh').click(function(){
	$('.js-btn-list-rank').click();
});


//删除一级,二级知识点
$('.js-btn-class-max-delete').click(function(){
	
	var dataid	= $(this).attr('dataid');
	var box		= $(this).parents('.js-class-row-box[dataid='+dataid+']');
	var list	= box.find('.js-class-row-box');
	if(list.size() > 0){
		alert('该知识点存在下级,不能删除..');
		return;	
	}
	
	//执行删除
	delete_all_blocks(Array(dataid));
});


//分组选中
$('.js-checkbox-all').click(function(){
	
	var box	= $(this).parents('.table');
		box.find('.js-checkbox-li').prop('checked', function( i, val) { return !val; });
	
});

//设置状态
$('.js-btn-class-switch').click(function(){
	
	var dataid	= $(this).attr('dataid');
	var rank	= $('.cls-spinner[dataid='+dataid+']').val();
	
	$(this).attr('rank', rank);
	$('.js-btn-list-rank').click();
});
</script>


</body>
</html>