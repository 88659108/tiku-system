<?php
namespace Paper\Controller;
use Think\Controller;
class AnswerController extends Controller {
	
	//作答
	public function index(){
		
		//接收参数
		$paperid	= I('paperid', 0, 'int');
		$getinfo	= I('getinfo', 0, 'int');
		$userid		= intval(get_sessions('userid'));
		
		if($userid == 0){
			$this->error('请先登录..', '/index.php/Paper/Index/', 3);		
		}
		
		if($paperid == 0){
			$this->error('答卷不存在..', '/index.php/Paper/Index/', 3);		
		}
		
		$upaper			= D('UserPaper')->table($userid);
		$chart_field	= ',ranking,addtime,subtime,score,analysis';
		$click_field	= ',marks,collects,notes,bugs';
		
		$upinfo			= $upaper->info($paperid, $userid, 'id,title,paperid,userid,status,totals,dataview,qnums,speed,totaltime,usetime'.$chart_field.$click_field);
		if(!$upinfo){
			$this->error('答卷不存在..', '/index.php/Paper/Index/', 3);		
		}
		
		//试卷数据格式化
		$dataview		= json_decode($upinfo['dataview'], true);
		if(!$dataview){
			$this->error('答卷存在异常,请重新申请..', '/index.php/Paper/Index/', 3);		
		}
		
		//异步加载答题卡
		if($getinfo == 1) $this->getPaperInfo($upinfo);
		
		
		//异步加载试题
		if($getinfo == 2) $this->getPaperQuestion($upinfo, $dataview);
		
		
		//异步保存试卷作答
		if($getinfo == 3) $this->savePaperAnswer($upinfo, $dataview);
		
		
		//异步交卷
		if($getinfo == 4) $this->submitPaperAnswer($upinfo, $dataview);
		
		
		//重点标记,收藏,笔记,纠错
		if($getinfo == 100) $this->setValuesCollects($upinfo);
		
		//笔记
		if($getinfo == 102) $this->setNotes($upinfo);
		
		
		//如果是交卷状态[查看解析]
		if($getinfo == 5 && $upinfo['status'] == 1) $this->showPaperBack($upinfo, $dataview);
		
		//如果是交卷状态
		if($upinfo['status'] == 1) $this->showPaperChart($upinfo, $dataview);
		
		
		$this->navs		= $dataview['navs'];
		$this->speed	= $upinfo['qnums'] - $upinfo['speed'];
		$this->upinfo	= $upinfo;
		
    	
		$this->display('index');
    }
	
