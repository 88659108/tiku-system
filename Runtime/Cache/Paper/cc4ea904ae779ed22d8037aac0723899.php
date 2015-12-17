<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo (C("PAGE_CHARSET")); ?>">
<title><?php echo ($upinfo["title"]); ?> - <?php echo (C("PAGE_TITLE")); ?></title>
<meta name="keywords" content="<?php echo (C("PAGE_KEYWORDS")); ?>" />
<meta name="description" content="<?php echo (C("PAGE_DESCRIPTION")); ?>" />

<meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome = 1">

<link rel="stylesheet" type="text/css" href="/Public/css/public.css" />
<link rel="stylesheet" type="text/css" href="/Public/css/ui-dialog.css" />
<link rel="stylesheet" type="text/css" href="/Public/css/answer.css" />

<style>
.js-question-module{ display:none; }
</style>

</head>
<body>

<div id="wrip">
  <div class="answer-top white-block">
    <h1 class="js-papertitle"><?php echo ($upinfo["title"]); ?></h1>
    <p class="title" style="display:none;">行政职业能力测验共有五个部分，135道题，总时限为120分钟。</p>
    <div class="type-list">
      <ul id="js-paper-navs" qcount="<?php echo ($upinfo["qnums"]); ?>">
      	<?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><li <?php if(($i) == "1"): ?>class="current"<?php endif; ?> key="<?php echo ($nav["key"]); ?>" usetime="<?php echo ($nav["usetime"]); ?>" navtitle="<?php echo ($nav["title"]); ?>"><?php echo ($nav["title"]); ?> (<span class="dig js-nav-speed"><?php echo ((isset($nav["speed"]) && ($nav["speed"] !== ""))?($nav["speed"]):"0"); ?></span>/<span class="dig js-nav-nums"><?php echo ($nav["nums"]); ?></span>)</li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  </div>
  
  <div class="left answer-left">
    
    <?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$md): $mod = ($i % 2 );++$i;?><div class="js-question-module" <?php if(($i) == "1"): ?>style="display:block;"<?php endif; ?>>
    
    <div class="answer-loading js-loading-nav-box"><div class="loading-bg"><a class="green js-loading-press" style="width:0%;"></a></div><p style="height:1200px;" class="text">正在努力加载中...</p></div>
    
    
    
    
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
    
  </div>
  
  <div class="dtk-block width-narrow">
        <div class="title"><span class="title-text js-dtk-switch">展开答题卡(剩下 <strong id="js-paper-speed" fid="<?php echo ($upinfo["paperid"]); ?>" paperid="<?php echo ($upinfo["id"]); ?>" qnums="<?php echo ($upinfo["qnums"]); ?>"><?php echo ($speed); ?></strong> 道题)&nbsp;<span class="js-dtk-ico">↑</span></span></div>
        <div class="dtk-conter js-paper-icos" style="display:none;"></div>
      </div>
  
  <div class="right fun-right white-block">
  <div class="analyze-block"><span class="img analyze-img"></span></div>
    <a class="default-btn anser-btn" href="/index.php/Paper/Answer/Index?paperid=<?php echo ($upinfo["id"]); ?>">查看报表</a><a class="default-btn anser-btn green-btn" href="#!">查看解析</a><a class="default-btn anser-btn" target="_blank" href="/ask">疑问讨论</a><a class="default-btn anser-btn js-btn-paper-showtype" href="#!">只看错题</a>
  </div>
</div>



<!-- global  lib -->
<script type="text/javascript" src="/Public/js//lib/jquery-1.10.2.js"></script>
<script type="text/javascript" src="/Public/js//lib/dialog-6.0.4.js"></script>
<script type="text/javascript" src="/Public/js/lib/store-1.3.17.js"></script>


<!-- system lib -->
<script type="text/javascript" src="/Public/js/common/zoobao.1.0.js"></script>
<script type="text/javascript" src="/Public/js/common/zoobao.utils.1.0.js"></script>






<!-- page lib -->
<script type="text/javascript" src="/Public/js/lib/json2.js"></script>
<script type="text/javascript" src="/Public/js/lib/arttemplate-3.0.js"></script>


