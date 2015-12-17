<?php


/**
 * 获得知识点[试题数量]
 *
 * @param   int   $typeid     知识点主键
 * @param   int   $lever      层级
 * @return  int
 */
function get_question_count($typeid, $lever){
	
	$cls	= D('Teaching/Question');	
	if($lever == 1) $where	= 'bigtype=' . $typeid;
	if($lever == 2) $where	= 'smalltype=' . $typeid;
	if($lever == 3) $where	= 'pointtype=' . $typeid;
	
	return $cls->where($where)->count();
}

/**
 * 获取知识点名称
 *
 * @param   int     $id     知识点主键
 * @param   string  $field  字段名称[title]
 * @return  field
 */
function get_question_class_cols($id, $field = 'title'){
	
	$cls	= D('question_class');	
	return $cls->where('id = ' . $id)->getField($field);
}


/**
 * 获得试题图片合法地址
 *
 * @param   string   $file     试题图片地址
 * @param   string   $dir      试题图片目录
 * @return  array
 */
function get_question_image($file, $dir = 'body'){
	
	if(!$file) return false;
	
	$url	= C('TMPL_PARSE_STRING.__UPLOAD__') . 'xingce/' . $dir . '/';
	$files	= question_image2arr($file);
	
	$urls	= $imgs	= array();
	foreach($files as $k=>$v){
		$src	= $url . $v;
		$urls[]	= $src;
		$imgs[]	= '<img src="' . $src . '" />';
	}
	
	return array('files'=>$files, 'urls'=>$urls, 'imgs'=>$imgs);
}



/**
 * 获得试题图片合法地址
 *
 * @param   string   $content  需要替换图片的试题内容
 * @param   string   $file     试题图片地址
 * @param   string   $dir      试题图片目录  可选值： body 	   > 试题标题
                                                  desc 	   > 试题解析 
												  material > 资料题材料
												  tag      > TAG标签文本
 
 * @return  array
 */
function question_image2text($content, $file, $dir = 'body'){
	
	if(!$file || !$content) return $content;
	
	$files		= get_question_image($file, $dir);
	$content 	= str_replace($files['files'], $files['imgs'], $content);
	
	return $content;
}

/**
 * 获得试题图片数组
 *
 * @param   string   $file     试题图片地址  如：xc_407_0.jpg|xc_407_1.jpg
 * @return  array
 */
function question_image2arr($file){
	
	$file		= str_replace(array('||'), '|', $file);
	return	 	  explode('|', $file);
}


/**
 * 根据用户的userid来散列获取分表名称
 *
 * @param  int 		$userid   用户表主键
 * @return boolean
 */
function spf_table($userid)
{
    return intval(sprintf('%02x', intval($userid) % 256));
}


/**
 * 获得用户SESSION值[ask系统]
 *
 * @param    string     $key      键名
 * @return   string
 */
function get_sessions1($key){
	
	$session	= $_SESSION['zb__Anwsion']['client_info'];
	
	if($key == 'userid') $key   = '__CLIENT_UID';
	if($key == 'username') $key = '__CLIENT_USER_NAME';
	
	$val		= $session[$key];
	return $val;
}

function get_sessions($key){
	$session	= $_SESSION;
	$val		= $session[$key];
	return $val;
}


/**
  * 插入队列
  *
  * @param    string    $name        队列名
  * @param    string    $data        队列数据
  * @param    bool		$opt		 队列操作方式[插入/读取 _默认读取]
  * @return   bool/array
  */
function queue_execute($name, $data, $opt = true) 
{
	//创建队列对象
	$queue	= queue_object_create();
	
	//插入/读取
	$result = ($opt === true) ? $queue->put($name, $data) : $queue->gets($name);
	
	//处理结果
	return $result;
}


/**
  * 创建队列对象
  *
  * @return   object
  */
function queue_object_create()
{
	//引入类库
	import('Lib.Com.Httpsqs');
				
	//初始化客户端
	$queue 	= new Httpsqs(C('HTTPSQS_HOST'), C('HTTPSQS_PORT'), C('HTTPSQS_AUTH'), C('HTTPSQS_CHARSET')); 
	
	return $queue;
}
