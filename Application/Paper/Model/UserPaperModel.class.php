<?php
namespace Paper\Model;
use Think\Model;
class UserPaperModel extends Model {
	protected $tableName = 'userpaper';
	
	protected $_validate = array(
		
		//必须填写
		array('title', 			'require', '试卷标题为空！', 1),
		array('paperid', 		'require', '母卷ID为空！', 1),
		array('userid', 		'require', '用户ID为空！', 1),
		array('dataview', 		'require', '答卷为空！', 1),
		
		array('totals', 		'require', '得分总分为空！'),
		array('qnums', 			'require', '试题总数为空！'),
		array('totaltime', 		'require', '规定总用时为空！')
     		
   	);
	   
	protected $_auto = array ( 
		array('status', 0),  							// 新增的时候把status字段设置为1
		array('score', 0, 1),  							
		
		array('addtime',	'time', 1, 'function'), 	// 对addtime字段在新增的时候写入当前时间戳
		
	);
	
	/**
	 * 根据userid初始化模型实际的数据表
	 */
	public function __construct($userid) {
		
		if(intval($userid) > 0){ 
			$this->tableName	= 'userpaper_' . spf_table($userid); 
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
		return	new \Paper\Model\UserPaperModel($userid);
	}
	
   	/**
	 * 获得答卷详细
	 * 
	 * @param    int     $paperid     母卷主键
	 * @param    int     $userid 	  用户主键
	 * @param    string  $filed		  查询字段列表
	 * @return   array				  
	 */
	public function info($upaperid, $userid, $field){
		
		//后续再加上缓存..
		$where	= ' id = ' . $upaperid;
		if(intval($userid) > 0) $where	.= ' AND userid=' . $userid;
		$row	= $this->where($where)->field($field)->find();
		
		return $row;
	}
   
}