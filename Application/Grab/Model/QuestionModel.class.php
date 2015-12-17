<?php
namespace Grab\Model;
use Think\Model;
class QuestionModel extends Model {
	protected 	$tableName = 'question';
	
	protected $_validate = array(
		
		//必须填写
		array('body', 			'require', '题干必须填写！'),
		array('options', 		'require', '选项必须填写！'),
		array('description', 	'require', '解析必须填写！'),
		array('answer', 		'require', '答案必须填写！'),
		array('qyear', 			'require', '年份必须填写！'),
		
		array('bigtype1', 		'require', 'bigtype1必须填写！'),
		array('smalltype1', 	'require', 'smalltype1年份必须填写！'),
		array('pointtype1', 	'require', 'pointtype1年份必须填写！'),
		
		array('supplierid', 	'require', '供应商必须填写！'),
		array('sourceid', 		'require', '数据源必须填写！'),
   	);
	
	protected $connection = array(
        'db_type'  => 'mysql',
        'db_user'  => 'root',
        'db_pwd'   => 'bf6598ba03',
        'db_host'  => '121.41.51.22',
        'db_port'  => '3306',
        'db_name'  => 'task_content',
        'db_charset' =>'utf8',
    );
}