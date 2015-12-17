
/*

javascript: void ((function () {      var d = document, e = d.createElement("script");      e.setAttribute("charset", "UTF-8");      e.setAttribute("src", "http://cdn.buzhi.com/js/jquery1.8.js?" + Math.floor(Math.random()*1000));      d.body.appendChild(e);    var d = document, e = d.createElement("script");      e.setAttribute("charset", "UTF-8");      e.setAttribute("src", "http://www.zoobao.com/bin/paper.js?" + Math.floor(Math.random()*1000));      d.body.appendChild(e);})());

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
	
	var box		= $('#paseexam');	
	var nav		= box.find('.selectArea');
	
	var data		= {};
	data.recommend	= 0;
	
	
	//省份
	data.city		= nav.find('ul li').find('a.active').text();
	
	var list		= box.find('ul#SelectQuestion li');
	list.each(function(index, element) {	
		
		var off			= 'insert';
		var obj			= $(this);
		
		if(off	== 'insert'){
			//data['title']		= '';
			//alert(obj.find('p').first().attr('title'));
			data.title		= obj.find('p').first().attr('title');
			//data.body		= obj.find('.score').html();
			data.year		= data.title.substr(0, 4);
			data.aves		= 0;
			data.diff		= 0;
			data.views		= 0;
			data.applys		= 0;
			data.supplierid	= 2;
			
			var str			= obj.find('a').attr('href');
			var arr			= str.split('paper_id');
			data.sourceid	= arr[1].replace('=', '').replace('&type=1', '');
			
			/*var arr	= [];
			for(var i in data){
				arr.push(i + '=' + data[i]);
			}
			
			alert(arr.join('&'));
			
			return;*/
			
			//录入
			var url	= 'http://www.zoobao.com/index.php/Grab/Index/insert';
			ajaxSend(url, data, function(json){
				
				if(json.status == 1){
					obj.find('.showBoxIn').html('成功收录');	
					return;
				}
				
				if(json.status == 2){
					obj.find('.showBoxIn').html('已经存在');	
				}else{
					
					obj.find('.showBoxIn').html('失败!!');	
				}
			});
			
			
		}else{
			
			var data	= {};
				data.filed		= 'recommend';
				data.value		= 1;
				data.supplierid	= 2;
				
				var str			= obj.find('a').attr('href');
				var arr			= str.split('paper_id');
				data.sourceid	= arr[1].replace('=', '').replace('&type=1', '');
			
			var url	= 'http://www.zoobao.com/index.php/Grab/Index/update';
			ajaxSend(url, data, function(json){
				
				if(json.status == 1){
					obj.find('.showBoxIn').html('成功更新');	
					return;
				}
				
				if(json.status == 2){
					obj.find('.showBoxIn').html('不存在');	
				}else{
					
					obj.find('.showBoxIn').html(json.msg);	
				}
			});
			
			
			
			
		}
	
	});
	
}



function supp_1(){

	var box 	= $('.paper-wrap');
	var nav		= box.find('.paper-nav');
	
	
	var data		= {};
	data.recommend	= 0;
	
	//省份
	data.city		= nav.find('ul.label-nav').find('li.active a').text();
	
	var list		= box.find('.paper-list .list-bd .paper');
	list.each(function(index, element) {
        
		var off			= 'insert';
		var obj			= $(this);
		
		
		if(off	== 'update'){
		
			data.title		= obj.find('.name span').text();
			//data.body		= obj.find('.score').html();
			data.year		= data.title.substr(0, 4);
			data.aves		= obj.find('.score .number').eq(2).text();
			data.diff		= obj.find('.score .number').eq(0).text();
			data.views		= obj.find('.score .number').eq(1).text();
			data.applys		= obj.find('.score .number').eq(1).text();
			data.supplierid	= 1;
			data.sourceid	= obj.find('.button-wrap .download-exercise').attr('data-paper-id');
			
			/*var arr	= [];
			for(var i in data){
				arr.push(i + '=' + data[i]);
			}
			
			alert(arr.join('&'));*/
			
			//录入
			var url	= 'http://www.zoobao.com/index.php/Grab/Index/insert';
			ajaxSend(url, data, function(json){
				
				if(json.status == 1){
					obj.find('.status-wrap .muted').html('成功收录');	
					return;
				}
				
				if(json.status == 2){
					obj.find('.status-wrap .muted').html('已经存在');	
				}else{
					
					obj.find('.status-wrap .muted').html('失败!!');	
				}
			});
		
		
		//更新
		}else{
			
			var data	= {};
				data.filed		= 'ispolice';
				data.value		= 1;
				data.supplierid	= 1;
				data.sourceid	= obj.find('.button-wrap .download-exercise').attr('data-paper-id');
			
			var url	= 'http://www.zoobao.com/index.php/Grab/Index/update';
			ajaxSend(url, data, function(json){
				
				if(json.status == 1){
					obj.find('.status-wrap .muted').html('成功更新');	
					return;
				}
				
				if(json.status == 2){
					obj.find('.status-wrap .muted').html('不存在');	
				}else{
					
					obj.find('.status-wrap .muted').html(json.msg);	
				}
			});
			
		}
    });
}


