<?php
namespace Grab\Model;
use Think\Model;
class QuestionMaterialModel extends Model {
	protected 	$tableName = 'question_material';
	
	protected $_validate = array(
		
		//必须填写
		array('material', 		'require', '资料必须填写！'),
		array('qyear', 			'require', '年份必须填写！'),
		
		array('bigtype', 		'require', 'bigtype必须填写！'),

		array('supplierid', 	'require', '供应商必须填写！'),
		array('sourceid', 		'require', '数据源必须填写！'),
   	);
	
	protected $connection = array(
        'db_type'  => 'mysql',
        'db_user'  => 'root',
        'db_pwd'   => 'bf6598ba03',
        'db_host'  => '127.0.0.1',
        'db_port'  => '3306',
        'db_name'  => 'task_content',
        'db_charset' =>'utf8',
    );
}