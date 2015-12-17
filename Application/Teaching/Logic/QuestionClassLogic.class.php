<?php
namespace Teaching\Logic;
use Think\Model;
class QuestionClassLogic extends Model {
	private		$_cacheKey = 'question-class-list';
	
	/**
	 * 查询知识点分类[三级树]
	 *
	 * @param   tops	array    知识点主键[可选]
	 * @param   $lever  int      层级
	 * @param   array 
	 */
	public function getTree($tops = array(), $lever = 1){
		
		$cls_list			= S($this->_cacheKey);
		if(!$cls_list || true){
			
			//实例化模型
			$cls			= D('QuestionClass');
			
			//第一级
			$cls_list		= $cls->where('status = 1 AND topid = 0')->order('rank asc')->select();
			foreach($cls_list as $key=>$val){
				
				//第二级
				$son_list	= $cls->where('status = 1 AND topid = ' . $val['id'])->order('rank asc')->select();	
				foreach($son_list as $k=>$v){
					
					//第三级
					$son1_list	= $cls->where('status = 1 AND topid = ' . $v['id'])->order('rank asc')->select();
					foreach($son1_list as $k1=>$v1){
					
						//第四级
						$son2_list	= $cls->where('status = 1 AND topid = ' . $v1['id'])->order('rank asc')->select();	
						$son1_list[$k1]['list']	= $son2_list;
					}
						
					$son_list[$k]['list']	= $son1_list;
				}
				
				$cls_list[$key]['list']	= $son_list;
			}
			
			//更新缓存
			S($this->_cacheKey, $cls_list);
		}
		
		
		//如果有指定知识点
		if(is_array($tops) && count($tops) > 0 || is_numeric($tops)){
			
			if(is_numeric($tops)) $tops = array($tops);
			
			//开始查找
			$sel_list	= array();
			foreach($cls_list as $k=>$v){
				
				//第一级
				if($lever == 1){
					if(in_array($v['id'], $tops)) $sel_list[] = $v;
				
				//第二级
				}else{
					foreach($v['list'] as $key=>$val){
						if(in_array($val['id'], $tops)) $sel_list[] = $val;
					}	
				}
			}	
			
			if(count($tops) > 0) $cls_list = $sel_list;
		}
		
		//返回全树
		return $cls_list;
	}
}