	/**
	 * 试卷分析报表
	 */
	private function showPaperChart($upinfo, $dataview){
		
		$this->speed	= $upinfo['qnums'] - $upinfo['speed'];
		$this->upinfo	= $upinfo;
		
		//答题卡
		$navs			= $dataview['navs'];
		foreach($navs as $key=>$val){
			$navs[$key]['item']	= $dataview['item'][$val['key']];
			
			//分析报表
			$ct_navs[]	= "'".$val['title']."'";
			$ct_err[]	= $val['errscore'];
			$ct_null[]	= $val['nullscore'];
			$ct_score[]	= $val['score'];
			
			$ct_time[]	= $val['usetime'];
			$ct_accy[]	= $val['accuracy'];
		}
		$this->navs		= $navs;
		
		//母卷信息
		$paper			= D('Paper');
		$pinfo			= $paper->info($upinfo['paperid'], 'id, title, topscore, avescore');
		$this->pinfo	= $pinfo;
		
		//分析报表
		$chart			= array();
		$chart['navs']	= implode(',', $ct_navs);
		
		
		$chart['accy']	= implode(',', $ct_accy);
		$chart['time']	= implode(',', $ct_time);
		
		$chart['err']	= implode(',', $ct_err);
		$chart['null']	= implode(',', $ct_null);
		$chart['score']	= implode(',', $ct_score);
		
		//成绩走势
		$chart['avescore']	= array(0,$pinfo['avescore'],$pinfo['avescore'],$pinfo['avescore'],$pinfo['avescore'],
								  	  $pinfo['avescore'],$pinfo['avescore'],$pinfo['avescore'],$pinfo['avescore'],$pinfo['avescore'],$pinfo['avescore']);
		$chart['avescore']	= implode(',', $chart['avescore']);
			
		//我的成绩
		$upaper				= D('UserPaper')->table($upinfo['userid']);
		$chart['scorelist']	= $upaper->where('userid=' . $upinfo['userid'])->order('id desc')->getField('score', true);
		$chart['scorelist']	= implode(',', $chart['scorelist']);
		if($chart['scorelist']) $chart['scorelist'] = '0,' . $chart['scorelist'];
		
		//其他用户[对比]
		$chart['userscore']	= $upaper->where('paperid=' . $upinfo['paperid'])->order('id desc')->getField('score', true);
		$chart['userscore']	= implode(',', $chart['userscore']);
		if($chart['userscore']) $chart['userscore'] = '0,' . $chart['userscore'];
		
		
		$this->chart		= $chart;
		
		
		//用户信息[使用$upinfo['userid']进行查询,使用session]
		$this->userinfo		= array('username'=>'pp1073', 'image'=>'user-img.gif');
		
		
		//知识点详细
		$clslist			= json_decode($upinfo['analysis'], true);
		$this->clslist		= $clslist;
		

		//显示模板
		$this->display('chart');
		exit;
	}
	
	
	/**
	 * 试卷回顾
	 */
	private function showPaperBack($upinfo, $dataview){
		
		$this->navs		= $dataview['navs'];
		$this->speed	= $upinfo['qnums'] - $upinfo['speed'];
		$this->upinfo	= $upinfo;
		
		
		//显示模板
		$this->display('back');
		exit;
	}
	
	
	/**
	 * 异步加载答题卡
	 */
	private function getPaperInfo($upinfo){
		
		$data			= array();
		$data['status']	= 1;
		$data['upinfo']	= array(
			'dataview'	=> $upinfo['dataview'],
			
			'marks'		=> $upinfo['marks'],
			'collects'	=> $upinfo['collects'],
			'notes'		=> $upinfo['notes'],
			'bugs'		=> $upinfo['bugs']
		);
		
		$this->ajaxReturn($data);
	}
	
	
	/**
	 * 异步加载试题
	 */
	private function getPaperQuestion($upinfo, $dataview){
		
		
		$model		= I('model', 0, 'int');
		
		
		$data			= array();
		$data['status']	= 1;
		
		//查找当前nav
		$data['nav']	= array();
		foreach($dataview['navs'] as $key=>$val){
			if($val['key'] == $model){
				$data['nav']	= $val;
				break;
			}
		}
		
		$question		= D('Teaching/Question');
		$list			= $dataview['item'][$model];
		foreach($list as $key=>$val){
			
			//客观题
			if($val['son'] == 0){
				$qinfo	= $question->selectQuestion($val['qid']);
				
				//字段过滤[格式化]
				$val		= $this->questionFields($qinfo, $val);
			
				
			//资料题	
			}else{
				
				//{"qid":"1603", "son":"5", "sonlist":{"0":{"qid":"28693", "answer":"C", "uanswer":"D"}, "3":{"qid":"28696", "answer":"B", "uanswer":"B"}}
				$qinfo				= $question->selectMaterial($val['qid']);
				$val['material']	= $qinfo['material'];
				
				//处理子题列表
				$sonlist			= $qinfo['sonlist'];
				$sonlist1			= $val['sonlist'];
				foreach($sonlist as $k=>$v){
					
					//字段过滤[格式化]
					$v				= $this->questionFields($v, $sonlist1[$k]);
					$sonlist[$k]	= $v;
				}
				$val['sonlist']		= $sonlist;
			}
			
			$list[$key]				= $val;
		}
		
		
		$data['dataview']			= $list;
		$this->ajaxReturn($data);
	}
	
	
	//格式化试题输出字段
	private function questionFields($qinfo, $question){
		
		//客观题字段[查询]
		$info	=  array(
			
			'qid'			=> $qinfo['sourceid'],//$qinfo['id'],
			'body'			=> $qinfo['body'],
			'options'		=> $qinfo['options'],
			'description'	=> $qinfo['description'],
			'answer'		=> $qinfo['answer'],
			'wrongans'		=> $qinfo['wrongans'],
			'optiontype'	=> $qinfo['optiontype'],
			'views'			=> $qinfo['views'],
			'errnums'		=> $qinfo['errnums'],
			'collects'		=> $qinfo['collects'],
			'values'		=> $qinfo['values'],
			'loglist'		=> $qinfo['loglist'],
			'pointname'		=> $qinfo['pointname']
		);
		
		$question['info']	= $info;
		
		//返回结果
		return $question;
	}
	
	
	//保存试卷作答
	private function savePaperAnswer($upinfo, $dataview){
		
		//接收作答数据
		$paperdata	= $_POST['paperdata'];
		$datainfo	= json_decode($paperdata, true);
		if(!$datainfo){
			$data['status']		= 0;
			$data['info']		= '数据错误，请重新保存';
			$this->ajaxReturn($data);
		}
		
		//存储答案
		$dataview['navs']	= $this->updateNavs($dataview['navs'], $datainfo['navs']);
		$dataview['item']	= $this->updateItem($dataview['item'], $datainfo['item']);
		
		$updata		= array(
			'dataview'	=> json_encode($dataview),
			'speed'		=> $datainfo['speed'],
			'usetime'	=> $datainfo['papertime'],
			'updatetime'=> time()
		);
		
		//保存数据
		$upaper			= D('UserPaper')->table($upinfo['userid']);
		$results		= $upaper->where('id=' . $upinfo['id'] . ' AND userid=' . $upinfo['userid'])->save($updata);
		
		$data			= array('status'=>0, 'info'=>'');
		if($results){
			$data['status']		= 1;
			$data['info']		= '答案保存成功';
		}
		
		$this->ajaxReturn($data);
	}
	
