<?php
namespace Grab\Model;
use Think\Model;
class PaperModel extends Model {
	protected 	$tableName = 'paper';
	
	protected $_validate = array(
		
		//必须填写
		array('title', 			'require', '名称必须填写！'),
		array('city', 			'require', '省份必须填写！'),
		array('year', 			'require', '年份必须填写！'),
		array('sourceid', 		'require', '数据源(主键)必须填写！'),
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