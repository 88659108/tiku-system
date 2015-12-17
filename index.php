<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', True);

// 定义应用目录
define('APP_PATH','./Application/');

// 定义运行时目录
define('RUNTIME_PATH','./Runtime/');

//应用模式
//define('APP_STATUS', 'home');


//生成一个模块
//define('BIND_MODULE','QRcode');

// 引入ThinkPHP入口文件
require './thinkphp/ThinkPHP.php';


/**
 * 与WeCenter系统的SESSION同步
 * 让两个系统的 sessionid 一致
 *
 */
if(strtolower(trim($_COOKIE['zb__Session'])) != strtolower(session_id())){
	
	/**
	 * 注意
	 * > zb__Session 是WeCenter的cookie，前缀也在其配置文件设置 ask\system\config.inc.php
	 * > thinkPHP全局函数 Application\Common\Common\function.php
	 *   function get_sessions($key)
	 *   则是读取WeCenter登陆后的SESSION信息，其SESSION前缀也与cookie一致
	 */
	
	setcookie('zb__Session', session_id(), false, '/', '.zoobao.com');
}