	//模块
	private function updateNavs($dataview, $datainfo){
		if(!$datainfo) return $dataview;
		
		foreach($dataview as $key=>$val){
			foreach($datainfo as $k=>$v){
				if($val['key']	== $v['key']){
					$val['usetime']	= intval($v['usetime']);
					$val['speed']	= intval($v['speed']);
				}
			}
			
			$dataview[$key]	= $val;
		}
		
		return $dataview;
	}
	
	//试题
	private function updateItem($dataview, $datainfo){
		if(!$datainfo) return $dataview;
		
		//遍历答案
		foreach($datainfo as $key=>$list){
			
			//没有答案,则下一个模块
			if(count($list) == 0) continue;
			
			//获得[试卷试题]
			$item	= $dataview[$key];
			
			//遍历试题作答
			foreach($list as $k=>$v){
				
				//遍历[试卷试题]
				foreach($item as $kk=>$val){
					if($v['qid'] == $val['qid']){
						
						//客观题
						if(intval($v['sonqid']) == 0){
							$val['usetime']	= intval($v['usetime']);
							$val['uanswer']	= strtoupper(trim($v['uanswer']));
							$val['answer']	= strtoupper(trim($v['answer']));
						
						//资料题子题	
						}else{
							$val['sonlist'][$v['sonindex']]	= array(
								'qid'		=> intval($v['sonqid']),
								'usetime'	=> intval($v['usetime']),
								'uanswer'	=> strtoupper(trim($v['uanswer'])),
								'answer'	=> strtoupper(trim($v['answer']))
							);
						}
					}
					
					$item[$kk]	= $val;
				}
			}
			
			$dataview[$key]		= $item;
		}
		
		return $dataview;
	}
	
	
	//交卷
	private function submitPaperAnswer($upinfo, $dataview){
		
		//查询母卷
		$paper			= D('Paper');
		$pinfo			= $paper->info($upinfo['paperid'], 'id, title, topscore, avescore, submits, loglist');
		
		//阅卷[简单智能分析]
		$upaperlc		= D('UserPaper', 'Logic');	
		$params			= array(
			'userid'	=>$upinfo['userid'], 
			'upaperid'	=>$upinfo['id'], 
			'paperid'	=>$upinfo['paperid'], 
			'speed'		=>$upinfo['speed']);
		
		$logicinfo		= $upaperlc->submitPaper($dataview, $params);
		$updata			= array(
			
			//状态[交卷]
			'status'	=> 1,										
			
			//得分
			'score'		=> $logicinfo['score'],			
			
			//正确率
			'accuracy'	=> $logicinfo['accuracy'],
			
			//错题数量
			'errnums'	=> $logicinfo['errnums'],	
			
			//增加模块分析结果
			'dataview'	=> json_encode($logicinfo['dataview']),	
			
			//交卷时间
			'subtime'=> time(),
			
			//击败xx.xx%人
			'ranking'	=> round($upaperlc->rankPaper($logicinfo, array('avescore'=>$pinfo['avescore'], 'topscore'=>$pinfo['topscore'])), 2)
		);
		
		//母卷： 最高分, 平均分, 交卷人数
		$pdata			= array(
			'topscore'	=> round(($updata['score'] > $pinfo['topscore']) ? $updata['score'] : $pinfo['topscore'], 2),
			'avescore'	=> round(($pinfo['avescore'] * $pinfo['submits'] + $updata['score']) / ($pinfo['submits'] + 1), 2),
			'submits'	=> $pinfo['submits'] + 1
		);
		
		//母卷日志[最近5条]
		if(!$pdata['loglist'] || $updata['score'] > 50){
			
			$topnums	= 5;
			$loglist	= ($pinfo['loglist']) ? json_decode($pinfo['loglist'], true) : array();
			if(count($loglist) >= $topnums){ array_splice($loglist, 0, 1); }
			
			$loginfo	= array('userid'=>$upinfo['userid'], 'upaperid'=>$upinfo['id'], 'time'=>time(), 'score'=>$updata['score'], 'typeid'=>2);
			$loglist[]	= $loginfo;
			$pdata['loglist']	= json_encode($loglist);
		}
		$results		= $paper->where('id=' . $upinfo['paperid'])->save($pdata);
		
		
		//保存数据[答卷]
		$upaper			= D('UserPaper')->table($upinfo['userid']);
		$results		= $upaper->where('id=' . $upinfo['id'] . ' AND userid=' . $upinfo['userid'])->save($updata);
		$data			= array('status'=>0, 'info'=>'');
		if($results){
			$data['status']		= 1;
			$data['info']		= '成功交卷';
			
			
			//深度智能分析
			$upaperlc->analysisFactory($params);
		}
		
		$this->ajaxReturn($data);
	}

	
	//报表
	public function chart(){
		
		
	}
	
