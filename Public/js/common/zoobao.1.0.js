/*!
 * zoobao.js
 * 
 * 核心类库 v1.0 | @zhongmin | 2015-12-04
 * http://code.zoobao.com
 *
 * DEMO:
 * > 
 * >
 *
 */
;(function(window, undefined){
	
	//核心命名空间
	var _lib 	= {};
	
	
	
	/**
	 * 扩展方法[简单版]
	 *
	 * 仅防覆盖
	 *
	 * @param   string   模块名称
	 * @param   object   模块对象
	 * @return  object
	 */
	_lib.extend	= function(){
		var modle	= arguments[0];
		var target 	= Zbo[modle];
		var object 	= arguments[1] || {};
		
		//模块名称，不是对象，不是函数，不为空，则注册
		if(modle && typeof target !== "object" && typeof target !== "function"){
			
			_lib[modle] = object;
			return object;
		}
		
		//抛出异常
		throw new error("ERROR: " + modle + " Already exist..");
	}
	
	
	
	//注册
	window.Zbo 	= _lib;
	
	
	
	/**
	 * 初始化console对象,防止IE不兼容,程序中断
	 *
	 * 
	 */
    var method;
    var noop 	= function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
	
    var length 	= methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method 	= methods[length];

        if (!console[method]) {
            console[method] = noop;
        }
    }
	
	
})(window);