<!-- model-->
<script type="text/javascript" src="/Public/js/paper1/paper.icos.1.0.js"></script>
<script type="text/javascript" src="/Public/js/paper1/paper.time.1.0.js"></script>
<script type="text/javascript" src="/Public/js/paper1/paper.navs.1.0.js"></script>
<script type="text/javascript" src="/Public/js/paper1/paper.question.1.0.js"></script>


<script type="text/javascript">

;(function($, window, undefined){
	
	var _lib		= window.Zbo;
	
	//答卷主键
	var paperid		= $('#js-paper-speed').attr('paperid');
	
	//配置信息: {试卷主键, 做题模式(0=做题模式, 1=解析模式)}
	var config		= {paperid:paperid, pagetype:1};
	
	//初始化: 答题卡
	_lib.icos.create(config);
	
	//初始化: 做题工具箱
	_lib.time.create(config).start();
	
	//初始化: 试卷菜单栏
	_lib.navs.create(config).start(0);
	
	//初始化: 试题管理器
	_lib.question.create(config);
	
	
})(window.jQuery, window);

</script>



<script type="text/javascript">
/*

//初始化
(function($){
	
	//答题卡
	var pinfo	= $('#js-paper-speed');
	var paperid	= pinfo.attr('paperid');
	app_paper_icos.create({paperid:paperid, pagetype:1, app_paper_navs:app_paper_navs});
	
	//计时,控制,交卷
	app_paper_time.create({paperid:paperid, app_paper_navs:app_paper_navs, app_paper_icos:app_paper_icos});
	
	//加载试题
	app_paper_navs.create({app_paper_time:app_paper_time, app_paper_question:app_paper_question, app_paper_icos:app_paper_icos, paperid:paperid, pagetype:1}).start(0);
	
	//试题管理器
	app_paper_question.create({paperid:paperid, pagetype:1, app_paper_icos:app_paper_icos, app_paper_navs:app_paper_navs});
	
})(window.jQuery);
*/

</script>


<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?497db2a22b54b711ea138cc0ed1d3c0a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>


<script id="tp-question-ico" type="text/html">
	
	{{if qinfo.status == 0}}
		<a class="img link {{if mod}}margin-r{{/if}}" href="#!" key="{{key}}" number="{{number}}">{{number}}</a>
	
	{{else}}
		{{if !pagetype}}
			<a class="img link green {{if mod}}margin-r{{/if}}" href="#!" key="{{key}}" number="{{number}}">{{number}}</a>
		{{else}}
			<a class="img link {{if mod}}margin-r{{/if}} {{if qinfo.status == 1}}green{{else}}red{{/if}}" href="#!" key="{{key}}" number="{{number}}">{{number}}</a>
		{{/if}}
	{{/if}}
	
</script>

<script id="tp-objective-question" type="text/html">
	<div class="subtopics-block white-block js-question" usetime="{{usetime}}" uanswer="{{uanswer}}" answer="{{answer}}" qid="{{info.qid}}"  {{if info.isajax}}ajax="1"{{/if}} {{if materialid}}sonindex="{{sonindex}}" materialid="{{materialid}}"{{/if}}>
        <div class="topic-title"><span class="dig left js-number">{{number}}</span>
          <div class="right topic-right">
            <div class="text">{{info.body}}</div>
          </div>
        </div>
        <div class="options-block">
          <ul class="js-options">
		  	{{each info.options as opt}}
			
			{{if answer == trim(opt.cs)}}
			<li cs="{{opt.cs | trim}}" class="{{if info.pagetype == 1}}green{{else}}{{if uanswer == trim(opt.cs)}}current{{/if}}{{/if}}">
			
			{{else}}
			{{if uanswer == trim(opt.cs)}}
			<li cs="{{opt.cs | trim}}" class="{{if info.pagetype == 1}}red{{else}}current{{/if}}">
			{{else}}
			<li cs="{{opt.cs | trim}}">
			{{/if}}
			{{/if}}
			
			<span class="img ico-option"></span><span class="options left">{{opt.cs | trim}}.</span><span class="text left">{{if opt.img == 1}}<img src="http://www.zoobao.com/Uploads/xingce/option2/{{opt.text}}" />{{else}}{{opt.text}}{{/if}}</span><span class="time right js-use-time">{{if uanswer == trim(opt.cs)}}{{info.usetime}}{{/if}}</span></li>
			{{/each}}
		  
          </ul>
		  
		  {{if materialid}}
		  <p class="view-data"><a class="link js-btn-show-material" href="#!" materialid="{{materialid}}">查看资料</a></p>
		  {{/if}}
		  
        </div>
		
		
		  
        <div class="analyze-fun"><a href="#!" class="link js-set-mark {{if info.ismark == 1}}current{{/if}}"><span class="img mark-icon"></span><span class="js-mark-text">{{if info.ismark == 1}}已标记{{else}}重点标记{{/if}}</span></a><a href="#!" class="link js-set-collects {{if info.iscoll == 1}}current{{/if}}"><span class="img collect-icon"></span><span class="js-coll-text">{{if info.iscoll == 1}}已收藏{{else}}收藏{{/if}}</span></a><a href="#!" class="link js-sub-bug {{if info.isbugs}}current{{/if}}" {{if info.isbugs}}bugmsg="{{info.isbugs.msg}}"{{/if}}><span class="img error-icon"></span><span class="js-bug-text">{{if info.isbugs}}已反馈{{else}}纠错{{/if}}</span></a></div>

		  {{if info.pagetype == 1 && uanswer}}
		  {{include 'tp-objective-question-notes'}}
		  
		  {{include 'tp-objective-question-description'}}
		  {{/if}}
		
		
		
      </div>