	//解析
	public function explain(){
		
		
	}
	
	//讨论
	public function ask(){
		
		
	}
	
	
	
	/**
	 * 重点标记,收藏
	 */
	private function setValuesCollects($upinfo){
		
		/**
		 * 1 == marks    重点标记
		 * 2 == notes    笔记
		 * 0 == collects 收藏 
		 *
		 */
		$model		= I('model', 0, 'int');
		
		$field		= ($model == 1) ? 'marks' : 'collects';
		if($model == 2) $field	= 'notes';
		if($model == 3) $field	= 'bugs';
		
		$qid		= I('qid', 0, 'int');
		$off		= I('off', 0, 'int');
		$msg		= I('msg', '');
		$err		= I('err', '');
		if($field == '' || $qid == 0 || ($model == 2 && $msg == '')){
			$this->error('请求错误或缺少参数..', '/index.php/Paper/Index/', 3);		
		}
		
		//本卷
		if($model == 2 || $model == 3){
			$values			= ($upinfo[$field]) ? json_decode($upinfo[$field], true) : array();
		
		}else{
			$values			= ($upinfo[$field]) ? explode(',', $upinfo[$field]) : array();
		}
		
		//本题
		$objq			= D('Teaching/Question');
		
		//集合
		$uqlt			= D('UserQList')->table($upinfo['userid']);
		
		//试题集
		$qnots			= D('UserNotes')->table($qid);
		
		//增加
		if($off == 1){
			
			//试卷
			if($model == 2 || $model == 3){
				$values[$qid]	= array('qid'=>$qid, 'err'=>$err, 'msg'=>$msg, 'time'=>time());
				
				$uqinfo			= $uqlt->info($upinfo['userid'], $qid, $model, 'id');
				
			}else{
				$values[]		= $qid;
				$values			= array_unique($values);
			}
			
			//日志：更新笔记, 纠错
			if($uqinfo && ($model == 2 || $model == 3)){
				$uqlt->where('id=' . $uqinfo['id'])->save(array('msg'=>$msg, 'err'=>$err));
				
				$where	= 'userid=' . $upinfo['userid'] . ' AND qid=' . $qid . ' AND typeid='. $model;
				$qnots->where($where)->save(array('msg'=>$msg, 'err'=>$err));
			}
			
			//日志：添加笔记, 收藏, 重点标记
			if(!$uqinfo || ($model == 0 || $model == 1)){
				
				//试题
				$objq->where('sourceid='.$qid)->setInc($field);
			
				$qinfo				= $objq->info($qid, 'qyear, bigtype, smalltype, pointtype');
				$qinfo['qid']		= $qid;
				$qinfo['userid']	= $upinfo['userid'];
				$qinfo['upaperid']	= $upinfo['id'];
				$qinfo['addtime']	= time();
				$qinfo['paperid']	= $upinfo['paperid'];
				$qinfo['typeid']	= $model;
				$qinfo['msg']		= $msg;
				$qinfo['err']		= $err;
				$uqlt->data($qinfo)->add();
				               
				if($model == 2 || $model == 3){
					$qnots->data($qinfo)->add();
				}
			}
		
		//减少	
		}else{
			
			//试题
			$objq->where('sourceid='.$qid)->setDec($field);
			
			//试卷
			if($model == 2 || $model == 3){
				unset($values[$qid]);
				
				$where	= 'userid=' . $upinfo['userid'] . ' AND qid=' . $qid . ' AND typeid='. $model;
				$qnots->where($where)->delete();
				
			}else{
				$key = array_search($qid, $values);
				if($key !== false) array_splice($values, $key, 1);
			}
			
			//日志
			$uqlt->where('typeid = '. $model .' AND qid=' . $qid .  ' AND userid = ' . $upinfo['userid'])->delete();
		}
		
		//更新试卷
		$updata		= array(
			$field => ($model == 2 || $model == 3) ? json_encode($values) : implode(',', $values)
		);
		$upaper		= D('UserPaper')->table($upinfo['userid']);
		$results	= $upaper->where('id=' . $upinfo['id'] . ' AND userid=' . $upinfo['userid'])->save($updata);
		
		//返回数据
		$data			= array('status'=>0, 'info'=>'');
		if($results){
			$data['status']		= 1;
			$data['info']		= '操作成功';
			
			//查询同类型人数
			$data['nums']		= intval($objq->where('sourceid='.$qid)->getField($field));
		}
		
		$this->ajaxReturn($data);
	}
	
	
	/**
	 * 笔记,纠错
	 *
	 */
	public function getList(){
		
		//接收参数
		$qid		= I('qid', 0, 'int');
				
		/**
		 * 1 == marks    重点标记
		 * 2 == notes    笔记
		 * 0 == collects 收藏 
		 *
		 */
		$model		= I('model', 0, 'int');
		if($qid == 0){
			$this->error('参数丢失..', '/index.php/Paper/Index/', 3);		
		}
		
		$notes		= D('UserNotes')->table($qid);
		$list		= $notes->getlist($qid, $model, '*');
		//print $notes->_sql();
		
		$data		= array('list'=>$list);
		$this->ajaxReturn($data);
	}
	
	
	/**
	 * 获得试题疑问
	 *
	 */
	public function getAskQuestions(){
		
		
		$data		= array();
		$qid		= I('qid', 0, 'int');
		$mckey		= 'upaper-ask-question-qid-' . $qid;
		$asklist	= S($mckey);
		if($asklist){
			$data['asklist']	= $asklist;
			$this->ajaxReturn($data);
		}
		
		//查询试题分类
		$objq		= D('Teaching/Question');
		$qinfo		= $objq->info($qid, 'qyear, bigtype, smalltype, pointtype');
		
		//问答列表
		$ask		= D('Ask/AskQuestion');
		$limit		= 5;
		$field		= 'question_id, question_content, agree_count, answer_users, view_count';
		$order		= 'agree_count DESC, view_count DESC';
		
		//查询本题
		$asklist	= $ask->where('tiku_qid='.$qid)->field($field)->order($order)->limit($limit)->select();
		if(!$asklist){
			
			//查询小知识点
			if(intval($qinfo['pointtype']) > 0){
				$asklist	= $ask->where('tiku_pointtype='.$qinfo['pointtype'])->field($field)->order($order)->limit($limit)->select();
			}
			
			//查询中知识点
			if(!$asklist){
				$asklist	= $ask->where('tiku_smalltype='.$qinfo['smalltype'])->field($field)->order($order)->limit($limit)->select();
			}
			
			//查询一级知识点
			if(!$asklist){
				$asklist	= $ask->where('tiku_bigtype='.$qinfo['bigtype'])->field($field)->order($order)->limit($limit)->select();
			}	
		}
		
		//为每个问题 查询一个最高关注的答案
		if($asklist){
			$ask_ans		= D('Ask/AskQuestionAnswer');
			foreach($asklist as $key=>$val){
				
				$limit			= 2;
				$where			= 'question_id=' . $val['question_id'];
				$field			= 'answer_content, comment_count, agree_count, thanks_count, uid, add_time';
				$order			= 'agree_count DESC, thanks_count DESC';
				$val['anslist']	= $ask_ans->where($where)->field($field)->order($order)->limit($limit)->select();
				
				$asklist[$key]	= $val;
			}	
		}
		
		
		S($mckey, $asklist, 3600);
		$data['asklist']	= $asklist;
		$this->ajaxReturn($data);
	}
	
	
	/**
	 * 设置试题疑问
	 *
	 */
	public function setAskQuestions(){
		
		$askid		= I('askid', 0, 'int');
		$qid		= I('qid', 0, 'int');
		$paperid	= I('paperid', 0, 'int');
		$upaperid	= I('upaperid', 0, 'int');
		
		//查询试题分类
		$objq		= D('Teaching/Question');
		$qinfo		= $objq->info($qid, 'qyear, bigtype, smalltype, pointtype');
		
		//更新问答
		$ask		= D('Ask/AskQuestion');
		$row		= $ask->where('question_id=' . $askid)->data(array(
			'tiku_qid'			=> $qid,
			'tiku_year'			=> $qinfo['qyear'],
			'tiku_bigtype'		=> $qinfo['bigtype'],
			'tiku_smalltype'	=> $qinfo['smalltype'],
			'tiku_pointtype'	=> $qinfo['pointtype'],
			'tiku_paperid'		=> $paperid,
			'tiku_upaperid'		=> $upaperid
		))->save();
		
		
		//邀请学霸
		$data				= array();
		$data['status']		= 1;
		
		//查询知识点
		$objc		= D('Teaching/QuestionClass');
		if(intval($qinfo['pointtype']) > 0) $clsid	= intval($qinfo['pointtype']);
		if(intval($clsid) == 0) $clsid	= intval($qinfo['smalltype']);
		if(intval($clsid) == 0) $clsid	= intval($qinfo['bigtype']);
		$data['classname']	= $objc->where('id=' . $clsid)->getField('title');;
		
		
		$this->ajaxReturn($data);
	}
	
}