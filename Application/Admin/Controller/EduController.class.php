<?php
namespace Admin\Controller;
use Think\Controller;

class EduController extends Controller {
    public function index(){
		
		$cls	= D('Teaching/QuestionClass','Logic'); 
		$cls_list	= $cls->getTree();
		
		$form_list	= $cls->getTree();
		
		$this->cls_list		= $cls_list;
		$this->form_list	= $form_list;
		$this->display();
    }
	
	
	/**
	 * 添加知识点
	 * 
	 * @param   int     topid     知识点类别
	 * @param   string  text	  知识点名称[或多个]
	 */
	public function insertblock(){
		
		$jsonMsg	= array('status'=>0, 'msg'=>'');
		
		$topid		= I('post.topid', 0, 'int');
		$text		= I('post.text', '');
		if(!$text){
			$jsonMsg['status']	= -1;
			$jsonMsg['msg']	= '知识点类别不能为空..';
			$this->ajaxReturn($jsonMsg);
		}
		
		//格式化
		$text		= str_replace(array('，', ' ', '|'), ',', $text);
		$text		= str_replace(array(',,'), ',', $text);
		$arr		= explode(',', $text);
		
		$datalist	= array();
		foreach($arr as $key=>$val){
			
			if($val){
				$datalist[]	= array('title'=>$val, 'topid'=>$topid);
			}
		}
		
		//批量入库
		$cls		= D('question_class');
		$result		= $cls->addAll($datalist);
		if($result){
			$jsonMsg['status']	= 1;
			S('question-class-class', null);
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
	/**
	 * 更新知识点
	 * 
	 * @param   int     topid     知识点类别
	 * @param   string  text	  知识点名称
	 */
	public function updateblock(){
		
		$jsonMsg	= array('status'=>0, 'msg'=>'');
		
		$mode		= I('post.mode', '');
		$topid		= I('post.topid', 0, 'int');
		$dataid		= I('post.dataid', 0, 'int');
		$text		= I('post.text', '');
		if(!$text){
			$jsonMsg['status']	= -1;
			$jsonMsg['msg']	= '知识点类别不能为空..';
			$this->ajaxReturn($jsonMsg);
		}
		
		//检查同名
		$cls		= D('question_class');
		$row		= $cls->where("title='%s' and id <> %d", array($text, $dataid))->select();
		if($row){
			$jsonMsg['status']	= -1;
			$jsonMsg['msg']	= '知识点已经存在..';
			$this->ajaxReturn($jsonMsg);
		}
		
		//入库
		$cls->title	= $text;
		$cls->topid	= $topid;
		$result		= $cls->where('id=' . $dataid)->save(); // 根据条件更新记录
		if($result){
			$jsonMsg['status']	= 1;
			S('question-class-class', null);
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
	
	/**
	 * 批量更新知识点
	 */
	public function updateblocks(){
		
		$jsonMsg	= array('status'=>0, 'msg'=>'');
		
		$mode		= I('post.mode', '');
		if(!$mode){
			$jsonMsg['status']	= -1;
			$jsonMsg['msg']	= '参数不合法..';
			$this->ajaxReturn($jsonMsg);
		}
		
		$rank		= I('post.rank', 0, 'int');
		$status		= I('post.status', 0, 'int');
		$topid		= I('post.topid', 0, 'int');
		$dataid		= I('post.dataid', 0, 'int');
		
		//更新排序
		if($mode == 'rank'){
			$data	= array('rank'=>$rank, 'status'=>$status);
		
		//更新类别	
		}else{
			$data	= array('topid'=>$topid);
		}
		
		//更新
		$cls		= D('question_class');
		$result		= $cls->where('id=' . $dataid)->setField($data); // 根据条件更新记录
		if($result){
			$jsonMsg['status']	= 1;
			S('question-class-class', null);
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
	
	/**
	 * 批量删除知识点
	 */
	public function deleteblocks(){
		
		$jsonMsg	= array('status'=>0, 'msg'=>'');
		
		$ids		= I('post.ids', '');
		if(!$ids){
			$jsonMsg['status']	= -1;
			$jsonMsg['msg']	= '没有选择知识点..';
			$this->ajaxReturn($jsonMsg);
		}
		
		//更新
		$cls		= D('question_class');
		$result		= $cls->delete($ids); // 根据条件删除记录
		if($result){
			$jsonMsg['status']	= 1;
			S('question-class-class', null);
		}
		
		$this->ajaxReturn($jsonMsg);
	}
}