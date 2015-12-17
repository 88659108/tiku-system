/*!
 * paper.question.js
 * 	
 * 题库模块[试题管理器] v1.0 | @zhongmin | | 2015-12-04
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
			_module			: '.js-question-module',
			_question		: '.js-question',
			_options		: '.js-options li',
			_usetime		: '.js-use-time',
			_number			: '.js-number',
			_question_notes : '.js-question-notes',
			_show_material	: '.js-btn-show-material',
			_material_fix	: '.js-material-',
			
			_desc_desc_box	: '.js-question-description',
			_desc_off_btn	: '.js-switch-off',
			_desc_off_txt	: '.js-switch-txt',
			_desc_text_box	: '.js-question-description-desc',
			_desc_tab_box	: '.js-question-description-tab',
			_desc_tab_btn	: '.js-desc-btn',
			_desc_tab_boxs	: '.js-desc-tab-box',
			
			_desc_form		: '.js-question-desc-form',
			_desc_form_btn	: '.js-question-desc-form-btn',
			_desc_form_txt	: '.js-question-form-content',
			
			_q_btn_mark		: '.js-set-mark',
			_q_btn_collects	: '.js-set-collects',
			_q_btn_mark_txt : '.js-mark-text',
			_q_btn_coll_txt : '.js-coll-text',
			_q_btn_sub_bug	: '.js-sub-bug',
			_q_btn_bug_txt	: '.js-bug-text',
			
			_q_inpt_notes	: '.js-q-notes',
			_q_ans_ok		: '.js-ans-ok',
			_q_ans_me		: '.js-ans-me',
		};
	}
	
	var _temp_question_notes 	= 'tp-objective-question-notes';
	var _temp_question_desc 	= 'tp-objective-question-description';
	var _temp_question_list 	= 'tp-question-description-questionlist';
	var _temp_desc_note_list 	= 'tp-question-description-notelist';
	var _temp_desc_ask_list 	= 'tp-question-description-ask-userlist';
	
	function __usetime_format(usetime){
		var _usetime	= (usetime) ? usetime : 0;
		return '用时：' + _utils.tools.timeFormat(_usetime, 'mm分ss秒');
	}
	
	//初始化试题事件[委托]
	function __init(){
		
		var _questions		= _objects.questions;
		_questions.mouseenter(function(){
			
			//计时开始
			var _question			= $(this);
			_objects.int_usetime	= setInterval(function(){
				var _usetime			= (_question.attr('usetime')) ? _question.attr('usetime') : 0;
				_question.attr('usetime', Number(_usetime) + 1);
			}, 1000);
		
		//暂停计时	
		}).mouseleave(function(){ window.clearInterval(_objects.int_usetime); });
		
		
		//选项[点击事件]
		_questions.find(_objects.obj._options).click(function(){
			
			//当前试题
			var _question	= $(this).parents(_objects.obj._question);
			var _answer		= $(this).attr('cs');
			
			
			//练习模式
			if(_objects.pagetype == 1){
				
				//练习模式[选择答案后，不能更改]
				if(_question.attr('answer')) return false;
				
				//清除事件[第一次选择答案，不能继续选择]
				_question.find(_objects.obj._options).unbind('click');
				window.clearInterval(_objects.int_usetime);
				_question.unbind('mouseenter mouseleave');
			}
			
			//标记选择[用时]
			$(this).addClass('current').siblings().removeClass('current').find(_objects.obj._usetime).html('');
			$(this).find(_objects.obj._usetime).html(__usetime_format(_question.attr('usetime')));
			

			
			//试题后期处理
			__question_answer_end_click(_question, _answer);
			
			
		});
			
		//重点标记
		_questions.find(_objects.obj._q_btn_mark).click(function(){
			
			//当前试题
			var _question	= $(this).parents(_objects.obj._question);
			var _qid		= _question.attr('qid');
			
			var _btn		= $(this);
			var _btn_txt	= _btn.find(_objects.obj._q_btn_mark_txt);
			var _off		= (!_btn.hasClass('current')) ? 1 : 0;
			var _txt		= '重点标记';
			
			//客户端提前操作[可cookie记录]
			if(_off){
				_btn.addClass('current');
				_txt		= '已标记';
				
			}else{
				_btn.removeClass('current');
			}
			_btn_txt.html(_txt);
				
			//发回服务器
			var _data		= {paperid:_objects.paperid, getinfo:100, model:1, off:_off, qid:_qid};
			__ajax(_data, function(json){
				
				var _nums	= (json.nums < 0) ? 0 : json.nums;
				var _ntxt	= (_nums > 0) ? '('+_nums+'人)' : '';
				_btn_txt.html(_txt + _ntxt);
				
			}, function(json){
				
			});
			
		});
		
		//收藏
		_questions.find(_objects.obj._q_btn_collects).click(function(){
			
			//当前试题
			var _question	= $(this).parents(_objects.obj._question);
			var _qid		= _question.attr('qid');
			
			var _btn		= $(this);
			var _btn_txt	= _btn.find(_objects.obj._q_btn_coll_txt);
			var _off		= (!_btn.hasClass('current')) ? 1 : 0;
			var _txt		= '收藏';
			
			//客户端提前操作[可cookie记录]
			if(_off){
				_btn.addClass('current');
				_txt		= '已收藏';
				
			}else{
				_btn.removeClass('current');
			}
			_btn_txt.html(_txt);	
				
			//发回服务器
			var _data		= {paperid:_objects.paperid, getinfo:100, model:0, off:_off, qid:_qid};
			__ajax(_data, function(json){
				
				var _nums	= (json.nums < 0) ? 0 : json.nums;
				var _ntxt	= (_nums > 0) ? '('+_nums+'人)' : '';
				_btn_txt.html(_txt + _ntxt);
				
			}, function(json){
				
			});
		});
		
		
		//纠错
		_questions.find(_objects.obj._q_btn_sub_bug).click(function(){
			
			//当前试题
			var _question	= $(this).parents(_objects.obj._question);
			var _qid		= _question.attr('qid');
			
			var _datainfo	= _objects.app_paper_icos.info();
			var _fid		= _datainfo.fid;
			
			//var msg			= '【正在开发中】试题编号：' + _qid + ', 请告知详尽原因, 以便更快修复, 试卷编号：' + _fid;
			var _btn		= $(this);
			
			var _btn_txt	= _btn.find(_objects.obj._q_btn_bug_txt);
			var _off		= (!_btn.hasClass('current')) ? 1 : 0;
			var _txt		= '纠错';
			
			var _bugmsg		= _btn.attr('bugmsg');
			var d = dialog({
				id: 'id-bug-form',
				title: '反馈错误',
				padding:0,
				content: '<textarea id="js-q-bugmsg" placeholder="请详细描述,我们会最快修复,谢谢你哦..">' + ((_bugmsg) ? _bugmsg : '') + '</textarea>',
				okValue: '提交',
				onclose: function () {
					dialog.get('id-bug-form').close().remove();
				},
				ok: function () {
					
					var msg	= $('#js-q-bugmsg').val();
					if(msg == ''){
						
						var dd = dialog({
							content: '请详细描述,我们会最快修复,谢谢你哦..'
						});
						dd.show();
						setTimeout(function () {
							dd.close().remove();
						}, 2000);
						return false;	
					}
					_btn.attr('bugmsg', msg);
					
					
					//客户端提前操作[可cookie记录]
					if(_off){
						_btn.addClass('current');
						_txt		= '已反馈';
						
					}else{
						//_btn.removeClass('current');
						_txt		= '已反馈';
					}
					_btn_txt.html(_txt);
			
				
			
					//发回服务器
					var _data		= {paperid:_objects.paperid, getinfo:100, model:3, off:1, qid:_qid, msg:msg, err:1};
					__ajax(_data, function(json){
							
						//alert(json.info);
						
						//没有内容才更新'人数', 体验更好..
						var _nums	= (json.nums < 0) ? 0 : json.nums;
						var _ntxt	= (_nums > 0) ? '('+_nums+'人)' : '';
						_btn_txt.html(_txt + _ntxt);
						
						dialog.get('id-bug-form').close().remove();
							
					}, function(json){
						alert(json.info);
					});
						
					
					
					return false;
				}
			});
			d.showModal();
			
		});
		
		
		//查看资料
		_questions.find(_objects.obj._show_material).click(function(){
			
			var _btn		= $(this);
			
			//当前试题
			var _question	= $(this).parents(_objects.obj._question);
			var _materialid	= _btn.attr('materialid');
			var material	= $(_objects.obj._material_fix + _materialid)
			
			var d = dialog({
				title: '查看资料',
				content: material.html(),
				width:790,
				fixed: true,
				quickClose: true// 点击空白处快速关闭
			});
			d.showModal();
			
		});
		
		
		//解析部分
		__question_desc_event_init(_questions);
	}
	
	
	//解析
	function __question_desc_click(_desc){
		
		//当前试题
		var _question	= _desc.parents(_objects.obj._question);
			
		var _txt	= _question.find(_objects.obj._desc_off_txt);
		var _box	= _question.find(_objects.obj._desc_text_box);
		var _tab	= _question.find(_objects.obj._desc_tab_box);
			
		//展开
		if(!_desc.attr('off')){
			_desc.attr('off', 1).removeClass('open').addClass('close');
			_txt.html('收起解析');
			_box.show();
			_tab.show();
				
		//收缩	
		}else{
			_desc.removeAttr('off').removeClass('close').addClass('open');
			_txt.html('展开解析');
			_box.hide();
			_tab.hide();
		}	
	}
	
	
	//试题作答后续处理[练习模式,考试模式]
	function __question_answer_end_click(_question, _uanswer){
		
		//获得试题原始数据
		var _box	= _question.parents(_objects.obj._module);
		var _index	= _box.index();
		var _info	= __select_question_info(_index, _question);
		
		_question.attr('uanswer', _uanswer).attr('answer', _info.answer).attr('ajax', 0);
		
		
			
		//客户端缓存起来
		var _materid	= _question.attr('materialid');
		var _key		= _question.attr('qid') + '-q-' + _objects.paperid + ((_materid) ? _materid : 0);
		var _mcdata		= {uanswer:_uanswer, answer:_info.answer, usetime: _question.attr('usetime')};
			_utils.cache.set(_key, _mcdata);
		
		
		
		
		//试题编号
		var _number	= _question.find(_objects.obj._number);
		
		//标示答题卡
		var _icos	= _objects.app_paper_icos;
			_icos.mark(_number.html(), {count:$(_objects.obj._question + '[uanswer!=""]').size()});
			
		//更新模块进度	
		var _speed	= _box.find(_objects.obj._question + '[uanswer!=""]').size();
		_objects.app_paper_navs.update({speed:_speed}, _box.index());	
		
		
		//[练习模式]
		if(_objects.pagetype == 1){
			__question_answer_end_explain(_question, _uanswer, _number, _info);
		}
	}
	
	
	//练习模式
	function __question_answer_end_explain(_question, _uanswer, _number, _info){
		
		var _box	= _question.find(_objects.obj._question_notes);
		if(_box.size() > 0){ return false; }
		
		//标记工具
		_info.uanswer	= _uanswer;
		_info.notes		= _objects.app_paper_icos.get_notes(_question.attr('qid'));
		_question.append(template(_temp_question_notes, _info));
		
		//解析
		_question.append(template(_temp_question_desc, {info:_info}));
		
		//解析部分[初始化事件]
		__question_desc_event_init(_question);
	}
	
	
	//解析部分[初始化事件]
	function __question_desc_event_init(_root){
		
		//console.log('__question_desc_event_init');
		
		//解析点击事件
		var _desc_box	= _root.find(_objects.obj._desc_desc_box);
		var _desc_btn	= _desc_box.find(_objects.obj._desc_off_btn); 
			_desc_btn.click(function(){
				__question_desc_click($(this));
			});
		
		//笔记
		var _desc_notes	= _root.find(_objects.obj._q_inpt_notes); 
		_desc_notes.change(function(){
			$(this).attr('isupdate', 1);
		}).keyup(function(){
			$(this).attr('isupdate', 1);
		}).mouseleave(__save_question_notes).blur(__save_question_notes);	
		
		
		//本题疑难讨论, 其他用户的笔记
		var _tab	= _desc_box.find(_objects.obj._desc_tab_box);
		var _btns	= _tab.find(_objects.obj._desc_tab_btn);
			_btns.click(function(){
				
				var _question	= $(this).parents(_objects.obj._question);
				var _box		= _question.find(_objects.obj._desc_tab_boxs);
				var _btn		= _question.find(_objects.obj._desc_tab_btn);
				
				var _index 		= $(this).index();
					_btn.removeClass('current');
					$(this).addClass('current');
				
				var _tbox		= _box.eq(_index);
					_box.hide();
					_tbox.show();
				
				if(_index == 0){
					_question_description_tab_question(_tbox);
					
				}else{
					_question_description_tab_notes(_tbox);
				}
			});
			
			
			
		//加载疑难讨论
		_tab.mouseenter(function(){
			
			//加载试题疑问列表
			var _box		= $(this).find(_objects.obj._desc_tab_boxs).eq(0);
			_question_description_tab_question(_box);
			
		});	
		
		
		//发表疑难问题
		var _d_form	= _tab.find(_objects.obj._desc_form);
		_d_form.find(_objects.obj._desc_form_btn).click(function(){
			
			//获得表单
			var _question	= $(this).parents(_objects.obj._question);
			var _d_form		= _question.find(_objects.obj._desc_form);
			
			//收集数据
			var _nav		= _objects.app_paper_navs.getNav();
			var _navtext	= _nav.attr('navtitle');
			var _cateid		= _objects.app_paper_navs.getNavId(_navtext);
			var _hash		= _objects.ask_post_hash;
			var _detail		= _d_form.find(_objects.obj._desc_form_txt).val();
			if(!_detail){
				var d = dialog({
					fixed: true,
					content: '请输入问题标题..  @_@ ',
					quickClose: true// 点击空白处快速关闭
				});
				d.show();
				
				setTimeout(function () {
					d.close().remove();
				}, 2000);
				
				return;
			}
			
			//截取问题标题
			var _txt_length	= 39;
			var _content	= (_detail.length > _txt_length) ? _detail.substr(0, _txt_length) : _detail;
			
			//隐藏表单
			_d_form.hide();
			
			//显示动画
			var _loading	= _question.find('.js-loading-submit-ask');
				_loading.show();
			var _press		= _loading.find('.js-loading-press');
				_press.animate({width: '10%'}, 1000); 
				_press.stop(true, false).animate({width: '80%'}, 8000); 

			//发送请求
			var url			= '/ask/?/publish/ajax/publish_question/';
			var data		= {'question_content':_content, 'question_detail':_detail,'topics[]':_navtext,'category_id':_cateid,'post_hash':_hash};
			ajaxSend(url, data, function(json){
				
				//获得临时的来路验证字符串
				_read_post_hash_code();
				
				//***出错
				if(json.errno != 1){
					
					var d = dialog({
						fixed: true,
						content: json.err,
						quickClose: true// 点击空白处快速关闭
					});
					d.show();
					
					
					//还原界面
					_d_form.show();
					_loading.hide();
					_press.attr('width', '0px');
					
					return;
				}
				
				
				//***成功*** 改变动画提示
				_loading.find('.text').html('成功发表，正在邀请学霸们...');
				
				
				//ask问题主键
				var _askid		= json.rsm.url.substr(json.rsm.url.lastIndexOf('/') + 1);
				
				//试题编号
				var _qid		= _question.attr('qid');
				
				//母卷
				var _paperid	= _objects.app_paper_icos.info().fid;
				
				//发送请求
				var _data		= {askid:_askid, qid:_qid, upaperid:_objects.paperid, paperid:_paperid};
				__ajax(_data, function(qjson){
					
					//进度条加载完毕
					_press.stop(true, false).animate({width: '100%'}, 600, function(){
						
						var _htmldata	= {userlist:null, askurl:json.rsm.url, classname:qjson.classname, classid:_cateid};
						var _htmlstr	= template(_temp_desc_ask_list, _htmldata);		
						_loading.replaceWith(_htmlstr);
							
					});
					
				
				}, function(json){
					
					_d_form.show();
					_loading.hide();
					_press.attr('width', '0px');
				
					
				}, '/Paper/Answer/setAskQuestions');
				
				
					
			}, function(json){
				
				_d_form.show();
				_loading.hide();
				_press.attr('width', '0px');
				
			}, {ajaxurl:true});
			
			
		});
	}
	
	
	//加载试题[疑问列表]
	function _question_description_tab_question(_tbox){
			
		var _loading	= _tbox.find('.js-loading');
		if(_loading.size() == 0){
			return true;
		}
		_loading.show();
		
		
		//获得临时的来路验证字符串
		_read_post_hash_code();
		
			
		//显示加载动画
		var _press		= _loading.find('.js-loading-press');
			_press.animate({width: '10%'}, 1000); 
			_press.stop(true, false).animate({width: '70%'}, 4000); 
			
			
		//发回服务器
		var _url		= '/Paper/Answer/getAskQuestions';
		var _question	= _tbox.parents(_objects.obj._question);
		var _qid		= _question.attr('qid');
		var _data		= {qid:_qid};
		__ajax(_data, function(json){
					
			//进度条加载完毕
			_press.stop(true, false).animate({width: '100%'}, 600, function(){
						
				
				var _nav		= _objects.app_paper_navs.getNav();
				var _cateid		= _objects.app_paper_navs.getNavId(_nav.attr('navtitle'));
			
				var _htmldata	= {asklist:json.asklist, classid:_cateid};
				var _htmlstr	= template(_temp_question_list, _htmldata);
				
				_loading.replaceWith(_htmlstr);
					
			});
			
			
				
		}, function(json){
			
			/*var _htmlstr	= template(_temp_question_list, json);
					
			//进度条加载完毕
			_press.stop(true, false).animate({width: '100%'}, 600, function(){
						
				_loading.replaceWith(_htmlstr);
					
			});*/
			
		}, _url);
	}
	
	
	
	//获得临时的来路验证字符串
	function _read_post_hash_code(){
		
		//获得临时的来路验证字符串
		__ajax({key:Math.random(9999), 'domain':document.href}, function(json){
				
			//临时缓存
			_objects.ask_post_hash				= json.post_hash;
				
		}, null, '/ask/system/api.php?do=post_hash', {ajaxurl:true});	
		
	}
	
	
	//加载试题[其他用户笔记]
	function _question_description_tab_notes(_tbox){
		
		var _loading	= _tbox.find('.js-loading');
		if(_loading.size() == 0){
			return true;
		}
		_loading.show();
			
		//显示加载动画
		var _press		= _loading.find('.js-loading-press');
			_press.animate({width: '10%'}, 1000); 
			_press.stop(true, false).animate({width: '70%'}, 4000); 
			
			
		//发回服务器
		var _question	= _tbox.parents(_objects.obj._question);
		var _qid		= _question.attr('qid');
		var _url		= '/Paper/Answer/getList';
		var _data		= {model:2, qid:_qid};
		__ajax(_data, function(json){
				
					
			//进度条加载完毕
			_press.stop(true, false).animate({width: '100%'}, 600, function(){
						
				var _htmlstr	= template(_temp_desc_note_list, json);
					_loading.replaceWith(_htmlstr);
					
			});
					
		}, function(json){
			
			
			/*var _htmlstr	= template(_temp_desc_note_list, json);
					
			//进度条加载完毕
			_press.stop(true, false).animate({width: '100%'}, 600, function(){
						
				_loading.replaceWith(_htmlstr);
					
			});*/
			
			
			//alert(json.info);
		}, _url);
	}
	
	
	//保存笔记
	function __save_question_notes(){
		
		var isupdate	= $(this).attr('isupdate');
		if(!isupdate) return false;
		$(this).removeAttr('isupdate');
			
			
		//当前试题
		var _question	= $(this).parents(_objects.obj._question);
		var _qid		= _question.attr('qid');
			
		var okval		= $.trim(_question.find(_objects.obj._q_ans_ok).text());
		var meval		= $.trim(_question.find(_objects.obj._q_ans_me).text());
			
		var msg			= $(this).val();
		var err			= (okval.toUpperCase() == meval.toUpperCase()) ? 0 : 1;
			
		//发回服务器
		var _data		= {paperid:_objects.paperid, getinfo:100, model:2, off:1, qid:_qid, msg:msg, err:err};
		__ajax(_data, function(json){
				
			//alert(json.info);
			/*var _nums	= (json.nums < 0) ? 0 : json.nums;
			var _ntxt	= (_nums > 0) ? '('+_nums+'人)' : '';
			_btn_txt.html(_txt + _ntxt);*/
				
		}, function(json){
			alert(json.info);
		});
	}
	
	
	//查找试题原始数据
	function __select_question_info(_index, _question){
		
		var _list	= _objects.dataview[_index];
		
		//遍历
		var _qid	= _question.attr('qid'), _sonindex = _question.attr('sonindex');
		for(var q in _list){
			
			//客观题
			if(_sonindex === undefined){
				if(_qid == _list[q].qid) return _list[q].info;
			
			
			//资料题
			}else{
				var _sonlist	= _list[q].sonlist;
				for(var s in _sonlist){
					if(_qid == _sonlist[s].info.qid) return _sonlist[s].info;
				}
			}
		}
		
		return false;
	}
	
	
	/**
	 * 请求答题卡数据
	 *
	 * @param  json    config   参数配置
	 * @param  func    callback 成功执行函数
	 * @param  func    error    失败执行函数
	 * @param  json    params   附加参数
	 *     
	 */
	function __ajax(data, callback, error, url, params){
			
		//请求地址
		var url			= (url) ? url : '/Paper/Answer/Index';
		_utils.ajax.post(url, data, function(json){
				
			//失败直接返回
			if(json.status == 0){
				if(error) error(json);
				return;
			}
			
			callback(json);
				
		}, error, params);
	}
	

	
	/**
	 * 分模块(注册/挂载)
	 *
	 * 应该统一到 paper命名空间下(暂简单处理)
	 * 
	 */
	_lib.extend('question', {
		
		
		//初始化[注入引用对象]
		create : function(config){
			
			_objects.app_paper_icos			= _lib.icos;
			_objects.app_paper_navs			= _lib.navs;
			_objects.pagetype				= config.pagetype;
			_objects.paperid				= config.paperid;
			
			return this;
		},
		
		//初始化[试题绑定事件]
		init : function(_box, _data){
			
			var obj							= __getobject();
			_objects.obj					= obj;
			
			//缓存试题原始数据
			if(!_objects.dataview)			  _objects.dataview = {};
			_objects.dataview[_data.index]	= _data.dataview;
			
			//查找当前试题列表
			_objects.questions				= _box.find(obj._question);
			
			//开始初始化
			__init();
			
			return this;
		},
		
		//只看错题
		showtype : function(_type, _index){
			
			var _box	= $(_objects.obj._module);
			var _qlist	= _box.eq(_index).find(_objects.obj._question);
			
			if(_type == 'all'){
				_qlist.show();
				return;	
			}
			
			
			//遍历[查找错题]
			_qlist.each(function(){
				
				var _question	= $(this);
				var okval		= $.trim(_question.find(_objects.obj._q_ans_ok).text());
				var meval		= $.trim(_question.find(_objects.obj._q_ans_me).text());
				var err			= (okval.toUpperCase() == meval.toUpperCase()) ? 0 : 1;
				
				if(err == 0){
					_question.hide();
				}
			});
		}
	});
	
	



})(window.jQuery, window);