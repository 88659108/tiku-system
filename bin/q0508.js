
/*

javascript: void ((function () {      var d = document, e = d.createElement("script");      e.setAttribute("charset", "UTF-8");      e.setAttribute("src", "http://cdn.buzhi.com/js/jquery1.8.js?" + Math.floor(Math.random()*1000));      d.body.appendChild(e);    var d = document, e = d.createElement("script");      e.setAttribute("charset", "UTF-8");      e.setAttribute("src", "http://www.zoobao.com/bin/q0508.js?" + Math.floor(Math.random()*1000));      d.body.appendChild(e);})());

*/

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



$(function(){
	
	
	
	supp_2();
	
	
	
});



function supp_2(){
	
	var elist	= $('#elist');
	var etype1	= elist.find('.etype').eq(0);
	
	var qlist	= [];
	etype1.find('li').each(function(){
		var title	= $(this).find('div').eq(0).text();
		
		var a		= $(this).find('dd.msgrst em a');
		var url		= a.attr('href');
		
		//获得题干,选项
		alert(title + url);
		$.get(url, null, function(data){
			
			//获得解析,正确答案
			var htmlstr = $(data).find('.pcb table').html();
			alert(title + url + htmlstr);
			
		}, 'html');

		
	});	
}

