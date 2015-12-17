<?php
namespace Admin\Controller;
use Think\Controller;
class QuestionController extends Controller {
   
	/**
	 * 教学配置
	 */
    public function index(){
        
		$this->display();
    }
	
	
	/**
	 * 统计报表
	 */
    public function chart(){
        
		
		$this->display();
    }
	
	
	/**
	 * 客观题
	 */
	public function objective(){
		
		//知识点分类
		$cls				= D('Teaching/QuestionClass','Logic');
		$form_list			= $cls->getTree();
		$this->form_list	= $form_list;
		
		//试题查询
		$q					= D('question');
		
		//查询条件
		if(I('get.serach')){
			
			$where	= ' 1 ';
			
			//知识点
			$str_cls	= I('get.class', '');
			if($str_cls){
				
				$str_cls		= str_replace(array(',,'), ',', $str_cls);
				$arr_cls		= explode(',', $str_cls);
				if(count($arr_cls) == 1){
					$where	.= ' AND bigtype=' . $arr_cls[0];
					$this->bigtype	= intval($arr_cls[0]);
				}
				
				if(count($arr_cls) == 2){
					$where	.= ' AND smalltype=' . $arr_cls[1];
					$this->smalltype	= intval($arr_cls[1]);
				}
				
				if(count($arr_cls) == 3){
					$where	.= ' AND pointtype=' . $arr_cls[2];
					$this->pointtype	= intval($arr_cls[2]);
				}
			}
			
			$field	= I('get.field');
			$this->field	= $field;
			$word	= I('get.keyword', NULL);
			if($word !== NULL){
				
				//关键词模糊查询 
				if(in_array($field, array('body', 'description'))  && $word) $where	.= ' AND ' . $field . " like '%" . $word . "%'";
				
				//字段索引
				$sfields	= array('id', 'qyear', 'status', 'ismock', 'diff', 'chance');
				if(in_array($field, $sfields)) $where	.= ' AND ' . $field . ' in (' . trim($word) . ')';
				
				//搜索旧标签
				if($field == 'pointtype1') $where	.= " AND pointtype = 0 AND " . $field . " = '". trim($word) ."'";
				//if($field == 'pointtype1') $where	.= " AND " . $field . " = '". trim($word) ."'";
			}
		}
		
		//查询满足要求的总记录数, $where表示查询条件
		$count      	= $q->where($where)->count();
		
		//搜索字段
		$this->field	= $field;
		
		// 导入管理分页类
		import('Admin.Util.Page');	
		$Page       	= new \Think\Page($count, 25);
		$this->pagenav	= $Page->show();
		
		//执行本页查询
		$list		= $q->field('description,wrongans,options', true)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->list	= $list;
		
		
		$this->display();
	}
	
	
	/**
	 * 试题 **单条操作字段
	 */
	public function question_update_filed(){
		$jsonMsg	= array('status'=>0, 'msg'=>'');

		$module		= I('post.module', 'question');
		$q			= D($module);
		$q->create();
		$result		= $q->save();
		if($result){
			$jsonMsg['id']		= I('post.id', 0, 'int');
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']	= '成功更新';
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
	/**
	 * 试题 **批量操作字段
	 */
	public function question_update_fileds(){
		
		$jsonMsg	= array('status'=>0, 'msg'=>'抱歉, 更新发生错误..');
		
		$filed		= I('post.filed', '');
		$value		= I('post.value', '');
		$ids		= I('post.ids', '');
		$module		= I('post.module', 'question');

		//数据模型
		$q			= D($module);
		
		//批量删除
		if($filed == 'delete'){
			$q->delete($ids);
			
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '成功删除选择记录..';
			$this->ajaxReturn($jsonMsg);
		}
		
		//更新字段
		$data	= array();
		
		//设置知识点
		if($filed == 'class'){
			
			if($value){
				
				$str_cls		= str_replace(array(',,'), ',', $value);
				$arr_cls		= explode(',', $str_cls);
				if(count($arr_cls) == 1){
					$data['bigtype'] 	= $arr_cls[0];
				}
				
				if(count($arr_cls) == 2){
					$data['bigtype'] 	= $arr_cls[0];
					$data['smalltype'] 	= $arr_cls[1];
				}
				
				if(count($arr_cls) == 3){
					$data['bigtype'] 	= $arr_cls[0];
					$data['smalltype'] 	= $arr_cls[1];
					$data['pointtype'] 	= $arr_cls[2];
				}
			}
		
		//其他字段直接更新
		}else{
			$data[$filed]	= $value;
		}
		
		//执行数据更新
		$where	= array('id' => array('in', $ids));
		$rows	= $q->where($where)->save($data);
		
		if($rows){
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '成功更新选择记录..';
		}
		
		//客户端返回
		$this->ajaxReturn($jsonMsg);
	}
	
	
	/**
	 * 客观题 **表单
	 */
	public function objective_form(){
		
		$id		= I('get.id', 0, 'int');
		
		//知识点分类
		$cls				= D('Teaching/QuestionClass','Logic');
		
		if($id > 0){
			$q					= D('question');
			$info				= $q->find($id);
			
			//选项 
			$info['options']	= json_decode(strip_tags($info['options']), true);
			
			
			$info['form_list2']	= $cls->getTree($info['bigtype'], 1);
			$info['form_list3']	= $cls->getTree($info['smalltype'], 2);
			
			
			$info['body1']			= question_image2text($info['body'], $info['bd_desc'], 'body2');
			$info['description1']	= question_image2text($info['description'], $info['dp_desc'], 'desc2');
			
			
			
		}
		
		$info['form_list1']	= $cls->getTree();
		
		
		$this->info			= $info;
		$this->display();
	}
	
	
	
	/**
	 * 客观题 **新增/更新
	 */
	public function objective_save(){
		
		$jsonMsg			= array('status'=>0, 'msg'=>'抱歉, 更新发生错误..');
		
		//数据模型类
		$q					= D('Teaching/Question');
		
		//从表单创建 **基础数据
		$data				= $q->create();
		
		//单独创建 **试题选项	
		$data['options']	= $q->get_form_options();	
		
		//多选,单选
		$data['optiontype']	= strlen($q->answer);
		
		//验证数据
		if (!$q->create($data)){
     		$jsonMsg['msg']	= $q->getError();
			$this->ajaxReturn($jsonMsg);
		}
		
		//入库
		$q->data($data);
		$result				= ($data['id']) ? $q->save() : $q->add();
		if($result){
			$jsonMsg['id']		= ($data['id']) ? I('post.id', 0, 'int') : $result;
			$jsonMsg['action']	= ($data['id']) ? 1 : 0;
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '操作成功';
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
	
	
	
	
	/**
	 * 资料题
	 */
	public function material(){
		
		//知识点分类
		$cls				= D('Teaching/QuestionClass','Logic');
		$form_list			= $cls->getTree(1000);
		$this->form_list	= $form_list;
		
		//试题查询
		$q					= D('question_material');
		
		//查询条件
		if(I('get.serach')){
			
			$where	= ' 1 ';
			
			//知识点
			$str_cls	= I('get.class', '');
			if($str_cls){
				
				$str_cls		= str_replace(array(',,'), ',', $str_cls);
				$arr_cls		= explode(',', $str_cls);
				if(count($arr_cls) == 1){
					$where	.= ' AND bigtype=' . $arr_cls[0];
					$this->bigtype	= intval($arr_cls[0]);
				}
				
				if(count($arr_cls) == 2){
					$where	.= ' AND smalltype=' . $arr_cls[1];
					$this->smalltype	= intval($arr_cls[1]);
				}
				
				if(count($arr_cls) == 3){
					$where	.= ' AND pointtype=' . $arr_cls[2];
					$this->pointtype	= intval($arr_cls[2]);
				}
			}
			
			$field	= I('get.field');
			$this->field	= $field;
			$word	= I('get.keyword', NULL);
			if($word !== NULL){
				
				//关键词模糊查询 
				if(in_array($field, array('body', 'description')) && $word) $where	.= ' AND ' . $field . " like '%" . $word . "%'";
				
				//字段索引
				$sfields	= array('qyear', 'status', 'ismock', 'diff', 'chance');
				if(in_array($field, $sfields)) $where	.= ' AND ' . $field . ' in (' . trim($word) . ')';
			}
		}
		
		//查询满足要求的总记录数, $where表示查询条件
		$count      	= $q->where($where)->count();
		
		// 导入管理分页类
		import('Admin.Util.Page');	
		$Page       	= new \Think\Page($count, 25);
		$this->pagenav	= $Page->show();
		
		//执行本页查询
		$list		= $q->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->list	= $list;
		
		
		$this->display();
	}
	
	
	/**
	 * 资料题 **表单
	 */
	public function material_form(){
		
		//资料题数据
		$info				= array();
		
		//知识点分类
		$cls				= D('Teaching/QuestionClass','Logic');
		
		//如果是更新
		$id					= I('get.id', 0, 'int');
		if($id > 0){		
		
			//查询资料
			$qm					= D('question_material');
			$info				= $qm->where('sourceid = ' . $id)->find();
			
			//子题列表
			$q					= D('question');
			$items				= $q->where('status=%s AND materialid=%s', 1, $info['id'])->select();
			
			if($items){
				foreach($items as $key=>$item){
					
					//选项
					$item['options']	= json_decode(strip_tags($item['options']), true);
					$item['form_list1']	= $cls->getTree();
					$item['form_list2']	= $cls->getTree($item['bigtype'], 1);
					$item['form_list3']	= $cls->getTree($item['smalltype'], 2);
					$items[$key]			= $item;
				}
				
				$info['items']			= $items;
			}
			
			$info['form_list2']	= $cls->getTree($info['bigtype'], 1);
			$info['form_list3']	= $cls->getTree($info['smalltype'], 2);	
			
			$info['qnums']		= count($items);
		}
		
		
		$info['form_list1']		= $cls->getTree();
		$this->minfo			= $info;
		$this->display();
	}

	
	/**
	 * 资料题 **新增/更新
	 */
	public function material_save(){
		
		$jsonMsg			= array('status'=>0, 'msg'=>'抱歉, 更新发生错误..');
		
		//数据模型类
		$q					= D('Teaching/QuestionMaterial');
		
		//从表单创建 **基础数据
		$data				= $q->create();
		
		//验证数据
		if (!$q->create($data)){
     		$jsonMsg['msg']	= $q->getError();
			$this->ajaxReturn($jsonMsg);
		}
		
		//入库
		$q->data($data);
		$result				= ($data['id']) ? $q->save() : $q->add();
		if($result){
			$jsonMsg['id']		= ($data['id']) ? I('post.id', 0, 'int') : $result;
			$jsonMsg['action']	= ($data['id']) ? 1 : 0;
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '操作成功';
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
}