<?php
namespace Admin\Controller;
use Think\Controller;
class GrabClsController extends Controller {
    public function index(){
        
		$this->display();
    }
	
	
	//入库
	public function insert(){
		
		$jsonMsg	= array('status'=>0, 'msg'=>'失败, 无法写入..');
		
		$cls		= D('Grab/QuestionClass');
		
		//从表单创建 **基础数据
		$data		= $cls->create();
		
		//验证数据
		if (!$cls->create($data)){
     		$jsonMsg['msg']	= $cls->getError();
			$this->ajaxReturn($jsonMsg);
		}
		
		$where		= 'supplierid='. $data['supplierid'] . ' AND sourceid = ' . $data['sourceid'];
		$row 		= $cls->where($where)->find();
		if($row){
			$jsonMsg['status']	= 2;
			$jsonMsg['msg']	= '名称已经存在..';
			$this->ajaxReturn($jsonMsg);	
		}
		
		//入库
		$insertid 	= $cls->data($data)->add();
		if($insertid){
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '成功收录..';
		}
		
		$this->ajaxReturn($jsonMsg);
	}
}