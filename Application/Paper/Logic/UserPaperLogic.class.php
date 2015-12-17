<?php
namespace Paper\Logic;
class UserPaperLogic{
	
	
	/**
	 * 申请一张试卷
	 *
	 * @param    int    $paperid     母卷主键
	 * @param    int	$userid		 用户主键
	 * @param	 string $dataview	 答卷描述
	 * @param    string $title		 试卷标题
	 * @param    array	$params		 其他参数[可选,有默认值]
	 					$params['qnums']		= 计算	试卷题数
						$params['totals']		= 100	试卷总分
						$params['totaltime']	= 7200  单位'秒',规定用时(2个小时)
						$params['gameinfo']		= array 邀请信息 uid,pid,msg
						
	 * @return	 array('paperid' => 0, 'msg' => '')		paperid大于0,则生成成功
	 */
	public function apply($paperid, $userid, $dataview, $title, $params = array()){
		
		/**
		 * 初始化参数
		 * 根据具体参数执行具体任务
		 * 进行数据合法性检查
		 * 入库
		 * 返回主键
		 */
		
		//试卷题数
		if(intval($params['qnums']) == 0){
			$datainfo					= json_decode($dataview, true);
			$params['qnums']			= intval($datainfo['info']['qnums']);	
		}
		
		//试卷总分				
		if(intval($params['totals'])   == 0){ $params['totals']	= 100; }
		
		//单位'秒',规定用时(2个小时)
		if(intval($params['totaltime']) == 0){ $params['totaltime'] = 7200; }
		
		$data			= array(
			'title'		=> $title,
			'paperid'	=> $paperid,
			'userid'	=> $userid,
			'dataview'	=> $dataview,
			'qnums'		=> $params['qnums'],
			'totals'	=> $params['totals'],
			'totaltime'	=> $params['totaltime']
		);
		
		//如果是邀请挑战
		$gamemsg		= trim($params['gameinfo']['gamemsg']);
		$gameuid		= intval($params['gameinfo']['gameuid']);
		$gamepid		= intval($params['gameinfo']['gamepid']);
		if($gameuid > 0 && $gamepid > 0){
			$data['gameinfo']	= json_encode($params['gameinfo']);	
		}
				
		//返回数据
		$return			= array('paperid' => 0, 'msg' => ''); 
		
		//验证数据
		$upaper			= D('UserPaper')->table($userid);
		if (!$upaper->create($data, 1)){
     		$return['msg']		= $upaper->getError();
			return $return;
		}
		
		//答卷入库
		$insertid 				= $upaper->add();
		
		//如果是邀请挑战
		$result					= true;
		if($gameuid > 0 && $gamepid > 0 && $insertid > 0){
			$result				= $this->joinGame($gamemsg, $insertid, $userid, $gameuid, $gamepid);
		}
		
		//记录用户日志
		//....  zb_userlog_0
		
		//返回状态
		if($insertid > 0 && $result){
			$return['msg']		= 'ok';
			$return['paperid']	= $insertid;
		}
		
		return $return;
	}


	/**
	 * 被邀请(挑战某张答卷)
	 */
	public function joinGame($msg, $upaperid, $userid, $touserid, $toupaperid){
		
		/**
		 * 根据对方获得试卷所在散列分表
		 * @查询试卷
		 * @将自己加入试卷参战列表
		 * @让用户不再可以参战(以防重复参战)
		 * @通知提示邀请者,有用户参战了..
		 * @返回成功
		 */
		 
		/**
		 * 参战数据格式(json)
		 * $json	= [{"userid":1073,"upaperid":100,"msg":"\u624d\u4e0d\u6015\u5462!"},{"userid":1033,"upaperid":215,"msg":"\u6bd4\u5c31\u6bd4!"}];
		 */ 
		
		//查询邀请挑战
		$upaper		= D('UserPaper')->table($touserid);		
		$row		= $upaper->field('joinuser')->find($toupaperid); 
		
		//加入挑战
		$users		= ($row['joinuser']) ? json_decode($row['joinuser'], true) : array();
		$users[]	= array('gameuid'=>$userid, 'upaperid'=>$upaperid, 'gamemsg'=>$msg);
		$joinuser	= json_encode($users);
		
		//更新
		$data		= array('joinuser' => $joinuser);
		$result		= $upaper->where('id=' . $toupaperid)->save($data);
		
		//* @让用户不再可以参战(以防重复参战)
		//* @通知提示邀请者,有用户参战了..
		//更新消息?  ---待处理
		
		
		return $result;
	}
	
	
	
