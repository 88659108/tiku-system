<?php
namespace Paper\Model;
use Think\Model;
class PaperModel extends Model {
	protected $tableName = 'paper';
	
   	/**
	 * 获得母卷详细
	 * 
	 * @param    int     $paperid     母卷主键
	 * @param    string  $filed		  查询字段列表
	 * @return   array				  
	 */
	public function info($paperid, $field){
		
		//后续再加上缓存..
		
		$row	= $this->field($field)->find($paperid);
		
		return $row;
	}
   
   
	   
}