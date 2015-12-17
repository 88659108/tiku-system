<?php
namespace Paper\Model;
use Think\Model;
class UserQListModel extends Model {
	protected $tableName = 'user_qlist';
	
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
			$this->tableName	= 'user_qlist_' . spf_table($userid);
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
		return	new \Paper\Model\UserQListModel($userid);
	}
	
	
   	/**
	 * 获得一道试题[结果]
	 * 
	 * @param    int     $userid 	  用户主键
	 * @param    int     $qid   	  试题主键
	 * @param    int     $typeid   	  分组类别[收藏0, 重点标记1, 笔记2, 纠错3]
	 * @param    string  $filed		  查询字段列表
	 * @return   array				  
	 */
	public function info($userid, $qid, $typeid, $field){
		
		//后续再加上缓存..
		$where	= ' userid = ' . $userid . ' AND qid = ' . $qid . ' AND typeid = ' . $typeid;
		$row	= $this->where($where)->field($field)->find();
		
		return $row;
	}
   
   
    /**
	 * 获得分组集合[结果]
	 * 
	 * @param    int     $userid 	  用户主键
	 * @param    int     $typeid   	  分组类别[收藏0, 重点标记1, 笔记2, 纠错3]
	 * @param    string  $filed		  查询字段列表
	 * @return   array				  
	 */
	public function getlist($userid, $typeid, $field){
		
		//后续再加上缓存..
		$where	= ' userid = ' . $userid . ' AND typeid = ' . $typeid;
		$list	= $this->where($where)->field($field)->select();
		
		return $list;
	}  
}