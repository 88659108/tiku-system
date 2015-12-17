<?php
namespace Admin\Model;
use Think\Model;
class QuestionClassModel extends Model {
	protected 	$tableName = 'question_class';
	private		$_cacheKey = 'question-class-list';
	
	
	/**
	 * 查询知识点分类[三级树]
	 *
	 * @param   topid	int    知识点主键[可选]
	 * @param   array 
	 */
	public function getTree($topid = 0, $lever = 1){
		
		$cls_list			= S($this->_cacheKey);
		if(!$cls_list){
			
			//第一级
			$cls_list		= $this->where('status = 0 AND topid = 0')->order('rank asc')->select();
			foreach($cls_list as $key=>$val){
				
				//第二级
				$son_list	= $this->where('status = 0 topid = ' . $val['id'])->order('rank asc')->select();	
				foreach($son_list as $k=>$v){
					
					//第三级
					$list	= $this->where('status = 0 topid = ' . $v['id'])->order('rank asc')->select();	
					$son_list[$k]['list']	= $list;
				}
				
				$cls_list[$key]['list']	= $son_list;
			}
			
			//更新缓存
			S($this->_cacheKey, $cls_list);
		}
		
		
		//如果有指定知识点
		if($topid > 0){
			foreach($cls_list as $k=>$v){
				
				//第一级
				if($lever == 1){
					if($v['id'] === $topid) return $v;
				
				//第二级
				}else{
					foreach($v['list'] as $key=>$val){
						if($val['id'] === $topid) return $val;
					}	
				}
			}	
		}
		
		//返回全树
		return $cls_list;
	}
}