/*!
 * paper.time.js
 * 	
 * 题库模块[做题工具箱] v1.0 | @zhongmin | | 2015-12-04
 * http://code.zoobao.com/
 *
 * DEMO:
 * > 
 * >
 *
 */
;(function($, window, undefined){
	
	
	var _lib		= window.Zbo;
	var _utils		= _lib.utils;
	
	
	
	
	//缓存引用
	var _objects	= {};
	
	//组件引用(HTML节点)	
	function __getobject(){
		return {
			paper_usetime 	: $('.js-paper-usetime'),
			pause_time	 	: $('.js-paper-time-pause'),
			end_time	 	: $('.js-paper-time-end'),
			paper_submit	: $('.js-paper-submit'),
			paper_navs		: $('#js-paper-navs'),
			paper_save	 	: $('.js-paper-answer-save'),
			
			//只看错题
			paper_showtype	: $('.js-btn-paper-showtype'),
			
			//试卷标题
			_papertitle		: '.js-papertitle',
			
			//提醒对话框
			_paper_box		: '.js-submit-box',
			
			//强制交卷,重新交卷
			_paper_box_end	: '.js-submit-btn-end',
			
			//关闭对话框
			_paper_box_close: '.js-submit-btn-close',
			
			//正在阅卷对话框
			_paper_loading	: '.js-submit-loading',
			
			//交卷成功 查看报表
			_paper_box_goto : '.js-submit-btn-goto',
			
			//进度条
			_loading_box  	: '.js-loading',
			_loading_press 	: '.js-loading-press',
			_loading_msg	: '.js-press-msg',
			
			//暂停做题
			_paper_end_time	: '.js-submit-end-box',
			
			//遮罩层
			_body_bg		: '.js-body-bg'
		};
	}
	
	//试卷交卷提醒对话框模板
	var _temp_paper_submit	= 'tp-paper-submit-box';
	var _temp_sub_loading	= 'tp-paper-submit-loading-box';
	var _temp_paper_endtime	= 'tp-paper-submit-end-box';
	
	//停止计时
	function __end_loop_time(){
		
		__start_usetime(false);
		__start_navtime(false);	
		
		
		//启动交卷动画
		var _body_bg	= $(_objects.obj._body_bg);
			_body_bg.fadeIn('slow');
		
		//对话框不存在，则创建..
		var _box	= $(_objects.obj._paper_end_time);
		if(!_box.size()){
				
			//创建结构
			var _htmlstr	= template(_temp_paper_endtime, null);
			$(document.body).append(_htmlstr);
			
			var _box	= $(_objects.obj._paper_end_time);
			
			//继续做
			_box.find(_objects.obj._paper_box_close).click(function(){
				
				_box.hide();
				_body_bg.hide();
				
				_objects.obj.pause_time.click();
			});
		}	
		
		_box.show();
	}
	
	//开启计时
	function __start_loop_time(){
		
		__start_usetime(true);
		__start_navtime(true);	
	}
	
	//格式化时间
	function __usetime_format(usetime, _config){
		
		var _config	= (!_config) ? {} : _config;
		
		var _usetime	= (usetime) ? usetime : 0;
		if(!_config.msgstr) _config.msgstr = '总用时：';
		return  _config.msgstr + _utils.tools.timeFormat(_usetime, _config.format);
	}
	
	
	//计时[暂停/启动]
	function __pause_time_click(){
		
		//暂停
		if(!$(this).attr('off')){
			$(this).attr('off', 1).addClass('green-btn').html('继续做题');
			_objects.obj.paper_submit.removeClass('green-btn');
			
			__end_loop_time();
			return;
		}
		
		//开启
		$(this).removeAttr('off').removeClass('green-btn').html('暂停');
		_objects.obj.paper_submit.addClass('green-btn');
		__start_loop_time();
	}
	
	//下次再做
	function __end_time_click(){
		
		_objects.app_paper_navs.saveanswer(function(json, _count){
			location.href = '/index.php/Paper/Index';
		});
	}
	
	//保存答案
	function __answer_save_click(){
		
		var _btn	= $(this);
		_objects.app_paper_navs.saveanswer(function(json, _count){
			var d = dialog({
				fixed: true,
				content: '成功保存答案..  @_@ ',
				quickClose: true// 点击空白处快速关闭
			});
			//d.show(_btn.get(0));
			d.show();
			
			setTimeout(function () {
				d.close().remove();
			}, 2000);
		});
	}
	
	//交卷
	function __paper_submit_click(){
		
		var _body_bg	= $(_objects.obj._body_bg);
		
		//试卷进度
		var _info		= _objects.app_paper_icos.info();
		var _speed		= _info._speeds;
		if(_speed > 0){
			
			//对话框不存在，则创建..
			var _box	= $(_objects.obj._paper_box);
			if(!_box.size()){
				
				//创建结构
				var data		= {speed:_speed};
				var _htmlstr	= template(_temp_paper_submit, data);
				$(document.body).append(_htmlstr);
				
				//绑定事件
				var _box	= $(_objects.obj._paper_box);
				_box.find(_objects.obj._paper_box_end).click(function(){ __end_paper_submit_click(_speed); });
				_box.find(_objects.obj._paper_box_close).click(function(){
					
					_box.remove();
					_box.fadeOut("slow");
					_body_bg.hide();
				});
			}
			
			_body_bg.fadeIn('slow');
			_box.show();
			return;	
		}
		
		//强制交卷
		__end_paper_submit_click(_speed);
	}
	
	//交卷[强制]
	function __end_paper_submit_click(_speed){
		
		//启动交卷动画
		var _body_bg	= $(_objects.obj._body_bg);
			_body_bg.fadeIn('slow');
		
		//对话框不存在，则创建..
		var _box	= $(_objects.obj._paper_loading);
		if(!_box.size()){
				
			//创建结构
			var _papertitle = $(_objects.obj._papertitle).html();
			var _data		= {papertitle:_papertitle, speed:_speed};
			var _htmlstr	= template(_temp_sub_loading, _data);
			$(document.body).append(_htmlstr);
				
			//绑定事件
			var _box		= $(_objects.obj._paper_loading);
			_box.find(_objects.obj._paper_box_end).click(function(){
				
				_box.remove();
				__end_paper_submit_click(_speed);	
				
			});
			_box.find(_objects.obj._paper_box_goto).click(function(){
				
				//跳转到报表页, 带试卷ID
				var _paperid	= _objects.paperid;
				location.href = '/index.php/Paper/Answer/Index?paperid=' + _paperid;
				
			});
			
			//继续做
			_box.find(_objects.obj._paper_box_close).click(function(){
				_box.remove();
				
				$(_objects.obj._paper_box).hide();
				_body_bg.hide();
			});
		}	
		
		//显示加载动画
		var _loading	= _box.find(_objects.obj._loading_box);
		var _press		= _loading.find(_objects.obj._loading_press);
		var _press_msg	= _loading.find(_objects.obj._loading_msg);
		
		//进度条加载完毕
		_press.animate({width: '90%'}, 6000, function(){});  
		
		_body_bg.fadeIn('slow');
		_box.show();
		
		_objects.app_paper_navs.saveanswer(function(json, _count){
			
			_press_msg.html('阅卷完毕，正在进行【试卷智能分析】，请稍后..');
			var _data	= {paperid:_objects.paperid, getinfo:4};
			__ajax(_data, function(json){
				
				//结束进度动画
				_press.stop(true, false).animate({width: '100%'}, 600, function(){
					
					_press_msg.html('完成分析，请查看【智能分析报表】，2秒后自动跳转..');
					_box.find(_objects.obj._paper_box_goto).fadeIn('slow');
					
					//2秒后自动跳转
					var _out	= setTimeout(function(){
						_box.find(_objects.obj._paper_box_goto).click();	
					}, 2000);
					
				}); 
				
				//清除申请的试卷[客户端]
				var _dinfo	= _objects.app_paper_icos.info();
				var _cookie	= 'paper-apply-' + _dinfo.fid;
				_utils.cache.remove(_cookie);
				
			//发送故障	
			}, function(json){
				
				//结束进度动画
				_press.stop(true, false).animate({width: '100%'}, 600, function(){
					
					_press_msg.html('网络超时，请重新【提交试卷】..');
					_box.find(_objects.obj._paper_box_end).fadeIn('slow');
					_box.find(_objects.obj._paper_box_close).fadeIn('slow');
				});
				
			});	
		});	
	}
	
	function __start_usetime(off){
		
		if(!off) return clearInterval(_objects.int_papertime);
		
		//暂停，切换nav不启动计时
		if(_objects.obj.pause_time.attr('off')) return;
		
		var obj_usetime			= _objects.obj.paper_usetime;
		_objects.int_papertime	= setInterval(function(){
				
			var usetime			= Number(obj_usetime.attr('usetime')) + 1;
			var title			= '还剩余：' + _utils.tools.timeFormat((Number(obj_usetime.attr('totaltime')) - usetime));
			obj_usetime.attr('usetime', usetime).attr('title', title).html(__usetime_format(usetime));
				
		}, 1000);
	}


	function __start_navtime(off){
		
		if(!off) return clearInterval(_objects.int_navtime);
		
		//暂停，切换nav不启动计时
		if(_objects.obj.pause_time.attr('off')) return;	
		
		var obj_usetime			= _objects.obj.paper_navs.find('li.current');
		_objects.int_navtime	= setInterval(function(){
			
			var usetime			= Number(obj_usetime.attr('usetime')) + 1;
			obj_usetime.attr('usetime', usetime).attr('title', __usetime_format(usetime));
			
		}, 1000);	
	}
	
	
	function _paper_showtype_click(){
		
		var _nav 		= _objects.app_paper_navs.getNav();
		var _type		= _nav.attr('show-list');
		var _index		= _nav.index();
		var _exetype 	= (_type == 'err') ? 'all' : 'err';
		
		_objects.app_paper_navs.update({exetype:_exetype}, _index);
		_nav.click();
	}

	
	
	/**
	 * 请求答题卡数据
	 *
	 * @param  json    config   参数配置
	 * @param  func    callback 成功执行函数
	 * @param  func    error    失败执行函数
	 *     
	 */
	function __ajax(data, callback, error){
			
		//请求地址
		var url			= '/Paper/Answer/Index';
		_utils.ajax.post(url, data, function(json){
				
			//失败直接返回
			if(json.status == 0){
				if(error) error(json);
				return;
			}
			
			callback(json);
				
		}, error);
	}
	

	/**
	 * 分模块(注册/挂载)
	 *
	 * 应该统一到 paper命名空间下(暂简单处理)
	 * 
	 */
	_lib.extend('time', {
		
		
		
		create : function(config){
			
			var obj					= __getobject();
			_objects.obj			= obj;
			
			_objects.paperid		= config.paperid;
			_objects.app_paper_navs	= _lib.navs;
			_objects.app_paper_icos	= _lib.icos;
			
			
			//总用时
			var usetime				= obj.paper_usetime.attr('usetime');
			obj.paper_usetime.html(__usetime_format(usetime));
			
			
			//事件监听
			obj.pause_time.click(__pause_time_click);		//暂停
			obj.end_time.click(__end_time_click);			//下次再做
			obj.paper_submit.click(__paper_submit_click);	//交卷
			obj.paper_showtype.click(_paper_showtype_click);//只看错题
			obj.paper_save.click(__answer_save_click);		//保存答案
			
			return this;
		},
		
		
		showtype: function(_txt, _type){
			_objects.obj.paper_showtype.html(_txt);
			
			if(_type == 'err'){
				_objects.obj.paper_showtype.addClass('green-btn');
			}else{
				_objects.obj.paper_showtype.removeClass('green-btn');
			}
		},
		
		start : function(){
			
			__start_loop_time();
			
			
			
			return this;
		},
		
		end : function(){
			
			__end_loop_time();
			
			return this;
		},
		
		change : function(){
			
			__start_navtime(false);
			__start_navtime(true);
			
		},
		
		format : function(usetime, _config){
			return __usetime_format(usetime, _config);
		}
	});
	
	


})(window.jQuery, window);