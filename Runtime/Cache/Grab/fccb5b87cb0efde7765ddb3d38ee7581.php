<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>云南试卷列表</title>
</head>

<body>
<h1 style="color:#F00;">云南试卷列表</h1>

如果需要拆分打分，如：言语理解与表达(15道),其中10道0.2分, 5道0.3分, 那就输入: 10>0.2|5>0.3<br />
如果15道全部是0.5分, 那就输入15>0.5, 依次类推..<br />
工具会自动统计分数，检查所有打分异常情况，进行提示..<br />
点击“保存打分项” 成功保存会直接隐藏掉该试卷..
<br />

<table width="80%" border="1" cellspacing="0" cellpadding="0">

  <?php if(is_array($list)): $kk = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pp): $mod = ($kk % 2 );++$kk;?><tr class="js-tr">
    <td width="15%" align="center" valign="top">
    <h1 class="js-btn-qnums" style="color:#F00; cursor:pointer; padding:20px;"><?php echo ($pp["qnums"]); ?>道<br /><span>显示试卷</span></h1>
    </td>
    <td width="85%" class="js-box-plist">
    
    
    <?php if(is_array($pp['plist'])): $k = 0; $__LIST__ = $pp['plist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($k % 2 );++$k;?><table width="99%" border="1" class="js-paper-box" cellspacing="0" cellpadding="0" style="display:none;">
     	<tr>
    	<td width="5%">
    		<?php echo ($k); ?>
        </td>
    	<td width="80%">
         <?php echo ($p["title"]); ?> <a target="_blank" href="http://www.zoobao.com/index.php/Paper/Index/?paperid=<?php echo ($p["id"]); ?>">申请试卷></a>
    	</td>
    	<td width="15%"><button class="js-btn-submit" paperid="<?php echo ($p["id"]); ?>">保存打分项</button></td>
  		</tr>
     	<tr>
     	  <td>&nbsp;</td>
     	  <td colspan="3">
          <ul class="js-itm-list">
          <?php if(is_array($p['navs'])): $n = 0; $__LIST__ = $p['navs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($n % 2 );++$n;?><li class="js-itemlist"><span class="js-nav"><?php echo ($nav["title"]); ?></span><span class="js-num"><?php echo ($nav["nums"]); ?></span><span>* <input type="text" data-name="js-item-<?php echo ($pp["qnums"]); ?>-<?php echo ($nav["title"]); ?>" style="width:240px;" class="js-sub js-item-<?php echo ($pp["qnums"]); ?>-<?php echo ($nav["title"]); ?>" /> = </span><span class="js-nav-count">0</span></li><?php endforeach; endif; else: echo "" ;endif; ?>
          
          <li><span>总分：</span><span class="js-paper-count">0</span></li>
          </ul>
          </td>
   	  </tr>
    </table><?php endforeach; endif; else: echo "" ;endif; ?>
    
     </td>
  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  
  
</table>




<script type="text/javascript" src="/Public/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/Public/js/common.js"></script>


<script language="javascript">


$('.js-btn-qnums').click(function(){
	
	var tr	= $(this).parents('.js-tr');
	var box = tr.find('.js-box-plist');
	var lit = box.find('table');
	var txt = $(this).find('span');
	
	if(!tr.attr('show')){
		lit.show();
		tr.attr('show', 1);
		txt.html('隐藏试卷');
		
	}else{
		lit.hide();	
		tr.removeAttr('show');
		txt.html('显示试卷');
	}
});


$('.js-sub').change(_paper_nav_score).keyup(_paper_nav_score).blur(_paper_nav_score);
function _paper_nav_score(){
	
	var ul	= $(this).parents('.js-itm-list');
	var li	= $(this).parents('li');
	var cot = li.find('.js-nav-count');
	
	var val = $(this).val();
	if(val){
		var arr	= val.split('|');
		
		var _name	= $(this).attr('data-name');
		$('.'+_name).val(val);
		
		var score	= 0;
		for(var i in arr){
			
			if(arr[i]){
				var itm = arr[i].split('>');	
				var num = itm[0];
				var sco = itm[1];
				
				if(!isNaN(num) && !isNaN(sco)){
					var s	= Number(num) * Number(sco);
					score  += s;
					
					
					
				}
			}
		}
		
		cot.html(score);
	}
	
	_sum_paper_score(ul);
}


function _sum_paper_score(ul){
	
	var score	= 0;
	ul.find('.js-nav-count').each(function(index, element){
		score  += Number($(this).text());
    });
	
	ul.find('.js-paper-count').html(score);
}


$('.js-btn-submit').click(function(){
	
	var tab		= $(this).parents('.js-paper-box');
	var paperid = $(this).attr('paperid');
	var score	= tab.find('.js-paper-count').text();
	if(score != 200){
		alert('试卷总分不是200分，请检查...');	
		return;
	}
	
	//,"subitem":[{"nums":20,"score":0.6}]
	var ul		= tab.find('.js-itm-list');
	var navs	= [];
	var isok	= 1;
	ul.find('li.js-itemlist').each(function(index, element){
		
		var txt	= $(this).find('.js-nav').text();
		var cot	= $(this).find('.js-num').text();
		var val	= $(this).find('.js-sub').val();
		
		var itemlist		= [];
		var _cot			= 0
		if(val){
			var arr			= val.split('|');
			var score		= 0;
			for(var i in arr){
				
				if(arr[i]){
					var itm = arr[i].split('>');	
					var num = itm[0];
					var sco = itm[1];
					
					if(!isNaN(num) && !isNaN(sco)){
						itemlist.push('{"nums":'+num+',"score":'+sco+'}');
						_cot += Number(num);
					}
				}
			}
		}
		
		if(cot != _cot){
			alert('【' + txt + '】存在异常, 该模块有' + cot + '道, ' + '打分项有' + _cot + '道。');
			isok = 0;
			return;	
		}
		
		navs.push('{"title":"'+txt+'","nums":"'+cot+'","subitem":['+ itemlist.join(',')+']}');
    });
	
	if(!isok){ return; }
	var navdata	= '[' + navs.join(',') + ']';
	
	//alert(navdata);
	var data	= {'paperid' : paperid , 'navdata' : navdata};
	ajaxSend('/Grab/Index/papernavs', data, function(json){
		
		alert(json.info);
		if(json.status == 1){
			
			tab.hide();	
		}
		
	});
	
});
</script>
</body>
</html>