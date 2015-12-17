<?php
namespace Paper\Model;
use Think\Model;
class MobileListModel extends Model {
	protected $tableName = 'mobile_list';
	
	protected $_validate = array(
		
     		
   	);
	   
	protected $_auto = array ( 
		array('addtime',	'time', 1, 'function'), 	// 对addtime字段在新增的时候写入当前时间戳
		
	);
	 
}