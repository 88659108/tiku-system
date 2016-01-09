# tiku-system
在线题库 -- 申请试卷，作答，阅卷，智能统计，技能强弱分析..

# <a href="http://www.zoobao.com/index.php/paper/index/paperlist" target="_blank">在线示例</a>

# 核心代码
重构后js：<a href="https://github.com/88659108/tiku-system/tree/master/Public/js/paper1" target="_blank">tiku-system/Public/js/paper1/</a><br />
试卷部分：<a href="https://github.com/88659108/tiku-system/tree/master/Application/Paper" target="_blank">tiku-system/Application/Paper/</a>

# 试题采集
半自动，通过浏览器，利用JS采集<br />
代码： tiku-system/bin/


<script type="text/javascript">

;(function($, window, undefined){
	
	var _lib		= window.Zbo;
	
	//答卷主键
	var paperid		= $('#js-paper-speed').attr('paperid');
	
	//配置信息: {试卷主键, 做题模式(0=做题模式, 1=解析模式)}
	var config		= {paperid:paperid, pagetype:0};
	
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
