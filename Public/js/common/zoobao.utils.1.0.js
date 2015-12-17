/*!
 * zoobao.utils.js
 * 	
 * 工具函数库 v1.0 | @zhongmin | | 2015-12-04
 * http://code.zoobao.com/
 *
 * DEMO:
 * > 
 * >
 *
 */
;(function($, window, undefined){
	
	
	/**
	 * 多个集合: tools, ajax, array
	 * 共用一个命名空间: utils
	 *
	 * 根据集合，后期可拆分成多个文件(按需加载) 
	 *
	 */
	var _lib		= {};
	
	
	/**
	 * 常用函数集
	 *
	 */
	_lib['tools'] 	= {
		
		/** 
		 * 对日期进行格式化， 
		 * @param date   要格式化的日期 
		 * @param format 进行格式化的模式字符串
		 *     支持的模式字母有： 
		 *     y:年, 
		 *     M:年中的月份(1-12), 
		 *     d:月份中的天(1-31), 
		 *     h:小时(0-23), 
		 *     m:分(0-59), 
		 *     s:秒(0-59), 
		 *     S:毫秒(0-999),
		 *     q:季度(1-4)
		 * @return String
		 */
		dateFormat : function(date, format) {
			if(format === undefined){
				format = date;
				date = new Date();
			}
			var map = {
				"M": date.getMonth() + 1, 	//月份 
				"d": date.getDate(), 		//日 
				"h": date.getHours(),		//小时 
				"m": date.getMinutes(), 	//分 
				"s": date.getSeconds(), 	//秒 
				"q": Math.floor((date.getMonth() + 3) / 3), //季度 
				"S": date.getMilliseconds() //毫秒 
			};
			format = format.replace(/([yMdhmsqS])+/g, function(all, t){
				var v = map[t];
				if(v !== undefined){
					if(all.length > 1){
						v = '0' + v;
						v = v.substr(v.length-2);
					}
					return v;
				}
				else if(t === 'y'){
					return (date.getFullYear() + '').substr(4 - all.length);
				}
				return all;
			});
			return format;
		},


		/**
		 * 对时间戳进行格式化
		 *
		 * @param   int     timestamp     时间戳
		 * @param   string  format        进行格式化的模式字符串
		 *     支持的模式字母有： 
		 *     h:小时(0-23), 
		 *     m:分(0-59), 
		 *     s:秒(0-59)
		 
		 * @return  string
		 */
		timeFormat : function(timestamp, format){
				
			var h	= Math.floor(timestamp / 3600);
			var m 	= Math.floor((timestamp % 3600) /60);  
			var s 	= timestamp % 60;  
				
			var hh 	= (h.toString().length < 2) ? '0' + h : h;
			var mm  = (m.toString().length < 2) ? '0' + m : m;
			var ss  = (s.toString().length < 2) ? '0' + s : s;
			
			if(format){
				return format.replace('hh', hh).replace('mm', mm).replace('ss', ss);
			}
			
			return hh + ':' + mm + ':' + ss;
		},
		
		
		/**
 		 * 检查字符串是否为合法email
		 *
         * @param {String} 字符串
         * @return {bool}  是否合法
         */
        isEmail : function(_email) {
			
            if(!_email) return false;
			
			var _regexp = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			return RegExp(_regexp).test(_email);
        },
		
		
		/**
 		 * 检查字符串是否为合法手机号
		 *
         * @param {String} 字符串
         * @return {bool}  是否合法
         */
        isMobile : function(_mobile) {
			
            if(!_mobile) return false;
			
			var _regexp = /^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
			return RegExp(_regexp).test(_mobile);
        },
		
		
		/**
	 	 * 验证数字 0-9
		 * @param {String} 字符串
		 * @return {bool}  是否合法
	     */
		validateNumber : function(value){
			 
			var flag = true;
			var reg = new RegExp("^[0-9]*$");  
			if(!reg.test(value)){  
				flag = false;
			}  
			if(!/^[0-9]*$/.test(value)){  
				flag = false;
			} 
			return flag;
		},
		
		
			
		/**
		 * 获取url中的参数
		 *
		 * @param  {String}  参数名
		 * @return {String}
		 */
		getUrlParam : function(name) {
			
			//构造一个含有目标参数的正则表达式对象
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); 
			
			//匹配目标参数
			var r = window.location.search.substr(1).match(reg);  
			
			//返回参数值
			if (r != null) return unescape(r[2]); return null; 
		},

		
		
		/**
		 * 检查浏览器
		 *
		 */
		isBrowser : function(){}
	
		
	};
	
	
	
	
	/**
	 * ajax工具集
	 *
	 */
	_lib['ajax'] 	= {
		
		
		/**
		 * 全局公用 请求函数
		 *
		 * @param  string    action    请求地址
		 * @param  string    data      发送的数据
		 * @param  function  success   成功,回调函数
		 * @param  function  success   失败,回调函数
		 * @param  json      params    更多配置参数 
		 */
		post : function(action, data, success, error, params){
			
			
			//临时兼容处理代码---
			var url		= '/index.php' + action;
			if(params){
				if(params.ajaxurl){ url = action; }
			}
			//临时兼容处理代码---
			
			
			var config = {url: url, dataType:'json',type: "POST",data:data,success:success,error:error,cache:false};
			for(var x in params){config[x] = params[x];}
			$.ajax(config);
		},
		
	};
	
	
	
	/**
	 * 数组工具集
	 *
	 */
	_lib['array'] 	= {
		
		
		/**
		 * 数组快速排重[一维]
		 *
		 * @param   array    _array     需排重的数组
		 * @return  array               排重后的数组
		 */
		unique : function(_array){
			
			var _arr = [], _temp = {}, _len = _array.length - 1;
			
			for(var i = _len; i >= 0; i--){
				
				if(!_temp[_array[i]]){
					_arr.push(_array[i]);
					_temp[_array[i]] = 1;
				}
			}
			
			return _arr;
		}
		
	};
	
	
	
	/**
	 * 缓存工具集
	 *
	 */
	_lib['cache'] 	= {
		
		
		/**
		 * 设置缓存
		 *
		 * @param   string    key     缓存名称
		 * @param   object    data    缓存数据
		 * @param   int       time    过期时间[可选, 默认永久]
		 */
		set : function(key, data, time){
			
			//使用第三方store缓存组件
			return store.set(key, data); 
		},
		
		
		
		/**
		 * 读取缓存
		 *
		 * @param   string    key     缓存名称
		 */
		get : function(key){
			return store.get(key);	
		},
		
		
		
		/**
		 * 删除缓存
		 *
		 * @param   string    key     缓存名称
		 */
		remove : function(key){
			return store.remove(key);
		},
		
	};
	
	
	
	
	/**
	 * 注册utils
	 *
	 */
	Zbo.extend('utils', _lib);
	
	
})(window.jQuery, window);

