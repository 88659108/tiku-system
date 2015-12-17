<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($info["title"]); ?></title>
</head>

<body>
<h1 style="color:#F00;">试卷：<?php echo ($info["title"]); ?></h1>
<table width="80%" border="1" cellspacing="0" cellpadding="0">

  <?php if(is_array($list['navs'])): $k = 0; $__LIST__ = $list['navs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pp): $mod = ($k % 2 );++$k;?><tr>
    <td width="11%"><?php echo ($pp["title"]); ?>(<?php echo ($pp["nums"]); ?>)</td>
    <td width="89%">
      
      <?php if(is_array($list['item'][$pp['key']])): $i = 0; $__LIST__ = $list['item'][$pp['key']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$q): $mod = ($i % 2 );++$i; if($q["son"] > 0 ): ?><h3 style="color:#F00;">资料(<?php echo ($q["qid"]); ?>)</h3><br />
      <?php if(is_array($q['info'])): $kk = 0; $__LIST__ = $q['info'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qq): $mod = ($kk % 2 );++$kk;?><table width="90%" border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td width="4%" style="font-weight:bold; color:#F00;">(<?php echo ($kk); ?>)</td>
          <td width="96%"><?php echo ($qq["body"]); ?></td>
        </tr>
        <tr>
          <td><?php echo ($qq["sourceid"]); ?></td>
          <td><?php echo ($qq["options"]); ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php echo ($qq["description"]); ?></td>
        </tr>
      </table><br /><?php endforeach; endif; else: echo "" ;endif; ?>
      
      
      
      
      <?php else: ?>
      <table width="90%" border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td width="4%" style="font-weight:bold; color:#F00;">(<?php echo ($i); ?>)</td>
          <td width="96%"><?php echo ($q["info"]["body"]); ?></td>
        </tr>
        <tr>
          <td><?php echo ($q["info"]["sourceid"]); ?></td>
          <td><?php echo ($q["info"]["options"]); ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php echo ($q["info"]["description"]); ?></td>
        </tr>
      </table><?php endif; ?>
      
      <br /><?php endforeach; endif; else: echo "" ;endif; ?>
      
     </td>
  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  
  
</table>
</body>
</html>