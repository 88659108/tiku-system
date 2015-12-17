<?php
namespace Grab\Controller;
use Think\Controller;

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
class IndexController extends Controller {
	
	//采集开关
	private  $off		= true;
	
	
	//更新试卷
	public function paper(){
		
		ini_set("max_execution_time", "4500");
		
		$pp			= D('Paper');
		$list		= $pp->where('supplierid=2 AND isupdate is null')->group('qnums')->select();
		
		
		foreach($list as $key=>$val){
			
			$plist		= $pp->where('supplierid=2 AND qnums='.$val['qnums'] . ' AND isupdate is null')->select();
			foreach($plist as $k=>$v){
			
				$arr	= json_decode($v['dataview'], true);
				$plist[$k]['navs']= $arr['navs'];
			}
			$list[$key]['plist']	= $plist;
			
			//if(intval($val['qnums']) == 0){
				//$re 	= $pp->where('id='.$val['id'])->save(array('qnums'=>$arr['info']['qnums']));
				//var_dump($re);
			//}	
		}
		
		$this->list = $list;
		$this->display();
	}
	
	//更新试卷[云南200分制]
	public function ynpaper(){
		
		ini_set("max_execution_time", "4500");
		
		$pp			= D('Paper');
		$list		= $pp->where("supplierid=2 AND city = '云南' AND isupdate=0")->group('qnums')->select();
		
		
		foreach($list as $key=>$val){
			
			$plist		= $pp->where('supplierid=2 AND qnums='.$val['qnums'] . " AND city = '云南' AND isupdate=0")->select();
			foreach($plist as $k=>$v){
			
				$arr	= json_decode($v['dataview'], true);
				$plist[$k]['navs']= $arr['navs'];
			}
			$list[$key]['plist']	= $plist;
			
			//if(intval($val['qnums']) == 0){
				//$re 	= $pp->where('id='.$val['id'])->save(array('qnums'=>$arr['info']['qnums']));
				//var_dump($re);
			//}	
		}
		
		$this->list = $list;
		$this->display();
	}
	
	
	
	
	public function papernavs(){
		
		$paperid	= I('post.paperid', 0, 'int');
		$navdata	= I('post.navdata', '');
		
		/*$str		= '[{"title":"言语理解与表达","nums":"15","subitem":[{"nums":15,"score":2}]},{"title":"数量关系","nums":"20","subitem":[{"nums":20,"score":1}]},{"title":"判断推理","nums":"40","subitem":[{"nums":40,"score":1}]},{"title":"资料分析","nums":"10","subitem":[{"nums":10,"score":1}]}]';*/
		
		
		$pp			= D('Paper');
		$row		= $pp->where('id=' . $paperid)->field('id, dataview')->find();
		
		//print_r($row);
		//exit;
		
		//验证数据
		$navdata	= json_decode(htmlspecialchars_decode($navdata), true);
		//print_r($navdata);
		if(!$navdata){
			$this->ajaxReturn(array('info'=>'navdata is null', 'status'=>-1));
		}
		
		//print $row['dataview'];
		
		$dataview	= json_decode($row['dataview'], true);
		$navs		= $dataview['navs'];
		foreach($navs as $key=>$val){
			$nav 	= $this->getScoreNav($navdata, $val['title']);
			$navs[$key]['subitem']	= $nav['subitem'];
		}
		$dataview['navs'] = $navs;
		
		$arr	= array('info'=>'保存失败', 'status'=>0);
		$re 	= $pp->where('id=' . $paperid)->save(array('dataview'=>json_encode($dataview), 'isupdate'=>1));
		//print json_encode($dataview);	
		if($re){
			$arr	= array('info'=>'ok', 'status'=>1);
		}
		
		$this->ajaxReturn($arr);
	}
	
