<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>模拟申请试卷页</title>

</head>

<body>




<script type="text/javascript" src="/Public/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/Public/js/common.js"></script>


<script>



function applyPaper(){
	<?php if($_GET['paperid']> 0): ?>var paperid	=<?php echo ($_GET['paperid']); ?>;
	<?php else: ?>
	var paperid	=259;<?php endif; ?>
	
	var gamepid	= 0;
	var gameuid	= 0;
	var gamemsg	= '哇哈哈..!22';
	
	var _cookie	= 'paper-apply-' + paperid;
	var _pid 	= $.cookie(_cookie);
	if(_pid){
		location.href = '/index.php/Paper/Answer/index?paperid='+_pid;
		return ;	
	}
	
	var data	= 'paperid=' + paperid + '&gameuid='+gameuid+'&gamepid='+gamepid+'&gamemsg='+gamemsg;
	ajaxSend('/Paper/Index/applyPaper', data, function(json){
		
		//alert(json.info);
		if(json.status > 0){
			var a	= '<a href="/index.php/Paper/Answer/index?paperid='+json.paperid+'" target="_blank">开始作答</a>';	
			
			$.cookie(_cookie, json.paperid);
			location.href = '/index.php/Paper/Answer/index?paperid='+json.paperid;
			$(document.body).append(a);
		}
		
	});	
	
	
}

</script>


<input type="button" onClick="applyPaper();" value="申请试卷" />

</body>
</html>