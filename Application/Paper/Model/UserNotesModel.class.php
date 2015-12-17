<?php
namespace Paper\Model;
use Think\Model;
class UserNotesModel extends Model {
	protected $tableName = 'user_notes';
	
	protected $_validate = array(
		
     		
   	);
	   
	protected $_auto = array ( 
		array('addtime',	'time', 1, 'function'), 	// 对addtime字段在新增的时候写入当前时间戳
		
	);
	
	/**
	 * 根据userid初始化模型实际的数据表
	 */
	public function __construct($qid) {
		
		if(intval($qid) > 0){ 
			$this->tableName	= 'user_notes_' . spf_table($qid);
		}
		
		parent::__construct($this->tableName);
	} 
	
	/**
	 * 设置散列表
	 *
	 * @param    int    $userid     用户主键
	 * @return   void
	 */
	public function table($qid){
		return	new \Paper\Model\UserNotesModel($qid);
	}
   
   
    /**
	 * 获得试题笔记[集合]
	 * 
	 * @param    int     $qid    	  用户主键
	 * @param    int     $typeid   	  分组类别[收藏0, 重点标记1, 笔记2, 纠错3]
	 * @param    string  $filed		  查询字段列表
	 * @return   array				  
	 */
	public function getlist($qid, $typeid, $field){
		
		//后续再加上缓存..
		$where	= ' qid = ' . $qid . ' AND typeid = ' . $typeid;
		$list	= $this->where($where)->field($field)->select();
		
		return $list;
	}  
}