	private function getScoreNav($navs, $nav_txt){
		
		foreach($navs as $key=>$val){
			if(trim($val['title']) == trim($nav_txt)) return $val;
		}
		
		return false;	
	}
	
	
    public function index(){
		
		$json	= '{"info":{"qnums":135},"navs":[{"title":"常识判断", "nums":"20", "key":"0"},{"title":"言语理解与表达", "nums":"40", "key":"1"},{"title":"数量关系", "nums":"15", "key":"2"},{"title":"判断推理", "nums":"40", "key":"3"},{"title":"资料分析", "nums":"20", "key":"4"}],"item":{"0":[{"qid":"60495"},{"qid":"60496"},{"qid":"60497"},{"qid":"60498"},{"qid":"60500"},{"qid":"60501"},{"qid":"60503"},{"qid":"60504"},{"qid":"60506"},{"qid":"60507"},{"qid":"60508"},{"qid":"60511"},{"qid":"60514"},{"qid":"60517"},{"qid":"60518"},{"qid":"60513"},{"qid":"60510"},{"qid":"60505"},{"qid":"60502"},{"qid":"60499"}],"1":[{"qid":"60509"},{"qid":"60512"},{"qid":"60516"},{"qid":"60519"},{"qid":"60520"},{"qid":"60524"},{"qid":"60528"},{"qid":"60531"},{"qid":"60535"},{"qid":"60539"},{"qid":"60547"},{"qid":"60559"},{"qid":"60568"},{"qid":"60572"},{"qid":"60577"},{"qid":"60580"},{"qid":"60585"},{"qid":"60588"},{"qid":"60593"},{"qid":"60600"},{"qid":"60521"},{"qid":"60525"},{"qid":"60527"},{"qid":"60530"},{"qid":"60532"},{"qid":"60534"},{"qid":"60538"},{"qid":"60540"},{"qid":"60543"},{"qid":"60555"},{"qid":"60560"},{"qid":"60569"},{"qid":"60571"},{"qid":"60573"},{"qid":"60576"},{"qid":"60579"},{"qid":"60581"},{"qid":"60584"},{"qid":"60587"},{"qid":"60591"}],"2":[{"qid":"60480"},{"qid":"60484"},{"qid":"60485"},{"qid":"60481"},{"qid":"60486"},{"qid":"60482"},{"qid":"60487"},{"qid":"60483"},{"qid":"60488"},{"qid":"60489"},{"qid":"60490"},{"qid":"60491"},{"qid":"60492"},{"qid":"60493"},{"qid":"60494"}],"3":[{"qid":"60523"},{"qid":"60529"},{"qid":"60533"},{"qid":"60537"},{"qid":"60542"},{"qid":"60562"},{"qid":"60575"},{"qid":"60582"},{"qid":"60589"},{"qid":"60603"},{"qid":"60605"},{"qid":"60607"},{"qid":"60606"},{"qid":"60604"},{"qid":"60602"},{"qid":"60601"},{"qid":"60594"},{"qid":"60590"},{"qid":"60586"},{"qid":"60583"},{"qid":"60578"},{"qid":"60574"},{"qid":"60570"},{"qid":"60561"},{"qid":"60551"},{"qid":"60536"},{"qid":"60541"},{"qid":"60526"},{"qid":"60515"},{"qid":"60522"},{"qid":"60613"},{"qid":"60614"},{"qid":"60616"},{"qid":"60617"},{"qid":"60619"},{"qid":"60620"},{"qid":"60622"},{"qid":"60621"},{"qid":"60618"},{"qid":"60615"}],"4":[{"qid":"2479", "son":"5"},{"qid":"2480", "son":"5"},{"qid":"2481", "son":"5"},{"qid":"2483", "son":"5"}]}}';
		
		$pid		= I('get.pid', 0, 'int');
		if($pid == 0){
			print 'pid == 0';
			exit;	
		}
		
		$pp			= D('Paper');
		$info		= $pp->find($pid);
		if($info['dataview'] == ''){
			print 'dataview == null';
			exit;	
		}
		
		$arr		= json_decode($info['dataview'], true);
		$qt			= D('Question');
		foreach($arr['navs'] as $k=>$v){
			
			//print $v['title'] . '<br />';
			$list	= $arr['item'][$v['key']];
			
			foreach($list as $kk=>$val){
				
				if(intval($val['son']) == 0){
					$where	= 'sourceid=' . $val['qid'];	
					$row				= $qt->where($where)->find();	
					$row['body']		= question_image2text($row['body'], $row['bd_desc'], 'body2');
					$row['description']	= question_image2text($row['description'], $row['dp_desc'], 'desc2');
					
				}else{
					$where	= 'materialid in (' . $val['qid'] . ')';
					
					$rowlist				= $qt->where($where)->select();	
					foreach($rowlist as $key=>$vl){
						$vl['body']			= question_image2text($vl['body'], $vl['bd_desc'], 'body2');
						$vl['description']	= question_image2text($vl['description'], $vl['dp_desc'], 'desc2');	
						$rowlist[$key]		= $vl;
					}
					
					$row	= $rowlist;
				}
				
				
				/*print $row['sourceid'];
				print $row['body'];
				print $row['options'];
				print $row['description'];
				print '<br /><br /><br /><br />';*/
				//var_dump($row);
				
				$list[$kk]['info']	= $row;
			}
			
			$arr['item'][$v['key']]	= $list;
		}
		
		
		
		$this->info	= $info;
		$this->list	= $arr;
		$this->display();
    }
	
	
	public function insert(){
		//if(!$this->off) E('..');
		
		$jsonMsg	= array('status'=>0, 'msg'=>'失败, 无法写入..');
		
		$pp			= D('Paper');
			
		//从表单创建 **基础数据
		$data		= $pp->create();
		
		//验证数据
		if (!$pp->create($data)){
     		$jsonMsg['msg']	= $pp->getError();
			$this->ajaxReturn($jsonMsg);
		}
		
		$where		= 'supplierid='. $data['supplierid'] . ' AND sourceid = ' . $data['sourceid'];
		$row 		= $pp->where($where)->find();
		if($row){
			$jsonMsg['status']	= 2;
			$jsonMsg['msg']	= '名称已经存在..';
			$this->ajaxReturn($jsonMsg);	
		}
		
		//入库
		$insertid 	= $pp->data($data)->add();
		if($insertid){
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '成功收录..';
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
	public function update(){
		if(!$this->off) E('..');
		
		$jsonMsg	= array('status'=>0, 'msg'=>'失败..');
		
		$pp			= D('Paper');
		
		$key		= I('post.filed', '');
		$val		= I('post.value', 0, 'int');
		$sourceid	= I('post.sourceid', 0, 'int');
		$supplierid	= I('post.supplierid', 0, 'int');
		if($key == ''){
			$jsonMsg['msg']	= '字段为空';
			$this->ajaxReturn($jsonMsg);	
		}
		
		$data				= array();
		$data[$key] 		= $val;
		$data['sourceid'] 	= $sourceid;
		$data['supplierid'] = $supplierid;
		
		$where				= 'supplierid='. $data['supplierid'] . ' AND sourceid = ' . $data['sourceid'];
		$row 				= $pp->where($where)->find();
		if(!$row){
			$jsonMsg['status']	= 2;
			$jsonMsg['msg']		= '不存在';
			$this->ajaxReturn($jsonMsg);	
		}
		
		//入库
		$insertid 	= $pp->where($where)->data($data)->save();
		if($insertid){
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '成功更新..';
		}
		
		$this->ajaxReturn($jsonMsg);
	}

	//更新试卷
	public function paperupdate2(){
		if(!$this->off) E('..');
		
		$jsonMsg	= array('status'=>0, 'msg'=>'失败..');
		
		$pp			= D('Paper');
		
		$dataview	= I('post.dataview', '');
		$title		= htmlspecialchars_decode(I('post.title', ''));
		$supplierid	= I('post.supplierid', 0, 'int');
		if($title == '' || $dataview == '' || $supplierid == 0){
			$jsonMsg['msg']	= '信息不全';
			$this->ajaxReturn($jsonMsg);	
		}
		
		$data				= array();
		$data['title'] 		= $title;
		$data['supplierid'] = $supplierid;
		$data['dataview'] 	= htmlspecialchars_decode($dataview);
		
		$where				= "title='". $data['title'] . "' AND supplierid = " . $data['supplierid'];
		$row 				= $pp->where($where)->find();
		if(!$row){
			$jsonMsg['status']	= 2;
			$jsonMsg['msg']		= '不存在' . $where;
			$this->ajaxReturn($jsonMsg);	
		}
		
		//入库
		$insertid 	= $pp->where($where)->data($data)->save();
		if($insertid){
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '成功组卷..' . $row['id'];
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
	
	//试题入库
	public function question(){
		if(!$this->off) E('..');
		
		$jsonMsg	= array('status'=>0, 'msg'=>'失败..');
		
		$qt			= D('Question');				//客观题
		$qc			= D('QuestionClass');			//知识点
		
		$data					= $qt->create();
		$data['body']			= htmlspecialchars_decode($data['body']);
		$data['options']		= htmlspecialchars_decode($data['options']);
		$data['options']		= $this->optionsDownFile($data['options']);
		$data['description']	= htmlspecialchars_decode($data['description']);
		$data['extend']			= htmlspecialchars_decode($data['extend']);
		$data['skill']			= htmlspecialchars_decode($data['skill']);
		
		//分类
		$pointtype	= trim($data['pointtype1']);
		$ptrow		= $qc->where("title = '".$pointtype."' AND supplierid = " . $data['supplierid'])->find();
		$smrow		= $qc->where('sourceid=' . $ptrow['topid'] . ' AND supplierid = '. $data['supplierid'])->find();
		$data['smalltype1']	= $smrow['title'];
		
		//验证数据
		if (!$qt->create($data)){
     		$jsonMsg['msg']	= $qt->getError();
			$this->ajaxReturn($jsonMsg);
		}
		
		$where		= 'supplierid='. $data['supplierid'] . ' AND sourceid = ' . $data['sourceid'];
		$row 		= $qt->where($where)->find();
		if($row){
			
			$updata	= array(
				'bigtype1'		=> $data['bigtype1'],
				'smalltype1'	=> $data['smalltype1'],
				'pointtype1'	=> $data['pointtype1'],
				'options'		=> $data['options']
			);
			$re		= $qt->where($where)->save($updata);
			
			
			$jsonMsg['status']	= 2;
			$jsonMsg['msg']	= '试题已经存在..';
			
			if($re){
				
				$jsonMsg['msg']	= '试题已经更新（成功）..';	
				
			}
			
			$this->ajaxReturn($jsonMsg);	
		}
		
		
		//题干图片
		if($data['bd_desc']){
			$dir		= 'Uploads/xingce/body2/';
			$arr				= $this->downFile($data['body'], $dir);
			$data['body']		= $arr['text'];
			$data['bd_desc']	= $arr['files'];
		}
		
		//解析图片
		if($data['dp_desc']){
			$dir		= 'Uploads/xingce/desc2/';
			$arr				= $this->downFile($data['description'], $dir);
			$data['description']= $arr['text'];
			$data['dp_desc']	= $arr['files'];
		}
		
		
		//入库
		$insertid 	= $qt->data($data)->add();
		if($insertid){
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '成功收录试题..';
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
	
	//资料入库
	public function material(){
		if(!$this->off) E('..');
		
		$jsonMsg	= array('status'=>0, 'msg'=>'失败..');
		
		$qm			= D('QuestionMaterial');		//资料
		$data		= $qm->create();
		$data['material']			= htmlspecialchars_decode($data['material']);
		
		//验证数据
		if (!$qm->create($data)){
     		$jsonMsg['msg']	= $pp->getError();
			$this->ajaxReturn($jsonMsg);
		}
		
		$where		= 'supplierid='. $data['supplierid'] . ' AND sourceid = ' . $data['sourceid'];
		$row 		= $qm->where($where)->find();
		if($row){
			$jsonMsg['status']	= 2;
			$jsonMsg['msg']	= '资料已经存在..';
			$this->ajaxReturn($jsonMsg);	
		}
		
		//解析图片
		if($data['material_desc']){
			$dir					= 'Uploads/xingce/material2/';
			$arr					= $this->downFile($data['material'], $dir);
			$data['material']		= $arr['text'];
			$data['material_desc']	= $arr['files'];
		}
		
		//入库
		$insertid 	= $qm->data($data)->add();
		if($insertid){
			$jsonMsg['status']	= 1;
			$jsonMsg['msg']		= '成功收录资料..';
		}
		
		$this->ajaxReturn($jsonMsg);
	}
	
	
	//处理选项图片
	function optionsDownFile($options){
	
		//[{"cs":"A ", "text":"http://tiku.huatu.com/cdn/images/vhuatu/tiku/2/22413e29c9ef509d21af97f86a3c299a1a016231.png", "img":"1"},{"cs":"B ", "text":"http://tiku.huatu.com/cdn/images/vhuatu/tiku/2/243ce5e32226f839adb55265746a20b178ccb87c.png", "img":"1"},{"cs":"C ", "text":"http://tiku.huatu.com/cdn/images/vhuatu/tiku/2/2a0a1828098e3f2972466485a4882d7b3245cf5a.png", "img":"1"},{"cs":"D ", "text":"http://tiku.huatu.com/cdn/images/vhuatu/tiku/9/96fe36afcdcbf4cf90b67c64b9320f65d4928875.png", "img":"1"}]
		
		$dir		= 'Uploads/xingce/option2/';
		
		//建立目录
		mkdir($dir, 0777);
		
		$list	= json_decode($options, true);
		foreach($list as $key=>$val){
			
			if(intval($val['img']) == 1){
				$url		= $val['text'];
				$filename	= md5($url.time()) . $this->_fileExt($url);
				$src		= $this->grabImage($url, $dir . $filename);	
				
				$list[$key]['text']	= $filename;
			}
		}
		
		return json_encode($list);
	}
	
	//下载图片
	function downFile($text, $dir){
		
		preg_match_all("/<img.*?>/si", $text, $pics);
		$arr	= $pics[0];	
		$srcs	= ''; 
		
		//存在图片
		if(count($arr) > 0){
			
			//建立目录
			mkdir($dir, 0777);
			
			//遍历 **下载图片
			$pic			= array();
			foreach($arr as $k=>$val){
				preg_match("<img.*src=[\"](.*?)[\"].*?>", $val, $pics);
				$url		= $pics[1];
					
				$filename	= md5($url) . '_' . $k . $this->_fileExt($url);
				$src		= $this->grabImage($url, $dir . $filename);
				if($src){
					$pic[]  = $filename;
					$text	= str_replace($val, $filename, $text);
				}
			}
			$srcs			= join($pic, '|');	
		}
		
		//返回处理后的[内容,图片列表]
		return array('text'=>$text, 'files'=>$srcs);
	}
	
	
	//获得后缀
	function _fileExt($file){
		return strrchr($file, '.');
	}
	
	
	//下载图片
	function grabImage($url, $filename='') {
		
		if($url == "") return false;
		
		if($filename == "") {
			$ext = strrchr($url, ".");
			if($ext != ".gif" && $ext != ".jpg" && $ext != ".png") return false;
			$filename	= date("YmdHis").$ext;
		}
		
		ob_start();
		readfile($url);
		$img 	= ob_get_contents();
		ob_end_clean();
		
		$size 	= strlen($img);
		$fp2	= @fopen($filename, "a");
		fwrite($fp2,$img);
		fclose($fp2);
		
		return $filename;
	} 
	
	
	
}