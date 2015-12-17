<?php
namespace Teaching\Model;
use Think\Model;
class QuestionModel extends Model {
	protected $tableName = 'question';
	
	protected $_validate = array(
		
		//必须填写
		array('body', 			'require', '题干必须填写！'),
		array('description', 	'require', '解析必须填写！'),
		array('answer', 		'require', '正确答案必须填写！'),
		
		// 当值不为空的时候判断是否在一个范围内
		array('ismock',	array(0,1),'题类范围不正确！',1,'in'), 
     	array('status',	array(0,1),'状态范围不正确！',1,'in'), 
     	array('diff',	array(0,1,2,3,4,5),'难度范围不正确！',1,'in'),
     	array('chance',	array(0,1,2,3,4,5),'考频范围不正确！',1,'in'), 		
     	
		//验证选项合法 **最少2个选项,最多6个选项
		array('options', 'cheackOptions','必须至少2个选项！', 0, 'callback', 3, array(2, 6)), 		
   	);
   
	protected $_auto = array ( 
		array('status', '1'),  							// 新增的时候把status字段设置为1
		array('views', 100) , 
		array('addtime',	'time',1,'function'), 		// 对addtime字段在新增的时候写入当前时间戳
		array('updatetime',	'time',2,'function'), 		// 对updatetime字段在更新的时候写入当前时间戳
		array('answer',		'strtoupper',3,'function'), 	
		 
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
    * 验证选项合法 **最少2个选项,最多6个选项
	*
	* @param    json    $value     表单接收数据
	* @param    int     $min       最小数目
	* @param    int     $max       最大数目
	* @return   bool
    */
   public function cheackOptions($value, $min, $max){
		
	   	if(!$value) return false;
	   
	   	$options		= json_decode($value, true);
		$count			= count($options);
		
		//选项数目合法
		return ($count >= $min && $count <= $max) ? true : false;
	}
	
	
	/**
	 * 从表单获得试题选项
	 *
	 * @return   array
	 */
	public function get_form_options(){
		
		$options		= array();
		$options[]		= array('cs'=>'A', 'text'=>I('post.opts-a'));
		$options[]		= array('cs'=>'B', 'text'=>I('post.opts-b'));
		$options[]		= array('cs'=>'C', 'text'=>I('post.opts-c'));
		$options[]		= array('cs'=>'D', 'text'=>I('post.opts-d'));
		$options[]		= array('cs'=>'E', 'text'=>I('post.opts-e'));
		$options[]		= array('cs'=>'F', 'text'=>I('post.opts-f'));
		
		//清理为空的选项(保留有值项)
		foreach($options as $key=>$val){
			if(!$val['text']) unset($options[$key]);	
		}
		
		//有则转json, 无则返回空
		return (count($options) > 0) ? json_encode($options) : null;
	}
	
	
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
	
	
	/**
	 * 获得资料题[子题列表]
	 * 
	 * @param    int     $materialid  主键
	 * @param    string  $filed		  查询字段列表
	 * @return   array				  
	 */
	public function sonList($materialid, $field){
		
		//后续再加上缓存..
		$where	= ' materialid = ' . $materialid;
		$list	= $this->where($where)->field($field)->select();
		
		return $list;
	}
	
	
	/**
	 * 查询一道试题[客观题]
	 *
	 * @param   int   $sourceid     试题主键
	 * @pram    array
	 */
	public function selectQuestion($sourceid){
		
		//读取缓存
		$key		= 'data-question-' . $sourceid;
		$info		= S($key);
		if($info)	return $info;
		
		//查询数据库
		$field		= 'id, body, bd_desc, options, description, dp_desc, answer, wrongans, optiontype, qyear, views, rorate, updatetime';
		$field	   .= ', bigtype, smalltype, pointtype, tagids, errnums, collects, values, loglist, sourceid, usetime';
		$info		= $this->info($sourceid, $filed);	
		
		//处理图片
		$info['body']			= question_image2text($info['body'], $info['bd_desc'], 'body2');
		$info['description']	= question_image2text($info['description'], $info['dp_desc'], 'desc2');
		
		
		//知识点(三级名称)
		$class				= D('QuestionClass');
		$info['pointname']	= $class->where('id = ' . $info['pointtype'])->getField('title');
		
		$info['bigtype1']	= $class->where('id = ' . $info['bigtype'])->getField('title');
		$info['smalltype1']	= $class->where('id = ' . $info['smalltype'])->getField('title');
		
		//写入缓存
		S($key, $info);
		return $info;
	}
	
	
	/**
	 * 查询一道试题[资料题]
	 *
	 * @param   int   $sourceid     资料题主键
	 * @pram    array
	 */
	public function selectMaterial($sourceid){
		
		//读取缓存
		$key		= 'data-question-' . $sourceid;
		$info		= S($key);
		//if($info)	return $info;
		
		//查询数据库
		$material	= D('Teaching/QuestionMaterial');
		$field		= 'id, material, material_desc, sourceid';
		$info		= $material->info($sourceid, $filed);	
			
		//处理图片
		$info['material']			= question_image2text($info['material'], $info['material_desc'], 'material2');
		
		//子题列表
		$class		= D('QuestionClass');
		$field		= 'id, body, bd_desc, options, description, dp_desc, answer, wrongans, optiontype, qyear, views, rorate, updatetime';
		$field	   .= ', bigtype, smalltype, pointtype, tagids, errnums, collects, values, loglist, sourceid';
		$sonlist	= $this->sonList($info['sourceid'], $filed);		
		foreach($sonlist as $key=>$val){
			
			//处理图片
			$val['body']			= question_image2text($val['body'], $val['bd_desc'], 'body2');
			$val['description']		= question_image2text($val['description'], $val['dp_desc'], 'desc2');
			
			//知识点(三级名称)
			$val['pointname']		= $class->where('id = ' . $val['pointtype'])->getField('title');
		
			$val['bigtype1']		= $class->where('id = ' . $val['bigtype'])->getField('title');
			$val['smalltype1']		= $class->where('id = ' . $val['smalltype'])->getField('title');
			
			
			$sonlist[$key]			= $val;
		}
		
		$info['sonlist']			= $sonlist;
		
		//写入缓存
		S($key, $info);
		return $info;
	}
	
   
}