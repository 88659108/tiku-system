<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
        
  <title>试题维护</title>
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
        
        

<script type="text/javascript" src="/Public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/ueditor/ueditor.all.min.js"></script>
<script>
var ueditor_config	= {
		
		////默认的编辑区域高度
		initialFrameHeight:150,
		
		//这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
        //toolbars:[['FullScreen', 'Source', 'Undo', 'Redo','Bold','test']],  	
};
</script>


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
<li><a href="/index.php/Admin/Question/objective">客观题</a></li>
<li class="active">试题维护</li>

						</ul><!-- .breadcrumb -->

												
					</div>

					<div class="page-content">
                    	
  <div class="row">
    <div class="col-xs-12">
      <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
          <li class="active"> <a data-toggle="tab" href="#home"> <i class="green icon-home bigger-110"></i> 试题主体 </a> </li>
          <?php if($info["materialid"] != 0): ?><li> <a href="/index.php/Admin/Question/material_form?id=<?php echo ($info["materialid"]); ?>" target="_blank"> <i class="green icon-external-link bigger-110"></i> 修改资料 </a> </li><?php endif; ?>
          <li> <a href="/index.php/Admin/Question/objective_ask?id=<?php echo ($_GET['id']); ?>"> 试题咨询 <span class="badge badge-danger">4</span> </a> </li>
          <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> 智能教学 &nbsp; <i class="icon-caret-down bigger-110 width-auto"></i> </a>
            <ul class="dropdown-menu dropdown-info">
              <li> <a data-toggle="tab" href="#dropdown1">@趣味奖励</a> </li>
              <li> <a data-toggle="tab" href="#dropdown2">@典型错误</a> </li>
            </ul>
          </li>
        </ul>
        <div class="tab-content">
          <div id="home" class="tab-pane in active"> 
          
          <?php echo (htmlspecialchars_decode($info["body1"])); ?><br>
          
          A.<?php echo $info[options][0][text]; ?>
          B.<?php echo $info[options][1][text]; ?><br>
          C.<?php echo $info[options][2][text]; ?>
          D.<?php echo $info[options][3][text]; ?><br>
          
          正确答案：<?php echo ($info["answer"]); ?><br>
          <?php echo (htmlspecialchars_decode($info["description1"])); ?><br>
          
          
          <form>
  			<?php if($info["id"] != 0): ?><input type="hidden" value="<?php echo ($info["id"]); ?>" name="id" /><?php endif; ?>
            <script type="text/plain" id="body-<?php echo ($info["id"]); ?>">
			<?php if($info["body"] != ''): echo (htmlspecialchars_decode($info["body"])); else: ?>试题题干（图文并茂）<?php endif; ?>
            </script>
            <script>
			ueditor_config.textarea	= 'body';
			var ue = UE.getEditor('body-<?php echo ($info["id"]); ?>', ueditor_config);
            </script>
            <br />
            <div class="widget-box transparent">
              <div class="widget-header widget-header-flat">
                <h4 class="lighter"> <i class="icon-circle-blank orange"></i> 选项(Options) </h4>
                <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="icon-chevron-up"></i> </a> </div>
              </div>
              <div class="widget-body"> <br />
                <div class="row">
                  <div class="col-xs-4">
                    <div class="input-group"><span class="input-group-addon"><i class="">A</i></span>
                      <input class="form-control" name="opts-a" type="text" value="<?php echo $info[options][0][text]; ?>">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="input-group"><span class="input-group-addon"><i class="">B</i></span>
                      <input class="form-control" name="opts-b" type="text" value="<?php echo $info[options][1][text]; ?>">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="input-group"><span class="input-group-addon"><i class="">C</i></span>
                      <input class="form-control" name="opts-c" type="text" value="<?php echo $info[options][2][text]; ?>">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="input-group"><span class="input-group-addon"><i class="">D</i></span>
                      <input class="form-control" name="opts-d" type="text" value="<?php echo $info[options][3][text]; ?>">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="input-group"><span class="input-group-addon"><i class="">E</i></span>
                      <input class="form-control" name="opts-e" type="text" value="<?php echo $info[options][4][text]; ?>">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="input-group"><span class="input-group-addon"><i class="">F</i></span>
                      <input class="form-control" name="opts-f" type="text" value="<?php echo $info[options][5][text]; ?>">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="input-group pull-right" style="width:200px;"> <span class="input-group-addon"><i class="">单选</i></span>
                      <input value="<?php echo ($info["answer"]); ?>" name="answer" class="form-control input-mask-phone" type="text" id="form-field-mask-2">
                      <span class="input-group-addon btn-success"><i class="">正确答案</i></span> </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="input-group pull-right" style="width:200px;"> <span class="input-group-addon"><i class="icon-warning-sign red"></i></span>
                      <input value="<?php echo ($info["wrongans"]); ?>" name="wrongans" class="form-control" type="text">
                      <span class="input-group-addon btn-danger"><i class="">高频错选</i></span> </div>
                  </div>
                </div>
              </div>
            </div>
            <br />
            <div class="widget-box transparent">
              <div class="widget-header widget-header-flat">
                <h4 class="lighter"> <i class="icon-book orange"></i> 解析(Description) </h4>
                <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="icon-chevron-up"></i> </a> </div>
              </div>
              <div class="widget-body"> 
                <script type="text/plain" id="description-<?php echo ($info["id"]); ?>">
				<?php if($info["description"] != ''): echo (htmlspecialchars_decode($info["description"])); else: ?>试题解析（图文并茂）<?php endif; ?></script>
				<script>
				ueditor_config.textarea	= 'description';
				var ue = UE.getEditor('description-<?php echo ($info["id"]); ?>', ueditor_config);
                </script>
              </div>
            </div>
            <br />
            <div class="widget-box transparent">
              <div class="widget-header widget-header-flat">
                <h4 class="lighter"> <i class="icon-cog orange"></i> 标签(Lable) </h4>
                <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="icon-chevron-up"></i> </a> </div>
              </div>
              <div class="widget-body"> <br />
                <div class="row">
                  <div class="col-xs-3">
                    <select class="form-control" name="ismock">
                      <option value="<?php echo ($info["ismock"]); ?>">真题 或 模拟...</option>
                      <option value="1"
                      <?php if(($info["ismock"]) == "1"): ?>selected="selected"<?php endif; ?>
                      >真题
                      </option>
                      <option value="0"
                      <?php if(($info["ismock"]) == "0"): ?>selected="selected"<?php endif; ?>
                      >模拟
                      </option>
                    </select>
                  </div>
                  <div class="col-xs-3">
                    <select class="form-control" name="bigtype">
                      <option value="0" style="font-weight:bold; color:#999;">选择一个根知识点</option>
                      <?php if(is_array($info["form_list1"])): $i = 0; $__LIST__ = $info["form_list1"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cls): $mod = ($i % 2 );++$i;?><option 
                        <?php if(($info["bigtype"]) == $cls["id"]): ?>selected="selected"<?php endif; ?> 
                         value="<?php echo ($cls["id"]); ?>" style="font-weight:bold; color:#F00;" data-topid="<?php echo ($cls["topid"]); ?>">&nbsp;&nbsp;<?php echo ($cls["title"]); ?>
                    
                        </option>
                        <?php if(is_array($cls['list'])): $i = 0; $__LIST__ = $cls['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clss): $mod = ($i % 2 );++$i;?><option value="<?php echo ($clss["id"]); ?>" style="display:none;" data-topid="<?php echo ($clss["topid"]); ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($clss["title"]); ?></option>
                          <?php if(is_array($clss['list'])): $i = 0; $__LIST__ = $clss['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clsss): $mod = ($i % 2 );++$i;?><option value="<?php echo ($clsss["id"]); ?>" style="display:none;" data-topid="<?php echo ($clsss["topid"]); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($clsss["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                  </div>
                  <div class="col-xs-3">
                    <select class="form-control" name="smalltype">
                      <option value="0">二级根知识点</option>
                      <?php if(is_array($info["form_list2"])): $i = 0; $__LIST__ = $info["form_list2"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cls): $mod = ($i % 2 );++$i; if(is_array($cls['list'])): $i = 0; $__LIST__ = $cls['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clss): $mod = ($i % 2 );++$i;?><option value="<?php echo ($clss["id"]); ?>"
                          <?php if(($info["smalltype"]) == $clss["id"]): ?>selected="selected"<?php endif; ?>
                          >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($clss["title"]); ?>
                          </option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                  </div>
                  <div class="col-xs-3">
                    <select class="form-control" name="pointtype">
                      <option value="0">三级根知识点</option>
                      <?php if(is_array($info["form_list3"])): $i = 0; $__LIST__ = $info["form_list3"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cls): $mod = ($i % 2 );++$i; if(is_array($cls['list'])): $i = 0; $__LIST__ = $cls['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clss): $mod = ($i % 2 );++$i;?><option value="<?php echo ($clss["id"]); ?>"
                          <?php if(($info["pointtype"]) == $clss["id"]): ?>selected="selected"<?php endif; ?>
                          >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($clss["title"]); ?>
                          </option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="col-xs-3">
                    <div class="input-group"> <span class="input-group-addon"><i class="">年份</i></span>
                      <input class="form-control" value="<?php echo ($info["qyear"]); ?>" name="qyear" type="text" placeholder="如：2013">
                    </div>
                  </div>
                  <div class="col-xs-3">
                    <div class="input-group"> <span class="input-group-addon"><i class="">难度(0-5)</i></span>
                      <input class="form-control" value="<?php echo ($info["diff"]); ?>" name="diff" type="text" placeholder="(0-5)">
                    </div>
                  </div>
                  <div class="col-xs-3">
                    <div class="input-group"> <span class="input-group-addon"><i class="">考频(0-5)</i></span>
                      <input class="form-control" value="<?php echo ($info["chance"]); ?>" name="chance" type="text" placeholder="(0-5)">
                    </div>
                  </div>
                  <div class="col-xs-3">
                    <div class="input-group"> <span class="input-group-addon"><i class="">状态</i></span>
                      <input class="form-control" value="<?php echo ($info["status"]); ?>" name="status" type="text" placeholder="(0-1)">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix form-actions">
              <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-info js-btn-form-submit" type="button"> <i class="icon-ok bigger-110"></i> Submit </button>
                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset"> <i class="icon-undo bigger-110"></i> Reset </button>
              </div>
            </div>
            </form>
          </div>
          <div id="profile" class="tab-pane">
            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.</p>
          </div>
          <div id="dropdown1" class="tab-pane">
            <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
          </div>
          <div id="dropdown2" class="tab-pane">
            <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin.</p>
          </div>
        </div>
      </div>
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
        

<script language="javascript">

$('.js-btn-form-submit').click(function(){
	
	var oform	= $(this).parents('form');
		
	var data	= oform.serialize();
	ajaxSend('/index.php/Admin/Question/objective_save', data, function(json){
		
		dialog({
			title: '操作提示',
			content: json.msg,
			cancel: false,
    		ok: function () {}
		})
		.width(320)
		.show();
		
	});
});


//根知识点
$('select[name=bigtype]').change(function(){
	
	var oform	= $(this).parents('form');
	
	//操作第二级下拉
	var topid	= $(this).val();
	var osmall	= oform.find('select[name=smalltype]');

	var html	= get_class_topid_sonlist($(this), topid);
		osmall.html(html).find('option').show();	
	
	//触发第二级事件
	osmall.change();
});


//二级知识点
$('select[name=smalltype]').change(function(){
	
	var oform	= $(this).parents('form');
	
	//根节点数
	var root	= oform.find('select[name=bigtype]');
	
	//操作第三级下拉
	var topid	= $(this).val();
	var opoint	= oform.find('select[name=pointtype]');
	var html	= get_class_topid_sonlist(root, topid);
		opoint.html(html).find('option').show();
});



/**
 * 根据父级主键 从一个select->option->获得直接子级列表
 * 
 * @param   obj    $root      列表对象
 * @param   int    $tipid     主键
 * @return  html->(option)
 */
function get_class_topid_sonlist(root, topid){
	return root.find('option[data-topid='+topid+']').clone();
}

</script> 

</body>
</html>