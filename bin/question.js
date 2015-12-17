/*

var p = {
	"navs":[
		{"title":"常识判断", "nums":"20", "key":"958814af4117d7381f5afa1b6fd9ddaf"},
		{"title":"言语理解与表达", "nums":"25", "key":"1a3303b8feb811bd6bc64c5a3ff3e270"}
	],	
	"item":{
		"958814af4117d7381f5afa1b6fd9ddaf":[{"qid":333, "attr":""}, {"qid":333, "attr":""}, {"qid":333, "attr":""}],
		"1a3303b8feb811bd6bc64c5a3ff3e270":[{"qid":333, "attr":""}, {"qid":333, "attr":""}, {"qid":333, "attr":""}]	
	},
	"info":{"qnums":45}
}


{"info":{"qnums":125},"navs":[{"title":"常识判断", "nums":"20", "key":"0"},{"title":"言语理解与表达", "nums":"40", "key":"1"},{"title":"数量关系", "nums":"10", "key":"2"},{"title":"判断推理", "nums":"35", "key":"3"},{"title":"资料分析", "nums":"20", "key":"4"}],"item":{"0":[{"qid":"64530"},{"qid":"64544"},{"qid":"64568"},{"qid":"64583"},{"qid":"64596"},{"qid":"64610"},{"qid":"64620"},{"qid":"64633"},{"qid":"64639"},{"qid":"64680"},{"qid":"64691"},{"qid":"64714"},{"qid":"64733"},{"qid":"64754"},{"qid":"64794"},{"qid":"64814"},{"qid":"64829"},{"qid":"64849"},{"qid":"64865"},{"qid":"64947"}],"1":[{"qid":"64655"},{"qid":"64689"},{"qid":"65885"},{"qid":"65486"},{"qid":"64749"},{"qid":"64789"},{"qid":"64810"},{"qid":"64831"},{"qid":"64855"},{"qid":"64876"},{"qid":"64922"},{"qid":"64943"},{"qid":"64957"},{"qid":"64970"},{"qid":"64985"},{"qid":"65004"},{"qid":"65018"},{"qid":"65044"},{"qid":"65056"},{"qid":"65062"},{"qid":"65092"},{"qid":"65109"},{"qid":"65141"},{"qid":"65169"},{"qid":"65203"},{"qid":"65231"},{"qid":"65503"},{"qid":"65256"},{"qid":"65285"},{"qid":"65311"},{"qid":"65322"},{"qid":"65329"},{"qid":"65340"},{"qid":"65347"},{"qid":"65358"},{"qid":"65370"},{"qid":"65377"},{"qid":"65393"},{"qid":"65403"},{"qid":"65418"}],"2":[{"qid":"65159"},{"qid":"65226"},{"qid":"65262"},{"qid":"65366"},{"qid":"65395"},{"qid":"65410"},{"qid":"65483"},{"qid":"65494"},{"qid":"65550"},{"qid":"65577"}],"3":[{"qid":"64842"},{"qid":"64858"},{"qid":"64890"},{"qid":"64909"},{"qid":"64925"},{"qid":"65046"},{"qid":"65058"},{"qid":"65063"},{"qid":"65075"},{"qid":"65093"},{"qid":"65107"},{"qid":"65120"},{"qid":"65129"},{"qid":"65142"},{"qid":"65153"},{"qid":"65261"},{"qid":"65309"},{"qid":"65318"},{"qid":"65326"},{"qid":"65361"},{"qid":"65375"},{"qid":"65385"},{"qid":"65397"},{"qid":"65416"},{"qid":"65763"},{"qid":"65451"},{"qid":"65468"},{"qid":"65481"},{"qid":"65487"},{"qid":"65495"},{"qid":"65520"},{"qid":"65557"},{"qid":"65576"},{"qid":"65585"},{"qid":"65597"}],"4":[{"qid":"65941"},{"qid":"65950"},{"qid":"65927"},{"qid":"65894"}]}}
*/