</script>



<script id="tp-objective-question-notes" type="text/html">
        <div class="analyze-column1 js-question-notes">
          <div class="left analyze-answer {{if answer == uanswer}}green{{else}}red{{/if}}"><span class="img answer-icon"></span>
            <table width="100%" border="0" class="table-line">
              <tbody>
                <tr>
                  <td>正确答案</td>
                  <td>你的答案</td>
                  <td rowspan="2"><span class="img expression-icon"></span></td>
                </tr>
                <tr>
                  <td class="green js-ans-ok"><strong>{{answer}}</strong></td>
                  <td class="color js-ans-me"><strong>{{uanswer}}</strong></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="right">
            <!--div class="label-list">
              <label class="current"><span class="img input-img"></span>做笔记，才能相互查看他人的..</label>
              <label><span class="img input-img"></span>不知道做</label>
              <label><span class="img input-img"></span>知识点不足</label>
            </div-->
            <div class="notes" style="display:none;"><span class="img notes-icon"></span>做个笔记,方便回顾,还能查看他人笔记</div>
            <div class="textarea-notes"><span class="img notes-icon"></span>
              <textarea class="js-q-notes" name="" cols="" rows="3" placeholder="做个笔记,方便回顾,还能查看他人笔记">{{if notes}}{{notes.msg}}{{/if}}</textarea>
            </div>
          </div>
        </div> 
</script>



<script id="tp-objective-question-description" type="text/html">
<div class="analyze-column2 js-question-description">
          <div class="analytical-switch open js-switch-off"><span class="img switch-icon"></span><span class="js-switch-txt">展开解析</span></div>
          <div class="analytical-block js-question-description-desc" style="display:none;">
            <div class="analy-left">
              <dl>
                <dt class="left">解析</dt>
                <dd class="left">{{info.description}}
                  <p class="text">故答案选{{info.answer}}</p>
                </dd>
              </dl>
              <dl>
                <dt class="left">考点</dt>
                <dd class="left"><a href="#!" class="btn-link">{{info.pointname}}</a></dd>
              </dl>
            </div>
            <div class="analy-right"><a href="#!" class="btn-link"><span class="img audio-icon"></span>听音频讲解</a><br />
              <a href="#!" class="btn-link"><span class="img video-icon"></span>听视频讲解</a></div>
          </div>
		  
		  
          <div class="analytical-tab js-question-description-tab" style="display:none;">
            <div class="title"><a href="#!" class="link current js-desc-btn">本题疑难讨论</a><a href="#!" class="link js-desc-btn">其他用户笔记</a></div>
            <div class="conter">
              
				<div class="tab-conter-1 js-desc-tab-box">
					<div class="notes" style="display:none;">做个笔记,方便回顾</div>
					<div class="textarea-notes grey-notes js-question-desc-form">
						<textarea class="js-question-form-content" placeholder="还有疑问吗？？ 发表出来，让大家一起交流，很快有结果哦..."></textarea>
						<a href="#!" class="btn-link js-question-desc-form-btn">提交问题</a>
					</div>
					
					<div class="answer-loading js-loading-submit-ask" style="display:none; margin:50px auto;">
						<div class="loading-bg">
							<a class="green js-loading-press" style="width:0%;"></a>
						</div>
						<p style="height:100px;" class="text">正在提交试题疑问, 请稍等...</p>
					</div>
				
					<div class="answer-loading js-loading" style="display:none;">
						<div class="loading-bg">
							<a class="green js-loading-press" style="width:0%;"></a>
						</div>
						<p style="height:100px;" class="text">正在努力加载中...</p>
					</div>
              	</div>
			  
			  
              	<div class="tab-conter-2 notes-block js-desc-tab-box" style="display:none;">
					<div class="answer-loading js-loading" style="display:none;">
						<div class="loading-bg">
							<a class="green js-loading-press" style="width:0%;"></a>
						</div>
						<p style="height:100px;" class="text">正在努力加载中...</p>
					</div>
              	</div>
			  
            </div>
          </div>
        </div>
