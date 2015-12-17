<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        
		$this->display();
		
    }
	
	
	public function action1(){
		
		//最大执行时间
		ini_set('max_execution_time', 3000);	
			
		
		$q					= D('question');
		$list				= $q->field('id, options')->select();
		
		print count($list);
		exit;
		foreach($list as $k=>$val){
			
			$re = $q->where('id='.$val['id'])->setField(array('options'=>strip_tags($val['options'])));	
			
			//print '<br />qid:' . $val['id'] . '_';
			//print ($re) ? 'ok' : 'err';
			if($re) $i++;
		}
			
			
			
		$this->display('action');
		
	}
	
	public function action2(){
		
			
		$this->display('action');
		
	}
	
	public function action3(){
		
			
		$this->display('action');
		
	}
	
	public function action4(){
		
			
		$this->display('action');
		
	}
}