function supp_2(){
	
	//alert('请先修改JS，收录规则。。 认真查看');
	//return;
	var str_ptitle	= $('.practiceInfo').html();
	var ptitle		= str_ptitle.match(/练习名称：.*<span>/).toString().replace('练习名称：', '').replace('<span>', '');
	
	//整卷
	var arr_paper	= [];
	var qcount		= 0;
	
	//菜单
	var navlist		= $('#select_module li');
	var arr_navs	= [];
	navlist.each(function(index, element) {
        
		var strs	= $(this).text();
		var nums	= strs.match(/[0-9]+/).toString();
		var name	= strs.replace(nums, '');
		qcount	   += Number(nums);
		
		arr_navs.push('{"title":"'+name+'", "nums":"'+nums+'", "key":"'+index+'"}');
    });
	
	//试卷信息
	arr_paper.push('"info":{"qnums":'+ qcount +'}');
	
	//菜单信息
	arr_paper.push('"navs":['+ arr_navs.join(',') +']');
	
	
	//试题部分
	var qdata		= {};
		qdata.qyear	= ptitle.substr(0, 4);
	
	
	var protion		= $('.contentMain');
	var arr_ption	= [];
	protion.each(function(pindex, element) {
		
        
		
		var arr_qitem	= [];
		$(this).find('.answer').each(function(index, element) {
			
			var qbox	= $(this);
			var qitems	= 0, materialid = 0;
			qbox.find('.answerCenter').each(function(index, element) {
                
				var qit		= $(this);
				var qid		= qit.find('.analysisDiv').attr('question_id');
				if(qid == 55286){
					alert(qid);
				
				//资料题
				if(!qit.hasClass('sigs')){
					qid			= qit.find('.addteather').attr('onclick').match(/\d+/).toString();
					materialid	= qid;		//资料题主键
					
					qitems		= qit.siblings('.sigs').size();
					arr_qitem.push('{"qid":"'+qid+'", "son":"'+ qitems +'"}');
					
					//资料
					qdata.material		= qit.find('.topic').html();
					
					//知识点(大)
					var strs		= navlist.eq(pindex).text();
					var nums		= strs.match(/[0-9]+/).toString();
					qdata.bigtype	= strs.replace(nums, '');
					
					//资料图片
					var dp_desc			= [];
					qit.find('.topic img').each(function(index, element) {
                        dp_desc.push($(this).attr('src'));
                    });
					qdata.material_desc	= dp_desc.join('|');
					
					qdata.ismock		= 1;
					qdata.supplierid	= 2;
					qdata.sourceid		= qid;
					
					//入库
					var url	= 'http://www.zoobao.com/index.php/Grab/Index/material';
					ajaxSend(url, qdata, function(json){
						
						qit.html(json.msg);
						
					});
					
				
				//客观题
				}else{
					
					//题干
					qit.find('.topic font').first().remove();
					qdata.body		= qit.find('.topic').html();
					
					//题干图片
					var db_desc		= [];
					qit.find('.topic img').each(function(index, element) {
                        db_desc.push($(this).attr('src'));
                    });
					qdata.bd_desc	= db_desc.join('|');
					
					//选项
					var opts		= [];
					qit.find('.AselectBox li').each(function(index, element) {
						
						var optype	= 0;
						if($(this).find('span img').size() > 0){
							var tt	= $(this).find('span img').eq(0).attr('src');
							optype	= 1;
						}else{
							var tt	= $(this).find('span').text();
						}
						$(this).find('span').remove();	
						var cs	= $(this).text().replace('.', '');
						opts.push('{"cs":"'+cs+'", "text":"'+tt+'", "img":"'+optype+'"}');
                    });
					qdata.options	= '[' + opts.join(',') + ']';
					
					//答案
					qdata.answer	= qit.find('.sureAnswer .greenAnswer').text();
					
					//知识点(小)
					qdata.pointtype1= qit.find('.analyclass .radiusBg').text();
					
					//知识点(大)
					var strs		= navlist.eq(pindex).text();
					var nums		= strs.match(/[0-9]+/).toString();
					qdata.bigtype1	= strs.replace(nums, '');
					
					//解析
					var desc			= qit.find("div.bubble_ico:contains('解析')").siblings('.aCleft');
					qdata.description	= desc.html();
					
					//解析图片
					var dp_desc			= [];
					desc.find('img').each(function(index, element) {
                        dp_desc.push($(this).attr('src'));
                    });
					qdata.dp_desc		= dp_desc.join('|');
					
					
					//拓展
					var extend			= qit.find("div.bubble_ico:contains('拓展')").siblings('.aCleft');
					qdata.extend		= extend.html();
					
					//技巧
					var skill			= qit.find("div.bubble_ico:contains('技巧')").siblings('.aCleft');
					qdata.skill			= skill.html();
					
					qdata.ismock		= 1;
					qdata.supplierid	= 2;
					qdata.sourceid		= qid;
					qdata.materialid	= materialid;
					qdata.optiontype	= qdata.answer.length;
					
					//入库
					var url	= 'http://www.zoobao.com/index.php/Grab/Index/question';
					ajaxSend(url, qdata, function(json){
						
						qit.html(json.msg);
						
					});
				}
				
				if(qitems == 0) arr_qitem.push('{"qid":"'+qid+'"}');
				
				}
            });
			
        });
		
		arr_ption.push('"'+pindex+'":['+ arr_qitem.join(',') +']');
		
    });
	
	//试题信息
	arr_paper.push('"item":{'+ arr_ption.join(',') +'}');
	
	
	var paperjson	= '{'+ arr_paper.join(',') +'}';

	$('.main div').first().html(paperjson);
	
	return ;
	
	//组卷规则入库
	var data			= {};
		data.title		= ptitle;
		data.dataview	= paperjson;
		data.supplierid	= 2;
	var url	= 'http://www.zoobao.com/index.php/Grab/Index/paperupdate2';
	ajaxSend(url, data, function(json){
		
		var msg	= $('.sside_center .sideButton').first();
			msg.html(json.msg);
		
	});
}

/*

javascript: void ((function () {      var d = document, e = d.createElement("script");      e.setAttribute("charset", "UTF-8");      e.setAttribute("src", "http://cdn.buzhi.com/js/jquery1.8.js?" + Math.floor(Math.random()*1000));      d.body.appendChild(e);    var d = document, e = d.createElement("script");      e.setAttribute("charset", "UTF-8");      e.setAttribute("src", "http://www.zoobao.com/bin/question.js?" + Math.floor(Math.random()*1000));      d.body.appendChild(e);})());

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