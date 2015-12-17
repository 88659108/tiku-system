var app_paper_navs 	= (function($){
	
	//缓存引用
	var _objects	= {};
	
	//组件引用(HTML节点)
	function __getobject(){
		return {
			paper_navs		: $('#js-paper-navs li'),
			paper_boxs		: $('.js-question-module'),
			_loading		: '.js-loading-nav-box',
			_question		: '.js-question',
			_papertime		: '.js-paper-usetime',
			_nums			: '.js-nav-nums',
			_speed			: '.js-nav-speed',
			_press			: '.js-loading-press',
			
			
			//定时保存时间[毫秒]
			_savetime		: 15000
		};
	}
	
	//标记需要保存的试题[属性查找的表达式]
	var _sendsave		= '[ajax]';
	
	//试题模板[客观题]
	var _temp_objective	= 'tp-objective-question';
	
	//试题模板[资料]
	var _temp_material	= 'tp-material-question';
	
	/**
	 * 点击事件[navs]
	 */
	function __navs_click(){
		
		__create($(this).index());
		
		
		if(_objects.pagetype == 1){
			var _showtype	= $(this).attr('show-list');
			if(!_showtype) _showtype = 'all';
			
			_objects.app_paper_time.showtype(__get_showtype_text(_showtype), _showtype);
			_objects.app_paper_question.showtype(_showtype, _objects.index);
		}
	}
	
	
	
	/**
	 * 创建试题集(内存)
	 */
	function __htmlstr_questions(dataview, index){
		
		var _number		= __getNavNumber(index), _htmlstr	= [];
		
		//给模板引擎扩展方法
		template.helper('trim', function (value){ return $.trim(value);});
		template.config('escape', false);
		
		for(var q in dataview){
			
			//客观题
			if(!dataview[q].son){
				_number++;
				_htmlstr.push(__htmlstr_objective(dataview[q], _number));
				continue;
			}
			
			//资料题
			_htmlstr.push(__htmlstr_material(dataview[q], _number));
			_number		+= Number(dataview[q].son);
		}
		
		return _htmlstr.join('');
	}
	
	
	//创建客观题
	function __htmlstr_objective(data, _number){
		
		//注册变量
		data.number				= _number;
		data.info.options		= $.parseJSON(data.info.options);
		data.info.pagetype		= _objects.pagetype;
		//data.info.usetime		= __usetime_format(data.usetime);
		data.info.ismark		= _objects.app_paper_icos.is_mark(data.info.qid);
		data.info.iscoll		= _objects.app_paper_icos.is_coll(data.info.qid);
		data.info.isbugs		= _objects.app_paper_icos.get_bugs(data.info.qid);
		data.info.usetime		= _objects.app_paper_time.format(data.usetime, {msgstr:'用时：', format:'mm分ss秒'});
		data.notes				= _objects.app_paper_icos.get_notes(data.info.qid);
		
		return  template(_temp_objective, data);
	}
	
	
	//创建客观题[标记工具]
	function __htmlstr_objective_notes(data, _number){
		
		
		
	}
	
	
	//创建资料题[含子题列表]
	function __htmlstr_material(data, _number){
		
		var _htmlstr			= [];
			_htmlstr.push(template(_temp_material, data));
		
		//子题列表
		var _sonlist			= data.sonlist;
		for(var q in _sonlist){
			_number++;
			
			//一道子题[客观题]
			var _info			= _sonlist[q];
				_info.materialid= data.qid;
				_info.sonindex	= q;
				_htmlstr.push(__htmlstr_objective(_info, _number));
		}
		
		return _htmlstr.join('');
	}
	
	
	/**
	 * 创建试题集(HTML)
	 */
	function __create_tohtml_questions(htmlstr, _box, _data){
		
		
		//内容写入
		_box.html(htmlstr);
		
		//跳转到指定试题
		if(_data.fade) _data.fade.goto_number(_box);
		
		//初始化试题[事件]
		_objects.app_paper_question.init(_box, _data);
	}
	
	
	/**
	 * 创建当前模块
	 */
	function __create(index, fade){
		
		//当前索引
		_objects.index	= index;
		
		
		var _nav		= _objects.obj.paper_navs.eq(index);
			_nav.addClass('current').siblings().removeClass('current');
			if(_objects.pagetype == 0){ _objects.app_paper_time.change(); }
		
		//当前模块试题容器
		var _box		= _objects.obj.paper_boxs.eq(index);
		var _loading	= _box.find(_objects.obj._loading);
		
		//不存在loading, 则表示可以直接显示
		var _iscreate	= _loading.size();
		if(_iscreate == 0){
			_objects.obj.paper_boxs.hide();
			_box.show();
			if(fade) fade.goto_number(_box);
			return true;
		}
		
		
		//滚动条回归最上面
		$("html,body").animate({scrollTop:0}, 10);
		
		//使用试卷内部索引[能兼容按钮顺序调整]
		var _nav		= _objects.navs.eq(index);
		var _model		= _nav.attr('key');
		
		//显示loading..
		_objects.obj.paper_boxs.hide(); _box.show();
		
		//显示加载动画
		var _press		= _loading.find(_objects.obj._press);
			_press.animate({width: '10%'}, 1000); 
			_press.stop(true, false).animate({width: '70%'}, 4000); 
		
		//从服务器加载[当前模块]
		__ajax({paperid:_objects.paperid, model:_model}, function(json){
			
			//创建结构(内存)
			var _htmlstr		= __htmlstr_questions(json.dataview, index);
				
			//进度条加载完毕
			_press.stop(true, false).animate({width: '100%'}, 600, function(){
					
				//写入结构,开始做题
				__create_tohtml_questions(_htmlstr, _box, {dataview:json.dataview, index:index, fade:fade});
					
			}); 
			
		}, function(){});
	}
	
	
	/**
	 * 查找当前nav,获得试题起始编号
	 */
	function __getNavNumber(index){
		
		var _number		 = 0;
		_objects.navs.slice(0, index).each(function(){
			
			//累加
			var _num	 = Number($(this).find(_objects.obj._nums).text());
				_number += _num;
		});
		
		return _number;
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
		ajaxSend(url, {paperid:data.paperid, model:data.model, getinfo:2}, function(json){
				
			//失败直接返回
			if(json.status == 0){
				if(error) error(json);
				return;
			}
			
			callback(json);
				
		}, error);
	}
	
	
	//定时器[保存试卷作答数据]
	function __setinterval_save_paper_answer(){
		
		_objects.int_saveanswer	= setInterval(function(){
				
			__save_paper_answer();
			
		}, _objects.obj._savetime);
	}
	
	
	//保存试卷作答数据[整卷]
	function __save_paper_answer(_callback){
		
		//整卷作答
		var _datainfo	= __paper_question_answer();
		
		//试卷作答数据
		var _paperdata	= _datainfo.data;
		
		//本次提交答案数量
		var _count		= _datainfo.count;
		
		//请求地址
		var url			= '/Paper/Answer/Index';
		ajaxSend(url, {paperid:_objects.paperid, paperdata:JSON.stringify(_paperdata), getinfo:3}, function(json){
			
			//失败直接返回
			if(json.status == 0) return;
			
			//清理已经保存的答案[防止重复提交]
			var _list	= $(_objects.obj._question + _sendsave);
				_list.removeAttr('ajax');
				//.removeAttr('uanswer').removeAttr('usetime').removeAttr('answer');
				
			//回调操作
			if(_callback) _callback(json, _count);
				
		}, function(json){
			
			//回调操作
			if(_callback) _callback(json, _count);
		});
	}
	
	
	//获得试卷作答数据[整卷]
	function __paper_question_answer(){
		
		var _navs	= _objects.obj.paper_navs;
		var _boxs	= _objects.obj.paper_boxs;
		
		//遍历各模块
		var _item	= {}, _info = [], _count = 0;
		_navs.each(function(){
			
			//模块数据
			var _key	= $(this).attr('key');
			var _use	= ($(this).attr('usetime')) ? $(this).attr('usetime') : 0;
			var _speed	= $(this).find(_objects.obj._speed).html();
			_info.push({"key":_key, "usetime":_use, "speed":_speed});
			
			//试题答案
			_item[_key]	= __module_question_answer($(this).index());
			_count	   += _item[_key].length;
		});
		
		//试卷总用时
		var _papertime	= $(_objects.obj._papertime).attr('usetime');
		
		//试卷进度
		var _speed		= _objects.app_paper_icos.info().speed;
		
		//整卷作答数据
		var _data		= {"navs":_info, "item":_item, "papertime":_papertime, "speed":_speed, "upaperid":_objects.paperid};
		
		var _info		= {count:_count};
		return {data:_data, info:_info}
	}
	
	
	//获得作答数据[某个模块]
	function __module_question_answer(_index){
		
		//当前模块
		var _qbox	= _objects.obj.paper_boxs.eq(_index);
		var _list	= _qbox.find(_objects.obj._question + _sendsave);
		
		//遍历试题
		var _qlist	= [];
		_list.each(function(){
			
			//试题答案
			var _ans	= {};
				_ans.qid		= $(this).attr('qid');
				_ans.usetime	= ($(this).attr('usetime')) ? $(this).attr('usetime') : 0;
				_ans.uanswer	= $(this).attr('uanswer');
				_ans.answer		= $(this).attr('answer');
			
			//资料题[子题]
			if($(this).attr('materialid')){
				_ans.qid		= $(this).attr('materialid');
				_ans.sonqid		= $(this).attr('qid');
				_ans.sonindex	= $(this).attr('sonindex');	
			}
			
			_qlist.push(_ans);
		});
		
		return _qlist;
	}
	
	
	function __get_showtype_text(_type){
		return (_type == 'err') ? '对错全看' : '只看错题';	
	}
	

	/**
	 * 公开接口
	 */
	return {
		
		create  : function(config){
			
			var obj						= __getobject();
			
			//缓存
			_objects.obj				= obj;
			_objects.paperid			= config.paperid;
			_objects.pagetype			= config.pagetype;
			_objects.app_paper_time		= config.app_paper_time;
			_objects.app_paper_question	= config.app_paper_question;
			_objects.app_paper_icos		= config.app_paper_icos;
			_objects.navs				= _objects.obj.paper_navs;
			
			//点击事件
			_objects.navs.click(__navs_click);
			
			
			//格式化[时间撮]
			_objects.navs.each(function(){
				
				var _usetime	= $(this).attr('usetime');
				var _title		= _objects.app_paper_time.format(_usetime);
				$(this).attr('title', _title);
				
			});
			
			
			//启动定时保存试卷
			__setinterval_save_paper_answer();
			
			return this;
		},
		
		
		start : function(index, fade){
			
			__create(index, fade);
			return this;
		},
		
		
		//保存作答数据[整卷]
		saveanswer: function(_callback){
			__save_paper_answer(_callback);
		},
		
		
		//更新模块信息
		update : function(_config, _index){
			
			var _nav		= _objects.obj.paper_navs.eq(_index);
			
			if(!_config.exetype){
				_nav.find(_objects.obj._speed).html(_config.speed);
			
			//只看错题
			}else if(_config.exetype == 'err'){
				_nav.attr('show-list', 'err');
				
			//对错全看
			}else if(_config.exetype == 'all'){
				_nav.attr('show-list', 'all');
			}	
		},
		
		
		//获得当前模块
		getNav : function(){
			
			var _index	= _objects.index;
			var _nav	= _objects.obj.paper_navs.eq(_index);
			
			return _nav;
		},
		
		//根据编号获得试题
		getQuestion : function(_box, _number){
			
			var _question = _box.find(".js-number:contains('"+_number+"')").map(function(){ 
				if ($(this).text() == _number) { return this; } 
			}).parents(_objects.obj._question);
			
			return _question;
		},
		
		/**
		 * 获得大分类的编号
		 */
		getNavId : function(_navtitle){
			
			var _id	= 0;
			if(!_navtitle) return _id;
			
			switch($.trim(_navtitle)){
				
				case '言语理解与表达':
				  _id	= 1;
				  break;
				  
				case '数量关系':
				  _id	= 2;
				  break;
				  
				case '判断推理':
				  _id	= 3;
				  break;
				  
				case '资料分析':
				  _id	= 4;
				  break;
				  
				case '常识判断':
				  _id	= 5;
				  break;
			}	
			
			return _id;
		}
	}

})(window.jQuery);