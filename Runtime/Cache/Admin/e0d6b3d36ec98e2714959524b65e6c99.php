<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
        
  <title>试题管理</title>
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
                            
							
<li>教学内容</li>
<li class="active">资料题</li>

						</ul><!-- .breadcrumb -->

												
					</div>

					<div class="page-content">
                    	
  <div class="row">
    <div class="col-xs-12">
      <div class="lighter row">
        <form action="/index.php/Admin/Question/material" method="get">
          <input type="hidden" name="serach" value="1" />
          <div class="col-sm-2">
            <div class="lighter row">
              <div class="input-group col-sm-1">
                <select name="class" style="width:160px;" class="form-control js-select-block" data-placeholder="选择一个知识点...">
                  <option value="" style="font-weight:bold; color:#999;">查询所有知识点</option>
                  <?php if(is_array($form_list)): $i = 0; $__LIST__ = $form_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cls): $mod = ($i % 2 );++$i;?><option 
                    <?php if($bigtype == $cls[id]){ echo 'selected="selected"'; } ?>
                     value="<?php echo ($cls["id"]); ?>" style="font-weight:bold; color:#F00;">-<?php echo ($cls["title"]); ?>
                    
                    </option>
                    <?php if(is_array($cls['list'])): $i = 0; $__LIST__ = $cls['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clss): $mod = ($i % 2 );++$i;?><option 
                      <?php if($smalltype == $clss[id]){ echo 'selected="selected"'; } ?>
                      
                       value="<?php echo ($cls["id"]); ?>,<?php echo ($clss["id"]); ?>" style="font-weight:bold; color:#966;">---<?php echo ($clss["title"]); ?>
                      
                      </option>
                      <?php if(is_array($clss['list'])): $i = 0; $__LIST__ = $clss['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clsss): $mod = ($i % 2 );++$i;?><option 
                        
                        <?php if($pointtype == $clsss[id]){ echo 'selected="selected"'; } ?>
                        
                         value="<?php echo ($cls["id"]); ?>,<?php echo ($clss["id"]); ?>,<?php echo ($clsss["id"]); ?>">------<?php echo ($clsss["title"]); ?>
                        
                        </option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                </select>
              </div>
              <div class="col-sm-1">
                <select style="width:80px;" class="form-control" name="field">
                  <option <?php if(($field) == "material"): ?>selected="selected"<?php endif; ?> value="body">材料</option>
                  <option <?php if(($field) == "id"): ?>selected="selected"<?php endif; ?> value="id">ID</option>
                  <option <?php if(($field) == "qyear"): ?>selected="selected"<?php endif; ?> value="qyear">年份</option>
                  <option <?php if(($field) == "status"): ?>selected="selected"<?php endif; ?> value="status">状态</option>
                  <option <?php if(($field) == "ismock"): ?>selected="selected"<?php endif; ?> value="ismock">题类别</option>
                  <option <?php if(($field) == "diff"): ?>selected="selected"<?php endif; ?> value="diff">难度</option>
                  <option <?php if(($field) == "chance"): ?>selected="selected"<?php endif; ?> value="chance">考频</option>
                  <option <?php if(($field) == "qnums"): ?>selected="selected"<?php endif; ?> value="qnums">子题数</option>
                </select>
              </div>
            </div>
          </div>
          <div class="input-group col-sm-6">
            <input type="text" class="form-control" name="keyword" placeholder="请输入 '材料' 进行模糊查询" value="<?php echo ($_GET['keyword']); ?>">
            <span class="input-group-btn">
            <button type="submit" class="btn btn-danger btn-sm"> 搜索试题 <i class=" icon-leaf icon-on-right bigger-110"></i> </button>
            </span> </div>
          <div class="col-sm-2 js-msg-box"></div>
        </form>
      </div>
      <hr>
      <div class="row">
        <div class="btn-group pull-right"><?php echo ($pagenav); ?></div>
      </div>
      <hr>
      <table class="table table-striped table-hover table-bordered">
        <thead>
          <tr>
            <th class="center" style="width:30px;"> <label>
                <input type="checkbox" class="ace js-all-checkbox">
                <span class="lbl"></span> </label>
            </th>
            <th style="width:60px;">编号</th>
            <th>题目</th>
            <th style="width:50px;">子题</th>
            <th style="width:340px;">考点定位</th>
            <th style="width:60px;">题类</th>
            <th style="width:80px;">年份 <i class="icon-time bigger-110 hidden-480"></i></th>
            <th style="width:80px;">难度/考频</th>
            <th style="width:80px;">状态</th>
            <th style="width:200px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qt): $mod = ($i % 2 );++$i;?><tr class="js-tr-li-box" dataid="<?php echo ($qt["id"]); ?>">
              <td class="center"><label>
                  <input type="checkbox" class="ace js-tr-checkbox" value="<?php echo ($qt["id"]); ?>">
                  <span class="lbl"></span> </label></td>
              <td><?php echo ($qt["id"]); ?></td>
              <td><div class="slim-scroll" data-height="100" style="overflow: hidden; width: auto;"><?php echo ($qt["material"]); ?></div>
                <?php if($qt["material_desc"] != ''): ?><i class="icon-camera"></i><?php endif; ?></td>
              <td><span class="label label-success arrowed-in-right"><?php echo ($qt["qnums"]); ?></span></td>
              <td><span class="label label-xlg label-grey arrowed arrowed-right"><?php echo (get_question_class_cols($qt["bigtype"])); ?></span><span class="label label-xlg label-light arrowed-in-right arrowed-in"><?php echo (get_question_class_cols($qt["smalltype"])); ?></span><span class="label label-xlg label-light arrowed-in-right arrowed"><abbr title="Phone"><?php echo (get_question_class_cols($qt["pointtype"])); ?></abbr></span></td>
              <td><?php if($qt["ismock"] == 1 ): ?><span class="label arrowed">真题</span>
                  <?php else: ?>
                  <span class="label label-danger arrowed">模拟</span><?php endif; ?></td>
              <td><span class="label arrowed"><?php echo ($qt["qyear"]); ?></span></td>
              <td><input type="text" value="<?php echo ($qt["diff"]); ?>" class="input-mini cls-spinner js-filed-diff" />
                <input type="text" value="<?php echo ($qt["chance"]); ?>" class="input-mini cls-spinner js-filed-chance" /></td>
              <td class="hidden-480"><label> <input 
                  
                  <?php if(($qt["status"]) == "1"): ?>checked="checked"<?php endif; ?>
                  class="ace ace-switch js-filed-status" type="checkbox" /><span class="lbl"></span> </label></td>
              <td><div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                  <button class="btn btn-xs btn-success js-btn-row-refresh"> <i class="icon-refresh bigger-120"></i> </button>
                  <a href="/index.php/Admin/Question/material_form?id=<?php echo ($qt["id"]); ?>" target="_blank" class="btn btn-xs btn-info"> <i class="icon-edit bigger-120"></i> </a>
                  <a href="/index.php/Admin/Question/objective_form" target="_blank" class="btn btn-xs btn-danger"> <i class="icon-comments-alt bigger-120"></i> </a>
                  <button class="btn btn-xs btn-warning"> <i class="icon-bar-chart bigger-120"></i> </button>
                </div>
                <div class="visible-xs visible-sm hidden-md">
                  <div class="inline position-relative">
                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="icon-cog icon-only bigger-110"></i> </button>
                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                      <li> <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View"> <span class="blue"> <i class="icon-zoom-in bigger-120"></i> </span> </a> </li>
                      <li> <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit"> <span class="green"> <i class="icon-edit bigger-120"></i> </span> </a> </li>
                      <li> <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete"> <span class="red"> <i class="icon-trash bigger-120"></i> </span> </a> </li>
                    </ul>
                  </div>
                </div></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        <tr>
          <th class="center" style="width:30px;"> <label>
              <input type="checkbox" class="ace js-all-checkbox">
              <span class="lbl"></span> </label>
          </th>
          <th style="width:60px;">批量<br />操作</th>
          <th> <select name="class" style="width:150px;" class="form-control js-all-execute col-xs-12 col-lg-6">
              <option value="">选择一个操作</option>
              <option value="class" data-filed="class">设置知识点分类</option>
              <option value="switch" data-filed="status" data-obj="switch" data-input="checkbox">设置状态</option>
              <option value="spinner" data-filed="diff" data-obj="spinner">设置难度</option>
              <option value="spinner" data-filed="chance" data-obj="spinner">设置考频</option>
              <option value="qyear" data-filed="qyear">设置年份</option>
              <option value="ismock" data-filed="ismock">设置题类</option>
              <option value="delete" data-filed="delete">设置删除</option>
            </select>
           
            <select name="class" style="width:160px; display:none;" class="form-control js-all-exe-box js-all-exe-class" data-placeholder="选择一个知识点...">
              <option value="" style="font-weight:bold; color:#999;">选择一个知识点</option>
              <?php if(is_array($form_list)): $i = 0; $__LIST__ = $form_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cls): $mod = ($i % 2 );++$i;?><option 
                
                <?php if(($bigtype) == "cls.id"): ?>selected="selected"<?php endif; ?>
                
                 value="<?php echo ($cls["id"]); ?>" style="font-weight:bold; color:#F00;">-<?php echo ($cls["title"]); ?>
                
                </option>
                <?php if(is_array($cls['list'])): $i = 0; $__LIST__ = $cls['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clss): $mod = ($i % 2 );++$i;?><option 
                  
                  <?php if(($smalltype) == "clss.id"): ?>selected="selected"<?php endif; ?>
                  
                   value="<?php echo ($cls["id"]); ?>,<?php echo ($clss["id"]); ?>" style="font-weight:bold; color:#966;">---<?php echo ($clss["title"]); ?>
                  
                  </option>
                  <?php if(is_array($clss['list'])): $i = 0; $__LIST__ = $clss['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clsss): $mod = ($i % 2 );++$i;?><option 
                    
                    <?php if(($pointtype) == "clsss.id"): ?>selected="selected"<?php endif; ?>
                    
                     value="<?php echo ($cls["id"]); ?>,<?php echo ($clss["id"]); ?>,<?php echo ($clsss["id"]); ?>">------<?php echo ($clsss["title"]); ?>
                    
                    </option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            </select>
            
            <input type="text" style="display:none;" class="col-xs-3 js-all-exe-box js-all-exe-qyear" name="qyear" placeholder="如： 2013,2014">
            
            <select class="js-all-exe-box js-all-exe-ismock" style="width:120px; display:none;">
              <option value="">选择试题类别</option>
              <option value="1">真题</option>
              <option value="0">模拟</option>
            </select>
            
            <label style="display:none;" class="js-all-exe-box js-all-exe-spinner"><input type="text" class="input-mini cls-spinner js-all-data-spinner"  /></label>
            
            <label style="display:none;" class="js-all-exe-box js-all-exe-switch"><input class="ace ace-switch js-all-data-switch" type="checkbox" /><span class="lbl"></span> </label>
             
            <br /><br />
            <button style="display:none;" class="btn btn-danger js-all-exe-box js-all-exe-submit">执行操作</button>
            
            <span class="js-all-exe-loading" style="display:none;"><i class="icon-spinner icon-spin orange bigger-125"></i> <span class="js-text">正在努力加载...</span></span>
            
          </th>
          <th style="width:50px;">答案</th>
          <th style="width:340px;">考点定位</th>
          <th style="width:60px;">题类</th>
          <th style="width:80px;">年份 <i class="icon-time bigger-110 hidden-480"></i></th>
          <th style="width:80px;">难度</th>
          <th style="width:80px;">状态</th>
          <th style="width:200px;">Action</th>
        </tr>
      </table>
      <div class="row">
        <div class="btn-group pull-right"><?php echo ($pagenav); ?></div>
      </div>
      <hr />
    </div>
    <!-- /.col --> 
  </div>
  <!-- /.row --> 
  

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
  <script type="text/javascript" src="/Public/bootstrap/js/jquery.slimscroll.min.js"></script>

  <script language="javascript">

$('.cls-spinner').ace_spinner({value:0,min:0,step:1, btn_up_class:'btn-info', btn_down_class:'btn-info'})
.on('change', function(){
					
});

$('[data-rel=tooltip]').tooltip();

// scrollables
$('.slim-scroll').each(function () {
	var $this = $(this);
	$this.slimScroll({
		height: $this.data('height') || 100,
		railVisible:true
	});
});



//更新按钮
$('.js-btn-row-refresh').click(function(){
	
	var tr		= $(this).parents('.js-tr-li-box');
	var dataid	= tr.attr('dataid');
	var diff	= tr.find('.js-filed-diff').val();
	var chance	= tr.find('.js-filed-chance').val();
	var status	= (tr.find('.js-filed-status').prop("checked")) ? 1 : 0;
	
	var data	= 'diff='+diff+'&status='+status+'&chance=' + chance+'&id=' + dataid + '&module=question_material';
	ajaxSend('/index.php/Admin/Question/question_update_filed', data, function(json){
		
		
		
	}, function(err){});
});


//全选
$('.js-all-checkbox').click(function(){
	
	var check	= $(this).prop('checked');
	var box	= $(this).parents('.table');
		box.find('.js-tr-checkbox').prop('checked', check);
	
	$('.js-all-checkbox').prop('checked', check);
});

//选择一个操作
$('.js-all-execute').change(function(){
	
	//获得一个操作
	var obj		= $(this).val();
	
	//显示相应的操作控件
	$('.js-all-exe-box').hide();
	
	if(!obj) return false;
	$('.js-all-exe-' + obj).show();
	
	//显示执行按钮
	$('.js-all-exe-submit').fadeIn('slow');
});

//执行批量操作
$('.js-all-exe-submit').click(function(){

	var ids		= get_all_checkbox();
	if(ids.length == 0){
		alert('没有选择任何记录');
		return false;	
	}
	
	var allbtn	= $('.js-all-execute');
	var exc		= allbtn.find('option:selected');
	var obj		= exc.attr('value');
	var filed	= exc.attr('data-filed');
	//alert(filed);
	
	var value	= '', isform = 0;
	if($.inArray(filed, ['delete']) == -1){
		
		isform	= 1;
		
		//数据对象
		var dataobj	= exc.attr('data-obj');
		if(dataobj){
			dataobj	= '.js-all-data-' + dataobj;
		}else{
			dataobj	= '.js-all-exe-' + obj;
		}
		//alert('dataobj:' + dataobj);
		
		//控件类型
		var input	= exc.attr('data-input');
		//alert('input:' + input);
		if(input){
			if(input == 'checkbox') value	= ($(dataobj).prop('checked')) ? 1 : 0;
			
		}else{
			value	= $(dataobj).val();
		}
	}

	//没有设定操作值
	if(isform === 1 && value === ''){
		alert('请选择或设置一个批量操作的值');
		return false;	
	}
	
	var btn		= $(this);
		btn.hide();
	var loading = $('.js-all-exe-loading');
		loading.show();
	var data	= 'filed=' + filed + '&value=' + value + '&ids=' + ids.join(',') + '&module=question_material';
	ajaxSend('/index.php/Admin/Question/question_update_fileds', data, function(json){
		
		loading.find('.js-text').html(json.msg);
		setTimeout(function(){ loading.find('.js-text').html('正在努力加载...'); loading.hide(); }, 2000);
		
		$('.js-all-exe-box').hide();
		
		if(json.status == 1){
			btn.hide();
		}
		
	}, function(err){});
	
});


//获得checkbox选择的值
function get_all_checkbox(){
	
	var ids	= [];
	$('.js-tr-checkbox').each(function(index, element) {
        if($(this).prop('checked')) ids.push($(this).val());
    });
	
	return ids;
}
</script> 

</body>
</html>