</script>



<script id="tp-question-description-questionlist" type="text/html">


{{if asklist}}


{{each asklist as ask}}
 				<div>
                  <div class="doubt-list blod"><span class="number">{{ask.agree_count}}</span><span class="right-text"><a href="/ask/?/question/{{ask.question_id}}" target="_blank">{{ask.question_content}}</a></span></div>
				  
				  {{each ask.anslist as als}}
                  <div class="doubt-list"><span class="number">{{als.agree_count}}</span><span class="right-text"><span class="name">行测学友：</span> {{als.answer_content}}</span></div>
				  {{/each}}
				  
                </div>
{{/each}}    
				
{{else}}	
			
{{/if}}	


                <div class="doubt-btn"><a target="_blank" href="/ask/?/category-{{classid}}__sort_type-unresponsive" class="btn-link">我来回答</a><a target="_blank" href="/ask/?/explore/category-{{classid}}" class="btn-link">更多疑问</a></div>			
</script>


<script id="tp-question-description-notelist" type="text/html">

{{if list}}
		<ul>
			{{each list as nt}}
			<li class="{{if nt.err == 1}}red{{else}}green{{/if}}"><span class="img"></span><span class="name">**学友:</span><span class="text-right">{{nt.msg}}</span></li>
			{{/each}}
		</ul>
{{else}}
<ul>
<!--li>**** 没有相关试题笔记 ****</li-->

<li class="red"><span class="img"></span><span class="name">laonia:</span><span class="text-right">C（3，2）/C（5，2）=0.3这是什么意思，怎么算</span></li>
<li class="green"><span class="img"></span><span class="name">litmoy:</span><span class="text-right">为什么我设甲为X 乙就是0.7X 不能得出结果..</span></li>
<li class="red"><span class="img"></span><span class="name">xuj359:</span><span class="text-right">什么叫若第五个相连那么五个图形就整体对称啊..</span></li>
</ul>
{{/if}}			
</script>

<script id="tp-question-description-ask-userlist" type="text/html">

				<div class="seekhelp-block">
                  <p class="text">成功提交！他们都是<strong>【{{classname}}】</strong>学霸，他们很<strong>乐意被邀请交流。</strong></p>
                  <dl>
                    <dt><img src="/Public/images/user-img.gif" /></dt>
                    <dd><span class="name">laonia</span><a href="#!" class="btn-link">邀请</a></dd>
                  </dl>
                  <dl>
                    <dt><img src="/Public/images/user-img.gif" /></dt>
                    <dd><span class="name">litmoy</span><a href="#!" class="btn-link">邀请</a></dd>
                  </dl>
                  <dl>
                    <dt><img src="/Public/images/user-img.gif" /></dt>
                    <dd><span class="name">xuj359</span><a href="#!" class="btn-link">邀请</a></dd>
                  </dl>
                  <dl>
                    <dt><img src="/Public/images/user-img.gif" /></dt>
                    <dd><span class="name">pp1073</span><a href="#!" class="btn-link">邀请</a></dd>
                  </dl>
                </div>
				
				<div class="doubt-btn" style="padding-top:25px;padding-bottom:25px;"><a href="{{askurl}}" target="_blank" class="btn-link">查看详情</a><a href="/ask/?/explore/category-{{classid}}" target="_blank" class="btn-link">更多疑问</a></div>
				
