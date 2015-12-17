<?php
return array(
	
	
	/* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     	// 数据库类型
    'DB_HOST'               =>  '121.41.51.22', // 服务器地址
    'DB_NAME'               =>  'wecenter_ask',     	// 数据库名
    'DB_USER'               =>  'root',      	// 用户名
    'DB_PWD'                =>  'bf6598ba03',    		// 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'zb_',    		// 数据库表前缀
	'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
	'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
	
	
);