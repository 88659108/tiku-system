<?php
namespace Ask\Model;
use Think\Model;
class AskQuestionAnswerModel extends Model {
	protected $tableName = 'answer';
	
	
   	protected $connection = array(
        'db_type'  => 'mysql',
        'db_user'  => 'root',
        'db_pwd'   => 'bf6598ba03',
        'db_host'  => '121.41.51.22',
        'db_port'  => '3306',
        'db_name'  => 'wecenter_ask',
        'db_charset' =>'utf8',
    );
}