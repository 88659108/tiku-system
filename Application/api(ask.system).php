<?php
/*
+--------------------------------------------------------------------------
|   YangMeng 
|   ========================================
|   by WeCenter Software
|   © 2011 - 2014 WeCenter. All Rights Reserved
|   ppvke.com
|   ========================================
|   Support: 75674952@qq.com
|   本代码主要功能是站内外互通,调用.
|
+---------------------------------------------------------------------------
*/

include('system.php');
AWS_APP::init();
class main extends AWS_CONTROLLER
{
	public function index()
	{
		print_r($this->model('topic')->get_child_topic_ids($_GET['topic_id']));
	}
}

$m = new main();


$m->index();
exit;
?>