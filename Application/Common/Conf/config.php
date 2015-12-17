<?php
return array(
	
	'PAGE_TITLE'			=> '默认全局标题',
	'PAGE_KEYWORDS'			=> '默认全局关键词',
	'PAGE_DESCRIPTION'		=> '默认全局关键词描述',
	'PAGE_CHARSET'			=> 'utf-8',

	
	/* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     	// 数据库类型
    'DB_HOST'               =>  '', 	// 服务器地址
    'DB_NAME'               =>  '',     	// 数据库名
    'DB_USER'               =>  '',      	// 用户名
    'DB_PWD'                =>  '',    		// 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'pix_',    		// 数据库表前缀
	'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
	'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
    
	/* 数据缓存设置 */
	'DATA_CACHE_TYPE'       =>  '',  	// 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
	'MEMCACHED_SERVER'      =>  '',    // 数据库表前缀
	'DATA_CACHE_TIME'       =>  0,      		// 数据缓存有效期 0表示永久缓存
	'DATA_CACHE_PREFIX'     =>  'ca_',   // 缓存前缀
	
	/* 队列设置 */
	'HTTPSQS_HOST'			=>  '',
	'HTTPSQS_PORT'			=>  1218,
	'HTTPSQS_AUTH'			=>  'mypass',
	'HTTPSQS_CHARSET'		=>  'utf-8',
	
	'SESSION_OPTIONS'       =>  array(), // session 配置数组 支持type name id path expire domain 等参数

    /* Cookie设置 */
    'COOKIE_EXPIRE'         =>  0,    // Cookie有效期
    'COOKIE_DOMAIN'         =>  'domain.com',      // Cookie有效域名
    'COOKIE_PATH'           =>  '/',     // Cookie路径
    'COOKIE_PREFIX'         =>  'cookie_',      // Cookie前缀 避免冲突
    'COOKIE_HTTPONLY'       =>  '',      // Cookie httponly设置
	
	//皮肤定义
	'DEFAULT_THEME'         =>  'default',	// 默认模板主题名称

	//静态资源路径
	'TMPL_PARSE_STRING'  =>array(
		 '__PUBLIC__' 		=> '/Public/',			// 公用文件根目录路径
		 '__CSS__'     		=> '/Public/css/', 		// CSS类库路径
		 '__JS__'     		=> '/Public/js/', 		// JS类库路径
		 '__IMG__'     		=> '/Public/images/', 	// images路径
		 '__UPLOAD__' 		=> '/Uploads/', 		// 上传路径替换规则
		 '__BOOTSTRAP__' 	=> '/Public/bootstrap/', // 前端框架路径
		 '__UEDITOR__' 		=> '/Public/ueditor/',	 // 编辑器路径
		
	),
	
	'URL_CASE_INSENSITIVE'  => false,   // 默认false 表示URL区分大小写 true则表示不区分大小写
	
	'URL_MODEL'             => 1,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
);