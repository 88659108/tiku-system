var app_paper_icos	= (function($){
	
	//缓存引用
	var _objects	= {};
	
	//组件引用(HTML节点)
	function __getobject(){
		return {
			paper_icos		: $('.js-paper-icos'),
			paperspeed		: $('#js-paper-speed'),
			off_icos		: $('.js-dtk-switch'),
			off_ico			: '.js-dtk-ico',
			_a				: 'a'
		};
	}
		
	//答题卡模板
	var _temp_name 	= 'tp-question-ico';
	
	/**
	 * 创建答题卡[做题页,回顾页]
	 *
	 * @param   json    dataview       试卷
	 
	 * @param   config
	 * @        int  pagetype       页面场景[0:做题页, 1:回顾页]
	 */
	function create_paper_nav_icos(dataview, config){
		
		var list = dataview.item, navs = dataview.navs, index 	= 0, htmlstr = [];
		for(var k = 0 in navs){
			
			//获得分组试题[兼容先后顺序自定义]
			var key		= navs[k].key, qids = list[key];
			
			//题型模块 
			config.key	= key;
			for(var j = 0 in qids){
				
				//客观题
				if(!qids[j].son){
					index++;
					htmlstr.push(html_tp_qico(qids[j], index, config));
					continue;
				}
				
				//资料题
				for(var si = 0; si < qids[j].son; si++){
					index++;
					qids[j].sonindex	= si;
					htmlstr.push(html_tp_qico(qids[j], index, config));	
				}		
			}
		}
		
		return htmlstr;
	}	
	
	
	/**
	 * 答题卡[结构]
	 *
	 * @param   object   qinfo       试题数据{json}
	 * @param   int      index       题卡编号
	 * @param   json     config      配置项
	 */
	function html_tp_qico(qinfo, index, config){
		
		//题卡状态
		qinfo.status			= 0;
		
		/**
		 * 客观题[局部结构]
		 *
		 * {"qid":"1603", "answer":"C", "uanswer":"D"}
		 */
		if(!qinfo.son){
			
			if(qinfo.uanswer){
				qinfo.status	= (qinfo.answer == qinfo.uanswer) ? 1 : -1;
			}
			
		
		/**
		 * 资料题[局部结构]
		 *
		 * {"qid":"1603", "son":"5", "sonlist":{"0":{"qid":"28693", "answer":"C", "uanswer":"D"}, "3":{"qid":"28696", "answer":"B", "uanswer":"B"}}
		 */
		}else if(qinfo['sonlist']){
			
			//子题作答列表[通过索引获得子题明细]
			var	sonlist	= qinfo.sonlist, soninfo = sonlist[qinfo.sonindex];
			if(!soninfo) soninfo = {};
			
			if(soninfo.uanswer){
				qinfo.status	= (soninfo.answer == soninfo.uanswer) ? 1 : -1;
				qinfo.soninfo	= soninfo;
			}
		}
		
		
		//模板引擎 **注册变量
		config.qinfo			= qinfo;
		config.number			= index;
		config.mod				= (index % 10 == 0) ? 1 : 0;
		var htmstr 				= template(_temp_name, config);
		
		//试题结构[html]
		return htmstr;
	}
	
	
	/**
	 * 请求答题卡数据
	 *
	 * @param  json    config   参数配置
	 * @param  func    callback 成功执行函数
	 * @param  func    error    失败执行函数
	 *     
	 */
	function __ajax(config, callback, error){
			
		//请求地址
		var url		= '/Paper/Answer/Index';
		window.ajaxSend(url, {paperid:config.paperid, getinfo:1}, function(json){
				
			//失败直接返回
			if(json.status == 0){
				if(error) error(json);
				return;
			}
				
			//使用前转换
			var dataview	= $.parseJSON(json.upinfo.dataview);
				
			//创建答题卡[HTML]
			var	htmlstr		= create_paper_nav_icos(dataview, config);
			callback(json, htmlstr);
				
		}, error);
			
		return this;
	}
	
	
	//答题卡[展开/收缩]
	function __paper_dtk_off_click(){
		
		var _btn	= _objects.obj.off_icos;
		var _box	= _objects.obj.paper_icos;
		var _ico	= _btn.find(_objects.obj.off_ico);
		var _cookie	= 'paper-icos-btn-' + _objects.paperid;
		
		//第一次使用，默认展开
		if(!$.cookie(_cookie)){
			_btn.attr('name',1);
			_box.slideDown(400);
			_ico.html('↓');
			
			
			//2秒后自动跳转
			var _out	= setTimeout(function(){
				_btn.removeAttr('name');
				_box.slideUp("slow");
				_ico.html('↑');
			}, 2000);
		}
		
		//点击切换
		_btn.click(function(){
			
			//标记点过
			$.cookie(_cookie, 1);
			
			//展开
			if(!_btn.attr('name')){
				_btn.attr('name',1);
				_box.slideDown("slow");
				_ico.html('↓');
			
			//收缩	
			}else {
				_btn.removeAttr('name');
				_box.slideUp("slow");
				_ico.html('↑');
			}
		});
	}

	/**
	 * 公开接口
	 */
	return {
		
		/**
		 * 创建答题卡
		 *
		 * @param  json    config   参数配置  
		 */
		create : function(config){
			
			var obj					= __getobject();
			_objects.obj			= obj;
			_objects.paperid		= config.paperid;
			_objects.app_paper_navs	= config.app_paper_navs;
			_objects.pagetype		= config.pagetype;
			
			__ajax(config, function(json, htmlstr){
				
				//创建html
				obj.paper_icos.html(htmlstr);		
				
				//缓存数据(重点标记)
				if(json.upinfo.marks){
					_objects.marks		= json.upinfo.marks.split(',');
				}
				
				//缓存数据(收藏)
				if(json.upinfo.collects){
					_objects.collects	= json.upinfo.collects.split(',');
				}
				
				//缓存数据(笔记)
				if(json.upinfo.notes){
					_objects.notes	= $.parseJSON(json.upinfo.notes);
				}
				
				//缓存数据(纠错)
				if(json.upinfo.bugs){
					_objects.bugs	= $.parseJSON(json.upinfo.bugs);
				}
				
				
				//点击答题卡[编号]
				var _ico		= _objects.obj.paper_icos.find(_objects.obj._a);
					_ico.click(function(){
						
						$(this).addClass('current').siblings().removeClass('current');
						
						var _index	= $(this).attr('key');
						var _number	= $(this).attr('number');
						_objects.app_paper_navs.start(_index, {goto_number:function(_box){
							
							//获得试题
							var _question	= _objects.app_paper_navs.getQuestion(_box, _number);
							var _prevlist	= _question.prevAll();
							
							//滑动到试题
							var _scroll	= Number(_question.offset().top) - 127;
							$("html,body").animate({scrollTop:_scroll}, 400);
							
						}});	
					});
						
				
			}, function(json){ alert(json.info); });
			
			
			//答题卡[展开/收缩]
			__paper_dtk_off_click();
			
			return this;
		},
		
		//标记试题卡
		mark : function(_number, _data){
			
			//标记作答信息
			//统计进度
			var _paperspeed	= _objects.obj.paperspeed;
			var _paper_icos	= _objects.obj.paper_icos;
			
			//标记
			var _ico		= _paper_icos.find(_objects.obj._a + '[number="'+ _number +'"]');
				_ico.addClass('green');
				
			
			//滑动到下一道试题
			var _iconext	= _paper_icos.find(_objects.obj._a + '[number="'+ (Number(_number) + 1) +'"]');	
				if (_iconext && _objects.pagetype == 0) _iconext.click();
			
			//统计进度	
			//var _speed		= Number(_paperspeed.html()) - 1;
			var _speed		= Number(_paperspeed.attr('qnums')) - _data.count;
				_paperspeed.html(_speed);	
		},
		
		//检查试题是否“重点标记”
		is_mark : function(qid){
			return ($.inArray(qid, _objects.marks) > -1) ? 1 : 0;
		},
		
		//检查试题是否“收藏”
		is_coll : function(qid){
			return ($.inArray(qid, _objects.collects) > -1) ? 1 : 0;
		},
		
		//获得笔记
		get_notes:function(qid){
			return (_objects.notes) ? _objects.notes[qid] : false;	
		},
		
		//获得纠错
		get_bugs:function(qid){
			return (_objects.bugs) ? _objects.bugs[qid] : false;	
		},
		
		//统计进度
		info : function(){
			
			var _paperspeed	= _objects.obj.paperspeed;
			var _speeds		= Number(_paperspeed.html());
			var _speed		= Number(_paperspeed.attr('qnums')) - _speeds;
			
			var _fid		= _objects.obj.paperspeed.attr('fid');
			
			return {
				speed  : _speed,
				_speeds: _speeds,
				fid		: _fid
				
			};
		}
		
	};

})(window.jQuery);