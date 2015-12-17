
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
	
	var url		= '/index.php' + action;
	if(params){
		if(params.ajaxurl){ url = action; }
	}
	var config 	= {url:url,dataType:'json',type:"POST",data:data,success:success,error:error,cache:false};
	for(var x in params){config[x] = params[x];}
	$.ajax(config);
}



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
function dateFormat(date, format) {
    if(format === undefined){
        format = date;
        date = new Date();
    }
    var map = {
        "M": date.getMonth() + 1, //月份 
        "d": date.getDate(), //日 
        "h": date.getHours(), //小时 
        "m": date.getMinutes(), //分 
        "s": date.getSeconds(), //秒 
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
}


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
function timeFormat(timestamp, format){
		
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
};