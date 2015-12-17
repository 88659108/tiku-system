<?php
namespace Paper\Model;
use Think\Model;
class UserAnalysisModel extends Model {
	protected $tableName = 'user_analysis';
	
	protected $_validate = array(
		
     		
   	);
	   
	protected $_auto = array ( 
		array('addtime',	'time', 1, 'function'), 	// 对addtime字段在新增的时候写入当前时间戳
		
	);
	
	/**
	 * 根据userid初始化模型实际的数据表
	 */
	public function __construct($userid) {
		
		if(intval($userid) > 0){ 
			$this->tableName	= 'user_analysis_' . spf_table($userid);
		}
		
		parent::__construct($this->tableName);
	} 
	
	/**
	 * 设置散列表
	 *
	 * @param    int    $userid     用户主键
	 * @return   void
	 */
	public function table($userid){
		return	new \Paper\Model\UserAnalysisModel($userid);
	}
	
	
   	/**
	 * 获得错题集[分析结果]
	 * 
	 * @param    int     $userid 	  用户主键
	 * @param    string  $filed		  查询字段列表
	 * @return   array				  
	 */
	public function info($userid, $field){
		
		//后续再加上缓存..
		$where	= ' userid = ' . $userid;
		$row	= $this->where($where)->field($field)->find();
		
		return $row;
	}
   
}