</script>




<script id="tp-material-question" type="text/html">
<div class="subtopics-block white-block data">
        <div class="topic-title"><span class="dig left">资料题</span>
          <div class="right topic-right">
            <div class="text js-material-{{qid}}">{{material}}</div>
          </div>
        </div>
      </div>
</script>

<script id="tp-paper-submit-box" type="text/html">
<div class="public-box submit-box js-submit-box" style="display:none;">
  <p class="text">还剩{{speed}}道题未答完，确定要交卷吗？</p>
  <div class="submit-btn-box"><a href="#!" class="default-btn anser-btn js-submit-btn-end">强制交卷（很残忍）</a><br>
    <a href="#!" class="default-btn green-btn anser-btn js-submit-btn-close">谢谢提醒，接着做..</a></div>
</div>
</script>


<script id="tp-paper-submit-end-box" type="text/html">
<div class="public-box submit-box js-submit-end-box" style="display:none;">
  <p class="text">先休息一下..</p>
  <div class="submit-btn-box">
    <a href="#!" class="default-btn green-btn anser-btn js-submit-btn-close">继续，接着做..</a></div>
</div>
</script>


<script id="tp-paper-submit-loading-box" type="text/html">
<div class="public-box submit-box js-submit-loading" style="display:none;">
  <h1>{{papertitle}}</h1>
<div class="answer-loading js-loading"><div class="loading-bg"><a style="width:0%;" class="green js-loading-press"></a></div><p class="text js-press-msg">正在努力阅卷...</p></div>
<div class="submit-btn-box"><a href="#!" class="default-btn anser-btn js-submit-btn-end" style="display:none;">网络超时（重新交卷）</a><br>
{{if speed > 0}}<a href="#!" class="default-btn green-btn anser-btn js-submit-btn-close" style="display:none;">还剩 {{speed}} 道，继续做？</a>{{/if}}
    <a href="#!" class="default-btn green-btn anser-btn js-submit-btn-goto" style="display:none;">查看成绩（智能分析报表）</a></div>
</div>
</script>


<div class="div-bg js-body-bg" style="display:none;"></div>







<!-- 代码 开始 -->
<div id="moquu_wxin" class="moquu_wxin"><a href="javascript:void(0)">行测王题库<div class="moquu_wxinh"></div></a></div>
<div id="moquu_wshare" class="moquu_wshare"><a href="javascript:void(0)">行测王题库<div class="moquu_wshareh"><div class="js-mobile-qrcode-imgbox"><img class="js-img-loading"  src="/Public/images/loading.gif" /></div></div></a></div>
<div id="moquu_wmaps"><a href="javascript:void(0)" class='moquu_wmaps'>行测王题库</a></div>
<a id="moquu_top" href="javascript:void(0)"></a>
<!-- 代码 结束 -->

<link rel="stylesheet" type="text/css" href="/Public/css/app_weixin.css" />
<script type="text/javascript" src="/Public/js/popwin.js"></script>
<script>

$('#moquu_wshare').mouseenter(function(){
	
	var _box	= $(this);
	var _img	= _box.find('.js-mobile-qrcode-imgbox');
	
	var _loding = _img.find('.js-img-loading');
	if(_loding.size() == 0) return false;
	
	//加载图片
	var _url		= '/QRcode/Index';
	
	var _pars		= $('.js-dtk-switch');
	var _upaperid	= (_pars.size() > 0) ? _pars.find('#js-paper-speed').attr('paperid') : 0;
	var _papertitle	= $('title').text();
	var _pageurl	= window.location.href;
	Zbo.utils.ajax.post(_url, {upaperid:_upaperid, papertitle:_papertitle, pageurl:encodeURIComponent(_pageurl)}, function(json){
		
		var _imgsrc	= '<img class="js-qrcode-img" src="'+ json.imgurl +'" />';
		_img.html(_imgsrc);
		
		
	}, function(){
		
		
	});
	
	
});




</script>

</body>
</html>