	/**
	 * 提交试卷[阅卷]
	 *
	 * @param   array $dataview  用户答卷
	 * @param   array $params    附加参数
	 *          int   $userid    用户
	 *          int   $upaperid  答卷
	 *          int   $speed     整卷进度	 
	 
	 * @param   array   
	 */
	public function submitPaper($dataview, $params){
		
		//附加参数
		$userid		= intval($params['userid']);
		$upaperid	= intval($params['upaperid']);
		$speed		= intval($params['speed']);
		
		/**
		 * 返回的阅卷结果：
		 *
		 * score      得分
		 * accuracy   正确率
		 * errnums	  错题数
		 * errlist	  错题集合
		 * dataview	  试卷代码[模块失分, 模块得分]
		 */
		
		$navs	= $dataview['navs'];
		$item	= $dataview['item'];
		
		
		/**
		 * 整卷统计:
		 *
		 * score      得分
		 * accuracy   正确率
		 * errnums	  错题数
		 * errlist	  错题集合 
		 */
		$score = 0; $accuracy = 0; $errnums = 0; $errlist = array();
		foreach($navs as $nkey => $nval){
			
			/**
			 * $nval['accuracy'] 模块正确率
			 * $nval['errnums']  模块错题数
			 * $nval['errscore'] 模块失分
			 * $nval['score']    模块得分
			 */
			 
			
			//初始化
			$nval['accuracy'] 	= 0;	
			$nval['errnums'] 	= 0;
			$nval['errscore'] 	= 0;
			$nval['score'] 		= 0;
			$nval['nullscore'] 	= 0;
			
			//试题列表
			$list	= $item[$nval['key']];
			foreach($list as $lkey => $lval){
				
				/**
				 * 批阅每一道试题[包括资料题]
				 *
				 * 打上"阅卷标记"
				 * check ==  0   未答
				 * check ==  1   正确
				 * check == -1   错误
				 * 
				 */
				
				//获得试题打分
				$subscore		= $this->subPaperScore($lkey, $nval);
				$lval['score']	= $subscore;
				
				
				//作答不正常，都作为“未答”处理[资料题除外]
				if(!$lval['uanswer'] && intval($lval['son'] == 0)){
					
					//标记“未答”
					$lval['check']		 = 0;
					$list[$lkey]		 = $lval;
					
					//未作答[失分]
					$nval['nullscore'] 	+= $subscore;
					
					
					$errlist[]			 = $lval;
					continue;
				}
				
				
				
				//如果批阅：客观题 ***************************************************************************/
				if(intval($lval['son']) == 0){
					
					
					//答案错误
					if(strtoupper(trim($lval['uanswer'])) != strtoupper(trim($lval['answer']))){
						
						//模块
						$nval['errscore'] 	+= $subscore;	//错误[失分]
						$nval['errnums']	+= 1;
						
						//整卷
						$errnums			+= 1;
						$errlist[]			 = $lval;
					
						//标记“错误”
						$check				 = -1;
					
					
					
					//答案正确
					}else{
					
						//模块
						$nval['score'] 		+= $subscore;
					
						//整卷
						$score				+= $subscore;
						
						//标记“正确”
						$check				 = 1;
					}
					
					
					//阅卷标记
					$lval['check']			 = $check;
					$list[$lkey]			 = $lval;
					continue;
				}
				
				
				
				//如果批阅：资料题 ***************************************************************************/
				$sonlist			= $lval['sonlist'];
				$sonerr				= 0;
				for($skey = 0;$skey<$lval['son'];$skey++){
					
					//资料题利用【索引】来确定子题位置，答题卡也使用了该索引
					$sval			= $sonlist[$skey];				
					
					//作答不正常，都作为“未答”处理
					if(!$sval['uanswer']){
						
						//标记“未答”
						$sval['check']		 	= 0;
						$lval['sonlist'][$skey]	= $sval;
						
						
						//未作答[失分]
						$nval['nullscore'] 	+= $subscore;
						
						$sonerr++;
						continue;
					}
					
					
					//答案错误
					if(strtoupper(trim($sval['uanswer'])) != strtoupper(trim($sval['answer']))){
						
						//模块
						$nval['errscore'] 	+= $subscore;
						$nval['errnums']	+= 1;
						
						//整卷
						$errnums			+= 1;
						$sonerr++;
						
						//标记“错误”
						$check				 = -1;
						
						
						
					//答案正确	
					}else{
					
						//模块
						$nval['score'] 		+= $subscore;
					
						//整卷
						$score				+= $subscore;
						
						//标记“错误”
						$check				 = 1;
					}
					
					
					//标记“未答”
					$sval['check']		 	 = $check;
					$lval['sonlist'][$skey]	 = $sval;
				}
				
				if($sonerr > 0){ $errlist[] = $lval; }
				
				$list[$lkey]				= $lval;
			}
			
			$dataview['item'][$nval['key']]	= $list;
			
			
			/**
			 * 完成一个模块的阅批
			 *
			 @ 处理模块的统计分析
			 * 
			 */
			//模块正确率
			$nval['accuracy']	= round(($nval['speed'] - $nval['errnums']) / $nval['speed'] * 100, 2);
			
			//覆盖模块
			$dataview['navs'][$nkey]	= $nval;
		}
		
		
		//整卷正确率
		if($errnums > 0 && $speed > 0){
			$accuracy	= round($errnums / $speed * 100, 2);
		}
		
		
		//统计数据也存一份进【试卷规则】
		$dataview['info']['score']		= $score;
		$dataview['info']['accuracy']	= $accuracy;
		$dataview['info']['errnums']	= $errnums;
		$dataview['info']['speed']		= $speed;
		
		
		//返回最终分析结果
		$info = array(
			'score' 		=> $score, 
			'accuracy'		=> $accuracy, 
			'errnums'		=> $errnums, 
			'dataview'		=> $dataview
		);
		
		//处理错题集合
		$this->insertError($errlist, $params);
		
		return $info;
	}
	
	
	/**
	 * 获得试题打分
	 */
	private function subPaperScore($index, $nav){
		
		//"subitem":[{"nums":20, "score":0.6},{"nums":20, "score":0.7}]
		
		//校正基数[试题编号]
		$index++;
		
		//打分配置列表
		$subitem	= $nav['subitem'];
		
		//只有一个配置项，则直接返回
		if(count($subitem) == 1) return $subitem[0]['score'];
		
		//否则遍历配置项
		$nums		= 0;
		foreach($nav['subitem'] as $key=>$val){
			
			//递增试题范围
			$nums	+= $val['nums'];
			if($nums < $index){ continue; }
			
			//得到[试题编号]所在区间的打分配置
			return 	$val['score'];
		}
		
		//应该不会运行到这句[否则，出现漏记分BUG]
		return 0;
	}
	
	
	/**
	 * 处理错题集
	 * 
	 * @param   array $errlist   错题集合
	 * @param   array $params    附加参数
	 *          int   $userid    用户
	 *          int   $upaperid  答卷
	 *          int   $paperid   母卷
	 * @param   bool
	 */
	private function insertError($errlist, $params){
		
		if(!is_array($errlist) || count($errlist) < 1) return false;
		
		//程序执行模式[及时模式[0]/异步队列[1]]
		$alstype		= 0;
		
		//异步
		if($alstype == 1){
			$jsondata	= array('errlist'=>$errlist, 'params'=>$params);
			$result		= queue_execute('userpaper_question_errlist', json_encode($jsondata));
			return $result;
		}
		//异步 *******************************************************************************
		
		
		//附加参数
		$userid			= intval($params['userid']);
		$upaperid		= intval($params['upaperid']);
		$paperid		= intval($params['paperid']);
		
		//试题
		$objq			= D('Teaching/Question');
		$errq			= D('UserErrQuestion')->table($userid);
		$material		= D('Teaching/QuestionMaterial');
		
		//批量数组
		$addlist		= array();

		//错题集[遍历，进行收录]
		foreach($errlist as $key=>$val){
			
			//查询错题是否收录
			$errwhere	= 'qid='.$val['qid'].' AND userid='.$userid;
			$errinfo	= $errq->where($errwhere)->field('qid')->find();
			//print '[1]'.$errq->_sql();
			
			//不存在，则收录错题
			if(!$errinfo){
				/**
				 * $field	= 'sourceid,qyear,bigtype,smalltype,pointtype,tagids'
				 * $qinfo	= $objq->where('sourceid='.$val['qid'])->field($field)->find();
				 */
				
				//客观题
				if(intval($val['son']) == 0){
					$qrow['sonlist'][0]	= $objq->selectQuestion($val['qid']);
					//print '[2]'.$objq->_sql();
				
				//资料题
				}else{
					$qrow				= $objq->selectMaterial($val['qid']);
					//print '[3]'.$objq->_sql();
				}
				
				foreach($qrow['sonlist'] as $k=>$qinfo){
					
					//如果是 资料题子题
					if(intval($val['son']) > 0){
						$errwhere		= 'qid='.$qinfo['sourceid'].' AND userid='.$userid;
						$errinfo		= $errq->where($errwhere)->field('qid')->find();
						//print '[4]'.$errq->_sql();
						
						//存在，则表示收录，直接更新答错次数
						if($errinfo){ 
							$errq->where($errwhere)->setInc('errnums');	
							//print '[5]'.$errq->_sql();
							continue;
						}	
					}
			
					$qdata	= array(
							'qid'		=> $qinfo['sourceid'],
							'qyear'		=> $qinfo['qyear'],
							'bigtype'	=> $qinfo['bigtype'],
							'smalltype'	=> $qinfo['smalltype'],
							'pointtype'	=> $qinfo['pointtype'],
							'tagids'	=> $qinfo['tagids'],
							'errans'	=> $val['uanswer'],
							'upaperid'	=> $upaperid,
							'userid'	=> $userid,
							'errnums'	=> 1,
							'paperid'	=> $paperid,
							'addtime'	=> time()
					);
					$addlist[]	= $qdata;
				}
				
				
			//否则，更新错误次数[错题集]	
			}else{
				$errq->where($errwhere)->setInc('errnums');
				//print '[6]'.$errq->_sql();	
			}
			
			
			//有答案说明答错 **更新试题错误次数[试题母表] 	
			if($val['uanswer'] || intval($val['son']) > 0){
				
				//[客观题]
				if(intval($val['son']) == 0){
					$objq->where('sourceid='.$val['qid'])->setInc('errnums');
					//print '[7]'.$objq->_sql();	
				
				//资料题 和 所有子题
				}else{
					$objq->where('materialid='.$val['qid'])->setInc('errnums');
					//print '[8]'.$objq->_sql();
					$material->where('sourceid='.$val['qid'])->setInc('errnums');
					//print '[9]'.$material->_sql();
				}
			}
		}
		
		//批量入库
		return $errq->addAll($addlist);
	}
	
	
	/**
	 * 计算击败多少人
	 *
	 * @param   array    $logicinfo     简单智能分析结果
	 * @param   array    $params        辅助参数
	 *          int      $topscore      母卷最高分
	 *          int      $avescore      母卷平均分
	 *
	 * @return  double
	 */
	public function rankPaper($logicinfo, $params){
		
		$score		= $logicinfo['score'];
		$avescore	= intval($params['avescore']);
		$topscore	= intval($params['topscore']);
		
		//优秀
		if($score > $topscore){
			$nums	= (rand(85, 98) / 100) * 100;
			return $nums + rand(10, 90) / 100;
		}
		
		//良好
		if($score > $avescore && $score < $topscore){
			$nums	= (rand(60, 83) / 100) * 100;
			return $nums + rand(10, 90) / 100;
		}
		
		//差
		$nums	= (rand(26, 42) / 100) * 100;
		
		return $nums + rand(10, 90) / 100;
	}
	
	
	/**
	 * 获得某个模块的信息
	 *
	 * @param   array   $navs     试卷头部模块
	 * @param   string  $name     模块名称
	 * @param   array             模块详细信息
	 */
	private function getNav($navs, $name)
	{
		if(!is_array($navs) || count($navs) < 1) return false;
		
		//遍历查找
		foreach($navs as $key=>$val){
			if(trim($val['title']) == trim($name)) return $val;	
		}
		
		return false;
	}
	
	
	/**
	 * 试卷智能分析[全局[用户级]]
	 * 
	 * @param   bool
	 */
	public function analysisUser($params){
		
		//附加参数
		$userid			= intval($params['userid']);
		$upaperid		= intval($params['upaperid']);
		$paperid		= intval($params['paperid']);
		$speed			= intval($params['speed']);
		
		if($userid == 0 || $upaperid == 0) return false;
		
		//程序执行模式[及时模式[0]/异步队列[1]]
		$alstype		= 0;
		if($alstype == 1){
			$jsondata	= $params;
			$result		= queue_execute('userpaper_user_analysis', json_encode($jsondata));
			return $result;
		}
		//异步 *******************************************************************************
		
		
		//查询答卷
		$upaper		= D('UserPaper')->table($userid);
		$upinfo		= $upaper->info($upaperid, $userid, 'score,dataview,usetime');
		if(!$upinfo){ return false; }

		$dataview	= json_decode($upinfo['dataview'], true);
		$mod_1		= $this->getNav($dataview['navs'], '常识判断');
		$mod_2		= $this->getNav($dataview['navs'], '言语理解与表达');
		$mod_3		= $this->getNav($dataview['navs'], '数量关系');
		$mod_4		= $this->getNav($dataview['navs'], '判断推理');
		$mod_5		= $this->getNav($dataview['navs'], '资料分析');
		
		//查询[用户智能分析集]
		$analysis	= D('UserAnalysis')->table($userid);
		$alsinfo	= $analysis->info($userid, '*');
		
		//增加
		if(!$alsinfo){
		
			$alsdata= array(
				'ranking'		=> 0.00,
				'classview'		=> array(),
				
				'userid'		=> $userid,
				'updatetime'	=> time(),
				'addtime'		=> time(),
				'score'			=> $upinfo['score'],
				
				'qnums'			=> $dataview['info']['speed'],
				'errnums'		=> $dataview['info']['errnums'],
				'accuracy'		=> $dataview['info']['accuracy'],
				'usetime'		=> $upinfo['usetime'],
				
				'qnums_q1'		=> $mod_1['speed'],
				'errnums_q1'	=> $mod_1['errnums'],
				'accuracy_q1'	=> $mod_1['accuracy'],
				'usetime_q1'	=> $mod_1['usetime'],
				
				'qnums_q2'		=> $mod_2['speed'],
				'errnums_q2'	=> $mod_2['errnums'],
				'accuracy_q2'	=> $mod_2['accuracy'],
				'usetime_q2'	=> $mod_2['usetime'],
				
				'qnums_q3'		=> $mod_3['speed'],
				'errnums_q3'	=> $mod_3['errnums'],
				'accuracy_q3'	=> $mod_3['accuracy'],
				'usetime_q3'	=> $mod_3['usetime'],
				
				'qnums_q4'		=> $mod_4['speed'],
				'errnums_q4'	=> $mod_4['errnums'],
				'accuracy_q4'	=> $mod_4['accuracy'],
				'usetime_q4'	=> $mod_4['usetime'],
				
				'qnums_q5'		=> $mod_5['speed'],
				'errnums_q5'	=> $mod_5['errnums'],
				'accuracy_q5'	=> $mod_5['accuracy'],
				'usetime_q5'	=> $mod_5['usetime']
			);
			$results			= $analysis->add($alsdata);	
		
		//更新
		}else{
			$alsinfo['score']		+= $upinfo['score'];
			
			$alsinfo['qnums']		+= $dataview['info']['speed'];
			$alsinfo['errnums']		+= $dataview['info']['errnums'];
			$alsinfo['accuracy']	 = round(($alsinfo['qnums'] - $alsinfo['errnums']) / $alsinfo['qnums'] * 100, 2);
			$alsinfo['usetime']		+= $upinfo['usetime'];
			
			$alsinfo['qnums_q1']	+= $mod_1['speed'];
			$alsinfo['errnums_q1']	+= $mod_1['errnums'];
			$alsinfo['accuracy_q1']	 = round(($alsinfo['qnums_q1'] - $alsinfo['errnums_q1']) / $alsinfo['qnums_q1'] * 100, 2);
			$alsinfo['usetime_q1']	+= $mod_1['usetime'];
			
			$alsinfo['qnums_q2']	+= $mod_2['speed'];
			$alsinfo['errnums_q2']	+= $mod_2['errnums'];
			$alsinfo['accuracy_q2']	 = round(($alsinfo['qnums_q2'] - $alsinfo['errnums_q2']) / $alsinfo['qnums_q2'] * 100, 2);
			$alsinfo['usetime_q2']	+= $mod_2['usetime'];
			
			$alsinfo['qnums_q3']	+= $mod_3['speed'];
			$alsinfo['errnums_q3']	+= $mod_3['errnums'];
			$alsinfo['accuracy_q3']	 = round(($alsinfo['qnums_q3'] - $alsinfo['errnums_q3']) / $alsinfo['qnums_q3'] * 100, 2);
			$alsinfo['usetime_q3']	+= $mod_3['usetime'];
			
			$alsinfo['qnums_q4']	+= $mod_4['speed'];
			$alsinfo['errnums_q4']	+= $mod_4['errnums'];
			$alsinfo['accuracy_q4']	 = round(($alsinfo['qnums_q4'] - $alsinfo['errnums_q4']) / $alsinfo['qnums_q4'] * 100, 2);
			$alsinfo['usetime_q4']	+= $mod_4['usetime'];
			
			$alsinfo['qnums_q5']	+= $mod_5['speed'];
			$alsinfo['errnums_q5']	+= $mod_5['errnums'];
			$alsinfo['accuracy_q5']	 = round(($alsinfo['qnums_q5'] - $alsinfo['errnums_q5']) / $alsinfo['qnums_q5'] * 100, 2);
			$alsinfo['usetime_q5']	+= $mod_5['usetime'];
			
			$alsinfo['updatetime']	 = time();
			$results				 = $analysis->where('userid=' . $userid)->save($alsinfo);
		}
		
		//全局[用户级]
		/**
		 * 正确率：整体, 五大模块
		 * 失分率： 五大模块
		 * 知识点：正确率, 失分率, [做题数/总题数]
		 * 统计项：错题记录， 错题总数， 做题总数， 各模块平均用时
		 */
		 
		return $results;
	}
	
	
	/**
	 * 试卷智能分析[局部[试卷级.答卷]]
	 * 
	 * @param   bool
	 */
	public function analysisPaper($params){
		
		//附加参数
		$userid			= intval($params['userid']);
		$upaperid		= intval($params['upaperid']);
		$paperid		= intval($params['paperid']);
		$speed			= intval($params['speed']);
		
		if($userid == 0 || $upaperid == 0) return false;
		
		//程序执行模式[及时模式[0]/异步队列[1]]
		$alstype		= 0;
		if($alstype == 1){
			$jsondata	= $params;
			$result		= queue_execute('userpaper_paper_analysis', json_encode($jsondata));
			return $result;
		}
		//异步 *******************************************************************************
		
		
		//查询答卷
		$upaper		= D('UserPaper')->table($userid);
		$upinfo		= $upaper->info($upaperid, $userid, 'id,userid,score,dataview,usetime');
		if(!$upinfo){ return false; }
		
		
		/**
		 * 遍历答卷  查询每个试题的 bigtype  smalltype  pointtype
		 * 数组： array(classid=>array(答对, 总数, 用时, 正确率)) >> 逐项累加
		 * 并存储所有分类的 classid， 并查询出树形结构
		 * 遍历树形结构, 附上每一个累加统计结果, 同时去除没有试题的分类项目
		 * 
		 */
 
		$objq		= D('Teaching/Question');
		$dataview	= json_decode($upinfo['dataview'], true);
		$list		= $dataview['item'];
		
		$cls_arr	= array();
		foreach($list as $key=>$val){
				
			foreach($val as $k=>$v){
				
				//客观题
				if(intval($v['son']) == 0){
					$qrow	= $objq->selectQuestion($v['qid']);
					
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
					}
					
					
				//资料题	
				}else{
					$sonlist	= $v['sonlist'];
					$slist		= $objq->where('materialid='.$v['qid'])->field('bigtype,smalltype,pointtype')->select();
					
					foreach($slist as $skey=>$sval){
						
						$v		= $sonlist[$skey];
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
						}
					}
				}
			}			
		}
			
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
		
		
		$updata		= array('analysis'=>json_encode($clslist));
		$results	= $upaper->where('id=' . $upinfo['id'] . ' AND userid=' . $upinfo['userid'])->save($updata);
		
		return $results;
		
		//局部[试卷级]
		/**
		 * 正确率：整卷, 五大模块
		 * 失分率： 五大模块
		 * 知识点：正确率, 失分率, [做题数/总题数]
		 * 统计项：错题总数
		 */
	}
	
	
	/**
	 * 试卷智能分析[局部[试卷级.母卷]]
	 * 
	 * @param   bool
	 */
	public function analysisSourcePaper($params)
	{
		
		//附加参数
		$userid			= intval($params['userid']);
		$upaperid		= intval($params['upaperid']);
		$paperid		= intval($params['paperid']);
		$speed			= intval($params['speed']);
		
		if($userid == 0 || $upaperid == 0) return false;
		
		
		//程序执行模式[及时模式[0]/异步队列[1]]
		$alstype		= 0;
		if($alstype == 0){
			$jsondata	= $params;
			$result		= queue_execute('userpaper_sourcepaper_analysis', json_encode($jsondata));
			return $result;
		}
		//异步 *******************************************************************************
		
		
		//母卷
		$paper		= D('Paper');
		$pinfo		= $paper->info($paperid, 'id, dataview, submits, analysis, aveerrnums, accuracy, aveusetime');
		if(!$pinfo) return false;
		
		if(!$pinfo['analysis']){
			$pinfo['analysis']	= $pinfo['dataview'];
		}
		
		$analysis	= json_decode($pinfo['analysis'], true);
		
		
		//查询答卷
		$upaper		= D('UserPaper')->table($userid);
		$upinfo		= $upaper->info($upaperid, $userid, 'id,userid,score,dataview,usetime');
		if(!$upinfo){ return false; }
		
		$dataview	= json_decode($upinfo['dataview'], true);
		
		//横向累计
		$sisdata	= $analysis['navs'];
		foreach($sisdata as $key=>$val){
			
			//查找答卷.模块
			$row	= $this->getNav($dataview['navs'], $val['title']);	
			$val['usetime']		= round(($val['usetime'] * ($pinfo['submits'] - 1) + $row['usetime']) / $pinfo['submits'], 0);
			$val['accuracy']	= round(($val['accuracy'] * ($pinfo['submits'] - 1) + $row['accuracy']) / $pinfo['submits'], 2);
			$val['errnums']		= round(($val['errnums'] * ($pinfo['submits'] - 1) + $row['errnums']) / $pinfo['submits'], 0);
			$val['errscore']	= round(($val['errscore'] * ($pinfo['submits'] - 1) + $row['errscore']) / $pinfo['submits'], 2);
			$val['score']		= round(($val['score'] * ($pinfo['submits'] - 1) + $row['score']) / $pinfo['submits'], 2);
			$val['nullscore']	= round(($val['nullscore'] * ($pinfo['submits'] - 1) + $row['nullscore']) / $pinfo['submits'], 2);
			
			$sisdata[$key]		= $val;
		}
		$analysis['navs']		= $sisdata;
		
		
		//最终更新数据
		$updata					= array();
		$updata['aveerrnums']	= round(($pinfo['aveerrnums'] * ($pinfo['submits'] - 1) + $dataview['info']['errnums']) / $pinfo['submits'], 0);
		$updata['accuracy']		= round(($pinfo['accuracy'] * ($pinfo['submits'] - 1) + $dataview['info']['accuracy']) / $pinfo['submits'], 2);
		$updata['aveusetime']	= round(($pinfo['aveusetime'] * ($pinfo['submits'] - 1) + $upinfo['usetime']) / $pinfo['submits'], 0);
		
		$analysis['info']['aveerrnums']		= $updata['aveerrnums'];
		$analysis['info']['aveaccuracy']	= $updata['accuracy'];
		$analysis['info']['aveusetime']		= $updata['aveusetime'];
		
		$updata['analysis']		= json_encode($analysis);
		$results				= $paper->where('id=' . $pinfo['id'])->save($updata);
		
		
		//返回结果
		return $results;
		
		//横向[母卷级]
		/**
		 * 正确率：整卷, 五大模块
		 * 平均值：整卷正确率， 五大模块正确率， 五大模块失分
		        ：知识点正确率, 知识点失分率
		          整卷用时，各模块平均用时
		 */
	}
	
	
	
	/**
	 * 试卷智能分析[微观[试题级]]
	 * 
	 * @param   bool
	 */
	public function analysisSourceQuestion($params)
	{

		//附加参数
		$userid			= intval($params['userid']);
		$upaperid		= intval($params['upaperid']);
		$paperid		= intval($params['paperid']);
		$speed			= intval($params['speed']);
		
		if($userid == 0 || $upaperid == 0) return false;
		
		
		//程序执行模式[及时模式[0]/异步队列[1]]
		$alstype		= 0;
		if($alstype == 0){
			$jsondata	= $params;
			$result		= queue_execute('userpaper_sourcequestion_analysis', json_encode($jsondata));
			return $result;
		}
		//异步 *******************************************************************************
		
		
		//查询答卷
		$upaper		= D('UserPaper')->table($userid);
		$upinfo		= $upaper->info($upaperid, $userid, 'id,userid,score,dataview,usetime');
		if(!$upinfo){ return false; }
		
		
		$objq		= D('Teaching/Question');
		$dataview	= json_decode($upinfo['dataview'], true);
		$list		= $dataview['item'];
		
		$cls_arr	= array();
		foreach($list as $key=>$val){
			foreach($val as $k=>$v){
				
				//客观题
				if(intval($v['son']) == 0){
					
					/**
					 * 判断 "阅卷标记"
					 *
					 * check ==  0   未答
					 * check ==  1   正确
					 * check == -1   错误
					 * 
					 */
					 
					$qrow	= $objq->selectQuestion($v['qid']);
					$qdata	= array();
					if(intval($v['check']) !== 1){
						
						//作答次数
						$qdata['views']		= intval($qrow['views']) + 1;
						
						//易错答案
						if(intval($v['check']) == -1){ $qdata['wrongans']	= strtoupper(trim($v['uanswer'])); }
						
						//正确率
						$qdata['rorate']	= round(intval($qrow['errnums'])  / $qdata['views'] * 100, 2);
						
						//平均用时
						$qdata['usetime']	= round(((intval($qrow['usetime']) * $qrow['views']) + intval($v['usetime'])) / $qdata['views'], 0);
					}
					
					//更新客观题
					$results				= $objq->where('sourceid=' . $v['qid'])->save($qdata);
					
					
				
				//资料题	
				}else{
					$sonlist	= $v['sonlist'];
					$slist		= $objq->where('materialid='.$v['qid'])->field('sourceid, views, usetime, errnums')->select();
					
					foreach($slist as $skey=>$sval){
						
						$v		= $sonlist[$skey];
						$qrow	= $slist[$skey];
						
						$qdata	= array();
						if(intval($v['check']) !== 1){
							
							//作答次数
							$qdata['views']		= intval($qrow['views']) + 1;
							
							//易错答案
							if(intval($v['check']) == -1){ $qdata['wrongans']	= strtoupper(trim($v['uanswer'])); }
							
							//正确率
							$qdata['rorate']	= round(intval($qrow['errnums'])  / $qdata['views'] * 100, 2);
							
							//平均用时
							$qdata['usetime']	= round(((intval($qrow['usetime']) * $qrow['views']) + intval($v['usetime'])) / $qdata['views'], 0);
						}
						
						//更新客观题
						$results				= $objq->where('sourceid=' . $qrow['sourceid'])->save($qdata);
						
					}
				}
			}	
		}
		
		//微观[试题级]
		/**
		 * 作答次数, 错误次数, 平均时间
		 
		 */ 
	}
	
	
	/**
	 * 试卷智能分析[深度]
	 * 
	 
	 * @param   array $params    附加参数
	 *          int   $userid    用户
	 *          int   $upaperid  答卷
	 *          int   $paperid   母卷
	 *          int   $speed     做题数
	 * @param   bool
	 */
	public function analysisFactory($params)
	{
		//全局[用户级]
		$this->analysisUser($params);
		
		//局部[试卷级]
		$this->analysisPaper($params);
		
		//横向[母卷级]
		$this->analysisSourcePaper($params);
		
		//微观[试题级]
		$this->analysisSourceQuestion($params);
	}
}