<?php
namespace Teaching\Model;
use Think\Model;
class QuestionMaterialModel extends Model {
	protected $tableName = 'question_material';
	
	protected $_validate = array(
		
		//必须填写
		array('material', 		'require', '题干必须填写！'),
		
		// 当值不为空的时候判断是否在一个范围内
		array('ismock',	array(0,1),			'题类范围不正确！',	1,	'in'), 
     	array('status',	array(0,1),			'状态范围不正确！',	1,	'in'), 
     	array('diff',	array(0,1,2,3,4,5),	'难度范围不正确！',	1,	'in'),
     	array('chance',	array(0,1,2,3,4,5),	'考频范围不正确！',	1,	'in'), 			
   	);
   
	protected $_auto = array ( 
		array('status', '1'),  							// 新增的时候把status字段设置为1
		array('addtime',	'time', 1, 'function'), 		// 对addtime字段在新增的时候写入当前时间戳
		array('updatetime',	'time', 2, 'function'), 		// 对updatetime字段在更新的时候写入当前时间戳 
	);
	
	/*protected $connection = array(
        'db_type'  => 'mysql',
        'db_user'  => 'root',
        'db_pwd'   => 'bf6598ba03',
        'db_host'  => '121.41.51.22',
        'db_port'  => '3306',
        //'db_name'  => 'task_content',
		'db_name'  => 'xingce',
        'db_charset' =>'utf8',
    );*/
	
	/**
	 * 获得试题详细
	 * 
	 * @param    int     $qid     	  主键
	 * @param    string  $filed		  查询字段列表
	 * @return   array				  
	 */
	public function info($qid, $field){
		
		//后续再加上缓存..
		$where	= ' sourceid = ' . $qid;
		$row	= $this->where($where)->field($field)->find();
		
		return $row;
	}
}