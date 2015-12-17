<?php
namespace Paper\Logic;
class BuildPaperLogic{
	
	/**
	 * 生产[动态卷规则]
	 */
	public function buildChangeCode(){
		
		
		$datacode	= '{"info":{"qnums":100},"navs":[

{"title":"综合训练",
"select":{"nums":25,"score":2, "where":[{"source":[["qyear","2014",">"], ["errnums","5","desc"]], "nums":10,"score":1},
								   {"error":[["errnums","1",">"]], "nums":15,"score":1}]}},

{"title":"判断推理之平面遍历",
"select":{"nums":25,"score":1, "where":[{"source":[["bigtype","3"], ["notes","5","desc"]], "nums":10},
								   {"error":[["pointtype","138"]], "nums":15}]}},

{"title":"数量关系之浓度问题",
"select":{"nums":30,"score":1, "where":[{"source":[["pointtype","85"], ["notes","5","desc"]], "nums":30}]}}

]}';
		
		
		
		
		
	}
	
	
	
	
	/**
	 * 生产[固定卷规则]
	 *
	 * @param   string   $changecode    动态卷规则
	 * @param   int      $userpars		用户抽题干预参数 
	 									> $userid  用户主键[分表位置]
										> $select  查询控制 0所有, 1自己
	 * @param	array
	 */
	public function buildDataView($changecode, $userpars){
		
		$dataview		= json_decode($changecode, true);
		if(!$dataview) return false;
		
		$pdata			= array();
		$pdata['info']	= $dataview['info'];
		
		$navs			= array();
		$item			= array();
		$qnums			= 0;
		foreach($dataview['navs'] as $key=>$val){
			
			if(!$val['select']['where']){
				return array('msg'=>'该模块：没有指明试题查询条件!', 'navs'=>$val);
			};
			
			//{"title":"\u5e38\u8bc6\u5224\u65ad","nums":"25","key":"0","subitem":[{"nums":25,"score":0.6}]}
			$nvrow			= array();
			$nvrow['title']	= $val['title'];
			$nvrow['nums']	= intval($val['select']['nums']);
			$nvrow['key']	= $key;
			$qnums		   += $nvrow['nums'];
			
			
			//打分项
			$subitem		= array();
			$nvqnums		= 0;
			foreach($val['select']['where'] as $k=>$v){
				
				//累加查询试题数目
				$nvqnums   += intval($v['nums']);
				
				//验证打分项
				$score		= ($v['score']) ? $v['score'] : $val['select']['score'];
				if(!$score){  return array('msg'=>'打分项为空!', 'navs'=>$val); }
				$subitem[]	= array('nums'=>$v['nums'], 'score'=>$score);
			}
			
			//验证该模块[题数]合法
			if($nvrow['nums'] != $nvqnums){
				return array('msg'=>'该模块：查询试题数目(where:'.$nvqnums.') 与 要求总数('.$nvrow['nums'].')不相等!', 'navs'=>$val);
			}
			
			$nvrow['subitem']	= $subitem;
			$navs[]				= $nvrow;
			
			//根据指定条件 **执行查询
			$results			= $this->selectQuestionEngine($val, $userpars);
			$qlist				= $results['qlist'];
			$qmsg				= $results['msg'];
			
			//验证该模块[查询题数]合法
			if(count($qlist) != $nvqnums){
				return array('msg'=>'该模块：没有达到试题查询数目('.$nvqnums.')!', 'navs'=>$val);
			}
			
			//试题入卷
			$item[]				= $qlist;
		}
		
		//整卷
		$pdata['navs']			= $navs;
		$pdata['item']			= $item;
		$pdata['info']['qnums']	= $qnums;
		$paperjson				= json_encode($pdata);
		
		//返回结果
		return array('result'=>1, 'paperjson'=>$paperjson);
	}
	
	
	
	
	
	/**
	 * 试题查询引擎
	 *
	 * @param   array    $nav    		查询条件
	 * @param   int      $userpars		用户抽题干预参数 如：用户主键[分表位置]
	 * @param   array
	 */
	public function selectQuestionEngine($nav, $userpars){
		

		 
		$data			= array();
		$data['qlist']	= array();
		$data['msg']	= '';
		
		foreach($nav['select']['where'] as $key=>$val){
			
			//查询真题
			if($val['source']){ $qlist	= $this->selectSourceQuestion($val); }
			
			//查询错题集
			if($val['error']){ $qlist	= $this->selectErrorQuestion($val, $userpars); }
			
			//验证合法[查询题数]
			if(count($qlist) != intval($val['nums'])){
				$data['msg']	= '该次查询题数，不满足要求('.$limit.')';
				return $data;
			}
			
			//添加到试题池
			foreach($qlist as $k=>$qid){
				$data['qlist'][]	= array('qid'=>$qid);
			}
		}
		
		//返回结果
		return $data;
	}
	
	
	/**
	 * 从真题库查询试题集合
	 *
	 * @param   array   $param    查询条件
	 * @return  array
	 *
	 */
	private function selectSourceQuestion($param){
		
		/**
		 * 
		 * {"source":[["qyear","2014",">"], ["errnums","5","desc"]], "nums":10,"score":1}
		 *
		 */
		 
		//解析 **获得查询字符串
		$sqlpars		= $this->selectSqlFactory($param, 'source');
		
		//执行查询
		$question		= D('Teaching/Question');
		$qids			= $question->where($sqlpars['where'])
								   ->order($sqlpars['order'])
								   ->cache('build-select-source-' . md5($sqlpars['where']), 3600 * 12)
								   ->getField('sourceid', true);
				   
		//从查询结果集 **随机抽选
		return $this->randomFilter($qids, intval($param['nums']));
	}
	
	
	/**
	 * 从错题集查询试题集合
	 *
	 * @param   array   $param    	查询条件
	 * @param   int     $userpars	用户抽题干预参数 如：用户主键[分表位置]
	 * @return  array
	 *
	 */
	private function selectErrorQuestion($param, $userpars){
		
		/**
		 * 
		 * {"error":[["errnums","1",">"]], "nums":15,"score":1}
		 *
		 */
		 
		$userid			= intval($userpars['userid']);
		$select			= intval($userpars['select']);
		 
		//解析 **获得查询字符串
		if($select == 1){ $param['error'][]	= array('userid', $userid);	}
		$sqlpars		= $this->selectSqlFactory($param, 'error');
		
		//执行查询
		$question		= D('UserErrQuestion')->table($userid);
		$qids			= $question->where($sqlpars['where'])
								   ->order($sqlpars['order'])
								   ->cache('build-select-error-' . md5($sqlpars['where']), 3600 * 12)
								   ->getField('qid', true); 
								   
		//从查询结果集 **随机抽选
		return $this->randomFilter($qids, intval($param['nums']));
	}
	
	
	
	/**
	 * 根据查询数组，解析出相应查询语句(sql)
	 *
	 * @param   array   $param    查询条件
	 * @param   string  $mode     查询模式[source,error,material]
	 * @return  array
	 *
	 */
	private function selectSqlFactory($param, $mode){
		
		/**
		 * 查询规则
		 *
		 {	"title":"综合训练","select":{"nums":25,"score":2, 
			"where":[{"source":[["qyear","2014",">"], ["errnums","5","desc"]], "nums":10,"score":1},
					 {"error":[["errnums","1",">"]], "nums":15,"score":1}]}},
		 */
		
		$sqlbox		= array();
		$orders		= array();
		foreach($param[$mode] as $key=>$val){
			
			//链接表达式
			$exp	= strtolower($val[2]);
			
			//特殊处理
			if(in_array($exp, array('desc'))){
				
				//作为排序
				if($exp == 'desc'){
					$orders[]	= $val[0] . ' ' . strtoupper($exp);
				}
				
			
			//直接拼接	
			}else{
				$exp		= ($val[2]) ? $val[2] : '=';
				$value		= (is_numeric($val[1])) ? intval($val[1]) : "'".trim($val[1])."'";
				
				$where		= $val[0] . $exp . $value;	
				$sqlbox[]	= $where;
			}
		}
		
		//整理并返回结果
		$pars			= array();
		$pars['where']	= implode(' AND ', $sqlbox);
		$pars['order']	= implode(', ', $orders);
		
		return $pars;
	}
	
	
	
	
	/**
	 * 从数组中随机抽选相应数量值
	 *
	 * @param   array   $ids    数组集合
	 * @param   int     $nums   需要抽选的数量
	 * @return  array
	 *
	 */
	public function randomFilter($ids, $nums){
		
		$values	= array();
		$max	= count($ids) - 1;
		
		for($i=1; $i<=$nums; $i++){
			$index		= mt_rand(0, $max);
			$values[]	= $ids[$index];	
		}
		
		return $values;
	}	
}