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
    <h1><?php echo ($upinfo["title"]); ?></h1>
    <p class="title">交卷时间：<span><?php echo (date("Y-m-d H:i",$upinfo["subtime"])); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;申请时间：<span><?php echo (date("Y-m-d H:i",$upinfo["addtime"])); ?></span></p>
  </div>
  <div class="left answer-left">
    <div class="">
      <div class="subtopics-block white-block">
        <div class="topic-title b-user-block">
          <dl class="b-user left">
            <dt class=""><img src="/Public/images/<?php echo ($userinfo["image"]); ?>" /></dt>
            <dd>
              <h2><?php echo ($userinfo["username"]); ?></h2>
            </dd>
            <dd><span class="name">本卷得分</span><span class="schedule"><a class="red sc-color" style="width:<?php echo ($upinfo["score"]); ?>%;"></a></span><strong><?php echo ($upinfo["score"]); ?>分</strong></dd>
            <dd><span class="name">全网平均</span><span class="schedule"><a class="green sc-color" style="width:<?php echo ($pinfo["avescore"]); ?>%;"></a></span><strong><?php echo ($pinfo["avescore"]); ?>分</strong></dd>
            <dd><span class="name">最高得分</span><span class="schedule"><a class="blue sc-color" style="width:<?php echo ($pinfo["topscore"]); ?>%;"></a></span><strong><?php echo ($pinfo["topscore"]); ?>分</strong></dd>
          </dl>
          <div class="b-score right"><span class="b-score"><?php echo ($upinfo["score"]); ?><span class="text">分</span></span>
            <p class="text">已击败同类考生<strong><?php echo ($upinfo["ranking"]); ?></strong>%</p>
          </div>
          <div class="b-share"><!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"> <span class="bds_more">分享到：</span> <a class="bds_qzone"></a> <a class="bds_tsina"></a> <a class="bds_tqq"></a> <a class="bds_renren"></a> <a class="bds_t163"></a> <a class="shareCount"></a> </div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&uid=636341" ></script> 
            <script type="text/javascript" id="bdshell_js"></script> 
            <script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script> 
            <!-- Baidu Button END --></div>
        </div>
        
        
        <div class="b-chart-block b-border-block">
          <div class="b-chart-title">
            <h3 class="b-title left">失分/得分情况</h3>
            <div class="b-sm-chart right"><!--span class="text">失分：<a class="img-c" style="background:#da5d65;"></a></span><span class="text">用时：<a class="img-c" style="background:#3ea1bd;"></a></span--></div>
          </div>
          <div class="b-chart-conter" id="js-socre-module"></div>
        </div>
        
        <div class="b-chart-block b-border-block">
          <div class="b-chart-title">
          <h3 class="b-title left">正确率/用时分布</h3>
            <div class="b-sm-chart right"><!--span class="text">失分：<a class="img-c" style="background:#da5d65;"></a></span><span class="text">用时：<a class="img-c" style="background:#3ea1bd;"></a></span--></div>
          </div>
          <div class="b-chart-conter" id="js-time-module"></div>
        </div>
        
        <div class="b-chart-block b-border-block">
          <div class="b-chart-title">
          <h3 class="b-title left">学习进步(成绩走势对比图)</h3>
            <div class="b-sm-chart right"><!--span class="text">失分：<a class="img-c" style="background:#da5d65;"></a></span><span class="text">用时：<a class="img-c" style="background:#3ea1bd;"></a></span--></div>
          </div>
          <div class="b-chart-conter" id="js-score-list-module"></div>
        </div>
        
        
        
        
        <div class="b-chart-block b-border-block">
          <div class="b-chart-title">
            <h3 class="b-title left">知识点(详细分析)</h3>
          </div>
          <div class="b-table">
            <table width="100%" border="0" class="table-line">
              <thead>
                <tr>
                  <td style="width:230px">考点</td>
                  <td style="width:60px">答对</td>
                  <td style="width:60px">总题数</td>
                  <td style="width:220px">正确率</td>
                  <td style="width:120px">练习时长</td>
                </tr>
              </thead>
              <tbody>
              
              <?php if(is_array($clslist)): $i = 0; $__LIST__ = $clslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cls): $mod = ($i % 2 );++$i;?><tr>
                  <td class="text-left"><span class="title js-btn-show-list" data-list="<?php echo ($cls["id"]); ?>"><span class="img js-btn-ico open-icon"></span><?php echo ($cls["title"]); ?></span></td>
                  <td><?php echo ($cls["isok"]); ?></td>
                  <td><?php echo ($cls["qnums"]); ?></td>
                  <td class="sch-left"><span class="schedule"><a class="<?php if($cls["accuracy"] <= 25): ?>red<?php endif; if(($cls["accuracy"] > 25) AND ($cls["accuracy"] < 55)): ?>orange<?php endif; if($cls["accuracy"] >= 55): ?>green<?php endif; ?> sc-color" style="width:<?php echo ($cls["accuracy"]); ?>%;"></a></span><strong><?php echo ($cls["accuracy"]); ?>%</strong></td>
                  <td class="js-time-flt" usetime="<?php echo ($cls["usetime"]); ?>">00分00秒</td>
                </tr>
                <?php if(is_array($cls['list'])): $i = 0; $__LIST__ = $cls['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clss): $mod = ($i % 2 );++$i;?><tr class="son-list-<?php echo ($cls["id"]); ?>" style="display:none;">
                  <td class="text-left">&nbsp;&nbsp;&nbsp;&nbsp;<span class="title js-btn-show-list" data-list="<?php echo ($clss["id"]); ?>"><span class="img  js-btn-ico open-icon" close></span><?php echo ($clss["title"]); ?></span></td>
                  <td><?php echo ($clss["isok"]); ?></td>
                  <td><?php echo ($clss["qnums"]); ?></td>
                  <td class="sch-left"><span class="schedule"><a class="<?php if($clss["accuracy"] <= 25): ?>red<?php endif; if(($clss["accuracy"] > 25) AND ($clss["accuracy"] < 55)): ?>orange<?php endif; if($clss["accuracy"] >= 55): ?>green<?php endif; ?> sc-color" style="width:<?php echo ($clss["accuracy"]); ?>%;"></a></span><strong><?php echo ($clss["accuracy"]); ?>%</strong></td>
                  <td class="js-time-flt" usetime="<?php echo ($clss["usetime"]); ?>">00分00秒</td>
                </tr>
                <?php if(is_array($clss['list'])): $i = 0; $__LIST__ = $clss['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$clsss): $mod = ($i % 2 );++$i;?><tr class="son-list-<?php echo ($clss["id"]); ?> son-son-<?php echo ($cls["id"]); ?>" style="display:none;">
                  <td class="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($clsss["title"]); ?></td>
                  <td><?php echo ($clsss["isok"]); ?></td>
                  <td><?php echo ($clsss["qnums"]); ?></td>
                  <td class="sch-left"><span class="schedule"><a class="<?php if($clsss["accuracy"] <= 25): ?>red<?php endif; if(($clsss["accuracy"] > 25) AND ($clsss["accuracy"] < 55)): ?>orange<?php endif; if($clsss["accuracy"] >= 55): ?>green<?php endif; ?> sc-color" style="width:<?php echo ($clsss["accuracy"]); ?>%;"></a></span><strong><?php echo ($clsss["accuracy"]); ?>%</strong></td>
                  <td class="js-time-flt" usetime="<?php echo ($clsss["usetime"]); ?>">00分00秒</td>
                </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?> 
                
              </tbody>
            </table>
          </div>
        </div>
        
        
        
        <div class="b-dtk-block b-border-block">
          <div class="b-chart-title">
            <h3 class="b-title left">答题卡</h3>
            
          </div>
          
          <?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><div class="dtk-conter b-dtk">
            <h4><?php echo ($nav["title"]); ?>：<span class="text"><strong>作答<?php echo ((isset($nav["speed"]) && ($nav["speed"] !== ""))?($nav["speed"]):"0"); ?>道</strong> / 共<?php echo ($nav["nums"]); ?>道</span></h4>
            
            <?php if(is_array($nav['item'])): $q = 0; $__LIST__ = $nav['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qt): $mod = ($q % 2 );++$q; if($qt["son"] == 0): ?><a class="img link <?php if($q%10 == 0): ?>margin-r<?php endif; ?> <?php if($qt["check"] == 0): ?>current<?php endif; ?> <?php if($qt["check"] == 1): ?>green<?php endif; ?> <?php if($qt["check"] == -1): ?>red<?php endif; ?>" href="#!"><?php echo ($q); ?></a>
            <?php else: ?>
            <?php if(is_array($qt['sonlist'])): $s = 0; $__LIST__ = $qt['sonlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($s % 2 );++$s;?><a class="img link <?php if($s%$qt["son"] == 0): ?>margin-r<?php endif; ?> <?php if($son["check"] == 0): ?>current<?php endif; ?> <?php if($son["check"] == 1): ?>green<?php endif; ?> <?php if($son["check"] == -1): ?>red<?php endif; ?>" href="#!"><?php echo ($s); ?></a><?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
            
            </div><?php endforeach; endif; else: echo "" ;endif; ?> 
           
            
        </div>
      </div>
    </div>
  </div>
  <div class="right fun-right white-block report-right">
    <div class="report-block"><span class="img report-img"></span>
    </div>
    <a class="default-btn anser-btn green-btn" href="#!">查看报告</a><a class="default-btn anser-btn" href="/index.php/Paper/Answer/Index?paperid=<?php echo ($upinfo["id"]); ?>&getinfo=5">查看解析</a><a class="default-btn anser-btn" href="#!">疑问讨论</a></div>
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
<script type="text/javascript" src="/Public/js/lib/highcharts.4.0.4.js"></script>



<!-- system lib -->
<script type="text/javascript" src="/Public/js/common/zoobao.1.0.js"></script>
<script type="text/javascript" src="/Public/js/common/zoobao.utils.1.0.js"></script>


<script type="text/javascript">


$(function () {
	
	
	//
	$('.js-btn-show-list').click(function(){
	
		var _itemid	= $(this).attr('data-list');
		var _class	= $('.son-list-' + _itemid);
		var _clsss1	= $('.son-son-' + _itemid);
		
		var _btnico = $(this).find('.js-btn-ico');
		if(_btnico.hasClass('close-icon')){
			_btnico.removeClass('close-icon').addClass('open-icon');
			_class.hide();
			_class.find('.js-btn-ico').removeClass('close-icon').addClass('open-icon');
			_clsss1.hide();
			
		}else{
			_btnico.removeClass('open-icon').addClass('close-icon');
			_class.show();
			
		}
	});
	
	//格式化时间
	$('.js-time-flt').each(function(index, element) {
        var _usetime	= $(this).attr('usetime');
		
		$(this).html(Zbo.utils.tools.timeFormat(Number(_usetime), 'mm分ss秒'));
    });
	
	
    $('#js-socre-module').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: false//'失分情况'
        },
        xAxis: {
            categories: [<?php echo ($chart["navs"]); ?>]
        },
        yAxis: {
            min: 0,
            title: {
                text: false//'失分情况'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: 0,
            verticalAlign: 'top',
            y: -10,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black, 0 0 3px black'
                    }
                }
            }
        },
        series: [{
            name: '答案错误失分',
            data: [<?php echo ($chart["err"]); ?>]
			//,color: '#F00'
        },{
            name: '未作答失分',
            data: [<?php echo ($chart["null"]); ?>]
			//,color: '#CCC'
        },{
            name: '得分',
            data: [<?php echo ($chart["score"]); ?>]
			//,color: '#537512'
        }]
    });
});



