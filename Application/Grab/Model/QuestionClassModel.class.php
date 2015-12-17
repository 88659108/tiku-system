<?php
namespace Grab\Model;
use Think\Model;
class QuestionClassModel extends Model {
	protected 	$tableName = 'question_class';
	
	protected $_validate = array(
		
		//必须填写
		array('title', 			'require', '名称必须填写！'),
		array('supplierid', 	'require', '供应商必须填写！'),
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