<?php

function create_select_options($bigtypeid){
	
	//知识点分类
	$cls			= D('Teaching/QuestionClass','Logic');
	$list			= $cls->getTree($bigtypeid);
	
	$options		= array();
	foreach($list as $key=>$val){
		
		//$options[]	= '<option value="'. $val['id'] .'">'. $val['title'] .'</option>';
		foreach($val['list'] as $k=>$v){
			$options[]	= '<option value="'. $val['id'] . ',' . $v['id'] .'">'. $v['title'] .'</option>';
			foreach($v['list'] as $kk=>$vv){
				$options[]	= '<option value="'. $val['id'] . ',' . $v['id'] . ',' . $vv['id'] .'">---'. $vv['title'] .'</option>';
			}
		}
	}
	
	return implode('', $options);
}