$(function () {
    $('#js-time-module').highcharts({
        chart: {
            zoomType: 'column'
        },
        title: {
            text: false
        },
        subtitle: {
            text: false
        },
        xAxis: [{
            categories: [<?php echo ($chart["navs"]); ?>]
        }],
        yAxis: [{
			min: 0, 
            labels: {
                format: '',
                style: {
                    color: '#Ff0'//Highcharts.getOptions().colors[5]
                },
				enabled:false
				
            },
            title: {
                text: false,
                style: {
                    color: '#Ff0'//color: Highcharts.getOptions().colors[5]
                }
				
            }
        }, {
			min: 0,
			max: 100, 
			//gridLineWidth: 0,
            title: {
                text: '',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
			
            opposite: false
			
        }],
        tooltip: {
            shared: true,
		
			//格式化
			formatter  : function(){
				
				var content = '<span style="font-size: 12px;">' + this.x + '</span><br/>';
				
				for (var i = 0; i < this.points.length; i++) {
					if(this.points[i].series.name == '作答用时'){
						this.points[i].y = Zbo.utils.tools.timeFormat(Number(this.points[i].y), 'mm分ss秒');
					}else{
						this.points[i].y = this.points[i].y + ' %';
					}
					content += '<span style="color: ' + this.points[i].series.color + '">● </span><span style="color:#333;">' + this.points[i].series.name + '</span>: <span style="color:#000;font-weight:bold;">' + this.points[i].y + '</span><br />';
				};
				
				return content;
			}
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            x: -40,
            verticalAlign: 'top',
            y: -15,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: '正确率',
            type: 'column',
            yAxis: 1,
            data: [<?php echo ($chart["accy"]); ?>],
            tooltip: {
                valueSuffix: ' '
            }

        }, {
            name: '作答用时',
            type: 'spline',
            //data: [4000,1256,2356,1256,1965],
			data:[<?php echo ($chart["time"]); ?>],
            tooltip: {
                valueSuffix: ' '
			},
			color: '#F00'
        }]
		 
    });
});


