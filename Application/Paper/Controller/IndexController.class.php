<?php
namespace Paper\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$this->login();
		header("Location: http://www.zoobao.com/index.php/Paper/Index/paperlist"); 
		exit;
		//$this->login();
		
		
		$this->display();
		
		
    }
	
	
	public function datacode(){
		
		if($_GET['sid']) session_id($_GET['sid']);
		$id	= session_id();
		
print $id;
print_r(S($id));
print_r($_SESSION);
exit;

print intval(sprintf('%02x', intval(33) % 256));
		
		$datacode	= '{"info":{"qnums":100},"navs":[

{"title":"综合训练",
"select":{"nums":25,"score":2, "where":[{"source":[["qyear","2014",">"], ["errnums","5","desc"]], "nums":10,"score":1},
								   {"error":[["errnums","1",">"]], "nums":15,"score":1}]}},

{"title":"判断推理之平面遍历",
"select":{"nums":25,"score":1, "where":[{"source":[["bigtype","3"], ["notes","5","desc"]], "nums":10},
								   {"error":[["pointtype","138"]], "nums":15}]}},

{"title":"数量关系之浓度问题",
"select":{"nums":30,"score":1, "where":[{"source":[["pointtype","85"], ["notes","5","desc"]], "nums":30}]}}

]}';
		
		
	/*
	
	{"title":"资料分析",
"select":{"nums":20,"score":1, "where":[{"material":[["pointtype","65"], ["qyear","2014",">"]], "nums":20}]}}	
	
	*/	
		
		$userpars	= array('userid'=>33, 'select'=>1);
		$build		= D('BuildPaper', 'Logic');
		$arr		= $build->buildDataView($datacode, $userpars);
		
		print_r($arr);
		
		print ($arr['result'] == 1) ? '生成成功' : '生成失败';
				
		print $arr['paperjson'];
		
		print_r(json_decode($arr['paperjson'], true));
	}
	
	
	//历年真题
	public function paperlist(){
		
		$this->login();
		
		$paper		= D('Paper');
		
		$year		= I('get.year', 0, 'int');
		$city		= I('get.city', 0, 'int');
		$where		= 'status = 1 AND isupdate=1';
		if($year) $where .= ' AND year = ' . $year;
		if($city) $where .= ' AND cityid = '. $city;
		
		$list		= $paper->where($where)->select();
		$this->list	= $list;
		
		$city		= D('City');
		$citylist	= $city->select();
		$this->citylist	= $citylist;
		
		
		$this->display();
	}
	
	//专项考点
	public function special(){
		
		@header('Content-type: text/html;charset=UTF-8');
		
		$paperid	= intval(I('get.paperid'));
		$paper		= D('Paper');
		$pinfo		= $paper->info($paperid, 'id, city, title, dataview, status, topscore, loglist, applys');
		
		
		if(!$pinfo){
			print '不存在的试卷编号';
			exit;	
		}
		
		$index		= intval(I('get.index'));
		
		print '<h1><a href="/index.php/Paper/Index/paperlist">返回试卷列表</a></h1>';
		
		if(I('get.mode') == 1){
			print '<h1><a href="/index.php/Paper/Index/special?paperid='.$paperid.'&index='.$index.'&mode=0">简洁显示</a></h1>';
		}else{
			print '<h1><a href="/index.php/Paper/Index/special?paperid='.$paperid.'&index='.$index.'&mode=1">完整显示</a></h1>';
		}
		print '<h1>' . $pinfo['title'] . '</h1>';
		
		print '<br />';
		
		$objq		= D('Teaching/Question');
		
		$dataview	= json_decode($pinfo['dataview'], true);
		$list		= $dataview['item'];
		$navs		= $dataview['navs'];
		
		print '<style type="text/css">
a { float:left; border:1px solid #F00; text-decoration:none; margin:0px 10px 0px 10px;}
a:hover{ border: 1px solid #900; }
body{ text-align:left;}
</style>';
		
		
		foreach($list as $key=>$val){
			print '<h2><a href="/index.php/Paper/Index/special?paperid='.$paperid.'&index='.$key.'">' . $navs[$key]['title'] . '</a></h2>';
		}
		print '<br />';
		print '<br />';
		
		
		
		$number		= 0;
		$cls_arr	= array();
		foreach($list as $key=>$val){
			
			if($key != $index) continue;
			
			print '<h2>当前显示的分组：' . $navs[$key]['title'] . '</h2>';
			print '<br />';
			
			$nav_ans	= array();
			$nav_dec	= array();
			
			foreach($val as $k=>$v){
				
				
				
				
				//客观题
				if(intval($v['son']) == 0){
					
					$number	+= 1;
					print '<strong>' . $number . '.</strong> ';
					$qrow	= $objq->selectQuestion($v['qid']);
					$nav_ans[]	= $number . '.' . $qrow['answer'];
					$nav_dec[]	= $number . '.' . $qrow['description'];
					
					print $qrow['body'];
					print '<br />';
					
					
					$options	= json_decode($qrow['options'], true);
					foreach($options as $op=>$ov){
						print $ov['cs'] . '.' . $ov['text'];	
						print '<br />';
					}
					print '<br />';
					
					
					if(I('get.mode')){
						print '题型：' . $qrow['bigtype1'] . '<br /> 考点：' . $qrow['smalltype1'] . '<br /> 知识点：' . $qrow['pointname'];
						print '<br /><br />';
						
						print '年份：' . $qrow['qyear'];
						print ' <br />省份：' . $pinfo['city'];
						print ' <br />所属试卷：' . $pinfo['title'];
						print '<br />';
					
						print '答案：' . $qrow['answer'];
						print '<br /><br />';
					
						print '解析：' . $qrow['description'];
						print '<br />';
						
						
						if($qrow['skill'] != 'null'){
							print '技巧：' . $qrow['skill'];
							print '<br />';
						}
							
						if($qrow['extend'] != 'null'){
							print '扩展：' . $qrow['extend'];
							print '<br />';
						}
					}
					
					/*$cls_arr[$qrow['bigtype']]['qnums']		+= 1;
					$cls_arr[$qrow['bigtype']]['usetime']	+= $v['usetime'];
					
					if($qrow['smalltype']){
						$cls_arr[$qrow['smalltype']]['qnums']	+= 1;
						$cls_arr[$qrow['smalltype']]['usetime']	+= $v['usetime'];
					}
					
					if($qrow['pointtype']){
						$cls_arr[$qrow['pointtype']]['qnums']	+= 1;
						$cls_arr[$qrow['pointtype']]['usetime']	+= $v['usetime'];
					}
					
					if(strtoupper(trim($v['uanswer'])) != strtoupper(trim($v['answer'])) || !$v['uanswer']){
						$cls_arr[$qrow['bigtype']]['iserr']		+= 1;
						if($qrow['smalltype']) $cls_arr[$qrow['smalltype']]['iserr']	+= 1;
						if($qrow['pointtype']) $cls_arr[$qrow['pointtype']]['iserr']	+= 1;
					}*/
					
					
				//资料题	
				}else{
					
					
					$qinfo			= $objq->selectMaterial($v['qid']);
					print $qinfo['material'];
					print '<br /><br />';
					
					$slist			= $qinfo['sonlist'];
					//$slist		= $objq->where('materialid='.$v['qid'])->field('*')->select();
					
					//$materialson	= array();
					//$materialsond	= array();
					foreach($slist as $skey=>$sval){
						
						$number	+= 1;
						print '<strong>' . $number . '.</strong> ';
						$nav_ans[]	= $number . '.' . $sval['answer'];
						$nav_dec[]	= $number . '.' . $sval['description'];
						
						print $sval['body'];
						print '<br />';
						
						
						$options	= json_decode($sval['options'], true);
						foreach($options as $op=>$ov){
							print $ov['cs'] . '.' . $ov['text'];	
							print '<br />';
						}
						print '<br />';
						
						
						
						if(I('get.mode')){
							
							print '题型：' . $sval['bigtype1'] . ' <br />考点：' . $sval['smalltype1'] . ' <br />知识点：' . $sval['pointname'];
							print '<br /><br />';
							
							print '年份：' . $sval['qyear'];
							print ' <br />省份：' . $pinfo['city'];
							print ' <br />所属试卷：' . $pinfo['title'];
							print '<br />';
						
						
						
							print '答案：' . $sval['answer'];
							print '<br /><br />';
						
							print '解析：' . $sval['description'];
							print '<br />';
						
							if($sval['skill'] != 'null'){
								print '技巧：' . $sval['skill'];
								print '<br />';
							}
							
							if($sval['extend'] != 'null'){
								print '扩展：' . $sval['extend'];
								print '<br />';
							}
						}
						
						
						
						print '<br /><br />';
						
						/*$v		= $sonlist[$skey];
						$qrow	= $slist[$skey];
					
						$cls_arr[$qrow['bigtype']]['qnums']		+= 1;
						$cls_arr[$qrow['bigtype']]['usetime']	+= $v['usetime'];
					
						if($qrow['smalltype']){
							$cls_arr[$qrow['smalltype']]['qnums']	+= 1;
							$cls_arr[$qrow['smalltype']]['usetime']	+= $v['usetime'];
						}
						
						if($qrow['pointtype']){
							$cls_arr[$qrow['pointtype']]['qnums']	+= 1;
							$cls_arr[$qrow['pointtype']]['usetime']	+= $v['usetime'];
						}
						
						if(strtoupper(trim($v['uanswer'])) != strtoupper(trim($v['answer'])) || !$v['uanswer']){
							$cls_arr[$qrow['bigtype']]['iserr']		+= 1;
							if($qrow['smalltype']) $cls_arr[$qrow['smalltype']]['iserr']	+= 1;
							if($qrow['pointtype']) $cls_arr[$qrow['pointtype']]['iserr']	+= 1;
						}*/
					}
					
					//$nav_ans[]	= $number .  '[' . implode(' ', $materialson) . ']';
					//$nav_dec[]	= $number .  implode('<br />', $materialsond);
					
				}
				
				print '<br /><br />';
			}
			
			
			print '<h2>解析列表</h2>';
			print implode('<br />', $nav_dec);
			
			
			
			print '<h2>答案列表</h2>';
			print implode('<br />', $nav_ans);
			
			print '<br /><br /><br /><br />';
		}
		
		
		
		
		exit;
			
		//知识点分类
		$cls			= D('Teaching/QuestionClass','Logic');
		$clslist		= $cls->getTree();
		
		foreach($clslist as $key=>$val){
			$row = $cls_arr[$val['id']];
			if(!$row){
				unset($clslist[$key]);
				continue;	
			}
			
			$val['qnums']		= $row['qnums'];
			$val['usetime']		= $row['usetime'];
			$val['isok']		= $row['qnums'] - $row['iserr'];
			$val['accuracy']	= round($val['isok'] / $row['qnums'] * 100, 2);
			
			foreach($val['list'] as $vk=>$vv){
				$row = $cls_arr[$vv['id']];
				if(!$row){
					unset($val['list'][$vk]);
					continue;	
				}
			
				$vv['qnums']	= $row['qnums'];
				$vv['usetime']	= $row['usetime'];
				$vv['isok']		= $row['qnums'] - $row['iserr'];
				$vv['accuracy']	= round($vv['isok'] / $row['qnums'] * 100, 2);
				
				
				foreach($vv['list'] as $vkk=>$vvv){
					$row = $cls_arr[$vvv['id']];
					if(!$row){
						unset($vv['list'][$vkk]);
						continue;	
					}
					
					$vvv['qnums']		= $row['qnums'];
					$vvv['usetime']		= $row['usetime'];
					$vvv['isok']		= $row['qnums'] - $row['iserr'];
					$vvv['accuracy']	= round($vvv['isok'] / $row['qnums'] * 100, 2);
					$vv['list'][$vkk]	= $vvv;
				}
				
				$val['list'][$vk]	= $vv;
			}
			
			$clslist[$key]	= $val;
		}
		
		print_r($clslist);
		
		
	}
	
	//高频错题
	public function wrong(){
		
		
		
		
	}
	
	//模考竞赛
	public function examgame(){
		
		
		
		
	}
	
	//视频课程
	public function course(){
		
		$param		= array(1,2,3,4,5);
		
		print count($param);
		if(count($param) >= 5){
			array_splice($param, 0, 1);
			$param[]	= 'd';
		}
		
		print count($param);
		if(count($param) >= 5){
			array_splice($param, 0, 1);
			$param[]	= 'dd';
			
		}
		
		print count($param);
		if(count($param) >= 5){
			array_splice($param, 0, 1);
			$param[]	= 'ddd';
			
		}
		
		print count($param);
		if(count($param) >= 5){
			array_splice($param, 0, 1);
			$param[]	= 'dddd';
			
		}
		
		print_r($param);
		
		
	}
	
	public function login(){
		
		$_SESSION['userid'] 	= 1073;
		$_SESSION['username'] 	= 'pp1073';	
	}
	
	
	
	//申请试卷
	public function applyPaper(){
		
		/**
		 * 整理参数
		 * 母卷主键,用户主键,挑战卷主键
		 */
		
		//接收参数
		$paperid	= I('post.paperid', 0, 'int');
		$userid		= intval(get_sessions('userid'));
		
		$gameuid	= I('post.gameuid', 0, 'int');
		$gamepid	= I('post.gamepid', 0, 'int');
		$gamemsg	= I('post.gamemsg', '');
		
		
		if($userid == 0){
			$json['status']	= 0;
			$json['info']	= '请输入内测《邀请码》..';
			$this->ajaxReturn($json);	
		}
		
		if($paperid == 0){
			$json['status']	= 0;
			$json['info']	= '请输入内测《邀请码》..';
			$this->ajaxReturn($json);	
		}
		
		//母卷
		$paper		= D('Paper');
		$pinfo		= $paper->info($paperid, 'id, title, dataview, status, topscore, loglist, applys');
		if(!$pinfo || $pinfo['status'] == 0){
			$this->error('申请的试卷不存在..', '/index.php/Paper/Index/', 3);		
		}
		
		$upaper		= D('UserPaper', 'Logic');
		$params		= array('gameinfo' => array('gameuid'=>$gameuid, 'gamepid'=>$gamepid, 'gamemsg'=>$gamemsg));
		
		//开启事务
		$paper->startTrans();
		
		//生成答卷
		$results	= $upaper->apply($pinfo['id'], $userid, $pinfo['dataview'], $pinfo['title'], $params);
		
		//给母卷记录日志[最近5条]
		$topnums	= 5;
		$loglist	= ($pinfo['loglist']) ? json_decode($pinfo['loglist'], true) : array();
		if(count($loglist) >= $topnums){ array_splice($loglist, 0, 1); }
		
		$loginfo	= array('userid'=>$userid, 'upaperid'=>$results['paperid'], 'time'=>time(), 'typeid'=>1);
		if($gameuid > 0 && $gamepid > 0){ $loginfo['gameinfo']	= $params['gameinfo']; }
		$loglist[]	= $loginfo;
			
		//更新母卷
		$pdata		= array('applys'=>$pinfo['applys'] + 1, 'loglist' => json_encode($loglist));
		$result1	= $paper->where('id=' . $pinfo['id'])->save($pdata);
		
		if($results['paperid'] > 0 && $result1){
			$paper->commit();
			
			$json	= array();
			$json['status']	= 1;
			$json['info']	= '恭喜，试卷申请成功..';
			$json['url']	= '';
			$json['paperid']= $results['paperid'];
			
			//成功
			$this->ajaxReturn($json);
		}
		
		$paper->rollback();
		$this->error('试卷申请失败，' . $results['msg'] . '...', '/index.php/Paper/Index/', 3);	
	}
	
	
	/**
	 * 获得邀请码
	 */
	public function getcode(){
	
		$mob	= D('MobileList');
		
		//发送短信
		$mobile	= I('mobile', '');
		if(!preg_match("/1[3458]{1}\d{9}$/",$mobile)){ 
			$json['status']	= -1;
			$json['info']	= '请填写正确的手机号码..'; 
   			$this->ajaxReturn($json);
		}
		
		$row	= $mob->where("mobile = '" .$mobile. "'")->find();
		if(intval($row['send']) == 1){
			$json['status']	= -2;
			$json['info']	= '您已经获得过邀请码，请输入收到的邀请码..'; 
   			$this->ajaxReturn($json);
		}
		
		$json['status']	= -3;
		$json['info']	= '短信发送失败，请重新获取..'; 
		
		
		
		
		/*$json['status']	= 1;
		$this->ajaxReturn($json);*/
			
			
		//保存手机号码
		$code	= $this->randchar(6);
		$data	= array(
			'mobile' 		=> $mobile,
			'code' 			=> $code,
			'valid_mobile' 	=> 0,
			'addtime' 		=> time(),
			'ip' 			=> get_client_ip(),
			'updatetime' 	=> time(),
			'send'			=> 0
		);
		
		$updata				= $data;
		
		//根据IP获取省，市，运营商
		$ipapi			= 'http://ip.taobao.com/service/getIpInfo.php?ip=';
		$ipjson			= $this->posttohosts($ipapi, array('ip'=>$data['ip']));
		if($ipjson){
			$iparr	= json_decode($ipjson, true);
			//print_r($iparr);
			if(intval($iparr['code']) == 0){
				$data['region']	= $iparr['data']['region'];
				$data['city']	= $iparr['data']['city'];
				$data['isp']	= $iparr['data']['isp'];
			}
		}
		
		if(!$row){
			$result			= $mob->data($data)->add();
		}else{
			$result			= $mob->where('id='.$row['id'])->save($updata);
		}
		if($result){
					
			//var_dump($result);
			//发送短信
			$codapi		= 'http://www.tui3.com/api/code/';
			$params 	= array(
				"k"		=> '3f2c7e0960a9cfcc9dbe85b9312c392d',
				"r"		=> 'json',
				"t"		=> $mobile,
				"c"		=> $code,
				"ti"	=> 1
			);	
				
			$jsonstr	= $this->posttohosts($codapi, $params);
			//var_dump($jsonstr);
			if($jsonstr){
				$arr	= json_decode($jsonstr, true);
				//if(intval($arr['err_code']) == 0){
					
					$udata	= array('send'=>(intval($arr['err_code']) > 0) ? 0 : 1);
					$result = $mob->where('id='.$row['id'])->save($udata);
					//if($result){
						$json['status']	= 1;
						$json['info']	= '请输入手机接收到的邀请码..';
					//}
				//}	
			}		 
		}
		
   		$this->ajaxReturn($json);	
	}
	
	
	//验证邀请码
	function setcode(){
		
		$mob	= D('MobileList');
		
		//发送短信
		$mobile	= I('post.mobile', '');
		$code	= I('post.code', '');
		if(!preg_match("/1[3458]{1}\d{9}$/",$mobile)){ 
			$json['status']	= -1;
			$json['info']	= '请填写正确的手机号码..'; 
   			$this->ajaxReturn($json);
		}
		
		$row	= $mob->where("mobile = '" .$mobile. "'")->find();
		if(!$row){
			$json['status']	= -2;
			$json['info']	= '邀请码验证失败,请先获得邀请码..'; 
   			$this->ajaxReturn($json);
		}
		
		//验证次数超过3次
		$cookiename			= 'setcode-'.$mobile;
		$codenums			= intval($_SESSION[$cookiename]);
		if($codenums > 3){
			$json['status']	= -5;
			$json['info']	= '邀请码验证失败,请先获得邀请码..'; 
   			$this->ajaxReturn($json);
		}
		
		//验证邀请码
		if($row['code'] !== $code){
			$nums					= 3 - intval($codenums);
			$_SESSION[$cookiename] 	= $codenums + 1;
			
			$json['status']	= -3;
			$json['nums']	= $nums;
			$json['info']	= '邀请码验证失败,请重新输入,剩余'.$nums.'次机会。'; 
   			$this->ajaxReturn($json);
		}
		
		if(intval($row['valid_mobile']) > 0){
			
			$data	= array(
				'valid_mobile' 	=> intval($row['valid_mobile']) + 1,
				'ip2' 			=> get_client_ip(),
				'updatetime' 	=> time(),
				'send'			=> 1
			);
			
			
			//根据IP获取省，市，运营商
			if(!$row['region'] || !$row['city']){
				$ipapi			= 'http://ip.taobao.com/service/getIpInfo.php?ip=';
				$ipjson			= $this->posttohosts($ipapi, array('ip'=>$data['ip2']));
				if($ipjson){
					$iparr	= json_decode($ipjson, true);
					//print_r($iparr);
					if(intval($iparr['code']) == 0){
						if(!$row['region']) $data['region']	= $iparr['data']['region'];
						if(!$row['city']) $data['city']	= $iparr['data']['city'];
						if(!$row['isp']) $data['isp']	= $iparr['data']['isp'];
					}
				}
			}
			
			$result		= $mob->where("mobile = '" .$mobile. "'")->save($data);
			if($result){
				$json['status']	= 2;
				$json['info']	= '欢迎您加入, 我们会提供优质的服务。'; 
				
				//$_SESSION['userid'] 	= $row['id'];
				//$_SESSION['username'] 	= '匿名考友';	
				
				$json['session_id']		= session_id();
				
				//session_destroy();
			
				$this->ajaxReturn($json);
			}
			
			$json['status']	= -5;
			$json['info']	= '发生异常，请再重新提交验证一次。'; 
			$this->ajaxReturn($json);
		}
		
		
		$data	= array(
			'valid_mobile' 	=> 1,
			'ip2' 			=> get_client_ip(),
			'updatetime' 	=> time(),
			'send'			=> 1
		);
		
		
			//根据IP获取省，市，运营商
			if(!$row['region'] || !$row['city']){
				$ipapi			= 'http://ip.taobao.com/service/getIpInfo.php?ip=';
				$ipjson			= $this->posttohosts($ipapi, array('ip'=>$data['ip2']));
				if($ipjson){
					$iparr	= json_decode($ipjson, true);
					//print_r($iparr);
					if(intval($iparr['code']) == 0){
						if(!$row['region']) $data['region']	= $iparr['data']['region'];
						if(!$row['city']) $data['city']	= $iparr['data']['city'];
						if(!$row['isp']) $data['isp']	= $iparr['data']['isp'];
					}
				}
			}
		
		
		
		
		
		$result		= $mob->where("mobile = '" .$mobile. "'")->save($data);
		if($result){
			$json['status']	= 1;
			$json['info']	= '欢迎您加入, 我们会提供优质的服务。'; 
			
			//$_SESSION['userid'] 	= $row['id'];
			//$_SESSION['username'] 	= '匿名考友';	
			$json['session_id']		= session_id();
			$this->ajaxReturn($json);
		}
		
		$nums					= 3 - intval($codenums);
		$_SESSION[$cookiename] 	= $codenums + 1;
		
		$json['status']	= -4;
		$json['nums']	= $nums;
		$json['info']	= '邀请码验证失败,请重新输入,剩余'.$nums.'次机会。'; 
		$this->ajaxReturn($json);
	}
	
	
	
	
	
	/**
	 * 生成随机字符串
	 */
	function randchar($length){
		
		$str 	= null;
	   	$strPol = "0123456789abcdefghijklmnopqrstuvwxyz";
	   	$max 	= strlen($strPol)-1;
	
	   	for($i=0;$i<$length;$i++){
			
			//rand($min,$max)生成介于min和max两个数之间的一个随机整数
			$str.=$strPol[rand(0,$max)];
	   	}
	
	   return $str;
  	}
	
	/**
	 * 调用短信接口 **发送短信
	 *
	 * @param   string   $url       短信接口地址
	 * @param   array    $data      发送数据信息
	 * @return  string   $response  请求返回的数据
	 */
	function posttohosts($url, $data)
	{
        $url = parse_url($url);
        if (!$url) return "couldn't parse url";
        if (!isset($url['port'])) { $url['port'] = ""; }
        if (!isset($url['query'])) { $url['query'] = ""; }
        $encoded = "";
        while (list($k,$v) = each($data))
        {
                $encoded .= ($encoded ? "&" : "");
                $encoded .= rawurlencode($k)."=".rawurlencode($v);
        }
        $fp = fsockopen($url['host'], $url['port'] ? $url['port'] : 80);
        if (!$fp) return "Failed to open socket to $url[host]";
        fputs($fp, sprintf("POST %s%s%s HTTP/1.0\n", $url['path'], $url['query'] ? "?" : "", $url['query']));
        fputs($fp, "Host: $url[host]\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
        fputs($fp, "Content-length: " . strlen($encoded) . "\n");
        fputs($fp, "Connection: close\n\n");
        fputs($fp, "$encoded\n");
        $line = fgets($fp,1024);
        if (!eregi("^HTTP/1\.. 200", $line)) return;
        $results = "";
        $inheader = 1;
        while(!feof($fp))
        {
                $line = fgets($fp,1024);
                if ($inheader && ($line == "\n" || $line == "\r\n"))
                {
                        $inheader = 0;
                }
                elseif (!$inheader)
                {
                        $results .= $line;
                }
        }
        fclose($fp);
        return $results;
	}
}