$(function () {
    $('#js-score-list-module').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: false//'Monthly Average Temperature'
        },
        subtitle: {
            text: false//'Source: WorldClimate.com'
        },
        xAxis: {
			min: 1,
			max: 10
            //categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: false//'Temperature (°C)'
            },
			min: 0,
			max: 100
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
		
		tooltip: {
            shared: true,
		
			//格式化
			formatter  : function(){
				
				var content = '<span style="font-size: 12px; text-align:center;">最近学习(第<span style="color:#000;font-weight:bold;"> ' + this.x + ' </span>张卷)</span><br/><br/>';
				
				for (var i = 0; i < this.points.length; i++) {
					content += '<span style="color: ' + this.points[i].series.color + '">● </span><span style="color:#333;">' + this.points[i].series.name + '</span>: <span style="color:#000;font-weight:bold;">' + this.points[i].y + ' 分</span><br />';
				};
				
				return content;
			}
        },
        series: [{
            name: '我的成绩',
            data: [0, 53, 64, 75, 64, 76, 64, 78, 76, 82, 88]
        }, {
            name: '平均成绩',
            data: [0, 48, 62, 72, 68, 64, 72, 74, 72, 78, 82]
        }, {
            name: '其他用户',
            data: [0, 72, 74, 72, 68, 72, 78, 82, 72, 78, 82]
        }]
		
		/*series: [{
            name: '我的成绩',
            data: [<?php echo ($chart["scorelist"]); ?>]
        }, {
            name: '平均趋势',
            data: [<?php echo ($chart["avescore"]); ?>]
        }, {
            name: '其他用户(本卷)',
            data: [<?php echo ($chart["userscore"]); ?>]
        }]*/
    });
});


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